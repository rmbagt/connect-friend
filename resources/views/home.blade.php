@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h2>Welcome, {{ Auth::user()->name }}!</h2>
                    <p>{{ __('You are logged in!') }}</p>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">{{ __('Account Status') }}</div>
                <div class="card-body">
                    <p><strong>Status:</strong> 
                        @if(Auth::user()->is_active)
                            <span class="text-success">Active</span>
                        @else
                            <span class="text-danger">Inactive</span>
                        @endif
                    </p>
                    @if(!Auth::user()->is_active)
                        <a href="{{ route('payment.show') }}" class="btn btn-primary">Complete Payment</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

