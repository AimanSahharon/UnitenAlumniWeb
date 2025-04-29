@extends('layouts.app')

@section('content')

<!-- Add Card Button (only for admins) -->
@can('isAdmin')
<div class="text-center my-4">
    <a href="{{ url('/admin/home/add') }}" class="btn btn-primary">
        Add Card
    </a>
</div>
@endcan
<!-- White Line -->
<div class="white-line"></div>

<!-- First Card: Uniten Career Portal-->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8"> <!-- Adjust width here -->
            <div class="card mt-3">
                <div class="card-header text-center">{{ __('Uniten Career Portal') }}</div>
                
                <div class="card-body text-center">
                    <a href="http://careers.uniten.edu.my/unicap/#" target="_blank">
                        <img src="{{ asset('images/uniten_career_portal.png') }}" class="img-fluid" alt="Image Description">
                    </a>
                    <div class="small mt-2">Uniten Career Portal</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- White Line -->
<div class="white-line"></div>

<!-- Second Card: Donations -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8"> <!-- Adjust width here -->
            <div class="card mt-3">
                <div class="card-header text-center">{{ __('Donations') }}</div>

                <div class="card-body text-center">
                    
                    <!-- Three Small Images with Labels -->
                    <div class="d-flex justify-content-center gap-4 mb-4">
                        <div>
                            <a href="https://example1.com" target="_blank">
                                <img src="{{ asset('images/ycu.jpg') }}" class="img-thumbnail uniform-img" alt="Small Image 1">
                            </a>
                            <div class="small mt-2">YCU</div>
                        </div>
                        <div>
                            <a href="https://www.amanahuniten.my/" target="_blank">
                                <img src="{{ asset('images/tazu.jpg') }}" class="img-thumbnail uniform-img" alt="Small Image 2">
                            </a>
                            <div class="small mt-2">TAZU</div>
                        </div>
                        <div>
                            <a href="https://example3.com" target="_blank">
                                <img src="{{ asset('images/donation.png') }}" class="img-thumbnail uniform-img" alt="Small Image 3">
                            </a>
                            <div class="small mt-2">WAKAF</div>
                        </div>
                    </div>
                    

                    <!-- Bootstrap Carousel -->
                    <div id="posterCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <a href="https://poster1.com" target="_blank">
                                    <img src="{{ asset('images/posters/alumni-waqf-fund.png') }}" class="d-block w-100" alt="Poster 1">
                                </a>
                            </div>
                            <div class="carousel-item">
                                <a href="https://poster2.com" target="_blank">
                                    <img src="{{ asset('images//posters/keistimewaan-berwakaf.png') }}" class="d-block w-100" alt="Poster 2">
                                </a>
                            </div>
                            <div class="carousel-item">
                                <a href="https://poster3.com" target="_blank">
                                    <img src="{{ asset('images/posters/rak-al-quran.jpg') }}" class="d-block w-100" alt="Poster 3">
                                </a>
                            </div>
                            <div class="carousel-item">
                                <a href="https://poster4.com" target="_blank">
                                    <img src="{{ asset('images/posters/spg.jpg') }}" class="d-block w-100" alt="Poster 4">
                                </a>
                            </div>
                            <div class="carousel-item">
                                <a href="https://poster4.com" target="_blank">
                                    <img src="{{ asset('images/posters/wakaf-alquran.png') }}" class="d-block w-100" alt="Poster 5">
                                </a>
                            </div>
                        </div>
                        <!-- Carousel Controls -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#posterCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#posterCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<!-- White Line -->
<div class="white-line"></div>


<!-- Third Card: IRC-->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8"> <!-- Adjust width here -->
            <div class="card mt-3">
                <div class="card-header text-center">{{ __('IRC') }}</div>
                
                <div class="card-body text-center">
                    <a href="https://lib.uniten.edu.my/ulib/" target="_blank">
                        <img src="{{ asset('images/irc.png') }}" class="img-fluid" alt="Image Description">
                    </a>
                    <div class="small mt-2">IRC</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- White Line -->
<div class="white-line"></div>

<!-- Fourth Card: Advertisements -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8"> <!-- Adjust width here -->
            <div class="card mt-3">
                <div class="card-header text-center">{{ __('Advertisements') }}</div>

                <div class="card-body text-center">
                    
                    <!-- Bootstrap Carousel -->
                    <div id="adsCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <a href="https://poster1.com" target="_blank">
                                    <img src="{{ asset('images/ads/ad1.jpg') }}" class="d-block w-100" alt="adPoster 1">
                                </a>
                            </div>
                            <div class="carousel-item">
                                <a href="https://poster2.com" target="_blank">
                                    <img src="{{ asset('images/ads/ad2.jpg') }}" class="d-block w-100" alt="adPoster 2">
                                </a>
                            </div>
                            <div class="carousel-item">
                                <a href="https://poster3.com" target="_blank">
                                    <img src="{{ asset('images/ads/ad3.jpg') }}" class="d-block w-100" alt="adPoster 3">
                                </a>
                            </div>
                        </div>
                        <!-- Carousel Controls -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#adsCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#adsCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<!-- White Line -->
<div class="white-line"></div>

<!-- Fifth Card: Social Media -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8"> <!-- Adjust width here -->
            <div class="card mt-3">
                <div class="card-header text-center">{{ __('Follow Us on Social Media') }}</div>

                <div class="card-body text-center">
                    
                    <!-- Three Small Images with Labels -->
                    <div class="d-flex justify-content-center gap-4 mb-4">
                        <div>
                            <a href="https://www.instagram.com/uniten.alumni/" target="_blank">
                                <img src="{{ asset('images/instagram.png') }}" class="img-thumbnail uniform-img" alt="Small Image 1">
                            </a>
                            <div class="small mt-2">Instagram</div>
                        </div>
                        <div>
                            <a href="https://www.facebook.com/UNITEN.ALUMNI/?locale=ms_MY" target="_blank">
                                <img src="{{ asset('images/facebook.png') }}" class="img-thumbnail uniform-img" alt="Small Image 2">
                            </a>
                            <div class="small mt-2">Facebook</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- White Line -->
<div class="white-line"></div>

<!-- Sixth Card: Contact Info -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8"> <!-- Adjust width here -->
            <div class="card mt-3">
                <div class="card-header text-center">{{ __('Contact Info') }}</div>
                
                <div class="card-body text-center">
                    <div class="small mt-2">
                        Alumni Relations, Career and Industry Linkage Department <br> 
                        University Tenaga Nasional (UNITEN) <br>
                        | Putrajaya Campus | <br>
                        Level 2, Administration Building, Jalan IKRAM-UNITEN, 43000 Kajang, Selangor, Malaysia <br>
                        Tel: +603-89212020 (ext. 7549) <br>
                        Email: mshaufi@uniten.edu.my
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Custom CSS -->
<style>
    .white-line { /* to create the white line border between the cards  */
        width: 100vw; /* Full width of the viewport */
        height: 2px; /* Adjust thickness */
        background: rgba(255, 255, 255); /* Transparent white */
        margin: 20px 0; /* Spacing between elements */
    }

    .uniform-img { /* To make the images square and uniform for YCU, TAZU and WAKAF */
    width: 80px;   /* Fixed width */
    height: 80px;  /* Fixed height */
    object-fit: cover; /* Ensures the image fits well */
}
</style>





<!--Cards posted by Admin Section-->

@foreach ($cards as $card)
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

@endsection
