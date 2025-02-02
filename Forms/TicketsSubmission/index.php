<?php
include '../../Library/SessionManager.php';
$session = new SessionManager();
require '../../Library/DBHelper.php';
    $DB = new DBHelper();
    $collection_array = $DB->GET_COLLECTION_FOR_DROPDOWN();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Submit Ticket</title>

    <link rel = "stylesheet" type = "text/css" href = "../../Master/master.css" >
    <script type="text/javascript" src="../../ExtLibrary/jQuery-2.2.3/jquery-2.2.3.min.js"></script>
    <style type="text/css">
        .Error_Input{margin-left: 10%; margin-top: 0%; background-color: #f1f1f1; border-radius: 10px; background-color: #f1f1f1; border-radius: 2px;  box-shadow: 0px 0px 3px #0c0c0c; padding-left: 8%; margin-right: 10%; padding-bottom: 5%; padding-top: 2.5%;}
        nav{margin: -1px 0px 40px 15px !important;}
        nav{margin-left: 8px;
          margin-top: 22px;}
    </style>
</head>

<body>
    <div id="wrap">
        <div id="main">
            <div id="divleft">
                <?php include '../../Master/header.php';
                include '../../Master/sidemenu.php';?>
            </div>
            <div id="divright">
                <h2 id="page_title">Error reporting</h2>

            <div id="divscroller" class= "Error_Input" >
                <h3>Database Name:</h3>
                <form name="frm_ticket" id="frm_ticket" method="post">
                <select name="ddlDBname" id="ddlDBname" required>
                    <option value="">Select</option>
                    <?php
                        foreach($collection_array as $col)
                            echo "<option value='" . $col['collectionID'] .  "'>$col[displayname]</option>";
                    ?>
                </select>
                <h3>Library Index:</h3>
                <div class="divSubject" id="divSubject0">
                    <input type = "text" class="txtSubject" name = "txtSubject" id = "txtSubject0" size="32" required/>
                    <input type="button" onclick="add_fields($(':text').length, null)" value="+">
                    <input type="button" onclick="remove_fields($(':text').length)" value="-">
                </div>


                <h3>What's wrong?</h3>
                <textarea name = "txtDesc" id="txtDesc" rows = "10" cols = "70" required/></textarea>

                <br><input type = "submit" name = "btnSubmit" value = "Submit" class="bluebtn"/>
                </form>
            </div>
            </div>
        </div>
    <!--End of new user input form-->
<?php include '../../Master/footer.php'; ?>
</body>
<script>

    //Window Height
    var windowHeight = window.innerHeight;
    $('#divscroller').height(windowHeight - (windowHeight * 0.3));

    $(window).resize(function (event) {
        windowHeight = event.target.innerHeight;
        $('#divscroller').height(windowHeight - (windowHeight * 0.3));
    });

    var libArray = [];
    $( document ).ready(function() {
        /* attach a submit handler to the form */
        $('#frm_ticket').submit(function (event) {
            /* stop form from submitting normally */
            event.preventDefault();
            /*Converts the list of Library indexes into a JSON format*/
            $.each($(".txtSubject"), function (index, libIndex) {
                libArray.push({"libraryIndex": libIndex.value});
            });
            var strLib = JSON.stringify(libArray);

            /* Send the data using post */
            $.ajax({
                type: 'post',
                url: 'index_processing.php',
                data: {dbname: $('#ddlDBname :selected').val(), subject: $('.txtSubject').val(), description: $('#txtDesc').val(), libIndex: strLib},
                success:function(data){
                    if(data == "true")
                    {
                        alert("Ticket Submitted!");
                        window.close();
                    }
                    else alert("Ticket failed to submit!");
                }
            });
        });
    });

    /**********************************************
     * Function: add_fields
     * Description: adds more fields for authors
     * Parameter(s): length (integer) Length of Author's cells
     * val (String ) - name of the author
     * Return value(s): None
     ***********************************************/

    function add_fields(length, val) {
        if (val == null)
            val = "";
        $('#divSubject' + (length - 1)).after('' +
         '<div class="divSubject" id="divSubject' + length + '" style="margin-top: 2%">' +
         '<input type = "text" class="txtSubject" name = "txtSubject" id = "txtSubject0" size="32" value="' + val + '" required/>' +
         '</div>');
    }
    
    function remove_fields(length) {
        if(length < 2)
            return false;
        $(".divSubject").last().remove();
    }

</script>
</html>