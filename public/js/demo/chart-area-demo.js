
Chart.defaults.global.defaultFontFamily =
    'Nunito, -apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';

Chart.defaults.global.defaultFontColor = '#6b7280';

function number_format(number) {
    return new Intl.NumberFormat('id-ID').format(number);
}

var ctx = document.getElementById('myAreaChart');

if (ctx) {
    new Chart(ctx, {
        type: 'line',

        data: {
            labels: window.sipklinChartLabels || [
                'Jan', 'Feb', 'Mar', 'Apr',
                'Mei', 'Jun', 'Jul', 'Agu',
                'Sep', 'Okt', 'Nov', 'Des'
            ],

            datasets: [{
                label: 'Kunjungan Pasien',
                lineTension: 0.3,
                backgroundColor: 'rgba(6, 40, 92, 0.10)',
                borderColor: '#06285c',
                pointRadius: 3,
                pointBackgroundColor: '#f6c343',
                pointBorderColor: '#06285c',
                pointHoverBackgroundColor: '#f6c343',
                pointHoverBorderColor: '#06285c',
                pointHitRadius: 10,
                pointBorderWidth: 2,
                fill: true,

                // Sementara 0, nanti dihubungkan ke database.
                data: window.sipklinChartValues || [
                    0, 0, 0, 0, 0, 0,
                    0, 0, 0, 0, 0, 0
                ]
            }]
        },

        options: {
            maintainAspectRatio: false,

            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 15,
                    bottom: 0
                }
            },

            scales: {
                xAxes: [{
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 12
                    }
                }],

                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        precision: 0,
                        maxTicksLimit: 5,
                        padding: 10,
                        callback: function(value) {
                            return number_format(value);
                        }
                    },

                    gridLines: {
                        color: 'rgb(234, 236, 244)',
                        drawBorder: false,
                        borderDash: [2]
                    }
                }]
            },

            legend: {
                display: false
            },

            tooltips: {
                backgroundColor: '#ffffff',
                bodyFontColor: '#6b7280',
                titleFontColor: '#06285c',
                borderColor: '#dddfeb',
                borderWidth: 1,
                displayColors: false,

                callbacks: {
                    label: function(tooltipItem, chart) {
                        var label =
                            chart.datasets[tooltipItem.datasetIndex].label || '';

                        return label + ': ' +
                            number_format(tooltipItem.yLabel);
                    }
                }
            }
        }
    });
}
