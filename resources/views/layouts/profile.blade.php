<!-- This layout is for profile page -->
@extends('layouts.app')

@section('content')  
<div class="profile-wrapper">
        <!-- Banner Image -->
     <div class="banner-container">
         <img src="{{ $user->userData->banner_image ? asset('storage/' . $user->userData->banner_image) : asset('default-banner.jpg') }}" 
             class="banner" alt="Banner Picture">
     </div>
 
     <!-- Profile Image -->
     <div class="profile-container">
         <img src="{{ $user->userData->profile_image ? asset('storage/' . $user->userData->profile_image) : asset('default-profile.png') }}" 
             class="profile" alt="Profile Picture">
     </div>
 
     <br><br> <!-- Create spacing between user's name and their profile image -->
     <h2 class="text-center">{{ Auth::user()->name }}</h2>
 
     <!-- Upload Buttons Stacked Vertically with Equal Spacing -->
     <div class="upload-container">
         <form action="{{ route('profile.upload.images') }}" method="POST" enctype="multipart/form-data">
             @csrf
 
             <br>
             <!-- Upload Profile Image Button -->
             <label class="upload-btn">
                 <input type="file" name="profile_image" accept="image/*" id="profileInput" onchange="showFileName(this, 'profileFileName')">
                 Upload Profile Image
             </label>
             <span id="profileFileName" class="file-name">No file selected</span>
 
             <br>
 
             <!-- Upload Banner Image Button -->
             <label class="upload-btn">
                 <input type="file" name="banner_image" accept="image/*" id="bannerInput" onchange="showFileName(this, 'bannerFileName')">
                 Upload Banner Image
             </label>
             <span id="bannerFileName" class="file-name">No file selected</span>
 
             <br>
 
             <!-- Upload Images Button -->
             <button type="submit">Upload Image(s)</button>
         </form>
     </div>
 
     <!-- CSS for Equal Spacing -->
     <style>
         .upload-container {
             display: flex;
             flex-direction: column;
             align-items: center;
             gap: 15px; /* Adds consistent spacing between buttons */
             margin-top: 20px;
         }
 
         .upload-btn, button {
             width: 200px;
             padding: 12px;
             text-align: center;
             border-radius: 5px;
             cursor: pointer;
             display: flex;
             justify-content: center;
             align-items: center;
         }
 
         .upload-btn {
             background-color: #007bff;
             color: white;
         }
 
         .upload-btn input {
             display: none;
         }
 
         .file-name {
             font-size: 14px;
             color: #333;
             margin-top: 5px;
         }
 
         button {
             background-color: #28a745;
             color: white;
             border: none;
         }
 
         button:hover, .upload-btn:hover {
             opacity: 0.8;
         }
     </style>
 
     <!-- JavaScript for Displaying Selected File Name -->
     <script>
         function showFileName(input, fileNameId) {
             const fileNameSpan = document.getElementById(fileNameId);
             if (input.files.length > 0) {
                 fileNameSpan.textContent = input.files[0].name;
             } else {
                 fileNameSpan.textContent = "No file selected";
             }
         }
     </script>
 

    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs mt-4 d-flex justify-content-center" id="ProfileTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link {{ request()->is('profile') ? 'active' : '' }}" 
                href="{{ route('profile', $user->id) }}">
                 Info
             </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link {{ request()->is('myposts') ? 'active' : '' }}" href="{{ route('myposts') }}">Posts</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('myinterestgroup') ? 'active' : '' }}" href="{{ route('myinterestgroup') }}">Interest Group</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('mybusinesslistings') ? 'active' : '' }}" href="{{ route('mybusinesslistings') }}">Business Listing</a>
        </li>
    </ul>
    
    <!-- Dynamic Content Section -->
    <div class="tab-content mt-3">
        @yield('tab-content')
    </div>
</div>

<style> 
    /* Profile Wrapper */
.profile-wrapper {
    max-width: 90%;
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
    top: 230px; /* Adjusts overlap with the banner */
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
    display: block; /* Ensures block-level behavior */
    margin: 20px auto; /* Centers horizontally */
    text-align: center;
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
    display: flex;
    flex-direction: column; /* Stack label and input */
    align-items: flex-start; /* Align labels and inputs on the left */
    width: 100%;
    margin-bottom: 15px; /* Space between fields */
}

.input-group label {
    font-weight: bold;
    margin-bottom: 5px; /* Space between label and input */
}

.input-group input, 
.input-group select, 
.input-group textarea {
    width: 100%; /* Make all inputs take full width */
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

@media screen and (max-width: 200px) {
    .profile-wrapper {
        max-width: 100%;
        margin: 20px;
        padding: 15px;
    }

    .input-group label {
        font-size: 14px;
    }

    .form-container button {
        font-size: 14px;
        padding: 10px;
    }
}

</style>
@endsection
