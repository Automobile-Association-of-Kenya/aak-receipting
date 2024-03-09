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

    confirmPayment.on("submit", function (event) {
        event.preventDefault();
    });

    function getPayments() {
        let tr = "",
            i = 1;
        $.getJSON("/payments-local", function (payments) {
            console.log(payments);
            $.each(payments, function (key, value) {
                tr += `<tr><td>${i++}</td><td><small>${
                    value.member.idNo
                }</small></td><td></td><td><small>${
                    value.member.mobilePhoneNumber
                }</small></td><td><small>${
                    value.amount
                }</small></td><td><small>${
                    value.description
                }</small></td><td><small><a href="/payment-print/${value.id}/${
                    value.amount
                }/${value.description}/${
                    value.member.idNo
                }" class="btn btn-sm btn-primary" target="__blank"><i class="fa fa-print"></i></a></small></td></tr>`;
            });
        }).done(function () {
            $.get("/payments-data", function (values) {
                let payments = JSON.parse(values);
                if (payments.data.length > 0) {
                    $.each(payments.data, function (key, value) {
                        let { id, phone, amount, source, owner, description } =
                            value;
                        tr += `<tr><td>${i++}</td><td><small>${owner}</small></td><td><small>${source}</small></td><td><small>${phone}</small></td><td><small>${numberFormat(
                            amount ?? 0
                        )}</small></td><td><small>${description}</small></td><td><small><a href="/payment-print/${id}/${amount}/${description}/${owner}" class="btn btn-sm btn-primary" target="__blank"><i class="fa fa-print"></i></a></small></td></tr>`;
                    });
                    let table =
                        '<table class="table table-bordered table-sm" id="paymentsDataTable" width="100%" cellspacing="0"><thead><th>#</th><th>ID Number </th><th>Source</th><th>Phone</th><th>Amount</th><th>Description</th><th>Action</th></thead><tbody>' +
                        tr +
                        "</tbody></table>";
                    $("#paymentTableSection").html(table);
                    if ($.fn.DataTable.isDataTable("#paymentsDataTable")) {
                        $("#paymentsDataTable").destroy();
                        $("#paymentsDataTable").DataTable({});
                    } else {
                        $("#paymentsDataTable").DataTable({});
                    }
                } else {
                    $("#paymentTableSection").html(
                        '<div class="text-center"><h3 class="text-danger">No data available to display</h3></div>'
                    );
                }
            });
        });
    }
    getPayments();
})();
