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
                                    <form action="{{ route('friendships.destroy', $friend->pivot) }}" method="POST">
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

                    <h3 class="mt-4">{{ __('Pending Friend Requests') }}</h3>
                    @if($pendingRequests->count() > 0)
                        <ul class="list-group">
                            @foreach($pendingRequests as $request)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        @if($request->user->avatar)
                                            <img src="{{ asset('storage/'.$request->user->avatar) }}" alt="{{ $request->user->name }}" class="rounded-circle me-2" width="32" height="32">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($request->user->name) }}&color=7F9CF5&background=EBF4FF" alt="{{ $request->user->name }}" class="rounded-circle me-2" width="32" height="32">
                                        @endif
                                        {{ $request->user->name }}
                                    </div>
                                    <div>
                                        <form action="{{ route('friendships.update', $request) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm">{{ __('Accept') }}</button>
                                        </form>
                                        <form action="{{ route('friendships.destroy', $request) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">{{ __('Reject') }}</button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>{{ __('You have no pending friend requests.') }}</p>
                    @endif

                    <h3 class="mt-4">{{ __('Sent Friend Requests') }}</h3>
                    @if($sentRequests->count() > 0)
                        <ul class="list-group">
                            @foreach($sentRequests as $request)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        @if($request->friend->avatar)
                                            <img src="{{ asset('storage/'.$request->friend->avatar) }}" alt="{{ $request->friend->name }}" class="rounded-circle me-2" width="32" height="32">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($request->friend->name) }}&color=7F9CF5&background=EBF4FF" alt="{{ $request->friend->name }}" class="rounded-circle me-2" width="32" height="32">
                                        @endif
                                        {{ $request->friend->name }}
                                    </div>
                                    <form action="{{ route('friendships.destroy', $request) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-warning btn-sm">{{ __('Cancel Request') }}</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>{{ __('You have no sent friend requests.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

