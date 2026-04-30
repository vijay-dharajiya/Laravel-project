@extends('admin.master')

@section('content')

<div class="container mt-4">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Upload Hotel Images</h4>
        </div>

        <div class="card-body">

            {{-- SUCCESS --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

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

            {{-- UPLOAD FORM --}}
            <form action="{{ route('hotel.images.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">

                    {{-- Select Hotel --}}
                    <div class="col-md-12">
                        <label class="form-label">Select Hotel</label>
                        {{-- ✅ id="hotelSelect" added for JS --}}
                        <select name="hotel_id" id="hotelSelect" class="form-control" required>
                            <option value="">-- Select Hotel --</option>
                            @foreach($hotels as $hotel)
                                <option value="{{ $hotel->id }}"
                                    {{ request('hotel_id') == $hotel->id ? 'selected' : '' }}>
                                    {{ $hotel->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Upload Images --}}
                    <div class="col-md-12">
                        <label class="form-label">Upload New Images</label>
                        <input type="file" name="images[]" id="imageInput" multiple
                               class="form-control"
                               accept="image/jpg,image/jpeg,image/png,image/webp" required>
                        <small class="text-muted">jpg, jpeg, png, webp — multiple allowed</small>
                    </div>

                    {{-- Image Preview --}}
                    <div class="col-md-12">
                        <div id="preview" class="d-flex flex-wrap gap-2 mt-2"></div>
                    </div>

                </div>

                <div class="mt-4 d-flex justify-content-between">
                    <a href="{{ route('admin.viewhotel') }}" class="btn btn-secondary px-4">Back</a>
                    <button type="submit" class="btn btn-success px-4">Upload Images</button>
                </div>

            </form>

            {{-- ✅ EXISTING UPLOADED IMAGES --}}
            @if(request('hotel_id'))
                <hr class="my-4">

                @if($existingImages->count() > 0)
                    <h5 class="mb-3">
                        Already Uploaded Images
                        <span class="badge bg-primary">{{ $existingImages->count() }}</span>
                    </h5>

                    <div class="row g-3">
                        @foreach($existingImages as $img)
                            <div class="col-6 col-md-3 col-lg-2">
                                <div class="card border shadow-sm">
                                    <img src="{{ asset('hotel_images/' . $img->image) }}"
                                         class="card-img-top"
                                         style="height:100px; object-fit:cover;">
                                    <div class="card-body p-1 text-center">
                                        <a href="{{ route('admin.hotelimage.delete', $img->id) }}"
                                           class="btn btn-danger btn-sm w-100"
                                           onclick="return confirm('Delete this image?')">
                                           🗑 Delete
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                @else
                    <div class="alert alert-warning">No images uploaded yet for this hotel.</div>
                @endif
            @endif

        </div>
    </div>
</div>

<script>
    // ✅ Preview before upload
    document.getElementById('imageInput').addEventListener('change', function () {
        const preview = document.getElementById('preview');
        preview.innerHTML = '';

        Array.from(this.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.cssText = 'width:120px;height:90px;object-fit:cover;';
                img.className = 'rounded border';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });

    // ✅ Dropdown change — reload page to show that hotel's images
    document.getElementById('hotelSelect').addEventListener('change', function () {
        if (this.value) {
            window.location.href = '{{ route('admin.hotelimages') }}?hotel_id=' + this.value;
        }
    });
</script>

@endsection