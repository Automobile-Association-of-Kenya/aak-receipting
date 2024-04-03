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
<<<<<<< HEAD
        invoiceBranchID = $("#invoiceBranchID"),
        invoiceProductsTbody = $("#invoiceProductsTbody"),
        invoiceProductsTfoot = $("#invoiceProductsTfoot");
=======
        invoiceBranchID = $("#invoiceBranchID");
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6

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
<<<<<<< HEAD
                let tr = `<tr data-id="${product.id}"><td>${product.name}</td><td><input id="invoiceProductQuantity" value="1" readonly></td><td class="invoiceProductAmount">${product.amount}</td><td><i class="fa fa-trash text-danger" id="removeInvoiceProduct"></i></td></tr>`;
                if ($("#invoiceProductsTbody > tr").length > 0) {
                    $("#invoiceProductsTbody > tr").each(function (key, value) {
                        if (
                            parseInt($(value).data("id")) ===
                            parseInt(product.id)
                        ) {
                            let cQTY = parseInt(
                                    $(value)
                                        .find("#invoiceProductQuantity")
                                        .val()
                                ),
                                nQTY = cQTY + 1,
                                cAmount = parseFloat(
                                    $(value)
                                        .find(".invoiceProductAmount")
                                        .text()
                                ),
                                nAmount =
                                    parseFloat(cAmount) +
                                    parseFloat(product.amount);
                            $(value).find(".invoiceProductQuantity").val(nQTY);
                            $(value)
                                .find(".invoiceProductAmount")
                                .text(nAmount);
                            calcuteTotal();
                        } else {
                            invoiceProductsTbody.prepend(tr);
                            calcuteTotal();
                        }
                    });
                } else {
                    invoiceProductsTbody.prepend(tr);
                    calcuteTotal();
                }
=======
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6
            });
        }
    });

<<<<<<< HEAD
    $("body").on("click", "#removeInvoiceProduct", function () {
        $(this).closest("tr").remove();
        calcuteTotal();
    });

    function calcuteTotal() {
        let amount = 0;
        $(".invoiceProductAmount").each(function (key, value) {
            amount += parseFloat($(this).text());
        });
        invoiceProductsTfoot.html(
            `<tr><td colspan="2"><strong>Total</strong></td><td><strong>${amount}</strong></td><td></td></tr>`
        );
        invoiceAmount.val(amount);
    }

    createInvoiceFOrm.on("submit", function (event) {
        event.preventDefault();
        const $this = $(this),
            errors = [],
            products = [];
        $("#invoiceProductsTbody > tr").each(function (key, value) {
            products.push({
                product_id: $(value).data("id"),
                amount: parseFloat(
                    $(value).find(".invoiceProductAmount").text()
                ),
            });
        });
=======
    createInvoiceFOrm.on("submit", function (event) {
        event.preventDefault();
        const $this = $(this);
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6
        const data = {
            _token: $this.find("input[name='_token']").val(),
            branch_id: invoiceBranchID.val(),
            members_id: memberID.val(),
<<<<<<< HEAD
            amount: invoiceAmount.val(),
            date: invoiceDate.val(),
            products: products,
        };
        if (data.products.length <= 0) {
            errors.push("Products are required");
        }
        if (data.branch_id == "") {
            errors.push("Branch is required");
        }
        if (data.members_id == "") {
            errors.push("Client is required");
        }
        if (data.amount == "") {
            errors.push("amount is required");
        }
        if (data.date == "") {
            errors.push("date is required");
        }
        if (errors.length <= 0) {
            $.post("/invoices", data)
                .done(function (params) {
                    console.log(params);
                    let result = JSON.parse(params);
                    if (result.status == "success") {
                        $this.trigger("reset");
                        showSuccess(result.message, "#invoiceFeedback");
                        window.setTimeout(function () {
                            $("#createInvoiceModal").modal("hide");
                        }, 3000);
                        getInvoices();
                        $("#invoiceProductsTbody > tr").each(function (key, value) {
                            $(value).remove();
                        });
                    } else {
                        showError(
                            "Error occured during processing",
                            "#invoiceFeedback"
                        );
                    }
                })
                .fail(function (error) {
                    console.error(error);
                    if (error.status == 422) {
                        var errors = "";
                        $.each(
                            error.responseJSON.errors,
                            function (key, value) {
                                errors += value + "!";
                            }
                        );
                        showError(errors, "#invoiceFeedback");
                    } else {
                        showError(
                            "Error occured during processing",
                            "#invoiceFeedback"
                        );
                    }
                });
        } else {
            showError(errors.join(", "), "#invoiceFeedback");
        }
=======
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
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6
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
<<<<<<< HEAD
=======
                        value.product !== null ? value.product.name : "N/A"
                    }</small></td><td><small>${
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6
                        value.amount
                    }</small></td><td><small>${
                        value.date
                    }</small></td><td><small><a href="/invoice-print/${
                        value.id
                    }" class="btn btn-sm btn-primary" target="__blank"><i class="fa fa-print"></i></a></small></td></tr>`;
                });
<<<<<<< HEAD
                let table = `<table class="table table-bordered table-hover" id="invoicesDataTable"><thead><th>#</th><th>NO</th><th>Branch</th><th>Member</th><th>Amount</th><th>Date</th><th>Action</th></thead><tbody>${tr}</tbody></table>`;
=======
                let table = `<table class="table table-bordered table-hover" id="invoicesDataTable"><thead><th>#</th><th>NO</th><th>Branch</th><th>Member</th><th>Product</th><th>Amount</th><th>Date</th><th>Action</th></thead><tbody>${tr}</tbody></table>`;
>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6
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
<<<<<<< HEAD
=======


>>>>>>> 6ca1795e5d40cf2e63222e9b256f4797b59d89d6
})();
