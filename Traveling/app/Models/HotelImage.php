<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelImage extends Model  // ✅ capital I
{
    protected $table = 'hotelimages'; // ✅ actual table name

    protected $fillable = ['hotel_id', 'image'];
}
