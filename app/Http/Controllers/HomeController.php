<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Hobby;
use App\Models\Friendship;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['hobbies', 'wishlistedBy'])
            ->where('is_visible', true)
            ->where('is_active', true)
            ->where('id', '!=', Auth::id()); // Exclude the current user

        // Filter by gender
        if ($request->has('gender')) {
            $query->where('gender', $request->gender);
        }

        // Filter by hobby
        if ($request->has('hobby')) {
            $query->whereHas('hobbies', function ($q) use ($request) {
                $q->where('hobbies.id', $request->hobby);
            });
        }

        // Search by name or hobby
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                 ->orWhereHas('hobbies', function ($q) use ($search) {
                     $q->where('name', 'like', "%{$search}%");
                 });
            });
        }

        $users = $query->paginate(15);
        $hobbies = Hobby::all();

        // Get friend status for each user
        $friendships = Friendship::where('user_id', Auth::id())
            ->orWhere('friend_id', Auth::id())
            ->get()
            ->keyBy(function ($friendship) {
                return $friendship->user_id == Auth::id() ? $friendship->friend_id : $friendship->user_id;
            });

        return view('home', compact('users', 'hobbies', 'friendships'));
    }

    public function toggleWishlist(User $user)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $currentUser = Auth::user();
        $currentUser->wishlist()->toggle($user->id);

        return back();
    }
}

