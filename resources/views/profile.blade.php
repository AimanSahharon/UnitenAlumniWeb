@extends('layouts.profile')

@section('tab-content')  
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
                        <input type="text" name="ic_passport" value="{{ $user->userData->ic_passport ?? '' }}" disabled style="pointer-events: none;"> <!-- future note: replace readonly with disabled so that user cannot copy -->
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
    </div>
</div>
 
@endsection
