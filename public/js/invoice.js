(function () {
    productOptions("#departmentProductID");
    membersOption("#memberID");
    branchesOption("#invoiceBranchID");
    // salesCodeOptions('#salescodeID');

    $("#memberID").select2({
        dropdownParent: "#membersInvoiceDiv",
    });
    $("#invoiceBranchID").select2({
        dropDownParent: '#invoiceBranchDiv',
    });

    const createInvoiceFOrm = $("#createInvoiceFOrm"),
        memberID = $("#memberID"),
        departmentProductID = $("#departmentProductID"),
        invoiceAmount = $("#invoiceAmount"),
        invoiceDate = $("#invoiceDate"),
        invoicesTableSection = $("#invoicesTableSection"),
        departmentInvoiceId = $("#departmentInvoiceId"),
        invoiceBranchID = $("#invoiceBranchID"),
        invoiceProductsTbody = $("#invoiceProductsTbody"),
        salescodeID = $("#salescodeID"),
        invoiceProductsTfoot = $("#invoiceProductsTfoot"),
        invoiceSubmit = $('#invoiceSubmit');

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

    // departmentProductID.on("change", function (event) {
    //     let product_id = $(this).val();

    //     if (product_id == "NULL") {
    //         invoiceAmount.val("");
    //     } else {
    //         if ($("#invoiceProductsTbody > tr").length > 0) {
    //             $("#invoiceProductsTbody > tr").each(function (key, row) {
    //                 if (
    //                     parseInt($(row).data("id")) ===
    //                     parseInt(product_id)
    //                 ) {
    //                     console.log('here we are');
    //                 } else {
    //                     $.getJSON("/products/" + product_id, function (product) {
    //                         invoiceAmount.val(product.amount);
    //                         let tr = `<tr data-id="${product.id}"><td>${product.name}</td><td><input id="invoiceProductQuantity" value="1" readonly></td><td class="invoiceProductAmount">${product.amount}</td><td><i class="fa fa-trash text-danger" id="removeInvoiceProduct"></i></td></tr>`;
    //                         calcuteTotal();
    //                         invoiceProductsTbody.prepend(tr);
    //                     });
    //                 }
    //             });
    //         } else {
    //             $.getJSON("/products/" + product_id, function (product) {
    //                 invoiceAmount.val(product.amount);
    //                 let tr = `<tr data-id="${product.id}"><td>${product.name}</td><td><input id="invoiceProductQuantity" value="1" readonly></td><td class="invoiceProductAmount">${product.amount}</td><td><i class="fa fa-trash text-danger" id="removeInvoiceProduct"></i></td></tr>`;
    //                 calcuteTotal();
    //                 invoiceProductsTbody.prepend(tr);
    //             });
    //         }
    //     }
    // });

    // departmentProductID.on("change", function (event) {
    //     let product_id = $(this).val();
    //     let productFound = false;
    //     $("#invoiceProductsTbody > tr").each(function (key, row) {
    //         let rowProductId = parseInt($(row).data("id"));
    //         console.log(`Row Product ID: ${rowProductId}, Selected Product ID: ${product_id}`);
    //         if (rowProductId === parseInt(product_id)) {
    //             console.log('Product already in the list');
    //             productFound = true;

    //             return false;  // Exit the loop
    //         }
    //     });
    //     if (!productFound) {
    //         $.getJSON("/products/" + product_id, function (product) {
    //             invoiceAmount.val(product.amount);
    //             let tr = `<tr data-id="${product.id}"><td>${product.name}</td><td><input id="invoiceProductQuantity" value="1" readonly></td><td class="invoiceProductAmount">${product.amount}</td><td><i class="fa fa-trash text-danger" id="removeInvoiceProduct"></i></td></tr>`;
    //             calcuteTotal();
    //             invoiceProductsTbody.prepend(tr);
    //         });
    //     }
    // });

    departmentProductID.on("change", function (event) {
        let product_id = $(this).val();
        if (product_id == "NULL") {
            invoiceAmount.val("");
        } else {
            let productFound = false;
            $("#invoiceProductsTbody > tr").each(function (key, row) {
                let rowProductId = parseInt($(row).data("id"));
                console.log(`Row Product ID: ${rowProductId}, Selected Product ID: ${product_id}`);
                if (rowProductId === parseInt(product_id)) {
                    console.log('Product already in the list');
                    productFound = true;
                    let quantityInput = $(row).find("#invoiceProductQuantity");
                    let currentQuantity = parseInt(quantityInput.val());
                    let newQuantity = currentQuantity + 1;
                    quantityInput.val(newQuantity);
                    let unitAmount = parseFloat($(row).find(".invoiceProductAmount").data("unit-amount"));
                    let newAmount = unitAmount * newQuantity;
                    $(row).find(".invoiceProductAmount").text(newAmount.toFixed(2));
                    calcuteTotal();
                    return false;
                }
            });
            if (!productFound) {
                $.getJSON("/products/" + product_id, function (product) {
                    invoiceAmount.val(product.amount);
                    let tr = `<tr data-id="${product.id}">
                            <td>${product.name}</td>
                            <td><input id="invoiceProductQuantity" value="1"></td>
                            <td class="invoiceProductAmount" data-unit-amount="${product.amount}">${product.amount}</td>
                            <td><i class="fa fa-trash text-danger" id="removeInvoiceProduct"></i></td>
                          </tr>`;
                    invoiceProductsTbody.prepend(tr);
                    calcuteTotal();
                });
            }
        }
    });

    $('body').on("input", "#invoiceProductQuantity", function () {
        let quantityInput = $(this);
        let row = quantityInput.closest("tr");
        let unitAmount = parseFloat(row.find(".invoiceProductAmount").data("unit-amount"));
        let newQuantity = parseInt(quantityInput.val());
        if (!isNaN(newQuantity) && newQuantity > 0) {
            let newAmount = unitAmount * newQuantity;
            row.find(".invoiceProductAmount").text(newAmount.toFixed(2));
            calcuteTotal();
        }
    });


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
        invoiceSubmit.prop('disabled', true);
        $("#invoiceProductsTbody > tr").each(function (key, value) {
            products.push({
                product_id: $(value).data("id"),
                amount: parseFloat(
                    $(value).find(".invoiceProductAmount").text()
                ),
            });
        });
        const data = {
            _token: $this.find("input[name='_token']").val(),
            branch_id: invoiceBranchID.val(),
            members_id: memberID.val(),
            amount: invoiceAmount.val(),
            date: invoiceDate.val(),
            sales_code: salescodeID.val(), // Include sales_code value here
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
                    let result = JSON.parse(params);
                    if (result.status == "success") {
                        $this.trigger("reset");
                        showSuccess(result.message, "#invoiceFeedback");
                        window.setTimeout(function () {
                            $("#createInvoiceModal").modal("hide");
                            invoiceSubmit.prop('disabled', false);
                        }, 3000);
                        getInvoices();
                        $("#invoiceProductsTbody > tr").each(function (
                            key,
                            value
                        ) {
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
                    invoiceSubmit.prop('disabled', false);

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
    });

    function getInvoices() {
        $.getJSON("/invoices-data", function (invoices) {
            let tr = "",
                i = 1;
            if (invoices.length > 0) {
                $.each(invoices, function (key, value) {
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
                        idNo =
                            value.member.idNo == null ||
                                value.member.idNo == undefined
                                ? ""
                                : value.member.idNo,
                        surNameName =
                            value.member.surNameName == null ||
                                value.member.surNameName == undefined
                                ? ""
                                : value.member.surNameName,
                        branch =
                            value.branch?.name == undefined ||
                                value.branch?.name == null
                                ? ""
                                : value.branch?.name,
                        amount =
                            value.amount == null || value.amount == undefined
                                ? ""
                                : value.amount,
                        date =
                            value.date == null || value.date == undefined
                                ? ""
                                : value.date;
                    tr += `<tr><td><small>${i++}</small></td><td><small>${value.invoice_no
                        }</small></td><td><small>${branch}</td></small><td><small>${idNo +
                        " " +
                        firstName +
                        " " +
                        secondName +
                        " " +
                        surNameName
                        }</small></td><td><small>${amount}</small></td><td><small>${date}</small><td><small>${value.user?.name}</small></td></td><td><small><a href="/invoice-print/${value.id
                        }" class="btn btn-sm btn-primary" target="__blank"><i class="fa fa-print"></i></a></small></td></tr>`;
                });
                let table = `<table class="table table-bordered table-hover table-sm" id="invoicesDataTable"><thead><th>#</th><th>NO</th><th>Branch</th><th>Customer</th><th>Amount</th><th>Date</th><th>Invoiced By</th><th>Action</th></thead><tbody>${tr}</tbody></table>`;
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
