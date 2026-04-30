@extends('admin.master')

@section('content')

<style>
.preview-box {
    position: relative;
    display: inline-block;
}
.preview-img {
    width: 110px;
    height: 80px;
    object-fit: cover;
    border-radius: 10px;
    border: 2px solid #eee;
}
.remove-btn {
    position: absolute;
    top: 5px;
    right: 5px;
    background: red;
    color: #fff;
    border: none;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    font-size: 14px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>

<div class="container mt-5" style="max-width:800px;">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">🏨 Upload Room Images</h4>
        </div>

        <div class="card-body">

            {{-- Success --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Errors --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $err)
                        <div>⚠ {{ $err }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.roomimages.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Step 1: Select Hotel --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Step 1 — Select Hotel</label>
                    <select name="hotel_id" id="hotelSelect" class="form-control" required>
                        <option value="">-- Select Hotel --</option>
                        @foreach($hotels as $hotel)
                            <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Step 2: Select Room (loads via AJAX) --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Step 2 — Select Room</label>
                    <select name="room_id" id="roomSelect" class="form-control" required>
                        <option value="">-- First select a hotel --</option>
                    </select>
                    <small class="text-muted">Rooms will load after selecting hotel</small>
                </div>

                {{-- Step 3: Upload Images --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Step 3 — Upload Images</label>
                    <input type="file" id="imageInput" name="images[]"
                           class="form-control" multiple
                           accept="image/jpg,image/jpeg,image/png,image/webp">
                    <small class="text-muted">First image will be set as primary automatically</small>
                </div>

                {{-- Preview --}}
                <div id="preview" class="d-flex flex-wrap gap-3 mb-3"></div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary px-4">Back</a>
                    <button type="submit" class="btn btn-success px-4">🚀 Upload Images</button>
                </div>

            </form>
        </div>
    </div>
</div>
<script>
let selectedFiles = [];

document.getElementById('hotelSelect').addEventListener('change', function () {
    const hotelId    = this.value;
    const roomSelect = document.getElementById('roomSelect');

    if (!hotelId) {
        roomSelect.innerHTML = '<option value="">-- First select a hotel --</option>';
        return;
    }

    roomSelect.innerHTML = '<option value="">-- Loading rooms... --</option>';

    // ✅ Matches your working URL exactly
    const url = `{{ url('/admin/rooms-by-hotel') }}/${hotelId}`;

    fetch(url, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => {
        if (!res.ok) throw new Error('HTTP ' + res.status);
        return res.json();
    })
    .then(rooms => {
        roomSelect.innerHTML = '<option value="">-- Select Room --</option>';

        if (rooms.length === 0) {
            roomSelect.innerHTML = '<option value="">No rooms found for this hotel</option>';
            return;
        }

        // ✅ room_name matches your JSON response exactly
        rooms.forEach(room => {
            roomSelect.innerHTML += `<option value="${room.id}">${room.room_name}</option>`;
        });
    })
    .catch(err => {
        console.error('AJAX error:', err);
        roomSelect.innerHTML = '<option value="">Error — check console</option>';
    });
});

document.getElementById('imageInput').addEventListener('change', function (e) {
    selectedFiles = Array.from(e.target.files);
    renderPreview();
});

function renderPreview() {
    const preview = document.getElementById('preview');
    preview.innerHTML = '';

    selectedFiles.forEach((file, index) => {
        const box = document.createElement('div');
        box.className = 'preview-box';

        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.className = 'preview-img';

        if (index === 0) {
            const badge = document.createElement('span');
            badge.innerText = '⭐ Primary';
            badge.style.cssText = 'position:absolute;bottom:5px;left:5px;background:gold;color:#000;font-size:10px;padding:2px 5px;border-radius:5px;';
            box.appendChild(badge);
        }

        const removeBtn = document.createElement('button');
        removeBtn.innerHTML = '×';
        removeBtn.className = 'remove-btn';
        removeBtn.type = 'button';
        removeBtn.onclick = function () {
            selectedFiles.splice(index, 1);
            updateFileInput();
            renderPreview();
        };

        box.appendChild(img);
        box.appendChild(removeBtn);
        preview.appendChild(box);
    });
}

function updateFileInput() {
    const input = document.getElementById('imageInput');
    const dt    = new DataTransfer();
    selectedFiles.forEach(file => dt.items.add(file));
    input.files = dt.files;
}
</script>
@endsection