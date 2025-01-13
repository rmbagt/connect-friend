@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h1 class="mb-4 text-center text-md-start">{{ __('Messages') }}</h1>
        </div>
    </div>
    <div class="row">
        <!-- Conversations List -->
        <div class="col-md-4 mb-4 mb-md-0">
            <div class="list-group shadow-sm">
                @foreach($conversations as $conversation)
                    <a href="{{ route('messages.show', $conversation['friend']) }}" 
                       class="list-group-item list-group-item-action border-start-0 border-end-0 @if(request()->is('messages/' . $conversation['friend']->id)) active @endif">
                        <div class="d-flex align-items-center">
                            <img src="{{ $conversation['friend']->getAvatarUrl() }}" 
                                 alt="{{ $conversation['friend']->name }}" 
                                 class="rounded-circle"
                                 style="width: 40px; height: 40px; margin-right: 15px; object-fit: cover;">
                            
                            <div class="flex-grow-1 overflow-hidden">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 text-truncate">{{ $conversation['friend']->name }}</h6>
                                    @if($conversation['latest_message'])
                                        <small class="text-muted ms-2">{{ $conversation['latest_message']->created_at->diffForHumans() }}</small>
                                    @endif
                                </div>
                                <p class="mb-0 text-muted small text-truncate">
                                    @if($conversation['latest_message'])
                                        {{ Str::limit($conversation['latest_message']->content, 50) }}
                                    @else
                                        {{ __('No messages yet') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Messages View -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body text-center p-5">
                    <div class="text-muted mb-3">
                        <i class="fas fa-comments fa-3x"></i>
                    </div>
                    <h5 class="card-title">{{ __('Select a conversation to start messaging') }}</h5>
                    <p class="text-muted">{{ __('Choose a contact from the list to view your conversation') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

