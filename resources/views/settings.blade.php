@extends('layouts.app')

@section('title')
    <title>Settings - AAK </title>
@endsection

@section('header_styles')
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.css') }}"></script>
@endsection
<style>
 .table-responsive thead{
    font-size: 12px;
}
.table-responsive tbody{
    font-size: 12px;
}
</style>

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4 p-4">
            <h4 class="text-center text-success">Coming Soon</>
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/payment.js') }}"></script>
@endsection
