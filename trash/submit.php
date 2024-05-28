<?php   require_once('inc/common.php');

if(! isset($_POST['items']) || empty($_POST['items']) ){
    die("Invalid request.");
}

$items = json_decode($_POST['items']); 

$totalAmount = mysqli_real_escape_string($conn, $_POST['totalAmount']);

$tableNo = mysqli_real_escape_string($conn, $_POST['tableNo']);
// die($tableNo);

$q = "INSERT INTO invoices(i_amount, i_created_at, i_table_no) VALUES('$totalAmount', '". date("Y-m-d H:i:s") ."', '$tableNo')";

if(mysqli_query($conn, $q)){
    $invoice_id = mysqli_insert_id($conn);
} else {
    die($q);
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
