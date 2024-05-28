<?php   require_once('inc/common.php');

if(! isset($_GET['id']) || empty($_GET['id']) ){
    die("Invalid request.");
}

$invoice_id = mysqli_real_escape_string($conn, $_GET['id']);

$q = "SELECT * FROM invoices, invoice_items, menu_items WHERE invoices.i_id = invoice_items.ii_i_id AND menu_items.mi_id = invoice_items.ii_m_id AND invoices.i_id = ".$invoice_id;

if($res = mysqli_query($conn, $q)){
    $res2 = mysqli_query($conn, $q);
    $row2 = mysqli_fetch_assoc($res2);
    extract($row2);
} else {
    header('location:index.php');
    die('Error');
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Invoice No: <?php echo $i_id; ?></title>

    <!-- Main styles for this application -->
    <link href="css/style.css" rel="stylesheet">

    <style>
        @page {
            size: A5;
            margin: 0 0 0 0;
        }
        * {
            font-family: Tahoma;
            font-size: 12px;
            box-sizing: border-box;
        }
        html {
            margin:0;
        }
        body {
            width:148mm;
            margin: 6px auto 0px auto;
        }
        table {
            border-collapse: collapse;
            width: 133mm;
        }
        th, td {
            border: 1px solid black;
        }
        td {
            padding-bottom: 4px;
            padding-top:0px;
            padding-left:2px;
        }
        .xs-font{
            font-size:11px;
        }
        @media print {
            .no-print, .no-print *{
                display: none !important;
            }
        }
    </style>
</head>
<body style="background-color:#ffffff">    
    <div class="container-fluid">
    <div class="row no-print">
        <div class="col-sm-12 text-center">
			<br>
				<a href="index.php" class="btn btn-outline-info btn-lg" tabindex="1" >Home</a>	
			<br>
			<br>
		</div>
	</div>
    <div class="row">
        <div class="col-sm-12 text-center">
            <h1>We Restaurants</h1>
            <hr>
        </div>
    </div>
    <div class="row">    
        <div class="col"><strong> Invoice No: <?php echo $i_id; ?></strong></div>    
        <div class="col text-center"><strong> Table No: <?php echo $i_table_no; ?></strong></div>    
        <div class="col text-right"><strong> Date: <?php echo date('d-m-Y', strtotime($i_created_at)); ?></strong></div>
    </div>
  <div class="row mt-4">
    <div class="col-sm-12">
        <table id="" class="table table-sm table-bordered text-center">
            <thead>
                <tr>
                    <th class="text-center w-10">#</th>
                    <th class="text-left w-60">Item</th>
                    <th class="text-center w-10">Qty</th>
                    <th class="text-center w-10">Amount</th>
                    <th class="text-center w-10">Total</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th></th>
                    <th class="text-right" colspan="3">Total Amount</th>
                    <th class="text-center">₹<?php echo $i_amount; ?></th>
                </tr>
            </tfoot>                                        
            <tbody>
                <?php 
                    $index = 1;
                    while($row = mysqli_fetch_assoc($res)){
                        echo '
                        <tr>
                        <td class="align-middle"><strong>'.$index++.'</strong></td>
                        <td class="text-left align-middle">'. $row["mi_title"] .'</td>
                        <td class="align-middle">'. $row["ii_qty"] .'</td>
                        <td class="align-middle">₹'. $row["mi_amount"] .'</td>
                        <td class="align-middle">₹'. $row["mi_amount"] * $row["ii_qty"] .'</td>    
                        </tr>
                        ';
                    }
                ?>
            </tbody>
        </table>
    </div>
  </div>
    <div class="row">
        <div class="col-sm-10 mx-auto text-center">
            <p class="h5">Thank you for visiting!</p>
        </div>
    </div>
    </div>

    <script>
        document.onreadystatechange = function () {
            if (document.readyState == "complete") {
                window.print();
          }
        }       
    </script>
</body>
</html>

