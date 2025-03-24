<!-- This layout is for Alumni Hub Page -->
@extends('layouts.app')

@section('content')  
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<div class="profile-wrapper">
    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs mt-4 d-flex justify-content-center" id="ConnectAlumniTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link {{ request()->is('connectalumni') ? 'active' : '' }}" href="{{ route('connectalumni') }}">Connect Alumni</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('posts.view') ? 'active' : '' }}" href="{{ route('posts.view') }}">Posts</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('interestgroup') ? 'active' : '' }}" href="{{ route('interestgroup') }}">Interest Group</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('businesslistings') ? 'active' : '' }}" href="{{ route('businesslistings') }}">Business Listing</a>
        </li>
    </ul>
    
    <!-- Dynamic Content Section -->
    <div class="tab-content mt-3">
        @yield('tab-content')
    </div>
</div>

<style> 
    .profile-wrapper {
        max-width: 90%;
        width:600px; /*change width of the profile wrapper white box*/
        margin: 0 auto;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        justify-content: center;
        align-items: center;
    }

    @media screen and (max-width: 200px) {
        .profile-wrapper {
            max-width: 100%;
            margin: 20px;
            padding: 15px;
        }
    }

    .form-container button {
    background: #1da1f2; /* Twitter blue */
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    display: block; /* Ensures block-level behavior */
    margin: 20px auto; /* Centers horizontally */
    text-align: center;
}
</style>
@endsection
