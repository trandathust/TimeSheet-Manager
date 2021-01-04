function actionDelete(event) {
    event.preventDefault();
    let urlRequest = $(this).data('url');

    let that = $(this);
    Swal.fire({
        title: 'Xác nhận xóa?',
        // text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xác nhận'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: 'GET',
                url: urlRequest,
                success: function (data) {
                    if (data.code == 200) {
                        that.parent().parent().remove();
                        Swal.fire(
                            'Thành Công!',
                            'Thông tin Timesheet đã được xóa',
                            'success'
                        )
                    }
                },
                error: function () {
                }

            });
        }
    });
};
$(function () {
    $(document).on('click', '.action_delete', actionDelete);

});
