<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Connection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ConnectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $connection)
    {
        // Fetch connections where either user_id or friend_id matches $user->id
        $connections = Connection::where('status', 'pending')->where('friend_id', $connection->id)->get();

        return view('connection-requests', compact('connections'));
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
        $loggedInUser = Auth::user();
        $user_id = $request->input('user_id');

        // Check if a connection already exists
        if (!Connection::where('user_id', $loggedInUser->id)->where('friend_id', $user_id)->exists()) {
            // Create a new connection
            Connection::create([
                'user_id' => $loggedInUser->id,
                'friend_id' => $user_id,
            ]);

            return redirect()->back()->with('success', 'Connection request sent.');
        }

        return redirect()->back()->with('error', 'You are already connected.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $connection)
    {
        // Fetch connections where either user_id or friend_id matches $user->id
        $connections = Connection::where('status', 'accepted')
        ->where(function ($query) use ($connection) {
            $query->where('user_id', $connection->id)
                ->orWhere('friend_id', $connection->id);
        })->get();

        return view('friends', compact('connections'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Connection $connection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Connection $connection)
    {
        $connection->status = 'accepted';
        $connection->save();
        return redirect()->back()->with('success', 'Connection request sent.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Connection $connection)
    {
        $connection->delete();
        return redirect()->back()->with('success', 'Connection request sent.');
    }

}
