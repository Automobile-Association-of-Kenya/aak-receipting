@extends('layouts.app')

@section('title')
    <title>Reports - AAK </title>
@endsection

@section('header_styles')
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.css') }}"></script>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4 p-4">
            <h6 class="m-0 font-weight-bold text-primary">Reports</h6>
            <form action="{{ route('reports.generete') }}" method="post" id="generateReportsForm">
            @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" id="invoiceBranchDiv" style="font-size:14px">
                                <label for="reportBranchID">Branch</label>
                                <select name="branch_id" id="reportBranchID" class="form-control  form-control-sm" required
                                    style="width: 100%;"></select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" style="font-size:14px">
                                <label for="reportDepartmentId">Department</label>
                                <select name="department_id" id="reportDepartmentId"
                                    class="form-control  form-control-sm"></select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group" style="font-size:14px">
                                <label for="reportDepartmentProductID">Product</label>
                                <select name="product_id" id="reportDepartmentProductID"
                                    class="form-control  form-control-sm">
                                    <option value="NULL"></option>
                                    </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" style="font-size:14px">
                                <label for="reportStartDate">Start Date</label>
                                <input type="date" class="form-control form-control-sm" id="reportStartDate"
                                    name="start_date" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" style="font-size:14px">
                                <label for="reportEndDate">End Date</label>
                                <input type="date" class="form-control form-control-sm" id="reportEndDate"
                                    name="end_date" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-success btn-sm">Generate</button>
                </div>
            </form>

        </div>
    </div>
@endsection

@section('footer_scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/reports.js') }}"></script>
@endsection
