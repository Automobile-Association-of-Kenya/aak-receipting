(function () {
    productOptions("#departmentProductID");
    membersOption("#memberID");
    branchesOption("#invoiceBranchID");

    $("#memberID").select2({
        dropdownParent: "#membersInvoiceDiv",
    });

    const createInvoiceFOrm = $("#createInvoiceFOrm"),
        memberID = $("#memberID"),
        departmentProductID = $("#departmentProductID"),
        invoiceAmount = $("#invoiceAmount"),
        invoiceDate = $("#invoiceDate"),
        invoicesTableSection = $("#invoicesTableSection"),
        departmentInvoiceId = $("#departmentInvoiceId"),
        invoiceBranchID = $("#invoiceBranchID");

    departmentInvoiceId.on("change", function (event) {
        let department_id = $(this).val();
        $.getJSON(
            "/department-services/" + department_id,
            function (departments) {
                let option = `<option value="">Select Product</option>`;
                $.each(departments, function (key, value) {
                    option += `<option value="${value.id}">${value.name}</option>`;
                });
                departmentProductID.html(option);
            }
        );
    });

    departmentProductID.on("change", function (event) {
        let product_id = $(this).val();
        if (product_id == "NULL") {
            invoiceAmount.val("");
        } else {
            $.getJSON("/products/" + product_id, function (product) {
                invoiceAmount.val(product.amount);
            });
        }
    });

    createInvoiceFOrm.on("submit", function (event) {
        event.preventDefault();
        const $this = $(this);
        const data = {
            _token: $this.find("input[name='_token']").val(),
            branch_id: invoiceBranchID.val(),
            members_id: memberID.val(),
            departments_products_id: departmentProductID.val(),
            amount: invoiceAmount.val(),
            date: invoiceDate.val(),
        };
        $.post("/invoices", data)
            .done(function (params) {
                let result = JSON.parse(params);
                if (result.status == "success") {
                    $this.trigger("reset");
                    showSuccess(result.message, "#invoiceFeedback");
                    getInvoices();
                } else {
                    showError(
                        "Error occured during processing",
                        "#invoiceFeedback"
                    );
                }
            })
            .fail(function (error) {
                if (error.status == 422) {
                    var errors = "";
                    $.each(error.responseJSON.errors, function (key, value) {
                        errors += value + "!";
                    });
                    showError(errors, "#invoiceFeedback");
                } else {
                    showError(
                        "Error occured during processing",
                        "#invoiceFeedback"
                    );
                }
            });
    });

    function getInvoices() {
        $.getJSON("/invoices-data", function (invoices) {
            let tr = "",
                i = 1;
            if (invoices.length > 0) {
                $.each(invoices, function (key, value) {
                    tr += `<tr><td><small>${i++}</small></td><td><small>${
                        value.invoice_no
                    }</small></td><td>${value.branch?.name}</td><td><small>${
                        value.member.idNo +
                        " " +
                        value.member.firstName +
                        " " +
                        value.member.secondName +
                        " " +
                        value.member.surNameName
                    }</small></td><td><small>${
                        value.product !== null ? value.product.name : "N/A"
                    }</small></td><td><small>${
                        value.amount
                    }</small></td><td><small>${
                        value.date
                    }</small></td><td><small><a href="/invoice-print/${
                        value.id
                    }" class="btn btn-sm btn-primary" target="__blank"><i class="fa fa-print"></i></a></small></td></tr>`;
                });
                let table = `<table class="table table-bordered table-hover" id="invoicesDataTable"><thead><th>#</th><th>NO</th><th>Branch</th><th>Member</th><th>Product</th><th>Amount</th><th>Date</th><th>Action</th></thead><tbody>${tr}</tbody></table>`;
                invoicesTableSection.html(table);
                if ($.fn.DataTable.isDataTable("#invoicesDataTable")) {
                    $("#invoicesDataTable").DataTable().destroy();
                    $("#invoicesDataTable").DataTable({
                        // dom: "Bfrtip",
                        // buttons: [
                        //     "copyHtml5",
                        //     "excelHtml5",
                        //     "csvHtml5",
                        //     "pdfHtml5",
                        // ],
                    });
                } else {
                    $("#invoicesDataTable").DataTable({
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
                invoicesTableSection.html(
                    '<div class="text-center"><h3 class="text-danger">No data available to display</h3></div>'
                );
            }
        });
    }

    getInvoices();


})();
