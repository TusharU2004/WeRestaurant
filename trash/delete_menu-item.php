<?php require_once('inc/common.php');

if(isset($_GET['id']) && !empty($_GET['id']) ){
    
    $mi_id = mysqli_real_escape_string($conn, $_GET['id']);

    $q = "DELETE FROM menu_items WHERE mi_id = $mi_id";

    if(mysqli_query($conn, $q)){
        $_SESSION['message'] = "Menu Item deleted successfully.";
        $_SESSION['messageClass'] = "success";
    }else{
        $_SESSION['message'] = "<strong>Error deleting menu item. Please try again.</strong>";
        $_SESSION['messageClass'] = "danger";
    }

}

header('location: add-menu-item.php');