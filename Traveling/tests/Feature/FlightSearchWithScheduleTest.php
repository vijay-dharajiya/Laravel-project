<?php

use App\Models\Flight;
use App\Models\FlightClass;
use App\Models\FlightSchedule;

it('returns flights only when flight has schedule for selected date', function () {
    $departDate = now()->addDay()->toDateString();

    // Create a flight
    $flight = Flight::create([
        'airline_name' => 'TestAir',
        'airline_code' => 'TA',
        'flight_number' => 'TA-101',
        'aircraft_type' => 'A320',
        'airline_logo' => null,
        'from_city' => 'Mumbai',
        'from_airport' => 'Chhatrapati Shivaji Maharaj International Airport',
        'from_airport_code' => 'BOM',
        'to_city' => 'Delhi',
        'to_airport' => 'Indira Gandhi International Airport',
        'to_airport_code' => 'DEL',
        'departure_time' => now()->addDay()->setTime(9, 0),
        'arrival_time' => now()->addDay()->setTime(11, 0),
        'overnight_arrival' => false,
        'stops' => 0,
        'stopover_cities' => null,
        'is_active' => true,
    ]);

    // Create flight class
    FlightClass::create([
        'flight_id' => $flight->id,
        'class_type' => 'Economy',
        'total_seats' => 50,
        'available_seats' => 50,
        'booked_seats' => 0,
        'base_price' => 1000,
        'tax' => 100,
        'total_price' => 1100,
        'currency' => 'INR',
        'cabin_baggage_kg' => 7,
        'checkin_baggage_kg' => 15,
        'is_refundable' => true,
        'cancellation_charge' => 0,
    ]);

    // Create schedule for selected date
    FlightSchedule::create([
        'flight_id' => $flight->id,
        'journey_date' => $departDate,
        'status' => 'Scheduled',
    ]);

    // Search for flights
    $response = $this->get(route('flight.search', [
        'from' => 'Mumbai',
        'from_code' => 'BOM',
        'to' => 'Delhi',
        'to_code' => 'DEL',
        'depart' => $departDate,
        'adults' => 1,
        'children' => 0,
        'class' => 'Economy',
        'trip' => 'one-way',
    ]));

    $response->assertStatus(200);
    $response->assertViewIs('flightdetails');
    $response->assertViewHas('flights');
    expect($response->original->getData()['flights']->count())->toBe(1);
});

it('does not return flights when flight has no schedule for selected date', function () {
    $departDate = now()->addDay()->toDateString();
    $otherDate = now()->addDays(3)->toDateString();

    // Create a flight
    $flight = Flight::create([
        'airline_name' => 'TestAir',
        'airline_code' => 'TA',
        'flight_number' => 'TA-102',
        'aircraft_type' => 'A320',
        'airline_logo' => null,
        'from_city' => 'Mumbai',
        'from_airport' => 'Chhatrapati Shivaji Maharaj International Airport',
        'from_airport_code' => 'BOM',
        'to_city' => 'Bangalore',
        'to_airport' => 'Kempegowda International Airport',
        'to_airport_code' => 'BLR',
        'departure_time' => now()->addDay()->setTime(10, 0),
        'arrival_time' => now()->addDay()->setTime(12, 0),
        'overnight_arrival' => false,
        'stops' => 0,
        'stopover_cities' => null,
        'is_active' => true,
    ]);

    // Create flight class
    FlightClass::create([
        'flight_id' => $flight->id,
        'class_type' => 'Economy',
        'total_seats' => 50,
        'available_seats' => 50,
        'booked_seats' => 0,
        'base_price' => 1000,
        'tax' => 100,
        'total_price' => 1100,
        'currency' => 'INR',
        'cabin_baggage_kg' => 7,
        'checkin_baggage_kg' => 15,
        'is_refundable' => true,
        'cancellation_charge' => 0,
    ]);

    // Create schedule for DIFFERENT date
    FlightSchedule::create([
        'flight_id' => $flight->id,
        'journey_date' => $otherDate,
        'status' => 'Scheduled',
    ]);

    // Try to search for flights on departDate (no schedule)
    $response = $this->get(route('flight.search', [
        'from' => 'Mumbai',
        'from_code' => 'BOM',
        'to' => 'Bangalore',
        'to_code' => 'BLR',
        'depart' => $departDate,
        'adults' => 1,
        'children' => 0,
        'class' => 'Economy',
        'trip' => 'one-way',
    ]));

    // Should redirect back with error
    $response->assertRedirect();
    $response->assertSessionHas('error');
});

it('filters flights with cancelled or delayed status', function () {
    $departDate = now()->addDay()->toDateString();

    // Create a flight
    $flight = Flight::create([
        'airline_name' => 'TestAir',
        'airline_code' => 'TA',
        'flight_number' => 'TA-103',
        'aircraft_type' => 'A320',
        'airline_logo' => null,
        'from_city' => 'Mumbai',
        'from_airport' => 'Chhatrapati Shivaji Maharaj International Airport',
        'from_airport_code' => 'BOM',
        'to_city' => 'Goa',
        'to_airport' => 'Dabolim Airport',
        'to_airport_code' => 'GOI',
        'departure_time' => now()->addDay()->setTime(14, 0),
        'arrival_time' => now()->addDay()->setTime(16, 0),
        'overnight_arrival' => false,
        'stops' => 0,
        'stopover_cities' => null,
        'is_active' => true,
    ]);

    // Create flight class
    FlightClass::create([
        'flight_id' => $flight->id,
        'class_type' => 'Economy',
        'total_seats' => 50,
        'available_seats' => 50,
        'booked_seats' => 0,
        'base_price' => 1000,
        'tax' => 100,
        'total_price' => 1100,
        'currency' => 'INR',
        'cabin_baggage_kg' => 7,
        'checkin_baggage_kg' => 15,
        'is_refundable' => true,
        'cancellation_charge' => 0,
    ]);

    // Create schedule with CANCELLED status
    FlightSchedule::create([
        'flight_id' => $flight->id,
        'journey_date' => $departDate,
        'status' => 'Cancelled',
    ]);

    // Try to search for flights
    $response = $this->get(route('flight.search', [
        'from' => 'Mumbai',
        'from_code' => 'BOM',
        'to' => 'Goa',
        'to_code' => 'GOI',
        'depart' => $departDate,
        'adults' => 1,
        'children' => 0,
        'class' => 'Economy',
        'trip' => 'one-way',
    ]));

    // Should redirect back with error (cancelled flights excluded)
    $response->assertRedirect();
    $response->assertSessionHas('error');
});

it('accepts only Scheduled and On Time flight schedules', function () {
    $departDate = now()->addDay()->toDateString();

    // Create a flight
    $flight = Flight::create([
        'airline_name' => 'TestAir',
        'airline_code' => 'TA',
        'flight_number' => 'TA-104',
        'aircraft_type' => 'A320',
        'airline_logo' => null,
        'from_city' => 'Delhi',
        'from_airport' => 'Indira Gandhi International Airport',
        'from_airport_code' => 'DEL',
        'to_city' => 'Hyderabad',
        'to_airport' => 'Rajiv Gandhi International Airport',
        'to_airport_code' => 'HYD',
        'departure_time' => now()->addDay()->setTime(15, 0),
        'arrival_time' => now()->addDay()->setTime(17, 30),
        'overnight_arrival' => false,
        'stops' => 0,
        'stopover_cities' => null,
        'is_active' => true,
    ]);

    // Create flight class
    FlightClass::create([
        'flight_id' => $flight->id,
        'class_type' => 'Economy',
        'total_seats' => 50,
        'available_seats' => 50,
        'booked_seats' => 0,
        'base_price' => 1000,
        'tax' => 100,
        'total_price' => 1100,
        'currency' => 'INR',
        'cabin_baggage_kg' => 7,
        'checkin_baggage_kg' => 15,
        'is_refundable' => true,
        'cancellation_charge' => 0,
    ]);

    // Create schedule with ON TIME status
    FlightSchedule::create([
        'flight_id' => $flight->id,
        'journey_date' => $departDate,
        'status' => 'On Time',
    ]);

    // Search for flights
    $response = $this->get(route('flight.search', [
        'from' => 'Delhi',
        'from_code' => 'DEL',
        'to' => 'Hyderabad',
        'to_code' => 'HYD',
        'depart' => $departDate,
        'adults' => 1,
        'children' => 0,
        'class' => 'Economy',
        'trip' => 'one-way',
    ]));

    $response->assertStatus(200);
    $response->assertViewIs('flightdetails');
    expect($response->original->getData()['flights']->count())->toBe(1);
});
