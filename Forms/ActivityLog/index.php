<?php
//for admin use only
include '../../Library/SessionManager.php';
$session = new SessionManager();

if($session->isAdmin()) {
    require('../../Library/DBHelper.php');
    $DB = new DBHelper();
}
else header('Location: ../../');
require('../../Library/ControlsRender.php');
$Render = new ControlsRender();

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Activity Log</title>

    <link rel = "stylesheet" type = "text/css" href = "../../Master/master.css" >
    <link rel = "stylesheet" type="text/css" href="../../ExtLibrary/DataTables-1.10.12/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="../../ExtLibrary/jQuery-2.2.3/jquery-2.2.3.min.js"></script>
    <script type="text/javascript" src="../../ExtLibrary/DataTables-1.10.12/js/jquery.dataTables.min.js"></script>
    <script>
        function SSP_DataTable(collection)
        {
            var table = $('#dtable').DataTable( {
                "processing": true,
                "serverSide": true,
                "lengthMenu": [20, 40 , 60, 80, 100],
                "bStateSave": false,
                "destroy": true,
                "order": [[ 0, "desc" ]],
                "ajax": "activitylog_processing.php?col=" + collection,
                "columnDefs": [
                    //column Document Index: Replace with Hyperlink
                    {
                        "render": function ( data, type, row) {
                            
                            return data;
                        },
                        "targets": 6
                    },
                ],
                "initComplete": function() {
                    this.api().columns().every( function () {
                        var column = this;
                        switch(column[0][0]) //column number
                        {
                            case 1:
                            case 2:
                            case 3:
                            case 4:
                            case 5:
                            case 6:
                                var input = $('<input type="text" style="width:100%" placeholder="Search..." value=""></input>')
                                    .appendTo( $(column.footer()).empty() )
                                    .on( 'keyup change', function () {
                                        var val = $.fn.dataTable.util.escapeRegex(
                                            $(this).val()
                                        );

                                        column
                                            .search(val)
                                            .draw();
                                    } );
                                break;
                        }
                    } );
                },
            } );

            //hide first column (LogID)
            table.column(0).visible(false);


            // select row on single click
            $('#dtable tbody').on( 'click', 'tr', function () {
                if ( $(this).hasClass('selected') ) {
                    $(this).removeClass('selected');
                }
                else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            } );
            //resize height of the scroller
            $("#divscroller").height($(window).outerHeight() - $(footer).outerHeight() - $("#table-header_right").outerHeight() - $("#page_title").outerHeight() - 55);
        }

        $(document).ready(function() {
            $( "#ddlCollection" ).change(function()
            {
                switch ($("#ddlCollection").val())
                {
                    case "": break;
                    default: SSP_DataTable($("#ddlCollection").val());
                }
            });

        });
    </script>
</head>
<body>
<div id="wrap">
    <div id="main">
                <div id="divleft">
                    <?php include '../../Master/header.php';
                    include '../../Master/sidemenu.php' ?>
                </div>
                <div id="divright">
                    <h2 id="page_title">Activity Log</h2>
                    <div id="#table-header_right"><label>Select Database:&nbsp; </label><select name="ddlCollection" id="ddlCollection"><?php $Render->GET_DDL_COLLECTION($DB->GET_COLLECTION_FOR_DROPDOWN(),null); ?></select></div>
                    <div id="divscroller">

                        <table id="dtable" class="display compact cell-border hover stripe" cellspacing="0" width="100%" data-page-length='20'>
                            <thead>
                            <tr>
                                <th width="35px">ID</th>
                                <th width="130px">Timestamp</th>
                                <th width="100px">Action</th>
                                <th width="150px">Library Index</th>
                                <th width="100px">Username</th>
                                <th>Notes</th>
                                <th id="AuthorNameDTColumn">Author Name</th>

                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
    </div>
</div>
<?php include '../../Master/footer.php'; ?>
</body>
<script>

</script>
</html>
