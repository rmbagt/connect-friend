@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="text-center mb-5 fw-bold">{{ __('Discover Friends') }}</h1>

    <div class="row justify-content-center mb-5">
        <div class="col-12 col-lg-10">
            <div class="row g-3">
                <!-- Search Form -->
                <div class="col-md-5">
                    <form action="{{ route('home') }}" method="GET">
                        <div class="input-group shadow-sm">
                            <input type="text" name="search" class="form-control border-end-0" 
                                   placeholder="{{ __('Search by name or hobby') }}" 
                                   value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Filter Form -->
                <div class="col-md-7">
                    <form action="{{ route('home') }}" method="GET">
                        <div class="row g-2">
                            <div class="col-sm-5">
                                <select name="gender" class="form-select shadow-sm">
                                    <option value="">{{ __('All Genders') }}</option>
                                    <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                                    <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                                </select>
                            </div>
                            <div class="col-sm-5">
                                <select name="hobby" class="form-select shadow-sm">
                                    <option value="">{{ __('All Hobbies') }}</option>
                                    @foreach($hobbies as $hobby)
                                        <option value="{{ $hobby->id }}" {{ request('hobby') == $hobby->id ? 'selected' : '' }}>
                                            {{ $hobby->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <button type="submit" class="btn btn-primary w-100 shadow-sm">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        @foreach($users as $user)
            <div class="col-sm-6 col-lg-4">
                <div class="card h-100 shadow-sm hover-shadow transition-all">
                    <img src="{{ $user->getAvatarUrl() }}" 
                         class="card-img-top object-fit-cover" style="height: 200px" 
                         alt="{{ $user->name }}">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-3">{{ $user->name }}</h5>
                        <p class="card-text text-muted">
                            <i class="fas fa-user me-2"></i>{{ ucfirst($user->gender) }}<br>
                            <i class="fas fa-heart me-2"></i>{{ $user->hobbies->pluck('name')->implode(', ') }}
                        </p>
                        @auth
                            @if(Auth::user()->isFriendWith($user))
                                <button class="btn btn-secondary w-100" disabled>
                                    <i class="fas fa-user-check me-2"></i>{{ __('Friends') }}
                                </button>
                            @elseif(Auth::user()->hasMutualWishlist($user))
                                <form action="{{ route('friendships.store', $user) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-user-plus me-2"></i>{{ __('Add Friend') }}
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('wishlist.toggle', $user) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-primary w-100">
                                        @if(Auth::user()->wishlist->contains($user))
                                            <i class="fas fa-heart-broken me-2"></i>{{ __('Remove from Wishlist') }}
                                        @else
                                            <i class="fas fa-heart me-2"></i>{{ __('Add to Wishlist') }}
                                        @endif
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary w-100">
                                <i class="fas fa-sign-in-alt me-2"></i>{{ __('Login to Interact') }}
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-5">
        {{ $users->links() }}
    </div>
</div>

<style>
.hover-shadow:hover {
    transform: translateY(-5px);
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
}
.transition-all {
    transition: all .3s ease;
}
</style>
@endsection

