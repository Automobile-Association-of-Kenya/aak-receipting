(function () {
    const todaysCustomerCount = $("#todaysCustomerCount"),
        customerSummary = $("#customerSummary"),
        totalCustomersCount = $("#totalCustomersCount"),
        todayPaymentsCount = $("#todayPaymentsCount"),
        paymentSummary = $("#paymentSummary"),
        totalPayments = $("#totalPayments"),
        todaysInvoicesCount = $("#todaysInvoicesCount"),
        invoicesSummary = $("#invoicesSummary"),
        todayUsersCount = $("#todayUsersCount"),
        usersSummary1 = $("#usersSummary1"),
        customersCount1 = $("#customersCount1");

    function getSummary() {
        $.getJSON("/summary", function (summary) {
            customersCount1.text(summary.members);
            todaysCustomerCount.text(summary.todaymembers + " Today");
            customerSummary.append(
                `<span class="text-success small pt-1 fw-bold">${summary.expiredmembers}</span> <span class="text-muted small pt-2 ps-1">Expired Customers</span>`
            );
            totalCustomersCount.text(summary.members);
            todayPaymentsCount.text(summary.todaypaymentscount + " Today");
            paymentSummary.append(
                `<span class="text-success small pt-1 fw-bold">${summary.todaypaymentstotal}</span> <span class="text-muted small pt-2 ps-1">Today Payments</span>`
            );
            todaysInvoicesCount.text(summary.todayivoicescount + " today");
            invoicesSummary.html(
                `<h6>${summary.invoicestotal}</h6><span class="text-success small pt-1 fw-bold">${summary.invoicetoday}</span> <span class="text-muted small pt-2 ps-1">Total Today</span>`
            );
            todayUsersCount.text(summary.userscounttoday + " Today");
            usersSummary1.html(`<h6>${summary.usercount}</h6>`);
            totalPayments.text(summary.totalpayments);
        });
    }
    getSummary();
})();
