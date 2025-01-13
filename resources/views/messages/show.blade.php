@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h4 class="mb-0">{{ __('Conversation with') }} {{ $user->name }}</h4>
                </div>
                <div class="card-body chat-container" style="height: 65vh; overflow-y: auto;">
                    @foreach($messages as $message)
                        <div class="message-bubble mb-3 {{ $message->sender_id == Auth::id() ? 'sent' : 'received' }}">
                            <div class="message-content {{ $message->sender_id == Auth::id() ? 'bg-primary text-white' : 'bg-light' }} p-3 rounded-lg">
                                <p class="mb-1">{{ $message->content }}</p>
                                <small class="{{ $message->sender_id == Auth::id() ? 'text-white-50' : 'text-muted' }}">
                                    {{ $message->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="card-footer bg-white">
                    <form action="{{ route('messages.store', $user) }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="content" class="form-control border-right-0" 
                                placeholder="{{ __('Type your message...') }}" required>
                            <div class="input-group-append">
                                <button class="btn btn-primary px-4" type="submit">
                                    {{ __('Send') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.chat-container {
    scrollbar-width: thin;
    scrollbar-color: rgba(0,0,0,.2) transparent;
}

.chat-container::-webkit-scrollbar {
    width: 6px;
}

.chat-container::-webkit-scrollbar-thumb {
    background-color: rgba(0,0,0,.2);
    border-radius: 3px;
}

.message-bubble {
    max-width: 75%;
}

.message-bubble.sent {
    margin-left: auto;
}

.message-bubble.received {
    margin-right: auto;
}

.message-content {
    box-shadow: 0 1px 2px rgba(0,0,0,.1);
}

.card {
    border-radius: 15px;
    border: none;
}

.card-header {
    border-top-left-radius: 15px !important;
    border-top-right-radius: 15px !important;
}
</style>
@endsection
