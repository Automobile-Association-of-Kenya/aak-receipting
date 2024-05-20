@extends('layouts.app')
@section('title')
<title>SalesCodes</title>
@endsection
<style>
   .table-responsive thead{
   font-size: 12px;
   }
   .table-responsive tbody{
   font-size: 10px;
   }
   .table-bordered tr {
   height: 5px; /* Adjust the height to your preference */
   }
</style>
@section('content')
<div class="container-fluid">
   <!-- Page Heading -->
   <h1 class="h3 mb-1 text-gray-800"></h1>
   <!-- Content Row -->
   <div class="row">
      <div class="col-md-12">
         <div class="text-right">
            <button class="btn btn-sm btn-success mb-2" data-toggle="modal" data-target="#createSalesCodeModal">Add
            new</button>
         </div>
         <table class="table table-bordered">
            <thead>
               <th>#</th>
               <th>Name</th>
               <th>Salescode</th>
               <th>Created</th>
            </thead>
            <tbody>
               @foreach ($salescodes as $item)
               <tr style="height:15px">
                  <td><small>{{ $loop->iteration }}</small></td>
                  <td><small>{{ $item->name }}</small></td>
                  <td><small>{{ $item->sales_code }}</small></td>
                  <td><small>{{ date('j M Y', strtotime($item->created_at)) }}</small></td>
               </tr>
               @endforeach
            </tbody>
         </table>
         {{-- {{ $salescodes->links() }} --}}
         
      </div>
</div>

   
</div>
<div class="modal fade" id="createSalesCodeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
   aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Create Sales Code</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form class="user" action="{{ route('salescodes.store') }}" method="POST" id="salescodeForm">
               @csrf
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="exampleInputEmail"
                           placeholder="Enter your Name" name="name" value="{{ old('name') }}">
                     </div>
                     @error('id_number')
                     <div class="alert alert-danger">
                        {{ $message }}
                     </div>
                     @enderror
                  </div>
                  <div class="col-md-12">
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
                     <div class="container-fluid">
                        <div class="row justify-content-center">
                           <div class="col-md-8 text-center">
                              <button type="submit" class="btn btn-primary btn-user btn-block">
                              Submit
                              </button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </form>
            <div id="salescodefeedback"></div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('footer_scripts')
<script src="{{ asset('js/salescode.js') }}"></script>
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
   (function() {
       $('#dataTable').DataTable();
   })()
</script>
@endsection