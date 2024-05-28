<?php require_once('inc/common.php');

    
?><!DOCTYPE html>
<html lang="en" xmlns:v-on="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="img/favicon.png">
    <title>We Restaurants</title>
    <?php require_once('inc/header.php'); ?>

</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
    <?php require_once('inc/navbar.php'); ?>

    <div class="app-body">
    
        <?php require_once('inc/sidebar.php'); ?>
        <?php
        $getSettings = mysqli_query($conn, "SELECT * FROM `settings` WHERE 1");
        $fetchSettings = mysqli_fetch_array($getSettings);
        ?>
        <!-- Main content -->
        <main class="main" id="app">
            <div class="container-fluid mt-4" >
                <div class="row">
                    <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <strong>Create an Invoice <?php echo (isset($_GET['tableId']) ? "For Table ".$_GET['tableId'] : ""); ?></strong>
                                </div>
                                <div class="card-block">
                                    <form action="" method="post" id="addItemForm" v-on:submit.prevent="addItem">
                                        <div class="row">
                                            <div class="col-sm-1" style="display: none;">
                                                <div class="form-group">
                                                    <label for="">Parcel</label>
                                                    <label class="switch switch-lg switch-icon switch-pill switch-primary" style="margin-top: 0.25rem; margin-bottom: 0.25rem;">
                                                        <input type="checkbox" id="isParcel" class="switch-input">
                                                        <span class="switch-label" data-on="" data-off=""></span>
                                                        <span class="switch-handle"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2" style="display: none;">
                                                <div class="form-group">
                                                    <label for="tableNo">Table No</label>
                                                    <input type="number" min="1" id="tableNo" name="tableNo" class="form-control" value="<?php echo (isset($_GET['tableId']) ? $_GET['tableId'] : "1") ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-8">
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
                                                    <input type="number" min="1" id="qty0" name="qty0" class="form-control" v-on:keyup.enter="addItem" value="1" >
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

                                    <table id="orderedItemsTable" class="table table-responsive table-hover table-bordered text-center" v-cloak>
                                        <thead>
                                            <tr>
                                            <th class="text-center w-10">#</th>
                                            <th class="text-left w-40">Item</th>
                                            <th class="text-center w-20">Qty</th>
                                            <th class="text-center w-10">Amount</th>
                                            <th class="text-center w-10">Total</th>
                                            <th class="text-center w-10">Remove</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                            <td></td>
                                            <td class="text-right" colspan="3">
                                                Final Amount</br>
                                                Discount {{ discount_percent }}%</br>
                                                <?php if($fetchSettings['isgst'] == 1) { ?>
                                                    <?php echo (!empty($fetchSettings['taxlabel1']) ? $fetchSettings['taxlabel1']." ".$fetchSettings['taxpercentage1'] : "") ?>%</br>
                                                    <?php echo (!empty($fetchSettings['taxlabel2']) ? $fetchSettings['taxlabel2']." ".$fetchSettings['taxpercentage2'] : "") ?>%</br>
                                                <?php } ?> 
                                                <strong>Total Amount</strong>
                                            </td>
                                            <td class="text-right">
                                                <?php echo $fetchSettings['currency']; ?>{{ totalAmount }}</br>
                                                - <?php echo $fetchSettings['currency']; ?>{{ discount_amount }}</br>
                                                <?php if($fetchSettings['isgst'] == 1) { ?>
                                                    + <?php echo $fetchSettings['currency']; ?>{{ (totalAmount*<?php echo $fetchSettings['taxpercentage1']; ?>/100) }}</br>
                                                    + <?php echo $fetchSettings['currency']; ?>{{ (totalAmount*<?php echo $fetchSettings['taxpercentage2']; ?>/100) }}</br>
                                                <?php } ?> 
                                                <strong><?php echo $fetchSettings['currency']; ?>{{ total_amount_payable }}</strong>
                                            </td>
                                            <td></td>
                                            </tr>
                                        </tfoot>                                        
                                        <tbody>
                                            <tr v-for="(item, index) in items">
                                                <td class="align-middle"><strong>{{ index + 1 }}</strong></td>
                                                <td class="text-left align-middle">{{ item.text }}</td>
                                                <td class="align-middle">
													<button type="button" class="btn btn-sm btn-link" v-on:click="decreaseQuantity(index)">
														<i class="icon-minus icons font-2xl d-block m-t-2"></i>
                                                    </button>
													<span>&nbsp;{{ item.qty }}&nbsp; </span>
													<button type="button" class="btn btn-sm btn-link" v-on:click="increaseQuantity(index)">
														<i class="icon-plus icons font-2xl d-block m-t-2"></i>
                                                    </button>
												</td>
                                                <td class="align-middle"><?php echo $fetchSettings['currency']; ?>{{ item.price }}</td>
                                                <td class="align-middle"><?php echo $fetchSettings['currency']; ?>{{ item.qty * item.price }}</td>    
                                                <td class="align-middle">
                                                    <button type="button" class="btn btn-sm btn-danger" v-on:click="removeItem(index)">
                                                        <i class="fa fa-remove"></i>
                                                        Remove
                                                    </button>
                                                </td>    
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                    <div class="row">
                                        <div class="col-md-9">
                                            <form class="form-inline">

                                                <label class="mb-md-3 mr-md-2" for="inlineFormCustomSelectPref">Add Discount: </label>

                                                <input type="text" class="form-control form-control-sm mb-3 col-12 col-md-6 col-xl-7" id="discount_remarks" v-model="discount_remarks" placeholder="Discount Remarks (optional)">

                                                <div class="input-group mb-3 col-12 col-md-3 px-0 px-md-3">
                                                    <input type="number" min="0" max="100" class="form-control form-control-sm" id="discount_percent" name="discount_percent" value="0" v-model="discount_percent">
                                                    <div class="input-group-addon">%</div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-md-3">
                                            <button v-on:click="submitItems" class="btn btn-success btn-lg btn-block" id="indexSubmitId">
                                                Submit
                                            </button>   
                                        </div>
                                    </div>

                                    <br>

                                </div>
                            </div>
                    </div>
                </div>

                <input type="hidden" id="tableCheckVar" value="0" />
                
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
        menu_items = <?php echo json_encode($items);?>;
    </script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script>
        var isChangePage = 1;
        $(document).ready(function() {

            function GetURLParameter(sParam) {
                var sPageURL = window.location.search.substring(1);
                var sURLVariables = sPageURL.split('&');
                for (var i = 0; i < sURLVariables.length; i++) {
                    var sParameterName = sURLVariables[i].split('=');
                    if (sParameterName[0] == sParam) {
                        return sParameterName[1];
                    }
                }
            }
            fetchGetParameter = GetURLParameter('tableId');
            if(fetchGetParameter == "parcel") {
                $('#isParcel').trigger('click');
                $('#tableNo').prop('type', 'text').val('Parcel').prop('readonly', true);
            }

            $('#indexSubmitId').click(function() {
                isChangePage = 0;
            });

            $('#isParcel').change(function() {
                if(this.checked) {
                    $('#tableNo').prop('type', 'text').val('Parcel').prop('readonly', true); 
					
                }else {
                    $('#tableNo').prop('readonly', false).val('1').prop('type', 'number'); 
                }
            });
			
			init_select2();
			
			$('#tableNo').focus();

            $('#tableNo').change(function() {
                $("#tableIdHidden").val($(this).val());
            });

        });
		
    </script>
    
    <!-- Custom scripts required by this view -->
    <script src="js/views/main.js"></script>
    
    <script type="text/javascript">

        // $(window).on("beforeunload", function() {
        //     return "Are you sure? You didn't finish the form!";
        // });
        $(window).on("unload", function(e) {
            if(isChangePage == 1) {
                var tableName = $('#tableNo').val();
                currentCookieValue = $.cookie("booking_id");
                var numbers = currentCookieValue.split(',');
                var arr1 = [];
                for(var i = 0; i < numbers.length; i++)
                {
                    if(tableName != numbers[i] ) {
                        arr1.push(numbers[i]);
                    }
                }
                $.cookie("booking_id", arr1, { path: '/' });
            }
        });

        var myFunction = function(e) {
            if(isChangePage == 1) {
                e = e || window.event;
                var message = "Are you sure?";
                // For IE6-8 and Firefox prior to version 4
                if (e) {
                    e.returnValue = message;
                }
                // For Chrome, Safari, IE8+ and Opera 12+
                return message;
            }
        }
        window.onbeforeunload = myFunction;

    </script>

</body>
</html>