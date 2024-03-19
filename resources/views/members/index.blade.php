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



                <div class="table-responsive" style="font-size:16px">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                        <thead>
                            <th>Name</th>
                            <th>Id No</th>
                            <th>Phone Number</th>
                            <th>Email Address</th>
                            <th>Date Created</th>
                        </thead>
                        <form id="dateFilterForm" method="POST" action="{{ route('members.filterByDate') }}">
                            @csrf
                            <div class="form-row align-items-center">
                                <div class="col-auto">
                                    <label class="sr-only" for="startDate">Start Date</label>
                                    <input type="date" class="form-control mb-2" id="startDate" name="startDate">
                                </div>
                                <div class="col-auto">
                                    <label class="sr-only" for="endDate">End Date</label>
                                    <input type="date" class="form-control mb-2" id="endDate" name="endDate">
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-success mb-2">Filter</button>
                                    <button type="button" class="btn btn-success mb-2" id="clearFilter">Clear</button>
                                </div>
                                <!-- Move the search button here -->
                                <div class="col-auto">
                                    <label class="sr-only" for="searchIdNo">Search by ID Number</label>
                                    <input type="text" class="form-control mb-2" id="searchIdNo" placeholder="Search by ID Number">
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-success mb-2" id="searchButton">Search</button>
                                </div>
                            </div>
                        </form>
                        
                        <tbody>
                            @foreach ($members as $item)
                                <tr>
                                    <td>
                                        <i class="fas fa-user-circle fa-1x float-left mr-3" ></i>
                                        <small>{{ $item->firstName . ' ' . $item->secondName . ' ' . $item->surNameName }}</small></td>
                                    <td> <small>{{ $item->idNo }}</small>
                                    <td> <small>{{ $item->mobilePhoneNumber }}</small>
                                    <td> <small>{{ $item->emailAddress }}</small>
                                    <td> <small>{{ $item->created_at }}</small>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="errorContainer" class="alert alert-danger" style="display: none;"></div>
        <div id="successContainer" class="alert alert-success" style="display: none;"></div>

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
                                placeholder="Enter ID Number" name="id_number" value="{{ old('id_number') }}" required>
                            @error('id_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group" style="font-size:14px" >
                            <input type="text" class="form-control form-control-user" id="clientFirstName"
                                placeholder="First Name" name="first_name" value="{{ old('first_name') }}" required>
                                @error('first_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="clientSecondName"
                                placeholder="Second Name" name="second_name" value="{{ old('second_name') }}" required>
                                @error('second_name')
                                <span class="text-danger">{{ $message }}</span>
                                    
                                @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="clientLastName"
                                placeholder="Last Name" name="last_name" value="{{ old('last_name') }}" required>
                                @error('last_name')
                                <span class="text-danger">{{ $message }}</span>
                                    
                                @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="email" class="form-control form-control-user" id="clientEmail"
                                placeholder="Email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="number" class="form-control form-control-user" id="clientPhone"
                                placeholder="Phone Number" name="phone_number" value="{{ old('phone_number') }}"required>
                                @error('phone_number')
                                <span class="text-danger">{{ $message }}</span>
                                    
                                @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div id="memberFeedback"></div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-md btn-success">Submit</button>
                 <button type="button" class="btn btn-" data-dismiss="modal">Close</button>
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
$('#searchButton').click(function() {
    var searchIdNo = $('#searchIdNo').val().trim();
    if (searchIdNo === '') {
        showError('Please enter an ID Number to search.');
        return;
    }

    $.ajax({
        type: 'GET',
        url: '/members/searchByIdNo/' + searchIdNo,
        success: function(response) {
            if (response.error) {
                showNoDataMessage(response.error);
                hideSuccess();
            } else {
                hideError();
                if (response.members.length > 0) {
                    updateTableWithData(response);
                    showSuccess('Search results for ID Number: ' + searchIdNo);
                } else {
                    showNoDataMessage('No member found with ID Number: ' + searchIdNo);
                }
            }
        },
        error: function(xhr, status, error) {
            var errorMessage = 'There was an error processing your request. Please try again later.';
            showError(errorMessage);
            console.error(error);

            var errorBackgroundColor = $('.feedback-message.error').css('background-color');
            setTimeout(function() {
                $('#searchIdNo').val(''); 
                var feedbackMessage = $('<div>').addClass('feedback-message').text('Search field cleared').css({
                    'background-color': errorBackgroundColor, 
                    'color': 'white', 
                    'padding': '10px',
                    'border-radius': '5px',
                    'position': 'absolute',
                    'top': $('#searchIdNo').position().top + $('#searchIdNo').outerHeight() + 5,
                    'left': $('#searchIdNo').position().left,
                    'opacity': '1',
                    'transition': 'opacity 2s ease-in-out'
                });
                $('#searchIdNo').parent().append(feedbackMessage);
                setTimeout(function() {
                    feedbackMessage.css('opacity', '0');
                }, 4000);
            }, 5000);
        }
    });
});

 
 $(document).ready(function() {
    function showError(message) {
        $('#errorContainer').html(message).show();
    }
    
    function hideError() {
        $('#errorContainer').hide();
    }

    function showSuccess(message) {
        $('#successContainer').html(message).show();
        setTimeout(function() {
            $('#successContainer').hide();
        }, 3000);
    }


    function hideSuccess() {
        $('#successContainer').hide();
    }

    function updateTableWithData(data) {
        $('#dataTable tbody').empty();
        data.members.forEach(function(member) {
            var row = '<tr>' +
                '<td><i class="fas fa-user-circle fa-1x float-left mr-3"></i><small>' + member.firstName + ' ' + member.secondName + ' ' + member.surNameName + '</small></td>' +
                '<td><small>' + member.idNo + '</small></td>' +
                '<td><small>' + member.mobilePhoneNumber + '</small></td>' +
                '<td><small>' + member.emailAddress + '</small></td>' +
                '<td><small>' + member.created_at + '</small></td>' +
                '</tr>';
            $('#dataTable tbody').append(row);
        });
    }

    function showNoDataMessage(message) {
        $('#dataTable tbody').empty();
        showError(message);
    }

    $('#clearFilter').click(function() {
        $('#startDate').val('');
        $('#endDate').val('');
        hideError();
        hideSuccess();
    });

    $('#dateFilterForm').submit(function(e) {
        e.preventDefault();
        var startDate = $('#startDate').val();
        if (startDate === '') {
            showNoDataMessage('Kindly choose the start date.');
            return;
        }

        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            success: function(response) {
                if (response.error) {
                    showError(response.error);
                    hideSuccess();
                } else {
                    hideError();
                    showSuccess('The list was filtered successfully.');
                    if (response.members.length > 0) {
                        updateTableWithData(response);
                    } else {
                        showNoDataMessage('No data found matching your specifications.');
                    }
                }
            },
            error: function(xhr, status, error) {
                if (xhr.status === 404) {
                    showNoDataMessage('No data found matching your specifications.');
                } else {
                    showError('There was an error processing your request. Please try again later.');
                }
                console.error(error);
            }
        });
    });
});
$('#createMemberForm').submit(function(e) {
    e.preventDefault();
    var formData = $(this).serialize();

    $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: formData,
        success: function(response) {
            if (response.status === 'success') {
                showSuccess(response.message);
                $('#createMemberForm')[0].reset();
            } else {
                showError(response.message);
                $('#createClientModal').modal('show');
            }
        },
        error: function(xhr, status, error) {
            showError('There was an error processing your request. Please try again later.');
            console.error(error);
            $('#createClientModal').modal('show');
        }
    });
});

    </script>
@endsection

