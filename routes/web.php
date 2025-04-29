<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BusinessListingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return view('welcome');
});

/*Route::get('/home', function() {
    return view('home');
}); */

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/mycard', function() {
    return view('mycard');
});

Route::get('/benefits', function() {
    return view('benefits');
});

Route::get('/alumnihub', function() {
    return view('alumnihub');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




Route::get('/profile', [UserController::class, 'profile'])->name('profile')->middleware('auth');
Route::put('/profile/update', [UserController::class, 'updateProfile'])
    ->name('profile.update')
    ->middleware('auth');

// Profile Edit Page
Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit')->middleware('auth');

// Profile Update (PUT method)
Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update')->middleware('auth');

// Profile Page
Route::get('/profile', [UserController::class, 'profile'])->name('profile')->middleware('auth');

//update profile images (profile image and banner image)
Route::post('/profile/upload/profile-picture', [UserController::class, 'uploadProfilePicture'])->name('profile.upload.picture');
Route::post('/profile/upload/banner', [UserController::class, 'uploadBannerPicture'])->name('profile.upload.banner');

//upload profile images
Route::post('/profile/upload-images', [UserController::class, 'uploadImages'])->name('profile.upload.images');

Route::get('/info', function () {
    return view('info');
})->name('info');

//Routes for Tabs in Profile Page
/*Route::get('/myposts', function () {
    return view('profile.myposts', ['user' => Auth::user()]);
})->name('myposts')->middleware('auth'); */

//Route::get('/myposts', [PostController::class, 'myPosts'])->name('myposts')->middleware('auth');
Route::get('/myposts', [PostController::class, 'myPosts'])->name('myposts')->middleware('auth');





Route::get('/myinterestgroup', function () {
    return view('profile.myinterestgroup', ['user' => Auth::user()]);
})->name('myinterestgroup')->middleware('auth');

/*Route::get('/mybusinesslistings', function () {
    return view('profile.mybusinesslistings', ['user' => Auth::user()]);
})->name('mybusinesslistings')->middleware('auth'); */

Route::get('/mybusinesslistings', [BusinessListingController::class, 'myBusinessListings'])->name('mybusinesslistings')->middleware('auth');





//Routes for Alumni Hub Tabs
Route::get('/connectalumni', [UserController::class, 'search'])->name('connectalumni');
Route::get('/alumni/{id}', [UserController::class, 'show'])->name('alumni.show'); //view other alumni's profile





//Routes for Posts
Route::get('/posts.view', function () {
    return view('alumnihub.posts');
})->name('posts.view');

//Post Routes
Route::get('/posts', [PostController::class, 'index']);
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::post('/posts/{id}/like', [PostController::class, 'like']);
Route::put('/posts/{post}', [PostController::class, 'updatePost'])->middleware('auth');


Route::post('/posts/{id}/comment', [PostController::class, 'comment']);
Route::delete('/comments/{id}', [PostController::class, 'deleteComment']);
Route::delete('/posts/{id}', [PostController::class, 'deletePost']);
Route::post('/posts/{id}/comment', [PostController::class, 'comment']);
Route::get('/posts/{id}/comments', function ($id) {
    return response()->json(\App\Models\Comment::where('post_id', $id)->with('user')->get());
});
Route::delete('/comments/{id}', [PostController::class, 'deleteComment']);
Route::get('/posts/{postId}/comments', [PostController::class, 'getComments']);
Route::put('/comments/{comment}', [PostController::class, 'updateComment']);





Route::get('/interestgroup', function () {
    return view('alumnihub.interestgroup');
})->name('interestgroup');

Route::get('/businesslistings', function () {
    return view('alumnihub.businesslistings');
})->name('businesslistings');


//Business Listings route
Route::get('/businesslistingposts', [BusinessListingController::class, 'index']);
Route::post('/businesslistingposts', [BusinessListingController::class, 'store'])->name('posts.store');
Route::post('/businesslistingposts/{id}/like', [BusinessListingController::class, 'like']);
Route::put('/businesslisting/{post}', [BusinessListingController::class, 'updatePost'])->middleware('auth');


Route::post('/businesslistingposts/{id}/comment', [BusinessListingController::class, 'comment']);
Route::delete('/businesslistingcomments/{id}', [BusinessListingController::class, 'deleteComment']);
Route::delete('/businesslistingposts/{id}', [BusinessListingController::class, 'deletePost']);
Route::post('/businesslistingposts/{id}/comment', [BusinessListingController::class, 'comment']);
Route::get('/businesslistingposts/{id}/comments', function ($id) {
    return response()->json(\App\Models\BusinessListingComment::where('business_listing_post_id', $id)->with('user')->get());
});
Route::delete('/businesslistingcomments/{id}', [BusinessListingController::class, 'deleteComment']);
Route::get('/businesslistingposts/{postId}/comments', [BusinessListingController::class, 'getComments']);
Route::put('/businesslistingcomments/{comment}', [BusinessListingController::class, 'updateComment']);




//Admin Routes
Route::get('/admin/home', [HomeController::class, 'card'])->name('admin.home');

Route::get('/admin/home/add', function() {
    return view('admin.addcard');
})->middleware('can:isAdmin');

Route::get('/admin/home/create', [HomeController::class, 'create'])->name('cards.create')->middleware('can:isAdmin');
Route::post('/admin/home', [HomeController::class, 'store'])->name('cards.store')->middleware('can:isAdmin');

Route::get('/admin/home/{id}/edit', [HomeController::class, 'edit'])->name('cards.edit')->middleware('can:isAdmin');
Route::put('/admin/home/{id}', [HomeController::class, 'update'])->name('cards.update')->middleware('can:isAdmin');
Route::delete('/admin/home/{id}', [HomeController::class, 'destroy'])->name('cards.destroy')->middleware('can:isAdmin');


/*Route::get('/admin/dashboard', function() {
    return view('admin.dashboard');
})->middleware('can:isAdmin'); */

Route::get('/admin/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard')->middleware('can:isAdmin');

