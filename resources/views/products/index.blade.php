@extends('layouts.app')

@section('title')
    <title>Products - AAK </title>
@endsection

@section('header_styles')
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.css') }}"></script>
@endsection

@section('content')
    <div class="container-fluid">

        {{-- <h1 class="h3 mb-2 text-gray-800">Clients</h1> --}}

        <div class="card shadow mb-3">

            <div class="card-header py-3 d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Products</h6>
                <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#createProductModal"
                    id="createClientToggle"><i class="fas fa-plus"></i>&nbsp;Add New</a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <th>#</th>
                            <th>Department</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <td>Action</td>
                        </thead>

                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($products as $item)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td> <small>{{ $item->department->name }}</small>
                                    <td> <small>{{ $item->name }}</small>
                                    <td> <small>{{ $item->amount }}</small>
                                    <td> <a href="" class="fa fa-edit"  style="font-size:15px">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

    </div>
    <div class="modal fade" id="createProductModal" tabindex="-1" role="dialog" aria-labelledby="createProductModal"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">
                    <h5 class="text-black">Add Product</h5>
                </div>
                <button type="button" class="close btn btn-warning text-danger" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('products.store') }}" method="POST" id="createProductForm">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="department_id">Department</label>
                                <select name="department_id" id="departmentID" class="form-control">
                                    <option value="" disabled selected>Select department</option>
                                        @foreach ($departments as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="productName">Product Name</label>
                                <input type="text" class="form-control" id="productName" name="name"
                                    value="{{ old('name') }}">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="productAmount">Product Cost</label>
                                <input type="number" class="form-control" id="productAmount" name="amount"
                                    value="{{ old('amount') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="productFeedback"></div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-md btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@section('footer_scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/products.js') }}"></script>
    <script>
        (function() {
            $('#dataTable').DataTable();
        })()
    </script>
@endsection
