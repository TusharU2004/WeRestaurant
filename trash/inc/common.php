<?php
    session_start();
    date_default_timezone_set("Asia/Kolkata");
    if( ! isset($_SESSION["adid"])) { header("location: login.php"); exit; }

    require_once('db.php');

    // if( ! isset($_SESSION["adid"])) { header("location: login.php"); exit; }
    
    $q = "SELECT mi_id as id, mi_title as text, mi_amount as price FROM menu_items";
    $res = mysqli_query($conn, $q);

    $items = array();
    while($row = mysqli_fetch_assoc($res)){
        $items[] = $row;
    }

?>