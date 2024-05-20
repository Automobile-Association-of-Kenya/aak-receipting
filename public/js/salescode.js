$(document).ready(function () {
    $("#salescodeForm").on("submit", function (event) {
        event.preventDefault();
        let $this = $(this);
        // Extracting form data
        var formData = {
            _token: $(this).find("input[name='_token']").val(),
            name: $(this).find("input[name='name']").val(),
            sales_code: $(this).find("input[name='sales_code']").val(),
        };

        $.post($(this).attr("action"), formData)
            .done(function (response) {
                let result = JSON.parse(response);
                if (result.status == "success") {
                    $this.trigger("reset");
                    showSuccess(result.message, "#salescodefeedback");
                    window.setTimeout(function () {
                        $("#createSalesCodeModal").modal("hide");
                    }, 1000);
                } else {
                    showError(
                        "Error occured during processing",
                        "#salescodefeedback"
                    );
                }
            })
            .fail(function (error) {
                if (error.status == 422) {
                    var errors = "";
                    $.each(error.responseJSON.errors, function (key, value) {
                        errors += value + "!";
                    });
                    showError(errors, "#salescodefeedback");
                } else {
                    showError(
                        "Error occured during processing",
                        "#salescodefeedback"
                    );
                }
            });
    });
});
