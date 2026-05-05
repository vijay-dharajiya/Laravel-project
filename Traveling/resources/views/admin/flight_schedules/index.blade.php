@extends('admin.master')

@section('content')

<div class="container mt-4">

    <div class="card shadow-lg border-0">

        <!-- HEADER -->
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0">📅 Flight Schedules</h4>
                <small>
                    {{ $flight->flight_number }} —
                    {{ $flight->from_airport_code }} → {{ $flight->to_airport_code }} |
                    {{ \Carbon\Carbon::parse($flight->departure_time)->format('h:i A') }}
                    →
                    {{ \Carbon\Carbon::parse($flight->arrival_time)->format('h:i A') }}
                </small>
            </div>
            <a href="{{ route('admin.viewflight') }}" class="btn btn-light btn-sm">
                ← Flights
            </a>
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
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            {{-- ── Generate Schedules Box ── --}}
            <div class="card border-primary mb-4">
                <div class="card-header bg-primary text-white fw-bold">
                    ⚡ Generate Schedules
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.flightschedule.generate', $flight->id) }}"
                          method="POST"
                          class="d-flex align-items-end gap-3 flex-wrap">
                        @csrf

                        <div>
                            <label class="fw-semibold mb-1 d-block">Generate for next:</label>
                            <div class="d-flex gap-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                           name="days" value="30" id="d30" checked>
                                    <label class="form-check-label" for="d30">30 Days</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                           name="days" value="60" id="d60">
                                    <label class="form-check-label" for="d60">60 Days</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                           name="days" value="90" id="d90">
                                    <label class="form-check-label" for="d90">90 Days</label>
                                </div>
                            </div>
                            <small class="text-muted">
                                Already existing dates will be skipped automatically.
                            </small>
                        </div>

                        <button type="submit" class="btn btn-primary fw-bold px-4">
                            ⚡ Generate
                        </button>

                    </form>
                </div>
            </div>

            {{-- ── Stats Bar ── --}}
            @php
                $total     = $schedules->total();
                $upcoming  = $schedules->getCollection()
                             ->filter(fn($s) => $s->journey_date >= today())->count();
                $cancelled = $schedules->getCollection()
                             ->filter(fn($s) => $s->status === 'Cancelled')->count();
                $past      = $schedules->getCollection()
                             ->filter(fn($s) => $s->journey_date < today())->count();
            @endphp

            <div class="row text-center mb-4">
                <div class="col-md-3">
                    <div class="card border-0 bg-light py-3">
                        <div class="fs-4 fw-bold text-primary">{{ $total }}</div>
                        <div class="text-muted small">Total Schedules</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 bg-light py-3">
                        <div class="fs-4 fw-bold text-success">{{ $upcoming }}</div>
                        <div class="text-muted small">Upcoming</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 bg-light py-3">
                        <div class="fs-4 fw-bold text-danger">{{ $cancelled }}</div>
                        <div class="text-muted small">Cancelled</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 bg-light py-3">
                        <div class="fs-4 fw-bold text-secondary">{{ $past }}</div>
                        <div class="text-muted small">Past (this page)</div>
                    </div>
                </div>
            </div>

            {{-- ── Cleanup Button ── --}}
            @if($past > 0)
                <div class="text-end mb-3">
                    <a href="{{ route('admin.flightschedule.cleanup', $flight->id) }}"
                       class="btn btn-outline-secondary btn-sm"
                       onclick="return confirm('Delete all past schedules for this flight?')">
                        🧹 Cleanup Past Schedules ({{ $past }} found)
                    </a>
                </div>
            @endif

            {{-- ── Schedules Table ── --}}
            @if($schedules->count() > 0)

            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">

                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Day</th>
                            <th>Status</th>
                            <th>Update Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($schedules as $schedule)

                        @php
                            $isPast = $schedule->journey_date < today();
                        @endphp

                        <tr class="{{ $isPast ? 'table-secondary' : '' }}">

                            {{-- # --}}
                            <td class="text-muted small">
                                {{ $loop->iteration }}
                            </td>

                            {{-- DATE --}}
                            <td class="fw-bold">
                                {{ \Carbon\Carbon::parse($schedule->journey_date)->format('d M Y') }}
                                @if($schedule->journey_date->isToday())
                                    <span class="badge bg-warning text-dark ms-1">Today</span>
                                @endif
                            </td>

                            {{-- DAY --}}
                            <td class="text-muted">
                                {{ \Carbon\Carbon::parse($schedule->journey_date)->format('l') }}
                            </td>

                            {{-- STATUS BADGE --}}
                            <td>
                                <span class="badge bg-{{ $schedule->status_color }} px-3 py-2">
                                    {{ $schedule->status }}
                                </span>
                                @if($isPast)
                                    <div class="small text-muted">Past</div>
                                @endif
                            </td>

                            {{-- UPDATE STATUS FORM --}}
                            <td>
                                @if(!$isPast)
                                <form action="{{ route('admin.flightschedule.status', $schedule->id) }}"
                                      method="POST"
                                      class="d-flex gap-2 justify-content-center">
                                    @csrf
                                    <select name="status" class="form-select form-select-sm"
                                            style="width:140px">
                                        @foreach(['Scheduled','On Time','Delayed','Cancelled','Boarding','Departed','Landed'] as $s)
                                            <option value="{{ $s }}"
                                                {{ $schedule->status === $s ? 'selected' : '' }}>
                                                {{ $s }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        Save
                                    </button>
                                </form>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>

                            {{-- DELETE --}}
                            <td>
                                <a href="{{ route('admin.flightschedule.destroy', $schedule->id) }}"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Delete this schedule?')">
                                    Delete
                                </a>
                            </td>

                        </tr>

                        @endforeach
                    </tbody>

                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $schedules->links() }}
            </div>

            @else
                <div class="text-center py-5 text-muted">
                    <div style="font-size:48px">📅</div>
                    <h5 class="mt-3">No Schedules Yet</h5>
                    <p>Use the Generate button above to create schedules for next 30, 60 or 90 days.</p>
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