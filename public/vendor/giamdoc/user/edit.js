$("select[name='manager']").change(function () {
    var select = $(this).val();
    let urlRequest = $(this).data('url');
    $.ajax({
        url: urlRequest,
        method: 'GET',
        data: {
            select: select,
        },
        success: function (data) {
            if (data.code == 200) {
                var listProject = data.listProject;
                $('#projects').empty()
                for (var i = 0; i < listProject.length; i++) {
                    var html = [];
                    html += '<option value="' + listProject[i]['id'] + '">' + listProject[i]['name'] + '</option>';
                    $('#projects').append(html);

                }
            }
        }
    });
});
