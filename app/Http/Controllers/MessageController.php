<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $conversations = $user->friends->map(function ($friend) use ($user) {
            $latestMessage = Message::where(function ($query) use ($user, $friend) {
                $query->where('sender_id', $user->id)->where('receiver_id', $friend->id);
            })->orWhere(function ($query) use ($user, $friend) {
                $query->where('sender_id', $friend->id)->where('receiver_id', $user->id);
            })->latest()->first();

            return [
                'friend' => $friend,
                'latest_message' => $latestMessage,
            ];
        });

        return view('messages.index', compact('conversations'));
    }

    public function show(User $user)
    {
        $this->authorize('message', $user);

        $messages = Message::where(function ($query) use ($user) {
            $query->where('sender_id', Auth::id())->where('receiver_id', $user->id);
        })->orWhere(function ($query) use ($user) {
            $query->where('sender_id', $user->id)->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        return view('messages.show', compact('user', 'messages'));
    }

    public function store(Request $request, User $user)
    {
        $this->authorize('message', $user);

        $validatedData = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'content' => $validatedData['content'],
        ]);

        return redirect()->back()->with('success', __('Message sent.'));
    }
}

