<?php

namespace Database\Seeders;

use App\Models\Hobby;
use Illuminate\Database\Seeder;

class HobbySeeder extends Seeder
{
    public function run(): void
    {
        $hobbies = [
            'Reading', 'Writing', 'Painting', 'Photography', 'Cooking',
            'Gardening', 'Hiking', 'Traveling', 'Music', 'Dancing',
            'Sports', 'Gaming', 'Coding', 'Yoga', 'Meditation'
        ];

        foreach ($hobbies as $hobby) {
            Hobby::create(['name' => $hobby]);
        }
    }
}

