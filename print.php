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
    $discount_amount = $i_amount * $i_discount_percent / 100;
    $CGST = round(($i_amount - $discount_amount) * $i_tax_percent / 2 / 100, 2);
    $SGST = round(($i_amount - $discount_amount) * $i_tax_percent / 2 / 100, 2);

    $TAX = round(($i_amount - $discount_amount) * $i_tax_percent / 100, 2);

} else {
    header('location:index.php');
    die('Error');
}

$getSettings = mysqli_query($conn, "SELECT * FROM `settings` WHERE 1");
$fetchSettings = mysqli_fetch_array($getSettings);

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Invoice No <?php echo $i_id; ?></title>

    <!-- Main styles for this application -->
    <link href="css/style.css" rel="stylesheet">

    <style>
        @page {
            size: A5;
            margin: 0 0 0 0;
        }
        * {
            font-family: Tahoma;
            font-size: 18px;
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
        .backImageClass {
            /*background-image: url(img/print_background.png);*/
            background-size: 150px 150px;
            background-repeat: no-repeat;
            background-position: center;
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
            <img src="img/logo.png" class="mx-auto mt-2 mb-2" style="width: 50%;">
            <!-- <p class="h5 d-inline ml-1" >The Multi-Cuisine Restaurant</p> -->
        </div>
        <?php
        $getSettings = mysqli_query($conn, "SELECT * FROM `settings` WHERE 1");
        $fetchSettings = mysqli_fetch_array($getSettings);
        ?>
        <div class="col-sm-12 text-center mt-1">
                <?php echo $fetchSettings['address']; ?>
                <br/>
                Mo: <?php echo $fetchSettings['mobilenumber']; ?> &nbsp;&nbsp;&nbsp; 
                <?php echo (trim($fetchSettings['gstnumber']) != "" ? "(GSTIN: ".$fetchSettings['gstnumber'].")" : ""); ?>
        </div>
    </div>
    <hr class="mt-1"> 
    <div class="row">    
        <div class="col" style="max-width: 90%">
        	<strong> Invoice No: <?php echo $i_id; ?></strong> <span style="float: right;"> <strong > Date: <?php echo date('d-m-Y', strtotime($i_created_at)); ?></strong> </span> </br>
        	<strong>Table No: <?php echo $i_table_no; ?></strong>
        </div></div>
        <div class="col text-center"><strong> </strong></div>    
        <div class="col text-right"></div>
    </div>
  <div class="row mt-4">
    <div class="col-sm-12">
        <table id="" class="table table-sm table-bordered backImageClass" style="width:90%">
            <thead>
                <tr>
                    <th class="text-center w-10">#</th>
                    <th class="text-left w-40">Item</th>
                    <th class="text-center w-10">Qty</th>
                    <th class="text-right w-10">Amount</th>
                    <th class="text-right w-10 pr-2">Total</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th></th>
                    <td class="text-right" colspan="3">
                        <?php if($i_amount != $i_total_amount_payable){ echo "Final Amount</br>";}?>
                        <?php if($i_discount_percent != 0){ echo "Discount $i_discount_percent%</br>";}?>

                        <?php if($i_tax_percent > 0) { ?>
                            <?php echo (!empty($fetchSettings['taxlabel1']) ? $fetchSettings['taxlabel1']." ".$fetchSettings['taxpercentage1']."%</br>" : ""); ?>
                            <?php echo (!empty($fetchSettings['taxlabel2']) ? $fetchSettings['taxlabel2']." ".$fetchSettings['taxpercentage2']."%</br>" : ""); ?>
                            <?php //if($i_tax_percent != 0){ echo "CGST ".($i_tax_percent/2)."%</br>";}?>
                            <?php //if($i_tax_percent != 0){ echo "SGST ".($i_tax_percent/2)."%</br>";}?>
                        <?php } ?>

						<strong>Total Amount</strong>
					</td>
                    <td class="text-right pr-2">
						<?php if($i_amount != $i_total_amount_payable){ echo $fetchSettings['currency'].$i_amount."</br>";}?>
						<?php if($i_discount_percent != 0){ echo $fetchSettings['currency'].$discount_amount."</br>";}?>

                        <?php if($i_tax_percent > 0) { ?>
                            <?php echo (!empty($fetchSettings['taxlabel1']) ? $fetchSettings['currency'].((($i_amount - $discount_amount)*$fetchSettings['taxpercentage1'])/100)."</br>" : ""); ?>
                            <?php echo (!empty($fetchSettings['taxlabel2']) ? $fetchSettings['currency'].((($i_amount - $discount_amount)*$fetchSettings['taxpercentage2'])/100)."</br>" : ""); ?>
                            <?php //if($i_tax_percent != 0){ echo $fetchSettings['currency'].$CGST."</br>";}?>
                            <?php //if($i_tax_percent != 0){ echo $fetchSettings['currency'].$SGST."</br>";}?>
                        <?php } ?>

						<?php echo $fetchSettings['currency']; ?><strong><?php echo $i_total_amount_payable; ?></strong>
					</td>
                </tr>
            </tfoot>
            <tbody>
                <?php
                    $index = 1;
                    while($row = mysqli_fetch_assoc($res)){
                        echo '
                        <tr>
                        <td class="text-center align-middle"><strong>'.$index++.'</strong></td>
                        <td class="text-left align-middle">'. $row["mi_title"] .'</td>
                        <td class="text-center align-middle">'. $row["ii_qty"] .'</td>
                        <td class="text-right align-middle">'. $row["mi_amount"] .'</td>
                        <td class="text-right align-middle pr-2">'. $row["mi_amount"] * $row["ii_qty"] .'</td>
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
            <p class="h5">Thank you for visit.</p>
        </div>
    </div>
    </div>

    <script>
        document.onreadystatechange = function () {
            if (document.readyState == "complete") {
                window.print();
                window.onafterprint=function() {
                    window.location.href="main_page.php";
                }
            }
        }
    </script>
</body>
</html>