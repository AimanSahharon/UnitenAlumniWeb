@extends('layouts.profile')

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

        <!-- Tabs Navigation (List out all the tabs) -->
    <ul class="nav nav-tabs mt-4 d-flex justify-content-center" id="profileTabs" role="tablist"> <!-- d-flex justify-content-center is to center the tabs -->
        <!-- Info Tab -->
        <li class="nav-item">
            <a class="nav-link active" id="info-tab" data-bs-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="true">Info</a>
        </li>
        <!-- Posts Tab -->
        <li class="nav-item">
            <a class="nav-link" id="posts-tab" data-bs-toggle="tab" href="#posts" role="tab" aria-controls="posts" aria-selected="false">Posts</a>
        </li>
        <!-- Interest Group Tab -->
        <li class="nav-item">
            <a class="nav-link" id="interest-group-tab" data-bs-toggle="tab" href="#interest-group" role="tab" aria-controls="interest-group" aria-selected="false">Interest Group</a>
        </li>
        <!-- Business Listings Tab -->
        <li class="nav-item">
            <a class="nav-link" id="business-listings-tab" data-bs-toggle="tab" href="#business-listings" role="tab" aria-controls="business-listings" aria-selected="false">Business Listing</a>
        </li>
    </ul>

        <!-- Tabs Content -->
        <div class="tab-content mt-3" id="profileTabsContent">
            <!-- Info Tab -->
            <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                <!-- to edit user information --> 
            <div class="form-container">
                <h2>User Profile: {{ Auth::user()->name }}</h2>

                @if(session('success'))
                    <p style="color: green;">{{ session('success') }}</p>
                @endif

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- IC or Passport textbox but cannot edit -->
                    <div class="input-group">
                        <label for="ic_passport"><strong>IC or Passport Number:</strong></label>
                        <input type="text" name="ic_passport" value="{{ $user->userData->ic_passport ?? '' }}" readonly>
                    </div>
                    
                    <!-- Full Name textbox -->
                    <div class="input-group">
                        <label for="full_name"><strong>Full Name:</strong></label>
                        <input type="text" name="full_name" value="{{ $user->userData->full_name ?? '' }}" required>
                    </div>

                    <!-- Student ID textbox -->
                    <div class="input-group">
                        <label for="student_id"><strong>Student ID:</strong></label>
                        <input type="text" name="student_id" value="{{ $user->userData->student_id ?? '' }}" required>
                    </div>

                    <!-- Year of Graduation textbox -->
                    <div class="input-group">
                        <label for="year_of_graduation"><strong>Year of Graduation:</strong></label>
                        <input type="number" name="year_of_graduation" value="{{ $user->userData->year_of_graduation ?? '' }}" required
                        min="1900" 
                        max="{{ date('Y') }}" 
                        oninput="if(this.value.length > 4) this.value = this.value.slice(0,4)">
                    </div>

                    <!-- Email Address textbox -->
                    <div class="input-group">
                        <label for="email_address"><strong>Email Address:</strong></label>
                        <input type="email" name="email_address" value="{{ $user->userData->email_address ?? '' }}" required>
                    </div>

                    <!-- Mobile Number textbox -->
                    <div class="input-group">
                        <label for="mobile_number"><strong>Mobile Number:</strong></label>
                        <input type="text" name="mobile_number" value="{{ $user->userData->mobile_number ?? '' }}" required>
                    </div>

                    <!-- Permanent Address textbox -->
                    <div class="input-group">
                        <label for="permanent_address"><strong>Permanent Address:</strong></label>
                        <textarea name="permanent_address" rows="3" required>{{ $user->userData->permanent_address ?? '' }}</textarea>
                    </div>

                    <!-- College dropdown menu -->
                    <div class="input-group">
                        <label for="college"><strong>College:</strong></label>
                        <select name="college" required>
                            <option value="" disabled selected>Please select your college</option>
                            <option value="COE" {{ ($user->userData->college ?? '') == 'COE' ? 'selected' : '' }}>COE</option>
                            <option value="CCI/CSIT/COIT" {{ ($user->userData->college ?? '') == 'CCI/CSIT/COIT' ? 'selected' : '' }}>CCI/CSIT/COIT</option>
                            <option value="UBS/COBA" {{ ($user->userData->college ?? '') == 'UBS/COBA' ? 'selected' : '' }}>UBS/COBA</option>
                            <option value="COGS" {{ ($user->userData->college ?? '') == 'COGS' ? 'selected' : '' }}>COGS</option>
                        </select>
                    </div>

                    <!-- Education Level dropdown menu -->
                    <div class="input-group">
                        <label for="education_level"><strong>Education Level:</strong></label>
                        <select name="education_level" required>
                            <option value="" disabled selected>Please select your education level</option>
                            <option value="Diploma" {{ ($user->userData->education_level ?? '') == 'Diploma' ? 'selected' : '' }}>Diploma</option>
                            <option value="Sarjana Muda" {{ ($user->userData->education_level ?? '') == 'Sarjana Muda' ? 'selected' : '' }}>Sarjana Muda</option>
                            <option value="Sarjana" {{ ($user->userData->education_level ?? '') == 'Sarjana' ? 'selected' : '' }}>Sarjana</option>
                            <option value="PhD" {{ ($user->userData->education_level ?? '') == 'PhD' ? 'selected' : '' }}>PhD</option>
                        </select>
                    </div>

                    <!-- Name of Programme dropdown menu -->
                    <div class="input-group">
                        <label for="name_of_programme"><strong>Name of Programme:</strong></label>
                        <select name="name_of_programme" required>
                            <option value="" disabled selected>Please select your programme</option>
                            <option value="Bachelor in Accounting" {{ ($user->userData->name_of_programme ?? '') == 'Bachelor in Accounting' ? 'selected' : '' }}>Bachelor in Accounting</option>
                            <option value="Bachelor of Business Administration (Hons.) in Human Resource Management" {{ ($user->userData->name_of_programme ?? '') == 'Bachelor of Business Administration (Hons.) in Human Resource Management' ? 'selected' : '' }}>Bachelor of Business Administration (Hons.) in Human Resource Management</option>
                            <option value="Diploma in Business Studies" {{ ($user->userData->name_of_programme ?? '') == 'Diploma in Business Studies' ? 'selected' : '' }}>Diploma in Business Studies</option>
                            <option value="Diploma in Computer Science" {{ ($user->userData->name_of_programme ?? '') == 'Diploma in Computer Science' ? 'selected' : '' }}>Diploma in Computer Science</option>
                        </select>
                    </div>

                    <!-- Current Employment Status dropdown menu -->
                    <div class="input-group">
                        <label for="current_employment_status"><strong>Current Employment Status:</strong></label>
                        <select name="current_employment_status" required>
                            <option value="" disabled selected>Please select your current employment status</option>
                            <option value="Employed" {{ ($user->userData->current_employment_status ?? '') == 'Employed' ? 'selected' : '' }}>Employed</option>
                            <option value="Self-Employed (Entrepreneur)" {{ ($user->userData->current_employment_status ?? '') == 'Self-Employed (Entrepreneur)' ? 'selected' : '' }}>Self-Employed (Entrepreneur)</option>
                            <option value="Not Employed" {{ ($user->userData->current_employment_status ?? '') == 'Not Employed' ? 'selected' : '' }}>Not Employed</option>
                        </select>
                    </div>
                    
                    <!-- Current Employment Level dropdown menu -->
                    <div class="input-group">
                        <label for="employment_level"><strong>Current Employment Level:</strong></label>
                        <select name="employment_level" required>
                            <option value="" disabled selected>Please select your employment level</option>
                            <option value="High Skilled (eg. Managers/legislators, professionals and technicians)" {{ ($user->userData->employment_level ?? '') == 'High Skilled (eg. Managers/legislators, professionals and technicians)' ? 'selected' : '' }}>High Skilled (eg. Managers/legislators, professionals and technicians)</option>
                            <option value="Semi Skilled (eg. Clerical, service and sales)" {{ ($user->userData->employment_level ?? '') == 'Semi Skilled (eg. Clerical, service and sales)' ? 'selected' : '' }}>Semi Skilled (eg. Clerical, service and sales)</option>
                            <option value="Low Skilled (eg. Farmers, fisheries, craft and related trades, plant and machine operators and elementary occupations)" {{ ($user->userData->employment_level ?? '') == 'Low Skilled (eg. Farmers, fisheries, craft and related trades, plant and machine operators and elementary occupations)' ? 'selected' : '' }}>Low Skilled (eg. Farmers, fisheries, craft and related trades, plant and machine operators and elementary occupations)</option>
                        </select>
                    </div>

                    <!-- Employment Sector dropdown menu -->
                    <div class="input-group">
                        <label for="employment_sector"><strong>Employment Sector:</strong></label>
                        <select name="employment_sector" required>
                            <option value="" disabled selected>Please select your employment sector</option>
                            <option value="Public Sector" {{ ($user->userData->employment_sector ?? '') == 'Public Sector' ? 'selected' : '' }}>Public Sector</option>
                            <option value="Private Sector" {{ ($user->userData->employment_sector ?? '') == 'Private Sector' ? 'selected' : '' }}>Private Sector</option>
                        </select>
                    </div>

                    <!-- Occupational Field dropdown menu -->
                    <div class="input-group">
                        <label for="occupational_field"><strong>Occupational Field:</strong></label>
                        <select name="occupational_field" required>
                            <option value="" disabled selected>Please select your occupational field</option>
                            <option value="Agriculture" {{ ($user->userData->occupational_field ?? '') == 'Agriculture' ? 'selected' : '' }}>Agriculture</option>
                            <option value="Mining and Quarrying" {{ ($user->userData->occupational_field ?? '') == 'Mining and Quarrying' ? 'selected' : '' }}>Mining and Quarrying</option>
                            <option value="Manufacturing" {{ ($user->userData->occupational_field ?? '') == 'Manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                            <option value="Construction" {{ ($user->userData->occupational_field ?? '') == 'Construction' ? 'selected' : '' }}>Construction</option>
                            <option value="Services" {{ ($user->userData->occupational_field ?? '') == 'Services' ? 'selected' : '' }}>Services</option>
                        </select>
                    </div>
                    
                    <!-- Range of Salary dropdown menu -->
                    <div class="input-group">
                        <label for="range_of_salary"><strong>Range of Salary:</strong></label>
                        <select name="range_of_salary" required>
                            <option value="" disabled selected>Please select your range of salary</option>
                            <option value="Less than RM4,800" {{ ($user->userData->range_of_salary ?? '') == 'Less than RM4,800' ? 'selected' : '' }}>Less than RM4,800</option>
                            <option value="RM4,801 - RM10,970" {{ ($user->userData->range_of_salary ?? '') == 'RM4,801 - RM10,970' ? 'selected' : '' }}>RM4,801 - RM10,970</option>
                            <option value="More than RM10,970" {{ ($user->userData->range_of_salary ?? '') == 'More than RM10,970' ? 'selected' : '' }}>More than RM10,970</option>
                        </select>
                    </div>
                    <!-- Position or Designation textbox -->
                    <div class="input-group">
                        <label for="position_designation"><strong>Position or Designation:</strong></label>
                        <input type="text" name="position_designation" value="{{ $user->userData->position_designation ?? '' }}" required>
                    </div>

                    <!-- Name of Organization textbox -->
                    <div class="input-group">
                        <label for="name_of_organisation"><strong>Name of Organisation:</strong></label>
                        <input type="text" name="name_of_organisation" value="{{ $user->userData->name_of_organisation ?? '' }}" required>
                    </div>

                    <!-- Location of Workplace textbox -->
                    <div class="input-group">
                        <label for="location_of_workplace"><strong>Location of Workplace:</strong></label>
                        <textarea name="location_of_workplace" rows="3" required>{{ $user->userData->location_of_workplace ?? '' }}</textarea>
                    </div>

                    <button type="submit">Update Profile</button>
                </form>
            </div>
        </div>





                <!-- Post Tab Content -->
        <div class="tab-pane fade" id="posts" role="tabpanel" aria-labelledby="posts-tab">
            <p>This is a blank page for now. Insert user's posts here.</p>
        </div>


        <!-- Interest Group Tab Content -->
        <div class="tab-pane fade" id="interest-group" role="tabpanel" aria-labelledby="interest-group-tab">
            <p>This is a blank page for now. Insert user's joined groups here.</p>
        </div>

        <!-- Business Listings Tab Content -->
        <div class="tab-pane fade" id="business-listings" role="tabpanel" aria-labelledby="business-listings-tab">
            <p>This is a blank page for now. Insert user's business listings here.</p>
        </div>


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
