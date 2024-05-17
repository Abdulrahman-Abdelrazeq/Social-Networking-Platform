<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        $comments = Comment::orderBy('created_at', 'desc')->get();
        return view('home', compact('posts'), compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'content' => 'required_without:image',
            'image' => 'required_without:content|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the file size and allowed formats as needed
        ]);

        // Create a new Post instance
        $post = new Post();
        $post->content = $request->input('content');

        $post -> user_id = Auth::id();

        // Upload and save the image if provided
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $post->image = $imagePath;
        }

        // Save the post to the database
        $post->save();

        // Redirect back to the form with a success message
        return redirect()->back()->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {

        // Validate the form data
        $request->validate([
            'content' => 'required_without:image',
            'image' => 'required_without:content|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the file size and allowed formats as needed
        ]);
        // Update the post content if provided
        $post->content = $request->input('content');

        // If a new image is provided, update the image
        if ($request->hasFile('image')) {
            // Delete the previous image if it exists
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            // Upload and save the new image
            $imagePath = $request->file('image')->store('images', 'public');
            $post->image = $imagePath;
        }

        // Save the post changes to the database
        $post->save();

        // Redirect back to the form with a success message
        return redirect()->back()->with('success', 'Post updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->back()->with('success', 'Post deleted successfully.');
    }


    public function user_posts(){

        $user = Auth::user();
        $posts = Post::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        $comments = Comment::orderBy('created_at', 'desc')->get();
        return view('profile', compact('posts'), compact('comments'));
    }

    public function likedUsers($postId)
    {
        $likes = like::where('post_id', $postId)->with('user')->get();
        // $likedUsers = $post->likes()->user()->get();
        // dd($likedUsers);
        return response()->json(['users' => $likes]);
    }

    public function like(Post $post)
    {
        $user = auth()->user();
        if ($user) {
            $like = Like::where('user_id', $user->id)
                        ->where('post_id', $post->id)
                        ->first();
            if ($like) {
                // Unlike the post if already liked
                $like->delete();
                $liked = false;
            } else {
                // Like the post if not already liked
                $like = new Like();
                $like->user_id = $user->id;
                $like->post_id = $post->id;
                $like->save();
                $liked = true;
            }
            return response()->json(['success' => true, 'liked' => $liked]);
        }
        return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
    }
}
