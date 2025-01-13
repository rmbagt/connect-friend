@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h2 class="mb-0 h5">{{ __('Friends') }}</h2>
                </div>

                <div class="card-body">
                    <!-- Friends Section -->
                    <div class="mb-5">
                        <h3 class="h5 mb-4">{{ __('Your Friends') }}</h3>
                        @if($friends->count() > 0)
                            <div class="list-group">
                                @foreach($friends as $friend)
                                    <div class="list-group-item border-start-0 border-end-0 d-flex justify-content-between align-items-center py-3">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $friend->getAvatarUrl() }}" alt="{{ $friend->name }}" 
                                                    class="rounded-circle me-3" width="40" height="40">
                                            <span class="fw-medium">{{ $friend->name }}</span>
                                        </div>
                                        <form action="{{ route('friendships.destroy', $friend->pivot->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-user-minus me-1"></i>{{ __('Remove') }}
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-4">
                                {{ $friends->links() }}
                            </div>
                        @else
                            <div class="alert alert-info">{{ __('You have no friends yet.') }}</div>
                        @endif
                    </div>

                    <!-- Mutual Wishlist Users Section -->
                    <div>
                        <h3 class="h5 mb-4">{{ __('Mutual Wishlist Users') }}</h3>
                        @if($mutualWishlistUsers->count() > 0)
                            <div class="list-group">
                                @foreach($mutualWishlistUsers as $mutualUser)
                                    <div class="list-group-item border-start-0 border-end-0 d-flex justify-content-between align-items-center py-3">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $mutualUser->getAvatarUrl() }}" alt="{{ $mutualUser->name }}" 
                                                    class="rounded-circle me-3" width="40" height="40">
                                            <span class="fw-medium">{{ $mutualUser->name }}</span>
                                        </div>
                                        <form action="{{ route('friendships.store', $mutualUser) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-success btn-sm">
                                                <i class="fas fa-user-plus me-1"></i>{{ __('Add Friend') }}
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-info">{{ __('You have no mutual wishlist users.') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

