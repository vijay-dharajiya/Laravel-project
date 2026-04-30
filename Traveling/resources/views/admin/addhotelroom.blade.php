@extends('admin.master')

@section('content')

<div class="container mt-5" style="max-width:800px;">

    <h3 class="mb-4 fw-bold text-primary">➕ Add Room</h3>

    {{-- ✅ Success Message --}}
    @if(session('success'))
        <div id="successMsg" style="background:#28a745;color:#fff;padding:12px;border-radius:8px;margin-bottom:15px;">
            ✔ {{ session('success') }}
        </div>
    @endif

    {{-- ❌ Error Message --}}
    @if($errors->any())
        <div style="background:#dc3545;color:#fff;padding:12px;border-radius:8px;margin-bottom:15px;">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>⚠ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-lg p-4" style="border-radius:15px;">

        <form action="{{ route('admin.hotelroom.store') }}" method="POST">
            @csrf

            {{-- Hotel --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Select Hotel</label>
                <select name="hotel_id" class="form-control" required>
                    <option value="">-- Select Hotel --</option>
                    @foreach($hotels as $hotel)
                        <option value="{{ $hotel->id }}">
                            {{ $hotel->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Room Type --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Room Type</label>
                <select name="room_type" class="form-control" required>
                    <option value="">-- Select Room Type --</option>
                    @foreach($room_types as $type)
                        <option value="{{ $type->id }}" 
                            {{ old('room_type') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Capacity --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Capacity (Guests)</label>
                <input type="number" name="capacity" class="form-control" min="1" placeholder="e.g. 2, 4" required>
            </div>

            {{-- Price --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Price ($)</label>
                <input type="number" step="0.01" name="price" class="form-control" min="0" placeholder="e.g. 2999.00" required>
            </div>

            {{-- Total Rooms --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Total Rooms</label>
                <input type="number" name="total_rooms" class="form-control" placeholder="e.g. 10" required>
            </div>

            {{-- Description --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Description</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Room features (AC, WiFi, TV...)"></textarea>
            </div>

            {{-- Status --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Status</label>
                <select name="status" class="form-control">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

            {{-- Submit --}}
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success px-4">Save Room</button>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary px-4">Back</a>
            </div>

        </form>
    </div>
</div>

{{-- ✅ Auto Hide Success Message --}}
<script>
    setTimeout(function(){
        let msg = document.getElementById('successMsg');
        if(msg){
            msg.style.display = 'none';
        }
    }, 3000);
</script>

@endsection