<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_visible' => 'boolean',
        'registration_price' => 'integer',
    ];

    public function hobbies()
    {
        return $this->belongsToMany(Hobby::class, 'user_hobbies');
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
            ->wherePivot('is_accepted', true)
            ->withTimestamps();
    }

    public function sentFriendRequests()
    {
        return $this->hasMany(Friendship::class, 'user_id')->where('is_accepted', false);
    }

    public function receivedFriendRequests()
    {
        return $this->hasMany(Friendship::class, 'friend_id')->where('is_accepted', false);
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
}

