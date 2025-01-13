@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">{{ __('Edit Profile') }}</h4>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('users.update', $user) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Profile Information Section -->
                        <div class="mb-4">
                            <h5 class="text-muted mb-3">Personal Information</h5>
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('Name') }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                    name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="gender" class="form-label">{{ __('Gender') }}</label>
                                <select id="gender" class="form-select @error('gender') is-invalid @enderror" name="gender" required>
                                    <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                                    <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Contact Information Section -->
                        <div class="mb-4">
                            <h5 class="text-muted mb-3">Contact Information</h5>

                            <div class="mb-3">
                                <label for="instagram_username" class="form-label">{{ __('Instagram Username') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">instagram.com/</span>
                                    <input id="instagram_username" type="text" class="form-control @error('instagram_username') is-invalid @enderror" 
                                        name="instagram_username" value="{{ old('instagram_username', str_replace('https://www.instagram.com/', '', $user->instagram_username)) }}" required>
                                </div>
                                @error('instagram_username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="mobile_number" class="form-label">{{ __('Mobile Number') }}</label>
                                <input id="mobile_number" type="text" class="form-control @error('mobile_number') is-invalid @enderror" 
                                    name="mobile_number" value="{{ old('mobile_number', $user->mobile_number) }}" required>
                                @error('mobile_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Profile Details Section -->
                        <div class="mb-4">
                            <h5 class="text-muted mb-3">Profile Details</h5>

                            <div class="mb-3">
                                <label for="avatar" class="form-label">{{ __('Profile Picture') }}</label>
                                <input id="avatar" type="file" class="form-control @error('avatar') is-invalid @enderror" name="avatar">
                                @error('avatar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="bio" class="form-label">{{ __('Bio') }}</label>
                                <textarea id="bio" class="form-control @error('bio') is-invalid @enderror" 
                                    name="bio" rows="4" placeholder="Tell us about yourself...">{{ old('bio', $user->bio) }}</textarea>
                                @error('bio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Hobbies Section -->
                        <div class="mb-4">
                            <h5 class="text-muted mb-3">{{ __('Hobbies') }}</h5>
                            <div class="row g-3">
                                @foreach($hobbies as $hobby)
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="hobbies[]" 
                                                value="{{ $hobby->id }}" id="hobby_{{ $hobby->id }}"
                                                {{ (is_array(old('hobbies', $user->hobbies->pluck('id')->toArray())) && 
                                                    in_array($hobby->id, old('hobbies', $user->hobbies->pluck('id')->toArray()))) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="hobby_{{ $hobby->id }}">
                                                {{ $hobby->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('hobbies')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-4">
                                {{ __('Update Profile') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
