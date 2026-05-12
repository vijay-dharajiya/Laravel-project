<?php

use App\Models\Flight;
use App\Models\FlightBooking;
use App\Models\FlightClass;
use App\Models\User;

it('stores a flight booking when the user submits a valid booking', function () {
    $user = User::factory()->create();

    $flight = new Flight;
    $flight->airline_name = 'TestAir';
    $flight->airline_code = 'TA';
    $flight->flight_number = 'TA-101';
    $flight->aircraft_type = 'A320';
    $flight->airline_logo = null;
    $flight->from_city = 'Mumbai';
    $flight->from_airport = 'Chhatrapati Shivaji Maharaj International Airport';
    $flight->from_airport_code = 'BOM';
    $flight->to_city = 'Delhi';
    $flight->to_airport = 'Indira Gandhi International Airport';
    $flight->to_airport_code = 'DEL';
    $flight->departure_time = '09:00:00';
    $flight->arrival_time = '11:00:00';
    $flight->overnight_arrival = 0;
    $flight->stops = 0;
    $flight->stopover_cities = null;
    $flight->is_active = true;
    $flight->save();

    $flightClass = FlightClass::create([
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

    $this->actingAs($user)
        ->post(route('flightbooking', $flight->id), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'gender' => 'Male',
            'email' => 'john@example.com',
            'phone_number' => '+911234567890',
            'travel_date' => now()->toDateString(),
            'adults' => 1,
            'children' => 0,
            'trip_type' => 'One Way',
            'class_id' => $flightClass->id,
        ])
        ->assertRedirect(route('flight.details', $flight->id))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('flight_bookings', [
        'flight_id' => $flight->id,
        'passenger_id' => $user->id,
        'first_name' => 'John',
        'last_name' => 'Doe',
        'cabin_class' => 'Economy',
    ]);

    expect(FlightBooking::count())->toBe(1);

    $flightClass->refresh();
    expect($flightClass->available_seats)->toBe(49);
    expect($flightClass->booked_seats)->toBe(1);
});
