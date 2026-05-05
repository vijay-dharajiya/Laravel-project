@extends('admin.master')

@section('content')

<div class="container mt-5" style="max-width:900px;">
    <h3 class="mb-4 fw-bold text-primary">✈️ Add New Flight</h3>
    {{-- ERRORS --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.postaddflight') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- ───── Airline Info ───── --}}
        <div class="card mb-4 p-3 shadow-sm">
            <h5 class="fw-bold mb-3">Airline Information</h5>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Airline Name</label>
                    <input type="text" name="airline_name" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Airline Code</label>
                    <input type="text" name="airline_code" class="form-control" placeholder="AI, 6E" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Flight Number</label>
                    <input type="text" name="flight_number" class="form-control" placeholder="AI-202" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Aircraft Type</label>
                    <input type="text" name="aircraft_type" class="form-control" placeholder="Boeing 737">
                </div>

                <div class="col-md-12 mb-3">
                    <label>Airline Logo</label>
                    <input type="file" name="airline_logo" class="form-control">
                </div>
            </div>
        </div>

        {{-- ───── Route ───── --}}
        <div class="card mb-4 p-3 shadow-sm">
            <h5 class="fw-bold mb-3">Route Information</h5>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>From City</label>
                    <input type="text" name="from_city" class="form-control" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>From Airport</label>
                    <input type="text" name="from_airport" class="form-control" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Airport Code</label>
                    <input type="text" name="from_airport_code" class="form-control" placeholder="AMD" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>To City</label>
                    <input type="text" name="to_city" class="form-control" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>To Airport</label>
                    <input type="text" name="to_airport" class="form-control" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Airport Code</label>
                    <input type="text" name="to_airport_code" class="form-control" placeholder="DEL" required>
                </div>
            </div>
        </div>

        {{-- ───── Timing ───── --}}
        <div class="card mb-4 p-3 shadow-sm">
            <h5 class="fw-bold mb-3">Flight Timing</h5>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Departure Time</label>
                    <input type="time" name="departure_time" class="form-control" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Arrival Time</label>
                    <input type="time" name="arrival_time" class="form-control" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Overnight Arrival</label>
                    <select name="overnight_arrival" class="form-control">
                        <option value="0">No</option>
                        <option value="1">Yes (+1 Day)</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- ───── Stops ───── --}}
        <div class="card mb-4 p-3 shadow-sm">
            <h5 class="fw-bold mb-3">Stops</h5>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Number of Stops</label>
                    <select name="stops" class="form-control">
                        <option value="0">Non-stop</option>
                        <option value="1">1 Stop</option>
                        <option value="2">2 Stops</option>
                    </select>
                </div>

                <div class="col-md-8 mb-3">
                    <label>Stopover Cities (comma separated)</label>
                    <input type="text" name="stopover_cities" class="form-control" placeholder="Delhi, Dubai">
                </div>
            </div>
        </div>

        {{-- ───── Status ───── --}}
        <div class="card mb-4 p-3 shadow-sm">
            <h5 class="fw-bold mb-3">Status</h5>

            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                <label class="form-check-label">Active Flight</label>
            </div>
        </div>

        {{-- Submit --}}
        <div class="text-end">
            <button class="btn btn-primary px-4">Save Flight</button>
        </div>

    </form>
</div>

@endsection