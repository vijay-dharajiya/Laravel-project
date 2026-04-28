@extends('header')

@section('home')

<style>
.page-wrapper{
    margin-top:110px;
}

/* CARD */
.flight-card, .form-card{
    border-radius:30px;
    background:#fff;
    box-shadow:0 20px 60px rgba(0,0,0,0.1);
    border:1px solid #eee;
}

/* IMAGE */
.flight-img{
    height:180px;
    width:100%;
    object-fit:cover;
    border-radius:30px;
}

/* ROUTE */
.route-box{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin:20px 0;
}

.route-line{
    flex:1;
    height:2px;
    background:#ddd;
    margin:0 10px;
    position:relative;
}

.route-line::after{
    content:"✈";
    position:absolute;
    top:-10px;
    left:50%;
    transform:translateX(-50%);
    color:#ff5722;
}

/* PRICE */
.price-box{
    background:#f8f9fa;
    border-radius:12px;
    padding:15px;
}

/* INPUT */
.custom-input{
    border-radius:10px;
    padding:10px;
    border:1px solid #ddd;
}

.custom-input:focus{
    border-color:#ff5722;
    box-shadow:0 0 8px rgba(255,87,34,0.2);
}

/* PASSENGER */
.passenger-box{
    background:#f8f9fa;
    padding:18px;
    border-radius:12px;
}

.counter{
    display:flex;
    align-items:center;
    gap:10px;
}

.counter button{
    width:36px;
    height:36px;
    border:none;
    background:#ff5722;
    color:#fff;
    border-radius:50%;
    font-size:18px;
}

.counter button:hover{
    background:#e64a19;
}

.counter span{
    font-weight:600;
    min-width:25px;
    text-align:center;
}

/* BUTTON */
.btn-main{
    background:linear-gradient(135deg,#ff5722,#ff8a50);
    color:#fff;
    border:none;
    border-radius:10px;
    padding:12px;
}

/* MOBILE */
@media(max-width:768px){
    .page-wrapper{margin-top:90px;}
}
</style>

<div class="container page-wrapper">
    <div class="row g-4">
           @if(session('success'))
                <div id="successMsg" style="background:linear-gradient(135deg,#28a745,#5cd65c);color:#fff;padding:15px;border-radius:12px;margin-bottom:20px;transition:0.5s;">
                    ✔ {{ session('success') }}
                </div>
            @endif
        <!-- LEFT: FLIGHT DETAILS -->
        <div class="col-lg-5">

            <div class="flight-card">

                <img src="{{ asset('images/'.$flight->image) }}" class="flight-img">

                <div class="p-4">

                    <div class="d-flex justify-content-between">
                        <h5 class="fw-bold">{{ $flight->airline_name }}</h5>
                        <small>{{ $flight->flight_no }}</small>
                    </div>

                    @php
                        $dep = \Carbon\Carbon::parse($flight->departure_time);
                        $arr = \Carbon\Carbon::parse($flight->arrival_time);
                        if($arr->lessThan($dep)) $arr->addDay();
                        $diff = $dep->diff($arr);
                    @endphp

                    <div class="route-box text-center">

                        <div>
                            <h6>{{ $dep->format('h:i A') }}</h6>
                            <small>{{ $flight->from_city }}</small>
                        </div>

                        <div class="route-line"></div>

                        <div>
                            <h6>{{ $arr->format('h:i A') }}</h6>
                            <small>{{ $flight->to_city }}</small>
                        </div>

                    </div>

                    <div class="text-center mb-3">
                        <small class="text-muted">
                            {{ $diff->h }}h {{ $diff->i }}m • {{ $flight->stops ?? 'Non-stop' }}
                        </small>
                    </div>

                    <div class="price-box d-flex justify-content-between">
                        <span>Total Price</span>
                        <strong>$<span id="totalPrice">{{ number_format($flight->price) }}</span></strong>
                    </div>

                </div>
            </div>

        </div>

        <!-- RIGHT: BOOKING FORM -->
        <div class="col-lg-7">

            <div class="form-card p-4">

                <h4 class="fw-bold mb-4">Passenger Details</h4>

                <form action="{{ route('flightbooking', $flight->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label>Full Name</label>
                            <input type="text" name="name" class="form-control custom-input" required>
                        </div>

                        <div class="col-md-6">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control custom-input" required>
                        </div>

                        <div class="col-md-6">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control custom-input" required>
                        </div>

                        <div class="col-md-6">
                            <label>Travel Date</label>
                            <input type="date" name="travel_date" class="form-control custom-input" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <!-- PASSENGERS -->
                        <div class="col-12">
                            <label>Passengers</label>

                            <div class="passenger-box">

                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <strong>Adults</strong><br>
                                        <small>18+</small>
                                    </div>

                                    <div class="counter">
                                        <button type="button" onclick="changeCount('adult',-1)">−</button>
                                        <span id="adultCount">1</span>
                                        <button type="button" onclick="changeCount('adult',1)">+</button>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <div>
                                        <strong>Children</strong><br>
                                        <small>0–17</small>
                                    </div>

                                    <div class="counter">
                                        <button type="button" onclick="changeCount('child',-1)">−</button>
                                        <span id="childCount">0</span>
                                        <button type="button" onclick="changeCount('child',1)">+</button>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- HIDDEN -->
                        <input type="hidden" name="adults" id="adultInput" value="1">
                        <input type="hidden" name="children" id="childInput" value="0">
                        <input type="hidden" name="class" value="Economy">

                    </div>

                    <button class="btn btn-main w-100 mt-4">
                        Confirm Booking ✈️
                    </button>

                </form>

            </div>

        </div>

    </div>
</div>

<script>
let adult = 1;
let child = 0;
let basePrice = {{ $flight->price }};

function changeCount(type, value){

    if(type === 'adult'){
        adult = Math.max(0, adult + value);
    }

    if(type === 'child'){
        child = Math.max(0, child + value);
    }

    // prevent total = 0
    if(adult + child === 0){
        if(type === 'adult'){
            adult = 1;
        } else {
            child = 1;
        }
    }

    // update UI
    document.getElementById('adultCount').innerText = adult;
    document.getElementById('childCount').innerText = child;

    document.getElementById('adultInput').value = adult;
    document.getElementById('childInput').value = child;

    // price update
    let total = (adult + child) * basePrice;
    document.getElementById('totalPrice').innerText = total.toLocaleString();
}
</script>

<script>
setTimeout(function() {
    let msg = document.getElementById('successMsg');
    if(msg){
        msg.style.opacity = '0';
        msg.style.transform = 'translateY(-10px)';
        setTimeout(() => msg.remove(), 500);
    }
}, 3000); // 3 seconds
</script>

@endsection