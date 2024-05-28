<?php
 $servername = "localhost";
 $username = "root";
 $password = "";
 $dbname = "werestaurant";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

/* change character set to utf8 */
if (!mysqli_set_charset($conn, "utf8")) {
    printf("Error loading character set utf8: %s\n", mysqli_error($conn));
    exit();
} else {
    // printf("Current character set: %s\n", mysqli_character_set_name($conn));
}
