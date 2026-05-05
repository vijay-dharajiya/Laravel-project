<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Flight;
use App\Models\FlightBooking;
use App\Models\FlightClass;
use App\Models\Hotel;
use App\Models\Hotelimage;
use App\Models\Room;
use App\Models\Roomimage;
use Carbon\Carbon;

class UserController extends Controller
{
    function index1(){
        if(Auth::check()&& Auth::user()->usertype=='user'){
            return view('dashboard');
        }
        
        else if(Auth::check()&& Auth::user()->usertype=='admin'){
            return view('admin.dashboard');
        }
    }

    public function searchAirports(Request $request)
    {
        $query = trim($request->q);

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $fromAirports = Flight::where('is_active', true)
            ->where(function($q2) use ($query) {
                $q2->where('from_city', 'LIKE', "%{$query}%")
                ->orWhere('from_airport', 'LIKE', "%{$query}%")
                ->orWhere('from_airport_code', 'LIKE', "%{$query}%");
            })
            ->select(
                'from_city as city',
                'from_airport as airport_name',
                'from_airport_code as airport_code'
            );

        $toAirports = Flight::where('is_active', true)
            ->where(function($q2) use ($query) {
                $q2->where('to_city', 'LIKE', "%{$query}%")
                ->orWhere('to_airport', 'LIKE', "%{$query}%")
                ->orWhere('to_airport_code', 'LIKE', "%{$query}%");
            })
            ->select(
                'to_city as city',
                'to_airport as airport_name',
                'to_airport_code as airport_code'
            );

        $airports = $fromAirports
            ->union($toAirports)
            ->get()
            ->unique('airport_code')
            ->sortBy('city')
            ->values();

        return response()->json($airports);
       
    }

    function searchFlights(Request $request)
    {
        $request->validate([
            'from_airport_code' => 'required|string|size:3',
            'to_airport_code' => 'required|string|size:3|different:from_airport_code',
            'departure_date' => 'required|date|after_or_equal:today',
            'return_date' => 'nullable|date|after_or_equal:departure_date',
            'trip_type' => 'required|in:One Way,Round Trip',
        ]);

        $flights = Flight::where('is_active', true)
            ->where('from_airport_code', $request->from_airport_code)
            ->where('to_airport_code', $request->to_airport_code)
            ->whereDate('departure_time', $request->departure_date)
            ->get();

        return view('flightdetails', compact('flights'));
    }
    /*=====================         HOME FUNCTION             ==========================*/
    function home(){
        $flights = Flight::limit(6)->where('is_active', true)->get();
        return view('index', compact('flights'));
    }

    /*=====================         FLIGHT FUNCTIONS             ==========================*/
    function flightslist(){
        $flights = Flight::all();
        return view('index', compact('flights'));
    }

    function flightdetails($id)
    {
        $flight = Flight::with('flightClasses')->find($id);

        if (!$flight) {
            return redirect()->route('index')->with('error', 'Flight not found.');
        }

        $classes = $flight->flightClasses->sortBy('total_price')->values();
        $econClass = $classes->first();
        $basePrice  = $econClass ? $econClass->total_price : 0;

        $dep = Carbon::parse($flight->departure_time);
        $arr = Carbon::parse($flight->arrival_time);

        if ($flight->overnight_arrival) {
            $arr = $arr->addDay();
        }

        $diff = $dep->diff($arr);
        $overnight = (bool) $flight->overnight_arrival;
        $stopovers = $flight->stopover_cities ? json_decode($flight->stopover_cities, true) : [];

        return view('flightdetails', compact(
            'flight',
            'classes',
            'econClass',
            'basePrice',
            'dep',
            'arr',
            'diff',
            'overnight',
            'stopovers'
        ));
    }

    function postflightbook(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'gender' => 'required|in:Male,Female,Other',
            'email' => 'required|email|max:100',
            'phone_number' => 'required|string|max:15',
            'travel_date' => 'required|date|after_or_equal:today',
            'return_date' => 'nullable|date|after_or_equal:travel_date',
            'adults' => 'required|integer|min:0',
            'children' => 'required|integer|min:0',
            'trip_type' => 'required|in:One Way,Round Trip',
            'class_id' => 'required|integer|exists:flight_classes,id',
        ]);

        $flight = Flight::findOrFail($id);

        $flightClass = FlightClass::where('id', $request->class_id)
            ->where('flight_id', $flight->id)
            ->first();

        if (! $flightClass) {
            return back()->with('error', 'Selected cabin class is not available for this flight.');
        }

        $totalPassengers = $request->adults + $request->children;

        if ($totalPassengers === 0) {
            return back()->with('error', 'At least 1 passenger is required.');
        }

        if ($request->trip_type === 'Round Trip' && ! $request->return_date) {
            return back()->with('error', 'Please select a return date for round-trip bookings.');
        }

        if ($flightClass->available_seats < $totalPassengers) {
            return back()->with('error', 'Not enough seats available for the selected class.');
        }

        $departureDatetime = Carbon::parse($request->travel_date . ' ' . $flight->departure_time);
        $arrivalDatetime = Carbon::parse($request->travel_date . ' ' . $flight->arrival_time);

        if ($flight->overnight_arrival) {
            $arrivalDatetime = $arrivalDatetime->addDay();
        }

        $booking = FlightBooking::create([
            'flight_id' => $flight->id,
            'flight_number' => $flight->flight_number,
            'airline_name' => $flight->airline_name,
            'origin_airport' => $flight->from_airport_code,
            'destination_airport' => $flight->to_airport_code,
            'departure_datetime' => $departureDatetime,
            'arrival_datetime' => $arrivalDatetime,
            'flight_duration' => $departureDatetime->diffInMinutes($arrivalDatetime),
            'cabin_class' => $flightClass->class_type,
            'trip_type' => $request->trip_type,
            'passenger_id' => Auth::id(),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'booking_status' => 'Confirmed',
        ]);

        $flightClass->decrement('available_seats', $totalPassengers);
        $flightClass->increment('booked_seats', $totalPassengers);

        return redirect()->route('flight.details', $flight->id)
            ->with('success', 'Booking confirmed successfully! Your PNR is ' . $booking->pnr_number);
    }
    /*=====================         HOTEL FUNCTIONS             ==========================*/
    public function hotelview($id)
    {
        // Get hotel with images
        $hotel = Hotel::with('images')->findOrFail($id);

        // 🔥 Get only THIS hotel's rooms with images
        $rooms = Room::with(['images' => function($q) {$q->orderBy('sort_order');}])->where('hotel_id', $id)->where('status', 1)->get();

        return view('hoteldetails', compact('hotel', 'rooms'));
    }
}
