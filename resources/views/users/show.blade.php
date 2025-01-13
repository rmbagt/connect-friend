@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">{{ __('User Profile') }}</h4>
                </div>

                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        @if($user->avatar)
                            <img src="{{ asset('storage/'.$user->avatar) }}" 
                                 alt="{{ $user->name }}" 
                                 class="rounded-circle shadow-sm img-thumbnail"
                                 width="150" height="150">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=7F9CF5&background=EBF4FF"
                                 alt="{{ $user->name }}" 
                                 class="rounded-circle shadow-sm img-thumbnail"
                                 width="150" height="150">
                        @endif
                        <h2 class="mt-3 mb-1">{{ $user->name }}</h2>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-item p-3 bg-light rounded">
                                <i class="fas fa-envelope me-2"></i>
                                <strong>{{ __('Email') }}:</strong>
                                <div class="text-break">{{ $user->email }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item p-3 bg-light rounded">
                                <i class="fas fa-venus-mars me-2"></i>
                                <strong>{{ __('Gender') }}:</strong>
                                <div>{{ ucfirst($user->gender) }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item p-3 bg-light rounded">
                                <i class="fab fa-instagram me-2"></i>
                                <strong>{{ __('Instagram') }}:</strong>
                                <div><a href="{{ $user->instagram_username }}" target="_blank" class="text-decoration-none">{{ $user->instagram_username }}</a></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item p-3 bg-light rounded">
                                <i class="fas fa-mobile-alt me-2"></i>
                                <strong>{{ __('Mobile') }}:</strong>
                                <div>{{ $user->mobile_number }}</div>
                            </div>
                        </div>
                    </div>

                    @if($user->bio)
                        <div class="mt-4 p-3 bg-light rounded">
                            <strong>{{ __('Bio') }}:</strong>
                            <p class="mt-2 mb-0">{{ $user->bio }}</p>
                        </div>
                    @endif

                    <div class="mt-4">
                        <h4 class="mb-3">
                            <i class="fas fa-heart me-2"></i>
                            {{ __('Hobbies') }}
                        </h4>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($user->hobbies as $hobby)
                                <span class="badge bg-secondary">{{ $hobby->name }}</span>
                            @endforeach
                        </div>
                    </div>

                    @if(Auth::id() === $user->id)
                        <div class="text-center mt-4">
                            <a href="{{ route('users.edit', $user) }}" 
                               class="btn btn-primary px-4">
                                <i class="fas fa-edit me-2"></i>
                                {{ __('Edit Profile') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .info-item {
        transition: all 0.3s ease;
    }
    .info-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
</style>
@endpush
