@extends('layouts.app')

@section('title')
    <title>Services</title>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                @if (session('exception'))
                    <div class="alert alert-danger">
                        {{ session('exception') }}
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-9">
                        <form class="user" action="{{ route('members.store') }}" method="POST">

                            <div class="row align-items-center">
                                <div class="col-md-3 d-flex align-items-center">
                                    <svg class="w-2 h-2 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 3v4c0 .6-.4 1-1 1H5m8-2h3m-3 3h3m-4 3v6m4-3H8M19 4v16c0 .6-.4 1-1 1H6a1 1 0 0 1-1-1V8c0-.4.1-.6.3-.8l4-4 .6-.2H18c.6 0 1 .4 1 1ZM8 12v6h8v-6H8Z"/>
                                    </svg>
                                </div>
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="departmentID" class="font-size-16">Departments</label>
                                                <select id="departmentID" class="form-control rounded-full text-base"
                                                    name="department_id">
                                                    <option value="" selected>Select Department</option>
                                                    @foreach ($data as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>

                                                @error('department_id')
                                                    <div class="alert alert-danger mt-2 font-size-14">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6" id="amountChargedCol" style="display: none;">
                                            <div class="form-group">
                                                <label for="amountCharged" class="font-size-16">Amount Charged</label>
                                                <input type="number" class="form-control rounded-full text-base" id="amountCharged"
                                                    aria-describedby="amountChargedHelp" placeholder="Amount Charged"
                                                    name="amount_charged" value="{{ old('amount_charged') }}">
                                                @error('amount_charged')
                                                    <div class="alert alert-danger font-size-14">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="serviceID" class="font-size-16">Products</label>
                                                <select id="serviceID" class="form-control rounded-full text-base"
                                                    name="service_id">
                                                    <option value="" selected>Select Products</option>
                                                </select>
                                                @error('service_id')
                                                    <div class="alert alert-danger mt-2 font-size-14">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6" id="amountCol" style="display: none;">
                                            <div class="form-group">
                                                <label for="make_payment" class="font-size-16">Amount</label>
                                                <input type="number" class="form-control rounded-full text-base" id="make_payment"
                                                    aria-describedby="makePaymentHelp" placeholder="Enter Amount To Pay"
                                                    name="make_payment" value="{{ old('make_payment') }}">
                                                @error('make_payment')
                                                    <div class="alert alert-danger font-size-14">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center" id="buttonsRow" style="display: none;">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-primary text-base" id="mpesaButton">
                                                    Mpesa
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-primary text-base" id="manualReceiptingButton">
                                                    Manual Receipting
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mpesa Modal HTML -->
    <div id="mpesaModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Mpesa Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="mpesaForm">
                        <div class="form-group">
                            <label for="phoneNumber">Phone Number to Pay</label>
                            <input type="text" class="form-control" id="mpesaPhoneNumber" name="phoneNumber" required>
                        </div>
                        <div class="form-group">
                            <label for="mpesaAmount">Amount</label>
                            <input type="number" class="form-control" id="mpesaAmount" name="amount" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="mpesaPayButton">Pay</button>
                </div>
            </div>
        </div>
    </div>

   <!-- Manual Receipting Modal HTML -->
<div id="manualReceiptingModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Manual Receipting Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="manualReceiptingForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="idNumber">ID Number</label>
                                <input type="text" class="form-control" id="idNumber" name="idNumber" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phoneNumber">Phone Number</label>
                                <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="amountToPay">Amount to Pay</label>
                                <input type="number" class="form-control" id="amountToPay" name="amountToPay" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modeOfPayment">Mode of Payment</label>
                                <select class="form-control" id="modeOfPayment" name="modeOfPayment" required>
                                    <option value="">Select Mode of Payment</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Card">Card</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <!-- Add more options as needed -->
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="referenceCode">Reference Code</label>
                        <input type="text" class="form-control" id="referenceCode" name="referenceCode" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="manualReceiptingPayButton">Pay</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer_scripts')
    <script src="{{ asset('js/service.js') }}"></script>
    <script>
        document.getElementById('serviceID').addEventListener('change', function() {
            var selectedService = this.value;
            var amountChargedCol = document.getElementById('amountChargedCol');
            var amountCol = document.getElementById('amountCol');
            var buttonsRow = document.getElementById('buttonsRow');

            if (selectedService) {
                amountChargedCol.style.display = 'block';
                amountCol.style.display = 'block';
                buttonsRow.style.display = 'flex';
            } else {
                amountChargedCol.style.display = 'none';
                amountCol.style.display = 'none';
                buttonsRow.style.display = 'none';
            }
        });

        document.getElementById('departmentID').addEventListener('change', function() {
            var selectedDepartment = this.value;
            var serviceID = document.getElementById('serviceID');
            var amountChargedCol = document.getElementById('amountChargedCol');
            var amountCol = document.getElementById('amountCol');
            var buttonsRow = document.getElementById('buttonsRow');

            if (!selectedDepartment) {
                serviceID.value = '';
                amountChargedCol.style.display = 'none';
                amountCol.style.display = 'none';
                buttonsRow.style.display = 'none';
            }
        });

        document.getElementById('mpesaButton').addEventListener('click', function() {
            $('#mpesaModal').modal('show');
        });

        document.getElementById('manualReceiptingButton').addEventListener('click', function() {
            $('#manualReceiptingModal').modal('show');
        });

        document.getElementById('mpesaPayButton').addEventListener('click', function() {
            var phoneNumber = document.getElementById('mpesaPhoneNumber').value;
            var amount = document.getElementById('mpesaAmount').value;
            console.log("Phone Number: " + phoneNumber);
            console.log("Amount: " + amount);
            $('#mpesaModal').modal('hide');
        });

        document.addEventListener('DOMContentLoaded', function() {
            var products = [
                { id: 1, name: "Product 1", amount: 10 },
                { id: 2, name: "Product 2", amount: 20 },
            ];

            var selectElement = document.getElementById('serviceID');

            products.forEach(function(product) {
                var option = document.createElement('option');
                option.value = product.id;
                option.textContent = product.name;
                selectElement.appendChild(option);
            });

            selectElement.addEventListener('change', function() {
                var selectedProductId = this.value;
                var selectedProduct = products.find(function(product) {
                    return product.id == selectedProductId;
                });
                if (selectedProduct) {
                    document.getElementById('amountChargedField').value = selectedProduct.amount;
                } else {
                    document.getElementById('amountChargedField').value = '';
                }
            });
        });

      function updateAmount(){

        var productSelected = document.getElementById('serviceID');
        var selectedProduct =productSelected.options[productSelected.selectedIndex].value;
        var amountCol = document.getElementById('amountCol');

        $.ajax({
            url:'/members' +selectedProduct,
            type:'GET',
            success:function(response){
                amountCol.value = response.amount;

            }
        })

      }

        document.getElementById('manualReceiptingPayButton').addEventListener('click', function() {
            var name = document.getElementById('name').value;
            var idNumber = document.getElementById('idNumber').value;
            var amountToPay = document.getElementById('amountToPay').value;
            var modeOfPayment = document.getElementById('modeOfPayment').value;
            var referenceCode = document.getElementById('referenceCode').value;

            console.log("Name: " + name);
            console.log("ID Number: " + idNumber);
            console.log("Amount to Pay: " + amountToPay);
            console.log("Mode of Payment: " + modeOfPayment);
            console.log("Reference Code: " + referenceCode);

            $('#manualReceiptingModal').modal('hide');
        });


    </script>
@endsection
