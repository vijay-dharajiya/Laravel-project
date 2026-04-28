@extends('admin.master')

@section('content')

<style>
.table-card{
    margin-top: 30px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    padding: 20px;
}

.hotel-img{
    width: 80px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
}

.badge-rating{
    background: #ffc107;
    color: #000;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 12px;
}

.action-btns a{
    margin-right: 5px;
}
</style>

<div class="container table-card">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Hotel List</h4>
        <a href="{{ route('admin.addhotel') }}" class="btn btn-primary">+ Add Hotel</a>
    </div>

    <div class="table-responsive">

        <table class="table table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Price/Night</th>
                    <th>Rating</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @foreach($hotels as $hotel)

                <tr>
                    <td>{{ $loop->iteration }}</td>

                    {{-- IMAGE --}}
                    <td>
                        <img src="hote_images/{{ $hotel->thumbnail }}" class="hotel-img">
                    </td>

                    {{-- NAME --}}
                    <td>
                        <strong>{{ $hotel->name }}</strong><br>
                        <small class="text-muted">{{ $hotel->city }}</small>
                    </td>

                    {{-- LOCATION --}}
                    <td>
                        {{ $hotel->city }}, {{ $hotel->state }}, {{ $hotel->country }}
                    </td>

                    {{-- PRICE --}}
                    <td>
                        ₹{{ number_format($hotel->price_per_night) }}
                    </td>

                    {{-- RATING --}}
                    <td>
                        <span class="badge-rating">
                            ⭐ {{ $hotel->star_rating ?? 'N/A' }}
                        </span>
                    </td>

                    {{-- STATUS --}}
                    <td>
                        @if($hotel->status == 'active')
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>

                    {{-- ACTIONS --}}
                    <td class="action-btns">

                        {{-- VIEW --}}
                        <a href="#" class="btn btn-sm btn-info">
                            View
                        </a>

                        {{-- EDIT --}}
                        <a href="#" class="btn btn-sm btn-warning">
                            Edit
                        </a>

                        {{-- DELETE --}}
                        <form action="#" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure?')">
                                Delete
                            </button>
                        </form>

                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="8" class="text-center">No hotels found</td>
                </tr>
                @endforelse

            </tbody>
        </table>

    </div>
</div>

@endsection