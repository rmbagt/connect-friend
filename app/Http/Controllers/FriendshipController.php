<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Friendship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FriendshipController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $friends = $user->friends()->withPivot('id')->paginate(10);
        $mutualWishlistUsers = $user->mutualWishlistUsers()
            ->whereNotIn('users.id', $friends->pluck('id'))
            ->get();

        return view('friendships.index', compact('friends', 'mutualWishlistUsers'));
    }

    public function store(Request $request, User $user)
    {
        if (Auth::id() === $user->id) {
            return redirect()->back()->with('error', __('You cannot add yourself as a friend.'));
        }

        if (Auth::user()->isFriendWith($user)) {
            return redirect()->back()->with('error', __('You are already friends with this user.'));
        }

        if (!Auth::user()->hasMutualWishlist($user)) {
            return redirect()->back()->with('error', __('You can only add friends from your mutual wishlist.'));
        }

        DB::transaction(function () use ($user) {
            Friendship::create([
                'user_id' => Auth::id(),
                'friend_id' => $user->id,
                'is_accepted' => true,
            ]);

            Friendship::create([
                'user_id' => $user->id,
                'friend_id' => Auth::id(),
                'is_accepted' => true,
            ]);

            // Remove from each other's wishlists
            Auth::user()->wishlist()->detach($user->id);
            $user->wishlist()->detach(Auth::id());
        });

        return redirect()->back()->with('success', __('Friend added successfully.'));
    }

    public function destroy(Friendship $friendship)
    {
        if ($friendship->user_id !== Auth::id() && $friendship->friend_id !== Auth::id()) {
            return redirect()->back()->with('error', __('You are not authorized to remove this friendship.'));
        }

        DB::transaction(function () use ($friendship) {
            // Delete the reciprocal friendship if it exists
            Friendship::where('user_id', $friendship->friend_id)
                      ->where('friend_id', $friendship->user_id)
                      ->delete();

            $friendship->delete();
        });

        return redirect()->back()->with('success', __('Friend removed successfully.'));
    }
}

