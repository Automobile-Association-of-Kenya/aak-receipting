@extends('layouts.app')

@section('title')
    <title>Add Corporate Client</title>
@endsection
@section('header_styles')
@endsection
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-1 text-gray-800">Add Corprate Client</h1>
        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12">
                @if (session('exception'))
                    <div class="alert alert-danger">
                        {{session('exception')}}
                    </div>
                @endif
                <form class="user" action="{{route('corporates.store')}}" method="POST" id="corporateCreateForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="number" class="form-control form-control-user" id="corporateIdNO"
                                     placeholder="Enter Customer Number" name="id_number"
                                    value="{{ old('id_number') }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="corporateFirstName"
                                    placeholder="First Name" name="first_name" value="{{ old('first_name') }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="corporateSecondName">Second Name</label>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="corporateSecondName"
                                    placeholder="N/A"  label="Second Name" name="second_name" value="{{ old('second_name') }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="corporateLastName">Last Name</label>
                                <input type="text" class="form-control form-control-user" id="corporateLastName"
                                    placeholder="N/A" name="last_name" value="{{ old('last_name') }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="corporateEmail">Email</label>
                                <input type="email" class="form-control form-control-user" id="corporateEmail"
                                    placeholder="Email" name="email" value="{{ old('email') }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="corporatePhoneNumber">Phone Number</label>
                                <input type="number" class="form-control form-control-user border-box" id="corporatePhoneNumber"
                                    aria-describedby="emailHelp" placeholder="N/A" name="phone_number"
                                    value="">
                            </div>
                        </div>

                    </div>
<div id="corporateFeedback"></div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        Submit
                    </button>
                    <hr>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/members.js') }}"></script>
<script>

    (function() {
        $('#dataTable').DataTable();
    })()


</script>
@endsection
