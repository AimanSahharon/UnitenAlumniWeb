@extends('layouts.alumnihub')

@section('tab-content')
<div class="container">
    <h2>Search and Connect with Alumni</h2>

    <form action="{{ route('connectalumni') }}" method="GET">
        <div class="container">
            <div class="row g-3"> <!-- 'g-3' adds consistent spacing -->
                <div class="col-12">
                    <div class="form-group">
                        <label for="search_name">Search by Name:</label>
                        <input type="text" name="search_name" class="form-control" placeholder="Enter full name..." value="{{ request('search_name') }}">
                    </div>
                </div>
        
                <div class="col-12">
                    <div class="form-group">
                        <label for="year_of_graduation">Graduation Year:</label>
                        <select name="year_of_graduation" class="form-control">
                            <option value="">Select Year</option>
                            @foreach(range(date('Y'), 1900, -1) as $year)
                                <option value="{{ $year }}" {{ request('year_of_graduation') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
        
                <div class="col-12">
                    <div class="form-group">
                        <label for="college">College:</label>
                        <select name="college" class="form-control">
                            <option value="">Select College</option>
                            <option value="COE" {{ request('college') == 'COE' ? 'selected' : '' }}>COE</option>
                            <option value="CCI/CSIT/COIT" {{ request('college') == 'CCI/CSIT/COIT' ? 'selected' : '' }}>CCI/CSIT/COIT</option>
                            <option value="UBS/COBA" {{ request('college') == 'UBS/COBA' ? 'selected' : '' }}>UBS/COBA</option>
                            <option value="COGS" {{ request('college') == 'COGS' ? 'selected' : '' }}>COGS</option>
                        </select>
                    </div>
                </div>
        
                <div class="col-12">
                    <div class="form-group">
                        <label for="education_level">Education Level:</label>
                        <select name="education_level" class="form-control">
                            <option value="">Select Level</option>
                            <option value="Diploma" {{ request('education_level') == 'Diploma' ? 'selected' : '' }}>Diploma</option>
                            <option value="Sarjana Muda" {{ request('education_level') == 'Sarjana Muda' ? 'selected' : '' }}>Sarjana Muda</option>
                            <option value="Sarjana" {{ request('education_level') == 'Sarjana' ? 'selected' : '' }}>Sarjana</option>
                            <option value="PhD" {{ request('education_level') == 'PhD' ? 'selected' : '' }}>PhD</option>
                        </select>
                    </div>
                </div>
        
                <div class="col-12">
                    <div class="form-group">
                        <label for="name_of_programme">Programme Name:</label>
                        <input type="text" name="name_of_programme" class="form-control" placeholder="Enter programme name..." value="{{ request('name_of_programme') }}">
                    </div>
                </div>
        
                <!-- Centering the Submit Button -->
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
        </div>
        
    </form>

    <h3 class="mt-4">Search Results:</h3>
    <!-- Scrollable Table Wrapper -->
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Graduation Year</th>
                    <th>College</th>
                    <th>Education Level</th>
                    <th>Programme</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($alumni) && $alumni->count())
                    @foreach($alumni as $alumnus)
                        <tr>
                            <td>
                                <a href="{{ route('alumni.show', $alumnus->id) }}">
                                    {{ $alumnus->full_name }}
                                </a>
                            </td>
                            <td>{{ $alumnus->year_of_graduation }}</td>
                            <td>{{ $alumnus->college }}</td>
                            <td>{{ $alumnus->education_level }}</td>
                            <td>{{ $alumnus->name_of_programme }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center">No alumni found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    @if(isset($alumni) && $alumni->count())
    {{ $alumni->links() }}
    @endif


</div>
@endsection
