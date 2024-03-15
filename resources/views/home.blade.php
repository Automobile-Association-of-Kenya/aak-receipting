@extends('layouts.app')

@section('title')
    <title>Dashboard</title>
@endsection

@section('header_styles')
    <style>
        .dashboard .filter .dropdown-header h6 {
            text-transform: uppercase;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 1px;
            color: #aab7cf;
            margin-bottom: 0;
            padding: 0;
        }

        .card {
            margin-bottom: 30px;
            border: none;
            border-radius: 5px;
            box-shadow: 0px 0 30px rgba(1, 41, 112, 0.1);
        }

        .dashboard .filter .dropdown-item {
            padding: 8px 15px;
        }

        /* Info Cards */
        .dashboard .info-card {
            padding-bottom: 10px;
        }

        .dashboard .info-card h6 {
            font-size: 28px;
            color: #012970;
            font-weight: 700;
            margin: 0;
            padding: 0;
        }

        .dashboard .card-icon {
            font-size: 32px;
            line-height: 0;
            width: 64px;
            height: 64px;
            flex-shrink: 0;
            flex-grow: 0;
        }

        .dashboard .sales-card .card-icon {
            color: #fed925;
            background: #f6f6fe;
        }

        .dashboard .revenue-card .card-icon {
            color: #fed925;
            background: hsl(143, 63%, 93%);
        }

        .dashboard .customers-card .card-icon {
            color: #036242;
            background: #ffecdf;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">

        <section class="section dashboard">
            <div class="row">

                <div class="col-lg-12">
                    <div class="row">


                    <div class="col-xxl-4 col-md-4">
                            <div class="card info-card customers-card">
                                <div class="card-body">
                                    <h5 class="card-title">Customers | <span class="text-warning"
                                            id="todaysCustomerCount"style="font-size: 12px;"></span></h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="fas fa-address-book"></i>
                                        </div>
                                        <div class="pl-3" id="customerSummary1">
                                            <h6 id="customersCount1"></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xxl-4 col-md-4">
                            <div class="card info-card customers-card">
                                <div class="card-body">
                                    <h5 class="card-title">Invoices | <span class="text-warning"
                                            id="todaysInvoicesCount"style="font-size: 12px;"></span></h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="fas fa-file-invoice-dollar"></i>
                                        </div>
                                        <div class="pl-3" id="invoicesSummary">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-4 col-md-4">
                            <div class="card info-card revenue-card">
                                <div class="card-body">
                                    <h5 class="card-title">Payments | <span class="text-warning" id="todayPaymentsCount"
                                            style="font-size: 12px;"></span></h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center pr-2">
                                            <i class="fas fa-money-bill"></i>
                                        </div>
                                        <div class="pl-3" id="paymentSummary">
                                            <h6 id="totalPayments"></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-4 col-md-4">
                            <div class="card info-card customers-card">
                                <div class="card-body">
                                    <h5 class="card-title">Users | <span class="text-warning"
                                            id="todayUsersCount"style="font-size: 12px;"></span></h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <div class="pl-3" id="usersSummary1">
                                            {{-- <h6 id="totalCustomersCount1">{{$total_users}}</h6> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection

@section('footer_scripts')
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endsection
