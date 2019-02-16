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
            { data: "State" },
            { data: "District" },
            { data: "Taluka" },
            { data: "Village" }
        ],
        "columnDefs":[
            {"targets": [1], "visible": false, "searchable": false}
        ]
    });
});