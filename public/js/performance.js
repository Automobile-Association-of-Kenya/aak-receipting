(function () {
    const actualStartDate = $('#actualStartDate'),
        actualEndDate = $('#actualEndDate'),
        filterSalesForm = $('#filterSalesForm'),
        totalTarget = $("#totalTarget"),
        totalAchieved = $('#totalAchieved'),
        salesYearForMonthSummary = $('#salesYearForMonthSummary'),
        salesPerformanceForm = $('#salesPerformanceForm');

    function fetchTotalTarget() {
        $.getJSON('/sales-person', function (params) {
            console.log(params);
            let target = params?.overall_target == null ? 0 : params?.overall_target;
            totalTarget.text("Ksh. "+parseFloat(target).toFixed(0))
        });
    }
    fetchTotalTarget();

    actualStartDate.on('change', function (event) {
        fetchSalesByRange();
    })
    actualEndDate.on('change', function (event) {
        fetchSalesByRange();
    })

    function fetchSalesByRange() {
        let start_date = actualStartDate.val(),
            end_date = actualEndDate.val();
        $.post('/sales-filter', { _token: filterSalesForm.find("input[name='_token']").val(), start_date: start_date, end_date: end_date }).done(function (params) {
            let data = JSON.parse(params);
            totalAchieved.text("Ksh. "+data.value[0].Amounts)
        })
    }
    fetchSalesByRange();

    function getMonthlySales(year) {
        $.post('monthly-perfomance',
            { _token: salesPerformanceForm.find("input[name='_token']").val(), year: salesYearForMonthSummary.val() })
            .done(function (params) {
                const lineCtx = document.getElementById('lineChart').getContext('2d');
                if (Chart.getChart(lineCtx) !== undefined) {
                    Chart.getChart(lineCtx).destroy();
                }
                const labels = params.map((item) => item.month);
                const amounts = params.map((item) => item.amount);

                const lineChart = new Chart(lineCtx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Performance Achieved',
                            data: amounts,
                            borderColor: 'rgba(2, 79, 49, 0.85)',
                            backgroundColor: 'rgba(2, 79, 49, 0.1)',
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Months'
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Performance Achieved'
                                },
                                beginAtZero: true,
                                ticks: {
                                    callback: function (value) {
                                        return value.toLocaleString();
                                    }
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function (tooltipItem) {
                                        return 'Performance Achieved: ' + tooltipItem.raw.toLocaleString();
                                    }
                                }
                            }
                        }
                    }
                });
            })
    }

    getMonthlySales(salesYearForMonthSummary.val())

    salesYearForMonthSummary.on('change', function (event) {
        getMonthlySales($(this).val());
    });

})()

