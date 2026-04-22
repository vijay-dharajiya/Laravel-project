@extends('admin.master')

@section('content')

<div class="container mt-4">
    <div class="card shadow">

        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Add Hotel</h4>
        </div>

        <div class="card-body">

            {{-- SUCCESS MESSAGE --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ERROR MESSAGE --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.postaddhotel') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    {{-- HOTEL NAME --}}
                    <div class="col-md-6 mb-3">
                        <label>Hotel Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter hotel name" required>
                    </div>

                    {{-- CITY --}}
                    <div class="col-md-6 mb-3">
                        <label>City</label>
                        <input type="text" name="city" class="form-control" placeholder="Enter city" required>
                    </div>

                    {{-- PRICE --}}
                    <div class="col-md-6 mb-3">
                        <label>Price Per Night</label>
                        <input type="number" name="price_per_night" class="form-control" placeholder="Enter price" required>
                    </div>

                    {{-- IMAGE --}}
                    <div class="col-md-6 mb-3">
                        <label>Hotel Image</label>
                        <input type="file" name="image" class="form-control" required>
                    </div>

                    {{-- DESCRIPTION --}}
                    <div class="col-md-12 mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Enter hotel description"></textarea>
                    </div>

                </div>

                {{-- BUTTONS --}}
                <div class="text-end">
                    <a href="{{route('dashboard') }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-success">Add Hotel</button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection