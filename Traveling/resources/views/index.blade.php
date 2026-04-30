@extends('header')

@section('home')

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">

<style>
body { font-family: 'Poppins', sans-serif; }

/* HERO */
.hero-section {
    height: 100vh;
    position: relative;
    overflow: hidden;
}

/* SLIDER */
.hero-slide {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    opacity: 0;
    transform: scale(1.1);
    transition: opacity 1.2s ease, transform 6s ease;
}
.hero-slide.active {
    opacity: 1;
    transform: scale(1);
}

/* IMAGES */
.hero-slide:nth-child(1){background-image:url('{{ asset('images/sea.jpg') }}');}
.hero-slide:nth-child(2){background-image:url('{{ asset('images/lake.jpg') }}');}
.hero-slide:nth-child(3){background-image:url('{{ asset('images/mountain.jpg') }}');}

/* OVERLAY */
.hero-overlay {
    position:absolute;
    inset:0;
    background:linear-gradient(to right, rgba(0,0,0,0.75) 35%, transparent);
}

/* CONTENT */
.hero-content {
    z-index:2;
    animation:fadeUp 1s ease;
}
/* TITLE */
.hero-title {
    font-size: clamp(50px,7vw,90px);
    font-weight:800;
    color:#fff;
    line-height:1.1;
}
.hero-title span { color:#ff5722; }

.hero-sub {
    color:rgba(255,255,255,0.75);
    font-size:15px;
}

.btn-main {
    background: linear-gradient(135deg, #6a11cb, #2575fc);
    color:#fff;
    border-radius:50px;
    padding:12px 30px;
    transition:0.3s;
}

.btn-main:hover {
    transform:translateY(-4px);
    box-shadow:0 12px 30px rgba(106,17,203,0.4);
}

/* STATS */
.hero-stats {
    position:absolute;
    bottom:40px;
    left:50%;
    transform:translateX(-50%);
    width:80%;
    backdrop-filter: blur(15px);
    background: rgba(255,255,255,0.08);
    border:1px solid rgba(255,255,255,0.2);
    border-radius:15px;
}
.hero-stats h4 { color:#ff5722; font-weight:700; }
.hero-stats small { color:#fff; }

/* ANIMATION */
@keyframes fadeUp {
    from {opacity:0; transform:translateY(40px);}
    to {opacity:1; transform:translateY(0);}
}
/** ================= TRENDING LISTINGS ================= */
/* TABS */
.pro-tab {
    padding: 10px 26px;
    border-radius: 50px;
    border: 1px solid #ddd;
    background: #fff;
    font-weight: 600;
    transition: 0.3s;
    position: relative;
    overflow: hidden;
}
.pro-tab:hover {
    color: #ff5722;
    border-color: #ff5722;
}
.pro-tab.active {
    background: #ff5722;
    color: #fff;
    box-shadow: 0 10px 25px rgba(255,87,34,0.4);
}
.pro-tab::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(120deg, transparent, rgba(255,255,255,0.4), transparent);
    transition: 0.6s;
}
.pro-tab:hover::before { left: 100%; }
/* TREND ITEM */
.trend-item { transition: 0.4s; }
/* CARD */
.trend-card-pro{
    background:#fff;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
    transition:0.4s;
}
.trend-card-pro:hover{
    transform:translateY(-10px);
    box-shadow:0 20px 60px rgba(0,0,0,0.15);
}

/* IMAGE */
.trend-img{
    position:relative;
    overflow:hidden;
}
.trend-img img{
    width:100%;
    height:200px;
    object-fit:cover;
    transition:0.6s;
}
.trend-card-pro:hover img{
    transform:scale(1.15);
}

/* OVERLAY */
.img-overlay{
    position:absolute;
    inset:0;
    background:linear-gradient(to top, rgba(0,0,0,0.5), transparent);
}

/* FLIGHT LINE */
.line{
    height:2px;
    background:#ddd;
    position:relative;
}
.line::after{
    content:"✈";
    position:absolute;
    top:-10px;
    left:50%;
    transform:translateX(-50%);
    font-size:14px;
    color:#ff5722;
}

/* ================= RESPONSIVE (ONLY ADDED) ================= */

@media (max-width: 1200px){
  .hero-title{
    font-size: clamp(40px,6vw,70px);
  }
}

@media (max-width: 992px){

  .hero-section{
    height: auto;
    min-height: 100vh;
    padding: 120px 0 80px;
  }

  .hero-content{
    text-align: center;
  }

  .hero-title{
    font-size: clamp(36px,8vw,60px);
  }

  .hero-stats{
    position: static;
    transform: none;
    width: 100%;
    margin-top: 40px;
  }
}

@media (max-width: 768px){

  .hero-title{
    font-size: 32px;
  }

  .hero-stats .col-md-3{
    width: 50%;
  }

  .trend-img img{
    height: 180px;
  }
}

@media (max-width: 576px){

  .hero-title{
    font-size: 26px;
  }

  .hero-stats h4{
    font-size: 18px;
  }

  .hero-stats small{
    font-size: 12px;
  }

  .pro-tab{
    padding: 8px 16px;
    font-size: 13px;
  }

  .trend-img img{
    height: 160px;
  }

  /*=================       Hotel Section          =================*/  
  /* HOTEL BADGE GLOW */
.trend-card-pro:hover .bg-warning {
    box-shadow: 0 0 15px rgba(255,193,7,0.7);
}

/* FACILITY ICON STYLE */
.trend-card-pro span {
    background: #f8f9fa;
    padding: 4px 8px;
    border-radius: 20px;
    font-size: 11px;
}
  
}
</style>

<!-- HERO -->
<section class="hero-section d-flex align-items-center">

    <div class="hero-slide active"></div>
    <div class="hero-slide"></div>
    <div class="hero-slide"></div>

    <div class="hero-overlay"></div>

    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-4 hero-content text-white">
                <h1 class="hero-title">
                    Explore <span>Beyond</span>
                </h1>

                <p class="hero-sub my-3">
                    Travel the world with premium experiences and unforgettable adventures.
                </p>
            </div>

            <div class="col-lg-8"></div>
        </div>
    </div>

    <div class="hero-stats py-3">
        <div class="row text-center">
            <div class="col-md-3"><h4>15K+</h4><small>Happy Clients</small></div>
            <div class="col-md-3"><h4>98+</h4><small>Destinations</small></div>
            <div class="col-md-3"><h4>20+</h4><small>Services</small></div>
            <div class="col-md-3"><h4>12+</h4><small>Experience</small></div>
        </div>
    </div>

</section>

<!-- TRENDING -->
<section class="py-5 bg-light">
<div class="container">

    <div class="text-center mb-5">
        <h2 class="fw-bold display-6">Trending Listings</h2>
        <p class="text-muted">Best Seller Travel Services</p>
    </div>

    <div class="d-flex justify-content-center mb-5 flex-wrap gap-3">
        <button class="pro-tab active" data-type="flight">✈ Flights</button>
        <button class="pro-tab" data-type="hotel">🏨 Hotels</button>
        <button class="pro-tab" data-type="tour">🌍 Tours</button>
        <button class="pro-tab" data-type="car">🚗 Cars</button>
    </div>
    <!-- FLIGHT SECTION -->
    <div class="row g-4">

        @foreach($flights as $flight)
        <div class="col-md-6 col-lg-4 trend-item" data-type="flight">

            <div class="trend-card-pro">

                <div class="trend-img">
                    <img src="{{ asset('images/'.$flight->image) }}">
                    <div class="img-overlay"></div>
                </div>

                <div class="p-3">

                    <div class="d-flex mb-2 align-items-center">
                        <h6 class="fw-bold mb-0">
                            {{ $flight->airline_name }}
                            <i class="fa-solid fa-circle mx-2 text-danger small"></i>
                            <small class="text-muted">{{ $flight->flight_no }}</small>
                        </h6>
                    </div>

                    @php
                        $dep = \Carbon\Carbon::parse($flight->departure_time);
                        $arr = \Carbon\Carbon::parse($flight->arrival_time);
                        if($arr->lessThan($dep)) $arr->addDay();
                        $diff = $dep->diff($arr);
                    @endphp

                    <div class="d-flex justify-content-between text-center my-3">

                        <div>
                            <p>Origin</p>
                            <strong>{{ $dep->format('h:i A') }}</strong><br>
                            <small class="text-muted">{{ $flight->from_city }}</small>
                        </div>

                        <div class="flex-grow-1 px-2">
                            <div class="line mt-3"></div>
                            <small class="text-muted">
                                {{ $diff->h }}h {{ $diff->i }}m
                            </small><br>
                            <small class="text-danger fw-bold">
                                {{ $flight->stops ?? 'Non-stop' }}
                            </small>
                        </div>

                        <div>
                            <p>Destination</p>
                            <strong>{{ $arr->format('h:i A') }}</strong><br>
                            <small class="text-muted">{{ $flight->to_city }}</small>
                        </div>

                    </div>

                    <div class="d-flex justify-content-between mt-3">
                        <h5 class="text-primary fw-bold mb-0">${{ number_format($flight->price) }}</h5>
                        @auth
                            <a href="{{ route('flight.book', $flight->id) }}" class="btn btn-sm btn-main">Book Now</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-sm btn-main">Login to Book</a>
                        @endauth                    </div>

                </div>

            </div>

        </div>
        @endforeach

    </div>

   <!-- HOTEL SECTION -->
    <div class="row g-4">

        @foreach($hotels as $hotel)
        <div class="col-md-6 col-lg-4 trend-item d-none" data-type="hotel">

            <div class="trend-card-pro">

                {{-- IMAGE --}}
                <div class="trend-img">
                    <img src="{{ asset('hotel_images/'.$hotel->thumbnail) }}">
                    <div class="img-overlay"></div>

                    {{-- RATING BADGE --}}
                    <div class="position-absolute top-0 end-0 m-2 bg-warning text-dark px-2 py-1 rounded">
                        ⭐ {{ $hotel->star_rating ?? 'N/A' }}
                    </div>
                </div>

                {{-- CONTENT --}}
                <div class="p-3">

                    {{-- HOTEL NAME --}}
                    <h6 class="fw-bold mb-1">
                        {{ $hotel->name }}
                    </h6>

                    {{-- LOCATION --}}
                    <small class="text-muted">
                        <i class="fa-solid fa-location-dot text-danger"></i>
                        {{ $hotel->city }}, {{ $hotel->country }}
                    </small>

                    {{-- FACILITIES --}}
                    <div class="mt-2 small text-muted">
                        @if($hotel->wifi) <span class="me-2">📶 Wifi</span> @endif
                        @if($hotel->parking) <span class="me-2">🅿 Parking</span> @endif
                        @if($hotel->pool) <span class="me-2">🏊 Pool</span> @endif
                        @if($hotel->ac) <span class="me-2">❄ AC</span> @endif
                        @if($hotel->restaurant) <span class="me-2">🍽️ Restaurant</span> @endif
                    </div>

                    {{-- PRICE + BUTTON --}}
                    <div class="d-flex justify-content-between align-items-center mt-3">

                        <div>
                            <h5 class="text-success fw-bold mb-0">
                                ₹{{ number_format($hotel->price_per_night) }}
                            </h5>
                            <small class="text-muted">per night</small>
                        </div>

                        <a href="{{ route('hotelview', $hotel->id) }}" class="btn btn-sm btn-main">
                            View
                        </a>
                        

                    </div>

                </div>

            </div>

        </div>
        @endforeach

    </div>


</div>
</section>

<script>
let slides = document.querySelectorAll('.hero-slide');
let index = 0;

setInterval(() => {
    slides[index].classList.remove('active');
    index = (index + 1) % slides.length;
    slides[index].classList.add('active');
}, 5000);

document.querySelectorAll('.pro-tab').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.pro-tab').forEach(b => b.classList.remove('active'));
        this.classList.add('active');

        let type = this.dataset.type;

        document.querySelectorAll('.trend-item').forEach(item => {
            item.classList.toggle('d-none', item.dataset.type !== type);
        });
    });
});
</script>

@endsection