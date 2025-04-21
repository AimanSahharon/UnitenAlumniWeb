@extends('layouts.app')

@section('content')
<div class="container-wrapper">
    <div class="container mt-4">
        <h2 class="text-center mb-4">Edit Card</h2>

        <form action="{{ route('cards.update', $card->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Title Field --}}
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="title" 
                    name="title" 
                    value="{{ old('title', $card->title) }}" 
                    required>
            </div>

            {{-- Content Field --}}
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea 
                    class="form-control" 
                    id="content" 
                    name="content" 
                    rows="4">{{ old('content', $card->content) }}</textarea>
            </div>

            {{-- Image Upload --}}
            <div class="mb-3">
                <label for="images" class="form-label">Add New Images</label>
                <input 
                    type="file" 
                    class="form-control" 
                    name="images[]" 
                    id="images" 
                    multiple>
            </div>

            @if ($card->images)
    @php
        $images = json_decode($card->images, true);
    @endphp

                <div class="mb-3">
                    <label class="form-label">Existing Images</label>
                    <div class="row">
                        @foreach ($images as $index => $image)
                            <div class="col-md-6 mb-3 text-center">
                                <img src="{{ asset('storage/' . $image) }}" class="img-fluid rounded mb-2" style="max-height: 150px;">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="delete_images[]" value="{{ $image }}" id="delete_{{ $index }}">
                                    <label class="form-check-label" for="delete_{{ $index }}">
                                        Delete
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Submit --}}
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary me-2">Update</button>
                <a href="{{ url('/admin/home') }}" class="btn btn-secondary">Cancel</a>
            </div>
            <br> <!--create some space between buttons and edge of container wrapper. Without this the edge of the container wrapper touches the bottom edges of the buttons -->
        </form>
    </div>
</div>

<style>
.container-wrapper {
    max-width: 90%;
    width: 600px; /* Set max width similar to Twitter */
    margin: 0 auto; /* Center it */
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    justify-content: center;
    align-items: center;
}
</style>
@endsection
