<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
    'flight_id',
    'name',
    'email',
    'phone',
    'travel_date',
    'adults',
    'children',
    'total_price'
];
}
