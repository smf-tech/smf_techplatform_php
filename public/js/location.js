$(document).ready(function () {
    var table = $('#location').DataTable({
        "ajax": "/getLocations",
        "ordering": false,
        "columns": [
            {
                data: null,
                defaultContent: '',
                className: 'select-checkbox',
                orderable: false
            },
            { data: "_id" },
            { data: "state.name" },
            { data: "district.name" },
            { data: "taluka.name" },
            { data: "village.name" }
        ],
        "columnDefs":[
            {"targets": [1], "visible": false, "searchable": false}
        ]
    });

    // $('#location tbody tr').prepend('<td><input type="checkbox"></td>');

    $('#location tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );
 
    $('#deleteRow').click( function () {
        table.row('.selected').remove().draw( false );
    } );
});