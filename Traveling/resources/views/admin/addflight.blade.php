@extends('admin.master')

@section('content')

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Add Flight</h4>
        </div>

        <div class="card-body">

            {{-- SUCCESS MESSAGE --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- FORM START --}}
            <form action="{{ route('admin.postaddflight') }}" method="POST">
                @csrf

                <div class="row">

                    {{-- Airline Name --}}
                    <div class="col-md-6 mb-3">
                        <label>Airline Name</label>
                        <input type="text" name="airline_name" class="form-control" required>
                    </div>
                    
                    {{--Airline Image--}}
                    <div class="col-md-6 mb-3">
                        <label>Airline Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    {{-- From City --}}
                    <div class="col-md-6 mb-3">
                        <label>From City</label>
                        <input type="text" name="from_city" class="form-control" required>
                    </div>

                    {{-- To City --}}
                    <div class="col-md-6 mb-3">
                        <label>To City</label>
                        <input type="text" name="to_city" class="form-control" required>
                    </div>

                    {{-- Departure Time --}}
                    <div class="col-md-6 mb-3">
                        <label>Departure Time</label>
                        <input type="time" name="departure_time" class="form-control" required>
                    </div>

                    {{-- Arrival Time --}}
                    <div class="col-md-6 mb-3">
                        <label>Arrival Time</label>
                        <input type="time" name="arrival_time" class="form-control" required>
                    </div>

                    {{-- Price --}}
                    <div class="col-md-6 mb-3">
                        <label>Price</label>
                        <input type="number" name="price" step="0.01" class="form-control" required>
                    </div>

                </div>

                {{-- SUBMIT BUTTON --}}
                <button type="submit" class="btn btn-success">
                    Add Flight
                </button>

                <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                    Back
                </a>

            </form>
            {{-- FORM END --}}

        </div>
    </div>
</div>

@endsection