(function () {
    const createMemberFOrm = $("#createMemberFOrm"),
        clientIDNumber = $("#clientIDNumber"),
        clientFirstName = $("#clientFirstName"),
        clientSecondName = $("#clientSecondName"),
        clientLastName = $("#clientLastName"),
        clientEmail = $("#clientEmail"),
        clientPhone = $("#clientPhone"),
        createClientToggle = $("#createClientToggle");

    createMemberFOrm.on("submit", function (event) {
        event.preventDefault();
        const $this = $(this);
        const data = {
            id_number: clientIDNumber.val(),
            first_name: clientFirstName.val(),
            second_name: clientSecondName.val(),
            last_name: clientLastName.val(),
            phone_number: clientPhone.val(),
            status: null,
            member_number: null,
            email: clientEmail.val(),
            _token: $this.find("input[name='_token']").val(),
        };
        $.post("/members", data)
            .done(function (params) {
                console.log(params);
                let result = JSON.parse(params);
                if (result.status == "success") {
                    $this.trigger("reset");
                    // showSuccess(result.message, "#memberFeedback");
                } else {
                    showError(
                        "Error occured during processing",
                        "#memberFeedback"
                    );
                }
            })
            .fail(function (error) {
                if (error.status == 422) {
                    showError(
                        error.responseJSON.errors.join(","),
                        "#memberFeedback"
                    );
                } else {
                    showError(
                        "Error occured during processing",
                        "#memberFeedback"
                    );
                }
            });
    });

})();
