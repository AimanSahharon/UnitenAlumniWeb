<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Post;
use App\Models\BusinessListingPost;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {

        // Default filter is day
        $filter = $request->get('filter', 'day');

        // Count all users except those with user_level = 0 to exlude admin in the registered user count
        $totalUsers = User::where('user_level', '!=', 0)->count();

        // Count unique users who made posts (excluding user_level = 0)
        $usersWithPosts = Post::whereHas('user', function ($query) {
            $query->where('user_level', '!=', 0);
        })->select('user_id')->distinct()->count();

        // Count unique users who made business listings (excluding user_level = 0)
        $usersWithBusinessListings = BusinessListingPost::whereHas('user', function ($query) {
            $query->where('user_level', '!=', 0);
        })->select('user_id')->distinct()->count();

        // Update the grouping logic based on the selected filter
        $groupByFormat = "DATE_FORMAT(created_at, '%Y-%m-%d')"; // Default to day

        if ($filter === 'month') {
            $groupByFormat = "DATE_FORMAT(created_at, '%Y-%m')"; // Group by Month (Year-Month)
        } elseif ($filter === 'year') {
            $groupByFormat = "DATE_FORMAT(created_at, '%Y')"; // Group by Year
        }

        // Fetch posts, business listings, and users with the appropriate date format
        $postsPerDay = Post::select(DB::raw("$groupByFormat as date"), DB::raw('count(*) as count'))
            ->groupBy(DB::raw($groupByFormat))
            ->orderBy('date')
            ->get();

        $businessListingsPerDay = BusinessListingPost::select(DB::raw("$groupByFormat as date"), DB::raw('count(*) as count'))
            ->groupBy(DB::raw($groupByFormat))
            ->orderBy('date')
            ->get();

        $usersPerDay = User::select(DB::raw("$groupByFormat as date"), DB::raw('count(*) as count'))
            ->where('user_level', '!=', 0)
            ->groupBy(DB::raw($groupByFormat))
            ->orderBy('date')
            ->get(); 
            
            

        return view('admin.dashboard', compact(
            'totalUsers',
            'usersWithPosts',
            'usersWithBusinessListings',
            'postsPerDay',
            'businessListingsPerDay',
            'usersPerDay',
            'filter',
        ));
    }

}
