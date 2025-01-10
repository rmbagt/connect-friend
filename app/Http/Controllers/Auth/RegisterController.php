<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Hobby;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'gender' => ['required', 'in:male,female'],
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
            'mobile_number' => ['required', 'string', 'regex:/^[0-9]+$/'],
            'hobbies' => ['required', 'array', 'min:3'],
            'hobbies.*' => ['exists:hobbies,id'],
            'bio' => ['required', 'string', 'max:500'],
        ]);
    }

    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'gender' => $data['gender'],
            'instagram_username' => 'https://www.instagram.com/' . $data['instagram_username'],
            'mobile_number' => $data['mobile_number'],
            'registration_price' => rand(100000, 125000),
            'bio' => $data['bio'],
        ]);

        $user->hobbies()->attach($data['hobbies']);
        $user->wallet()->create(['balance' => 0]);

        return $user;
    }

    public function showRegistrationForm()
    {
        $hobbies = Hobby::all();
        return view('auth.register', compact('hobbies'));
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect()->route('payment.show');
    }
}

