<!DOCTYPE html>
<html>
<head>
    <title>Credit Note</title>
    <!-- Include Bootstrap CSS for styling the modal -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="container mt-5">
    <h2>Credit Note</h2>
    <!-- Button to Open the Modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
        Credit Note
    </button>

    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Enter Details</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="modalForm" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="creditNumber">Credit Number:</label>
                            <input type="text" class="form-control" id="creditNumber" name="creditNumber" required>
                        </div>
                        <div class="form-group">
                            <label for="customerNumber">Customer Number:</label>
                            <input type="text" class="form-control" id="customerNumber" name="customerNumber" required>
                        </div>
                        <div class="form-group">
                            <label for="customerName">Customer Name:</label>
                            <input type="text" class="form-control" id="customerName" name="customerName" required>
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount:</label>
                            <input type="number" class="form-control" id="amount" name="amount" required>
                        </div>
                        <div class="form-group">
                            <label for="reason">Reason:</label>
                            <textarea class="form-control" id="reason" name="reason" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include jQuery and Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
$(document).ready(function(){
    $("#modalForm").on('submit', function(event){
        event.preventDefault();

        var formData = {
            creditNumber: $("#creditNumber").val(),
            customerNumber: $("#customerNumber").val(),
            customerName: $("#customerName").val(),
            amount: $("#amount").val(),
            reason: $("#reason").val(),
        };

        $.ajax({
            url: "{{ route('creditnote') }}",
            method: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response){
                alert("Form submitted successfully!");
                $('#myModal').modal('hide');
            },
            error: function(xhr){
                alert("An error occurred: " + xhr.status + " " + xhr.statusText);
            }
        });
    });
});
</script>
</body>
</html>
