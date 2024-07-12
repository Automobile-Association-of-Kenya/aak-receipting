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
        customersCount1 = $("#customersCount1"),
        todayCustomerCount = $("#todayCustomerCount");

    function getSummary() {
        $.getJSON("/summary", function (summary) {
            console.log(summary);
            customersCount1.text(summary.members);
            todaysCustomerCount.text(summary.todaymembers + " Today");
            todayCustomerCount.text(summary.todaymembers);
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
            usersSummary1.html(
                `<h6>${summary.usercount}</h6><span class="text-success small pt-1 fw-bold">${summary.userscounttoday}</span> <span class="text-muted small pt-2 ps-1">Today</span>`
            );
            totalPayments.text(summary.totalpayments);
        });
    }
    getSummary();

    function getTransactionsSummary() {
        var currentYear = new Date().getFullYear();
        $.getJSON("invoices-payments-summary/" + currentYear, function (data) {
            const ctx = document
                .getElementById("transactionsSummary")
                .getContext("2d");
            if (Chart.getChart(ctx) !== undefined) {
                Chart.getChart(ctx).destroy();
            }
            let invoicetotal = 0;
            let paymenttotal = 0;
            $.each(data, function (key, value) {
                invoicetotal += parseFloat(value.invoices);
                paymenttotal += parseFloat(value.payments);
            });

            const labels = data.map((item) => item.month);
            const invoices = data.map((item) => item.invoices || 0);
            const payments = data.map((item) => item.payments || 0);

            const invoicePaymentsChart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: "Invoices",
                            data: invoices,
                            backgroundColor: "#fed925",
                            borderWidth: 1,
                        },
                        {
                            label: "Payments",
                            data: payments,
                            backgroundColor: "#006544",
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                },
            });
        });
    }

    getTransactionsSummary();
})();
