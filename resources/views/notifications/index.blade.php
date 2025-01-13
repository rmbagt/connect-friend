@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0">{{ __('Notifications') }}</h5>
                    @if($notifications->where('read_at', null)->count() > 0)
                        <button id="markAllAsRead" class="btn btn-primary btn-sm rounded-pill px-3">
                            {{ __('Mark all as read') }}
                        </button>
                    @endif
                </div>

                <div class="card-body p-0">
                    @if($notifications->count() > 0)
                        <div class="list-group list-group-flush" id="notificationsList">
                            @foreach($notifications as $notification)
                                <div class="list-group-item {{ $notification->read_at ? 'bg-light' : '' }}" 
                                     id="notification-{{ $notification->id }}">
                                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                                        <div class="notification-content">
                                            <p class="mb-1 text-break">{{ $notification->content }}</p>
                                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                        </div>
                                        <div class="notification-actions d-flex gap-2">
                                            <a href="{{ route('notifications.viewAndMarkAsRead', $notification) }}" 
                                               class="btn btn-info btn-sm rounded-pill px-3">
                                                {{ __('View') }}
                                            </a>
                                            @if(!$notification->read_at)
                                                <button class="btn btn-outline-primary btn-sm rounded-pill px-3 mark-as-read" 
                                                        data-id="{{ $notification->id }}">
                                                    {{ __('Mark as read') }}
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="px-3 py-3">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <div class="p-4 text-center text-muted">
                            <i class="fas fa-bell-slash mb-3" style="font-size: 2rem;"></i>
                            <p class="mb-0">{{ __('No notifications.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Keep the existing JavaScript code as is
</script>
@endpush

@push('styles')
<style>
.list-group-item {
    transition: background-color 0.3s ease;
}

.btn {
    transition: all 0.3s ease;
}

.notification-content {
    flex: 1;
}

@media (max-width: 768px) {
    .notification-actions {
        width: 100%;
    }
}
</style>
@endpush
