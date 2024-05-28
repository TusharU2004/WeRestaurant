<?php
    require_once('inc/common.php');
    require 'vendor/autoload.php';
    use Carbon\Carbon;

    if(isset($_POST['submit']) && $_POST['submit'] == "settings") {
        $updQry = "";
        if(isset($_POST['isgst'])) {
            $updQry .= "`isgst`=1,";
        } else {
            $updQry .= "`isgst`=0,";
        }
        if(isset($_POST['taxlabel1'])) {
            $updQry .= "`taxlabel1`='".$_POST['taxlabel1']."',";
        }
        if(isset($_POST['taxlabel2'])) {
            $updQry .= "`taxlabel2`='".$_POST['taxlabel2']."',";
        }
        if(isset($_POST['taxpercentage1'])) {
            $updQry .= "`taxpercentage1`='".$_POST['taxpercentage1']."',";
        }
        if(isset($_POST['taxpercentage2'])) {
            $updQry .= "`taxpercentage2`='".$_POST['taxpercentage2']."',";
        }
        mysqli_query($conn, "UPDATE `settings` SET ".substr($updQry, 0, -1));
        if(mysqli_error($conn)) {
            $_SESSION['message'] = "<strong>Something Went Wrong.</strong>";
            $_SESSION['messageClass'] = "danger";
        } else {
            $_SESSION['message'] = "<strong>Tax Setting Updated.</strong>";
        }
    }
    
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="img/favicon.png">
    <title>Settings | We Restaurants</title>
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
                                    <div class="pull-left" style="margin-top: 10px;">
                                        <strong>Manage Your Tax</strong>
                                    </div>
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

                                    <form action="#" method="POST" id="search" enctype="multipart/form-data">
                                        <div class="row">
                                            <?php
                                            $getSettings = mysqli_query($conn, "SELECT * FROM `settings` WHERE 1");
                                            $fetchSettings = mysqli_fetch_array($getSettings);
                                            ?>
                                            
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="isgst">Apply Tax?</label>
                                                    <input style="width: 9%;" type="checkbox" name="isgst" class="form-control" id="isgst" <?php echo ($fetchSettings['isgst'] == 1 ? "checked" : ""); ?>>
                                                </div>
                                            </div>

                                            <div class="col-sm-2 taxPageBox">
                                                <div class="form-group">
                                                    <label for="taxlabel1">Tax Label 1 (ex: cgst/sgst/vat)</label>
                                                    <input type="text" name="taxlabel1" class="form-control" id="taxlabel1" value="<?php echo $fetchSettings['taxlabel1']; ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label for="taxpercentage1">Tax Percentage 1</label>
                                                    <input type="number" name="taxpercentage1" class="form-control" id="taxpercentage1" value="<?php echo $fetchSettings['taxpercentage1']; ?>">
                                                </div>
                                            </div>

                                            <div class="col-sm-2 taxPageBox">
                                                <div class="form-group">
                                                    <label for="taxlabel2">Tax Lable 2 (ex: cgst/sgst/vat)</label>
                                                    <input type="text" name="taxlabel2" class="form-control" id="taxlabel2" value="<?php echo $fetchSettings['taxlabel2']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="taxpercentage2">Tax Percentage 2</label>
                                                    <input type="number" name="taxpercentage2" class="form-control" id="taxpercentage2" value="<?php echo $fetchSettings['taxpercentage2']; ?>">
                                                </div>
                                            </div>

                                            <div class="col-sm-3" style="text-align: justify;">
                                                <b>Note: </b>If the tax checkbox is on, then the tax will be calculated. Tax is not counted if tax label is empty, And nowhere else will appear.
                                            </div>

                                            <div class="col-sm-12"><!-- justify-content-sm-center  -->
                                                <div class="col-sm-3" style="padding: 0px;margin-left: auto;margin-right: auto;">
                                                    <div class="form-group">
                                                        <label for="">&nbsp;</label>
                                                        <button type="submit" id="searchButton" class="btn btn-primary btn-block" name="submit" value="settings">
                                                            <i class="fa fa-save"></i>
                                                            Save Tax Settings
                                                        </button>
                                                    </div>
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