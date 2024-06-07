@extends('layouts.app')

@section('title')
    <title>Users - AAK </title>
@endsection

@section('header_styles')
@endsection

@section('content')
    <div class="container-fluid">

        {{-- <h1 class="h3 mb-2 text-gray-800">Clients</h1> --}}

        <div class="card shadow mb-3">

            <div class="card-header py-3 d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Users</h6>
                <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#createUserModal"
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
                <div class="table-responsive" style="font-size:14px" id="userTableSection">
                    {{-- <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
                                    <td> <a href="" class="fa fa-edit"  style="font-size:15px">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table> --}}
                </div>
            </div>
        </div>

    </div>



    <div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModal"
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
                <form action="{{ route('users.store') }}" method="POST" id="createUserForm">
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="userName">Name</label>
                                    <input type="text" class="form-control" id="userName" name="name"
                                        value="{{ old('name') }}">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="userEmail">Email</label>
                                    <input type="email" class="form-control" id="userEmail" name="email" id="userEmail" value="{{ old('email') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="userRole">Role</label>
                                    <select class="form-control" name="role" id="userRole">
                                        <option value="CEA">CEA</option>
                                        <option value="Admin">Admin</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="userPassword">Password</label>
                                    <input type="password" class="form-control" id="userPassword" name="password"
                                        value="">
                                </div>
                            </div>

                        </div>
                    </div>

                    <div id="userFeedback"></div>
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
    <script src="{{ asset('js/users.js') }}"></script>
    <script>
        (function() {
            $('#dataTable').DataTable();
        })()
    </script>
@endsection
