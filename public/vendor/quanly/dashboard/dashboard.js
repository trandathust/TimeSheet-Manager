$(function () {
    'use strict'

    var ticksStyle = {
        fontColor: '#495057',
        fontStyle: 'bold'
    }

    var mode = 'index'
    var intersect = true
    var project = $('#sales-chart').data('project');
    var name = [];
    var total_hour = [];
    var confirm_hour = [];
    var effective = [];
    var confirm_effective = [];

    project.forEach(function (element) {
        name.push(element.name);
        total_hour.push(element.total_hour);
        confirm_hour.push(element.confirm_hour);
        effective.push(element.effective);
        confirm_effective.push(element.confirm_effective);
    });
    var $salesChart = $('#sales-chart')
    var salesChart = new Chart($salesChart, {
        type: 'bar',
        data: {
            labels: name,
            datasets: [{
                yAxisID: 'first-y-axis',
                label: "Hiệu Quả",
                type: "line",
                backgroundColor: '#7d8286',
                borderColor: '#7d8286',
                data: effective,
                fill: false
            }, {
                yAxisID: 'first-y-axis',
                label: "Hiệu Quả Đã Xác Nhận",
                type: "line",
                backgroundColor: '#007bff',
                borderColor: '#007bff',
                data: confirm_effective,
                fill: false
            }, {
                yAxisID: 'second-y-axis',
                label: "Giờ Làm",
                type: "bar",
                backgroundColor: '#7d8286',
                borderColor: '#7d8286',
                data: total_hour,
            }, {
                yAxisID: 'second-y-axis',
                label: "Giờ Làm Đã Xác nhận",
                type: "bar",
                backgroundColor: '#007bff',
                borderColor: '#007bff',
                data: confirm_hour
            }
            ]
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                mode: mode,
                intersect: intersect
            },
            hover: {
                mode: mode,
                intersect: intersect
            },
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        display: true,
                        lineWidth: '4px',
                        color: 'rgba(0, 0, 0, .2)',
                        zeroLineColor: 'transparent'
                    },
                    id: 'first-y-axis',
                    display: true,
                    position: 'right',
                    ticks: {
                        beginAtZero: true
                    }
                }, {
                    id: 'second-y-axis',
                    display: true,
                    position: 'left',
                    ticks: {
                        beginAtZero: true,
                        stepSize: 10
                    }
                }],
                xAxes: [{
                    display: true,
                    gridLines: {
                        display: false
                    },
                    ticks: ticksStyle
                }]
            }
        }
    })
})
