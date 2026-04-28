<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flight;
use App\Models\Hotel;

class AdminController extends Controller
{
    function addflight(){
        return view('admin.addflight');
    }

    function viewflight(){
        //return flight::all();
        $flights = flight::all();
        return view('admin.viewflight', compact('flights'));
    }

    function postAddflight(Request $rq)
    {
        // ✅ VALIDATION
        $rq->validate([
            'airline_name'   => 'required',
            'flight_no'      => 'required|unique:flights,flight_no',
            'from_city'      => 'required',
            'to_city'        => 'required',
            'departure_time' => 'required',
            'arrival_time'   => 'required',
            'price'          => 'required|numeric',
        ]);

        $flight = new Flight();

        // BASIC FIELDS
        $flight->airline_name   = $rq->airline_name;
        $flight->flight_name    = $rq->flight_name;
        $flight->flight_no      = $rq->flight_no;
        $flight->from_city      = $rq->from_city;
        $flight->to_city        = $rq->to_city;
        $flight->departure_time = $rq->departure_time;
        $flight->arrival_time   = $rq->arrival_time;
        $flight->price          = $rq->price;

        // ✅ STOPS (TEXT INPUT)
        $flight->stops = $rq->stops ?? 'Non-stop';

        // ✅ IMAGE UPLOAD
        if ($rq->hasFile('image')) {
            $img = $rq->file('image');
            $imagename = time() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('images'), $imagename);
            $flight->image = $imagename;
        }

        $flight->save();

        return redirect()->route('admin.viewflight')->with('msg', 'Flight Added Successfully');
    }
    /*FLIGHTS FUNCTIONS*/
    function editflight($id){
        $flight = flight::findOrFail($id);
        return view('admin.updateflight', compact('flight'));
    }
    /* FLIGHT UPDATE FUNCTION */
    function posteditflight(Request $rq, $id)
    {
        $flight = flight::findOrFail($id);

        // BASIC FIELDS
        $flight->airline_name = $rq->airline_name;
        $flight->flight_name  = $rq->flight_name;
        $flight->flight_no    = $rq->flight_no;
        $flight->from_city    = $rq->from_city;
        $flight->to_city      = $rq->to_city;
        $flight->departure_time = $rq->departure_time;
        $flight->arrival_time   = $rq->arrival_time;
        $flight->stops        = $rq->stops;
        $flight->price        = $rq->price;

        // IMAGE UPDATE
        if ($rq->hasFile('image')) {

            // DELETE OLD IMAGE
            if ($flight->image && file_exists(public_path('images/'.$flight->image))) {
                unlink(public_path('images/'.$flight->image));
            }

            // UPLOAD NEW IMAGE
            $img = $rq->file('image');
            $imagename = time().'.'.$img->getClientOriginalExtension();
            $img->move(public_path('images'), $imagename);

            $flight->image = $imagename;
        }

        $flight->save();

        return redirect()->route('admin.viewflight')->with('msg', 'Flight Updated Successfully');
    }

    function deleteflight($id){
        $flight = flight::findOrfail($id);
        $flight->delete();
        return redirect()->route('admin.viewflight')->with('msg' , 'Flight Deleted Successfully');
    }

    /*==================            HOTELS FUNCTIONS               ===========================*/ 

    function addhotel(){
        return view('admin.addhotel');
    }

    function viewhotel(){
        return view('admin.viewhotel');
    }

    function hotelstore(Request $rq){
        $rq->validate([
            'name' => 'required|string|max:255',
            'price_per_night' => 'required|numeric|min:0',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'status' => 'required|in:active,inactive',

            'state' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'star_rating' => 'nullable|integer|min:1|max:5',
            'total_rooms' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $hotel = new Hotel();
        $hotel->name = $rq->name;
        $hotel->description = $rq->description;
        $hotel->slug = \Str::slug($rq->name) . '-' . time();
        $hotel->city = $rq->city;
        $hotel->state = $rq->state;
        $hotel->country = $rq->country;
        $hotel->address = $rq->address;
        $hotel->latitude = $rq->latitude;
        $hotel->longitude = $rq->longitude;
        $hotel->phone = $rq->phone;
        $hotel->email = $rq->email;
        $hotel->website = $rq->website;
        $hotel->star_rating = $rq->star_rating;
        $hotel->price_per_night = $rq->price_per_night;
        $hotel->total_rooms = $rq->total_rooms;
        $hotel->status = $rq->status;
        $hotel->wifi = $rq->has('wifi');
        $hotel->parking = $rq->has('parking');
        $hotel->pool = $rq->has('pool');
        $hotel->gym = $rq->has('gym');
        $hotel->restaurant = $rq->has('restaurant');
        $hotel->ac = $rq->has('ac');
        if ($rq->hasFile('thumbnail')) {
            $img = $rq->file('thumbnail');
            $imagename = time() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('hotel_images'), $imagename);
            $hotel->thumbnail = $imagename;
        }
        $hotel->save();
        return redirect()->route('admin.viewhotel')->with('msg', 'Hotel Added Successfully');
    }
}
