(function () {
    const createBranchForm = $("#createBranchForm"),
        branchName = $("#branchName"),
        branchCode = $("#branchCode"),
        branchesTableSection = $("#branchesTableSection");

    createBranchForm.on("submit", function (event) {
        event.preventDefault();
        const $this = $(this);
        const data = {
            name: branchName.val(),
            branch_code: branchCode.val(),
            _token: $this.find("input[name='_token']").val(),
        };
        $.post("/branches", data)
            .done(function (params) {
                let result = JSON.parse(params);
                if (result.status == "success") {
                    $this.trigger("reset");
                    showSuccess(result.message, "#branchFeedback");
                    window.setTimeout(function() {
                        $("#createBranchModal").modal("hide");
                    }, 3000);
                    getBranches();
                } else {
                    showError(
                        "Error occured during processing",
                        "#branchFeedback"
                    );
                }
            })
            .fail(function (error) {
                if (error.status == 422) {
                    showError(
                        error.responseJSON.errors.join(","),
                        "#branchFeedback"
                    );
                } else {
                    showError(
                        "Error occured during processing",
                        "#branchFeedback"
                    );
                }
            });
    });

    function getBranches() {
        $.getJSON("/branches-data", function (branches) {
            let tr = "",
                i = 1;
            $.each(branches, function (key, value) {
                tr += `<tr><td>${i++}</td><td><small>${value?.name}</small></td>
                    <td><small>${value?.branch_code}</small></td>
                    <td><small>${
                        value?.user.name
                    }</small></td></tr>`;
            });
            let table = `<table class="table table-bordered table-hover table-sm" id="branchesTable"><thead><th>#</th><th>Code</th><th>Name</th><th>Added by</th></thead><tbody>${tr}</tbody></table>`;
            branchesTableSection.html(table);
            // $("#branchesTable").DataTable();
            if ($.fn.DataTable.isDataTable("#branchesTable")) {
                $("#branchesTable").DataTable().destroy();
                $("#branchesTable").DataTable({
                    // dom: "Bfrtip",
                    // buttons: [
                    //     "copyHtml5",
                    //     "excelHtml5",
                    //     "csvHtml5",
                    //     "pdfHtml5",
                    // ],
                });
            } else {
                $("#branchesTable").DataTable({
                    // dom: "Bfrtip",
                    // buttons: [
                    //     "copyHtml5",
                    //     "excelHtml5",
                    //     "csvHtml5",
                    //     "pdfHtml5",
                    // ],
                });
            }
        });
    }
    getBranches();
})();
