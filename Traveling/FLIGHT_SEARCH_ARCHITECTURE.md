# Flight Search Architecture

## Search Flow Diagram

```
┌─────────────────────────────────────────────────────────────────┐
│                    INDEX PAGE (index.blade.php)                  │
│                                                                   │
│  ┌──────────────────────────────────────────────────────────┐   │
│  │        Flight Search Form                                │   │
│  │  ┌─────────────────────────────────────────────────────┐ │   │
│  │  │ From: [____________]  To: [____________]            │ │   │
│  │  │ Date: [____________]  Return: [____________]        │ │   │
│  │  │ Passengers: Adults [_] Children [_]               │ │   │
│  │  │ Class: [Economy ▼]                                │ │   │
│  │  │ [ SEARCH FLIGHTS ]                                │ │   │
│  │  └─────────────────────────────────────────────────────┘ │   │
│  └──────────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────────┘
                              ↓
                       Click Search Button
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│        UserController::search() - Validation Layer               │
│                                                                   │
│  1. Validate Input ─────────────────────────────────────────┐   │
│     • from, to, dates, passengers, class                   │   │
│     • Must be valid airport codes & dates                  │   │
│                                                             │   │
│  2. Query Flights Table ────────────────────────────────────┤   │
│     WHERE:                                                  │   │
│     • is_active = true                                     │   │
│     • from_airport_code = 'BOM'                            │   │
│     • to_airport_code = 'DEL'                              │   │
│                                                             │   │
│  3. Check Flight Schedules ────────────────────────────────┤   │
│     WHEREHAS flight_schedules:                              │   │
│     • journey_date = '2026-05-10'                          │   │
│     • status IN ('Scheduled', 'On Time')                   │   │
│                                                             │   │
│  4. Filter by Availability ────────────────────────────────┤   │
│     • available_seats >= total passengers                  │   │
│     • For requested class (Economy/Business/etc)           │   │
│                                                             │   │
│  5. Prepare Data ──────────────────────────────────────────┤   │
│     • Calculate departure/arrival times                    │   │
│     • Check overnight arrival                              │   │
│     • Parse stopover cities                                │   │
│                                                             │   │
│  6. Return Results ────────────────────────────────────────┤   │
│     ✓ Matching flights                                     │   │
│     ✓ Search parameters                                    │   │
│     ✓ Total passengers count                               │   │
│     ✗ No flights → Error message                           │   │
└─────────────────────────────────────────────────────────────────┘
                              ↓
                 Return to view (flightdetails)
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│            FLIGHT DETAILS PAGE (flightdetails.blade.php)         │
│                                                                   │
│  ┌──────────────────────────────────────────────────────────┐   │
│  │         Search Form (Sticky Header)                      │   │
│  │  From [_______] To [_______] Date [_______] [SEARCH]    │   │
│  └──────────────────────────────────────────────────────────┘   │
│                                                                   │
│  ┌──────────────────┐  ┌───────────────────────────────────┐    │
│  │    FILTERS       │  │      FLIGHT RESULTS               │    │
│  ├──────────────────┤  ├───────────────────────────────────┤    │
│  │ Stops:           │  │  Found: 5 flights                 │    │
│  │ ☑ All Flights(5) │  │  Sort by: [Price ▼]              │    │
│  │ ☐ Non-stop    (2)│  │                                   │    │
│  │ ☐ 1 Stop      (2)│  │  ┌─────────────────────────────┐  │    │
│  │ ☐ 2+ Stops    (1)│  │  │ ✈ TestAir TA-101            │  │    │
│  │                  │  │  │ BOM 09:00 → DEL 11:00 (2h)  │  │    │
│  │ Price Range:     │  │  │ Non-stop | ₹1,100           │  │    │
│  │ Min: [___]       │  │  │ [ View Details ]             │  │    │
│  │ Max: [___]       │  │  └─────────────────────────────┘  │    │
│  │                  │  │                                   │    │
│  │ Airlines:        │  │  ┌─────────────────────────────┐  │    │
│  │ ☑ TestAir (5)    │  │  │ ✈ AirIndia AI-205           │  │    │
│  │ ☑ IndiGo IG-150  │  │  │ BOM 14:00 → DEL 16:30 (2h)  │  │    │
│  │                  │  │  │ 1 Stop via LKO | ₹950       │  │    │
│  │ [Reset Filters]  │  │  │ [ View Details ]             │  │    │
│  │                  │  │  └─────────────────────────────┘  │    │
│  │                  │  │                                   │    │
│  │                  │  │  ... more flights ...             │    │
│  └──────────────────┘  └───────────────────────────────────┘    │
│                                                                   │
└─────────────────────────────────────────────────────────────────┘
                              ↓
                         Click Flight Card
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│         BOOKING PAGE (flightbooking.blade.php)                   │
│                                                                   │
│  ┌──────────────────────────────────────────────────────────┐   │
│  │  Flight: TestAir TA-101                                  │   │
│  │  BOM 09:00 → DEL 11:00 (Non-stop, 2h)                  │   │
│  │  Available: 45 seats | Price: ₹1,100/person             │   │
│  └──────────────────────────────────────────────────────────┘   │
│                                                                   │
│  ┌──────────────────────────────────────────────────────────┐   │
│  │  Booking Form:                                           │   │
│  │  Name: [_________]  Gender: [Male ▼]                    │   │
│  │  Email: [_________]  Phone: [_________]                 │   │
│  │  Adults: [1]  Children: [0]                             │   │
│  │  Class: [Economy ▼]                                     │   │
│  │  [ CONFIRM BOOKING ]                                    │   │
│  └──────────────────────────────────────────────────────────┘   │
│                                                                   │
└─────────────────────────────────────────────────────────────────┘
                              ↓
                         Submit Booking
                              ↓
                    Booking Confirmed ✓
```

## Database Query Structure

```sql
-- Pseudo-SQL of what the search() method executes:

SELECT flights.*, flight_classes.*
FROM flights
INNER JOIN flight_schedules 
  ON flights.id = flight_schedules.flight_id
WHERE
  flights.is_active = true
  AND flights.from_airport_code = 'BOM'
  AND flights.to_airport_code = 'DEL'
  AND flight_schedules.journey_date = '2026-05-10'
  AND flight_schedules.status IN ('Scheduled', 'On Time')
  AND flight_classes.class_type = 'Economy'
  AND flight_classes.available_seats >= 2
ORDER BY flights.departure_time ASC;
```

## Key Relationships

```
flights (1) ──→ (many) flight_classes
   │                        ├─ class_type: Economy, Business, First
   │                        ├─ available_seats
   │                        ├─ total_price
   │                        └─ baggage info
   │
   └─→ (many) flight_schedules
            ├─ journey_date: 2026-05-10
            ├─ status: Scheduled, On Time, Delayed, Cancelled
            └─ (other schedule info)
```

## Validation Steps

```
Input from Form
     ↓
validate([from, to, dates, passengers, class])
     ↓
Check flights.from_airport_code
     ↓
Check flights.to_airport_code
     ↓
Check flight_schedules.journey_date
     ↓
Check flight_schedules.status
     ↓
Check flight_classes.available_seats >= passengers
     ↓
Filter by class type
     ↓
Return matching flights OR error message
```

## Status Filtering Logic

```
Flight Schedule Status
     │
     ├─ Scheduled ──────→ ✅ SHOW in results
     │
     ├─ On Time ────────→ ✅ SHOW in results
     │
     ├─ Delayed ────────→ ❌ HIDE from results
     │
     ├─ Cancelled ──────→ ❌ HIDE from results
     │
     ├─ Boarding ───────→ ❌ HIDE from results
     │
     ├─ Departed ───────→ ❌ HIDE from results
     │
     └─ Landed ────────→ ❌ HIDE from results
```

## Round Trip Search

```
Outbound Search:
  FROM: Mumbai (BOM)
  TO: Delhi (DEL)
  DATE: 2026-05-10
  ✓ Returns matching flights

Return Search:
  FROM: Delhi (DEL)      ← Reversed
  TO: Mumbai (BOM)       ← Reversed
  DATE: 2026-05-12       ← Return date
  ✓ Returns matching return flights

Both shown on flightdetails.blade.php
```
