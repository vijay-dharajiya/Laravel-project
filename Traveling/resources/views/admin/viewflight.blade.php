@extends('admin.master')

@section('content')

<div class="container mt-4">
    <div class="card shadow">
        
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Flight List</h4>
            <a href="{{ route('admin.addflight') }}" class="btn btn-light btn-sm">
                + Add Flight
            </a>
        </div>

        <div class="card-body">

            {{-- SUCCESS MESSAGE --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- TABLE --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Airline Name</th>
                            <th>Image</th>
                            <th>From City</th>
                            <th>To City</th>
                            <th>Departure</th>
                            <th>Arrival</th>
                            <th>Price</th>
                            <th colspan="2">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($flights as $flight)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $flight->airline_name }}</td>
                                <td>
                                    @if($flight->image)
                                        <img src="{{ asset('images/' . $flight->image) }}" alt="Flight Image" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                                    @else
                                        <span>No Image</span>
                                    @endif
                                </td>
                                <td>{{ $flight->from_city }}</td>
                                <td>{{ $flight->to_city }}</td>

                                <td>
                                    {{ \Carbon\Carbon::parse($flight->departure_time)->format('h:i A') }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($flight->arrival_time)->format('h:i A') }}
                                </td>

                                <td>₹{{ $flight->price }}</td>

                                <td>
                                    <a href="{{ route('admin.editflight', $flight->id) }}" 
                                       class="btn btn-sm btn-primary">
                                       Edit
                                    </a>
                                </td>

                                <td>
                                    <a href="{{ route('admin.deleteflight', $flight->id) }}" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Are you sure you want to delete this flight?')">
                                       Delete
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">No Flights Found</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <a href="{{ route('dashboard') }}" class="btn btn-secondary mt-2">
                Back
            </a>

        </div>
    </div>
</div>

@endsection