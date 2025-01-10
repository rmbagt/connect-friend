<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Hobby;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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

    public function create()
    {
        $hobbies = Hobby::all();
        return view('users.create', compact('hobbies'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'gender' => 'required|in:male,female',
            'instagram_username' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9._]+$/',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^[a-zA-Z0-9._]{1,30}$/', $value)) {
                        $fail('The instagram username is invalid.');
                    }
                },
            ],
            'mobile_number' => 'required|string|regex:/^[0-9]+$/',
            'hobbies' => 'required|array|min:3',
            'hobbies.*' => 'exists:hobbies,id',
            'bio' => 'required|string|max:500',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['registration_price'] = rand(100000, 125000);
        $validatedData['instagram_username'] = 'https://www.instagram.com/' . $validatedData['instagram_username'];

        $user = User::create($validatedData);
        $user->hobbies()->attach($request->hobbies);

        // Create a wallet for the user
        $user->wallet()->create(['balance' => 0]);

        Auth::login($user);

        return redirect()->route('payment.show')->with('success', __('Registration successful. Please complete your payment.'));
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
            'instagram_username' => 'required|string|max:255|regex:/^https:\/\/www\.instagram\.com\/[a-zA-Z0-9_.]+\/?$/',
            'mobile_number' => 'required|string|regex:/^[0-9]+$/',
            'hobbies' => 'required|array|min:3',
            'hobbies.*' => 'exists:hobbies,id',
            'avatar' => 'nullable|image|max:1024',
        ]);

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $validatedData['avatar'] = $avatarPath;
        }

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

