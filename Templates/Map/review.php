<?php
include '../../Library/SessionManager.php';
$session = new SessionManager();
if(isset($_GET['col']) && isset($_GET['doc'])) {
    $collection = $_GET['col'];
    $docID = $_GET['doc'];
    require('../../Library/ControlsRender.php');
    $Render = new ControlsRender();
    require('../../Library/DBHelper.php');
    $DB = new DBHelper();
    $config = $DB->SP_GET_COLLECTION_CONFIG($collection);
    $document = $DB->SP_TEMPLATE_MAP_DOCUMENT_SELECT($collection,$docID);
    //var_dump($document);
}
else header('Location: ../../');

include '../../Library/DateHelper.php';
$date = new DateHelper();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Review Form</title>
    <link rel = "stylesheet" type = "text/css" href = "../../Master/master.css" >
    <script type="text/javascript" src="../../ExtLibrary/jQuery-2.2.3/jquery-2.2.3.min.js"></script>

</head>
<body>
<table id = "thetable">
    <tr>
        <td class="menu_left" id="thetable_left">
            <?php include '../../Master/header.php';
            include '../../Master/sidemenu.php' ?>
        </td>
        <td class="Account" id="thetable_right">
            <h2><?php echo $config['DisplayName'];?> Review Form</h2>
            <div id="div_scroller">
                <form id="theform" name="theform" method="post">
            <table id="table2">
                    <tr>
                        <td>
                                <span class="label"><span style = "color:red;"> * </span>Library Index:</span>
                        </td>
                        <td>
                                <input type = "text" name = "txtLibraryIndex" id = "txtLibraryIndex" size="26" value="<?php echo $document['LibraryIndex']; ?>" required="true" />
                        </td>
                        <td>
                            <span class="label">Customer Name:</span>
                        </td>
                        <td>
                            <input type = "text" list="lstCustomer" name = "txtCustomer" id = "txtCustomer" size="26" value="<?php echo $document['CustomerName']; ?>" />
                            <datalist id="lstCustomer">
                                <?php $Render->getDataList($DB->GET_CUSTOMER_LIST($collection)); ?>
                            </datalist>
                        </td>
                        <tr>
                            <td> <span class="label"><span style = "color:red;"> * </span>Document Title:</span></td>
                            <td><input type = "text" name = "txtTitle" id = "txtTitle" size="26" value="<?php echo $document['Title']; ?>" required />
                            </td>
                            <td>
                                <span class="label">Document Start Date:</span>
                            </td>
                            <td>
                                <select name="ddlStartMonth" id="ddlStartMonth" style="width:60px">
                                    <?php $Render->GET_DDL_MONTH($date->splitDate($document['StartDate'])['Month']); ?>
                                </select>
                                <select name="ddlStartDay" id="ddlStartDay" style="width:60px">
                                    <?php $Render->GET_DDL_DAY($date->splitDate($document['StartDate'])['Day']); ?>
                                </select>
                                <select id="ddlStartYear" name="ddlStartYear" style="width:85px">
                                    <?php $Render->GET_DDL_YEAR($date->splitDate($document['StartDate'])['Year']); ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="label">Document Subtitle:</span>
                            </td>
                            <td>
                                <input type = "text" name = "txtSubtitle" id = "txtSubtitle" size="26" value="<?php echo $document['Subtitle']; ?>" />
                            </td>
                            <td>
                                <span class="label">Document End Date:</span>
                            </td>
                            <td>
                                <select name="ddlEndMonth" id="ddlEndMonth" style="width:60px">
                                    <?php $Render->GET_DDL_MONTH($date->splitDate($document['EndDate'])['Month']); ?>
                                </select>
                                <select name="ddlEndDay" id="ddlEndDay" style="width:60px">
                                    <?php $Render->GET_DDL_DAY($date->splitDate($document['EndDate'])['Day']); ?>
                                </select>
                                <select name="ddlEndYear" id="ddlEndYear" style="width:85px">
                                    <?php $Render->GET_DDL_YEAR($date->splitDate($document['EndDate'])['Year']); ?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td><span class="label">Map Scale:</span></td>
                            <td> <input type = "text" name = "txtMapScale" id = "txtMapScale" size="26" value="<?php echo $document['MapScale']; ?>"  />
                            </td>
                            <td>
                                <span class="label">Field Book Number:</span>
                            </td>
                            <td>
                                <input type = "text" name = "txtFieldBookNumber" id = "txtFieldBookNumber" size="26" value="<?php if($document['FieldBookNumber'] != 0 && $document['FieldBookNumber'] != null) {echo $document['FieldBookNumber'];} ?>"/><span class = "errorInput" id = "customernameErr"></span>
                            </td>
                        </tr>

                         <tr>
                             <td><span class="labelradio"><mark>Is Map:</mark><p hidden><b></b>This is to signal if it is a map</p></span>
                             </td>
                             <td>
                                 <input type = "radio" name = "rbIsMap" id = "rbIsMap_yes" size="26" value="1" <?php if($document['IsMap'] == 1) echo "checked"; ?>/>Yes
                                 <input type = "radio" name = "rbIsMap" id = "rbIsMap_no" size="26" value="0"  <?php if($document['IsMap'] == 0) echo "checked"; ?>/>No
                             </td>
                             <td><span class="label">Field Book Page:</span></td>
                             <td><input type = "text" name = "txtFieldBookPage" id = "txtFieldBookPage" size="26" value="<?php echo $document['FieldBookPage']; ?>" />
                             </td>
                         </tr>
                        <tr>
                            <td>
                                <span class="labelradio" ><mark>Needs Review:</mark><p hidden><b></b>This is to signal if a review is needed</p></span>
                            </td>
                            <td>
                                <input type = "radio" name = "rbNeedsReview" id = "rbNeedsReview_yes" size="26" value="1" <?php if($document['NeedsReview'] == 1) echo "checked"; ?>/>Yes
                                <input type = "radio" name = "rbNeedsReview" id = "rbNeedsReview_no" size="26" value="0" <?php if($document['NeedsReview'] == 0) echo "checked"; ?>/>No
                            </td>
                            <td>
                                <?php $readrec = array("POOR","GOOD","EXCELLENT"); ?>
                                <span class="label"><span style = "color:red;"> * </span>Readability:</span>
                            </td>
                            <td>
                                <select id="ddlReadability" name="ddlReadability" required style="width:215px">
                                    <?php
                                    $Render->GET_DDL2($readrec,$document['Readability']);
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                                <td><span class="labelradio"><mark>Has North Arrow:</mark><p hidden><b></b>This is to signal if it has a North Arrow</p></span>
                                </td>
                                <td>
                                    <input type = "radio" name = "rbHasNorthArrow" id = "rbHasNorthArrow_yes" size="26" value="1" <?php if($document['HasNorthArrow'] == 1) echo "checked"; ?>/>Yes
                                    <input type = "radio" name = "rbHasNorthArrow" id = "rbHasNorthArrow_no" size="26" value="0"  <?php if($document['HasNorthArrow'] == 0) echo "checked"; ?>/>No
                                </td>
                                <td>
                                     <span class="label"><span style = "color:red;"> * </span>Rectifiability:</span>
                                </td>
                                <td>
                                <select id="ddlRectifiability" name="ddlRectifiability" required style="width:215px">
                                    <?php
                                    $Render->GET_DDL2($readrec,$document['Rectifiability']);
                                    ?>
                                </select>
                                </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="labelradio"><mark>Has Street:</mark><p hidden><b></b>This is to signal if a Street(s) are present</p></span>
                            </td>
                            <td>
                                <input type = "radio" name = "rbHasStreets" id = "rbHasStreets_yes" size="26" value="1" <?php if($document['HasStreets'] == 1) echo "checked"; ?>/>Yes
                                <input type = "radio" name = "rbHasStreets" id = "rbHasStreets_no" size="26" value="0" <?php if($document['HasStreets'] == 0) echo "checked"; ?> />No
                            </td>
                            <td>
                                <span class="label">Company Name:</span>

                            </td>
                            <td>
                                <input type = "text" list="lstCompany" name = "txtCompany" id = "txtCompany" size="26" value="<?php echo $document['CompanyName'];?>" />
                                <datalist id="lstCompany">
                                    <?php $Render->getDataList($DB->GET_COMPANY_LIST($collection)); ?>
                                </datalist>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="labelradio"><mark>Has POI:</mark><p hidden><b></b>This is to signal if a Point of Interest is present</p></span>
                            </td>
                            <td>
                                <input type = "radio" name = "rbHasPOI" id = "rbHasPOI_yes" size="26" value="1" <?php if($document['HasPOI'] == 1) echo "checked"; ?>/>Yes
                                <input type = "radio" name = "rbHasPOI" id = "rbHasPOI_no" size="26" value="0"  <?php if($document['HasPOI'] == 0) echo "checked"; ?>/>No
                            </td>
                            <td>
                                <span class="label">Document Type:</span>
                            </td>
                            <td>
                                <input type = "text" name = "txtType" id = "txtType" size="26" value="<?php echo $document['Type'];?>" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="labelradio"><mark>Has Coordinates:</mark><p hidden><b></b>This is to signal if Coordinates are visible</p></span>
                            </td>
                            <td>
                                <input type = "radio" name = "rbHasCoordinates" id = "rbHasCoordinates_yes" size="26" value="1" <?php if($document['HasCoordinates'] == 1) echo "checked"; ?> />Yes
                                <input type = "radio" name = "rbHasCoordinates" id = "rbHasCoordinates_no" size="26" value="0"  <?php if($document['HasCoordinates'] == 0) echo "checked"; ?>/>No
                            </td>
                            <td>
                                <span class="label"><span style = "color:red;"> * </span>Document Medium:</span>
                            </td>
                            <td>
                                <select id="ddlMedium" name="ddlMedium" style="width:215px" required>
                                    <?php
                                    $Render->GET_DDL($DB->GET_TEMPLATE_MAP_MEDIUM_FOR_DROPDOWN($collection),$document['Medium']);
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="labelradio"><mark>Has Coast:</mark><p hidden><b></b>This is to signal if a Coast line is present</p></span>
                            </td>
                            <td>
                                <input type = "radio" name = "rbHasCoast" id = "rbHasCoast_yes" size="26" value="1" <?php if($document['HasCoast'] == 1) echo "checked"; ?>/>Yes
                                <input type = "radio" name = "rbHasCoast" id = "rbHasCoast_no" size="26" value="0" <?php if($document['HasCoast'] == 0) echo "checked"; ?> />No
                            </td>
                            <td>
                                <span class="label">Document Author:</span>
                            </td>
                            <td>
                                <input type = "text" list="lstAuthor" name = "txtAuthor" id = "txtAuthor" size="26" value="<?php echo $document['AuthorName']; ?>" /></span>
                                <datalist id="lstAuthor">
                                    <?php $Render->getDataList($DB->GET_AUTHOR_LIST($collection)); ?>
                                </datalist>
                            </td>
                        </tr>
                        <tr style="vertical-align: top">
                            <td>
                                <span class="label"><span style = "color:red;"> * </span>Scan Of Front:</span>

                            </td>
                            <td style="text-align:center">
                                <?php echo "<a href=\"download.php?file=$config[StorageDir]$document[FileNamePath]\">(Click to download)</a><br>";
                                echo "<a id='download_front' href=\"download.php?file=$config[StorageDir]$document[FileNamePath]\"><br><img src='" .  '../../' . $config['ThumbnailDir'] . str_replace(".tif",".jpg",$document['FileName']) . " ' alt = Error /></a>";
                                echo "<br>Size: " . round(filesize($config['StorageDir'] . $document['FileNamePath'])/1024/1024, 2) . " MB";
                                ?>
                            </td>
                            <td>
                                <span class="label">Scan Of Back:</span>
                            </td>
                            <td rowspan="2" style="text-align: center">
                                <?php
                                if($document['FileNameBack'] == '' || $document['FileNameBackPath'] == '')
                                    echo 'No file uploaded';
                                else {
                                    echo "<a href=\"download.php?file=$config[StorageDir]$document[FileNameBackPath]\">(Click to download)</a><br>";
                                    echo "<a id='download_back' href=\"download.php?file=$config[StorageDir]$document[FileNameBackPath]\"><br><img src='" . '../../' . $config['ThumbnailDir'] . str_replace(".tif", ".jpg", $document['FileNameBack']) . " ' alt = Error /></a>";
                                    echo "<br>Size: " . round(filesize($config['StorageDir'] . $document['FileNameBackPath'])/1024/1024, 2) . " MB";
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top">
                                <span class="label"><br>Comments:</span>
                            </td>
                            <td>
                                <textarea name = "txtComments" rows = "5" cols = "35" id="txtComments"/><?php echo $document['Comments']; ?></textarea>
                            </td>
                        </tr>
                <tr>
                    <td colspan="4" style="text-align: center">
                        <input type = "hidden" id="txtDocID" name = "txtDocID" value = "<?php echo $docID;?>" />
                        <input type = "hidden" id="txtAction" name="txtAction" value="review" />  <!-- catalog or review -->
                        <input type = "hidden" id="txtCollection" name="txtCollection" value="<?php echo $collection; ?>" />
                        <span class="update">
                        <?php if($session->hasWritePermission())
                            {echo "<input type='submit' id='btnSubmit' name='btnSubmit' value='Update' class='bluebtn'/>";}
                        ?>
                            <div class="bluebtn" id="loader" style="display: none;">
                                updating
                                <img style="width: 2%;;" src='../../Images/loader.gif'/></div>
                            </div>
                        </span>
                    </td>
                </tr>

            </table>
                </form>
            </div>
        </td>
    </tr>

</table>

<?php include '../../Master/footer.php'; ?>

</body>
<style>
    @media screen and (max-height: 860px) {
        #div_scroller{
            max-height:650px;}
    }
    @media screen and (min-height: 861px) {
        #div_scroller{
            max-height:900px;}
    }


    #div_scroller{
        overflow-y: scroll;
        overflow-x:hidden;
        min-height:600px;
        /*	max-height:750px; */
    }

    #table2{
        width:95%;
        background-color: white;
        padding: 40px;
        border-radius: 6%;
        box-shadow: 0px 0px 2px;
        margin: auto;
        font-family: verdana;
        text-align: left;
        margin-top: 10px;
        margin-bottom: 50px;

    }
    #table2 td,tr{line-height:42px;}


    .label
    {
        float:left;
        width:150px;
        min-width: 195px;
        padding-top:2px;
    }
    .labelradio
    {
        float:left;
        width:150px;
        min-width: 195px;
        line-height:20px;
    }
    mark {
        background-color: #ccf5ff;
    }
    span.labelradio:hover p{
        z-index: 10;
        display: inline;
        position: absolute;
        border: 1px solid #000000;
        background: #bfe9ff;
        font-size: 13px;
        font-style: normal;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px; -o-border-radius: 3px;
        border-radius: 3px;
        -webkit-box-shadow: 4px 4px 4px #000000;
        -moz-box-shadow: 4px 4px 4px #000000;
        box-shadow: 4px 4px 4px #000000;
        width: 200px;
        padding: 10px 10px;
    }

    #thetable{height:100%;}
</style>
<script>
    $( document ).ready(function() {
        /* attach a submit handler to the form */
        $('#theform').submit(function (event) {
            /* stop form from submitting normally */
            $('#btnSubmit').css("display", "none");
            $('#loader').css("display", "inherit");
            event.disabled;

            event.preventDefault();
            /* Send the data using post */
            $.ajax({
                type: 'post',
                url: 'form_processing.php',
                data:  $('#theform').serializeArray(),
                success:function(data){
                    var json = JSON.parse(data);
                    var msg = json;
                    for(var i = 0; i < json.length; i++)
                    {
                        msg += json[i] + "\n";
                    }
                        alert(msg);},
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus); alert("Error: " + errorThrown);
                    }
                });
            });
        });
</script>
</html>