@extends('layouts.alumnihub')

@section('tab-content')
<div class="container">
    <h2>{{ $alumnus->full_name }}'s Profile</h2>
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
