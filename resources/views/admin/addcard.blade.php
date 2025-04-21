@extends('layouts.app')


@section('content')
<form action="{{ route('cards.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="text" name="title" placeholder="Card Title" required class="form-control mb-2">
    <textarea name="content" placeholder="Optional Text" class="form-control mb-2"></textarea>
    <input type="file" name="images[]" multiple accept="image/*" class="form-control mb-2">
    <button type="submit" class="btn btn-primary">Add Card</button>
</form>

    
@endsection