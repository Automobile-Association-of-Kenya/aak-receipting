@extends('layouts.app')

@section('title')
    <title>Clients - AAK </title>
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
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Payments</h6>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="table-responsive" id="paymentTableSection">
                    {{-- <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <th>#</th>
                            <th>ID Number </th>
                            <th>Amount</th>
                            <th>Description</th>
                            <th>Date paid </th>
                         
                        </thead>

                        <tbody>

                            @foreach ($collection as $item)
                                <tr>
                                    <td>{{ $item['id'] }}</td>
                                    <td>{{ $item['phone'] }}</td>
                                    <td>{{ $item['amount'] }}</td>
                                    <td>{{ $item['source'] }}</td>
                                    <td>{{ $item['owner'] }}</td>
                                    <td>{{ $item['description'] }}</td>
                                    <td>{{ $item['date_created'] }}</td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table> --}}
                </div>
            </div>
        </div>

    </div>
@endsection

@section('footer_scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/payment.js') }}"></script>
@endsection
