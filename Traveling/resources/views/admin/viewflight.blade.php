@extends('admin.master')

@section('content')

<style>
    .flight-table-wrap {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.07);
        overflow: hidden;
    }

    .flight-header {
        background: linear-gradient(135deg, #1a1f36 0%, #2d3561 100%);
        padding: 22px 28px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .flight-header h4 {
        color: #fff;
        font-weight: 700;
        font-size: 20px;
        margin: 0;
        letter-spacing: -0.3px;
    }

    .flight-header small {
        color: rgba(255,255,255,0.55);
        font-size: 12px;
        display: block;
        margin-top: 3px;
    }

    .btn-add-flight {
        background: #f59e0b;
        color: #1a1f36;
        font-weight: 700;
        font-size: 13px;
        border: none;
        padding: 9px 20px;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-add-flight:hover {
        background: #fbbf24;
        color: #1a1f36;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(245,158,11,0.4);
    }

    /* Table */
    .flight-table {
        width: 100%;
        border-collapse: collapse;
    }

    .flight-table thead tr {
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
    }

    .flight-table thead th {
        padding: 13px 16px;
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        text-align: left;
        white-space: nowrap;
    }

    .flight-table thead th:first-child,
    .flight-table tbody td:first-child {
        text-align: center;
        width: 50px;
    }

    .flight-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.15s;
    }

    .flight-table tbody tr:last-child { border-bottom: none; }

    .flight-table tbody tr:hover { background: #f8faff; }

    .flight-table tbody td {
        padding: 14px 16px;
        font-size: 13.5px;
        color: #334155;
        vertical-align: middle;
    }

    /* Airline cell */
    .airline-logo {
        width: 42px; height: 42px;
        border-radius: 10px;
        object-fit: cover;
        border: 1px solid #e2e8f0;
        flex-shrink: 0;
    }

    .airline-logo-placeholder {
        width: 42px; height: 42px;
        border-radius: 10px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 16px;
        flex-shrink: 0;
    }

    .airline-name { font-weight: 600; color: #1e293b; font-size: 14px; }
    .flight-num {
        font-size: 11px;
        color: #94a3b8;
        font-family: monospace;
        margin-top: 2px;
    }

    /* Route cell */
    .route-codes {
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .route-arrow {
        color: #94a3b8;
        font-size: 14px;
    }

    .route-cities {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 3px;
    }

    /* Time cell */
    .time-display {
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .overnight-tag {
        font-size: 10px;
        background: #fef3c7;
        color: #d97706;
        border-radius: 4px;
        padding: 1px 5px;
        font-weight: 600;
    }

    .duration-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #f1f5f9;
        border-radius: 20px;
        padding: 4px 10px;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        white-space: nowrap;
    }

    /* Badges */
    .badge-nonstop {
        background: #dcfce7;
        color: #16a34a;
        border-radius: 6px;
        padding: 4px 10px;
        font-size: 11px;
        font-weight: 600;
    }

    .badge-stop {
        background: #fef9c3;
        color: #ca8a04;
        border-radius: 6px;
        padding: 4px 10px;
        font-size: 11px;
        font-weight: 600;
    }

    .stopover-cities {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 3px;
    }

    .badge-active {
        background: #dcfce7;
        color: #15803d;
        border-radius: 6px;
        padding: 5px 12px;
        font-size: 11px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .badge-active::before {
        content: '';
        width: 6px; height: 6px;
        background: #16a34a;
        border-radius: 50%;
        display: inline-block;
    }

    .badge-inactive {
        background: #fee2e2;
        color: #dc2626;
        border-radius: 6px;
        padding: 5px 12px;
        font-size: 11px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .badge-inactive::before {
        content: '';
        width: 6px; height: 6px;
        background: #dc2626;
        border-radius: 50%;
        display: inline-block;
    }

    /* Action buttons */
    .action-group {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        justify-content: flex-start;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        border-radius: 7px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.18s;
        white-space: nowrap;
    }

    .action-btn:hover {
        transform: translateY(-1px);
        text-decoration: none;
    }

    .btn-schedules {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
    }
    .btn-schedules:hover {
        background: #2563eb;
        color: #fff;
        box-shadow: 0 3px 10px rgba(37,99,235,0.3);
    }

    .btn-classes {
        background: #f0fdf4;
        color: #16a34a;
        border: 1px solid #bbf7d0;
    }
    .btn-classes:hover {
        background: #16a34a;
        color: #fff;
        box-shadow: 0 3px 10px rgba(22,163,74,0.3);
    }

    .btn-edit {
        background: #fafaf9;
        color: #44403c;
        border: 1px solid #d6d3d1;
    }
    .btn-edit:hover {
        background: #44403c;
        color: #fff;
        box-shadow: 0 3px 10px rgba(68,64,60,0.25);
    }

    .btn-delete {
        background: #fff1f2;
        color: #e11d48;
        border: 1px solid #fecdd3;
    }
    .btn-delete:hover {
        background: #e11d48;
        color: #fff;
        box-shadow: 0 3px 10px rgba(225,29,72,0.3);
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #94a3b8;
    }

    .empty-state .empty-icon { font-size: 48px; margin-bottom: 12px; }
    .empty-state h6 { color: #64748b; font-weight: 600; }

    /* Alert */
    .alert-success-custom {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #15803d;
        border-radius: 10px;
        padding: 12px 18px;
        font-size: 14px;
        font-weight: 500;
        margin: 16px 20px 0;
    }

    /* Row number */
    .row-num {
        width: 28px; height: 28px;
        background: #f1f5f9;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
    }

    .timezone {
        font-size: 8px;
        color: #94a3b8;
        background: #f1f5f9;
        padding: 1px 4px;
        border-radius: 4px;
        font-weight: 600;

    }
</style>

<div class="flight-table-wrap">

    {{-- HEADER --}}
    <div class="flight-header">
        <div>
            <h4>✈️ Flight Management</h4>
            <small>Manage all flights, classes and schedules</small>
        </div>
        <a href="{{ route('admin.addflight') }}" class="btn-add-flight">
            + Add Flight
        </a>
    </div>

    {{-- SUCCESS --}}
    @if(session('msg'))
        <div class="alert-success-custom" id="successMsg">
            ✅ {{ session('msg') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="table-responsive" style="padding: 0 0 8px;">
        <table class="flight-table">

            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Airline</th>
                    <th class="text-center">Route</th>
                    <th class="text-center">Timing</th>
                    <th class="text-center">Duration</th>
                    <th class="text-center">Stops</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($flights as $flight)

                @php
                    $dep  = \Carbon\Carbon::parse($flight->departure_time);
                    $arr  = \Carbon\Carbon::parse($flight->arrival_time);
                    if($flight->overnight_arrival) { $arr->addDay(); }
                    $diff = $dep->diff($arr);
                @endphp

                <tr>

                    {{-- # --}}
                    <td>
                        <span class="row-num">{{ $loop->iteration }}</span>
                    </td>

                    {{-- AIRLINE --}}
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            @if($flight->airline_logo)
                                <img src="{{ asset($flight->airline_logo) }}"
                                     class="airline-logo">
                            @else
                                <div class="airline-logo-placeholder">
                                    {{ strtoupper(substr($flight->airline_name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <div class="airline-name">{{ $flight->airline_name }}</div>
                                <div class="flight-num">{{ $flight->flight_number }}</div>
                            </div>
                        </div>
                    </td>

                    {{-- ROUTE --}}
                    <td>
                        <div class="route-codes">
                            {{ $flight->from_airport_code }}
                            <span class="route-arrow">→</span>
                            {{ $flight->to_airport_code }}
                        </div>
                        <div class="route-cities">
                            {{ $flight->from_city }} → {{ $flight->to_city }}
                        </div>
                    </td>

                    {{-- TIMING --}}
                    <td>
                        <div class="time-display">
                            {{ $dep->format('h:i A') }}
                            <span class="timezone">{{ $flight->departure_timezone ? ' '.$flight->departure_timezone : '' }}</span>
                            <span class="route-arrow">→</span>
                            {{ $arr->format('h:i A') }}
                            <span class="timezone">{{ $flight->arrival_timezone ? ' '.$flight->arrival_timezone : '' }}</span>
                            @if($flight->overnight_arrival)
                                <span class="overnight-tag">+1</span>
                            @endif
                        </div>
                    </td>

                    {{-- DURATION --}}
                    <td>

                        <span class="duration-pill">
                            🕐 {{$flight->duration}}
                        </span>
                      {{--  <span class="duration-pill">
                            🕐 {{ $diff->h }}h {{ $diff->i }}m
                        </span> --}}
                    </td>

                    {{-- STOPS --}}
                    <td>
                        @if($flight->stops == 0)
                            <span class="badge-nonstop">Non-stop</span>
                        @else
                            <span class="badge-stop">{{ $flight->stops }} Stop</span>
                            @if($flight->stopover_cities)
                                <div class="stopover-cities">
                                    via {{ implode(', ', json_decode($flight->stopover_cities)) }}
                                </div>
                            @endif
                        @endif
                    </td>

                    {{-- STATUS --}}
                    <td>
                        @if($flight->is_active)
                            <span class="badge-active">Active</span>
                        @else
                            <span class="badge-inactive">Inactive</span>
                        @endif
                    </td>

                    {{-- ACTIONS --}}
                    <td>
                        <div class="action-group">

                            <a href="{{ route('admin.flightschedule.index', $flight->id) }}"
                               class="action-btn btn-schedules">
                                📅 Schedules
                            </a>

                            <a href="{{ route('admin.flightclass.index', $flight->id) }}"
                               class="action-btn btn-classes">
                                🎫 Classes
                            </a>

                            <a href="{{ route('admin.editflight', $flight->id) }}"
                               class="action-btn btn-edit">
                                ✏️ Edit
                            </a>

                            <a href="{{ route('admin.deleteflight', $flight->id) }}"
                               class="action-btn btn-delete"
                               onclick="return confirm('Delete this flight? This will also delete all classes and schedules.')">
                                🗑️ Delete
                            </a>

                        </div>
                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <div class="empty-icon">✈️</div>
                            <h6>No Flights Found</h6>
                            <p style="font-size:13px;">
                                Click <strong>+ Add Flight</strong> to add your first flight.
                            </p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    {{-- FOOTER --}}
    <div style="padding: 14px 20px; border-top: 1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center;">
        <span style="font-size:12px; color:#94a3b8;">
            Total: {{ count($flights) }} flight(s)
        </span>
        <a href="{{ route('dashboard') }}"
           style="font-size:13px; color:#64748b; text-decoration:none; font-weight:500;">
            ← Back to Dashboard
        </a>
    </div>

</div>

<script>
    setTimeout(function () {
        let msg = document.getElementById('successMsg');
        if (msg) {
            msg.style.transition = 'opacity 0.5s';
            msg.style.opacity = '0';
            setTimeout(() => msg.remove(), 500);
        }
    }, 2500);
</script>

@endsection