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
} else {
    header('location:index.php');
    die('Error');
}

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="img/favicon.png">
    <title>Invoice Details | We Restaurants</title>

    <!-- Icons -->
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/simple-line-icons.css" rel="stylesheet">

    <!-- Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    
    <!-- Main styles for this application -->
    <link href="css/style.css" rel="stylesheet">
</head>

<!-- BODY options, add following classes to body to change options
    
    // Header options
    1. '.header-fixed'					- Fixed Header
    
    // Sidebar options
    1. '.sidebar-fixed'					- Fixed Sidebar
    2. '.sidebar-hidden'				- Hidden Sidebar
    3. '.sidebar-off-canvas'		- Off Canvas Sidebar
    4. '.sidebar-minimized'			- Minimized Sidebar (Only icons)
    5. '.sidebar-compact'			  - Compact Sidebar
    
    // Aside options
    1. '.aside-menu-fixed'			- Fixed Aside Menu
    2. '.aside-menu-hidden'			- Hidden Aside Menu
    3. '.aside-menu-off-canvas'	- Off Canvas Aside Menu
    
// Breadcrumb options
1. '.breadcrumb-fixed'			- Fixed Breadcrumb

// Footer options
1. '.footer-fixed'					- Fixed footer

-->

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
    <header class="app-header navbar">
        <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">☰</button>
        <a class="navbar-brand" href="#"></a>
        <button class="navbar-toggler sidebar-minimizer d-md-down-none" type="button">☰</button>

    </header>

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

                                    <table id="allItemsTable" class="table table-hover table-bordered text-center">
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
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
        </main>
        
    </div>
    
    <footer class="app-footer">
        <a href="http://wcodez.com">WebcodeZ Infoway</a> © <?php echo date('Y'); ?>
        <span class="float-right">Developed by <a href="http://wcodez.com">WebcodeZ Infoway</a>
        </span>
    </footer>

    <!-- Bootstrap and necessary plugins -->
    <script src="js/libs/jquery.min.js"></script>
    <script src="js/libs/index.js"></script>
    <script src="js/libs/bootstrap.min.js"></script>
    <script src="js/libs/pace.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.js"></script>
    <script src="https://unpkg.com/vue@2.4.4/dist/vue.js"></script>
    
    
    
    
    <!-- GenesisUI main scripts -->
    
    <script src="js/app.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#title').focus();
        });
        $('#title').focus();
    </script>
</body>

</html>