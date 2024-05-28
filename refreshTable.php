<?php
require_once('inc/common.php');
$getSettings = mysqli_query($conn, "SELECT * FROM `settings` WHERE 1");
$fetchSettings = mysqli_fetch_array($getSettings);
$totalTable = $fetchSettings['total_table'];
$bookedTable = (isset($_COOKIE['booking_id']) ? $_COOKIE['booking_id'] : []);
if(!empty($bookedTable)) {
    $explodeBookedTable = explode(",", $bookedTable);
}
for($i=1; $i<=$totalTable; $i++) {
    $bookColor = "";
    $textaniamtion = "";
    if(!empty($explodeBookedTable)) {
        if(in_array($i, $explodeBookedTable)) {
            $bookColor = "gredientcls";
            $textaniamtion = "textaniamtion";
        }
    }
?>
    <div class="col-md-2 mb40">
        <div class="tblnumbers <?php echo $bookColor; ?>" data-redirecturl="index.php?tableId=<?php echo $i; ?>">
            <h4 class=""><?php echo $i; ?></h4>
        </div>
    </div>
<?php } ?>
<div class="col-md-2 mb40">
    <div class="parcelNumbers" data-redirecturl="index.php?tableId=parcel">
    </div>
</div>