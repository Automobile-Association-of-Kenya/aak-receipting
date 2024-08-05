$(document).ready(function() {
    var transactionData = []; // Store fetched data for filtering

    function fetchTransactionDetails() {
        $.ajax({
            url: fetchTransDetailsRoute, // Ensure this route is correctly defined
            method: 'GET',
            success: function(response) {
                if (response) {
                    transactionData = response; // Store fetched transaction details
                    populateMpesaDropdown(transactionData); // Populate dropdown with fetched data
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    function populateMpesaDropdown(data) {
        var options = '<option value="">Select Mpesa Code</option>';
        data.forEach(function(transaction) {
            options += '<option value="' + transaction.TransID + '" data-amount="' + transaction.TransAmount + '">' +
                       transaction.TransID + ' - Amount: ' + transaction.TransAmount +
                       '</option>';
        });
        $('#mpesaCode').html(options).trigger('change');
    }

    // Call the function to fetch transaction details
    fetchTransactionDetails();

    // Initialize Select2 on the Mpesa Code select to enable searching
    $('#mpesaCode').select2({
        placeholder: 'Select Mpesa Code',
        allowClear: true,
        width: '100%'
    });

    // Event listener for selecting an Mpesa code from the dropdown
    $('#mpesaCode').on('change', function() {
        var selectedOption = $(this).val();
        if (selectedOption) {
            $('#paymentReference').val(selectedOption); // Set the selected Mpesa code to the paymentReference field
        }
    });

    // Event listener for changing the payment method dropdown
    $('#paymentMethod').on('change', function() {
        var selectedMethod = $(this).val();
        if (selectedMethod === 'MPESA') {
            $('#mpesaCodeGroup').show(); // Show the Mpesa code group
            $('#paymentReference').prop('readonly', true); // Make payment reference read-only
        } else {
            $('#mpesaCodeGroup').hide(); // Hide the Mpesa code group
            $('#paymentReference').val(''); // Clear the payment reference
            $('#paymentReference').prop('readonly', false); // Make payment reference editable
        }
    });

    // Force the check when the page is loaded in case the method is already MPESA
    if ($('#paymentMethod').val() === 'MPESA') {
        $('#mpesaCodeGroup').show();
        $('#paymentReference').prop('readonly', true);
    }
});
