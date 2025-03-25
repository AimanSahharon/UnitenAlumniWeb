<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /*public function index()
    {
        $posts = Post::with('comments', 'likes')->latest()->get();
        return response()->json($posts);
    } */

    public function index()
    {
        $posts = Post::with('user', 'comments.user', 'likes')->latest()->get();
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
    
        $post = Post::create([
            'user_id' => Auth::id(), // Using Auth facade instead of auth()
            'content' => $request->content,
            'image' => $imagePath ? "/storage/{$imagePath}" : null,
        ]);
    
        return response()->json($post->load('user'));
    }


    

    /*public function like($id)
    {
        Like::create(['post_id' => $id]);
        return response()->json(['message' => 'Liked']);
    } */

    /*public function like($id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $like = Like::firstOrCreate([
            'post_id' => $id,
            'user_id' => Auth::id(),
        ]);

        return response()->json(['message' => 'Liked', 'like' => $like]);
    } */
    public function like($id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        $userId = Auth::id();
    
        // Check if the like already exists
        $existingLike = Like::where('post_id', $id)->where('user_id', $userId)->first();
    
        if ($existingLike) {
            // Unlike the post (remove the like)
            $existingLike->delete();
            return response()->json(['message' => 'Unliked', 'liked' => false, 'likes_count' => Like::where('post_id', $id)->count()]);
        } else {
            // Like the post
            Like::create([
                'post_id' => $id,
                'user_id' => $userId,
            ]);
            return response()->json(['message' => 'Liked', 'liked' => true, 'likes_count' => Like::where('post_id', $id)->count()]);
        }
    }
    


    /*public function comment(Request $request, $id)
    {
        $comment = Comment::create([
            'post_id' => $id,
            'content' => $request->content
        ]);

        return response()->json($comment);
    } */

    public function comment(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'content' => 'nullable|string|max:500'
        ]);

        $comment = Comment::create([
            'post_id' => $id,
            'user_id' => Auth::id(),
            'content' => $request->content
        ]);

        return response()->json($comment->load('user'));
    }


    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return response()->json(['message' => 'Comment deleted successfully']);
    }

    public function deletePost($id)
    {
        $post = Post::findOrFail($id);

        // Delete related comments and likes first
        $post->comments()->delete();
        $post->likes()->delete();

        // Delete the post
        $post->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }

    public function updateComment (Request $request, Comment $comment)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment->update([
            'content' => $request->content,
        ]);

        return response()->json($comment);
    }

    /*public function updatePost(Request $request, Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'content' => 'nullable|string|max:300',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ]);

        if (!$request->has('content') && !$request->hasFile('image')) {
            return response()->json(['error' => 'Post must have content or an image'], 422);
        }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads', 'public');
            $post->image = "/storage/{$imagePath}";
        }

        if ($request->has('content')) {
            $post->content = $request->content;
        }

        $post->save();

        return response()->json($post);
    } */

    public function updatePost(Request $request, Post $post)
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

        return response()->json($post);
    }

    








    



}