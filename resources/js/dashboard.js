(function () {
    const todaysCustomerCount = $("#todaysCustomerCount"),
        customerSummary = $("#customerSummary"),
        totalCustomersCount = $("#totalCustomersCount"),
        todayPaymentsCount = $("#todayPaymentsCount"),
        paymentSummary = $("#paymentSummary"),
        totalPayments = $("#totalPayments");

    function getSummary() {
        $.getJSON("/summary", function (summary) {
            console.log(summary);
            todaysCustomerCount.text(summary.todaymembers + " Today");
            customerSummary.append(
                `<span class="text-success small pt-1 fw-bold">${summary.expiredmembers}</span> <span class="text-muted small pt-2 ps-1">Expired Customers</span>`
            );
            totalCustomersCount.text(summary.members);
            todayPaymentsCount.text(summary.todaypaymentscount + " Today");
            paymentSummary.append(
                `<span class="text-success small pt-1 fw-bold">${summary.todaypaymentstotal}</span> <span class="text-muted small pt-2 ps-1">Today Payments</span>`
            );
            totalPayments.text(summary.totalpayments);
        });
    }
    getSummary();
})();
