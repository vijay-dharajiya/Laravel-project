<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class FlightBooking extends Model
{
    // ─── Fillable Fields ──────────────────────────────────────────────────────
    protected $fillable = [
        // Booking Core
        'booking_id',
        'pnr_number',
        'booking_date',
        'booking_status',
        'trip_type',

        // Flight Information
        'flight_id',
        'flight_number',
        'airline_name',
        'origin_airport',
        'destination_airport',
        'departure_datetime',
        'arrival_datetime',
        'flight_duration',
        'cabin_class',

        // Passenger Details
        'passenger_id',
        'first_name',
        'last_name',
        'gender',
        'email',           // pre-filled from auth, but user can edit
        'phone_number',

        // Meta
        'check_in_status',
    ];

    // ─── Casts ────────────────────────────────────────────────────────────────
    protected $casts = [
        'booking_date'       => 'datetime',
        'departure_datetime' => 'datetime',
        'arrival_datetime'   => 'datetime',
        'created_at'         => 'datetime',
        'updated_at'         => 'datetime',
    ];

    // ─── Auto-generate booking_id & pnr_number on create ─────────────────────
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($booking) {

            // booking_id → BK + current year + 6 zero-padded random digits
            // e.g. BK2025004821
            do {
                $bookingId = 'BK' . date('Y') . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT);
            } while (self::where('booking_id', $bookingId)->exists()); // ensure unique

            $booking->booking_id = $bookingId;

            // pnr_number → 6 random uppercase letters + digits
            // e.g. A4XZ2B
            do {
                $pnr = strtoupper(Str::random(6));
            } while (self::where('pnr_number', $pnr)->exists()); // ensure unique

            $booking->pnr_number = $pnr;
        });
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    /**
     * The flight this booking belongs to.
     */
    public function flight(): BelongsTo
    {
        return $this->belongsTo(Flight::class);
    }

    /**
     * The passenger (user) who made this booking.
     */
    public function passenger(): BelongsTo
    {
        return $this->belongsTo(User::class, 'passenger_id');
    }

    // ─── Helper Methods ───────────────────────────────────────────────────────

    /**
     * Full name of the passenger.
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Flight duration formatted as "2h 15m" instead of raw minutes.
     */
    public function getFormattedDurationAttribute(): string
    {
        $hours   = intdiv($this->flight_duration, 60);
        $minutes = $this->flight_duration % 60;

        return "{$hours}h {$minutes}m";
    }

    /**
     * Check if booking can be cancelled
     * (only Pending or Confirmed bookings can be cancelled).
     */
    public function isCancellable(): bool
    {
        return in_array($this->booking_status, ['Pending', 'Confirmed']);
    }

    /**
     * Check if the flight is upcoming (departure is in the future).
     */
    public function isUpcoming(): bool
    {
        return $this->departure_datetime->isFuture();
    }
}