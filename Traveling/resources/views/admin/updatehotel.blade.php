@extends('admin.master')

@section('content')

<div class="container mt-4">
    <div class="card shadow-lg border-0">
        
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">Update Hotel</h4>
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

            <form action="{{ route('admin.postedithotel', $hotel->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">

                    {{-- Hotel Name --}}
                    <div class="col-md-6">
                        <label class="form-label">Hotel Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $hotel->name }}" required>
                    </div>

                    {{-- Price --}}
                    <div class="col-md-6">
                        <label class="form-label">Price Per Night</label>
                        <input type="number" name="price_per_night" class="form-control" value="{{ $hotel->price_per_night }}" required>
                    </div>

                    {{-- City --}}
                    <div class="col-md-4">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control" value="{{ $hotel->city }}" required>
                    </div>

                    {{-- State --}}
                    <div class="col-md-4">
                        <label class="form-label">State</label>
                        <input type="text" name="state" class="form-control" value="{{ $hotel->state }}">
                    </div>

                    {{-- Country --}}
                    <div class="col-md-4">
                        <label class="form-label">Country</label>
                        <input type="text" name="country" class="form-control" value="{{ $hotel->country }}">
                    </div>

                    {{-- Address --}}
                    <div class="col-md-12">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control">{{ $hotel->address }}</textarea>
                    </div>

                    {{-- Latitude --}}
                    <div class="col-md-6">
                        <label class="form-label">Latitude</label>
                        <input type="text" name="latitude" class="form-control" value="{{ $hotel->latitude }}">
                    </div>

                    {{-- Longitude --}}
                    <div class="col-md-6">
                        <label class="form-label">Longitude</label>
                        <input type="text" name="longitude" class="form-control" value="{{ $hotel->longitude }}">
                    </div>

                    {{-- Phone --}}
                    <div class="col-md-4">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ $hotel->phone }}">
                    </div>

                    {{-- Email --}}
                    <div class="col-md-4">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $hotel->email }}">
                    </div>

                    {{-- Website --}}
                    <div class="col-md-4">
                        <label class="form-label">Website</label>
                        <input type="text" name="website" class="form-control" value="{{ $hotel->website }}">
                    </div>

                    {{-- Star Rating --}}
                    <div class="col-md-4">
                        <label class="form-label">Star Rating</label>
                        <select name="star_rating" class="form-control">
                            <option value="">Select</option>
                            @for($i=1; $i<=5; $i++)
                                <option value="{{ $i }}" {{ $hotel->star_rating == $i ? 'selected' : '' }}>
                                    {{ $i }} Star
                                </option>
                            @endfor
                        </select>
                    </div>

                    {{-- Total Rooms --}}
                    <div class="col-md-4">
                        <label class="form-label">Total Rooms</label>
                        <input type="number" name="total_rooms" class="form-control" value="{{ $hotel->total_rooms }}">
                    </div>

                    {{-- Status --}}
                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="active" {{ $hotel->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $hotel->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    {{-- Facilities --}}
                    <div class="col-md-12">
                        <label class="form-label">Facilities</label><br>

                        <input type="checkbox" name="wifi" value="1" {{ $hotel->wifi ? 'checked' : '' }}> Wifi
                        <input type="checkbox" name="parking" value="1" {{ $hotel->parking ? 'checked' : '' }}> Parking
                        <input type="checkbox" name="pool" value="1" {{ $hotel->pool ? 'checked' : '' }}> Pool
                        <input type="checkbox" name="gym" value="1" {{ $hotel->gym ? 'checked' : '' }}> Gym
                        <input type="checkbox" name="restaurant" value="1" {{ $hotel->restaurant ? 'checked' : '' }}> Restaurant
                        <input type="checkbox" name="ac" value="1" {{ $hotel->ac ? 'checked' : '' }}> AC
                    </div>

                    {{-- Description --}}
                    <div class="col-md-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control">{{ $hotel->description }}</textarea>
                    </div>

                    {{-- IMAGE --}}
                    <div class="col-md-12">
                        <label class="form-label">Thumbnail Image</label>

                        <div class="mb-2">
                            <img src="{{ asset('hotel_images/'.$hotel->thumbnail) }}" width="120" class="rounded shadow">
                        </div>

                        <input type="file" name="thumbnail" class="form-control">
                        <small class="text-muted">Leave blank if you don’t want to change image</small>
                    </div>

                </div>

                {{-- BUTTONS --}}
                <div class="mt-4 d-flex justify-content-between">
                    <a href="{{ route('admin.viewhotel') }}" class="btn btn-secondary px-4">Back</a>
                    <button type="submit" class="btn btn-warning px-4">Update Hotel</button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection