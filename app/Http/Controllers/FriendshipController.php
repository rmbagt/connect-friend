<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Friendship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendshipController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $friends = $user->friends()->paginate(10);
        $pendingRequests = $user->receivedFriendRequests()->with('user')->get();
        $sentRequests = $user->sentFriendRequests()->with('friend')->get();
        return view('friendships.index', compact('friends', 'pendingRequests', 'sentRequests'));
    }

    public function store(Request $request, User $user)
    {
        if (Auth::id() === $user->id) {
            return redirect()->back()->with('error', __('You cannot send a friend request to yourself.'));
        }

        $existingFriendship = Friendship::where(function ($query) use ($user) {
            $query->where('user_id', Auth::id())->where('friend_id', $user->id);
        })->orWhere(function ($query) use ($user) {
            $query->where('user_id', $user->id)->where('friend_id', Auth::id());
        })->first();

        if ($existingFriendship) {
            return redirect()->back()->with('error', __('A friend request already exists.'));
        }

        Friendship::create([
            'user_id' => Auth::id(),
            'friend_id' => $user->id,
        ]);

        return redirect()->back()->with('success', __('Friend request sent.'));
    }

    public function update(Friendship $friendship)
    {
        if ($friendship->friend_id !== Auth::id()) {
            return redirect()->back()->with('error', __('You are not authorized to accept this request.'));
        }

        $friendship->update(['is_accepted' => true]);

        return redirect()->back()->with('success', __('Friend request accepted.'));
    }

    public function destroy(Friendship $friendship)
    {
        if ($friendship->user_id !== Auth::id() && $friendship->friend_id !== Auth::id()) {
            return redirect()->back()->with('error', __('You are not authorized to delete this friendship.'));
        }

        $friendship->delete();

        return redirect()->back()->with('success', __('Friend removed.'));
    }
}

