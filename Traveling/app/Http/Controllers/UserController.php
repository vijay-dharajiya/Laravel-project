<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\flight;
use App\Models\Booking;

class UserController extends Controller
{
    function index(){
        if(Auth::check()&& Auth::user()->usertype=='user'){
            return view('dashboard');
        }
        
        else if(Auth::check()&& Auth::user()->usertype=='admin'){
            return view('admin.dashboard');
        }
    }

    function home(){
        $flights = flight::limit(6)->get();
        return view('index', compact('flights'));
    }

    function flightbook($id){
        $flight = flight::find($id);
        if(!$flight){
            return redirect()->route('index')->with('error', 'Flight not found.');
        }
        return view('flightbooking', compact('flight'));
    }

    function postflightbook(Request $request, $id)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required',
            'travel_date' => 'required|date|after_or_equal:today',
            'adults' => 'required|integer|min:0',
            'children' => 'required|integer|min:0',
        ]);

        $flight = Flight::findOrFail($id);

        $totalPassengers = $request->adults + $request->children;

        if ($totalPassengers == 0) {
            return back()->with('error', 'At least 1 passenger required');
        }

        // Calculate price
        $totalPrice = $flight->price * $totalPassengers;

        // Insert booking
        $booking = new Booking();
        $booking->user_id = Auth::id();
        $booking->flight_id = $flight->id;
        $booking->name = $request->name;
        $booking->email = $request->email;
        $booking->phone = $request->phone;
        $booking->travel_date = $request->travel_date;
        $booking->adults = $request->adults;
        $booking->children = $request->children;
        $booking->total_price = $totalPrice;
        $booking->save();

        return redirect()->back()->with('success', 'Booking Confirmed!');
    }
}
