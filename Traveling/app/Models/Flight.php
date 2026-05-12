<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    protected $fillable = [
        'airline_name',
        'airline_code',
        'flight_number',
        'aircraft_type',
        'airline_logo',
        'from_city',
        'from_airport',
        'from_airport_code',
        'to_city',
        'to_airport',
        'to_airport_code',
        'departure_time',
        'arrival_time',
        'overnight_arrival',
        'stops',
        'stopover_cities',
        'is_active',
    ];

    public function flightClasses()
    {
        return $this->hasMany(FlightClass::class);
    }

    public function schedules()
    {
        return $this->hasMany(FlightSchedule::class);
    }

    public function classes()
    {
        return $this->hasMany(FlightClass::class);
    }
}
