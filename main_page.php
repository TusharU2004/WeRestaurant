<?php
    require_once('inc/common.php');
    require 'vendor/autoload.php';
    use Carbon\Carbon;
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="img/favicon.png">
    <title>Tables | We Restaurants</title>
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
                            <div class="card tabless">
                                <!-- <div class="card-header">
                                    <strong>Manage Your Tables</strong>
                                </div> -->
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
                                        <div class="row" id="refreshWrapper">
                                            
                                            <?php
                                            $getSettings = mysqli_query($conn, "SELECT * FROM `settings` WHERE 1");
                                            $fetchSettings = mysqli_fetch_array($getSettings);
                                            $totalTable = $fetchSettings['total_table'];
                                            $bookedTable = (isset($_COOKIE['booking_id']) ? $_COOKIE['booking_id'] : []);
                                            if(!empty($bookedTable)) {
                                                $explodeBookedTable = explode(",", $bookedTable);
                                            }
                                            for($i=1; $i<=$totalTable; $i++) {
                                                $bookColor = "";
                                                if(!empty($explodeBookedTable)) {
                                                    if(in_array($i, $explodeBookedTable)) {
                                                        $bookColor = "gredientcls";
                                                    }
                                                }
                                            ?>
                                                <div class="col-md-2 mb40">
                                                    <div class="tblnumbers <?php echo $bookColor; ?>" data-redirecturl="index.php?tableId=<?php echo $i; ?>">
                                                        <h4 class=""><?php echo $i; ?></h4>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                            <?php
                                            $getSettings = mysqli_query($conn, "SELECT * FROM `settings` WHERE 1");
                                            $fetchSettings = mysqli_fetch_array($getSettings);
                                            if($fetchSettings['parcelservice'] == 1) {
                                            ?>
                                                <div class="col-md-2 mb40">
                                                    <div class="parcelNumbers" data-redirecturl="index.php?tableId=parcel">
                                                    </div>
                                                </div>
                                            <?php } ?>

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
    <script type="text/javascript">
        $(document).on('click', '.tblnumbers', function(e) {
        // $('.tblnumbers').click(function(e) {
            if($(this).hasClass('bookColor')) {
                alert("This Table is already booked");
            } else {
                var currUrl = $(this).attr('data-redirecturl');
                // window.location.href=currUrl;
                window.open(currUrl, '_BLANK');
            }
        });

        $(document).on('click', '.parcelNumbers', function(e) {
            var currUrl = $(this).attr('data-redirecturl');
            window.open(currUrl, '_BLANK');
        });

        setInterval(function()
        { 
            $.ajax({
              url:"refreshTable.php",
              type:"post",
              success:function(data)
              {
                  $("#refreshWrapper").html(data);
              }
            });
        }, 3000);

    </script>

</body>
</html>