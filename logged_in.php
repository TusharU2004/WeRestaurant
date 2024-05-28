<?php session_start();

    if( ! isset($_SESSION["adid"])) { header("location: login.php"); exit; }

    if( $_SESSION["adid"] > 1 ) {
        header('location: reports_by_day.php');
    } else {
        header('location: login.php');
    }
