<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    // Inside Flight.php — add this method
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
