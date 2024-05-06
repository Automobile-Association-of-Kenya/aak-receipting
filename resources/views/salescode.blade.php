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
                <label for="clients">Add Sales Code</label>
                <form class="user" action="{{ route('salescodes.store') }}" method="POST" id="salescodeForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="exampleInputEmail"
                                    placeholder="Enter your Name" name="name"
                                    value="{{ old('name') }}">
                            </div>
                            @error('id_number')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="exampleInputSaleCode"
                                    placeholder="Enter Sales Code" name="sales_code" value="{{ old('sales_code') }}">
                            </div>
                            @error('sales_code')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-4 offset-md-4">
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script src="{{ asset('js/salescode.js') }}"></script>
@endsection
