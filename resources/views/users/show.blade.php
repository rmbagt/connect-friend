@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('User Profile') }}</div>

                <div class="card-body">
                    <div class="text-center mb-4">
                        @if($user->avatar)
                            <img src="{{ asset('storage/'.$user->avatar) }}" alt="{{ $user->name }}" class="rounded-circle" width="150">
                        @else
                            <img src="https://via.placeholder.com/150" alt="{{ $user->name }}" class="rounded-circle">
                        @endif
                    </div>

                    <h2 class="text-center mb-4">{{ $user->name }}</h2>

                    <p><strong>{{ __('Email') }}:</strong> {{ $user->email }}</p>
                    <p><strong>{{ __('Gender') }}:</strong> {{ ucfirst($user->gender) }}</p>
                    <p><strong>{{ __('Instagram') }}:</strong> <a href="{{ $user->instagram_username }}" target="_blank">{{ $user->instagram_username }}</a></p>
                    <p><strong>{{ __('Mobile') }}:</strong> {{ $user->mobile_number }}</p>
                    
                    @if($user->bio)
                        <p><strong>{{ __('Bio') }}:</strong> {{ $user->bio }}</p>
                    @endif

                    <h4 class="mt-4">{{ __('Hobbies') }}</h4>
                    <ul>
                        @foreach($user->hobbies as $hobby)
                            <li>{{ $hobby->name }}</li>
                        @endforeach
                    </ul>

                    @if(Auth::id() === $user->id)
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-primary mt-3">{{ __('Edit Profile') }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

