@extends('layouts.profile')

@section('content')  
<div class="profile-wrapper">
    <div class="form-container">
        <h2>User Profile</h2>

        @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="input-group">
                <label for="full_name"><strong>Full Name:</strong></label>
                <input type="text" name="full_name" value="{{ $user->userData->full_name ?? '' }}" required>
            </div>

            <div class="input-group">
                <label for="student_id"><strong>Student ID:</strong></label>
                <input type="text" name="student_id" value="{{ $user->userData->student_id ?? '' }}" required>
            </div>
            <!--
            <label for="student_id"><strong>Student ID:</strong></label>
            <input type="text" id="student_id" name="student_id" value="{{ $user->userData->student_id ?? '' }}" required> -->

            <button type="submit">Update Profile</button>
        </form>
    </div>
</div>


<style> 
    /* Profile Wrapper */
.profile-wrapper {
    width: 600px; /* Set max width similar to Twitter */
    margin: 0 auto; /* Center it */
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    justify-content: center;
    align-items: center;
}

/* Banner Image */
.banner-container {
    width: 100%;
    height: 200px; /* Set banner height */
    position: relative;
    overflow: hidden;
    background: #f5f5f5; /* Light grey background in case no banner */
}

.banner {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Ensures the image covers the div */
}

/* Profile Image */
.profile-container {
    position: absolute;
    top: 200px; /* Adjusts overlap with the banner */
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

/* Form Styling */
.form-container {
    margin-top: 70px;
    padding: 20px;
    text-align: center;
}

.form-container input {
    display: block;
    margin: 10px auto;
} 

.form-container button {
    background: #1da1f2; /* Twitter blue */
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.form-container button:hover {
    background: #0d8ae5;
}

.input-group {
    display: flex;
    align-items: center; /* Aligns text and input in the same line */
    gap: 10px; /* Adds spacing between the label and input */
    justify-content: center; /* Centers horizontally */
    width: 100%; /* Ensures it takes up full width */
}

</style>












@endsection
