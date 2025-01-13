<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Hobby;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('hobbies')->where('is_visible', true)->get();
        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        $hobbies = Hobby::all();
        return view('users.edit', compact('user', 'hobbies'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'instagram_username' => 'required|string|max:255|regex:/^[a-zA-Z0-9._]+$/',
            'mobile_number' => 'required|string|regex:/^[0-9]+$/',
            'hobbies' => 'required|array|min:3',
            'hobbies.*' => 'exists:hobbies,id',
            'avatar' => 'nullable|image|max:1024',
            'bio' => 'nullable|string|max:500',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $validatedData['avatar'] = $avatarPath;
        }

        $validatedData['instagram_username'] = 'https://www.instagram.com/' . $validatedData['instagram_username'];

        $user->update($validatedData);
        $user->hobbies()->sync($request->hobbies);

        return redirect()->route('users.show', $user)->with('success', __('Profile updated successfully.'));
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();
        return redirect()->route('home')->with('success', __('Account deleted successfully.'));
    }
}

