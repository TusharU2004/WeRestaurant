<?php
        session_start();
        session_destroy();
		if (isset($_COOKIE['booking_id'])) {
		    unset($_COOKIE['booking_id']);
		    setcookie('booking_id', null, -1, '/');
		}
        header("location: index.php");

?>
