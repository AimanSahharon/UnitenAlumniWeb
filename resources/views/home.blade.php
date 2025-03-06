@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- First Card -->
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- White Line -->
<div class="white-line"></div>

<!-- Second Card -->
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

<!-- Third Card -->
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
                            <a href="https://example2.com" target="_blank">
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


<!-- Fourth Card -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8"> <!-- Adjust width here -->
            <div class="card mt-3">
                <div class="card-header text-center">{{ __('IRC') }}</div>
                
                <div class="card-body text-center">
                    <a href="http://careers.uniten.edu.my/unicap/#" target="_blank">
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

<!-- Fifth Card -->
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

<!-- Sixth Card -->
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

<!-- Seventh Card -->
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
@endsection
