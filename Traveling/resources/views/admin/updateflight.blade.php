@extends('admin.master')

@section('content')

<div class="container mt-5" style="max-width:900px;">
    <h3 class="mb-4 fw-bold text-primary">✏️ Update Flight</h3>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

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

    <form action="{{ route('admin.posteditflight', $flight->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- ───── Airline Info ───── --}}
        <div class="card mb-4 p-3 shadow-sm">
            <h5 class="fw-bold mb-3">Airline Information</h5>

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label>Airline Name</label>
                    <input type="text" name="airline_name" class="form-control"
                           value="{{ $flight->airline_name }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Airline Code</label>
                    <input type="text" name="airline_code" class="form-control"
                           value="{{ $flight->airline_code }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Flight Number</label>
                    <input type="text" name="flight_number" class="form-control"
                           value="{{ $flight->flight_number }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Aircraft Type</label>
                    <input type="text" name="aircraft_type" class="form-control"
                           value="{{ $flight->aircraft_type }}">
                </div>

                <div class="col-md-12 mb-3">
                    <label>Airline Logo</label>
                    <input type="file" name="airline_logo" class="form-control">

                    {{-- OLD IMAGE --}}
                    @if($flight->airline_logo)
                        <div class="mt-2">
                            <img src="{{ asset($flight->airline_logo) }}"
                                 style="width:80px;height:80px;object-fit:cover;border-radius:8px;">
                        </div>
                    @endif
                </div>

            </div>
        </div>

        {{-- ───── Route ───── --}}
        <div class="card mb-4 p-3 shadow-sm">
            <h5 class="fw-bold mb-3">Route Information</h5>

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label>From City</label>
                    <input type="text" name="from_city" class="form-control"
                           value="{{ $flight->from_city }}" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>From Airport</label>
                    <input type="text" name="from_airport" class="form-control"
                           value="{{ $flight->from_airport }}" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Airport Code</label>
                    <input type="text" name="from_airport_code" class="form-control"
                           value="{{ $flight->from_airport_code }}" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>To City</label>
                    <input type="text" name="to_city" class="form-control"
                           value="{{ $flight->to_city }}" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>To Airport</label>
                    <input type="text" name="to_airport" class="form-control"
                           value="{{ $flight->to_airport }}" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Airport Code</label>
                    <input type="text" name="to_airport_code" class="form-control"
                           value="{{ $flight->to_airport_code }}" required>
                </div>

            </div>
        </div>

        {{-- ───── Timing ───── --}}
        <div class="card mb-4 p-3 shadow-sm">
            <h5 class="fw-bold mb-3">Flight Timing</h5>

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label>Departure Time</label>
                    <input type="time" name="departure_time" class="form-control"
                        value="{{ \Carbon\Carbon::parse($flight->departure_time)->format('H:i') }}" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Arrival Time</label>
                    <input type="time" name="arrival_time" class="form-control"
                        value="{{ \Carbon\Carbon::parse($flight->arrival_time)->format('H:i') }}" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Overnight Arrival</label>
                    <select name="overnight_arrival" class="form-control">
                        <option value="0" {{ $flight->overnight_arrival == 0 ? 'selected' : '' }}>No</option>
                        <option value="1" {{ $flight->overnight_arrival == 1 ? 'selected' : '' }}>Yes (+1 Day)</option>
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
                        <option value="0" {{ $flight->stops == 0 ? 'selected' : '' }}>Non-stop</option>
                        <option value="1" {{ $flight->stops == 1 ? 'selected' : '' }}>1 Stop</option>
                        <option value="2" {{ $flight->stops == 2 ? 'selected' : '' }}>2 Stops</option>
                    </select>
                </div>

                <div class="col-md-8 mb-3">
                    <label>Stopover Cities</label>
                    <input type="text" name="stopover_cities" class="form-control"
                        value="{{ $flight->stopover_cities ? implode(', ', json_decode($flight->stopover_cities)) : '' }}">
                </div>

            </div>
        </div>

        {{-- ───── Status ───── --}}
        <div class="card mb-4 p-3 shadow-sm">
            <h5 class="fw-bold mb-3">Status</h5>

            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_active" value="1"
                    {{ $flight->is_active ? 'checked' : '' }}>
                <label class="form-check-label">Active Flight</label>
            </div>
        </div>

        {{-- BUTTONS --}}
        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.viewflight') }}" class="btn btn-secondary px-4">Back</a>
            <button type="submit" class="btn btn-success px-4">Update Flight</button>
        </div>

    </form>
</div>

@endsection