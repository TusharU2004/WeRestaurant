<?php require_once('inc/common.php');
    
if(isset($_POST['title']) && !empty($_POST['title']) && isset($_POST['price']) && !empty($_POST['price']) ) {
    
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    $q = "INSERT INTO menu_items(mi_title, mi_amount) VALUES('".$title."','".$price."')";
    if(mysqli_query($conn, $q)){
        $_SESSION['message'] = "New Menu Item <strong>$title</strong> added successfully.";
        $_SESSION['messageClass'] = "success";
    }else{
        $_SESSION['message'] = "<strong>Error adding new item. Please try again.</strong>";
        $_SESSION['messageClass'] = "danger";
    }

}

header('location: add-menu-item.php');