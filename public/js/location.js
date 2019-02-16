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
});