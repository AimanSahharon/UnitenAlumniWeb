<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;

class PostController extends Controller
{
    /*public function index()
    {
        $posts = Post::with('comments', 'likes')->latest()->get();
        return response()->json($posts);
    } */

    public function index()
    {
        $posts = Post::with('comments', 'likes')->latest()->get();
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
    public function store(Request $request)
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
    }
    

    public function like($id)
    {
        Like::create(['post_id' => $id]);
        return response()->json(['message' => 'Liked']);
    }

    public function comment(Request $request, $id)
    {
        $comment = Comment::create([
            'post_id' => $id,
            'content' => $request->content
        ]);

        return response()->json($comment);
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


}
