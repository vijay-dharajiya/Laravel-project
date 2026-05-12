<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlightClass extends Model
{
    protected $table = 'flight_classes';

    protected $fillable = [
        'flight_id',
        'class_type',

        // Seats
        'total_seats',
        'available_seats',
        'booked_seats',

        // Pricing
        'base_price',
        'tax',
        'total_price',
        'currency',

        // Baggage
        'cabin_baggage_kg',
        'checkin_baggage_kg',

        // Refund
        'is_refundable',
        'cancellation_charge',
    ];

    protected $casts = [
        'is_refundable' => 'boolean',
        'base_price' => 'float',
        'tax' => 'float',
        'total_price' => 'float',
        'cancellation_charge' => 'float',
    ];

    // ─── Relationship → belongs to Flight ────────────────────────────
    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

    // ─── Available seats accessor (safety fallback) ───────────────────
    // Even though we store available_seats in DB,
    // this accessor acts as a double-check
    public function getRemainingSeatsAttribute(): int
    {
        return $this->total_seats - $this->booked_seats;
    }

    // ─── Check if seats are available before booking ──────────────────
    public function hasSeats(int $requested = 1): bool
    {
        return $this->available_seats >= $requested;
    }

    // ─── Called when user books seats ─────────────────────────────────
    public function bookSeats(int $count): void
    {
        $this->decrement('available_seats', $count);
        $this->increment('booked_seats', $count);
    }

    // ─── Called when user cancels booking ─────────────────────────────
    public function cancelSeats(int $count): void
    {
        $this->increment('available_seats', $count);
        $this->decrement('booked_seats', $count);
    }

    // ─── Seat fill percentage (useful for frontend progress bar) ──────
    public function getFillPercentageAttribute(): int
    {
        if ($this->total_seats === 0) {
            return 0;
        }

        return (int) round(($this->booked_seats / $this->total_seats) * 100);
    }

    // ─── Class color for UI badges ────────────────────────────────────
    public function getClassColorAttribute(): string
    {
        return match ($this->class_type) {
            'Economy' => 'success',
            'Premium Economy' => 'info',
            'Business' => 'warning',
            'First' => 'danger',
            default => 'secondary',
        };
    }
}
