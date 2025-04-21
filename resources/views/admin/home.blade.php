@extends('layouts.app')

@section('content')
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->


<!-- Add Card Button (only for admins) -->
@can('isAdmin')
<div class="text-center my-4">
    <a href="{{ url('/admin/home/add') }}" class="btn btn-primary">
        Add Card
    </a>
</div>
@endcan


@foreach ($cards as $card)
<!-- White Line OUTSIDE container -->
<div class="white-line"></div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-3">
                <div class="card-header text-center">{{ $card->title }}</div>
                <div class="card-body text-center">
                    @if ($card->content)
                        <p>{{ $card->content }}</p>
                    @endif

                    @php
                        $images = json_decode($card->images, true);
                    @endphp

                    @if ($images && count($images) > 0)
                        <div id="carouselCard{{ $card->id }}" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($images as $index => $image)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/' . $image) }}" class="d-block w-100" alt="Card Image {{ $index + 1 }}">
                                </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselCard{{ $card->id }}" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselCard{{ $card->id }}" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    @endif
                    {{-- Only admins see Edit/Delete buttons --}}
                    @can('isAdmin')
                    <div class="mt-3 d-flex justify-content-center gap-2">
                        <a href="{{ route('cards.edit', $card->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('cards.destroy', $card->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this card?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>
                    @endcan

                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

<!--Add white line between the cards-->
<style> 
    .white-line {
        width: 100vw;
        height: 2px;
        background: white;
        margin: 20px 0;
    }
</style>
@endsection
