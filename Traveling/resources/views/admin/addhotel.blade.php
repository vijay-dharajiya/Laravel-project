@extends('admin.master')

@section('content')

<div class="container mt-4">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Add Hotel</h4>
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

            <form action="{{ route ('admin.hotelstore') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">

                    {{-- Hotel Name --}}
                    <div class="col-md-6">
                        <label class="form-label">Hotel Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    {{-- Price --}}
                    <div class="col-md-6">
                        <label class="form-label">Price Per Night</label>
                        <input type="number" name="price_per_night" class="form-control" required>
                    </div>

                    {{-- City --}}
                    <div class="col-md-4">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control" required>
                    </div>

                    {{-- State --}}
                    <div class="col-md-4">
                        <label class="form-label">State</label>
                        <input type="text" name="state" class="form-control">
                    </div>

                    {{-- Country --}}
                    <div class="col-md-4">
                        <label class="form-label">Country</label>
                        <input type="text" name="country" class="form-control" value="India">
                    </div>

                    {{-- Address --}}
                    <div class="col-md-12">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control"></textarea>
                    </div>

                    {{-- Latitude --}}
                    <div class="col-md-6">
                        <label class="form-label">Latitude</label>
                        <input type="text" name="latitude" class="form-control">
                    </div>

                    {{-- Longitude --}}
                    <div class="col-md-6">
                        <label class="form-label">Longitude</label>
                        <input type="text" name="longitude" class="form-control">
                    </div>

                    {{-- Phone --}}
                    <div class="col-md-4">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control">
                    </div>

                    {{-- Email --}}
                    <div class="col-md-4">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>

                    {{-- Website --}}
                    <div class="col-md-4">
                        <label class="form-label">Website</label>
                        <input type="url" name="website" class="form-control" placeholder="https://example.com">
                    </div>

                    {{-- Star Rating --}}
                    <div class="col-md-4">
                        <label class="form-label">Star Rating</label>
                        <select name="star_rating" class="form-control">
                            <option value="">Select</option>
                            <option value="1">1 Star</option>
                            <option value="2">2 Star</option>
                            <option value="3">3 Star</option>
                            <option value="4">4 Star</option>
                            <option value="5">5 Star</option>
                        </select>
                    </div>

                    {{-- Total Rooms --}}
                    <div class="col-md-4">
                        <label class="form-label">Total Rooms</label>
                        <input type="number" name="total_rooms" class="form-control">
                    </div>

                    {{-- Status --}}
                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    {{-- Facilities --}}
                    <div class="col-md-12">
                        <label class="form-label">Facilities</label><br>

                        <input type="checkbox" name="wifi" value="1"> Wifi
                        <input type="checkbox" name="parking" value="1"> Parking
                        <input type="checkbox" name="pool" value="1"> Pool
                        <input type="checkbox" name="gym" value="1"> Gym
                        <input type="checkbox" name="restaurant" value="1"> Restaurant
                        <input type="checkbox" name="ac" value="1" checked> AC
                    </div>

                    {{-- Description --}}
                    <div class="col-md-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>

                    {{-- Thumbnail --}}
                    <div class="col-md-12">
                        <label class="form-label">Thumbnail Image</label>
                        <input type="file" name="thumbnail" class="form-control">
                    </div>

                </div>

                {{-- BUTTONS --}}
                <div class="mt-4 d-flex justify-content-between">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary px-4">Back</a>
                    <button type="submit" class="btn btn-success px-4">Add Hotel</button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection