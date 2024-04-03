@extends('layouts.app')

@section('title')
    <title>Branches - AAK </title>
@endsection

@section('header_styles')
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.css') }}"></script>
@endsection

@section('content')
    <div class="container-fluid">

        {{-- <h1 class="h3 mb-2 text-gray-800">Clients</h1> --}}

        <div class="card shadow mb-3">

            <div class="card-header py-3 d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Branches</h6>
<<<<<<< HEAD
                <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#createBranchModal"
=======
                <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#createProductModal"
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6
                    id="createClientToggle"><i class="fas fa-plus"></i>&nbsp;Add New</a>
            </div>

            <div class="card-body">
                @if (session('exception'))
                    <div class="alert alert-danger">
                        {{ session('exception') }}
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
<<<<<<< HEAD
                <div class="table-responsive" id="branchesTableSection">

                    {{-- <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
=======
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6
                        <thead>
                            <th>#</th>
                            <th>Name</th>
                            <th>Branch Code</th>
                            <th>Added By</th>
                            <th>Action</th>
                        </thead>

                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($branches as $item)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td> <small>{{ $item->name }}</small>
                                    <td> <small>{{ $item->branch_code }}</small>
                                    <td> <small>{{$item->user?$item->user->name:'-'}}</small>
                                    <td> <a href="" class="fa fa-edit"  style="font-size:15px">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

<<<<<<< HEAD
                    </table> --}}

=======
                    </table>
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6
                </div>
            </div>
        </div>

    </div>
<<<<<<< HEAD

    <div class="modal fade" id="createBranchModal" tabindex="-1" role="dialog" aria-labelledby="createProductModal"
=======
    <div class="modal fade" id="createProductModal" tabindex="-1" role="dialog" aria-labelledby="createProductModal"
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h5 class="text-black">Add Branch</h5>
                    </div>
                    <button type="button" class="close btn btn-warning text-danger" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @if ($errors->any())
                    @foreach ($errors->all() as $item)
                        <div class="alert alert-danger m-2">
                            {{ $item }}
                        </div>
                    @endforeach
                @endif
<<<<<<< HEAD
                <form action="{{ route('branches.store') }}" method="POST" id="createBranchForm">
=======
                <form action="{{ route('branches.store') }}" method="POST" id="createProductForm">
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
<<<<<<< HEAD
                                    <label for="branchName">Name</label>
                                    <input type="text" class="form-control" id="branchName" name="name"
=======
                                    <label for="productName">Name</label>
                                    <input type="text" class="form-control" id="productName" name="name"
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6
                                        value="{{ old('name') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
<<<<<<< HEAD
                                    <label for="branchCode">Branch Code</label>
                                    <input type="text" class="form-control" id="branchCode" name="branch_code"
=======
                                    <label for="productCode">Branch Code</label>
                                    <input type="text" class="form-control" id="productCode" name="name"
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6
                                        value="{{ old('name') }}">
                                </div>
                            </div>
                        </div>

                    </div>
<<<<<<< HEAD
                    <div id="branchFeedback"></div>
=======
                    <div id="productFeedback"></div>
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6
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
<<<<<<< HEAD
    <script src="{{ asset('js/branch.js') }}"></script>
=======
    <script src="{{ asset('') }}"></script>
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6
    <script>
        (function() {
            $('#dataTable').DataTable();
        })()
    </script>
@endsection
