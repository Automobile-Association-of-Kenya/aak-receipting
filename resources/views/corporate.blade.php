@extends('layouts.app')

@section('title')
    <title>Add Corporate Client</title>
@endsection
@section('header_styles')
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.css') }}"></script>
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
                <form class="user" action="{{route('corporates.store')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="number" class="form-control form-control-user" id="exampleInputEmail"
                                    aria-describedby="emailHelp" placeholder="Enter Customer Number" name="id_number"
                                    value="{{ old('id_number') }}">
                            </div>
                            @error('id_number')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="exampleInputPassword"
                                    placeholder="First Name" name="first_name" value="{{ old('first_name') }}">
                            </div>
                            @error('first_name')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="secondName">Second Name</label>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="exampleInputPassword"
                                    placeholder="N/A"  label="Second Name" name="second_name" value="{{ old('second_name') }}">
                            </div>
                            @error('second_name')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="secondName">Last Name</label>
                                <input type="text" class="form-control form-control-user" id="exampleInputPassword"
                                    placeholder="N/A" name="last_name" value="{{ old('last_name') }}">
                            </div>
                            @error('last_name')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="secondName">Email</label>
                                <input type="email" class="form-control form-control-user" id="exampleInputPassword"
                                    placeholder="Email" name="email" value="{{ old('email') }}">
                            </div>
                            @error('email')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="secondName">Phone Number</label>
                                <input type="number" class="form-control form-control-user border-box" id="exampleInputEmail"
                                    aria-describedby="emailHelp" placeholder="N/A" name="phone_number"
                                    value="{{ old('phone_number') }}">
                            </div>
                            @error('phone_number')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                <select name="status" id="" class="form-control select"
                                    style="border-radius: 10rem" name="status">
                                    <option value="" selected>Select Status</option>
                                    <option value="ACTIVE">ACTIVE</option>
                                    <option value="EXPIRED">EXPIRED</option>
                                    <option value="PENDING">PENDING</option>
                                </select>
                            </div>
                            @error('status')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div> --}}
                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                <input type="number" class="form-control form-control-user" id="exampleInputPassword"
                                    placeholder="Member Number" name="member_number" value="{{ old('member_number') }}">
                            </div>
                            @error('member_number')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div> --}}
                        <!-- <div class="col-md-6">
                            <div class="form-group">
                                <input type="date" class="form-control form-control-user" id="exampleInputPassword"
                                    placeholder="Member Expiry Date" name="member_expiry_date"
                                    value="{{ old('member_expiry_date') }}">
                            </div>
                            @error('member_number')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div> -->
                    </div>

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
