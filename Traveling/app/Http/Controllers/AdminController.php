<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\FlightClass;
use App\Models\FlightSchedule;
use App\Models\Hotel;
use App\Models\HotelImage;
use App\Models\Room;
use App\Models\RoomImage;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /* ==================  FLIGHT FUNCTIONS  ================== */

    public function addflight()
    {
        return view('admin.addflight');
    }

    public function viewflight()
    {
        $flights = Flight::all();

        return view('admin.viewflight', compact('flights'));
    }

    public function postAddflight(Request $rq)
    {
        // ✅ Validation
        $rq->validate([
            'airline_name' => 'required',
            'airline_code' => 'required|max:10',
            'flight_number' => 'required|unique:flights,flight_number',
            'aircraft_type' => 'nullable',

            'from_city' => 'required',
            'from_airport' => 'required',
            'from_airport_code' => 'required|max:10',

            'to_city' => 'required',
            'to_airport' => 'required',
            'to_airport_code' => 'required|max:10',

            'departure_time' => 'required',
            'departure_timezone' => 'required',
            'arrival_time' => 'required',
            'arrival_timezone' => 'required',
            'duration'=> 'required',

            'stops' => 'required|integer|min:0|max:2',
            'stopover_cities' => 'nullable|required_if:stops,1|required_if:stops,2',
        ]);

        // ❌ Prevent same airport
        if ($rq->from_airport_code == $rq->to_airport_code) {
            return back()->with('error', 'From and To airport cannot be same');
        }

        // ✅ Create Flight Object
        $flight = new Flight;

        // ─── Airline Info ───
        $flight->airline_name = $rq->airline_name;
        $flight->airline_code = $rq->airline_code;
        $flight->flight_number = $rq->flight_number;
        $flight->aircraft_type = $rq->aircraft_type;

        // ─── Route ───
        $flight->from_city = $rq->from_city;
        $flight->from_airport = $rq->from_airport;
        $flight->from_airport_code = strtoupper($rq->from_airport_code);

        $flight->to_city = $rq->to_city;
        $flight->to_airport = $rq->to_airport;
        $flight->to_airport_code = strtoupper($rq->to_airport_code);

        // ─── Timing ───
        $flight->departure_time = $rq->departure_time;
        $flight->arrival_time = $rq->arrival_time;
        $flight->departure_timezone = $rq->departure_timezone;
        $flight->arrival_timezone = $rq->arrival_timezone;
        $flight->duration = $rq->duration;
        $flight->overnight_arrival = $rq->overnight_arrival ?? 0;

        // ─── Stops ───
        $flight->stops = $rq->stops;

        // Stopover cities (comma → JSON)
        if (! empty($rq->stopover_cities)) {
            $cities = array_map('trim', explode(',', $rq->stopover_cities));
            $flight->stopover_cities = json_encode(array_values(array_filter($cities)));
        }

        // ─── Airline Logo Upload (Your Style) ───
        if ($rq->hasFile('airline_logo')) {
            $img = $rq->file('airline_logo');

            $imagename = time().'_logo.'.$img->getClientOriginalExtension();

            $img->move(public_path('airline_logos'), $imagename);

            $flight->airline_logo = 'airline_logos/'.$imagename;
        }

        // ─── Status ───
        $flight->is_active = $rq->has('is_active') ? 1 : 0;

        // ✅ Save
        $flight->save();

        return redirect()->route('admin.viewflight')->with('msg', '✈️ Flight Added Successfully');
    }

    public function editflight($id)
    {
        $flight = Flight::findOrFail($id);

        return view('admin.updateflight', compact('flight'));
    }

    public function posteditflight(Request $rq, $id)
    {
        // ✅ Validation
        $rq->validate([
            'airline_name' => 'required',
            'airline_code' => 'required|max:10',
            'flight_number' => 'required|unique:flights,flight_number,'.$id,
            'aircraft_type' => 'nullable',

            'from_city' => 'required',
            'from_airport' => 'required',
            'from_airport_code' => 'required|max:10',

            'to_city' => 'required',
            'to_airport' => 'required',
            'to_airport_code' => 'required|max:10',

            'departure_time' => 'required',
            'arrival_time' => 'required',
            'departure_timezone' => 'required',
            'arrival_timezone' => 'required',
            'duration'=> 'required',

            'stops' => 'required|integer|min:0|max:2',
        ]);

        $flight = Flight::findOrFail($id);

        // ❌ Prevent same airport
        if ($rq->from_airport_code == $rq->to_airport_code) {
            return back()->with('error', 'From and To airport cannot be same');
        }

        // ─── Airline Info ───
        $flight->airline_name = $rq->airline_name;
        $flight->airline_code = $rq->airline_code;
        $flight->flight_number = $rq->flight_number;
        $flight->aircraft_type = $rq->aircraft_type;

        // ─── Route ───
        $flight->from_city = $rq->from_city;
        $flight->from_airport = $rq->from_airport;
        $flight->from_airport_code = strtoupper($rq->from_airport_code);

        $flight->to_city = $rq->to_city;
        $flight->to_airport = $rq->to_airport;
        $flight->to_airport_code = strtoupper($rq->to_airport_code);

        // ─── Timing ───
        $flight->departure_time = $rq->departure_time;
        $flight->arrival_time = $rq->arrival_time;
        $flight->departure_timezone = $rq->departure_timezone;
        $flight->arrival_timezone = $rq->arrival_timezone;
        $flight->duration = $rq->duration;
        $flight->overnight_arrival = $rq->overnight_arrival ?? 0;

        // ─── Stops ───
        $flight->stops = $rq->stops;

        // Stopover cities JSON
        if (! empty($rq->stopover_cities)) {
            $cities = array_map('trim', explode(',', $rq->stopover_cities));
            $flight->stopover_cities = json_encode(array_values(array_filter($cities)));
        } else {
            $flight->stopover_cities = null;
        }

        // ─── Airline Logo Update (Your Style) ───
        if ($rq->hasFile('airline_logo')) {

            // Delete old logo
            if ($flight->airline_logo && file_exists(public_path($flight->airline_logo))) {
                unlink(public_path($flight->airline_logo));
            }

            $img = $rq->file('airline_logo');
            $imagename = time().'_logo.'.$img->getClientOriginalExtension();

            $img->move(public_path('airline_logos'), $imagename);

            $flight->airline_logo = 'airline_logos/'.$imagename;
        }

        // ─── Status ───
        $flight->is_active = $rq->has('is_active') ? 1 : 0;

        // ✅ Save
        $flight->save();

        return redirect()->route('admin.viewflight')->with('msg', '✏️ Flight Updated Successfully');
    }

    public function deleteflight($id)
    {
        $flight = Flight::findOrFail($id);

        // Delete airline logo
        if ($flight->airline_logo && file_exists(public_path($flight->airline_logo))) {
            unlink(public_path($flight->airline_logo));
        }

        $flight->delete();

        return redirect()->route('admin.viewflight')->with('msg', '🗑️ Flight Deleted Successfully');
    }

    /* ================== FLIGHT CLASS FUNCTIONS ================== */

    // ─── Show all classes of a flight ─────────────────────────────────
    public function flightClassIndex($flightId)
    {
        $flight = Flight::findOrFail($flightId);
        $classes = FlightClass::where('flight_id', $flightId)->get();

        return view('admin.flight_classes.index', compact('flight', 'classes'));
    }

    // ─── Show add form ─────────────────────────────────────────────────
    public function flightClassCreate($flightId)
    {
        $flight = Flight::findOrFail($flightId);

        // Find which classes already exist for this flight
        $existingTypes = FlightClass::where('flight_id', $flightId)
            ->pluck('class_type')
            ->toArray();

        // Only show classes that are NOT added yet
        $allTypes = ['Economy', 'Premium Economy', 'Business', 'First'];
        $availableTypes = array_diff($allTypes, $existingTypes);

        if (empty($availableTypes)) {
            return redirect()
                ->route('admin.flightclass.index', $flightId)
                ->with('error', 'All 4 classes already added for this flight.');
        }

        return view('admin.flight_classes.create', compact('flight', 'availableTypes'));
    }

    // ─── Store classes ─────────────────────────────────────────────────
    public function flightClassStore(Request $rq, $flightId)
    {
        $flight = Flight::findOrFail($flightId);

        $rq->validate([
            'classes' => 'required|array|min:1',
            'classes.*.class_type' => 'required|in:Economy,Premium Economy,Business,First',
            'classes.*.total_seats' => 'required|integer|min:1',
            'classes.*.base_price' => 'required|numeric|min:0',
            'classes.*.tax' => 'required|numeric|min:0',
            'classes.*.cabin_baggage_kg' => 'required|integer|min:0',
            'classes.*.checkin_baggage_kg' => 'required|integer|min:0',
            'classes.*.is_refundable' => 'nullable|boolean',
            'classes.*.cancellation_charge' => 'nullable|numeric|min:0',
        ]);

        foreach ($rq->classes as $classData) {

            // Prevent duplicate class type for same flight
            $exists = FlightClass::where('flight_id', $flightId)
                ->where('class_type', $classData['class_type'])
                ->exists();

            if ($exists) {
                continue;
            } // skip if already added

            $base = (float) $classData['base_price'];
            $tax = (float) $classData['tax'];

            FlightClass::create([
                'flight_id' => $flightId,
                'class_type' => $classData['class_type'],

                // Seats
                'total_seats' => $classData['total_seats'],
                'available_seats' => $classData['total_seats'], // same as total at start
                'booked_seats' => 0,

                // Pricing
                'base_price' => $base,
                'tax' => $tax,
                'total_price' => $base + $tax, // auto calculated
                'currency' => 'INR',

                // Baggage
                'cabin_baggage_kg' => $classData['cabin_baggage_kg'],
                'checkin_baggage_kg' => $classData['checkin_baggage_kg'],

                // Refund
                'is_refundable' => isset($classData['is_refundable']) ? 1 : 0,
                'cancellation_charge' => $classData['cancellation_charge'] ?? 0,
            ]);
        }

        return redirect()
            ->route('admin.flightclass.index', $flightId)
            ->with('msg', '✅ Flight Classes Added Successfully');
    }

    // ─── Show edit form ────────────────────────────────────────────────
    public function flightClassEdit($id)
    {
        $class = FlightClass::findOrFail($id);
        $flight = Flight::findOrFail($class->flight_id);

        return view('admin.flight_classes.edit', compact('class', 'flight'));
    }

    // ─── Update class ──────────────────────────────────────────────────
    public function flightClassUpdate(Request $rq, $id)
    {
        $class = FlightClass::findOrFail($id);

        $rq->validate([
            'total_seats' => 'required|integer|min:1',
            'base_price' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'cabin_baggage_kg' => 'required|integer|min:0',
            'checkin_baggage_kg' => 'required|integer|min:0',
            'is_refundable' => 'nullable|boolean',
            'cancellation_charge' => 'nullable|numeric|min:0',
        ]);

        $base = (float) $rq->base_price;
        $tax = (float) $rq->tax;

        // Recalculate available seats if total_seats changed
        $seatDiff = $rq->total_seats - $class->total_seats;
        $newAvailable = $class->available_seats + $seatDiff;

        // available_seats should never go below 0
        if ($newAvailable < 0) {
            return back()->with('error', 'Total seats cannot be less than already booked seats.');
        }

        $class->total_seats = $rq->total_seats;
        $class->available_seats = $newAvailable;
        $class->base_price = $base;
        $class->tax = $tax;
        $class->total_price = $base + $tax;
        $class->cabin_baggage_kg = $rq->cabin_baggage_kg;
        $class->checkin_baggage_kg = $rq->checkin_baggage_kg;
        $class->is_refundable = $rq->has('is_refundable') ? 1 : 0;
        $class->cancellation_charge = $rq->cancellation_charge ?? 0;

        $class->save();

        return redirect()
            ->route('admin.flight_classes.index', $class->flight_id)
            ->with('msg', '✏️ Class Updated Successfully');
    }

    // ─── Delete class ──────────────────────────────────────────────────
    public function flightClassDestroy($id)
    {
        $class = FlightClass::findOrFail($id);
        $flightId = $class->flight_id;

        // Safety check — don't delete if bookings exist
        if ($class->booked_seats > 0) {
            return redirect()
                ->route('admin.flight_classes.index', $flightId)
                ->with('error', '❌ Cannot delete. This class has active bookings.');
        }

        $class->delete();

        return redirect()
            ->route('admin.flight_classes.index', $flightId)
            ->with('msg', '🗑️ Class Deleted Successfully');
    }

    /* ==================  HOTEL FUNCTIONS  ================== */

    public function addhotel()
    {
        return view('admin.addhotel');
    }

    public function viewhotel()
    {
        $hotels = Hotel::all();

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
        $hotels = Hotel::all();
        $room_types = RoomType::where('status', 1)->get();

        return view('admin.addhotelroom', compact('hotels', 'room_types'));
    }

    public function roomimages()
    {
        $hotels = Hotel::all();

        // ✅ Empty by default — rooms load via AJAX after hotel selected
        $rooms = collect();
        $room_types = RoomType::where('status', 1)->get();

        return view('admin.addroomimage', compact('hotels', 'rooms', 'room_types'));
    }

    /* ================== FLIGHT SCHEDULE FUNCTIONS ================== */

    // ─── Show all schedules of a flight ───────────────────────────────
    public function flightScheduleIndex($flightId)
    {
        $flight = Flight::findOrFail($flightId);
        $schedules = FlightSchedule::where('flight_id', $flightId)
            ->orderBy('journey_date', 'asc')
            ->paginate(30);

        return view('admin.flight_schedules.index', compact('flight', 'schedules'));
    }

    // ─── Generate schedules in bulk (30/60/90 days) ───────────────────
    public function flightScheduleGenerate(Request $rq, $flightId)
    {
        $rq->validate([
            'days' => 'required|in:30,60,90',
        ]);

        $flight = Flight::findOrFail($flightId);
        $days = (int) $rq->days;
        $created = 0;
        $skipped = 0;

        for ($i = 0; $i < $days; $i++) {

            $date = Carbon::today()->addDays($i)->toDateString();

            // Skip if already exists
            $exists = FlightSchedule::where('flight_id', $flightId)
                ->where('journey_date', $date)
                ->exists();

            if ($exists) {
                $skipped++;

                continue;
            }

            FlightSchedule::create([
                'flight_id' => $flightId,
                'journey_date' => $date,
                'status' => 'Scheduled',
            ]);

            $created++;
        }

        $msg = "✅ {$created} schedules created.";
        if ($skipped > 0) {
            $msg .= " {$skipped} already existed, skipped.";
        }

        return redirect()
            ->route('admin.flightschedule.index', $flightId)
            ->with('msg', $msg);
    }

    // ─── Update status of a single schedule ───────────────────────────
    public function flightScheduleUpdateStatus(Request $rq, $id)
    {
        $rq->validate([
            'status' => 'required|in:Scheduled,On Time,Delayed,Cancelled,Boarding,Departed,Landed',
        ]);

        $schedule = FlightSchedule::findOrFail($id);
        $schedule->status = $rq->status;
        $schedule->save();

        return redirect()
            ->route('admin.flightschedule.index', $schedule->flight_id)
            ->with('msg', '✅ Schedule status updated.');
    }

    // ─── Delete single schedule ────────────────────────────────────────
    public function flightScheduleDestroy($id)
    {
        $schedule = FlightSchedule::findOrFail($id);
        $flightId = $schedule->flight_id;

        // Safety — don't delete past or active schedules
        if (in_array($schedule->status, ['Boarding', 'Departed'])) {
            return redirect()
                ->route('admin.flightschedule.index', $flightId)
                ->with('error', '❌ Cannot delete. Flight is currently Boarding or Departed.');
        }

        $schedule->delete();

        return redirect()
            ->route('admin.flightschedule.index', $flightId)
            ->with('msg', '🗑️ Schedule deleted.');
    }

    // ─── Delete ALL past schedules of a flight (cleanup) ──────────────
    public function flightScheduleCleanup($flightId)
    {
        Flight::findOrFail($flightId); // verify flight exists

        $deleted = FlightSchedule::where('flight_id', $flightId)
            ->where('journey_date', '<', Carbon::today())
            ->delete();

        return redirect()
            ->route('admin.flightschedule.index', $flightId)
            ->with('msg', "🧹 {$deleted} past schedules cleaned up.");
    }

    /* ==================  HOTEL STORE  ================== */

    public function hotelstore(Request $rq)
    {
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

        $hotel = new Hotel;
        $hotel->name = $rq->name;
        $hotel->description = $rq->description;
        $hotel->slug = \Str::slug($rq->name).'-'.time();
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
            $imagename = time().'.'.$img->getClientOriginalExtension();
            $img->move(public_path('hotel_images'), $imagename);
            $hotel->thumbnail = $imagename;
        }

        $hotel->save();

        return redirect()->route('admin.hotelimages', ['hotel_id' => $hotel->id])->with('success', 'Hotel Added! Now upload images.');
    }

    /* ==================  HOTEL EDIT/UPDATE/DELETE  ================== */

    public function edithotel($id)
    {
        $hotel = Hotel::findOrFail($id);

        return view('admin.updatehotel', compact('hotel'));
    }

    public function postedithotel(Request $rq, $id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->name = $rq->name;
        $hotel->description = $rq->description;
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
            if ($hotel->thumbnail && file_exists(public_path('hotel_images/'.$hotel->thumbnail))) {
                unlink(public_path('hotel_images/'.$hotel->thumbnail));
            }
            $img = $rq->file('thumbnail');
            $imagename = time().'.'.$img->getClientOriginalExtension();
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
        if ($hotel->thumbnail && file_exists(public_path('hotel_images/'.$hotel->thumbnail))) {
            unlink(public_path('hotel_images/'.$hotel->thumbnail));
        }

        // Delete all gallery images from disk
        foreach ($hotel->images as $image) {
            if (file_exists(public_path('hotel_images/'.$image->image))) {
                unlink(public_path('hotel_images/'.$image->image));
            }
        }

        $hotel->delete(); // DB records auto-deleted if cascade set
    }

    /* ==================  HOTEL IMAGES STORE  ================== */

    public function hotelimagestore(Request $rq)
    {
        $rq->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'images' => 'required',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp',
        ]);

        foreach ($rq->file('images') as $img) {
            $filename = time().'_'.uniqid().'.'.$img->getClientOriginalExtension();
            $img->move(public_path('hotel_images'), $filename);

            $hotelImage = new HotelImage;
            $hotelImage->hotel_id = $rq->hotel_id;
            $hotelImage->image = $filename;
            $hotelImage->save();
        }

        return back()->with('success', 'Hotel Images uploaded successfully!');
    }

    /* ===================  HOTEL IMAGE DELETE  ================== */
    // AdminController.php
    public function deleteHotelImage($id)
    {
        $image = HotelImage::findOrFail($id);
        $hotel_id = $image->hotel_id;

        // ✅ Delete file from disk
        if (file_exists(public_path('hotel_images/'.$image->image))) {
            unlink(public_path('hotel_images/'.$image->image));
        }

        $image->delete();

        return redirect()->route('admin.hotelimages', ['hotel_id' => $hotel_id])
            ->with('success', 'Image deleted successfully!');
    }
    /* ==================  HOTEL ROOM STORE  ================== */

    public function hotelroomstore(Request $rq)
    {
        $rq->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'room_type' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'total_rooms' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'status' => 'required|in:0,1',
        ]);

        $room = new Room;
        $room->hotel_id = $rq->hotel_id;
        $room->room_type = $rq->room_type;
        $room->capacity = $rq->capacity;
        $room->price = $rq->price;
        $room->total_rooms = $rq->total_rooms;
        $room->description = $rq->description;
        $room->status = $rq->status;
        $room->save();

        return redirect()->route('admin.roomimages', ['hotel_id' => $room->hotel_id, 'room_id' => $room->id])
            ->with('success', 'Room added successfully!');
    }

    /* ==================  ROOM IMAGES STORE  ================== */

    public function roomimagestore(Request $rq)
    {
        $rq->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'room_id' => 'required|exists:rooms,id',
            'images' => 'required',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        foreach ($rq->file('images') as $index => $img) {
            $filename = time().'_'.uniqid().'.'.$img->getClientOriginalExtension();
            $img->move(public_path('room_images'), $filename);

            $roomImage = new RoomImage;
            $roomImage->hotel_id = $rq->hotel_id;
            $roomImage->room_id = $rq->room_id;
            $roomImage->image = $filename;
            $roomImage->is_primary = $index === 0 ? 1 : 0;
            $roomImage->sort_order = $index;
            $roomImage->save();
        }

        return back()->with('success', 'Room images uploaded successfully!');
    }

    /* ==================  AJAX — Get Rooms by Hotel  ================== */

    public function getRoomsByHotel($hotel_id)
    {
        $rooms = Room::where('rooms.hotel_id', $hotel_id)
            ->where('rooms.status', 1)
            ->join('room_types', 'rooms.room_type', '=', 'room_types.id')
            ->get(['rooms.id', 'room_types.name as room_name']);

        return response()->json($rooms);
    }
}
