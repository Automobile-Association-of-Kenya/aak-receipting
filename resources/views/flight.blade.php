@extends('layouts.app')

@section('title')
    <title>Flights - AAK </title>
@endsection

@section('header_styles')
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.css') }}"></script>
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Flights</h6>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                       
                            <thead> 
                              <th>Id</th>
                              <!-- <th>Flight Id</th> -->
                              <!-- <th>Member Id</th> -->
                              <th>Membership Number</th>
                              <th>Member Name</th>
                              <th>Flight Code</th>
                              <th>Departure Airport</th>
                              <th>Destination Airport </th>
                              <th>Date Created </th>
                              <!-- <th>Updated_at </th> -->
                            </thead> 
                        <tbody>
                            @foreach($flights as $item)
                              <tr> 
                              <td>{{$item['id']}}</td>
                              <!-- <td>{{$item['flightId']}}</td> -->
                              <!-- <td>{{$item['memberId']}}</td> -->
                              <td>{{$item['MembershipNumber']}}</td>
                              <td>{{$item['MemberName']}}</td>
                              <td>{{$item['flightCode']}}</td>
                              <td>{{$item['departureAirport']}}</td>
                              <td>{{$item['destinationAirport']}}</td>
                              <td>{{$item['created_at']}}</td>
                              <!-- <td>{{$item['updated_at']}}</td> -->
                              </tr>
                              @endforeach
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer_scripts')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        (function() {
            $('#dataTable').DataTable();
        })()
    </script>
@endsection
