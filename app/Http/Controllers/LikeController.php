<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Like $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Like $like)
    {
        //
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
