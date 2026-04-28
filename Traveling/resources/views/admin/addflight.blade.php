@extends('admin.master')

@section('content')

<div class="container mt-4">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Add Flight</h4>
        </div>

        <div class="card-body">

            {{-- SUCCESS --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- VALIDATION ERRORS --}}
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

                <div class="row g-3">

                    {{-- Airline Name --}}
                    <div class="col-md-6">
                        <label class="form-label">Airline Name</label>
                        <input type="text" name="airline_name" class="form-control" required>
                    </div>

                    {{-- Flight Name --}}
                    <div class="col-md-6">
                        <label class="form-label">Flight Name</label>
                        <input type="text" name="flight_name" class="form-control">
                    </div>

                    {{-- Flight Number --}}
                    <div class="col-md-6">
                        <label class="form-label">Flight Number</label>
                        <input type="text" name="flight_no" class="form-control" required>
                    </div>

                    {{-- Image --}}
                    <div class="col-md-6">
                        <label class="form-label">Airline Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    {{-- From City --}}
                    <div class="col-md-6">
                        <label class="form-label">From City</label>
                        <input type="text" name="from_city" class="form-control" required>
                    </div>

                    {{-- To City --}}
                    <div class="col-md-6">
                        <label class="form-label">To City</label>
                        <input type="text" name="to_city" class="form-control" required>
                    </div>

                    {{-- Departure Time --}}
                    <div class="col-md-6">
                        <label class="form-label">Departure Time</label>
                        <input type="time" name="departure_time" class="form-control" required>
                    </div>

                    {{-- Arrival Time --}}
                    <div class="col-md-6">
                        <label class="form-label">Arrival Time</label>
                        <input type="time" name="arrival_time" class="form-control" required>
                    </div>

                    {{-- Stops (TEXT INPUT ✅) --}}
                    <div class="col-md-6">
                        <label class="form-label">Stops</label>
                        <input type="text" name="stops" class="form-control"
                               placeholder="Example: Non-stop / 1 Stop (Delhi)">
                    </div>

                    {{-- Price --}}
                    <div class="col-md-6">
                        <label class="form-label">Price ($)</label>
                        <input type="number" name="price" step="0.01" class="form-control" required>
                    </div>

                </div>

                {{-- BUTTONS --}}
                <div class="mt-4 d-flex justify-content-between">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary px-4">Back</a>
                    <button type="submit" class="btn btn-success px-4">Add Flight</button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection