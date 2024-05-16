<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($postId)
    {
        $post = Post::findOrFail($postId);
        $comments = $post->comments()->latest()->get();
        return response()->json(['comments' => $comments]);
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
        // Validate the request
        $request->validate([
            'content' => 'nullable',
            'image' => 'required_without:content|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the file size and allowed formats as needed
        ]);
        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->post_id = $request->input('post_id');
        $comment->user_id = Auth::user()->id;

        // Upload and save the image if provided
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('comment_images', 'public');
            $comment->image = $imagePath;
        }

        // Save the comment to the database
        $comment->save();
        return response()->json(['comment' => $comment]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->back()->with('success', 'Post deleted successfully.');

    }
}
