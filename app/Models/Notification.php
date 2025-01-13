<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'content', 'type', 'read_at', 'data'];

    protected $casts = [
        'read_at' => 'datetime',
        'data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTargetUrl()
    {
        switch ($this->type) {
            case 'friend_request_accepted':
                return route('friendships.index');
            case 'new_message':
                $senderId = $this->data['sender_id'] ?? null;
                return $senderId ? route('messages.show', $senderId) : route('messages.index');
            default:
                return route('notifications.index');
        }
    }
}

