$(document).ready(function () {

    "use strict";
    
    var lang = $("html").attr("lang");

    $('#datatable1').DataTable({language: { url:"../../plugins/datatables/i18n/"+lang+".json" }});

    $('#datatable2').DataTable({
        language: { url:"../../plugins/datatables/i18n/"+lang+".json" },
        "scrollY": "300px",
        "scrollCollapse": true,
        "paging": false
    });

    $('#datatable3').DataTable({
        language: { url:"../../plugins/datatables/i18n/"+lang+".json" },
        "scrollX": true
    });

    $('#datatable4 tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" class="form-control" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#datatable4').DataTable({
        language: { url:"../../plugins/datatables/i18n/"+lang+".json" },
        initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;
 
                $( 'input', this.footer() ).on( 'keyup change clear', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        }
    });
});