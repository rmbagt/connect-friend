<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Hobby;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $hobbies = Hobby::all();

        User::factory()->count(3)->create()->each(function ($user) use ($hobbies) {
            $user->hobbies()->attach(
                $hobbies->random(rand(3, 5))->pluck('id')->toArray()
            );
        });

        // Create a test user
        $testUser = User::create([
            'name' => 'RMBA GT',
            'email' => 'rmbagt@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'gender' => 'male',
            'bio' => 'A person who loves to code and play games.',
            'instagram_username' => 'https://www.instagram.com/reynaldo_marchellba',
            'mobile_number' => '085263728174',
            'registration_price' => 100000 + rand(0, 25000),
            'remember_token' => Str::random(10),
            'is_active' => true,
        ]);

        $testUser->hobbies()->attach(
            $hobbies->random(3)->pluck('id')->toArray()
        );
    }
}

