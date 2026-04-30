@extends('admin.master')

@section('content')

<style>
.page-title{
    font-weight: 700;
    margin-bottom: 0;
}

.table-card{
    margin-top: 25px;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.06);
    padding: 20px;
}

/* TABLE STYLE */
.table thead{
    background: linear-gradient(135deg, #1e3c72, #2a5298);
    color: #fff;
}

.table tbody tr{
    transition: 0.2s ease-in-out;
}

.table tbody tr:hover{
    background: #f6f9ff;
    transform: scale(1.01);
}

/* IMAGE */
.hotel-img{
    width: 85px;
    height: 65px;
    object-fit: cover;
    border-radius: 10px;
    border: 2px solid #eee;
}

/* BADGE */
.badge-rating{
    background: #ffb703;
    color: #fdfefc;
    font-weight: 600;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
}

/* BUTTONS */
.btn-sm{
    border-radius: 8px;
    font-size: 12px;
    padding: 5px 10px;
}

.action-btns a,
.action-btns button{
    margin-right: 5px;
}

/* HEADER BOX */
.top-bar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom: 15px;
}

.top-bar a{
    border-radius: 10px;
    padding: 8px 15px;
    font-weight: 500;
}

</style>

<div class="container table-card">

    {{-- HEADER --}}
    <div class="top-bar">
        <div>
            <h4 class="page-title">🏨 Hotel Management</h4>
            <small class="text-muted">Manage all hotel listings easily</small>
        </div>

        <a href="{{ route('admin.addhotel') }}" class="btn btn-primary">
            + Add New Hotel
        </a>
    </div>

    {{-- TABLE --}}
    <div class="table-responsive">

        <table class="table table-hover align-middle">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Hotel</th>
                    <th>Location</th>
                    <th>Price / Night</th>
                    <th>Rating</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($hotels as $hotel)

                <tr>

                    {{-- NO --}}
                    <td>{{ $loop->iteration }}</td>

                    {{-- HOTEL INFO --}}
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('hotel_images/'.$hotel->thumbnail) }}" class="hotel-img mx-3">
                            <div>
                                <strong>{{ $hotel->name }}</strong><br>
                                <small class="text-muted">{{ $hotel->city }}</small>
                            </div>
                        </div>
                    </td>

                    {{-- LOCATION --}}
                    <td>
                        {{ $hotel->city }}<br>
                        <small class="text-muted">
                            {{ $hotel->state }}, {{ $hotel->country }}
                        </small>
                    </td>

                    {{-- PRICE --}}
                    <td>
                        <strong>₹{{ number_format($hotel->price_per_night) }}</strong>
                    </td>

                    {{-- RATING --}}
                    <td>
                        <span class="badge-rating">
                            {{ $hotel->star_rating ?? 'N/A' }}⭐
                        </span>
                    </td>

                    {{-- STATUS --}}
                    <td>
                        @if($hotel->status == 'active')
                            <span class="badge bg-success px-3 py-2 text-white">Active</span>
                        @else
                            <span class="badge bg-danger px-3 py-2 text-white">Inactive</span>
                        @endif
                    </td>

                    {{-- ACTIONS --}}
                    <td class="text-center action-btns">


                        <a href="{{ route('admin.edithotel', $hotel->id) }}" class="btn btn-sm btn-warning text-white">
                            Edit
                        </a>

                        <form action="{{ route('admin.deletehotel', $hotel->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure you want to delete this hotel?')">
                                Delete
                            </button>
                        </form>

                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        No hotels found 😕
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>

    </div>
</div>

@endsection