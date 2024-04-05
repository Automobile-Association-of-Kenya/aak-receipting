(function () {
    departmentOptions("#departmentID");
    const createProductForm = $("#createProductForm"),
        departmentID = $("#departmentID"),
        productName = $("#productName"),
        productAmount = $("#productAmount");

    createProductForm.on('submit', function(event) {
        event.preventDefault();
        const $this = $(this);
        const data = {
            departments_id: departmentID.val(),
            name: productName.val(),
            amount: productAmount.val(),
            _token: $this.find("input[name='_token']").val(),
        };
        $.post("/products", data)
            .done(function (params) {
                console.log(params);
                let result = JSON.parse(params);
                if (result.status == "success") {
                    $this.trigger("reset");
                    showSuccess(result.message, "#productFeedback");
                } else {
                    showError(
                        "Error occured during processing",
                        "#productFeedback"
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
                    showError(errors, "#productFeedback");
                } else {
                    showError(
                        "Error occured during processing",
                        "#productFeedback"
                    );
                }
            });
    });
})();
