@extends('admin.master')

@section('content')

<div class="container mt-4">
    <div class="card shadow-lg border-0">
        
        <!-- HEADER -->
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Update Flight</h4>
        </div>

        <div class="card-body">

            {{-- SUCCESS --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
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

                <div class="row g-3">

                    <!-- Airline Name -->
                    <div class="col-md-6">
                        <label class="form-label">Airline Name</label>
                        <input type="text" name="airline_name" class="form-control"
                               value="{{ $flight->airline_name }}" required>
                    </div>

                    <!-- Flight Name -->
                    <div class="col-md-6">
                        <label class="form-label">Flight Name</label>
                        <input type="text" name="flight_name" class="form-control"
                               value="{{ $flight->flight_name }}">
                    </div>

                    <!-- Flight No -->
                    <div class="col-md-6">
                        <label class="form-label">Flight Number</label>
                        <input type="text" name="flight_no" class="form-control"
                               value="{{ $flight->flight_no }}" required>
                    </div>

                    <!-- Image -->
                    <div class="col-md-6">
                        <label class="form-label">Airline Image</label>
                        <input type="file" name="image" class="form-control">

                        {{-- OLD IMAGE PREVIEW --}}
                        @if($flight->image)
                            <div class="mt-2">
                                <img src="{{ asset('images/'.$flight->image) }}"
                                     style="width:80px;height:80px;object-fit:cover;border-radius:8px;">
                            </div>
                        @endif
                    </div>

                    <!-- From City -->
                    <div class="col-md-6">
                        <label class="form-label">From City</label>
                        <input type="text" name="from_city" class="form-control"
                               value="{{ $flight->from_city }}" required>
                    </div>

                    <!-- To City -->
                    <div class="col-md-6">
                        <label class="form-label">To City</label>
                        <input type="text" name="to_city" class="form-control"
                               value="{{ $flight->to_city }}" required>
                    </div>

                    <!-- Departure -->
                    <div class="col-md-6">
                        <label class="form-label">Departure Time</label>
                        <input type="time" name="departure_time" class="form-control"
                               value="{{ \Carbon\Carbon::parse($flight->departure_time)->format('H:i') }}" required>
                    </div>

                    <!-- Arrival -->
                    <div class="col-md-6">
                        <label class="form-label">Arrival Time</label>
                        <input type="time" name="arrival_time" class="form-control"
                               value="{{ \Carbon\Carbon::parse($flight->arrival_time)->format('H:i') }}" required>
                    </div>

                    <!-- Stops -->
                    <div class="col-md-6">
                        <label class="form-label">Stops</label>
                        <input type="text" name="stops" class="form-control"
                               value="{{ $flight->stops }}"
                               placeholder="Example: Non-stop / 1 Stop (Delhi)">
                    </div>

                    <!-- Price -->
                    <div class="col-md-6">
                        <label class="form-label">Price ($)</label>
                        <input type="number" name="price" step="0.01" class="form-control"
                               value="{{ $flight->price }}" required>
                    </div>

                </div>

                <!-- BUTTONS -->
                <div class="mt-4 d-flex justify-content-between">
                    <a href="{{ route('admin.viewflight') }}" class="btn btn-secondary px-4">Back</a>
                    <button type="submit" class="btn btn-success px-4">Update Flight</button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection