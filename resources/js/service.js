(function () {
    const departmentID = $("#departmentID"),
        serviceID = $("#serviceID");

    departmentID.on("change", function () {
        let department_id = $(this).val();
        $.getJSON("/department-services/" + department_id, function (services) {
            let option = "<option value=''>Select Service</option>";
            $.each(services, function (key, value) {
                option += `<option value="${value.id}">${value.name}</option>`;
            });
            serviceID.html(option);
        });
    });
})();
