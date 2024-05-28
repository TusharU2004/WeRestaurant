<?php require_once('inc/common.php');

$q = "SELECT * FROM menu_items where mi_isActive = 1 order by trim(lower(mi_title)) asc";
$res = mysqli_query($conn, $q);
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="img/favicon.png">
    <title>Menu Items | We Restaurants</title>
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
                                    <strong>Add a menu item</strong>
                                </div>
                                <div class="card-block">
                                    <form action="process_add-menu-item.php" method="post" id="addItemForm" >
                                        <div class="row">
                                            
                                            <div class="col-sm-7">
                                                <div class="form-group">
                                                    <label for="title">Name of the Menu Item</label>
                                                    <input type="text" id="title" name="title" class="form-control" tabindex="1" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="price">Price</label>
                                                    <input type="number" id="price" name="price" class="form-control" tabindex="2"  required>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="">&nbsp;</label>
                                                    <button type="submit" id="addButton" class="btn btn-primary btn-block" tabindex="3" >
                                                        <i class="fa fa-plus"></i>
                                                        Add
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    
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
                                        echo '<br>';
                                    } ?>
                                    
                                    <table id="allItemsTable" class="table table-responsive table-hover table-bordered text-center">
                                        <thead>
                                            <tr>
                                            <th class="text-center w-10">#</th>
                                            <th class="text-left w-60">Item</th>
                                            <th class="text-center w-20">Price</th>
                                            <th class="text-center w-10">Remove</th>
                                            </tr>
                                        </thead>                 
                                        <tbody>
                                            <?php
                                                $getSettings = mysqli_query($conn, "SELECT * FROM `settings` WHERE 1");
                                                $fetchSettings = mysqli_fetch_array($getSettings);
                                            
                                                $index = 1;
                                                while($row = mysqli_fetch_assoc($res)){
                                                    echo '
                                                    <tr>
                                                    <td class="align-middle"><strong>'.$index++.'</strong></td>
                                                    <td class="text-left align-middle">'. $row["mi_title"] .'</td>
                                                    <td class="align-middle">'. $fetchSettings['currency'] . $row["mi_amount"] .'</td>
                                                    <td class="align-middle">
                                                        <a href="delete_menu-item.php?id='. $row["mi_id"] .'" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you Sure? This action cannot be undone.\')">
                                                            <i class="fa fa-remove"></i>
                                                            Remove
                                                        </a>
                                                    </td>    
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
    
    <?php require_once('inc/footer.php'); ?>

    <?php require_once('inc/footer-scripts.php'); ?>    
    
    <script>
        $(document).ready(function() {
            $('#title').focus();
        });
        $('#title').focus();
    </script>
</body>

</html>