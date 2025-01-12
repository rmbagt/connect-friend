@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h2>Welcome, {{ Auth::user()->name }}!</h2>
                    <p>{{ __('You are logged in!') }}</p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">{{ __('Profile Information') }}</div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>Gender:</strong> {{ ucfirst(Auth::user()->gender) }}</p>
                    <p><strong>Instagram:</strong> <a href="{{ Auth::user()->instagram_username }}" target="_blank">{{ Auth::user()->instagram_username }}</a></p>
                    <p><strong>Mobile:</strong> {{ Auth::user()->mobile_number }}</p>
                    <a href="{{ route('users.edit', Auth::user()) }}" class="btn btn-primary">Edit Profile</a>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">{{ __('Your Hobbies') }}</div>
                <div class="card-body">
                    @if(Auth::user()->hobbies->count() > 0)
                        <ul>
                            @foreach(Auth::user()->hobbies as $hobby)
                                <li>{{ $hobby->name }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p>You haven't added any hobbies yet.</p>
                    @endif
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">{{ __('Wallet') }}</div>
                <div class="card-body">
                    <p><strong>Balance:</strong> Rp {{ number_format(Auth::user()->wallet->balance, 0, ',', '.') }}</p>
                    <a href="{{ route('wallet.show') }}" class="btn btn-primary">Manage Wallet</a>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">{{ __('Friends') }}</div>
                <div class="card-body">
                    @if(Auth::user()->friends->count() > 0)
                        <ul>
                            @foreach(Auth::user()->friends->take(5) as $friend)
                                <li>{{ $friend->name }}</li>
                            @endforeach
                        </ul>
                        @if(Auth::user()->friends->count() > 5)
                            <p>And {{ Auth::user()->friends->count() - 5 }} more...</p>
                        @endif
                    @else
                        <p>You haven't added any friends yet.</p>
                    @endif
                    <a href="{{ route('friendships.index') }}" class="btn btn-primary">Manage Friends</a>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">{{ __('Messages') }}</div>
                <div class="card-body">
                    <a href="{{ route('messages.index') }}" class="btn btn-primary">View Messages</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

