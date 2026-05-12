# Flight Search - Quick Reference Guide

## For Users

### How to Search for Flights

1. **Go to Home Page** (index.blade.php)
2. **Fill the Search Form:**
   - **From**: Select departure city/airport
   - **To**: Select destination city/airport
   - **Depart Date**: Select travel date
   - **Return Date**: (Optional, for round trips)
   - **Passengers**: Set number of adults and children
   - **Class**: Select cabin class (Economy, Premium Economy, Business, First)
   - **Trip Type**: One Way or Round Trip

3. **Click "Search Flights"**
   - System checks flights table for matching routes
   - System checks flight_schedule table for availability on selected date
   - Only shows flights with "Scheduled" or "On Time" status
   - Filters by available seats for requested class

4. **View Results** on Flight Details Page
   - See all matching flights
   - Use sidebar filters to narrow down:
     - By number of stops
     - By price range
     - By airline
   - Sort by: Price (↑/↓), Duration, or Stops
   - Use the top search form to change search criteria

5. **Click "View Details"** on a flight
   - Opens booking page with full flight details
   - Fill booking form with passenger information
   - Confirm booking

### Filters Available

| Filter | Options | Effect |
|--------|---------|--------|
| **Stops** | All/Non-stop/1 Stop/2+ Stops | Show only flights with selected stops |
| **Price** | Min - Max range slider | Show flights within price range |
| **Airlines** | Checkboxes | Show/hide specific airlines |

### Reset Search

- Click "Reset Filters" button to clear all filters and show all matching flights
- Use top search form to change From/To/Date and search again

---

## For Developers

### Key Implementation Files

| File | Purpose |
|------|---------|
| `app/Http/Controllers/UserController.php` | search() method - handles flight search |
| `app/Models/Flight.php` | Flight model with schedules relationship |
| `app/Models/FlightSchedule.php` | FlightSchedule model with status validation |
| `resources/views/flightdetails.blade.php` | Search results page |
| `resources/views/flightbooking.blade.php` | Booking page |
| `tests/Feature/FlightSearchWithScheduleTest.php` | Schedule validation tests |

### Search Algorithm

```php
// 1. Validate input parameters
$validated = $request->validate([...]);

// 2. Query flights with schedule validation
$flights = Flight::with(['flightClasses', 'schedules'])
    ->where('is_active', true)
    ->where('from_airport_code', $fromCode)
    ->where('to_airport_code', $toCode)
    ->whereHas('schedules', function ($q) use ($depart) {
        $q->whereDate('journey_date', '=', $depart)
          ->whereIn('status', ['Scheduled', 'On Time']);
    })
    ->orderBy('departure_time')
    ->get()
    ->filter(function ($flight) use ($class, $totalPax) {
        // Filter by available seats
        $cls = $flight->flightClasses->firstWhere('class_type', $class);
        return $cls && $cls->available_seats >= $totalPax;
    })
    ->values();

// 3. Handle no results
if ($flights->isEmpty()) {
    return back()->with('error', 'No flights available...');
}

// 4. Prepare data and return view
return view('flightdetails', [...]);
```

### Database Validation

**Important:** The search validates against TWO tables:

1. **flights table**: From/To airport codes, is_active flag
2. **flight_schedules table**: Journey date, status

A flight will only appear in results if:
- ✅ It's active (is_active = true)
- ✅ It has the correct from/to airports
- ✅ It has a schedule entry for the selected date
- ✅ The schedule status is "Scheduled" OR "On Time"
- ✅ It has available seats for the requested class

### Routes

```php
// Search results page
Route::get('/flights/search', [UserController::class, 'search'])
    ->name('flight.search');

// Booking page
Route::get('/flights/{id}', [UserController::class, 'flightdetails'])
    ->name('flight.details');

// Submit booking (authenticated)
Route::post('/flight_booking/{id}', [UserController::class, 'postflightbook'])
    ->name('flightbooking');

// Airport autocomplete (AJAX)
Route::get('/airports/search', [UserController::class, 'searchAirports'])
    ->name('airports.search');
```

### Testing

Run tests to verify functionality:

```bash
# Test flight search with schedule validation
php artisan test tests/Feature/FlightSearchWithScheduleTest.php --compact

# Test flight booking
php artisan test tests/Feature/FlightBookingTest.php --compact

# Run all tests
php artisan test --compact
```

### Adding/Modifying Flight Schedules

To make a flight available for search:

```php
// In Admin panel or via Artisan command
FlightSchedule::create([
    'flight_id' => $flight->id,
    'journey_date' => Carbon::parse('2026-05-10'),
    'status' => 'Scheduled', // or 'On Time'
]);
```

Acceptable statuses for search results:
- `Scheduled` ✅
- `On Time` ✅

Other statuses will be hidden:
- `Delayed`, `Cancelled`, `Boarding`, `Departed`, `Landed` ❌

### Troubleshooting

**Issue**: No flights showing in search results
- ✓ Check if flights table has records for those routes
- ✓ Check if flights are active (is_active = true)
- ✓ Check if flight_schedules table has entries for selected date
- ✓ Check if schedule status is "Scheduled" or "On Time"
- ✓ Check if selected date is in the future

**Issue**: Flight showing but can't book
- ✓ Check available_seats in flight_classes
- ✓ Check if passenger count exceeds available seats
- ✓ Check if selected class exists for that flight

**Issue**: Round trip showing only one direction
- ✓ Check if return flight schedule exists
- ✓ Check if return flight has same route (reversed)
- ✓ Check if return date is after depart date

### Performance Considerations

- Uses eager loading: `with(['flightClasses', 'schedules'])`
- Uses `whereHas()` for efficient relationship filtering
- Filters in-memory after fetching (acceptable for typical flight counts)
- Consider adding database indexes on:
  - `flight_schedules.journey_date`
  - `flight_schedules.status`
  - `flights.from_airport_code`
  - `flights.to_airport_code`

### Future Enhancements

- [ ] Cache frequently searched routes
- [ ] Add preferred airline preferences
- [ ] Store search history for users
- [ ] Add price alerts
- [ ] Implement real-time seat count updates
- [ ] Add layover duration filters
- [ ] Support multi-city searches

---

## API Reference

### GET /flights/search

**Required Parameters:**
```
from: string (3-letter airport code)
from_code: string (3-letter airport code)
to: string (city/airport name)
to_code: string (3-letter airport code)
depart: string (YYYY-MM-DD date, >= today)
adults: integer (1-9)
children: integer (0-8)
class: enum (Economy|Premium Economy|Business|First)
trip: enum (one-way|round)
```

**Optional Parameters:**
```
return: string (YYYY-MM-DD date, optional for round trips)
```

**Response:**
- ✓ 200: Returns flightdetails view with $flights collection
- ✗ Redirect: Back to form with error message if no flights found

### Example Request

```
GET /flights/search?
  from=Mumbai&
  from_code=BOM&
  to=Delhi&
  to_code=DEL&
  depart=2026-05-10&
  adults=2&
  children=0&
  class=Economy&
  trip=one-way
```

---

## Testing Checklist

- [x] Flight with schedule returns in search
- [x] Flight without schedule doesn't return
- [x] Cancelled flights filtered out
- [x] Only Scheduled/On Time flights shown
- [x] Seat availability validated
- [x] Round trip searches work
- [x] Error message shown when no flights found
- [x] Filters work on results page
- [x] Sort options work
- [x] Flight booking saves correctly
