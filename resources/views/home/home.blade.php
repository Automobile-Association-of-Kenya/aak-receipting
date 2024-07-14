<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipting</title>
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/iziToast.min.css') }}" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color:rgba(0, 0, 0, 0.1);
        }

        header {
            background: rgba(2, 79, 49, 0.85);
            color: #fff;
            padding: 3px 0;
        }

        .logo {
            height: 50px;
            display: block;
            margin: auto;
        }

        .btn-custom {
            background: rgba(2, 79, 49, 0.85);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            padding: 10px 20px;
            display: inline-block;
            margin-top: 10px;
        }

        .btn-custom:hover {
            background: rgba(2, 79, 49, 0.85);
            color: #fff;
        }

        .center {
            text-align: center;
            margin-top: 50px;
        }

        .custom-heading {
            font-size: 15px;
            font-weight: 900;
        }

        .card-custom {
            background-color: white;
            border: none;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: white;
            margin: 20px 0;
        }

        .card-icon {
            font-size: 8rem;
            margin-bottom: 10px;
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
            <img src="{{ asset('img/logo.png') }}" alt="AA LOGOAAK" class="logo">

        </header>
        <main>
            <div class="row justify-content-center mt-5">
                <div class="col-md-5">
                    <div class="card-custom">
                        <a href="/login" class="btn btn-custom">Billing System</a>
                        <div class="mt-2">
                            <i class="bi bi-receipt card-icon" style="color: #f4d616;"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card-custom">
                        <a href="{{ route('login') }}" class="btn btn-custom">Sales Campaign</a>
                        <div class="mt-2">
                            <i class="bi bi-graph-up card-icon" style="color: rgba(2, 79, 49, 0.85);"></i>
                        </div>
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


