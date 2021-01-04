$('.btn_submit').on('click', function (event) {
    $('.sub_error').hide();
    event.preventDefault();
    var _token = $("input[name='_token']").val();
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
                );
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
