@extends('layouts.app')

@section('title')
    <title>Add Client</title>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-1 text-gray-800"></h1>

        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12">
            <i class="fas fa-user-plus"></i>
              <label for="clients">Add Client</label>
                @if (session('exception'))
                    <div class="alert alert-danger">
                        {{session('exception')}}
                    </div>
                @endif
                <form class="user" action="{{route('members.store')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="number" class="form-control form-control-user" id="exampleInputEmail"
                                    aria-describedby="emailHelp" placeholder="Enter ID Number" name="id_number"
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
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="exampleInputPassword"
                                    placeholder="Second Name" name="second_name" value="{{ old('second_name') }}">
                            </div>
                            @error('second_name')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="exampleInputPassword"
                                    placeholder="Last Name" name="last_name" value="{{ old('last_name') }}">
                            </div>
                            @error('last_name')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
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
                                <input type="number" class="form-control form-control-user" id="exampleInputEmail"
                                    aria-describedby="emailHelp" placeholder="Phone Number" name="phone_number"
                                    value="{{ old('phone_number') }}">
                            </div>
                            @error('phone_number')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                     <div class="col-md-4 offset-md-4"  style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"
                     >
                       <button type="submit" class="btn btn-primary btn-user btn-block"
                      >
                        Submit
                       </button>
                    </div>
                <hr>
                </form>
            </div>
        </div>
    </div>
@endsection


