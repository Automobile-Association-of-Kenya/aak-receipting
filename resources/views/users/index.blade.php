@extends('layouts.app')

@section('title')
    <title>Users - AAK </title>
@endsection

@section('header_styles')
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.css') }}"></script>
@endsection

@section('content')
    <div class="container-fluid">

        {{-- <h1 class="h3 mb-2 text-gray-800">Clients</h1> --}}

        <div class="card shadow mb-3">

            <div class="card-header py-3 d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Users</h6>
                <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#createProductModal"
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
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <th>#</th>
                            <th>Department</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Action</th>
                        </thead>

                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($users as $item)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td> <small>{{ $item->name }}</small>
                                    <td> <small>{{ $item->email }}</small>
                                    <td> <small>{{ $item->role_id == 1 ? 'Admin' : 'User' }}</small>
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
                        <h5 class="text-black">Add User</h5>
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
                <form action="{{ route('users.store') }}" method="POST" id="createProductForm">
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="productName">Name</label>
                                    <input type="text" class="form-control" id="productName" name="name"
                                        value="{{ old('name') }}">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="productAmount">Email</label>
                                    <input type="email" class="form-control" id="productAmount" name="email"
                                        value="{{ old('email') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="productAmount">Role</label>
                                    <select class="form-control" name="role">
                                        <option value="0">User</option>
                                        <option value="1">Admin</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="productAmount">Password</label>
                                    <input type="password" class="form-control" id="productAmount" name="password"
                                        value="">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="productAmount">Confirm Password</label>
                                    <input type="password" class="form-control" id="productAmount"
                                        name="password_confirmation" value="">
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
