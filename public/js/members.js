(function () {
    const createMemberFOrm = $("#createMemberFOrm"),
        clientIDNumber = $("#clientIDNumber"),
        clientFirstName = $("#clientFirstName"),
        clientSecondName = $("#clientSecondName"),
        clientLastName = $("#clientLastName"),
        clientEmail = $("#clientEmail"),
        clientPhone = $("#clientPhone"),
        createClientToggle = $("#createClientToggle"),
        customersTableSection = $("#customersTableSection");

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
                let result = JSON.parse(params);
                if (result.status == "success") {
                    $this.trigger("reset");
                    showSuccess(result.message, "#memberFeedback");
                    window.setTimeout(function () {
                        $("#createClientModal").modal("hide");
                    }, 3000);
                    getMembers();
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

        $.post("/corporates", data)
            .done(function (params) {
                let result = JSON.parse(params);
                if (result.status == "success") {
                    $this.trigger("reset");
                    showSuccess(result.message, "#memberFeedback");
                    window.setTimeout(function () {
                        $("#createClientModal").modal("hide");
                    }, 3000);
                    getMembers();
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

    function getMembers() {
        $.getJSON("/members-data", function (customers) {
            let tr = "",
                i = 1;
            $.each(customers, function (key, value) {
                tr += `<tr><td>${i++}</td><td><small>${value.MembershipNumber
                    }</small></td><td><small>${value.firstName +
                    " " +
                    value.secondName +
                    " " +
                    value.surNameName
                    }</small></td><td><small>${value.idNo}</small></td><td><small>${value.mobilePhoneNumber
                    }</small></td><td><small>${value.emailAddress
                    }</small></td></tr>`;
            });
            let table = `<table class="table table-bordered table-hover table-sm" id="mambersTable"><thead><th>#</th><th>Customer Number</th><th>Name</th><th>ID</th><th>Phone</th><th>Email</th></thead><tbody>${tr}</tbody></table>`;
            customersTableSection.html(table);
            $("#mambersTable").DataTable();
        });
    }

    getMembers();

    const corporateCreateForm = $('#corporateCreateForm'), corporateIdNO = $('#corporateIdNO'),
        corporateFirstName = $('#corporateFirstName'),
        corporateSecondName = $('#corporateSecondName'),
        corporateLastName = $('#corporateLastName'),
        corporateEmail = $('#corporateEmail'),
        corporatePhoneNumber = $('#corporatePhoneNumber');

    corporateCreateForm.on('submit', function (event) {
        event.preventDefault();
        const $this = $(this), data = {
            _token: $(this).find("input[name='_token'").val(),
            id_number: corporateIdNO.val(),
            first_name: corporateFirstName.val(),
            second_name: corporateSecondName.val(),
            last_name: corporateLastName.val(),
            email: corporateEmail.val(),
            phone_number: corporatePhoneNumber.val(),
        }, errors = [];
        console.log(data);
        $.post('corporates', data).done(function (params) {
            console.log(params);
            let result = JSON.parse(params);
            if (result.status == "success") {
                $this.trigger("reset");
                showSuccess(result.message, "#corporateFeedback");
            } else {
                showError(
                    "Error occured during processing",
                    "#corporateFeedback"
                );
            }
        }).fail(function (error) {
            console.log(error);
            if (error.status == 422) {
                showError(
                    error.responseJSON.errors.join(","),
                    "#corporateFeedback"
                );
            } else {
                showError(
                    "Error occured during processing",
                    "#corporateFeedback"
                );
            }
        })
    })

})();
