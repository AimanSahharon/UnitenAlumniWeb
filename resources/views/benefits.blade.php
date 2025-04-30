@extends('layouts.app')

@section('content')
<div class="text-center">
    <h1 class="text-white">BENEFITS</h1>
</div>

@can('isAdmin')
<div class="text-center my-4">
    <a href="{{ url('/admin/benefits/add') }}" class="btn btn-primary">
        Add Card
    </a>
</div>
@endcan




@foreach ($benefits as $card)
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
                        $links = json_decode($card->image_links, true);
                    @endphp

                    @if ($images && count($images) > 0)
                        <div id="carouselCard{{ $card->id }}" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($images as $index => $image)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        @if (!empty($links) && isset($links[$index]) && $links[$index])
                                            <a href="{{ $links[$index] }}" target="_blank">
                                                <img src="{{ asset('storage/' . $image) }}" class="d-block w-100" alt="Card Image {{ $index + 1 }}">
                                            </a>
                                        @else
                                            <img src="{{ asset('storage/' . $image) }}" class="d-block w-100" alt="Card Image {{ $index + 1 }}">
                                        @endif
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

                    @can('isAdmin')
                    <div class="mt-3 d-flex justify-content-center gap-2">
                        <a href="{{ route('benefits.edit', $card->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('benefits.destroy', $card->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this card?');">
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
