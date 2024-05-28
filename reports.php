<?php require_once('inc/common.php');

if(!empty($_GET['fromDate']) || !empty($_GET['toDate']) || !empty($_GET['tableNo']) ) {

    $q = "SELECT * FROM invoices WHERE ";

    if(!empty($_GET['fromDate'])) {
        $fromDate = mysqli_real_escape_string($conn, $_GET['fromDate']);
        $fromDate = implode('-', array_reverse(explode('-', $fromDate)));
        $q .= "i_created_at >= '$fromDate' AND ";
    }

    if(!empty($_GET['toDate'])) {
        $toDate = mysqli_real_escape_string($conn, $_GET['toDate']);
        $toDate = implode('-', array_reverse(explode('-', $toDate)));
        $q .= "i_created_at < '$toDate' + INTERVAL 1 DAY AND ";
    }

    if(!empty($_GET['tableNo'])) {
        $tableNo = mysqli_real_escape_string($conn, $_GET['tableNo']);
        $q .= "i_table_no = '$tableNo'";
    }

    if( substr($q, -4) == 'AND '){ 
        $q = rtrim($q, 'AND ');
    }

	$q .= " ORDER BY i_created_at DESC";
			
    if($res = mysqli_query($conn, $q)){
    }else{
        $_SESSION['message'] = "<strong>Error fetching data. Please try again.</strong>";
        $_SESSION['messageClass'] = "danger";
    }
    
}
else
{
    $currentDate = date('Y-m-d');
    $q = "SELECT * FROM invoices WHERE i_created_at >= '$currentDate' - INTERVAL 1 DAY AND i_created_at < '$currentDate' + INTERVAL 1 DAY ORDER BY i_created_at DESC";
    $res = mysqli_query($conn, $q);
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
                                    <strong>View Reports</strong>
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
                                            
											<div class="col-sm-1">
                                                <div class="form-group">
                                                    <label for="">Parcel</label>
                                                    <label class="switch switch-lg switch-icon switch-pill switch-primary" style="margin-top: 0.25rem; margin-bottom: 0.25rem;">
                                                        <input type="checkbox" id="isParcel" class="switch-input">
                                                        <span class="switch-label" data-on="" data-off=""></span>
                                                        <span class="switch-handle"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="tableNo">Table No </label>
                                                    <input type="number" min="1" id="tableNo" name="tableNo" class="form-control" placeholder="All">
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="fromDate">From Date</label>
                                                    <input type="text" id="fromDate" name="fromDate" class="form-control" placeholder="Format: 21-09-2017">
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-3">

                                                <div class="form-group">
                                                    <label for="toDate">To Date</label>
                                                    <input type="text" id="toDate" name="toDate" class="form-control" placeholder="Format: 28-09-2017">
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

                                    <table id="allItemsTable" class="table table-responsive table-sm table-bordered text-center">
                                        <thead>
                                            <tr>
                                            <th class="text-center w-10"># </th>
                                            <th class="text-center w-20">InvoiceDate</th>
                                            <th class="text-center w-10">Table</th>
                                            <th class="text-center w-10">Amount</th>
                                            <th class="text-center w-10">Discount(%)</th>
                                            <th class="text-center w-10">Discount(Rs)</th>
                                            <th class="text-center w-10">Payable</th>
                                            <th class="text-center w-10">View</th>
                                            <th class="text-center w-10">Print</th>
                                            <th class="text-center w-10">Delete</th>
                                            <!-- <th class="text-center w-10">Delete</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $orders = 0;
                                                $index = 0;
                                                $amount = 0;
                                                $total_discount = 0;
                                                $total_amount = 0;
                                                while($row = mysqli_fetch_assoc($res)){
                                                    $discount = $row["i_discount_percent"] * $row["i_amount"] / 100;
                                                    echo '
                                                    <tr>
                                                    <td class="align-middle"><strong>'.$row["i_id"].'</strong></td>
                                                    <td class="align-middle">'. $row["i_created_at"] .'</td>
                                                    <td class="align-middle">'. $row["i_table_no"] .'</td>
                                                    <td class="align-middle">'. $fetchSettings['currency'].$row["i_amount"] .'</td>
                                                    <td class="align-middle">'. $row["i_discount_percent"] .'%</td>
                                                    <td class="align-middle">'. $fetchSettings['currency'].$discount .'</td>
                                                    <td class="align-middle">'. $fetchSettings['currency'].$row["i_total_amount_payable"] .'</td>
                                                    <td class="align-middle">
                                                        <a href="view_invoice.php?id='. $row["i_id"] .'" class="btn btn-sm btn-outline-primary">
                                                            View
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    </td>
                                                    <td class="align-middle">
                                                        <a href="print.php?id='. $row["i_id"] .'" class="btn btn-sm btn-outline-primary" target="_blank">
                                                            Print
                                                            <i class="fa fa-print"></i>
                                                        </a>
                                                    </td>
                                                    <td class="align-middle">
                                                        <a href="javascript:;" class="btn btn-sm btn-outline-danger deleteBill" data-id='. $row["i_id"] .'>
                                                            Delete
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </td>
                                                    </tr>
                                                    ';
                                                    $orders++;
                                                    $amount = $amount + $row["i_amount"];
                                                    $total_discount = $total_discount + $discount;
                                                    $total_amount = $total_amount + $row["i_total_amount_payable"];
                                                }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                            <th class="text-center w-10">Total</th>
                                            <th class="text-center w-20"><?php echo $orders.' Orders'; ?></th>
                                            <th class="text-center w-10"></th>
                                            <th class="text-center w-10"><?php echo $fetchSettings['currency'].$amount; ?></th>
                                            <th class="text-center w-10"></th>
                                            <th class="text-center w-10"><?php echo $fetchSettings['currency'].$total_discount; ?></th>
                                            <th class="text-center w-10"><?php echo $fetchSettings['currency'].$total_amount; ?></th>
                                            <th class="text-center w-10"></th>
                                            <th class="text-center w-10"></th>
                                            <th class="text-center w-10"></th>
                                            <!-- <th class="text-center w-10"></th> -->
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
        <?php
        $getBillPassword = mysqli_query($conn, "SELECT * FROM `admin` WHERE id='3'");
        $fetchSBillPassword = mysqli_fetch_array($getBillPassword);
        echo "<input type='hidden' id='billPassword' value='".$fetchSBillPassword['password']."' />";
        ?>
        
    </div>
    
    <?php require_once('inc/footer.php'); ?>

    <?php require_once('inc/footer-scripts.php'); ?>    
    	
	<script>
        $(document).ready(function() {
            $('#isParcel').change(function() {
                if(this.checked) {
                    $('#tableNo').prop('type', 'text').val('Parcel').prop('readonly', true); 
					
                }else {
                    $('#tableNo').prop('readonly', false).val('1').prop('type', 'number'); 
                }
            });
			
        });

        $(document).on("click", ".deleteBill", function() {
            var currVal = $(this).attr('data-id');  
            var inputPassword =prompt("Enter Password", 'password');
           
            if (inputPassword != null || inputPassword != "") {
                var dbPassword = $("#billPassword").val();
                if(inputPassword == dbPassword) {
                    $.ajax({
                        url:"deleteBill.php?billId="+currVal,
                        type:"get",
                        success:function(data) {
                            location.reload();
                        }
                    });
                }
            }

        });
    </script>

</body>

</html>