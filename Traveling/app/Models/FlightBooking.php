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
        'booking_reference',
        'trip_type',
        'class',
        'depart_date',
        'return_date',
        'adults',
        'children',
        'grand_total',
        'status',

        // Outbound Flight
        'depart_flight_id',
        'depart_class_id',

        // Return Flight
        'return_flight_id',
        'return_class_id',

        // Primary Contact
        'contact_email',
        'contact_phone',

        // Passengers JSON
        'passengers',
    ];

    // ─── Casts ────────────────────────────────────────────────────────────────
    protected $casts = [
        'depart_date'  => 'date',
        'return_date'  => 'date',
        'grand_total'  => 'decimal:2',
        'passengers'   => 'array',   // auto encode/decode JSON
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
    ];

    // ─── Auto-generate booking_reference on create ────────────────────────────
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($booking) {
            // booking_reference → BK-2026-XXXXXX (6 random uppercase alphanumeric)
            do {
                $ref = 'BK-' . date('Y') . '-' . strtoupper(Str::random(6));
            } while (self::where('booking_reference', $ref)->exists());

            $booking->booking_reference = $ref;
        });
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    public function departFlight(): BelongsTo
    {
        return $this->belongsTo(Flight::class, 'depart_flight_id');
    }

    public function returnFlight(): BelongsTo
    {
        return $this->belongsTo(Flight::class, 'return_flight_id');
    }

    public function departClass(): BelongsTo
    {
        return $this->belongsTo(FlightClass::class, 'depart_class_id');
    }

    public function returnClass(): BelongsTo
    {
        return $this->belongsTo(FlightClass::class, 'return_class_id');
    }

    // ─── Helper Methods ───────────────────────────────────────────────────────

    /**
     * All passengers as a flat collection with their type label.
     */
    public function allPassengers(): array
    {
        return $this->passengers ?? [];
    }

    /**
     * Total passenger count (adults + children).
     */
    public function getTotalPassengersAttribute(): int
    {
        return (int) $this->adults + (int) $this->children;
    }

    /**
     * Whether the booking can still be cancelled.
     */
    public function isCancellable(): bool
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    /**
     * Whether the outbound flight is still upcoming.
     */
    public function isUpcoming(): bool
    {
        return $this->depart_date->isFuture();
    }
}