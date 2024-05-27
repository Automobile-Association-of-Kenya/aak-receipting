@extends('layouts.app')

@section('title')
    <title>Credits</title>
@endsection

@section('header_styles')
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <!-- Display success message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Display error messages -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Credits</h6>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createCreditModal">
                    <i class="fas fa-plus"></i>&nbsp;Add Credit
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="creditTableSection">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Credit No</th>
                                <th>Customer No</th>
                                <th>Customer Name</th>
                                <th>Amount</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($credits as $credit)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $credit->credit_no }}</td>
                                    <td>{{ $credit->customer_no }}</td>
                                    <td>{{ $credit->customer_name }}</td>
                                    <td>{{ $credit->amount }}</td>
                                    <td>{{ $credit->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Creating Credit -->
   <!-- Modal for Creating Credit -->
<div class="modal fade" id="createCreditModal" tabindex="-1" role="dialog" aria-labelledby="createCreditModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Credit</h5>
                <button type="button" class="close btn btn-warning text-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('credits.store') }}" method="POST" id="createCreditForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" style="font-size:14px">
                                <label for="creditNo">Credit No</label>
                                <input type="text" class="form-control" id="creditNo" name="credit_no" placeholder="Enter Credit No" value="{{ old('credit_no') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" style="font-size:14px">
                                <label for="customerNo">Customer No</label>
                                <input type="text" class="form-control" id="customerNo" name="customer_no" placeholder="Enter Customer No" value="{{ old('customer_no') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" style="font-size:14px">
                                <label for="customerName">Customer Name</label>
                                <input type="text" class="form-control" id="customerName" name="customer_name" placeholder="Enter Customer Name" value="{{ old('customer_name') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" style="font-size:14px">
                                <label for="amount">Amount</label>
                                <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter Amount" value="{{ old('amount') }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group" style="font-size:14px">
                                <label for="reasons">Reasons</label>
                                <textarea class="form-control" id="reasons" name="reasons" rows="3" placeholder="Enter Reasons">{{ old('reasons') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@section('footer_scripts')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();

            // Fade out alert messages after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow', function() {
                    $(this).remove();
                });
            }, 5000); // 5000ms = 5 seconds
        });
    </script>
@endsection
