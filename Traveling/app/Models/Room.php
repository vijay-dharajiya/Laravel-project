<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'hotel_id', 'room_type', 'capacity',
        'price', 'total_rooms', 'description', 'status'
    ];

    public function images()
    {
        // ✅ RoomImage capital I + correct import
        return $this->hasMany(RoomImage::class, 'room_id')
                    ->orderBy('sort_order');
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id'); // ✅
    }
}
