@extends('layouts.profile')

@section('content')  
<div class="profile-wrapper">
    <div class="form-container">
        <h2>User Profile</h2>

        @if($user->userData)
            <p><strong>Full Name:</strong> {{ $user->userData->full_name }}</p>
            <p><strong>Student ID:</strong> {{ $user->userData->student_id }}</p>
        @else
            <p style="color: red;">User data not available.</p>
        @endif
    </div>
</div>
@endsection
