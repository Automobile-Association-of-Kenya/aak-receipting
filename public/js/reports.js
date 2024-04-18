(function () {
    departmentOptions("#reportDepartmentId");
    branchesOption("#reportBranchID");
    
    const generateReportsForm = $("#generateReportsForm"),
        reportDepartmentId = $("#reportDepartmentId"),
        reportDepartmentProductID = $("#reportDepartmentProductID"),
        reportStartDate = $("#reportStartDate"),
        reportEndDate = $("#reportEndDate"),
        reportBranchID = $("#reportBranchID");

    reportDepartmentId.on("change", function (event) {
        let department_id = $(this).val();
        $.getJSON(
            "/department-services/" + department_id,
            function (departments) {
                let option = `<option value="">Select Product</option>`;
                $.each(departments, function (key, value) {
                    option += `<option value="${value.id}">${value.name}</option>`;
                });
                reportDepartmentProductID.html(option);
            }
        );
    });

    generateReportsForm.on("submit", function (event) {
        event.preventDefault();
        const $this = $(this),
            data = {
                _token: $this.find("input[name='_token']").val(),
                department_id: reportDepartmentId.val(),
                product_id: reportDepartmentProductID.val(),
                start_date: reportStartDate.val(),
                end_date: reportEndDate.val(),
                branch_id: reportBranchID.val(),
            };
        $.post("reports-generete", data)
            .done(function (params) {
                console.log(params);
            })
            .fail(function (error) {
                console.error(error);
            });
    });
})();
