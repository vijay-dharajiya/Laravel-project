@extends('admin.master')

@section('content')

<div class="container mt-4" style="max-width:900px;">

    <h3 class="mb-1 fw-bold text-success">🎫 Add Flight Classes</h3>
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

    <form action="{{ route('admin.flightclass.store', $flight->id) }}" method="POST">
        @csrf

        {{-- Loop through available class types --}}
        @foreach($availableTypes as $index => $type)

        @php
            // Default values per class type
            $defaults = [
                'Economy'         => ['seats' => 150, 'price' => 4500,  'tax' => 450,  'cabin' => 7,  'checkin' => 15],
                'Premium Economy' => ['seats' => 40,  'price' => 8000,  'tax' => 800,  'cabin' => 7,  'checkin' => 20],
                'Business'        => ['seats' => 20,  'price' => 15000, 'tax' => 1500, 'cabin' => 10, 'checkin' => 30],
                'First'           => ['seats' => 10,  'price' => 35000, 'tax' => 3500, 'cabin' => 10, 'checkin' => 40],
            ];
            $d = $defaults[$type];

            $colors = [
                'Economy'         => 'success',
                'Premium Economy' => 'info',
                'Business'        => 'warning',
                'First'           => 'danger',
            ];
            $color = $colors[$type];
        @endphp

        <div class="card mb-4 shadow-sm border-{{ $color }}">

            {{-- Class Header --}}
            <div class="card-header bg-{{ $color }} text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">{{ $type }}</h5>
                <span class="badge bg-white text-{{ $color }}">Class {{ $index + 1 }}</span>
            </div>

            <div class="card-body">

                {{-- Hidden class type --}}
                <input type="hidden" name="classes[{{ $index }}][class_type]" value="{{ $type }}">

                <div class="row">

                    {{-- Seats --}}
                    <div class="col-md-4 mb-3">
                        <label class="fw-semibold">Total Seats <span class="text-danger">*</span></label>
                        <input type="number"
                               name="classes[{{ $index }}][total_seats]"
                               class="form-control"
                               value="{{ old("classes.$index.total_seats", $d['seats']) }}"
                               min="1" required>
                        <small class="text-muted">Available seats = total seats at start</small>
                    </div>

                    {{-- Base Price --}}
                    <div class="col-md-4 mb-3">
                        <label class="fw-semibold">Base Price ($) <span class="text-danger">*</span></label>
                        <input type="number"
                               name="classes[{{ $index }}][base_price]"
                               class="form-control base-price-{{ $index }}"
                               value="{{ old("classes.$index.base_price", $d['price']) }}"
                               min="0" step="0.01" required
                               oninput="calcTotal({{ $index }})">
                    </div>

                    {{-- Tax --}}
                    <div class="col-md-4 mb-3">
                        <label class="fw-semibold">Tax ($) <span class="text-danger">*</span></label>
                        <input type="number"
                               name="classes[{{ $index }}][tax]"
                               class="form-control tax-{{ $index }}"
                               value="{{ old("classes.$index.tax", $d['tax']) }}"
                               min="0" step="0.01" required
                               oninput="calcTotal({{ $index }})">
                    </div>

                    {{-- Total Price (readonly) --}}
                    <div class="col-md-4 mb-3">
                        <label class="fw-semibold">Total Price ($)</label>
                        <input type="text"
                               id="total_{{ $index }}"
                               class="form-control bg-light fw-bold text-success"
                               value="{{ $d['price'] + $d['tax'] }}"
                               readonly>
                        <small class="text-muted">Auto = Base + Tax</small>
                    </div>

                    {{-- Cabin Baggage --}}
                    <div class="col-md-4 mb-3">
                        <label class="fw-semibold">Cabin Baggage (kg) <span class="text-danger">*</span></label>
                        <input type="number"
                               name="classes[{{ $index }}][cabin_baggage_kg]"
                               class="form-control"
                               value="{{ old("classes.$index.cabin_baggage_kg", $d['cabin']) }}"
                               min="0" required>
                    </div>

                    {{-- Check-in Baggage --}}
                    <div class="col-md-4 mb-3">
                        <label class="fw-semibold">Check-in Baggage (kg) <span class="text-danger">*</span></label>
                        <input type="number"
                               name="classes[{{ $index }}][checkin_baggage_kg]"
                               class="form-control"
                               value="{{ old("classes.$index.checkin_baggage_kg", $d['checkin']) }}"
                               min="0" required>
                    </div>

                    {{-- Refundable --}}
                    <div class="col-md-6 mb-3">
                        <label class="fw-semibold">Refundable?</label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="classes[{{ $index }}][is_refundable]"
                                   value="1"
                                   id="refund_{{ $index }}"
                                   onchange="toggleCharge({{ $index }})"
                                   {{ old("classes.$index.is_refundable") ? 'checked' : '' }}>
                            <label class="form-check-label" for="refund_{{ $index }}">
                                Yes, this class is refundable
                            </label>
                        </div>
                    </div>

                    {{-- Cancellation Charge --}}
                    <div class="col-md-6 mb-3" id="charge_box_{{ $index }}" style="display:none;">
                        <label class="fw-semibold">Cancellation Charge ($)</label>
                        <input type="number"
                               name="classes[{{ $index }}][cancellation_charge]"
                               class="form-control"
                               value="{{ old("classes.$index.cancellation_charge", 0) }}"
                               min="0" step="0.01">
                    </div>

                </div>
            </div>
        </div>

        @endforeach

        {{-- Buttons --}}
        <div class="d-flex justify-content-between mb-5">
            <a href="{{ route('admin.flightclass.index', $flight->id) }}"
               class="btn btn-secondary px-4">
                ← Back
            </a>
            <button type="submit" class="btn btn-success px-5 fw-bold">
                💾 Save Classes
            </button>
        </div>

    </form>
</div>

<script>
    // Auto calculate total price
    function calcTotal(index) {
        const base  = parseFloat(document.querySelector(`.base-price-${index}`).value) || 0;
        const tax   = parseFloat(document.querySelector(`.tax-${index}`).value) || 0;
        document.getElementById(`total_${index}`).value = (base + tax).toFixed(2);
    }

    // Show/hide cancellation charge
    function toggleCharge(index) {
        const checkbox = document.getElementById(`refund_${index}`);
        const box      = document.getElementById(`charge_box_${index}`);
        box.style.display = checkbox.checked ? 'block' : 'none';
    }
</script>

@endsection