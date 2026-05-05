@extends('admin.master')

@section('content')

<div class="container mt-4" style="max-width:750px;">

    <h3 class="mb-1 fw-bold text-primary">✏️ Edit Class</h3>
    <p class="text-muted mb-4">
        {{ $flight->flight_number }} —
        {{ $flight->from_city }} → {{ $flight->to_city }}
    </p>

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

    <form action="{{ route('admin.flightclass.update', $class->id) }}" method="POST">
        @csrf

        <div class="card shadow-sm border-{{ $class->class_color }}">

            <div class="card-header bg-{{ $class->class_color }} text-white">
                <h5 class="mb-0 fw-bold">{{ $class->class_type }}</h5>
            </div>

            <div class="card-body">
                <div class="row">

                    {{-- Total Seats --}}
                    <div class="col-md-4 mb-3">
                        <label class="fw-semibold">Total Seats <span class="text-danger">*</span></label>
                        <input type="number" name="total_seats" class="form-control"
                               value="{{ old('total_seats', $class->total_seats) }}"
                               min="1" required>
                        <small class="text-muted">
                            Booked: {{ $class->booked_seats }} —
                            Available will auto adjust
                        </small>
                    </div>

                    {{-- Base Price --}}
                    <div class="col-md-4 mb-3">
                        <label class="fw-semibold">Base Price (₹) <span class="text-danger">*</span></label>
                        <input type="number" name="base_price"
                               class="form-control"
                               id="base_price"
                               value="{{ old('base_price', $class->base_price) }}"
                               min="0" step="0.01" required
                               oninput="calcTotal()">
                    </div>

                    {{-- Tax --}}
                    <div class="col-md-4 mb-3">
                        <label class="fw-semibold">Tax (₹) <span class="text-danger">*</span></label>
                        <input type="number" name="tax"
                               class="form-control"
                               id="tax"
                               value="{{ old('tax', $class->tax) }}"
                               min="0" step="0.01" required
                               oninput="calcTotal()">
                    </div>

                    {{-- Total Price --}}
                    <div class="col-md-4 mb-3">
                        <label class="fw-semibold">Total Price (₹)</label>
                        <input type="text" id="total_price"
                               class="form-control bg-light fw-bold text-success"
                               value="{{ $class->total_price }}" readonly>
                        <small class="text-muted">Auto = Base + Tax</small>
                    </div>

                    {{-- Cabin Baggage --}}
                    <div class="col-md-4 mb-3">
                        <label class="fw-semibold">Cabin Baggage (kg)</label>
                        <input type="number" name="cabin_baggage_kg" class="form-control"
                               value="{{ old('cabin_baggage_kg', $class->cabin_baggage_kg) }}"
                               min="0" required>
                    </div>

                    {{-- Check-in Baggage --}}
                    <div class="col-md-4 mb-3">
                        <label class="fw-semibold">Check-in Baggage (kg)</label>
                        <input type="number" name="checkin_baggage_kg" class="form-control"
                               value="{{ old('checkin_baggage_kg', $class->checkin_baggage_kg) }}"
                               min="0" required>
                    </div>

                    {{-- Refundable --}}
                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold">Refundable?</label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox"
                                   name="is_refundable" value="1"
                                   id="is_refundable"
                                   onchange="toggleCharge()"
                                   {{ $class->is_refundable ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_refundable">
                                Yes, this class is refundable
                            </label>
                        </div>
                    </div>

                    {{-- Cancellation Charge --}}
                    <div class="col-md-6 mb-3"
                         id="charge_box"
                         style="display:{{ $class->is_refundable ? 'block' : 'none' }}">
                        <label class="fw-semibold">Cancellation Charge (₹)</label>
                        <input type="number" name="cancellation_charge" class="form-control"
                               value="{{ old('cancellation_charge', $class->cancellation_charge) }}"
                               min="0" step="0.01">
                    </div>

                    {{-- Seat Info (readonly) --}}
                    <div class="col-12">
                        <div class="alert alert-light border mt-2">
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="text-muted small">Total Seats</div>
                                    <strong>{{ $class->total_seats }}</strong>
                                </div>
                                <div class="col-4">
                                    <div class="text-muted small">Booked</div>
                                    <strong class="text-danger">{{ $class->booked_seats }}</strong>
                                </div>
                                <div class="col-4">
                                    <div class="text-muted small">Available</div>
                                    <strong class="text-success">{{ $class->available_seats }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Buttons --}}
        <div class="d-flex justify-content-between mt-4 mb-5">
            <a href="{{ route('admin.flightclass.index', $flight->id) }}"
               class="btn btn-secondary px-4">
                ← Back
            </a>
            <button type="submit" class="btn btn-primary px-5 fw-bold">
                💾 Update Class
            </button>
        </div>

    </form>
</div>

<script>
    function calcTotal() {
        const base  = parseFloat(document.getElementById('base_price').value) || 0;
        const tax   = parseFloat(document.getElementById('tax').value) || 0;
        document.getElementById('total_price').value = (base + tax).toFixed(2);
    }

    function toggleCharge() {
        const checkbox = document.getElementById('is_refundable');
        const box      = document.getElementById('charge_box');
        box.style.display = checkbox.checked ? 'block' : 'none';
    }
</script>

@endsection