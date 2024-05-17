<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Comment;
use App\Models\Connection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;



class UserController extends Controller
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
    public function show(User $user)
    {
        // Fetch the user's posts
        $posts = $user->posts()->latest()->get();

        // Fetch the user's comments
        $comments = Comment::orderBy('created_at', 'desc')->get();
        // if($user-> id != Auth::id()){
            // Fetch the user's connection
            // $connection = Connection::where('user_id', $user-> id)->where('friend_id', Auth::id())->orWhere('user_id', Auth::id())->where('friend_id', $user-> id)->get();

            $loggedInUser = Auth::user();
            $connection = Connection::where(function ($query) use ($loggedInUser, $user) {
                $query->where('user_id', Auth::id())
                      ->where('friend_id', $user->id);
            })->orWhere(function ($query) use ($loggedInUser, $user) {
                $query->where('user_id', $user->id)
                      ->where('friend_id', $loggedInUser->id);
            })->get();


        // }else{
        //     $connection = null;
        // }
        // dd($connectionExists->id);
        // Return the profile view with the user and their posts
        return view('profile', compact('connection', 'user', 'posts', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $user = auth()->user(); // Assuming you're using authentication
    
        if ($request->hasFile('image')) {
            // Delete the old profile picture if exists
            if ($user->profile_picture) {
                Storage::delete('public/' . $user->profile_picture);
            }
    
            // Store the new profile picture
            $path = $request->file('image')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }
    
        $user->save();
    
        return redirect()->back()->with('success', 'Profile picture updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }



    public function search(Request $request)
    {
        $query = $request->input('query');
        // Perform the search query
        $users = User::where('name', 'like', "%{$query}%")
                     ->orWhere('email', 'like', "%{$query}%")
                     ->get();

        return view('search-results', compact('users', 'query'));
    }
}
