<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flight;       // ✅ uppercase
use App\Models\Hotel;        // ✅ uppercase
use App\Models\HotelImage;   // ✅ fixed
use App\Models\Room;
use App\Models\RoomImage;    // ✅ fixed
use App\Models\RoomType;     // ✅ fixed

class AdminController extends Controller
{
    /*==================  FLIGHT FUNCTIONS  ==================*/

    public function addflight()
    {
        return view('admin.addflight');
    }

    public function viewflight()
    {
        $flights = Flight::all(); // ✅ uppercase
        return view('admin.viewflight', compact('flights'));
    }

    public function postAddflight(Request $rq)
    {
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
        $flight->airline_name   = $rq->airline_name;
        $flight->flight_name    = $rq->flight_name;
        $flight->flight_no      = $rq->flight_no;
        $flight->from_city      = $rq->from_city;
        $flight->to_city        = $rq->to_city;
        $flight->departure_time = $rq->departure_time;
        $flight->arrival_time   = $rq->arrival_time;
        $flight->price          = $rq->price;
        $flight->stops          = $rq->stops ?? 'Non-stop';

        if ($rq->hasFile('image')) {
            $img       = $rq->file('image');
            $imagename = time() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('images'), $imagename);
            $flight->image = $imagename;
        }

        $flight->save();
        return redirect()->route('admin.viewflight')->with('msg', 'Flight Added Successfully');
    }

    public function editflight($id)
    {
        $flight = Flight::findOrFail($id); // ✅ uppercase
        return view('admin.updateflight', compact('flight'));
    }

    public function posteditflight(Request $rq, $id)
    {
        $flight = Flight::findOrFail($id); // ✅ uppercase

        $flight->airline_name   = $rq->airline_name;
        $flight->flight_name    = $rq->flight_name;
        $flight->flight_no      = $rq->flight_no;
        $flight->from_city      = $rq->from_city;
        $flight->to_city        = $rq->to_city;
        $flight->departure_time = $rq->departure_time;
        $flight->arrival_time   = $rq->arrival_time;
        $flight->stops          = $rq->stops;
        $flight->price          = $rq->price;

        if ($rq->hasFile('image')) {
            if ($flight->image && file_exists(public_path('images/' . $flight->image))) {
                unlink(public_path('images/' . $flight->image));
            }
            $img       = $rq->file('image');
            $imagename = time() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('images'), $imagename);
            $flight->image = $imagename;
        }

        $flight->save();
        return redirect()->route('admin.viewflight')->with('msg', 'Flight Updated Successfully');
    }

    public function deleteflight($id)
    {
        $flight = Flight::findOrFail($id); // ✅ uppercase
        if ($flight->image && file_exists(public_path('images/' . $flight->image))) {
            unlink(public_path('images/' . $flight->image));
        }
        $flight->delete();
        return redirect()->route('admin.viewflight')->with('msg', 'Flight Deleted Successfully');
    }

    /*==================  HOTEL FUNCTIONS  ==================*/

    public function addhotel()
    {
        return view('admin.addhotel');
    }

    public function viewhotel()
    {
        $hotels = Hotel::all(); // ✅ uppercase
        return view('admin.viewhotel', compact('hotels'));
    }

    public function hotelimages()
    {
        $hotels = Hotel::all();

        $existingImages = collect(); // empty by default
        if (request('hotel_id')) {
            $existingImages = HotelImage::where('hotel_id', request('hotel_id'))->get();
        }

        return view('admin.addhotelimages', compact('hotels', 'existingImages'));
    }
    public function hotelroom()
    {
        $hotels     = Hotel::all();    // ✅ uppercase
        $room_types = RoomType::where('status', 1)->get(); // ✅ fixed
        return view('admin.addhotelroom', compact('hotels', 'room_types'));
    }

    public function roomimages()
    {
        $hotels = Hotel::all();
        
        // ✅ Empty by default — rooms load via AJAX after hotel selected
        $rooms = collect();
        $room_types = RoomType::where('status', 1)->get(); 
        return view('admin.addroomimage', compact('hotels', 'rooms',));
    }

    /*==================  HOTEL STORE  ==================*/

    public function hotelstore(Request $rq)
    {
        $rq->validate([
            'name'            => 'required|string|max:255',
            'price_per_night' => 'required|numeric|min:0',
            'city'            => 'required|string|max:100',
            'country'         => 'required|string|max:100',
            'status'          => 'required|in:active,inactive',
            'state'           => 'nullable|string|max:100',
            'address'         => 'nullable|string',
            'latitude'        => 'nullable|numeric',
            'longitude'       => 'nullable|numeric',
            'phone'           => 'nullable|string|max:20',
            'email'           => 'nullable|email',
            'website'         => 'nullable|url',
            'star_rating'     => 'nullable|integer|min:1|max:5',
            'total_rooms'     => 'nullable|integer|min:1',
            'description'     => 'nullable|string',
            'thumbnail'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $hotel                  = new Hotel();
        $hotel->name            = $rq->name;
        $hotel->description     = $rq->description;
        $hotel->slug            = \Str::slug($rq->name) . '-' . time();
        $hotel->city            = $rq->city;
        $hotel->state           = $rq->state;
        $hotel->country         = $rq->country;
        $hotel->address         = $rq->address;
        $hotel->latitude        = $rq->latitude;
        $hotel->longitude       = $rq->longitude;
        $hotel->phone           = $rq->phone;
        $hotel->email           = $rq->email;
        $hotel->website         = $rq->website;
        $hotel->star_rating     = $rq->star_rating;
        $hotel->price_per_night = $rq->price_per_night;
        $hotel->total_rooms     = $rq->total_rooms;
        $hotel->status          = $rq->status;
        $hotel->wifi            = $rq->has('wifi');
        $hotel->parking         = $rq->has('parking');
        $hotel->pool            = $rq->has('pool');
        $hotel->gym             = $rq->has('gym');
        $hotel->restaurant      = $rq->has('restaurant');
        $hotel->ac              = $rq->has('ac');

        if ($rq->hasFile('thumbnail')) {
            $img       = $rq->file('thumbnail');
            $imagename = time() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('hotel_images'), $imagename);
            $hotel->thumbnail = $imagename;
        }

        $hotel->save();
        return redirect()->route('admin.hotelimages', ['hotel_id' => $hotel->id])->with('success', 'Hotel Added! Now upload images.');    }

    /*==================  HOTEL EDIT/UPDATE/DELETE  ==================*/

    public function edithotel($id)
    {
        $hotel = Hotel::findOrFail($id); // ✅
        return view('admin.updatehotel', compact('hotel'));
    }

    public function postedithotel(Request $rq, $id)
    {
        $hotel                  = Hotel::findOrFail($id); // ✅
        $hotel->name            = $rq->name;
        $hotel->description     = $rq->description;
        $hotel->city            = $rq->city;
        $hotel->state           = $rq->state;
        $hotel->country         = $rq->country;
        $hotel->address         = $rq->address;
        $hotel->latitude        = $rq->latitude;
        $hotel->longitude       = $rq->longitude;
        $hotel->phone           = $rq->phone;
        $hotel->email           = $rq->email;
        $hotel->website         = $rq->website;
        $hotel->star_rating     = $rq->star_rating;
        $hotel->price_per_night = $rq->price_per_night;
        $hotel->total_rooms     = $rq->total_rooms;
        $hotel->status          = $rq->status;
        $hotel->wifi            = $rq->has('wifi');
        $hotel->parking         = $rq->has('parking');
        $hotel->pool            = $rq->has('pool');
        $hotel->gym             = $rq->has('gym');
        $hotel->restaurant      = $rq->has('restaurant');
        $hotel->ac              = $rq->has('ac');

        if ($rq->hasFile('thumbnail')) {
            if ($hotel->thumbnail && file_exists(public_path('hotel_images/' . $hotel->thumbnail))) {
                unlink(public_path('hotel_images/' . $hotel->thumbnail));
            }
            $img       = $rq->file('thumbnail');
            $imagename = time() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('hotel_images'), $imagename);
            $hotel->thumbnail = $imagename;
        }

        $hotel->save();
        return redirect()->route('admin.viewhotel')->with('msg', 'Hotel Updated Successfully');
    }

    // ✅ Fix — also delete gallery images from disk
    public function deletehotel($id)
    {
        $hotel = Hotel::findOrFail($id);

        // Delete thumbnail
        if ($hotel->thumbnail && file_exists(public_path('hotel_images/' . $hotel->thumbnail))) {
            unlink(public_path('hotel_images/' . $hotel->thumbnail));
        }

        // Delete all gallery images from disk
        foreach ($hotel->images as $image) {
            if (file_exists(public_path('hotel_images/' . $image->image))) {
                unlink(public_path('hotel_images/' . $image->image));
            }
        }

        $hotel->delete(); // DB records auto-deleted if cascade set
    }

    /*==================  HOTEL IMAGES STORE  ==================*/

    public function hotelimagestore(Request $rq)
    {
        $rq->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'images'   => 'required',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp',
        ]);

        foreach ($rq->file('images') as $img) {
            $filename = time() . '_' . uniqid() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('hotel_images'), $filename);

            $hotelImage           = new HotelImage(); // ✅ fixed class name
            $hotelImage->hotel_id = $rq->hotel_id;
            $hotelImage->image    = $filename;
            $hotelImage->save();
        }

        return back()->with('success', 'Hotel Images uploaded successfully!');
    }
    /*===================  HOTEL IMAGE DELETE  ==================*/
    // AdminController.php
    public function deleteHotelImage($id)
    {
        $image    = HotelImage::findOrFail($id);
        $hotel_id = $image->hotel_id;

        // ✅ Delete file from disk
        if (file_exists(public_path('hotel_images/' . $image->image))) {
            unlink(public_path('hotel_images/' . $image->image));
        }

        $image->delete();

        return redirect()->route('admin.hotelimages', ['hotel_id' => $hotel_id])
                        ->with('success', 'Image deleted successfully!');
    }
    /*==================  HOTEL ROOM STORE  ==================*/

    public function hotelroomstore(Request $rq)
    {
        $rq->validate([
            'hotel_id'    => 'required|exists:hotels,id',
            'room_type'   => 'required|string',
            'capacity'    => 'required|integer|min:1',
            'price'       => 'required|numeric|min:0',
            'total_rooms' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'status'      => 'required|in:0,1', // ✅ fixed validation
        ]);

        $room              = new Room();
        $room->hotel_id    = $rq->hotel_id;
        $room->room_type   = $rq->room_type;
        $room->capacity    = $rq->capacity;
        $room->price       = $rq->price;
        $room->total_rooms = $rq->total_rooms;
        $room->description = $rq->description;
        $room->status      = $rq->status;
        $room->save();

        return redirect()->route('admin.roomimages', ['hotel_id' => $room->hotel_id, 'room_id' => $room->id])
                        ->with('success', 'Room added successfully!');
    }

    /*==================  ROOM IMAGES STORE  ==================*/

    public function roomimagestore(Request $rq)
    {
        $rq->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'room_id'  => 'required|exists:rooms,id', 
            'images'   => 'required',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        foreach ($rq->file('images') as $index => $img) {
            $filename = time() . '_' . uniqid() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('room_images'), $filename);

            $roomImage             = new RoomImage();
            $roomImage->hotel_id   = $rq->hotel_id;
            $roomImage->room_id    = $rq->room_id;  // ✅ now correctly points to rooms.id
            $roomImage->image      = $filename;
            $roomImage->is_primary = $index === 0 ? 1 : 0;
            $roomImage->sort_order = $index;
            $roomImage->save();
        }

        return back()->with('success', 'Room images uploaded successfully!');
    }

    /*==================  AJAX — Get Rooms by Hotel  ==================*/

    public function getRoomsByHotel($hotel_id)
{
    $rooms = Room::where('rooms.hotel_id', $hotel_id)
                ->where('rooms.status', 1)
                ->join('room_types', 'rooms.room_type', '=', 'room_types.id')
                ->get(['rooms.id', 'room_types.name as room_name']);

    return response()->json($rooms);
}
}