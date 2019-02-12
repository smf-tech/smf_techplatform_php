$(document).ready(function () {
    $('#location').DataTable({
        "ajax": "/getLocations",
        "ordering": false,
        columns: [
            {
                data: null,
                defaultContent: '',
                className: 'select-checkbox',
                orderable: false
            },
            { data: "state" },
            { data: "district" },
            { data: "taluka" },
            { data: "village" }
        ]
    });
});