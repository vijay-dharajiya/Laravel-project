<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Flight;
use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Hotelimage;
use App\Models\Room;
use App\Models\Roomimage;

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
        $flights = Flight::limit(6)->get();
        $hotels = Hotel::with('images')->where('status', 'active')->limit(6)->get();
        return view('index', compact('flights', 'hotels'));
    }

    function flightbook($id){
        $flight = Flight::find($id);
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

    public function hotelview($id)
    {
        // Get hotel with images
        $hotel = Hotel::with('images')->findOrFail($id);

        // 🔥 Get only THIS hotel's rooms with images
        $rooms = Room::with(['images' => function($q) {$q->orderBy('sort_order');}])->where('hotel_id', $id)->where('status', 1)->get();

        return view('hoteldetails', compact('hotel', 'rooms'));
    }
}
