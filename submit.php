<?php   require_once('inc/common.php');

if(! isset($_POST['items']) || empty($_POST['items']) ){
    die("Invalid request.");
}

$items = json_decode($_POST['items']); 

$totalAmount = mysqli_real_escape_string($conn, $_POST['totalAmount']);
$tableNo = mysqli_real_escape_string($conn, $_POST['tableNo']);
$tax_percent = mysqli_real_escape_string($conn, $_POST['tax_percent']);
$discount_percent = mysqli_real_escape_string($conn, $_POST['discount_percent']);
$discount_remarks = mysqli_real_escape_string($conn, $_POST['discount_remarks']);
$total_amount_payable = mysqli_real_escape_string($conn, $_POST['total_amount_payable']);

$q = "INSERT INTO invoices(i_amount, i_created_at, i_table_no, i_discount_percent, i_discount_remarks, i_tax_percent, i_total_amount_payable) 
    VALUES('$totalAmount', '". date("Y-m-d H:i:s") ."', '$tableNo', '$discount_percent', '$discount_remarks', '$tax_percent', '$total_amount_payable')";

if(mysqli_query($conn, $q)){
    $invoice_id = mysqli_insert_id($conn);
} else {
    die('error');
}

$q = "INSERT INTO invoice_items(ii_i_id,ii_m_id,ii_qty) VALUES";

foreach($items as $item){
    $q .= "('". $invoice_id ."', 
        '". mysqli_real_escape_string($conn, $item->id) ."', 
        '". mysqli_real_escape_string($conn, $item->qty) ."'),";
}

$q = rtrim($q, ',');

if(mysqli_query($conn, $q)){
    echo $invoice_id;
} else {
    die('error');
}
