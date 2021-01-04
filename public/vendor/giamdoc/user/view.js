$(function () {
    $('#table_1').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "info": false
    });
});
$(function () {
    $('#table_2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "info": false
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
                            'Xóa người dùng thành công',
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



$("select[name='select_id']").change(function () {

    var id = $('#id').val();
    var select = $(this).val();
    var _token = $("input[name='_token']").val();
    let urlRequest = $(this).data('url');
    $.ajax({
        url: urlRequest,
        method: 'POST',
        data: {
            id: id,
            status: select,
            _token: _token
        },
        success: function (data) {
            if (data.code == 200) {
                Swal.fire(
                    'Thành Công!',
                    'Trạng thái người dùng đã thay đổi',
                    'success'
                );
            }
        }
    });
});

$(document).ready(function () {
    $("#myInput_table").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#table_1_tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});


$(document).ready(function () {
    $("#myInput").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#table_2_tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
