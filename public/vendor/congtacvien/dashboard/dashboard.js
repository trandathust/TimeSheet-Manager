$(function () {
    'use strict'

    var ticksStyle = {
        fontColor: '#495057',
        fontStyle: 'bold'
    }
    var mode = 'index'
    var intersect = true
    var hour = $('#work-chart').data('hour');
    var day = [];
    var total_hour = [];
    var confirm_hour = [];
    var effective = [];
    var confirm_effective = [];

    hour.forEach(function (element) {
        day.push(element.getDay);
        total_hour.push(element.total_hour);
        confirm_hour.push(element.confirm_hour);
        effective.push(element.effective);
        confirm_effective.push(element.confirm_effective);
    });
    var $workChart = $('#work-chart')
    var sworkChart = new Chart($workChart, {
        type: 'bar',
        data: {
            labels: day,
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
                        display: false,
                        lineWidth: '4px',
                        color: 'rgba(0, 0, 0, .2)',
                        zeroLineColor: 'transparent'
                    },
                    id: 'first-y-axis',
                    display: true,
                    position: 'right',
                    ticks: {
                        beginAtZero: true,
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

    //salary chart

    var salary = $('#salary-chart').data('salary');
    var month = [];
    var total_salary_of_month = [];

    salary.forEach(function (element) {
        month.push(element.month);
        total_salary_of_month.push(element.total_salary_of_month);
    });
    var $salaryChart = $('#salary-chart')
    var salaryChart = new Chart($salaryChart, {
        type: 'bar',
        data: {
            labels: month,
            datasets: [
                {
                    backgroundColor: '#007bff',
                    borderColor: '#007bff',
                    data: total_salary_of_month
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
                            if (value >= 1000000) {
                                value /= 1000000
                                value += 'M'
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


})


$('.btn_submit').on('click', function (event) {
    $('.sub_error').hide();
    event.preventDefault();
    var _token = $("input[name='_token']").val();
    var date_work = $('#date_work').val();
    var project_id = $('#project_id').val();
    var start_time = $('#start_time').val();
    var end_time = $('#end_time').val();
    var total_hour = $('#total_hour').val();
    var effective = $('#effective').val();
    var description = $('#description').val();
    let urlRequest = $(this).data('url');
    $.ajax({
        url: urlRequest,
        type: 'POST',
        data: {
            _token: _token,
            date_work: date_work,
            project_id: project_id,
            start_time: start_time,
            end_time: end_time,
            total_hour: total_hour,
            effective: effective,
            description: description,
        },
        success: function (data) {
            if (data.code == 200) {
                Swal.fire(
                    'Thành công',
                    'Thông tin timesheet đã được lưu lại!',
                    'success'
                ).then((result) => {
                    if (result.value) {
                        window.location.reload()
                    }
                });
            };
            if (data.code == 500) {

                Swal.fire(
                    'Thất bại',
                    'Lỗi trong quá trình thực hiện',
                    'warning'
                );

            };
            if (data.code == 700) {
                var message = data.message
                var i = data.i
                var el = $(document).find('[name="' + i + '"]');
                el.after($('<span class= "sub_error" style="color: red;">' + message + '</span>'));
            }
        },
        error: function (err) {
            if (err.status == 422) { // when status code is 422, it's a validation issue
                console.log(err.responseJSON);
                // $('#success_message').fadeIn().html(err.responseJSON.message);

                // you can loop through the errors object and show it to the user
                console.warn(err.responseJSON.errors);
                // display errors on each form field
                $.each(err.responseJSON.errors, function (i, error) {
                    var el = $(document).find('[name="' + i + '"]');
                    el.after($('<span class= "sub_error" style="color: red;">' + error[0] + '</span>'));
                });
            }
        }
    });
});

$(function () {
    $('#table_timesheet').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": false,
        "autoWidth": false,
        "responsive": false,
    });
});

