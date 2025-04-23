@extends('layouts.app')


@section('content')
<div class="container-wrapper">
    <form action="{{ route('cards.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <br>
        <input type="text" name="title" placeholder="Card Title" required class="form-control mb-2">
        <textarea name="content" placeholder="Optional Text" class="form-control mb-2"></textarea>
        <input type="file" name="images[]" multiple accept="image/*" class="form-control mb-2">
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Add Card</button>
        </div>
        <br>
    </form>
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