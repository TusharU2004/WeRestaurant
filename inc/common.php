<?php
    session_start();
    date_default_timezone_set("Asia/Kolkata");
    if( ! isset($_SESSION["adid"])) { header("location: login.php"); exit; }

    if( $_SESSION["adid"] > 1 ) {
        $allowed_pages = [
            'reports',
            'reports_by_day',
            'view_invoice',
            'print',
            'manage_profile'
        ];
        if( ! in_array( basename($_SERVER['SCRIPT_FILENAME'], '.php'), $allowed_pages )){
            header('location: login.php');
            exit;
        }
    }

    require_once('db.php');


    $q = "SELECT mi_id as id, mi_title as text, mi_amount as price FROM menu_items where mi_isActive = 1";
    $res = mysqli_query($conn, $q);

    $items = array();
    $i=0;
    while($row = mysqli_fetch_assoc($res)){
        $items[$i]['id'] = $row['id'];
        $items[$i]['text'] = $row['text'] . " (".$row['id'].")";
        $items[$i]['price'] = $row['price'];
        $i++;
    }