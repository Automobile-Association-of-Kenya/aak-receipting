@extends('layouts.guest')

@section('content')
    <div class="container">
        <div class="container-fluid h-100 d-flex align-items-center justify-content-center">
            <div class="col-md-5 mt-4">
                <div class="card mt-5" style="border: none;">
                    <div class="card-header bg-white text-center">
                        <img src="{{ asset('img/logo.png') }}" width="80px" alt="AA"><br>
                        <h5>Forgot Your Password</h5>
                        <p>{{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                        </p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('password.email') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="email"
                                    class="col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-12">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary  btn-block">
                                {{ __('Email Password Reset Link') }}
                            </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
