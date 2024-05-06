@extends('layouts.app')

@section('title')
    <title>Transactions - AAK </title>
@endsection

@section('header_styles')
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.css') }}"></script>
    <style>
        #confirmPayment {
            display: none;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-white">
                @if (session('stkSuccess'))
                    <div class="alert alert-success">
                        {{ session('stkSuccess') }}
                    </div>
                @endif
                @if (session('stkError'))
                    <div class="alert alert-danger">
                        {{ session('stkError') }}
                    </div>
                @endif
                <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
                    <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100 active" data-toggle="tab" data-target="#invoicesTab" type="button"
                            role="tab" aria-controls="home" aria-selected="true">Invoices</button>
                    </li>

                    <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100" data-toggle="tab" data-target="#paymentsTab" type="button"
                            role="tab" aria-controls="profile" aria-selected="false">Payments</button>
                    </li>

                </ul>
                <h6 class="m-0 font-weight-bold text-primary"></h6>
            </div>

            <div class="card-body tab-content">
                <div class="tab-pane fade show active" id="invoicesTab" role="tabpanel" aria-labelledby="invoices-tab">
                    <div class="text-right mb-2">
                        <a href="#" class="btn btn-primary btn-sm" data-toggle="modal"
                            data-target="#createInvoiceModal" id="createInvoiceToggle"><i class="fa fa-plus"></i>&nbsp;Add
                            New</a>
                    </div>
                    <div class="table-responsive" id="invoicesTableSection">

                    </div>
                </div>

                <div class="tab-pane fade" id="paymentsTab" role="tabpanel" aria-labelledby="payments-tab">
                    <div class="text-right mb-2">
                        <a href="#" class="btn btn-primary btn-sm" data-toggle="modal"
                            data-target="#createPaymentModal" id="createPaymentToggle"><i class="fa fa-plus"></i>&nbsp;Add
                            New</a>
                    </div>
                    <div class="table-responsive" id="paymentTableSection">

                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="createInvoiceModal" tabindex="-1" role="dialog" aria-labelledby="createInvoiceModal"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h5 class="text-black">Add Invoice</h5>
                    </div>
                    <button type="button" class="close btn btn-warning text-danger" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('invoices.store') }}" method="POST" id="createInvoiceFOrm">
                    <div class="modal-body">
                        @csrf
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group" id="invoiceBranchDiv" style="font-size:14px">
                                    <label for="invoiceBranchID">Branch</label>
                                    <select name="branch_id" id="invoiceBranchID" class="form-control  form-control-sm"
                                        required style="width: 100%;"></select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group" id="membersInvoiceDiv" style="font-size:14px">
                                    <label for="memberID">Client</label>
                                    <select name="member_id" id="memberID" class="form-control  form-control-sm"
                                        data-control="select2" data-dropdown-parent="#membersInvoiceDiv" required
                                        style="width: 100%;"></select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group" style="font-size:14px">
                                    <label for="departmentInvoiceId">Departments</label>
                                    <select name="department_id" id="departmentInvoiceId"
                                        class="form-control  form-control-sm"></select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group" style="font-size:14px">
                                    <label for="departmentProductID">Product</label>
                                    <select name="product_id" id="departmentProductID"
                                        class="form-control  form-control-sm"></select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group" style="font-size: 14px">
                                    <label for="salescodeID">Sales Code</label>
                                    <select id="salescodeID" name="sales_code" required class="form-control form-control-sm">
                                        <option value="">Select Sales Code</option>
                                        @foreach ($sales as $sale)
                                            <option value="{{ $sale->sales_code }}">{{ $sale->name }} - {{ $sale->sales_code }}</option>
                                        @endforeach
                                    </select>
                                   
                                </div>
                            </div>
                            
                            
                            
                            
                            
                            


                            <div class="col-md-12">
                                <hr>
                                <table class="table table-bordered table-hover table-sm">
                                    <thead>
                                        <th>Product</th>
                                        <th>QTY</th>
                                        <th>Cost</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody id="invoiceProductsTbody">

                                    </tbody>
                                    <tfoot id="invoiceProductsTfoot">

                                    </tfoot>
                                </table>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group" style="font-size:14px">
                                    <label for="invoiceAmount">Amount</label>
                                    <input type="number" class="form-control form-control-sm" id="invoiceAmount"
                                        name="invoice_amount" value="{{ old('invoice_amount') }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group" style="font-size:14px">
                                    <label for="invoiceDate">Date</label>
                                    <input type="date" class="form-control form-control-sm" id="invoiceDate"
                                        name="invoice_date" value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div id="invoiceFeedback"></div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-md btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createPaymentModal" tabindex="-1" role="dialog" aria-labelledby="createPaymentModal"
        aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h5 class="text-black">Add Payment</h5>
                    </div>
                    <button type="button" class="close btn btn-warning text-danger" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
                    <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100 active" data-toggle="tab" data-target="#mpesaTab" type="button"
                            role="tab" aria-controls="home" aria-selected="true">Mpesa Express</button>
                    </li>

                    <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100" data-toggle="tab" data-target="#manualTab" type="button"
                            role="tab" aria-controls="profile" aria-selected="false">Other Payment Modes</button>
                    </li>

                </ul>

                <div class="modal-body tab-content">
                    @csrf
                    <div class="tab-pane fade show active" id="mpesaTab" role="tabpanel" aria-labelledby="mpesa-tab">
                        <form action="{{ route('payment.mpesa') }}" method="post" id="mpesaPaymentForm">
                            @csrf
                            <div class="col-md-12">
                                <div class="form-group" id="mpesaMembersDIv" style="font-size:14px">
                                    <label for="mpesaPaymentMemberID">Client</label>
                                    <select name="mpesa_payment_member_id" id="mpesaPaymentMemberID"
                                        class="form-control form-control-sm" data-control="select2"
                                        data-dropdown-parent="#mpesaMembersDIv" required style="width: 100%;"
                                        required></select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group" style="font-size:14px">
                                    <label for="mpesaPaymentInvoiceID">Invoice</label>
                                    <select name="mpesaPaymentInvoiceID" id="mpesaPaymentInvoiceID"
                                        class="form-control form-control-sm">
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group" id="membersDIv">
                                    <label for="paymentMemberID">Enter phone number to pay </label>
                                    <input type="number" class="form-control form-control-sm" id="mpesaPaymentPhone"
                                        name="payment_phone" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="paymentAmount">Amount</label>
                                    <input type="number" class="form-control form-control-sm" id="mpesaPaymentAmount"
                                        name="mpesa_payment_amount" value="{{ old('mpesa_payment_amount') }}" required
                                        readonly>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="mpesaPaymentDescription">Description</label>
                                    <textarea name="mpesaPaymentDescription" id="mpesaPaymentDescription" class="form-control form-control-sm"></textarea>
                                </div>
                            </div>

                            <div id="mpesaPaymentFeedback"></div>

                            <div class="mt-2" id="mpesaPaymentAction">
                                <button type="submit" class="btn btn-primary btn-sm" id="initiatePayment">Send
                                    STK</button>
                                <button type="submit" class="btn btn-warning btn-sm"
                                    id="confirmPayment">Confirm</button>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="manualTab" role="tabpanel" aria-labelledby="manual-tab">
                        <form action="{{ route('payments.store') }}" method="POST" id="createManualPaymentFOrm">
                            @csrf
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group" id="jjjjhjhjj" style="font-size:14px">
                                        <label for="paymentMemberID">Client</label>
                                        <select name="payment_member_id" id="paymentMemberID"
                                            class="form-control form-control-sm" data-control="select2"
                                            data-dropdown-parent="#jjjjhjhjj" required style="width: 100%;"></select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group" style="font-size:14px">
                                        <label for="paymentInvoiceID">Invoice</label>
                                        <select name="paymentInvoiceID" id="paymentInvoiceID"
                                            class="form-control form-control-sm">
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group" style="font-size:14px">
                                        <label for="paymentMethod">Method</label>
                                        <select name="payment_method" id="paymentMethod"
                                            class="form-control form-control-sm">
                                            <option value="MPESA">MPESA</option>
                                            <option value="Cash">BANK</option>
                                            <option value="Cash">CHEQUE</option>
                                            <option value="Cash">EFT</option>
                                            <option value="Cash">RTGS</option>
                                            <option value="Cash">CREDITCARD</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="paymentAmount">Amount</label>
                                        <input type="number" class="form-control form-control-sm" id="paymentAmount"
                                            name="payment_amount" value="{{ old('payment_amount') }}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="paymentReference">Transaction Reference</label>
                                        <input type="text" class="form-control form-control-sm" id="paymentReference"
                                            name="ref_no" value="{{ old('ref_no') }}">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="paymentDate">Date</label>
                                        <input type="date" class="form-control form-control-sm" id="paymentDate"
                                            name="payment_date" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="paymentDescription">Description</label>
                                        <textarea name="description" id="paymentDescription" class="form-control form-control-sm"></textarea>
                                    </div>
                                </div>

                            </div>

                            <div class="text-right">
                                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                            </div>

                        </form>

                    </div>
                    <div id="paymentFeedback"></div>

                </div>

            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script src="{{ asset('js/invoice.js') }}"></script>
    <script src="{{ asset('js/payment.js') }}"></script>
@endsection
