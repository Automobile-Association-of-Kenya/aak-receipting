@extends('layouts.app')

@section('title')
    <title>Members - AAK </title>
@endsection

@section('header_styles')
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.css') }}"></script>
@endsection

@section('content')
    <div class="container-fluid">

        {{-- <h1 class="h3 mb-2 text-gray-800">Clients</h1> --}}

        <div class="card shadow mb-3">

            <div class="card-header py-3 d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Clients</h6>
                <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#createClientModal"
                        id="createClientToggle"><i class="fas fa-user-plus"></i>&nbsp;Add New</a>
            </div>

            <div class="card-body">



                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                        <thead>
                            <th>Name</th>
                            <th>Id No</th>
                            <th>Phone Number</th>
                            <th>Email Address</th>
                        </thead>

                        <tbody>
                            @foreach ($members as $item)
                                <tr>
                                    <td>
                                        <i class="fas fa-user-circle fa-1x float-left mr-3"></i>
                                        <small>{{ $item->firstName . ' ' . $item->secondName . ' ' . $item->surNameName }}</small></td>
                                    <td> <small>{{ $item->idNo }}</small>
                                    <td> <small>{{ $item->mobilePhoneNumber }}</small>
                                    <td> <small>{{ $item->emailAddress }}</small>
                                
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

<div class="modal fade" id="createClientModal" tabindex="-1" role="dialog" aria-labelledby="createClientModal"
aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <div class="modal-title">
                <h5 class="text-black">Add Client</h5>
            </div>
            <button type="button" class="close btn btn-warning text-danger" data-dismiss="modal"
                aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{ route('members.store') }}" method="POST" id="createMemberFOrm">
            <div class="modal-body">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" style="font-size:14px">
                            <input type="number" class="form-control form-control-user" id="clientIDNumber"
                                placeholder="Enter ID Number" name="id_number" value="{{ old('id_number') }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group" style="font-size:14px" >
                            <input type="text" class="form-control form-control-user" id="clientFirstName"
                                placeholder="First Name" name="first_name" value="{{ old('first_name') }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="clientSecondName"
                                placeholder="Second Name" name="second_name" value="{{ old('second_name') }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="clientLastName"
                                placeholder="Last Name" name="last_name" value="{{ old('last_name') }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="email" class="form-control form-control-user" id="clientEmail"
                                placeholder="Email" name="email" value="{{ old('email') }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="number" class="form-control form-control-user" id="clientPhone"
                                placeholder="Phone Number" name="phone_number" value="{{ old('phone_number') }}">
                        </div>
                    </div>
                </div>
            </div>
            <div id="memberFeedback"></div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-md btn-success">Submit</button>
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
