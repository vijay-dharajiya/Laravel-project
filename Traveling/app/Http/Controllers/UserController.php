<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\FlightBooking;
use App\Models\FlightClass;
use App\Models\FlightSchedule;
use App\Models\Hotel;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /*==========================================================================
     | DASHBOARD
     |=========================================================================*/
    public function dashboard()
    {
        if (Auth::check() && Auth::user()->usertype === 'admin') {
            return view('admin.dashboard');
        }

        return view('dashboard');
    }

    /*==========================================================================
     | HOME PAGE
     | Shows trending flights (first 6 active) + all hotels
     |=========================================================================*/
    public function home()
    {
        $flights = Flight::with('flightClasses')
            ->where('is_active', true)
            ->limit(6)
            ->get();

        $hotels = Hotel::limit(6)->get();

        return view('index', compact('flights', 'hotels'));
    }

    /*==========================================================================
     | AIRPORT AUTOCOMPLETE (AJAX)
     | Called by the search box as the user types
     | Route: GET /airports/search?q=xxx
     |=========================================================================*/
    public function searchAirports(Request $request)
    {
        $query = trim($request->q ?? '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        // Search both from and to airports across all active flights
        $fromAirports = Flight::where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('from_city', 'LIKE', "%{$query}%")
                    ->orWhere('from_airport', 'LIKE', "%{$query}%")
                    ->orWhere('from_airport_code', 'LIKE', "%{$query}%");
            })
            ->select(
                'from_city         as city',
                'from_airport      as airport_name',
                'from_airport_code as airport_code'
            );

        $toAirports = Flight::where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('to_city', 'LIKE', "%{$query}%")
                    ->orWhere('to_airport', 'LIKE', "%{$query}%")
                    ->orWhere('to_airport_code', 'LIKE', "%{$query}%");
            })
            ->select(
                'to_city         as city',
                'to_airport      as airport_name',
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


    /*==========================================================================
     | FLIGHT SEARCH RESULTS
     | Route: GET /flights/search
     | Handles both one-way and round-trip searches with all filters
     |=========================================================================*/
    public function search(Request $request)
    {
        /* ──────────────────────────────────────────────────────────
        1.  READ ALL INPUTS — everything the view needs
        ────────────────────────────────────────────────────────── */
        $selDate    = $request->input('depart',   now()->toDateString());
        $returnDate = $request->input('return',   null);
        $fromCode   = strtoupper($request->input('from_code', ''));
        $toCode     = strtoupper($request->input('to_code',   ''));
        $fromText   = $request->input('from', '');
        $toText     = $request->input('to',   '');
        $tripType   = $request->input('trip', 'one-way');   // 'one-way' | 'round'
        $isRound    = $tripType === 'round';

        // Class — must be one of the four valid values
        $validClasses = ['Economy', 'Premium Economy', 'Business', 'First'];
        $selClass = in_array($request->input('class'), $validClasses)
                    ? $request->input('class') : 'Economy';

        // Passengers — minimum 1 adult
        $adults   = max(1, (int) $request->input('adults',   1));
        $children = max(0, (int) $request->input('children', 0));
        $totalPax = $adults + $children;

        /* ──────────────────────────────────────────────────────────
        2.  GUARD — return date must be ≥ depart date for round-trips
        ────────────────────────────────────────────────────────── */
        if ($isRound && $returnDate && $returnDate < $selDate) {
            $returnDate = $selDate;
        }

        $noFlightWarning = null;
        $returnWarning   = null;

        /* ──────────────────────────────────────────────────────────
        3.  ONWARD FLIGHTS  (FROM → TO on $selDate)
        ────────────────────────────────────────────────────────── */

        // 3a. Does ANY flight exist on that date at all?
        $hasDepartFlights = FlightSchedule::where('journey_date', $selDate)
            ->where('status', '!=', 'Cancelled')
            ->exists();

        if (!$hasDepartFlights) {
            $noFlightWarning = 'No flights scheduled on '
                . Carbon::parse($selDate)->format('d M Y') . '.';
        }

        // 3b. Build the onward query
        $onwardFlights = Flight::where('is_active', true)
            ->when($fromCode, fn($q) => $q->where('from_airport_code', $fromCode))
            ->when($toCode,   fn($q) => $q->where('to_airport_code',   $toCode))
            ->whereHas('schedules', function ($q) use ($selDate) {
                $q->where('journey_date', $selDate)
                ->where('status', '!=', 'Cancelled');
            })
            ->whereHas('flightClasses', function ($q) use ($selClass, $adults) {
                $q->where('class_type',       $selClass)
                ->where('available_seats', '>=', $adults);
            })
            ->with([
                'flightClasses',
                'schedules' => fn($q) => $q->where('journey_date', $selDate),
            ])
            ->orderBy('departure_time')
            ->get();

        // 3c. Route-level warning if no onward flights found
        if (!$noFlightWarning && $onwardFlights->isEmpty()) {
            $routeFrom = Flight::where('airport_code', $fromCode)->value('city') ?? $fromCode;
            $routeTo   = Flight::where('airport_code', $toCode)->value('city')   ?? $toCode;
            $noFlightWarning = "No {$selClass} flights available from {$routeFrom} to {$routeTo} "
                . 'on ' . Carbon::parse($selDate)->format('d M Y')
                . " with seats for {$adults} adult(s).";
        }

        /* ──────────────────────────────────────────────────────────
        4.  RETURN FLIGHTS  (TO → FROM on $returnDate)
        ────────────────────────────────────────────────────────── */
        $returnFlights = collect();
        $pairs         = [];

        if ($isRound && $returnDate) {

            $hasReturnFlights = FlightSchedule::where('journey_date', $returnDate)
                ->where('status', '!=', 'Cancelled')
                ->exists();

            if (!$hasReturnFlights) {
                $returnWarning = 'No flights scheduled on return date '
                    . Carbon::parse($returnDate)->format('d M Y') . '.';
            }

            $returnFlights = Flight::where('is_active', true)
                ->where('from_airport_code', $toCode)
                ->where('to_airport_code',   $fromCode)
                ->whereHas('schedules', function ($q) use ($returnDate) {
                    $q->where('journey_date', $returnDate)
                    ->where('status', '!=', 'Cancelled');
                })
                ->whereHas('flightClasses', function ($q) use ($selClass, $adults) {
                    $q->where('class_type',       $selClass)
                    ->where('available_seats', '>=', $adults);
                })
                ->with([
                    'flightClasses',
                    'schedules' => fn($q) => $q->where('journey_date', $returnDate),
                ])
                ->orderBy('departure_time')
                ->get();

            if ($returnFlights->isEmpty() && !$returnWarning) {
                $returnWarning = "No {$selClass} return flights available on "
                    . Carbon::parse($returnDate)->format('d M Y')
                    . " with seats for {$adults} adult(s).";
            }

            // 4a. Build depart × return pairs sorted by combined price (cheapest first)
            if ($onwardFlights->isNotEmpty() && $returnFlights->isNotEmpty()) {
                foreach ($onwardFlights as $depart) {
                    foreach ($returnFlights as $return) {
                        $pairs[] = ['depart' => $depart, 'return' => $return];
                    }
                }

                usort($pairs, function ($a, $b) use ($selClass) {
                    $priceA  = optional($a['depart']->flightClasses->firstWhere('class_type', $selClass))->total_price ?? 0;
                    $priceA += optional($a['return']->flightClasses->firstWhere('class_type', $selClass))->total_price ?? 0;
                    $priceB  = optional($b['depart']->flightClasses->firstWhere('class_type', $selClass))->total_price ?? 0;
                    $priceB += optional($b['return']->flightClasses->firstWhere('class_type', $selClass))->total_price ?? 0;
                    return $priceA <=> $priceB;
                });
            }
        }

        /* ──────────────────────────────────────────────────────────
        5.  SCHEDULE MAPS  (used by the view for date-level info)
        ────────────────────────────────────────────────────────── */
        $onwardScheduleMap = FlightSchedule::whereIn('flight_id', $onwardFlights->pluck('id'))
            ->where('journey_date', $selDate)
            ->get()
            ->keyBy('flight_id');

        $returnScheduleMap = collect();
        if ($isRound && $returnDate) {
            $returnScheduleMap = FlightSchedule::whereIn('flight_id', $returnFlights->pluck('id'))
                ->where('journey_date', $returnDate)
                ->get()
                ->keyBy('flight_id');
        }

        /* ──────────────────────────────────────────────────────────
        6.  DATE STRIP DATA
        ────────────────────────────────────────────────────────── */
        $flightschedules = FlightSchedule::orderBy('journey_date')
            ->pluck('journey_date')
            ->unique()
            ->toArray();

        $datesWithFlights = Flight::where('is_active', true)
            ->when($fromCode, fn($q) => $q->where('from_airport_code', $fromCode))
            ->when($toCode,   fn($q) => $q->where('to_airport_code',   $toCode))
            ->whereHas('schedules', fn($q) => $q->where('status', '!=', 'Cancelled'))
            ->with('schedules')
            ->get()
            ->pluck('schedules')
            ->flatten()
            ->pluck('journey_date')
            ->unique()
            ->toArray();

        /* ──────────────────────────────────────────────────────────
        7.  $flights — merged list (still needed by the view)
        ────────────────────────────────────────────────────────── */
        $flights = $isRound
            ? $onwardFlights->merge($returnFlights)
            : $onwardFlights;

        /* ──────────────────────────────────────────────────────────
        8.  AIRPORT NAME LOOKUP  (used in view for display)
            We pre-fetch so the blade doesn't hit DB per card.
        ────────────────────────────────────────────────────────── */
        $allCodes = $onwardFlights
            ->merge($returnFlights)
            ->flatMap(fn($f) => [$f->from_airport_code, $f->to_airport_code])
            ->unique()
            ->filter()
            ->values();

        $airportNames = flight::whereIn('from_airport_code', $allCodes)
            ->pluck('from_airport', 'from_airport_code');   // ['JFK' => 'John F. Kennedy International Airport', ...]

        /* ──────────────────────────────────────────────────────────
        9.  RETURN VIEW — pass EVERYTHING the blade needs
        ────────────────────────────────────────────────────────── */
        return view('flightdetails', compact(
            // Flight collections
            'flights',
            'onwardFlights',
            'returnFlights',
            'pairs',
            // Schedule maps
            'onwardScheduleMap',
            'returnScheduleMap',
            // Date/route data
            'flightschedules',
            'datesWithFlights',
            'selDate',
            'returnDate',
            'tripType',
            // Search inputs (for repopulating the search bar)
            'fromCode',
            'toCode',
            'fromText',
            'toText',
            // Class & passengers
            'selClass',
            'adults',
            'children',
            'totalPax',
            // Warnings
            'noFlightWarning',
            'returnWarning',
            // Airport name map
            'airportNames',
        ));
    }

    function flightdetailview()
    {
        return view('flightdetails');
    }
    /*==========================================================================
     | FLIGHT DETAILS PAGE (BOOKING PAGE)
     | Route: GET /flights/{id}
     |=========================================================================*/
  public function flightdetails(Request $request, $id)
    {
        // =========================
        // DEPART FLIGHT
        // =========================
        $departFlight = Flight::findOrFail(
            $request->depart_flight ?? $id
        );

        // =========================
        // RETURN FLIGHT
        // =========================
        $returnFlight = null;

        if ($request->trip === 'round' && $request->return_flight) {
            $returnFlight = Flight::find($request->return_flight);
        }

        // =========================
        // DEPART CLASS
        // =========================
        $departClass = null;

        if ($request->depart_class) {
            $departClass = FlightClass::find($request->depart_class);
        }

        // =========================
        // RETURN CLASS
        // =========================
        $returnClass = null;

        if ($request->return_class) {
            $returnClass = FlightClass::find($request->return_class);
        }

        return view('flightbooking', [
            'departFlight' => $departFlight,
            'returnFlight' => $returnFlight,

            'departClass' => $departClass,
            'returnClass' => $returnClass,

            'tripType'   => $request->trip,
            'selClass'   => $request->class,

            'adults'     => (int)$request->adults,
            'children'   => (int)$request->children,

            'departDate' => $request->depart_date,
            'returnDate' => $request->return_date,
        ]);
    }

    /*==========================================================================
     | POST FLIGHT BOOKING
     | Route: POST /flight_booking/{id}
     |
     | ▼▼▼ UPDATED — now handles round-trip (second flight) in the same form ▼▼▼
     |=========================================================================*/
    /**
     * Store the booking — called when the passenger form is submitted.
     * Route: POST /flight/book   name: flight.book
     */
    public function store(Request $request)
    {
        // ── 1. Validate ───────────────────────────────────────────────────────
        $adults   = (int) $request->input('adults', 1);
        $children = (int) $request->input('children', 0);
 
        // Build dynamic passenger validation rules
        $passengerRules = [];
 
        for ($i = 1; $i <= $adults; $i++) {
            $passengerRules["passengers.adult.{$i}.first_name"] = 'required|string|max:100';
            $passengerRules["passengers.adult.{$i}.last_name"]  = 'required|string|max:100';
            $passengerRules["passengers.adult.{$i}.gender"]     = 'required|in:male,female,other';
        }
 
        for ($j = 1; $j <= $children; $j++) {
            $passengerRules["passengers.child.{$j}.first_name"] = 'required|string|max:100';
            $passengerRules["passengers.child.{$j}.last_name"]  = 'required|string|max:100';
            $passengerRules["passengers.child.{$j}.gender"]     = 'required|in:male,female';
            $passengerRules["passengers.child.{$j}.dob"]        = 'required|date|before:today|after:' . now()->subYears(18)->format('Y-m-d');
        }
 
        $validated = $request->validate(array_merge([
            // Trip meta
            'depart_flight_id' => 'required|exists:flights,id',
            'depart_class_id'  => 'required|exists:flight_classes,id',
            'return_flight_id' => 'nullable|exists:flights,id',
            'return_class_id'  => 'nullable|exists:flight_classes,id',
            'trip_type'        => 'required|in:one-way,round',
            'class'            => 'required|string|max:50',
            'adults'           => 'required|integer|min:1|max:9',
            'children'         => 'required|integer|min:0|max:9',
            'depart_date'      => 'required|date|after_or_equal:today',
            'return_date'      => 'nullable|date|after_or_equal:depart_date',
            'grand_total'      => 'required|numeric|min:0',
 
            // Primary contact (on first adult)
            'contact_email'    => 'required|email|max:255',
            'contact_phone'    => 'required|string|max:30',
        ], $passengerRules));
 
        // ── 2. Re-verify grand_total server-side (prevent tampering) ──────────
        $departClass = FlightClass::findOrFail($validated['depart_class_id']);
        $returnClass = isset($validated['return_class_id'])
                       ? FlightClass::find($validated['return_class_id'])
                       : null;
 
        $totalPax    = $adults + $children;
        $dPrice      = ($departClass->base_price ?? 0) + ($departClass->tax ?? 0);
        $rPrice      = $returnClass ? (($returnClass->base_price ?? 0) + ($returnClass->tax ?? 0)) : 0;
        $expectedTotal = ($dPrice + $rPrice) * $totalPax;
 
        // Allow small float tolerance (±1)
        if (abs($expectedTotal - (float) $validated['grand_total']) > 1) {
            throw ValidationException::withMessages([
                'grand_total' => 'Price mismatch detected. Please go back and re-select your flight.',
            ]);
        }
 
        // ── 3. Check seat availability ────────────────────────────────────────
        if (($departClass->available_seats ?? 0) < $totalPax) {
            return back()->with('error', 'Not enough seats available on the outbound flight. Please go back and choose another option.');
        }
 
        if ($returnClass && ($returnClass->available_seats ?? 0) < $totalPax) {
            return back()->with('error', 'Not enough seats available on the return flight. Please go back and choose another option.');
        }
 
        // ── 4. Build passengers array for JSON storage ────────────────────────
        $passengersJson = [];
 
        for ($i = 1; $i <= $adults; $i++) {
            $p = $validated['passengers']['adult'][$i];
            $passengersJson[] = [
                'type'       => 'adult',
                'NO.'      => $i,
                'first_name' => $p['first_name'],
                'last_name'  => $p['last_name'],
                'gender'     => $p['gender'],
            ];
        }
 
        for ($j = 1; $j <= $children; $j++) {
            $p = $validated['passengers']['child'][$j];
            $passengersJson[] = [
                'type'       => 'child',
                'NO.'      => $j,
                'first_name' => $p['first_name'],
                'last_name'  => $p['last_name'],
                'gender'     => $p['gender'],
                'dob'        => $p['dob'],
            ];
        }
 
        // ── 5. Insert into DB inside a transaction ────────────────────────────
        try {
            $booking = DB::transaction(function () use (
                $validated, $passengersJson, $totalPax, $expectedTotal,
                $departClass, $returnClass
            ) {
                // Create the booking record
                $booking = FlightBooking::create([
                    'trip_type'        => $validated['trip_type'],
                    'class'            => $validated['class'],
                    'depart_date'      => $validated['depart_date'],
                    'return_date'      => $validated['return_date'] ?? null,
                    'adults'           => $validated['adults'],
                    'children'         => $validated['children'],
                    'grand_total'      => $expectedTotal,  // use server-calculated value
                    'status'           => 'pending',
 
                    'depart_flight_id' => $validated['depart_flight_id'],
                    'depart_class_id'  => $validated['depart_class_id'],
                    'return_flight_id' => $validated['return_flight_id'] ?? null,
                    'return_class_id'  => $validated['return_class_id'] ?? null,
 
                    'contact_email'    => $validated['contact_email'],
                    'contact_phone'    => $validated['contact_phone'],
 
                    'passengers'       => $passengersJson,
                ]);
 
                // Decrement available seats on outbound class
                $departClass->decrement('available_seats', $totalPax);
 
                // Decrement on return class if round trip
                if ($returnClass) {
                    $returnClass->decrement('available_seats', $totalPax);
                }
 
                return $booking;
            });
 
            // ── 6. Redirect to confirmation page ──────────────────────────────
            return redirect()
                ->route('flight.booking.confirmation', ['booking' => $booking->id])
                ->with('success', 'Booking confirmed! Your reference is ' . $booking->booking_reference);
 
        } catch (\Exception $e) {
            Log::error('Flight booking failed', [
                'error'   => $e->getMessage(),
                'request' => $request->except(['_token']),
            ]);
 
            return back()
                ->withInput()
                ->with('error', 'Something went wrong while processing your booking. Please try again.');
        }
    }
 
    /**
     * Show the booking confirmation page.
     * Route: GET /flight/booking/{booking}/confirmation   name: flight.booking.confirmation
     */
    public function confirmation(FlightBooking $booking)
    {
        // Load relationships for the confirmation view
        $booking->load(['departFlight', 'returnFlight', 'departClass', 'returnClass']);
 
        return view('flightconfirmation', compact('booking'));
    }

 
    /*==========================================================================
     | HOTEL DETAIL PAGE
     | Route: GET /hotel/{id}
     |=========================================================================*/
    public function hotelview($id)
    {
        $hotel = Hotel::with('images')->findOrFail($id);
        $rooms = Room::with(['images' => fn ($q) => $q->orderBy('sort_order')])
            ->where('hotel_id', $id)
            ->where('status', 1)
            ->get();

        return view('hoteldetails', compact('hotel', 'rooms'));
    }

    
}
