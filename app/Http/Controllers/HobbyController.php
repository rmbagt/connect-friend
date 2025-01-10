<?php

namespace App\Http\Controllers;

use App\Models\Hobby;
use Illuminate\Http\Request;

class HobbyController extends Controller
{
    public function index()
    {
        $hobbies = Hobby::withCount('users')->get();
        return view('hobbies.index', compact('hobbies'));
    }

    public function show(Hobby $hobby)
    {
        $users = $hobby->users()->where('is_visible', true)->paginate(15);
        return view('hobbies.show', compact('hobby', 'users'));
    }
}

