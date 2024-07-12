<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipting - Sales Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        header {
            background: rgba(2, 79, 49, 0.85);
            color: #fff;
            padding: 5px 0;
        }

        .logo {
            height: 50px;
            display: block;
            margin: auto;
        }

        .btn-custom {
            background: rgba(2, 79, 49, 0.85);
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-custom:hover {
            background: rgba(2, 79, 49, 0.85);
            color: #fff;
        }

        .form-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 100%;
        }

        .center {
            text-align: center;
        }

        .content-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
            padding-bottom: 40px;
        }

        .left-half {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .right-half {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .signup-link {
            margin-top: 10px;
        }

        h6 a {
            text-decoration: none;
            color: rgba(2, 79, 49, 0.85);
        }

        h6 a:hover {
            color: rgba(2, 79, 49, 0.7);
        }

        footer {
            background: rgba(2, 79, 49, 0.85);
            color: #fff;
            text-align: center;
            padding: 10px 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="text-center">
            <img src="{{ asset('img/logo.png') }}" alt="AA LOGO" class="logo">
        </header>
        <main class="content-wrapper mt-5">
            <div class="row w-100 p-b-5">
                <div class="col-md-4 left-half">
                    <h1 class="center" style="font-weight:800; color:rgba(2, 79, 49, 0.85);">Login</h1>
                    <h6 class="signup-link"><a href="{{ route('signupSalescode') }}">Do not have an account? Signup</a></h6>
                </div>
                <div class="col-md-8 right-half">
                    <div class="form-container col-md-7">
                        <h2 class="center">Login</h2>
                        <form action="{{ route('salesCode') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="email" class="col-form-label text-md-right">{{ __('Sales Code') }}</label>
                                <div class="col-md-12">
                                    <input id="salesCode" type="text" class="form-control @error('salesCode') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('salesCode')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-form-label text-md-right">{{ __('Password') }}</label>
                                <div class="col-md-12">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <button type="submit" class="btn btn-custom btn-block">
                                {{ __('Login') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
        <footer>
            Copyright &copy; 2024
        </footer>
    </div>
</body>
</html>
