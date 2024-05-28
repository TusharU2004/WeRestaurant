<?php
    require_once('inc/common.php');
    require 'vendor/autoload.php';
    use Carbon\Carbon;

    if(isset($_POST['submit']) && $_POST['submit'] == "profile") {

        $requireFlag = true;
        $requireField = [
            'username'=> 'Username', 'password' => 'Password', 'cpassword' => 'Confirm Password'
        ];
        foreach ($requireField as $requireKey => $requireValue) {
            if(!isset($_POST[$requireKey]) || (isset($_POST[$requireKey]) && empty($_POST[$requireKey]))) {
                $_SESSION['message'] = "<strong>Please Enter ".$requireValue."</strong>";
                $_SESSION['messageClass'] = "danger";
                $requireFlag = false;
            }
        }

        if($requireFlag == true) {
            if($_POST['password'] != $_POST['cpassword']) {
                $_SESSION['message'] = "<strong>Password And Confirm Password Does Not Match.</strong>";
                $_SESSION['messageClass'] = "danger";
            } else {
              //  mysqli_query($conn, "UPDATE `admin` SET `username`='".$_POST['username']."',`password`='".md5($_POST['password'])."' WHERE `id`='".$_SESSION["adid"]."'");
                $_SESSION['message'] = "<strong> opps ! password update not possible in demo version!..</strong>";
            }
        }

    }

    if(isset($_POST['submitbill']) && $_POST['submitbill'] == "billpassword") {

        $requireFlag = true;
        $requireField = [
            'billcpassword' => 'Bill Confirm Password', 'billnewpassword' => 'Bill New Password'
        ];
        foreach ($requireField as $requireKey => $requireValue) {
            if(!isset($_POST[$requireKey]) || (isset($_POST[$requireKey]) && empty($_POST[$requireKey]))) {
                $_SESSION['bill_message'] = "<strong>Please Enter ".$requireValue."</strong>";
                $_SESSION['messageClass'] = "danger";
                $requireFlag = false;
            }
        }

        if($requireFlag == true) {
            if($_POST['billnewpassword'] != $_POST['billcpassword']) {
                $_SESSION['bill_message'] = "<strong>Bill Password And Confirm Password Does Not Match.</strong>";
                $_SESSION['messageClass'] = "danger";
            } else {
                echo "UPDATE `admin` SET `password`='".md5($_POST['billnewpassword'])."' WHERE `id`='3'";
                mysqli_query($conn, "UPDATE `admin` SET `password`='".$_POST['billnewpassword']."' WHERE `id`='3'");
                $_SESSION['bill_message'] = "<strongopps ! password update not possible in demo version!..</strong>";
            }
        }

    }

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="img/favicon.png">
    <title>Profile | We Restaurants</title>
    <?php require_once('inc/header.php'); ?>

</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
    <?php require_once('inc/navbar.php'); ?>

    <div class="app-body">
    
        <?php require_once('inc/sidebar.php'); ?>
    
        <!-- Main content -->
        <main class="main" id="app">
            <div class="container-fluid mt-4" >
                <div class="row">
                    <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <strong>Manage Your Profile</strong>
                                </div>
                                <div class="card-block">

                                    <?php if(isset($_SESSION['message'])){
                                            if(!isset($_SESSION['messageClass'])){
                                                $_SESSION['messageClass'] = 'primary';
                                            }
                                        echo '
                                            <div class="alert alert-'.$_SESSION['messageClass'].' alert-dismissible fade show" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                '.$_SESSION['message'].'
                                            </div>
                                        ';
                                        unset($_SESSION['message']);
                                        unset($_SESSION['messageClass']);
                                    } else {
                                    } ?>

                                    <form action="#" method="POST" id="search">
                                        <div class="row">

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="username">Username</label>
                                                    <input type="text" name="username" class="form-control" id="username">
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input type="password" name="password" class="form-control" id="password">
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="cpassword">Password</label>
                                                    <input type="password" name="cpassword" class="form-control" id="cpassword">
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="">&nbsp;</label>
                                                    <button type="submit" id="searchButton" class="btn btn-primary btn-block" name="submit" value="profile">
                                                        <i class="fa fa-save"></i>
                                                        Update Profile
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <br>

                                </div>
                            </div>
                    </div>
                </div>

                 <div class="row">
                    <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <strong>Change Bill Delete Password</strong>
                                </div>
                                <div class="card-block">

                                    <?php if(isset($_SESSION['bill_message'])){
                                            if(!isset($_SESSION['messageClass'])){
                                                $_SESSION['messageClass'] = 'primary';
                                            }
                                        echo '
                                            <div class="alert alert-'.$_SESSION['messageClass'].' alert-dismissible fade show" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                '.$_SESSION['bill_message'].'
                                            </div>
                                        ';
                                        unset($_SESSION['bill_message']);
                                        unset($_SESSION['messageClass']);
                                    } else {
                                    } ?>

                                    <form action="#" method="POST">
                                        <div class="row">

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="billnewpassword">Bill New Password</label>
                                                    <input type="billnewpassword" name="billnewpassword" class="form-control" id="billnewpassword">
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="billcpassword">Bill Confirm Password</label>
                                                    <input type="billcpassword" name="billcpassword" class="form-control" id="billcpassword">
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="">&nbsp;</label>
                                                    <button type="submit" class="btn btn-primary btn-block" name="submitbill" value="billpassword">
                                                        <i class="fa fa-save"></i>
                                                        Update Bill Password
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <br>

                                </div>
                            </div>
                    </div>
                </div>
            
            </div>
            <!-- /.conainer-fluid -->
            <br>
            <br>
            <br>
        </main>
        
    </div>

    <?php require_once('inc/footer.php'); ?>
    <?php require_once('inc/footer-scripts.php'); ?>    

</body>
</html>