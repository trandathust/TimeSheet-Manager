$(function () {
    $('#table_project').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": false,
        "autoWidth": false,
        "responsive": true,
    });
});


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
                            'Đã Xóa!',
                            'Xóa đơn hàng thành công.',
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

$("select[name='status']").change(function () {
    var id = $(this).closest("tr").find('#id').val();
    var name = $(this).closest("tr").find('#name').val();
    var description = $(this).closest("tr").find('#description').val();
    var start_time = $(this).closest("tr").find('#start_time').val();
    var end_time = $(this).closest("tr").find('#end_time').val();
    var status = $(this).val();
    var _token = $("input[name='_token']").val();
    let urlRequest = $(this).data('url');
    $.ajax({
        url: urlRequest,
        method: 'POST',
        data: {
            id: id,
            name: name,
            description: description,
            start_time: start_time,
            end_time: end_time,
            status: status,
            _token: _token
        },
        success: function (data) {
            if (data.code == 200) {
                Swal.fire(
                    'Thành Công!',
                    'Trạng thái dự án đã thay đổi',
                    'success'
                );
            }
            if (data.code == 700) {
                Swal.fire(
                    'Thất Bại!',
                    'Hãy sửa ngày kết thúc dự án trước!',
                    'warning'
                );
            }
        }
    });
});


$(document).ready(function () {
    $("#myInput").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#table_project_tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
