$(function () {
    $('#table_timesheet').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": false,
        "autoWidth": false,
        "responsive": true,
    });
});
$(document).ready(function () {
    $('.btnprn').printPage();

    $("#myInput_table").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#table_timesheet_tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
