<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Avatar;

class AvatarSeeder extends Seeder
{
    public function run(): void
    {
        $avatars = [
            ['name' => 'Basic Avatar', 'image_path' => 'https://i.pinimg.com/736x/5d/99/50/5d9950c70003b26a8ca28e6158c0b4f2.jpg', 'price' => 50],
            ['name' => 'Cool Avatar', 'image_path' => 'https://i.pinimg.com/736x/fc/eb/41/fceb41ed28b6e8abd4018a75028c76b3.jpg', 'price' => 500],
            ['name' => 'Super Avatar', 'image_path' => 'https://i.pinimg.com/736x/50/24/e2/5024e20dadeb39798d512419e9985afe.jpg', 'price' => 5000],
            ['name' => 'Ultra Avatar', 'image_path' => 'https://i.pinimg.com/736x/44/7b/01/447b01def7a69239c6ee5aae7bdf6c5e.jpg', 'price' => 50000],
            ['name' => 'Legendary Avatar', 'image_path' => 'https://i.pinimg.com/736x/bb/ab/cc/bbabccb74b3f3825e0faa3af97fa296f.jpg', 'price' => 100000],
        ];

        foreach ($avatars as $avatar) {
            Avatar::create($avatar);
        }
    }
}

