$(document).ready(function() {
    $('#admin-table').DataTable({
        lengthChange: false,
        searching: false,
        ordering: false,
    });
    $('a[data-rel^=lightcase]').lightcase({
        maxWidth: 1920,
        maxHeight: 1200
    });
    $("#apartment_deleteImages").imagepicker({
        hide_select : true,
        show_label  : true
    });
    $('#edit-submit').click(function () {
        $("#loader").fadeIn('fast');
    })

} );
