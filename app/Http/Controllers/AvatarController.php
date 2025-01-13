<?php

namespace App\Http\Controllers;

use App\Models\Avatar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvatarController extends Controller
{
    public function index()
    {
        $avatars = Avatar::all();
        return view('avatars.index', compact('avatars'));
    }

    public function purchase(Request $request, Avatar $avatar)
    {
        $user = Auth::user();

        if ($user->wallet->balance < $avatar->price) {
            return redirect()->back()->with('error', 'Insufficient balance to purchase this avatar.');
        }

        $user->wallet->balance -= $avatar->price;
        $user->wallet->save();

        $user->avatars()->attach($avatar->id);

        return redirect()->back()->with('success', 'Avatar purchased successfully!');
    }

    public function setAsProfilePicture(Avatar $avatar)
    {
        $user = Auth::user();

        if (!$user->avatars->contains($avatar)) {
            return redirect()->back()->with('error', 'You do not own this avatar.');
        }

        $user->avatar = $avatar->image_path;
        $user->save();

        return redirect()->back()->with('success', 'Avatar set as profile picture successfully!');
    }
}

