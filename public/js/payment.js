
(function () {
    membersOption("#paymentMemberID");
    membersOption("#mpesaPaymentMemberID");
    departmentOptions('#departmentInvoiceId');

    $("#paymentMemberID").select2({
        dropdownParent: "#jjjjhjhjj",
    });

    $("#mpesaPaymentMemberID").select2({
        dropdownParent: "#mpesaMembersDIv",
    });

    function numberFormat(number) {
        var parts = parseFloat(number).toFixed(2).split(".");
        var integerPart = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        var formattedNumber = integerPart;
        if (parts.length > 1) {
            var decimalPart = parts[1];
            formattedNumber += "." + decimalPart;
        }
        return formattedNumber;
    }

    const createManualPaymentFOrm = $("#createManualPaymentFOrm"),
        paymentMemberID = $("#paymentMemberID"),
        paymentInvoiceID = $("#paymentInvoiceID"),
        paymentAmount = $("#paymentAmount"),
        paymentDate = $("#paymentDate"),
        paymentDescription = $("#paymentDescription"),
        mpesaPaymentAction = $("#mpesaPaymentAction"),
        initiatePayment = $("#initiatePayment"),
        confirmPayment = $("#confirmPayment"),
        createMpesaPaymentForm = $("#createMpesaPaymentForm"),
        mpesaPaymentMemberID = $("#mpesaPaymentMemberID"),
        mpesaPaymentPhone = $("#mpesaPaymentPhone"),
        paymentMethod = $('#paymentMethod'), paymentReference = $('#paymentReference'),
        mpesaPaymentAmount = $("#mpesaPaymentAmount");


    createManualPaymentFOrm.on("submit", function (event) {
        event.preventDefault();
        const $this = $(this);
        const data = {
            _token: $this.find("input[name='_token']").val(),
            members_id: paymentMemberID.val(),
            transact_no: paymentReference.val(),
            amount: paymentAmount.val(),
            date: paymentDate.val(),
            method: paymentMethod.val(),
            description: paymentDescription.val(),
        };
        console.log(data);
        $.post("/payments", data)
            .done(function (params) {
                console.log(params);
                let result = JSON.parse(params);
                if (result.status == "success") {
                    $this.trigger("reset");
                    showSuccess(result.message, "#paymentFeedback");
                    getPayments();
                } else {
                    showError(
                        "Error occured during processing",
                        "#paymentFeedback"
                    );
                }
            })
            .fail(function (error) {
                console.error(error);
                if (error.status == 422) {
                    var errors = "";
                    $.each(error.responseJSON.errors, function (key, value) {
                        errors += value;
                    });
                    showError(errors, "#paymentFeedback");
                } else {
                    showError(
                        "Error occured during processing",
                        "#paymentFeedback"
                    );
                }
            });
    });

    createMpesaPaymentForm.on("submit", function (event) {
        event.preventDefault();
        const $this = $(this);
        const data = {
            _token: $this.find("input[name='_token']").val(),
            member_id: mpesaPaymentMemberID.val(),
            amount: mpesaPaymentAmount.val(),
            phone: mpesaPaymentPhone.val(),
        };
        console.log(data);
        $.post("/payments", data)
            .done(function (params) {
                console.log(params);
                let result = JSON.parse(params);
                if (result.status == "success") {
                    $this.trigger("reset");
                    showSuccess(result.message, "#paymentFeedback");
                    getPayments();
                } else {
                    showError(
                        "Error occured during processing",
                        "#paymentFeedback"
                    );
                }
            })
            .fail(function (error) {
                console.error(error);
                if (error.status == 422) {
                    var errors = "";
                    $.each(error.responseJSON.errors, function (key, value) {
                        errors += value;
                    });
                    showError(errors, "#paymentFeedback");
                } else {
                    showError(
                        "Error occured during processing",
                        "#paymentFeedback"
                    );
                }
            });
    });

    initiatePayment.on("click", function (event) {
        event.preventDefault();
    });

    confirmPayment.on('submit', function (event) {
        event.preventDefault();
    });

    function getPayments() {
        $.get("/payments-data", function (values) {
            let payments = JSON.parse(values);

            if (payments.data.length > 0) {
                let tr = "",
                    i = 1;
                $.each(payments.data, function (key, value) {
                    let { id, phone, amount, source, owner, description } =
                        value;
                    tr +=
                        "<tr><td>" +
                        i++ +
                        "</td><td>" +
                        owner +
                        "</td><td>" +
                        source +
                        "</td><td>" +
                        phone +
                        "</td><td>" +
                        numberFormat(amount ?? 0) +
                        "</td><td>" +
                        description +
                        '</td><td><a href="/payment-print/' +
                        value.id +
                        '" class="btn btn-sm btn-primary" target="__blank"><i class="fa fa-print"></i></a></td></tr>';
                });
                let table =
                    '<table class="table table-bordered" id="paymentsDataTable" width="100%" cellspacing="0"><thead><th>#</th><th>ID Number </th><th>Source</th><th>Phone</th><th>Amount</th><th>Description</th><th>Action</th></thead><tbody>' +
                    tr +
                    "</tbody></table>";

                $("#paymentTableSection").html(table);

                if ($.fn.DataTable.isDataTable("#paymentsDataTable")) {
                    $("#paymentsDataTable").destroy();
                    $("#paymentsDataTable").DataTable({
                        // dom: "Bfrtip",
                        // buttons: [
                        //     "copyHtml5",
                        //     "excelHtml5",
                        //     "csvHtml5",
                        //     "pdfHtml5",
                        // ],
                    });
                } else {
                    $("#paymentsDataTable").DataTable({
                        // dom: "Bfrtip",
                        // buttons: [
                        //     "copyHtml5",
                        //     "excelHtml5",
                        //     "csvHtml5",
                        //     "pdfHtml5",
                        // ],
                    });
                }
            } else {
                $("#paymentTableSection").html(
                    '<div class="text-center"><h3 class="text-danger">No data available to display</h3></div>'
                );
            }
        });
    }
    getPayments();
})();
