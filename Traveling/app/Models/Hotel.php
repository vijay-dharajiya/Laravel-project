<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
        'name', 'description', 'slug', 'city', 'state', 'country',
        'address', 'phone', 'email', 'star_rating', 'price_per_night',
        'total_rooms', 'wifi', 'parking', 'pool', 'gym',
        'restaurant', 'ac', 'thumbnail', 'status',
    ];

    public function images()
    {
        return $this->hasMany(HotelImage::class, 'hotel_id'); // ✅
    }

    public function rooms()
    {
        return $this->hasMany(Room::class, 'hotel_id'); // ✅
    }
}
