@extends('admin.master')

@section('content')

<div class="container mt-4">
    <div class="card shadow-lg border-0">
        
        <!-- HEADER -->
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Flight List</h4>
            <a href="{{ route('admin.addflight') }}" class="btn btn-warning btn-sm fw-bold">
                + Add Flight
            </a>
        </div>

        <div class="card-body">

            {{-- SUCCESS --}}
            @if(session('msg'))
                <div class="alert alert-success alert-dismissible fade show" id="successMsg">
                    {{ session('msg') }}
                </div>
            @endif

            {{-- TABLE --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">

                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Flight</th>
                            <th>Route</th>
                            <th>Time</th>
                            <th>Duration</th>
                            <th>Stops</th>
                            <th>Price</th>
                            <th colspan="2">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($flights as $flight)

                        @php
                            $dep = \Carbon\Carbon::parse($flight->departure_time);
                            $arr = \Carbon\Carbon::parse($flight->arrival_time);

                            if($arr->lessThan($dep)){
                                $arr->addDay();
                            }

                            $diff = $dep->diff($arr);
                        @endphp

                        <tr>

                            <!-- NO -->
                            <td>{{ $loop->iteration }}</td>

                            <!-- FLIGHT (NO IMAGE) -->
                            <td class="text-start">
                                <strong>{{ $flight->airline_name }}</strong><br>
                                <small class="text-muted">{{ $flight->flight_no }}</small>
                            </td>

                            <!-- ROUTE -->
                            <td>
                                <span class="badge bg-light text-dark px-3 py-2">
                                    {{ $flight->from_city }}
                                </span>
                                →
                                <span class="badge bg-light text-dark px-3 py-2">
                                    {{ $flight->to_city }}
                                </span>
                            </td>

                            <!-- TIME -->
                            <td>
                                <div class="d-flex flex-column align-items-center">

                                    <strong>{{ $dep->format('h:i A') }}</strong>

                                    <div class="d-flex align-items-center gap-2 my-1">
                                        <hr style="width:40px; margin:0;">
                                        <small class="text-muted fw-bold">TO</small>
                                        <hr style="width:40px; margin:0;">
                                    </div>

                                    <small class="text-muted">{{ $arr->format('h:i A') }}</small>

                                </div>
                            </td>

                            <!-- DURATION -->
                            <td>
                                {{ $diff->h }}h {{ $diff->i }}m
                            </td>

                            <!-- STOPS -->
                            <td>
                                <span class="badge bg-danger">
                                    {{ $flight->stops ?? 'Non-stop' }}
                                </span>
                            </td>

                            <!-- PRICE -->
                            <td>
                                <strong class="text-success">
                                    ${{ number_format($flight->price) }}
                                </strong>
                            </td>

                            <!-- EDIT -->
                            <td>
                                <a href="{{ route('admin.editflight', $flight->id) }}" 
                                   class="btn btn-sm btn-primary">
                                   Edit
                                </a>
                            </td>

                            <!-- DELETE -->
                            <td>
                                <a href="{{ route('admin.deleteflight', $flight->id) }}" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Delete this flight?')">
                                   Delete
                                </a>
                            </td>

                        </tr>

                        @empty
                        <tr>
                            <td colspan="9" class="text-muted">No Flights Found</td>
                        </tr>
                        @endforelse

                    </tbody>

                </table>
            </div>

            <!-- BACK -->
            <a href="{{ route('dashboard') }}" class="btn btn-secondary mt-3">
                Back
            </a>

        </div>
    </div>
</div>

<style>
.table td {
    vertical-align: middle;
}
</style>

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