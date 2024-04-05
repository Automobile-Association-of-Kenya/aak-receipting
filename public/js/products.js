(function () {
    const createProductForm = $("#createProductForm"),
        departmentID = $("#departmentID"),
        productName = $("#productName"),
        productAmount = $("#productAmount"),
        productVAT = $("#productVAT"),
        productGL = $("#productGL"),
        productsTableSection = $("#productsTableSection");

    createProductForm.on("submit", function (event) {
        event.preventDefault();
        const $this = $(this),
            data = {
                _token: $this.find("input[name='_token']").val(),
                departments_id: departmentID.val(),
                name: productName.val(),
                amount: productAmount.val(),
                vatable: productVAT.val(),
                GlNo: productGL.val(),
            };

        $.post("/products", data)
            .done(function (params) {
                console.log(params);
                let result = JSON.parse(params);
                if (result.status == "success") {
                    $this.trigger("reset");
                    showSuccess(result.message, "#productFeedback");
                    window.setTimeout(function () {
                        $("#createProductModal").modal("hide");
                    },3000);
                    getProducts();
                } else {
                    showError(
                        "Error occured during processing",
                        "#productFeedback"
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
                    showError(errors, "#productFeedback");
                } else {
                    showError(
                        "Error occured during processing",
                        "#productFeedback"
                    );
                }
            });
    });

    function getProducts() {
        $.getJSON("/products-data", function (products) {
            let tr = "",
                i = 1;
            $.each(products, function (key, value) {
                tr += `<tr><td>${i++}</td><td>${
                    value.department?.name
                }</td><td>${value.name}</td><td>${value.amount}</td><td>${
                    value.name
                }</td><td>${value.GlNo}</td></tr>`;
            });
            let table = `<table class="table table-bordered table-hover table-sm" id="productsTable"><thead><th>#</th><th>Department</th><th>Product</th><th>Cost</th><th>Vatable</th><th>GL No</th></thead><tbody>${tr}</tbody></table>`;
            productsTableSection.html(table);
            $("#productsTable").DataTable();
        });
    }
    getProducts();
})();
