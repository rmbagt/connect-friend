@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Friends') }}</div>

                <div class="card-body">
                    <h3>{{ __('Your Friends') }}</h3>
                    @if($friends->count() > 0)
                        <ul class="list-group">
                            @foreach($friends as $friend)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        @if($friend->avatar)
                                            <img src="{{ asset('storage/'.$friend->avatar) }}" alt="{{ $friend->name }}" class="rounded-circle me-2" width="32" height="32">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($friend->name) }}&color=7F9CF5&background=EBF4FF" alt="{{ $friend->name }}" class="rounded-circle me-2" width="32" height="32">
                                        @endif
                                        {{ $friend->name }}
                                    </div>
                                    <form action="{{ route('friendships.destroy', $friend->pivot->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">{{ __('Remove') }}</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                        {{ $friends->links() }}
                    @else
                        <p>{{ __('You have no friends yet.') }}</p>
                    @endif

                    <h3 class="mt-4">{{ __('Mutual Wishlist Users') }}</h3>
                    @if($mutualWishlistUsers->count() > 0)
                        <ul class="list-group">
                            @foreach($mutualWishlistUsers as $mutualUser)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        @if($mutualUser->avatar)
                                            <img src="{{ asset('storage/'.$mutualUser->avatar) }}" alt="{{ $mutualUser->name }}" class="rounded-circle me-2" width="32" height="32">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($mutualUser->name) }}&color=7F9CF5&background=EBF4FF" alt="{{ $mutualUser->name }}" class="rounded-circle me-2" width="32" height="32">
                                        @endif
                                        {{ $mutualUser->name }}
                                    </div>
                                    <form action="{{ route('friendships.store', $mutualUser) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">{{ __('Add Friend') }}</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>{{ __('You have no mutual wishlist users.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

