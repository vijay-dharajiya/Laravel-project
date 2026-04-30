<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomImage extends Model  // ✅ capital I
{
    protected $table    = 'roomimages'; // ✅ actual table name
    protected $fillable = ['hotel_id', 'room_id', 'image', 'is_primary', 'sort_order'];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id'); // ✅ added relationship
    }
}
