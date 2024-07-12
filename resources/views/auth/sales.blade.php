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
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            height: 100vh;
        }

        .container {
            border: 3px solid #e4cfff;
            padding: 20px;
            background: #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 1200px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        header {
            background: rgba(2, 79, 49, 0.85);
            color: #fff;
            padding: 10px 0;
            text-align: center;
            position: relative;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .logo {
            height: 50px;
            display: block;
            margin: auto;
        }

        .sales-code {
            font-weight: bold;
            color: #fff;
            position: absolute;
            top: 15px;
            right: 20px;
        }

        main {
            text-align: center;
            flex: 1;
        }

        .stats-row {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .stats-block {
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            flex: 1;
            margin: 10px;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            min-width: 200px;
        }

        .highlight {
            font-weight: bold;
            font-size: 1.2em;
            margin-bottom: 5px;
        }

        .achieved {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .chart-container {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto;
        }

        .chart-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 1em;
            font-weight: bold;
        }

        .line-chart-container {
            margin-top: 10px;
        }

        .line-chart {
            width: 100%;
            height: 200px;
        }

        footer {
            background: rgba(2, 79, 49, 0.85);
            color: #fff;
            text-align: center;
            padding: 10px 0;
            width: 100%;
            border-radius: 8px;
            margin-top: 20px;
        }

        .submit-button {
            background-color: rgba(2, 79, 49, 0.85);
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            display: inline-block;
            cursor: pointer;
            border-radius: 4px;
            transition-duration: 0.4s;
        }

        .submit-button:hover {
            background-color: #45a049;
            /* Darker green background color on hover */
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <img src="{{ asset('img/logo.png') }}" alt="AA LOGOAAK" class="logo">
            <div class="sales-code">
                @auth
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span
                                class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->sales_code }}</span>
                            <img class="img-profile rounded-circle" src="{{ asset('img/undraw_profile.svg') }}">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="userDropdown">
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </li>
                @endauth
            </div>
        </header>
        <main>
            <div class="stats-row">
                <div class="stats-block">
                    <div class="highlight">Overall Target</div>
                    <div class="text-center">
                        <div class="highlight" id="totalTarget">Loading...</div>
                    </div>
                </div>

                <div class="stats-block">
                    <div class="highlight">Actual</div>

                    <form action="{{ url('sales-filter') }}" id="filterSalesForm">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <input type="date" class="form-control form-control-sm" id="actualStartDate"
                                    name="actualStartDate" placeholder="Start" value="{{ $startOfYear }}">
                            </div>

                            <div class="col-6">
                                <input type="date" class="form-control form-control-sm" id="actualEndDate"
                                    name="actualEndDate" placeholder="End" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </form>

                    <div>
                        <div class="highlight" id="totalAchieved">Loading...</div>
                    </div>
                </div>
            </div>

            <div class="stats-row">
                <div class="card col-md-12">

                    <div class="card-header bg-white">
                        <div class="row">
                            <div class="col-7">Sales Graph</div>
                            <div class="col-5">
                                <form action="#" id="salesPerformanceForm">
                                    @csrf
                                    <select name="salesYearForMonthSummary" id="salesYearForMonthSummary"
                                        class="form-control form-control-sm">
                                        @for ($i = date('Y'); $i >= 2020; $i--)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="line-chart-container">
                            <canvas id="lineChart" class="line-chart"></canvas>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <footer>
        Copyright &copy; 2024
    </footer>

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/performance.js') }}"></script>
</body>

</html>
