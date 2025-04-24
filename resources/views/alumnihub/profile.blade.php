<!-- This is to display Alumni's profile afer user select user from Connect Alumni Page -->

@extends('layouts.alumnihub')

@section('tab-content')
<div class="profile-wrapper">
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

    <br><br> <!-- Create spacing between user's name and their profile image -->
    <h2 class="text-center unselectable">{{ $alumnus->full_name }}</h2>

    <!-- Profile Information Section -->
    <div class="info-container">
        <div class="info-item">
            <span class="label">Graduation Year:</span>
            <span class="value @cannot('isAdmin') unselectable @endcannot">{{ $alumnus->year_of_graduation }}</span> <!--Only admin can highlight or select the data while normal user cannot select or copy data-->
        </div>
        <div class="info-item">
            <span class="label">College:</span>
            <span class="value @cannot('isAdmin') unselectable @endcannot">{{ $alumnus->college }}</span>
        </div>
        <div class="info-item">
            <span class="label">Education Level:</span>
            <span class="value @cannot('isAdmin') unselectable @endcannot">{{ $alumnus->education_level }}</span>
        </div>
        <div class="info-item">
            <span class="label">Programme:</span>
            <span class="value @cannot('isAdmin') unselectable @endcannot">{{ $alumnus->name_of_programme }}</span>
        </div>
        @can("isAdmin") <!--Admin can view more details about this alumni and only admin can view sensitive information-->
        <div class="info-item">
            <span class="label">IC or Passport Number:</span>
            <span class="value">{{ $alumnus->ic_passport }}</span>
        </div>

        <div class="info-item">
            <span class="label">Student ID:</span>
            <span class="value">{{ $alumnus->student_id }}</span>
        </div>

        <div class="info-item">
            <span class="label">Email Address:</span>
            <span class="value">{{ $alumnus->email_address }}</span>
        </div>

        <div class="info-item">
            <span class="label">Mobile Number:</span>
            <span class="value">{{ $alumnus->mobile_number }}</span>
        </div>

        <div class="info-item">
            <span class="label">Permanent Address:</span>
            <span class="value">{{ $alumnus->permanent_address }}</span>
        </div>

        <div class="info-item">
            <span class="label">Current Employment Status:</span>
            <span class="value">{{ $alumnus->current_employment_status }}</span>
        </div>

        <div class="info-item">
            <span class="label">Current Employment Level:</span>
            <span class="value">{{ $alumnus->employment_level }}</span>
        </div>

        <div class="info-item">
            <span class="label">Employment Sector:</span>
            <span class="value">{{ $alumnus->employment_sector }}</span>
        </div>

        <div class="info-item">
            <span class="label">Occupational Field:</span>
            <span class="value">{{ $alumnus->occupational_field }}</span>
        </div>

        <div class="info-item">
            <span class="label">Range of Salary:</span>
            <span class="value">{{ $alumnus->range_of_salary }}</span>
        </div>

        <div class="info-item">
            <span class="label">Position or Designation:</span>
            <span class="value">{{ $alumnus->position_designation }}</span>
        </div>

        <div class="info-item">
            <span class="label">Name of Organisation:</span>
            <span class="value">{{ $alumnus->name_of_organisation }}</span>
        </div>

        <div class="info-item">
            <span class="label">Location of Workplace:</span>
            <span class="value">{{ $alumnus->location_of_workplace }}</span>
        </div>
        @endcan
    </div>

    <a href="{{ route('connectalumni') }}" class="btn btn-secondary">Back to Search</a>
    <br><br> <!--to create some space below-->
</div>

<!-- CSS to Style Profile Page -->
<style>
    .profile-wrapper {
        max-width: 90%;
        width: 600px;
        margin: 0 auto;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        text-align: center;
    }

    /* Banner */
    .banner-container {
        width: 100%;
        height: 200px;
        position: relative;
        overflow: hidden;
        background: #f5f5f5;
    }

    .banner {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Profile Image */
    .profile-container {
        position: absolute;
        top: 250px;
        left: 40%;
        transform: translateX(-50%);
        width: 120px;
        height: 120px;
        border-radius: 50%;
        overflow: hidden;
        background: white;
        border: 4px solid white;
    }

    .profile {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    /* Profile Information */
    .info-container {
        margin-top: 60px;
        padding: 20px;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f9f9f9;
        padding: 10px 15px;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    .label {
        font-weight: bold;
        color: #333;
    }

    .value {
        color: #555;
        font-size: 16px;
    }

    /* Prevent text selection & copying */
    .unselectable {
        user-select: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        pointer-events: none;
    }
</style>


@endsection
