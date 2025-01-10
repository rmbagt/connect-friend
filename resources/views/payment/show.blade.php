@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Payment') }}</div>

                <div class="card-body">
                    <h5>Registration Fee: ${{ number_format($user->registration_price / 100, 2) }}</h5>
                    <form method="POST" action="{{ route('payment.process') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="amount" class="form-label">{{ __('Enter Payment Amount') }}</label>
                            <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" step="0.01" required>
                            @error('amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Submit Payment') }}</button>
                    </form>

                    @if (session('warning'))
                        <div class="alert alert-warning mt-3" role="alert">
                            {{ session('warning') }}
                        </div>
                    @endif

                    @if (session('overpayment'))
                        <div class="alert alert-info mt-3" role="alert">
                            {{ session('overpayment') }}
                            <form method="POST" action="{{ route('payment.handle-overpayment') }}">
                                @csrf
                                <input type="hidden" name="overpayment_amount" value="{{ session('overpayment_amount') }}">
                                <button type="submit" name="action" value="add_to_wallet" class="btn btn-sm btn-success">Yes, add to wallet</button>
                                <button type="submit" name="action" value="refund" class="btn btn-sm btn-danger">No, I want to pay again</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

