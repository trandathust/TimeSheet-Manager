$(function () {
    $('#example2').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": false,
        "autoWidth": false,
        "responsive": false,
    });
});
$(function () {
    $('#example1').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": false,
        "autoWidth": false,
        "responsive": false,
    });
});


$(function () {
    'use strict'

    var ticksStyle = {
        fontColor: '#495057',
        fontStyle: 'bold'
    }

    var mode = 'index'
    var intersect = true

    var hour = $('#hour-chart').data('hour');
    var date_work = [];
    var total_hour = [];
    var confirm_hour = [];
    hour.forEach(function (element) {
        date_work.push(element.date_work);
        total_hour.push(element.total_hour);
        confirm_hour.push(element.confirm_hour);
    });

    var hourChart = $('#hour-chart')
    var hourChart = new Chart(hourChart, {
        data: {
            labels: date_work,
            datasets: [{
                labels: 'chưa xác nhận',
                type: 'line',
                data: total_hour,
                backgroundColor: 'transparent',
                borderColor: '#93979b',
                pointBorderColor: '#93979b',
                pointBackgroundColor: '#93979b',
                fill: false
                // pointHoverBackgroundColor: '#ced4da',
                // pointHoverBorderColor    : '#ced4da'
            },
            {
                labels: 'đã xác nhận',
                type: 'line',
                data: confirm_hour,
                backgroundColor: 'tansparent',
                borderColor: '#007bff',
                pointBorderColor: '#007bff',
                pointBackgroundColor: '#007bff',
                fill: false
                // pointHoverBackgroundColor: '#007bff',
                // pointHoverBorderColor    : '#007bff'
            }]
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
                    // display: false,
                    gridLines: {
                        display: true,
                        lineWidth: '4px',
                        color: 'rgba(0, 0, 0, .2)',
                        zeroLineColor: 'transparent'
                    },
                    ticks: $.extend({
                        beginAtZero: true,
                    }, ticksStyle)
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


    var salary = $('#salary-chart').data('salary');
    var total_money = [];
    var month = [];
    salary.forEach(function (element) {
        total_money.push(element.total_money);
        month.push('Tháng ' + element.month);
    });

    var salaryChart = $('#salary-chart')
    var salaryChart = new Chart(salaryChart, {
        type: 'bar',
        data: {
            labels: month,
            datasets: [
                {
                    backgroundColor: '#007bff',
                    borderColor: '#007bff',
                    data: total_money
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
                    // display: false,
                    gridLines: {
                        display: true,
                        lineWidth: '4px',
                        color: 'rgba(0, 0, 0, .2)',
                        zeroLineColor: 'transparent'
                    },
                    ticks: $.extend({
                        beginAtZero: true,

                        // Include a dollar sign in the ticks
                        callback: function (value, index, values) {
                            if (value >= 1000 && value < 1000000) {
                                value /= 1000
                                value += 'k'
                            }
                            if (value >= 1000000 && value < 1000000000) {
                                value /= 1000000
                                value += 'M'
                            }
                            if (value >= 1000000000) {
                                value /= 1000000000
                                value += 'Tỷ'
                            }
                            return value
                        }
                    }, ticksStyle)
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

    var project = $('#project-chart').data('project');
    var name = [];
    var count = [];
    var max = 0;
    var step_size = 2;
    project.forEach(function (element) {
        name.push(element.name);
        count.push(element.count);
    });
    //kiểm tra max để tính stepSize
    for (let i = 0; i < count.length; i++) {
        if (max <= count[i]) {
            max = count[i];
        };
    };
    if (max <= 10) {
        step_size = 2;
    } else if (10 < max <= 50) {
        step_size = 5;
    } else if (50 < max <= 100) {
        step_size = 10;
    } else if (100 < max <= 500) {
        step_size = 25;
    } else if (500 < max) {
        step_size = 50;
    };

    var projectChart = $('#project-chart')
    var projectChart = new Chart(projectChart, {
        type: 'bar',
        data: {
            labels: name,
            datasets: [
                {
                    backgroundColor: '#007bff',
                    borderColor: '#007bff',
                    data: count
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
                    // display: false,
                    gridLines: {
                        display: true,
                        lineWidth: '4px',
                        color: 'rgba(0, 0, 0, .2)',
                        zeroLineColor: 'transparent'
                    },
                    ticks: $.extend({
                        beginAtZero: true,
                        stepSize: step_size,
                        suggestedMax: max + step_size,


                        // Include a dollar sign in the ticks
                        callback: function (value, index, values) {
                            if (value >= 1000) {
                                value /= 1000
                                value += 'k'
                            }
                            return value + ' CTV'
                        }
                    }, ticksStyle)
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
