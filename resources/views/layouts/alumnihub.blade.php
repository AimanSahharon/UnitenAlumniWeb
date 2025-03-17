@extends('layouts.app')

@section('content')  
<div class="profile-wrapper">
    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs mt-4 d-flex justify-content-center" id="ConnectAlumniTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link {{ request()->is('connectalumni') ? 'active' : '' }}" href="{{ route('connectalumni') }}">Connect Alumni</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('posts') ? 'active' : '' }}" href="{{ route('posts') }}">Posts</a>
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
        width: 600px;
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
</style>
@endsection
