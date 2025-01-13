<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Avatar;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'gender',
        'instagram_username',
        'mobile_number',
        'registration_price',
        'is_visible',
        'avatar',
        'is_active',
        'bio',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_visible' => 'boolean',
        'is_active' => 'boolean',
        'registration_price' => 'integer',
    ];

    public function hobbies()
    {
        return $this->belongsToMany(Hobby::class, 'user_hobbies');
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
            ->withTimestamps();
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function wishlist()
    {
        return $this->belongsToMany(User::class, 'wishlists', 'user_id', 'wishlisted_user_id')->withTimestamps();
    }

    public function wishlistedBy()
    {
        return $this->belongsToMany(User::class, 'wishlists', 'wishlisted_user_id', 'user_id')->withTimestamps();
    }

    public function hasMutualWishlist(User $user)
    {
        return $this->wishlist()->where('wishlisted_user_id', $user->id)->exists() &&
               $user->wishlist()->where('wishlisted_user_id', $this->id)->exists();
    }

    public function mutualWishlistUsers()
    {
        return $this->belongsToMany(User::class, 'wishlists', 'user_id', 'wishlisted_user_id')
            ->whereIn('users.id', function ($query) {
                $query->select('user_id')
                    ->from('wishlists')
                    ->where('wishlisted_user_id', $this->id);
            });
    }

    public function isFriendWith(User $user)
    {
        return $this->friends()->where('friend_id', $user->id)->exists() ||
               $user->friends()->where('friend_id', $this->id)->exists();
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function avatars()
    {
        return $this->belongsToMany(Avatar::class, 'user_avatars')->withTimestamps();
    }

    public function getAvatarUrl()
    {
        $avatarUrls = [
            'https://i.pinimg.com/736x/5d/99/50/5d9950c70003b26a8ca28e6158c0b4f2.jpg',
            'https://i.pinimg.com/736x/fc/eb/41/fceb41ed28b6e8abd4018a75028c76b3.jpg',
            'https://i.pinimg.com/736x/50/24/e2/5024e20dadeb39798d512419e9985afe.jpg',
            'https://i.pinimg.com/736x/44/7b/01/447b01def7a69239c6ee5aae7bdf6c5e.jpg',
            'https://i.pinimg.com/736x/bb/ab/cc/bbabccb74b3f3825e0faa3af97fa296f.jpg',
        ];

        if ($this->avatar && in_array($this->avatar, $avatarUrls)) {
            return $this->avatar;
        }

        return $this->avatar ? asset('storage/' . $this->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }
}

