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
        let option = `<option value="NULL">Select Client</option>`;
        $.each(members, function (key, value) {
            let firstName =
                value.firstName == null ||
                    value.firstName == undefined
                    ? ""
                    : value.firstName,
                secondName =
                    value.secondName == null ||
                        value.secondName == undefined
                        ? ""
                        : value.secondName,
                idNo =
                    value.idNo == null ||
                        value.idNo == undefined
                        ? ""
                        : value.idNo,
                surNameName =
                    value.surNameName == null ||
                        value.surNameName == undefined
                        ? ""
                        : value.surNameName;
            option += `<option value="${value.id}">${
                idNo +
                " " +
                firstName +
                " " +
                secondName +
                " " +
                surNameName
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

function branchesOption(target) {
    $.getJSON("/branches-data", function (branches) {
        let option = `<option value="NULL">Select Branch</option>`;
        $.each(branches, function (key, value) {
            option += `<option value="${value.id}">${value.name}</option>`;
        });
        $(target).html(option);
    });
}
