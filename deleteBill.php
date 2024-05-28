<?php
require_once('inc/common.php');
if(isset($_GET['billId']) && !empty($_GET['billId'])) {
    mysqli_query($conn, "DELETE FROM `invoices` WHERE `i_id`='".$_GET['billId']."'");
    mysqli_query($conn, "DELETE FROM `invoice_items` WHERE `ii_i_id`='".$_GET['billId']."'");
    header('location:reports.php');
}