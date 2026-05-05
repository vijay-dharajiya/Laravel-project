<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class FlightSchedule extends Model
{
    protected $table = 'flight_schedules';

    protected $fillable = [
        'flight_id',
        'journey_date',
        'status',
    ];

    protected $casts = [
        'journey_date' => 'date',
    ];

    // ─── Relationship → belongs to Flight ────────────────────────────
    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

    // ─── Check if this date is still bookable ─────────────────────────
    public function isBookable(): bool
    {
        return in_array($this->status, ['Scheduled', 'On Time'])
            && $this->journey_date->isFuture();
    }

    // ─── Check if date is in past ──────────────────────────────────────
    public function isPast(): bool
    {
        return $this->journey_date->isPast();
    }

    // ─── Status badge color for UI ────────────────────────────────────
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'Scheduled' => 'primary',
            'On Time'   => 'success',
            'Delayed'   => 'warning',
            'Cancelled' => 'danger',
            'Boarding'  => 'info',
            'Departed'  => 'secondary',
            'Landed'    => 'dark',
            default     => 'secondary',
        };
    }

    // ─── Formatted date for display ───────────────────────────────────
    public function getFormattedDateAttribute(): string
    {
        return $this->journey_date->format('D, d M Y'); // Mon, 01 Jun 2025
    }
}