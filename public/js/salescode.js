$(document).ready(function() {
    $('#salescodeForm').on('submit', function(event) {
        event.preventDefault();
        
        // Extracting form data
        var formData = {
            '_token': $(this).find("input[name='_token']").val(),
            'name': $(this).find("input[name='name']").val(),
            'sales_code': $(this).find("input[name='sales_code']").val()
        };

        $(document).ready(function() {
            // Fetch sales codes and names from the server
            $.get("/salescodes", function(data) {
                // Populate the table with sales code data
                $.each(data, function(index, item) {
                    $("#salesCodeTableBody").append(
                        "<tr><td>" + item.name + "</td><td>" + item.sales_code + "</td></tr>"
                    );
                });
            });
        });
        

        // Sending AJAX POST request
        $.post($(this).attr('action'), formData)
            .done(function(response) {
                console.log(response);
                // Handling success response
                // alert('Sales code added successfully!');
                // Displaying success message with success background and slider
                var successMessage = $('<div>').addClass('success-message').text('Sales code added successfully!');
                successMessage.css({
                    'background-color': '#d4edda', // Bootstrap success color
                    'color': '#155724', // Text color for success color
                    'padding': '10px',
                    'border': '1px solid #c3e6cb', // Border color for success color
                    'border-radius': '5px',
                    'position': 'fixed',
                    'bottom': '20px',
                    'right': '20px',
                    'z-index': '9999'
                });
                var slider = $('<div>').addClass('slider');
                slider.css({
                    'position': 'fixed',
                    'bottom': '10px',
                    'right': 'calc(20px + ' + successMessage.outerWidth() + 'px)', // Position the slider from the right edge of the success message
                    'width': '1px',
                    'height': '3px',
                    'background-color': '#155724', // Color for the slider
                    'z-index': '9998'
                });
                $('body').append(successMessage, slider);
                // Slide up the success message and slider after a delay
                successMessage.slideUp(3000, function() {
                    $(this).remove();
                    slider.slideUp(3000, function() {
                        $(this).remove();
                    });
                });
                window.location.href = '/salescode';
            })
            .fail(function(xhr, status, error) {
                // Handling error response
                console.error(xhr.responseText);
                alert('An error occurred while adding the sales code. Please try again later.');
            });
    });
});
