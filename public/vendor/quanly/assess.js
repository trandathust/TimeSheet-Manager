$(function () {
    $('#table_assess').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": false,
        "autoWidth": false,
        "responsive": false,
    });
});

$(function () {
    $('#table_assess_2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": false,
        "autoWidth": false,
        "responsive": false,
    });
});


$(document).ready(function () {
    $("#myInput_table").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#table_assess_tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});


$(document).ready(function () {
    $("#myInput").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#table_assess_2_tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});


$('.btn_submit').on('click', function (event) {
    $('.sub_error').hide();
    event.preventDefault();
    var _token = $("input[name='_token']").val();
    var confirm_hour = $(this).closest("tr").find('#confirm_hour').val();
    var confirm_effective = $(this).closest("tr").find('#confirm_effective').val();
    let urlRequest = $(this).data('url');
    $.ajax({
        url: urlRequest,
        type: 'POST',
        data: {
            _token: _token,
            confirm_effective: confirm_effective,
            confirm_hour: confirm_hour,
        },
        success: function (data) {
            if (data.code == 200) {
                var message = data.message;
                Swal.fire(
                    'Thành công',
                    message,
                    'success'
                );
            };
            if (data.code == 700) {
                var message = data.message;
                Swal.fire(
                    'Thất bại',
                    message,
                    'warning'
                );
            };
            if (data.code == 500) {

                Swal.fire(
                    'Thất bại',
                    'Lỗi trong quá trình thực hiện',
                    'warning'
                );

            };
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


$("input:checkbox[name=status]").change(function () {
    var status = $(this).val();
    var _token = $("input[name='_token']").val();
    var confirm_hour = $(this).closest("tr").find('#confirm_hour_hidden').val();
    var confirm_effective = $(this).closest("tr").find('#confirm_effective_hidden').val();
    var status_manager = $(this).closest("tr").find('#status').val();
    let urlRequest = $(this).data('url');
    $.ajax({
        url: urlRequest,
        type: 'POST',
        data: {
            _token: _token,
            confirm_effective: confirm_effective,
            confirm_hour: confirm_hour,
            status_manager: status_manager,
        },
        success: function (data) {
            if (data.code == 200) {
                Swal.fire(
                    'Thành công',
                    'Trạng thái timesheet đã thay đổi!',
                    'success'
                ).then((result) => {
                    if (result.value) {
                        window.location.reload();
                    }
                });
            };
            if (data.code == 700) {
                var message = data.message;
                Swal.fire(
                    'Thất bại',
                    message,
                    'warning'
                ).then((result) => {
                    if (result.value) {
                        window.location.reload();
                    }
                });
            };
        }
    });
});

$('.btn_submit_change').on('click', function (event) {
    $('.sub_error').hide();
    event.preventDefault();
    var _token = $("input[name='_token']").val();
    var confirm_hour = $(this).closest("tr").find('#confirm_hour').val();
    var confirm_effective = $(this).closest("tr").find('#confirm_effective').val();
    var status_manager = $(this).closest("tr").find('#status').val();
    let urlRequest = $(this).data('url');
    $.ajax({
        url: urlRequest,
        type: 'POST',
        data: {
            _token: _token,
            confirm_effective: confirm_effective,
            confirm_hour: confirm_hour,
            status_manager: status_manager,
        },
        success: function (data) {
            if (data.code == 200) {

                Swal.fire(
                    'Thành công',
                    'Thông tin timesheet đã được lưu lại!',
                    'success'
                ).then((result) => {
                    if (result.value) {
                        window.location.reload();
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
