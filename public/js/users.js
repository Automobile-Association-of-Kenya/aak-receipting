(function () {

    const createUserForm = $('#createUserForm'),
        userName = $('#userName'),
        userEmail = $('#userEmail'),
        userRole = $('#userRole'),
        userPassword = $('#userPassword'), userTableSection = $('#userTableSection');
    // createUserModal;

    createUserForm.on("submit", function (event) {
        event.preventDefault();
        const $this = $(this),
            data = {
                _token: $this.find("input[name='_token']").val(),
                name: userName.val(),
                email: userEmail.val(),
                role: userRole.val(),
                password: userPassword.val(),
            };
        // console.log(data);
        $.post("/users", data)
            .done(function (params) {
                console.log(params);
                let result = JSON.parse(params);
                if (result.status == "success") {
                    $this.trigger("reset");
                    showSuccess(result.message, "#userFeedback");
                    window.setTimeout(function () {
                        $("#createUserModal").modal("hide");
                    }, 3000);
                    getUsers();
                } else {
                    showError(
                        "Error occured during processing",
                        "#userFeedback"
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
                    showError(errors, "#userFeedback");
                } else {
                    showError(
                        "Error occured during processing",
                        "#userFeedback"
                    );
                }
            });
    });

    function getUsers() {
        $.getJSON("/users-data", function (users) {
            let tr = "",
                i = 1;
            $.each(users, function (key, value) {
                tr += `<tr><td>${i++}</td><td>${value.name}</td><td>${value.email
                    }</td><td>${value.role}</td></tr>`;
            });
            let table = `<table class="table table-bordered table-hover table-sm" id="usersTable"><thead><th>#</th><th>Name</th><th>Email</th><th>Role</th></thead><tbody>${tr}</tbody></table>`;
            userTableSection.html(table);
            $('#usersTable').DataTable();
        });
    }
    getUsers();
})();
