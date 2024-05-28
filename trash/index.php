<?php require_once('inc/common.php');

    
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="img/favicon.png">
    <title>We Restaurants</title>

    <!-- Icons -->
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/simple-line-icons.css" rel="stylesheet">

    <!-- Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    
    <!-- Main styles for this application -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
    <?php require_once('inc/header.php'); ?>

    <div class="app-body">
    
        <?php require_once('inc/sidebar.php'); ?>
    
        <!-- Main content -->
        <main class="main" id="app">
            <div class="container-fluid mt-4" >
                <div class="row">
                    <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <strong>Create an Invoice</strong>
                                </div>
                                <div class="card-block">
                                    <form action="" method="post" id="addItemForm" v-on:submit.prevent="addItem">
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="tableNo">Table No</label>
                                                    <input type="number" id="tableNo" name="tableNo" class="form-control" value="1">
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="select22">Menu Item</label>
                                                    <select class="form-control" id="select22" name="menuItem" >
                                                        <option selected=false></option>
                                                    </select>
                                                </div>
                                            </div> 
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="qty0">Quantity</label>
                                                    <input type="number" id="qty0" name="qty0" class="form-control" v-on:keyup.enter="addItem" value="1" >
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="">&nbsp;</label>
                                                    <button type="button" id="addButton" v-on:click="addItem" class="btn btn-primary btn-block">
                                                        <i class="fa fa-plus"></i>
                                                        Add
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <br>

                                    <table id="orderedItemsTable" class="table table-hover table-bordered text-center" v-cloak>
                                        <thead>
                                            <tr>
                                            <th class="text-center w-10">#</th>
                                            <th class="text-left w-50">Item</th>
                                            <th class="text-center w-10">Qty</th>
                                            <th class="text-center w-10">Amount</th>
                                            <th class="text-center w-10">Total</th>
                                            <th class="text-center w-10">Remove</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                            <th></th>
                                            <th class="text-right" colspan="3">Total Amount</th>
                                            <th class="text-center">₹{{ totalAmount }}</th>
                                            <th></th>
                                            </tr>
                                        </tfoot>                                        
                                        <tbody>
                                            <tr v-for="(item, index) in items">
                                                <td class="align-middle"><strong>{{ index + 1 }}</strong></td>
                                                <td class="text-left align-middle">{{ item.text }}</td>
                                                <td class="align-middle">{{ item.qty }}</td>
                                                <td class="align-middle">₹{{ item.price }}</td>
                                                <td class="align-middle">₹{{ item.qty * item.price }}</td>    
                                                <td class="align-middle">
                                                    <button type="button" class="btn btn-sm btn-danger" v-on:click="removeItem(index)">
                                                        <i class="fa fa-remove"></i>
                                                        Remove
                                                    </button>
                                                </td>    
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                    <br>

                                    <div class="col-sm-3 float-right">
                                        <button v-on:click="submitItems" class="btn btn-success btn-lg btn-block">
                                            Submit
                                        </button>   
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
        menu_items = <?php echo json_encode($items);?>;
    </script>
    
    <!-- Custom scripts required by this view -->
    <script src="js/views/main.js"></script>
    
</body>

</html>