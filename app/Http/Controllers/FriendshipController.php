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
        $friends = $user->friends;
        $pendingRequests = $user->receivedFriendRequests;
        return view('friendships.index', compact('friends', 'pendingRequests'));
    }

    public function store(Request $request, User $user)
    {
        $this->authorize('befriend', $user);

        $friendship = Friendship::create([
            'user_id' => Auth::id(),
            'friend_id' => $user->id,
        ]);

        return redirect()->back()->with('success', __('Friend request sent.'));
    }

    public function update(Friendship $friendship)
    {
        $this->authorize('accept', $friendship);

        $friendship->update(['is_accepted' => true]);

        return redirect()->back()->with('success', __('Friend request accepted.'));
    }

    public function destroy(Friendship $friendship)
    {
        $this->authorize('delete', $friendship);

        $friendship->delete();

        return redirect()->back()->with('success', __('Friend removed.'));
    }
}

