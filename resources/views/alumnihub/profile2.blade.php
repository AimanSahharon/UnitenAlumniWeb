@extends('layouts.alumnihub')

@section('tab-content')
<div class="container">

    <h2>{{ $alumnus->full_name }}'s Profile</h2>


    <!-- Banner Image -->
    <div class="banner-container">
        <img src="{{ $alumnus->banner_image ? asset('storage/' . $alumnus->banner_image) : asset('default-banner.jpg') }}" 
            class="banner" alt="Banner Picture">
    </div>

    <!-- Profile Image -->
    <div class="profile-container">
        <img src="{{ $alumnus->profile_image ? asset('storage/' . $alumnus->profile_image) : asset('default-profile.png') }}" 
            class="profile" alt="Profile Picture">
    </div>

    <!-- Styling for Banner and Profile Image -->
<style>
    .banner-container {
        width: 100%;
        height: 250px;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f4f4f4;
    }
    .banner {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .profile-container {
        position: relative;
        width: 150px;
        height: 150px;
        margin: -75px auto 20px;
        border-radius: 50%;
        overflow: hidden;
        border: 5px solid white;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }
    .profile {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

    <table class="table table-bordered">
        <tr>
            <th>Name</th>
            <td>{{ $alumnus->full_name }}</td>
        </tr>
        <tr>
            <th>Graduation Year</th>
            <td>{{ $alumnus->year_of_graduation }}</td>
        </tr>
        <tr>
            <th>College</th>
            <td>{{ $alumnus->college }}</td>
        </tr>
        <tr>
            <th>Education Level</th>
            <td>{{ $alumnus->education_level }}</td>
        </tr>
        <tr>
            <th>Programme</th>
            <td>{{ $alumnus->name_of_programme }}</td>
        </tr>
    </table>

    <a href="{{ route('connectalumni') }}" class="btn btn-secondary">Back to Search</a>
</div>
@endsection
