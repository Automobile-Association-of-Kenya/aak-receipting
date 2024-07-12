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
