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

});
