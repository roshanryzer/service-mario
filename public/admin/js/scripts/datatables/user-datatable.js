$(document).ready(function () {

    /************************************************
     *       js of select checkbox and Length        *
     ************************************************/

    $('#check-slct').DataTable({
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets: 0
        }],
        select: {
            style: 'os',
            selector: 'td:first-child'
        },
        order: [[1, 'asc']],

        "lengthMenu": [[5, 25, 50, -1], [5, 25, 50, "All"]],

        /**************************************
         *       js of Search Placeholder      *
         ***************************************/

        language: {
            search: "_INPUT_",
            "search": '<i class="fa fa-search"></i>',
            "searchPlaceholder": "search",
        }


    });


});

