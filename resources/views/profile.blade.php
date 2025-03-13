@extends('layouts.profile') 

@section('content')  
<div class="profile-wrapper">
    <!-- Banner Image -->
    <div class="banner-container">
        @if(Auth::user()->banner_image)
            <img src="{{ asset('storage/' . Auth::user()->banner_image) }}" alt="Banner Image" class="banner">
        @endif
    </div>

    <!-- Profile Image -->
    <div class="profile-container">
        @if(Auth::user()->profile_image)
            <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Profile Image" class="profile">
        @endif
    </div>

    <!-- Profile Update Form -->
    <div class="form-container">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Profile & Banner Image Upload -->
            <div class="input-group">
                <label for="profile_image">Profile Image:</label>
                <input type="file" name="profile_image" accept="image/*">
            </div>

            <div class="input-group">
                <label for="banner_image">Banner Image:</label>
                <input type="file" name="banner_image" accept="image/*">
            </div>

            <!-- Editable Fields from userdata Table -->
            <div class="input-group">
                <label for="ic_passport">IC or Passport Number:</label>
                <input type="text" name="ic_passport" value="{{ $user->ic_passport ?? '' }}" required>
            </div>
            <div class="input-group">
                <label for="full_name">Full Name:</label>
                <input type="text" name="full_name" value="{{ $userdata->full_name ?? '' }}" required>
            </div>

            <div class="input-group">
                <label for="email">Email:</label>
                <input type="email" name="email" value="{{ Auth::user()->email }}" required>
            </div>

            <div class="input-group">
                <label for="studentID">Student ID:</label>
                <input type="text" name="studentID" value="{{ $userdata->studentID ?? '' }}" required>
            </div>

            <div class="input-group">
                <label for="graduation_year">Graduation Year:</label>
                <input type="number" name="graduation_year" value="{{ $userdata->graduation_year ?? '' }}" required>
            </div>

            <div class="input-group">
                <label for="mobile_number">Mobile Number:</label>
                <input type="number" name="mobile_number" value="{{ $userdata->mobile_number ?? '' }}" required>
            </div>

            <div class="input-group">
                <label for="permanent_address">Permanent Address:</label>
                <textarea name="permanent_address" rows="3" required>{{ $userdata->permanent_address ?? '' }}</textarea>
            </div>

            <div class="input-group">
                <label for="college">College:</label>
                <select name="college" required>
                    <option value="COE" {{ ($userdata->college ?? '') == 'COE' ? 'selected' : '' }}>COE</option>
                    <option value="CCI/CSIT/COIT" {{ ($userdata->college ?? '') == 'CCI/CSIT/COIT' ? 'selected' : '' }}>CCI/CSIT/COIT</option>
                    <option value="UBS/COBA" {{ ($userdata->college ?? '') == 'UBS/COBA' ? 'selected' : '' }}>UBS/COBA</option>
                    <option value="COGS" {{ ($userdata->college ?? '') == 'COGS' ? 'selected' : '' }}>COGS</option>
                </select>
            </div>

            <div class="input-group">
                <label for="education_level">Educational Level:</label>
                <select name="education_level" required>
                    <option value="Diploma" {{ ($userdata->education_level ?? '') == 'Diploma' ? 'selected' : '' }}>Diploma</option>
                    <option value="Sarjana Muda" {{ ($userdata->education_level ?? '') == 'Sarjana Muda' ? 'selected' : '' }}>Sarjana Muda</option>
                    <option value="Sarjana" {{ ($userdata->education_level ?? '') == 'Sarjana' ? 'selected' : '' }}>Sarjana</option>
                    <option value="PhD" {{ ($userdata->education_level ?? '') == 'PhD' ? 'selected' : '' }}>PhD</option>
                </select>
            </div>

            <div class="input-group">
                <label for="name_of_programme">Name of Programme:</label>
                <select name="name_of_programme" required>
                    <option value="Bachelor in Accounting" {{ ($userdata->name_of_programme	 ?? '') == 'Bachelor in Accounting' ? 'selected' : '' }}>Bachelor in Accounting</option>
                    <option value="Bachelor of Business Administration (Hons.) in Human Resource Management" {{ ($userdata->name_of_programme	 ?? '') == 'Bachelor of Business Administration (Hons.) in Human Resource Management' ? 'selected' : '' }}>Bachelor of Business Administration Hons. in Human Resource Management</option>
                    <option value="Diploma in Business Studies" {{ ($userdata->name_of_programme	 ?? '') == 'Diploma in Business Studies' ? 'selected' : '' }}>Diploma in Business Studies</option>
                    <option value="Diploma in Computer Science" {{ ($userdata->name_of_programme	 ?? '') == 'Diploma in Computer Science' ? 'selected' : '' }}>Diploma in Computer Science</option>
                </select>
            </div>

            <div class="input-group">
                <label for="current_employment_status">Current Employment Status:</label>
                <select name="current_employment_status" required>
                    <option value="Employed" {{ ($userdata->current_employment_status	 ?? '') == 'Employed' ? 'selected' : '' }}>Employed</option>
                    <option value="Self-Employed" {{ ($userdata->current_employment_status	 ?? '') == 'Self-Employed' ? 'selected' : '' }}>Self-Employed</option>
                    <option value="Not Employed" {{ ($userdata->current_employment_status	 ?? '') == 'Not Employed' ? 'selected' : '' }}>Not Employed</option>
                </select>
            </div>

            <div class="input-group">
                <label for="employment_level">Employment Level:</label>
                <select name="employment_level" required>
                    <option value="High Skilled" {{ ($userdata->employment_level	 ?? '') == 'High Skilled' ? 'selected' : '' }}>High Skilled</option>
                    <option value="Semi Skilled" {{ ($userdata->employment_level	 ?? '') == 'Semi Skilled' ? 'selected' : '' }}>Semi Skilled</option>
                    <option value="Low Skilled" {{ ($userdata->employment_level	 ?? '') == 'Low Skilled' ? 'selected' : '' }}>Low Skilled</option>
                </select>
            </div>

            <div class="input-group">
                <label for="employment_sector">Employment Sector:</label>
                <select name="employment_sector	" required>
                    <option value="Public Sector" {{ ($userdata->employment_sector	 ?? '') == 'Public Sector' ? 'selected' : '' }}>Public Sector</option>
                    <option value="Private Sector" {{ ($userdata->employment_sector	 ?? '') == 'Private Sector' ? 'selected' : '' }}>Private Sector</option>
                </select>
            </div>

            <div class="input-group">
                <label for="occupational_field	">Occupational Field:</label>
                <select name="occupational_field" required>
                    <option value="Agriculture" {{ ($userdata->occupational_field	 ?? '') == 'Agriculture' ? 'selected' : '' }}>Agriculture</option>
                    <option value="Mining and Quarying" {{ ($userdata->occupational_field	 ?? '') == 'Mining and Quarying' ? 'selected' : '' }}>Mining and Quarying</option>
                    <option value="Manufacturing" {{ ($userdata->occupational_field	 ?? '') == 'Manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                    <option value="Construction" {{ ($userdata->occupational_field	 ?? '') == 'Construction' ? 'selected' : '' }}>Construction</option>
                    <option value="Services" {{ ($userdata->occupational_field	 ?? '') == 'Services' ? 'selected' : '' }}>Services</option>
                </select>
            </div>

            <div class="input-group">
                <label for="range_of_salary">Employment Level:</label>
                <select name="range_of_salary" required>
                    <option value="Less than RM4,800" {{ ($userdata->range_of_salary	 ?? '') == 'Less than RM4,800' ? 'selected' : '' }}>Less than RM4,800</option>
                    <option value="RM4,801 - RM10,970" {{ ($userdata->range_of_salary	 ?? '') == 'RM4,801 - RM10,970' ? 'selected' : '' }}>RM4,801 - RM10,970</option>
                    <option value="More than RM10,970" {{ ($userdata->range_of_salary	 ?? '') == 'More than RM10,970' ? 'selected' : '' }}>More than RM10,970</option>
                </select>
            </div>

            <div class="input-group">
                <label for="position">Position:</label>
                <input type="text" name="position" value="{{ $userdata->position ?? '' }}" required>
            </div>

            <div class="input-group">
                <label for="name_of_organisation">Name of Organisation:</label>
                <input type="text" name="name_of_organisation" value="{{ $userdata->position ?? '' }}" required>
            </div>

            <div class="input-group">
                <label for="location_of_workplace">Location of Workplace:</label>
                <textarea name="location_of_workplace" rows="3" required>{{ $userdata->location_of_workplace ?? '' }}</textarea>
            </div>

            <button type="submit">Update Profile</button>
        </form>
    </div>
</div>

<style> 
.profile-wrapper {
    width: 600px;
    margin: 0 auto;
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

/* Banner Image */
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
    top: 200px;
    left: 50%;
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

.input-group {
    display: flex;
    align-items: center;
    gap: 10px;
    justify-content: center;
    width: 100%;
    margin-bottom: 10px;
}

.input-group label {
    width: 150px;
    text-align: right;
    font-weight: bold;
}

.input-group input, .input-group select, .input-group textarea {
    flex: 1;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.form-container button {
    background: #1da1f2;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.form-container button:hover {
    background: #0d8ae5;
}
</style>

@endsection
