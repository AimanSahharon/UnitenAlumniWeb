<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BusinessListingPost;
use App\Models\BusinessListingComment;
use App\Models\BusinessListingLike;
use Illuminate\Support\Facades\Storage;

class BusinessListingController extends Controller
{
     /*public function index()
    {
        $posts = Post::with('comments', 'likes')->latest()->get();
        return response()->json($posts);
    } */

    public function index()
    {
        $posts = BusinessListingPost::with('user', 'comments.user', 'likes')->latest()->get();
        return response()->json($posts);
    } 

    

    /*public function store(Request $request)
    {
        $post = Post::create([
            'content' => $request->content,
            'image' => $request->image ?? null,
        ]);

        return response()->json($post);
    } */
   /* public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Validate the image
        ]);
    
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads', 'public'); // Save in storage/app/public/uploads
        }
    
        $post = Post::create([
            'content' => $request->content,
            'image' => $imagePath ? "/storage/{$imagePath}" : null, // Store public URL
        ]);
    
        return response()->json($post);
    } */

    /*public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads', 'public');
        }
    
        $post = Post::create([
            'user_id' => Auth::id(), // Using Auth facade instead of auth()
            'content' => $request->content,
            'image' => $imagePath ? "/storage/{$imagePath}" : null,
        ]);
    
        return response()->json($post->load('user'));
    } */

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        $request->validate([
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ]);

        if (!$request->has('content') && !$request->hasFile('image')) {
            return response()->json(['error' => 'Post must have content or an image'], 422);
        }
    
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads', 'public');
        }
    
        $post = BusinessListingPost::create([
            'user_id' => Auth::id(), // Using Auth facade instead of auth()
            'content' => $request->content,
            'image' => $imagePath ? "/storage/{$imagePath}" : null,
        ]);
    
        return response()->json($post->load('user'));
    }


    

    /*public function like($id)
    {
        Like::create(['business_listing_post_id' => $id]);
        return response()->json(['message' => 'Liked']);
    } */

    /*public function like($id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $like = Like::firstOrCreate([
            'business_listing_post_id' => $id,
            'user_id' => Auth::id(),
        ]);

        return response()->json(['message' => 'Liked', 'like' => $like]);
    } */

    //To like a post
    public function like($id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        $userId = Auth::id();
    
        // Check if the like already exists
        $existingLike = BusinessListingLike::where('business_listing_post_id', $id)->where('user_id', $userId)->first();
    
        if ($existingLike) {
            // Unlike the post (remove the like)
            $existingLike->delete();
            return response()->json(['message' => 'Unliked', 'liked' => false, 'likes_count' => BusinessListingLike::where('business_listing_post_id', $id)->count()]);
        } else {
            // Like the post
            BusinessListingLike::create([
                'business_listing_post_id' => $id,
                'user_id' => $userId,
            ]);
            return response()->json(['message' => 'Liked', 'liked' => true, 'likes_count' => BusinessListingLike::where('business_listing_post_id', $id)->count()]);
        }
    }
    


    /*public function comment(Request $request, $id)
    {
        $comment = Comment::create([
            'business_listing_post_id' => $id,
            'content' => $request->content
        ]);

        return response()->json($comment);
    } */

    //To comment on post
    public function comment(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'content' => 'nullable|string|max:500'
        ]);

        $comment = BusinessListingComment::create([
            'business_listing_post_id' => $id,
            'user_id' => Auth::id(),
            'content' => $request->content
        ]);

        return response()->json($comment->load('user'));
    }


    public function deleteComment($id)
    {
        $comment = BusinessListingComment::findOrFail($id);
        $comment->delete();
        return response()->json(['message' => 'Comment deleted successfully']);
    }

    //To Delete Post
    public function deletePost($id)
    {
        $post = BusinessListingPost::findOrFail($id);

        // Delete related comments and likes first
        $post->comments()->delete();
        $post->likes()->delete();

        // Delete the post
        $post->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }

    public function updateComment (Request $request, BusinessListingComment $comment)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment->update([
            'content' => $request->content,
            'updated_at' => now() // Ensure updated timestamp
        ]);

        return response()->json($comment);
    }

    //To update post
    public function updatePost(Request $request, BusinessListingPost $post)
    {
        if (Auth::id() !== $post->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'content' => 'nullable|string|max:300',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ]);

        if ($request->has('content')) {
            $post->content = $request->content;
        }

        // Handle image removal
        if ($request->has('remove_image')) {
            if ($post->image) {
                Storage::delete(str_replace('/storage/', 'public/', $post->image)); // Fix: Use `Storage` facade
                $post->image = null;
            }
        }

        // Handle new image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads', 'public');
            $post->image = "/storage/{$imagePath}";
        }

        $post->save();

        return response()->json([
            'id' => $post->id,
            'content' => $post->content,
            'image' => $post->image,
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at, // Ensure this is included
        ]);
    }

    public function myBusinessListings()
    {
        $user = auth()->user(); // Get currently logged-in user
        $posts = $user->posts()->with('comments.user')->latest()->get(); // Or however you're getting posts

        return view('profile.mybusinesslistings', compact('posts', 'user'));
    } 

}
