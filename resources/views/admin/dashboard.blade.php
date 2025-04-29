@extends('layouts.app')

@section('content')
<div class="container-wrapper p-4 text-center">
    <h1>Admin Dashboard</h1>
    <h2>User Stats</h2>
    <ul style="list-style-type: none; padding: 0;">
        <li><strong>Total Registered Users:</strong> {{ $totalUsers }}</li>
        <li><strong>Total Posts being created:</strong> {{ $usersWithPosts }}</li>
        <li><strong>Total Business Listings being created:</strong> {{ $usersWithBusinessListings }}</li>
    </ul>
    <p style="display: inline; margin-right: 10px;">Filter by:</p>
    <!-- Filter Dropdown -->
    <form method="GET" action="{{ route('dashboard') }}">
        <select name="filter" style="text-align: center;" onchange="this.form.submit()">
            <option value="day" {{ $filter === 'day' ? 'selected' : '' }}>Day</option>
            <option value="month" {{ $filter === 'month' ? 'selected' : '' }}>Month</option>
            <option value="year" {{ $filter === 'year' ? 'selected' : '' }}>Year</option>
        </select>
    </form>

    <canvas id="activityChart" height="100"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!--To use chart.js-->
    <script>
    //JavaScript to render the chart
    const postData = @json($postsPerDay);
    const businessData = @json($businessListingsPerDay);
    const userData = @json($usersPerDay);

    //Extract unique dates
    const labels = [...new Set([
        ...postData.map(p => p.date),
        ...businessData.map(b => b.date),
        ...userData.map(u => u.date)
    ])].sort((a, b) => new Date(a) - new Date(b)); // <-- sort dates ascending, when a - b and a comes after b then a comes after b else if a is before b then b is ahead of a

    // Format the labels based on the selected filter
    const formattedLabels = labels; // Keep raw date strings from backend
    

  



    const postCounts = formattedLabels.map(label =>
        postData.find(p => p.date === label)?.count || 0
    );

    const businessCounts = formattedLabels.map(label =>
        businessData.find(b => b.date === label)?.count || 0
    );

    const userCounts = formattedLabels.map(label =>
        userData.find(u => u.date === label)?.count || 0
    );

    new Chart(document.getElementById('activityChart'), { //Uses Chart.js to create a line graph
        type: 'line',
        data: {
            labels: formattedLabels, // Use formatted labels
            datasets: [
                {
                    label: 'Posts',
                    data: postCounts,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    tension: 0.4,
                    fill: true,
                },
                {
                    label: 'Business Listings',
                    data: businessCounts,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    tension: 0.4,
                    fill: true,
                },
                {
                    label: 'Users',
                    data: userCounts,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.4,
                    fill: true,
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Count',
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Date',
                    },
                    ticks: { //change the X-Axis chart label based on the filter e.g if it's filter by day change from 2025-03-27 to 27 Mar 2025
                        callback: function(value, index, ticks) {
                        const rawDate = this.getLabelForValue(value);
                        const dateObj = new Date(rawDate);

                        /*if ("{{ $filter }}" === "day") {
                            return dateObj.toLocaleDateString('en-GB', {
                                day: 'numeric',
                                month: 'short',
                                year: 'numeric'
                            }); // e.g., 1 Jan 2025
                        } else if ("{{ $filter }}" === "month") {
                            return dateObj.toLocaleDateString('en-GB', {
                                month: 'short',
                                year: 'numeric'
                            }); // e.g., Jan 2025
                        } else if ("{{ $filter }}" === "year") {
                            return dateObj.getFullYear(); // e.g., 2025
                        }

                        return rawDate; */

                        //This is to change from 2025-03-27 to 27 Mar, 2025 (This version has a coma after month)
                        if ("{{ $filter }}" === "day") {
                            const day = dateObj.getDate();
                            const month = dateObj.toLocaleString('en-GB', { month: 'short' });
                            const year = dateObj.getFullYear();
                            return `${day} ${month}, ${year}`; // e.g., 1 Jan, 2025

                        } else if ("{{ $filter }}" === "month") {
                            const month = dateObj.toLocaleString('en-GB', { month: 'short' });
                            const year = dateObj.getFullYear();
                            return `${month} ${year}`; // e.g., Jan 2025

                        } else if ("{{ $filter }}" === "year") {
                            return dateObj.getFullYear(); // e.g., 2025
                        }

                        return rawDate;

                        }
                    }
                }
            }
        }
    });

    </script>
</div> <!-- end of container-wrapper -->

<!--To create a white square background with rounded corner-->
<style>
    .container-wrapper {
        max-width: 90%;
        width: 600px;
        margin: 0 auto;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        justify-content: center;
        align-items: center;
    }
</style>


@endsection
