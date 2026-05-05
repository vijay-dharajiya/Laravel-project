@extends('admin.master')

@section('content')

<div class="container mt-4">

    <div class="card shadow-lg border-0">

        <!-- HEADER -->
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0">🎫 Flight Classes</h4>
                <small>
                    {{ $flight->flight_number }} —
                    {{ $flight->from_airport_code }} → {{ $flight->to_airport_code }}
                </small>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.flightclass.create', $flight->id) }}"
                   class="btn btn-warning btn-sm fw-bold">
                    + Add Class
                </a>
                <a href="{{ route('admin.viewflight') }}"
                   class="btn btn-light btn-sm">
                    ← Flights
                </a>
            </div>
        </div>

        <div class="card-body">

            {{-- SUCCESS --}}
            @if(session('msg'))
                <div class="alert alert-success alert-dismissible fade show" id="successMsg">
                    {{ session('msg') }}
                </div>
            @endif

            {{-- ERROR --}}
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Flight Info Bar --}}
            <div class="alert alert-light border mb-4">
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="text-muted small">Flight</div>
                        <strong>{{ $flight->flight_number }}</strong>
                    </div>
                    <div class="col-md-3">
                        <div class="text-muted small">Route</div>
                        <strong>{{ $flight->from_city }} → {{ $flight->to_city }}</strong>
                    </div>
                    <div class="col-md-3">
                        <div class="text-muted small">Timing</div>
                        <strong>
                            {{ \Carbon\Carbon::parse($flight->departure_time)->format('h:i A') }}
                            →
                            {{ \Carbon\Carbon::parse($flight->arrival_time)->format('h:i A') }}
                        </strong>
                    </div>
                    <div class="col-md-3">
                        <div class="text-muted small">Classes Added</div>
                        <strong>{{ $classes->count() }} / 4</strong>
                    </div>
                </div>
            </div>

            {{-- Classes Table --}}
            @if($classes->count() > 0)

            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">

                    <thead class="table-dark">
                        <tr>
                            <th>Class</th>
                            <th>Seats</th>
                            <th>Fill</th>
                            <th>Pricing</th>
                            <th>Baggage</th>
                            <th>Refund</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($classes as $class)
                        <tr>

                            {{-- CLASS TYPE --}}
                            <td>
                                <span class="badge bg-{{ $class->class_color }} fs-6 px-3 py-2 text-white">
                                    {{ $class->class_type }}
                                </span>
                            </td>

                            {{-- SEATS --}}
                            <td>
                                <div class="fw-bold">{{ $class->available_seats }}
                                    <span class="text-muted fw-normal">/ {{ $class->total_seats }}</span>
                                </div>
                                <small class="text-danger">{{ $class->booked_seats }} booked</small>
                            </td>

                            {{-- FILL PERCENTAGE --}}
                            <td style="min-width:120px">
                                <div class="progress" style="height:8px;">
                                    <div class="progress-bar bg-{{ $class->class_color }}"
                                         style="width:{{ $class->fill_percentage }}%">
                                    </div>
                                </div>
                                <small class="text-muted">{{ $class->fill_percentage }}% filled</small>
                            </td>

                            {{-- PRICING --}}
                            <td class="text-start">
                                <div>
                                    <span class="text-muted small">Base:</span>
                                    ${{ number_format($class->base_price, 2) }}
                                </div>
                                <div>
                                    <span class="text-muted small">Tax:</span>
                                    ${{ number_format($class->tax, 2) }}
                                </div>
                                <div class="fw-bold text-success">
                                    ${{ number_format($class->total_price, 2) }}
                                </div>
                            </td>

                            {{-- BAGGAGE --}}
                            <td>
                                <div><small class="text-muted">Cabin:</small> {{ $class->cabin_baggage_kg }}kg</div>
                                <div><small class="text-muted">Check-in:</small> {{ $class->checkin_baggage_kg }}kg</div>
                            </td>

                            {{-- REFUND --}}
                            <td>
                                @if($class->is_refundable)
                                    <span class="badge bg-success">Refundable</span>
                                    <div class="small text-muted mt-1">
                                        Charge: ${{ number_format($class->cancellation_charge, 2) }}
                                    </div>
                                @else
                                    <span class="badge bg-danger text-white">Non-Refundable</span>
                                @endif
                            </td>

                            {{-- ACTION --}}
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.flightclass.edit', $class->id) }}"
                                       class="btn btn-sm btn-primary">
                                        Edit
                                    </a>
                                    <a href="{{ route('admin.flightclass.destroy', $class->id) }}"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Delete this class?')">
                                        Delete
                                    </a>
                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

            @else
                <div class="text-center py-5 text-muted">
                    <div style="font-size:48px">🎫</div>
                    <h5 class="mt-3">No Classes Added Yet</h5>
                    <p>Add Economy, Business, First or Premium Economy class for this flight.</p>
                    <a href="{{ route('admin.flightclass.create', $flight->id) }}"
                       class="btn btn-success mt-2">
                        + Add First Class
                    </a>
                </div>
            @endif

        </div>
    </div>
</div>

<script>
    setTimeout(function () {
        let msg = document.getElementById('successMsg');
        if (msg) {
            msg.classList.remove('show');
            setTimeout(() => msg.remove(), 500);
        }
    }, 2000);
</script>

@endsection