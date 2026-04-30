@extends('header')

@section('home')

{{-- Swiper CDN --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<style>
.page-wrapper { margin-top: 100px; }

/* HERO */
.hotel-hero {
    height: 350px;
    border-radius: 20px;
    position: relative;
    overflow: hidden;
    margin-bottom: 30px;
}
.hotel-hero img { width: 100%; height: 100%; object-fit: cover; }

.hotel-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(0,0,0,0.7), rgba(0,0,0,0.4));
}
.hotel-content { position: absolute; bottom: 20px; left: 30px; color: #fff; }

/* HOTEL SLIDER */
.slider-img {
    width: 100%;
    height: 420px;
    object-fit: contain;
    background: #fff;
    border-radius: 15px;
}

/* ROOM CARD */
.room-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    transition: 0.3s;
    overflow: hidden;
}
.room-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

/* ROOM SLIDER */
.room-slider-img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.room-badge {
    position: absolute;
    top: 15px;
    left: 15px;
    background: linear-gradient(135deg, #007bff, #00c6ff);
    color: #fff;
    padding: 5px 12px;
    font-size: 12px;
    border-radius: 20px;
    z-index: 10;
}

.room-price { font-weight: 700; color: #28a745; }

.btn-main {
    background: linear-gradient(135deg, #ff7e00, #ffb347);
    color: #fff;
    border: none;
    border-radius: 25px;
}

/* Room swiper nav buttons smaller */
.room-swiper .swiper-button-next,
.room-swiper .swiper-button-prev {
    color: #ff7e00;
    transform: scale(0.6);
}
.room-swiper .swiper-pagination-bullet-active {
    background: #ff7e00;
}
</style>

@php
    $firstImage = $hotel->images->first();
@endphp

<div class="container page-wrapper">

    {{-- 🔥 HERO (FIRST HOTEL IMAGE) --}}
    @if($firstImage)
    <div class="hotel-hero">
        <img src="{{ asset('hotel_images/' . $firstImage->image) }}">
        <div class="hotel-overlay"></div>
        <div class="hotel-content">
            <h2>{{ $hotel->name }}</h2>
            <p class="mb-1">{{ $hotel->location }}</p>
            <p class="small">{{ $hotel->description }}</p>
        </div>
    </div>
    @endif

    {{-- 🔥 HOTEL IMAGE SLIDER (ALL HOTEL IMAGES) --}}
    @if($hotel->images->count() > 0)
    <div class="swiper mySwiper mb-5">
        <div class="swiper-wrapper">
            @foreach($hotel->images as $img)
            <div class="swiper-slide">
                <img src="{{ asset('hotel_images/' . $img->image) }}" class="slider-img">
            </div>
            @endforeach
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>
    @endif

    {{-- 🔥 ROOMS --}}
    <h4 class="fw-bold mb-4">Available Rooms</h4>

    <div class="row g-4">
        @foreach($rooms as $room)
        <div class="col-lg-4 col-md-6">
            <div class="room-card position-relative h-100">

                <div class="room-badge">{{ $room->room_type }}</div>

                {{-- 🔥 ROOM IMAGE SLIDER (ONLY THIS ROOM'S IMAGES) --}}
                @if($room->images->count() > 0)
                <div class="swiper room-swiper roomSwiper-{{ $room->id }}">
                    <div class="swiper-wrapper">
                        @foreach($room->images as $img)
                        <div class="swiper-slide">
                            <img src="{{ asset('room_images/' . $img->image) }}"
                                 class="room-slider-img">
                        </div>
                        @endforeach
                    </div>
                    {{-- Only show nav if more than 1 image --}}
                    @if($room->images->count() > 1)
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    @endif
                    <div class="swiper-pagination"></div>
                </div>
                @else
                {{-- Fallback if no room images --}}
                <div class="bg-light d-flex align-items-center justify-content-center"
                     style="height:200px;">
                    <span class="text-muted">No Image Available</span>
                </div>
                @endif

                {{-- ROOM DETAILS --}}
                <div class="p-3">
                    <h5 class="fw-bold">{{ $room->room_type }}</h5>

                    <p class="text-muted mb-1">👥 {{ $room->capacity }} Guests</p>
                    <p class="text-muted mb-2">🛏 {{ $room->total_rooms }} Rooms</p>

                    <p class="small text-muted">
                        {{ Str::limit($room->description, 80) }}
                    </p>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="room-price">
                            ₹{{ number_format($room->price) }}
                        </span>
                        <a href="#" class="btn btn-sm btn-main">Book Now</a>
                    </div>
                </div>

            </div>
        </div>
        @endforeach
    </div>

</div>

{{-- 🔥 SCRIPTS --}}
<script>
// Hotel image slider
new Swiper(".mySwiper", {
    loop: true,
    autoplay: { delay: 3000, disableOnInteraction: false },
    pagination: { el: ".mySwiper .swiper-pagination", clickable: true },
    navigation: {
        nextEl: ".mySwiper .swiper-button-next",
        prevEl: ".mySwiper .swiper-button-prev"
    }
});

// 🔥 Each room gets its own independent slider
@foreach($rooms as $room)
@if($room->images->count() > 0)
new Swiper(".roomSwiper-{{ $room->id }}", {
    loop: {{ $room->images->count() > 1 ? 'true' : 'false' }},
    autoplay: { delay: 2500, disableOnInteraction: false },
    pagination: {
        el: ".roomSwiper-{{ $room->id }} .swiper-pagination",
        clickable: true
    },
    navigation: {
        nextEl: ".roomSwiper-{{ $room->id }} .swiper-button-next",
        prevEl: ".roomSwiper-{{ $room->id }} .swiper-button-prev"
    }
});
@endif
@endforeach
</script>

@endsection