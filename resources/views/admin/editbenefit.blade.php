@extends('layouts.app')

@section('content')
<div class="container-wrapper">
    <form action="{{ route('benefits.update', $benefit->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <br>

        <input type="text" name="title" value="{{ old('title', $benefit->title) }}" required class="form-control mb-2">

        <textarea name="content" class="form-control mb-2">{{ old('content', $benefit->content) }}</textarea>

        <label for="images">Upload New Images (optional):</label>
        <input type="file" name="images[]" id="imageInput" multiple accept="image/*" class="form-control mb-3">

        <!-- New section for dynamic URL inputs for new image -->
        <div id="newImageLinks"></div>

        <h5>Existing Images</h5>
        @php
            $images = json_decode($benefit->images, true);
            $links = json_decode($benefit->image_links, true);
        @endphp

        @if ($images)
            @foreach ($images as $index => $image)
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $image) }}" alt="Image {{ $index+1 }}" class="img-thumbnail" style="max-height: 200px;">
                    <br>
                    <label>Link for this image (optional):</label>
                    <input type="url" name="existing_image_links[]" value="{{ $links[$index] ?? '' }}" class="form-control mb-2">

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="delete_images[]" value="{{ $index }}" id="deleteImage{{ $index }}">
                        <label class="form-check-label" for="deleteImage{{ $index }}">
                            Delete this image
                        </label>
                    </div>
                </div>
            @endforeach
        @endif

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Update benefit</button>
        </div>
        <br>
    </form>
</div>

<style>
.container-wrapper {
    max-width: 90%;
    width: 600px;
    margin: 0 auto;
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    justify-content: center;
    align-items: center;
}
</style>

<!-- JavaScript for dynamic new image links -->
<script>
document.getElementById('imageInput').addEventListener('change', function(event) {
    const container = document.getElementById('newImageLinks');
    container.innerHTML = ''; // Clear previous inputs

    const files = event.target.files;

    for (let i = 0; i < files.length; i++) {
        // Create label
        const label = document.createElement('label');
        label.textContent = `Link for new image ${i + 1} (optional):`;

        // Create input
        const input = document.createElement('input');
        input.type = 'url';
        input.name = 'new_image_links[]';
        input.className = 'form-control mb-2';

        // Append label and input
        container.appendChild(label);
        container.appendChild(input);
    }
});
</script>
@endsection
