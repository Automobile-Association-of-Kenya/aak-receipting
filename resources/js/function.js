function showSuccess(message, target) {
    iziToast.success({
        title: "OK",
        message: message,
        position: "center",
        timeout: 7000,
        target: target,
    });
}

function showError(message, target) {
    iziToast.error({
        title: "Error",
        message: message,
        position: "center",
        timeout: 7000,
        target: target,
    });
}

function membersOption(target) {
    $.getJSON("/members-data", function (members) {
        let option = `<option value="NULL">Select Member</option>`;
        $.each(members, function (key, value) {
            option += `<option value="${value.id}">${value.idNo+" "+
                value.firstName +
                " " +
                value.secondName +
                " " +
                value.surNameName
            }</option>`;
        });
        $(target).html(option);
    });
}

function productOptions(target) {
    $.getJSON("/products-data", function (products) {
        let option = `<option value="NULL">Select Product</option>`;
        $.each(products, function (key, value) {
            option += `<option value="${value.id}">${value.name}</option>`;
        });
        $(target).html(option);
    });
}

function departmentOptions(target) {
    $.getJSON("/departments-data", function (departments) {
        let option = `<option value="NULL">Select Department</option>`;
        $.each(departments, function (key, value) {
            option += `<option value="${value.id}">${value.name}</option>`;
        });
        $(target).html(option);
    });
}
