@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-5 fw-bold">Avatar Shop</h1>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($avatars as $avatar)
            <div class="col">
                <div class="card h-100 shadow-sm hover-shadow transition-transform">
                    <div class="position-relative">
                        <img src="{{ asset($avatar->image_path) }}" 
                             class="card-img-top img-fluid p-3" 
                             alt="{{ $avatar->name }}"
                             style="height: 250px; object-fit: contain;">
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold mb-3">{{ $avatar->name }}</h5>
                        <p class="card-text text-muted mb-4">
                            <span class="fs-5 fw-semibold text-primary">
                                Rp {{ number_format($avatar->price, 0, ',', '.') }}
                            </span>
                        </p>
                        @if(Auth::user()->avatars->contains($avatar))
                            <form action="{{ route('avatars.set-profile-picture', $avatar) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100 rounded-pill">
                                    Set as Profile Picture
                                </button>
                            </form>
                        @else
                            <form action="{{ route('avatars.purchase', $avatar) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success w-100 rounded-pill">
                                    Purchase Now
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
.hover-shadow:hover {
    transform: translateY(-5px);
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
}

.transition-transform {
    transition: all 0.3s ease;
}
</style>
@endsection
