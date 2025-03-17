<?php
//This UserController is for the alumni using the website and they can access their profile page to update their information
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\UserData;



class UserController extends Controller
{
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

    // Ensure ic_passport exists
    if (!$user->ic_passport) {
        return back()->with('error', 'IC/Passport number is missing.');
    }

    // Retrieve or create UserData record as an Eloquent model
    $userData = UserData::firstOrNew(['ic_passport' => $user->ic_passport]);

    // Handle profile image upload
    if ($request->hasFile('profile_image')) {
        $userData->profile_image = $request->file('profile_image')->store('profile_images', 'public');
    }

    // Handle banner image upload
    if ($request->hasFile('banner_image')) {
        $userData->banner_image = $request->file('banner_image')->store('banner_images', 'public');
    }

    // Fill the model with request data and save
    $userData->fill($request->all());
    $userData->save();

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

        public function uploadProfilePicture(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $path = $request->file('profile_image')->store('profile_images', 'public');

        $user->userData->update(['profile_image' => $path]);
        

        return back()->with('success', 'Profile picture updated successfully!');
    }

    public function uploadBannerPicture(Request $request)
    {
        $request->validate([
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $path = $request->file('banner_image')->store('banner_images', 'public');

        $user->userData->update(['banner_image' => $path]);

        return back()->with('success', 'Banner picture updated successfully!');
    }

    public function uploadImages(Request $request)
    {
        $user = Auth::user();
        
        if ($request->hasFile('profile_image')) {
            $profilePath = $request->file('profile_image')->store('profiles', 'public');
            $user->userData->profile_image = $profilePath;
        }

        if ($request->hasFile('banner_image')) {
            $bannerPath = $request->file('banner_image')->store('banners', 'public');
            $user->userData->banner_image = $bannerPath;
        }

        $user->userData->save();
        return back()->with('success', 'Image(s) updated successfully!');
    }

    public function search(Request $request)
    {
        $query = UserData::query(); // Assuming UserData is your model

        if ($request->filled('search_name')) {
            $query->where('full_name', 'like', '%' . $request->search_name . '%');
        }

        if ($request->filled('year_of_graduation')) {
            $query->where('year_of_graduation', $request->year_of_graduation);
        }

        if ($request->filled('college')) {
            $query->where('college', $request->college);
        }

        if ($request->filled('education_level')) {
            $query->where('education_level', $request->education_level);
        }

        if ($request->filled('name_of_programme')) {
            $query->where('name_of_programme', 'like', '%' . $request->name_of_programme . '%');
        }

        $alumni = $query->paginate(10);

        return view('alumnihub.connectalumni', ['alumni' => $alumni]);
    }

    public function show($id)
    {
        $alumnus = UserData::findOrFail($id); // Fetch alumni details
        return view('alumnihub.profile', compact('alumnus'));
    }





    public function myPosts()
    {
        $posts = Auth::user()->posts; // Assuming a relationship exists
        return view('profile.myposts', compact('posts'));
    }

    public function myInterestGroup()
    {
        return view('profile.myinterestgroup'); // Ensure file exists in resources/views/profile/
    }

    public function myBusinessListings()
    {
        return view('profile.mybusinesslistings'); // Ensure file exists in resources/views/profile/
    }




    

    


}
