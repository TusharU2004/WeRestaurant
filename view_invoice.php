<?php require_once('inc/common.php');

if(! isset($_GET['id']) || empty($_GET['id']) ){
    die("Invalid request.");
}

$invoice_id = mysqli_real_escape_string($conn, $_GET['id']);

$q = "SELECT * FROM invoices, invoice_items, menu_items WHERE invoices.i_id = invoice_items.ii_i_id AND menu_items.mi_id = invoice_items.ii_m_id AND invoices.i_id = ".$invoice_id;
// die($q);
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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="img/favicon.png">
    <title>Invoice Details | We Restaurants</title>
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
                                    <strong>Invoice Details</strong>
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
                                    
                                    <div class="row">    
                                        <div class="col"><strong> Invoice No: <?php echo $i_id; ?></strong></div>    
										<div class="col text-center"><strong> Table No: <?php echo $i_table_no; ?></strong></div>
                                        <div class="col text-right"><strong> Date: <?php echo date('d-m-Y', strtotime($i_created_at)); ?></strong></div>
                                    </div>
                                    <br>

                                    <table id="allItemsTable" class="table table-responsive table-hover table-bordered">
                                        <thead>
                                            <tr>
                                            <th class="text-center w-10">#</th>
                                            <th class="text-left w-60">Item</th>
                                            <th class="text-center w-10">Qty</th>
                                            <th class="text-right w-10">Amount</th>
                                            <th class="text-right w-10 pr-2">Total</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td class="text-right" colspan="3">
                                                    <?php if($i_amount != $i_total_amount_payable){ echo "Final Amount</br>";}?>
                                                    <?php if($i_discount_remarks != ''){echo '('.$i_discount_remarks.')'; } ?>
                                                    <?php if($i_discount_percent != 0){ echo "Discount $i_discount_percent%</br>";}?>

                                                    <?php if($i_tax_percent > 0) { ?>
                                                        <?php echo "Tax ".$i_tax_percent."%<br/>" ?>
                                                        <?php //echo (!empty($fetchSettings['taxlabel1']) ? $fetchSettings['taxlabel1']." ".$fetchSettings['taxpercentage1']."%</br>" : ""); ?>
                                                        <?php //echo (!empty($fetchSettings['taxlabel2']) ? $fetchSettings['taxlabel2']." ".$fetchSettings['taxpercentage2']."%</br>" : ""); ?>
                                                        <?php // if($i_tax_percent != 0){ echo "CGST ".($i_tax_percent/2)."%</br>";}?>
                                                        <?php // if($i_tax_percent != 0){ echo "SGST ".($i_tax_percent/2)."%</br>";}?>
                                                    <?php } ?>

                                                    <strong>Total Amount</strong>
                                                </td>
                                                <td class="text-right pr-2">
                                                    <?php if($i_amount != $i_total_amount_payable){ echo $fetchSettings['currency'].$i_amount."</br>";}?>
                                                    <?php if($i_discount_percent != 0){ echo "- ".$fetchSettings['currency'].$discount_amount."</br>";}?>

                                                    <?php if($i_tax_percent > 0) { ?>
                                                        <?php echo $i_total_amount_payable."</br>"; ?>
                                                        <?php //echo (!empty($fetchSettings['taxlabel1']) ? $fetchSettings['currency'].((($i_amount - $discount_amount)*$fetchSettings['taxpercentage1'])/100)."</br>" : ""); ?>
                                                        <?php //echo (!empty($fetchSettings['taxlabel2']) ? $fetchSettings['currency'].((($i_amount - $discount_amount)*$fetchSettings['taxpercentage2'])/100)."</br>" : ""); ?>
                                                        <?php // if($i_tax_percent != 0){ echo "+ ".$fetchSettings['currency'].$CGST."</br>";}?>
                                                        <?php // if($i_tax_percent != 0){ echo "+ ".$fetchSettings['currency'].$SGST."</br>";}?>
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
                                                    <td class="text-right align-middle">'. $fetchSettings['currency'].$row["mi_amount"] .'</td>
                                                    <td class="text-right align-middle pr-2">'. $fetchSettings['currency'].$row["mi_amount"] * $row["ii_qty"] .'</td>    
                                                    </tr>
                                                    ';
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                    
                                    <br>

                                    <div class="row">
                                        <div class="col-sm-3 mx-auto">
                                            <a href="print.php?id=<?php echo $i_id;?>" class="btn btn-success btn-lg btn-block" target="_blank">
                                                Print
                                            </a>   
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                
            </div>
            <!-- /.conainer-fluid -->
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
        </main>
        
    </div>
    
    <?php require_once('inc/footer.php'); ?>

    <?php require_once('inc/footer-scripts.php'); ?>    
    
    <!-- Custom scripts required by this view -->
    <script src="js/views/main.js"></script>

    <script>
        $(document).ready(function() {
            $('#title').focus();
        });
        $('#title').focus();
    </script>
</body>

</html>