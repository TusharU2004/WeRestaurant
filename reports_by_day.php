<?php
    require_once('inc/common.php');
    require 'vendor/autoload.php';
    use Carbon\Carbon;

if(!empty($_GET['fromDate']) || !empty($_GET['toDate'])) {
    $fromDate = mysqli_real_escape_string($conn, $_GET['fromDate']);
    $fromDate = implode('-', array_reverse(explode('-', $fromDate)));

    $toDate = mysqli_real_escape_string($conn, $_GET['toDate']);
    $toDate = implode('-', array_reverse(explode('-', $toDate)));

    $q = "SELECT
            COUNT(*) as total_orders,
            SUM(i_total_amount_payable) as total_amount_payable,
            CONVERT(i_created_at, DATE) as date
          FROM `invoices` WHERE ";

    if(!empty($fromDate)) {
        $q .= "i_created_at >= '$fromDate' AND ";
    }

    if(!empty($toDate)) {
        $q .= "i_created_at < '$toDate' + INTERVAL 1 DAY AND ";
    }

    if( substr($q, -4) == 'AND '){ 
        $q = rtrim($q, 'AND ');
    }

	$q .= " GROUP BY CONVERT(i_created_at,DATE) ORDER BY i_created_at DESC";
			
    if($res = mysqli_query($conn, $q)){
    }else{
        $_SESSION['message'] = "<strong>Error fetching data. Please try again.</strong>";
        $_SESSION['messageClass'] = "danger";
    }
    
}
else
{
    $currentDate = date('Y-m-d');
    $q = "SELECT COUNT(*) as total_orders, SUM(i_total_amount_payable) as total_amount_payable, CONVERT(i_created_at, DATE) as date FROM `invoices`  WHERE i_created_at >= '$currentDate' - INTERVAL 30 DAY group BY convert(i_created_at,DATE) ORDER BY i_created_at DESC";
    $res = mysqli_query($conn, $q);

    // To use in text fields
    $_GET['fromDate']  = '';
    $_GET['toDate'] = '';
}
$getSettings = mysqli_query($conn, "SELECT * FROM `settings` WHERE 1");
$fetchSettings = mysqli_fetch_array($getSettings);
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="img/favicon.png">
    <title>Reports | We Restaurants</title>
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
                                    <strong>View Reports By Day</strong>
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

                                    <form action="#" method="GET" id="search">
                                        <div class="row">

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="tableNo">Date Range Preset</label>
                                                    <select name="daterange" id="daterange" class="form-control" >
                                                        <option value="">Select</option>
                                                        <option value="1">Last 7 Days</option>
                                                        <option value="2">Last 30 Days</option>
                                                        <option value="3">This Month</option>
                                                        <option value="4">Last Month</option>
                                                        <option value="5">This Year</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="fromDate">From Date <span class="small">(Format: 21-09-2017)</span></label>
                                                    <input type="text" id="fromDate" name="fromDate" class="form-control" placeholder="Start" value="<?php echo $_GET['fromDate'];?>">
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-3">

                                                <div class="form-group">
                                                    <label for="toDate">To Date <span class="small">(Format: 28-09-2017)</span></label>
                                                    <input type="text" id="toDate" name="toDate" class="form-control" placeholder="End" value="<?php echo $_GET['toDate'];?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="">&nbsp;</label>
                                                    <button type="submit" id="searchButton" class="btn btn-primary btn-block">
                                                        <i class="fa fa-search"></i>
                                                        Search
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <br>

                                    <table id="allItemsTable" class="table table-responsive table-sm table-bordered table-striped text-center">
                                        <thead>
                                            <tr>
                                            <th class="text-center w-10">Sr No</th>
                                            <th class="text-center w-30">Date</th>
                                            <th class="text-center w-20">Total Orders</th>
                                            <th class="text-center w-25">Total Payable Amount</th>
                                            <th class="text-center w-1">View Details</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $total_orders = 0;
                                                $index = 1;
                                                $amount = 0;
                                                $total_discount = 0;
                                                $total_amount = 0;
                                                while($row = mysqli_fetch_assoc($res)){
                                                    $row_date = implode('-', array_reverse(explode('-', $row["date"])));
                                                    echo '
                                                    <tr>
                                                    <td class="align-middle">'. $index++ .'</td>
                                                    <td class="align-middle">
                                                        <a href="reports.php?fromDate='. $row_date .'&toDate='. $row_date .'" class="btn btn-sm btn-link">
                                                            <strong>'.$row_date.'</strong>
                                                        </a>
                                                    </td>
                                                    <td class="align-middle">'. $row["total_orders"] .'</td>
                                                    <td class="align-middle">'. $fetchSettings['currency'].$row["total_amount_payable"] .'</td>
                                                    <td class="align-middle">
                                                        <a href="reports.php?fromDate='. $row_date .'&toDate='. $row_date .'" class="btn btn-sm btn-outline-primary">
                                                            View
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    </td>
                                                    </tr>
                                                    ';
                                                    $total_orders = $total_orders + $row["total_orders"];
                                                    $total_amount = $total_amount + $row["total_amount_payable"];
                                                }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th class="text-center"></th>
                                                <th class="text-center">Total</th>
                                                <th class="text-center"><?php echo $total_orders; ?></th>
                                                <th class="text-center"><?php echo $fetchSettings['currency'].$total_amount; ?></th>
                                                <th class="text-center"></th>
                                            </tr>
                                        </tfoot>
                                    </table>

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
    	
	<script>
        $(document).ready(function() {
            $('#daterange').change(function() {
                if( $('#daterange').val() == 1 ) {
                    $('#fromDate').val('<?php echo Carbon::now()->subDays(7)->format('d-m-Y'); ?>');
                    $('#toDate').val('<?php echo Carbon::now()->format('d-m-Y'); ?>');
                }
                else if( $('#daterange').val() == 2 ) {
                    $('#fromDate').val('<?php echo Carbon::now()->subDays(30)->format('d-m-Y'); ?>');
                    $('#toDate').val('<?php echo Carbon::now()->format('d-m-Y'); ?>');
                }
                else if( $('#daterange').val() == 3 ) {
                    $('#fromDate').val('<?php echo Carbon::now()->startOfMonth()->format('d-m-Y'); ?>');
                    $('#toDate').val('<?php echo Carbon::now()->format('d-m-Y'); ?>');
                }
                else if( $('#daterange').val() == 4 ) {
                    $('#fromDate').val('<?php echo Carbon::now()->modify('first day of last month')->format('d-m-Y'); ?>');
                    $('#toDate').val('<?php echo Carbon::now()->modify('last day of last month')->format('d-m-Y'); ?>');
                }
                else if( $('#daterange').val() == 5 ) {
                    $('#fromDate').val('<?php echo Carbon::now()->modify('first day of january this year')->format('d-m-Y'); ?>');
                    $('#toDate').val('<?php echo Carbon::now()->format('d-m-Y'); ?>');
                }

            });

        });
    </script>

</body>

</html>