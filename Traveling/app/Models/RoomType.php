<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model  // ✅ no underscore
{
    protected $table = 'room_types'; // ✅ actual table name

    protected $fillable = ['name', 'description', 'status'];
}
