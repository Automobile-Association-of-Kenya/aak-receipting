(function () {
    membersOption("#paymentMemberID");
    membersOption("#mpesaPaymentMemberID");
    departmentOptions("#departmentInvoiceId");

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
        paymentMethod = $("#paymentMethod"),
        paymentReference = $("#paymentReference"),
        mpesaPaymentDescription = $("#mpesaPaymentDescription"),
        mpesaPaymentAmount = $("#mpesaPaymentAmount"),
        mpesaPaymentInvoiceID = $("#mpesaPaymentInvoiceID"),
        mpesaPaymentForm = $("#mpesaPaymentForm");

    paymentMemberID.on("change", function () {
        let member_id = $(this).val();
        $.getJSON("/member-invoices/" + member_id, function (invoices) {
            let option = `<option value="">Select Invoice</option>`;
            $.each(invoices, function (key, value) {
                option += `<option value="${value.id}">${value.invoice_no}</option>`;
            });
            paymentInvoiceID.html(option);
        });
    });

    mpesaPaymentMemberID.on("change", function () {
        let member_id = $(this).val();
        $.getJSON("/member-invoices/" + member_id, function (invoices) {
            let option = `<option value="">Select Invoice</option>`;
            $.each(invoices, function (key, value) {
                option += `<option value="${value.id}">${value.invoice_no}</option>`;
            });
            mpesaPaymentInvoiceID.html(option);
        });
    });
    mpesaPaymentInvoiceID.on("change", function () {
        let invoice_id = $(this).val();
        $.getJSON("/invoices/" + invoice_id, function (invoice) {
            mpesaPaymentAmount.val(invoice.amount);
        });
    });

    paymentInvoiceID.on("change", function (event) {
        let invoice_id = $(this).val();
        $.getJSON("/invoices/" + invoice_id, function (invoice) {
            paymentAmount.val(invoice.amount);
        });
    });

    createManualPaymentFOrm.on("submit", function (event) {
        event.preventDefault();
        const $this = $(this);
        const data = {
            _token: $this.find("input[name='_token']").val(),
            invoice_id: paymentInvoiceID.val(),
            members_id: paymentMemberID.val(),
            transact_no: paymentReference.val(),
            amount: paymentAmount.val(),
            date: paymentDate.val(),
            method: paymentMethod.val(),
            description: paymentDescription.val(),
        };
        $.post("/payments", data)
            .done(function (params) {
                console.log(params);
                let result = JSON.parse(params);
                if (result.status == "success") {
                    $this.trigger("reset");
                    showSuccess(result.message, "#paymentFeedback");
                    window.setTimeout(function () {
                        $("#createPaymentModal").modal("hide");
                    }, 3000);
                    getPayments();
                } else {
                    showError(
                        "Error occured during processing",
                        "#paymentFeedback"
                    );
                }
            })
            .fail(function (error) {
                console.log(error);
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

    // initiatePayment.on("click", function (event) {
    //     event.preventDefault();
    // });

    confirmPayment.on("submit", function (event) {
        event.preventDefault();
    });

    function getPayments() {
        $.getJSON("/payments-data", function (payments) {
            //let payments = JSON.parse(values);
            if (payments.length > 0) {
                let tr = "",
                    i = 1;
                $.each(payments, function (key, value) {
                    let firstName =
                            value.member.firstName == null ||
                            value.member.firstName == undefined
                                ? ""
                                : value.member.firstName,
                        secondName =
                            value.member.secondName == null ||
                            value.member.secondName == undefined
                                ? ""
                                : value.member.secondName,
                        surNameName =
                            value.member.surNameName == null ||
                            value.member.surNameName == undefined
                                ? ""
                                : value.member.surNameName,
                        mobilePhoneNumber =
                            value.member.mobilePhoneNumber == null ||
                            value.member.mobilePhoneNumber == undefined
                                ? ""
                                : value.member.mobilePhoneNumber,
                        amount =
                            value.amount == null || value.amount == undefined
                                ? ""
                                : value.amount,
                        description =
                            value.description == null || value.description == undefined
                                ? ""
                                : value.description,
                        invoice_no =
                            value.invoice?.invoice_no == null || value.invoice?.invoice_no == undefined
                                ? ""
                                : value.invoice?.invoice_no;
                    tr += `<tr><td><small>${i++}</small></td><td><small>${
                        value.receipt_no
                    }</small></td><td><small>${
                        value.member.idNo +
                        " " +
                        firstName +
                        " " +
                        secondName +
                        " " +
                        surNameName
                    }</small></td><td><small>${
                        mobilePhoneNumber
                    }</small></td><td><small>${numberFormat(
                        amount
                    )}</small></td><td><small>${
                        description
                    }</small></td><td><small>${
                        invoice_no
                    }</small></td><td><small><a href="/payment-print/${
                        value.id
                    }" class="btn btn-sm btn-primary" target="__blank"><i class="fa fa-print"></i></a></small></td></tr>`;
                });
                let table =
                    '<table class="table table-bordered table-sm" id="paymentsDataTable" width="100%" cellspacing="0"><thead><th>#</th><th>NO</th><th>Customer</th><th>Phone</th><th>Amount</th><th>Description</th><th>Invoice</th><th>Action</th></thead><tbody>' +
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

    mpesaPaymentForm.on("submit", function (event) {
        event.preventDefault();
        const $this = $(this),
            data = {
                _token: $this.find("input[name='_token']").val(),
                members_id: mpesaPaymentMemberID.val(),
                invoice_id: mpesaPaymentInvoiceID.val(),
                phone: mpesaPaymentPhone.val(),
                description: mpesaPaymentDescription.val(),
                amount: mpesaPaymentAmount.val(),
            };
        initiatePayment.prop("disabled", true);
        $.post("/payment-mpesa", data)
            .done(function (params) {
                console.log(params);
                initiatePayment.prop("disabled", false);
                let result = JSON.parse(params);
                if (result.status == "success") {
                    $this.trigger("reset");
                    window.setTimeout(function () {
                        $("#createPaymentModal").modal("hide");
                    }, 3000);
                    showSuccess(result.message, "#mpesaPaymentFeedback");
                    getPayments();
                } else {
                    showError(
                        "Error occured during processing",
                        "#mpesaPaymentFeedback"
                    );
                }
            })
            .fail(function (error) {
                console.error(error);
                initiatePayment.prop("disabled", false);
                if (error.status == 422) {
                    var errors = "";
                    $.each(error.responseJSON.errors, function (key, value) {
                        errors += value + "!";
                    });
                    showError(errors, "#mpesaPaymentFeedback");
                } else {
                    showError(
                        "Error occured during processing",
                        "#mpesaPaymentFeedback"
                    );
                }
            });
    });
})();
