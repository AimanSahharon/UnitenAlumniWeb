<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    /*public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner_image' => 'image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::delete('public/' . $user->profile_image);
            }
            $profilePath = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $profilePath;
        }

        if ($request->hasFile('banner_image')) {
            if ($user->banner_image) {
                Storage::delete('public/' . $user->banner_image);
            }
            $bannerPath = $request->file('banner_image')->store('banner_images', 'public');
            $user->banner_image = $bannerPath;
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    } */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
    
        // Validate input
        $request->validate([
            'full_name' => 'required|string',
            'student_id' => 'required|string',
            'year_of_graduation' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'email_address' => 'required|string',
            'mobile_number' => 'required|string',
            'permanent_address' => 'required|string',
            'college' => 'required|string',
            'education_level' => 'required|string',
            'name_of_programme' => 'required|string',
            'current_employment_status' => 'required|string',
            'employment_level' => 'required|string',
            'employment_sector' => 'required|string',
            'occupational_field' => 'required|string',
            'range_of_salary' => 'required|string',
            'position_designation' => 'required|string',
            'name_of_organisation' => 'required|string',
            'location_of_workplace' => 'required|string',

        ]);

        if (!$user->ic_passport) {
            return back()->with('error', 'IC/Passport number is missing.');
        }

        // Debugging: Check if request data is received
        if (!$request->filled('student_id')) {
            return back()->with('error', 'Student ID cannot be empty.');
        }
        /* Update profile images
        if ($request->hasFile('profile_image')) {
            $profileImagePath = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $profileImagePath;
        }
    
        if ($request->hasFile('banner_image')) {
            $bannerImagePath = $request->file('banner_image')->store('banner_images', 'public');
            $user->banner_image = $bannerImagePath;
        } */
    
       // $user->save();
    
        // Update userdata table
        DB::table('user_data')->updateOrInsert(
            ['ic_passport' => $user->ic_passport], //match by ic_passport
            [
                'full_name' => $request->full_name,
                'student_id' => $request->student_id,
                'year_of_graduation' => $request->year_of_graduation,
                'email_address' => $request->email_address,
                'mobile_number' => $request->mobile_number,
                'permanent_address' => $request->permanent_address,
                'college' => $request->college,
                'education_level' => $request->education_level,
                'name_of_programme' => $request->name_of_programme,
                'current_employment_status' => $request->current_employment_status,
                'employment_level' => $request->employment_level,
                'employment_sector' => $request->employment_sector,
                'occupational_field' => $request->occupational_field,
                'range_of_salary' => $request->range_of_salary,
                'position_designation' => $request->position_designation,
                'name_of_organisation' => $request->name_of_organisation,
                'location_of_workplace' => $request->location_of_workplace,
                'updated_at' => now(),
            ]
        );
    
        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }
    

    public function edit()
{
    $user = Auth::user();
    $userdata = DB::table('user_data')->where('ic_passport', $user->ic_passport)->first();


    return view('profile.edit', compact('user', 'userdata'));
}

    public function profile()
    {
        $user = Auth::user();
        $userData = $user->userData; // Retrieve related user_data

        return view('profile', compact('user', 'userData'));
    }


}
