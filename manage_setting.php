<?php
    require_once('inc/common.php');
    require 'vendor/autoload.php';
    use Carbon\Carbon;

    if(isset($_POST['submit']) && $_POST['submit'] == "settings") {

        $updQry = "";
        if(isset($_POST['address'])) {
            $updQry .= "`address`='".$_POST['address']."',";
        }
        if(isset($_POST['mobileNo'])) {
            $updQry .= "`mobilenumber`='".$_POST['mobileNo']."',";
        }
        if(isset($_POST['gstNo'])) {
            $updQry .= "`gstnumber`='".$_POST['gstNo']."',";
        }
        /* if(isset($_POST['isgst'])) {
            $updQry .= "`isgst`=1,";
        } else {
            $updQry .= "`isgst`=0,";
        } */
        if(isset($_POST['parcelservice'])) {
            $updQry .= "`parcelservice`=1,";
        } else {
            $updQry .= "`parcelservice`=0,";
        }
        if(isset($_POST['total_table'])) {
            $updQry .= "`total_table`='".$_POST['total_table']."',";
        }
        if(isset($_POST['currency'])) {
            $updQry .= "`currency`='".$_POST['currency']."',";
        }
        
        $noError = 0;
        if(isset($_FILES['image']) && (isset($_FILES['image']['name']) && !empty($_FILES['image']['name']))) {




            // $target_dir = "img/";
            // $fileName = "logo.png";
            // $target_file = $target_dir . $fileName;
            // $uploadOk = 1;
            // $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // // Check if image file is a actual image or fake image
            
            // $check = getimagesize($_FILES["logo"]["tmp_name"]);

            // if($check === true) {
            //     $_SESSION['message'] = "<strong>File is not an image.</strong>";
            //     $_SESSION['messageClass'] = "danger";
            //     $uploadOk = 0;
            //     $noError = 1;
            
        //}
            
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                $_SESSION['message'] = "<strong>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</strong>";
                $_SESSION['messageClass'] = "danger";
                $uploadOk = 0;
                $noError = 1;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $_SESSION['message'] = "<strong>Sorry, your file was not uploaded.</strong>";
                $_SESSION['messageClass'] = "danger";
                $noError = 1;
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
                    $updQry .= "`logo`='".$fileName."',";
                } else {
                    $_SESSION['message'] = "<strong>Sorry, there was an error uploading your file.</strong>";
                    $_SESSION['messageClass'] = "danger";
                    $noError = 1;
                }
            }

        }

        if(isset($_FILES['favicon']) && (isset($_FILES['favicon']['name']) && !empty($_FILES['favicon']['name']))) {

            $target_dir = "img/";
            $fileName = "favicon.png";
            $target_file = $target_dir . $fileName;
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
            
            $check = getimagesize($_FILES["favicon"]["tmp_name"]);

            if($check === true) {
                $_SESSION['message'] = "<strong>File is not an image.</strong>";
                $_SESSION['messageClass'] = "danger";
                $uploadOk = 0;
                $noError = 1;
            }
            
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                $_SESSION['message'] = "<strong>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</strong>";
                $_SESSION['messageClass'] = "danger";
                $uploadOk = 0;
                $noError = 1;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $_SESSION['message'] = "<strong>Sorry, your file was not uploaded.</strong>";
                $_SESSION['messageClass'] = "danger";
                $noError = 1;
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["favicon"]["tmp_name"], $target_file)) {
                    $updQry .= "`favicon`='".$fileName."',";
                } else {
                    $_SESSION['message'] = "<strong>Sorry, there was an error uploading your file.</strong>";
                    $_SESSION['messageClass'] = "danger";
                    $noError = 1;
                }
            }

        }
        
        if($noError == 0) {
            mysqli_query($conn, "UPDATE `settings` SET ".substr($updQry, 0, -1));
            if(mysqli_error($conn)) {
                $_SESSION['message'] = "<strong>Something Went Wrong.</strong>";
                $_SESSION['messageClass'] = "danger";
            } else {
                $_SESSION['message'] = "<strong>Setting Updated but logo and favicon update not possible in demo version!...</strong>";
                
            }
        }
        
    }

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="img/favicon.png">
    <title>Settings | We Restaurants</title>
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
                                    <div class="pull-left" style="margin-top: 10px;">
                                        <strong>Manage Your Settings</strong>
                                    </div>
                                    <div class="pull-right">
                                        <div class="form-group" style="margin: 10px 0px 0px 0px;">
                                            <button type="button" id="clearAllTable" class="btn btn-primary btn-block" >
                                                <i class="fa fa-unlock-alt"></i>
                                                Click To Unfreeze All Table
                                            </button>
                                        </div>
                                    </div>
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

                                    <form action="#" method="POST" id="search" enctype="multipart/form-data">
                                        <div class="row">
                                            <?php
                                            $getSettings = mysqli_query($conn, "SELECT * FROM `settings` WHERE 1");
                                            $fetchSettings = mysqli_fetch_array($getSettings);
                                            ?>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="address">Address</label>
                                                    <!-- <input type="text" name="address" class="form-control" id="address"> -->
                                                    <textarea name="address" class="form-control" id="address"><?php echo $fetchSettings['address']; ?></textarea>
                                                </div>
                                            </div>

                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="mobileNo">Mobile Number</label>
                                                    <input type="text" name="mobileNo" class="form-control" id="mobileNo" value="<?php echo $fetchSettings['mobilenumber']; ?>">
                                                </div>
                                            </div>

                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="gstNo">GST Number</label>
                                                    <input type="text" name="gstNo" class="form-control" id="gstNo" value="<?php echo $fetchSettings['gstnumber']; ?>">
                                                </div>
                                            </div>

                                            <?php /* <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="isgst">Is Gst?</label>
                                                    <input style="width: 9%;" type="checkbox" name="isgst" class="form-control" id="isgst" <?php echo ($fetchSettings['isgst'] == 1 ? "checked" : ""); ?>>
                                                </div>
                                            </div> */ ?>

                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="parcelservice">Parcel Service?</label>
                                                    <input style="width: 9%;" type="checkbox" name="parcelservice" class="form-control" id="parcelservice" <?php echo ($fetchSettings['parcelservice'] == 1 ? "checked" : ""); ?>>
                                                </div>
                                            </div>

                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="total_table">Total Table</label>
                                                    <input type="number" name="total_table" class="form-control" id="total_table" value="<?php echo $fetchSettings['total_table']; ?>">
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="logo">Logo (200px,82px)</label>
                                                    <input type="file" name="insert_image" class="form-control" id="insert_image"  accept="image/*" >
                                                </div>
                                            </div>
                                         <div class="col-sm-2">
                                                <div class="form-group">
                                                <?php 
                                                $output ='
                                                            <img src="data:image/png;base64,'.base64_encode($fetchSettings['logo']).'" style="margin-top: 12px"  class="img-thumbnail" />
                                                        ';?>
                                                                 <!-- <img src="data:image/png;base64,'.base64_encode($fetchSettings['logo'])"  class="img-thumbnail" /> -->
                                                <?PHP echo $output; ?>
                                                <!-- <img src="data:image/png;base64,'.base64_encode($fetchSettings['logo']).'"  class="img-thumbnail" /> -->
                                                    <!-- <img class="img-fluid" style="margin-top: 12px" src="img/<?php// echo $fetchSettings['logo']; ?>" /> -->
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="favicon">Favicon (32px,32px)</label>
                                                    <!--<input type="file" name="favicon" class="form-control" id="favicon" value="<?php echo $fetchSettings['favicon']; ?>">-->
                                                    <input type="file" name="insert_favicon" class="form-control" id="insert_favicon"  accept="image/*" >
                                                    
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                <?php 
                                                               $output ='
                                                               <img src="data:image/png;base64,'.base64_encode($fetchSettings['favicon']).'"  style="width: 32px;height: 32px;margin-top: 32px;  class="img-thumbnail" />
                                                           ';?>
                                                                    <!-- <img src="data:image/png;base64,'.base64_encode($fetchSettings['logo'])"  class="img-thumbnail" /> -->
                                                   <?PHP echo $output; ?>
                                                   
                                                </div>
                                            </div>

                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="currency">Currency</label>
                                                    <input type="text" name="currency" class="form-control" id="currency" value="<?php echo $fetchSettings['currency']; ?>">
                                                </div>
                                            </div>

                                            <div class="col-sm-12"><!-- justify-content-sm-center  -->
                                                <div class="col-sm-3" style="padding: 0px;margin-left: auto;margin-right: auto;">
                                                    <div class="form-group">
                                                        <label for="">&nbsp;</label>
                                                        <button type="submit" id="searchButton" class="btn btn-primary btn-block" name="submit" value="settings">
                                                            <i class="fa fa-save"></i>
                                                            Save Settings
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
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

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script type="text/javascript">
        $(document).on('click', '#clearAllTable', function() {
            if(confirm("Are You sure you want to unfreeze all table?"))
            $.cookie('booking_id', null, { path: '/' })
        });
    </script>
</body>
</html>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.4/croppie.css" />
  <!--<script src="jquery.min.js"></script>  -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.4/croppie.js"></script>
 
        <div id="insertimageModal" class="modal" role="dialog">
            <div class="modal-dialog" style="max-width:50%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Crop & Insert Image</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-10 text-center">
                                <div id="image_demo" style="width:762px; margin-top:30px"></div>
                                </div>
                                <div class="col-md-4" style="padding-top:30px;">
                                <br /><br /><br/>
                                <button class="btn btn-success crop_image">Crop & Insert Image</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

<!------------------------------------------------------------------------------------------------------------------------------------------>

<div id="insertfaviconModal" class="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Crop & Insert Image</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-10 text-center">
                                <div id="imagedemo" style="width:300px; margin-top:30px"></div>
                                </div>
                                <div class="col-md-4" style="padding-top:30px;">
                                <br /><br /><br/>
                                <button class="btn btn-success crop_image_favicon">Crop & Insert Image</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
<!------------------------------------------------------------------------------------------------------------------------------------------->


<script>  
$(document).ready(function(){
    
 $image_crop = $('#image_demo').croppie({
    enableExif: true,
    viewport: {
      width:500,
      height:200,
      type:'square' //circle
    },
    boundary:{
      width:700,
      height:300
    }    
  });
    $('#insert_image').on('change', function(){
    var reader = new FileReader();
    reader.onload = function (event) {
      $image_crop.croppie('bind', {
        url: event.target.result
      }).then(function(){
        console.log('jQuery bind complete');
      });
    }
    reader.readAsDataURL(this.files[0]);
    $('#insertimageModal').modal('show');
  });

  $('.crop_image').click(function(event){
    $image_crop.croppie('result', {
      type: 'canvas',
      size: 'viewport'
    }).then(function(response){
      $.ajax({
        url:'insert_image.php',
        type:'POST',
        data:{"image":response},
        success:function(data){
          $('#insertimageModal').modal('hide');
          
          
        }
      })
    });
  });

    
 $image_crop_faivicon = $('#imagedemo').croppie({
    enableExif: true,
    viewport: {
      width:200,
      height:200,
      type:'square' //circle
    },
    boundary:{
      width:300,
      height:300
    }    
  });
    $('#insert_favicon').on('change', function(){
    var reader = new FileReader();
    reader.onload = function (event) {
      $image_crop_faivicon.croppie('bind', {
        url: event.target.result
      }).then(function(){
        console.log('jQuery bind complete');
      });
    }
    reader.readAsDataURL(this.files[0]);
    $('#insertfaviconModal').modal('show');
  });

  $('.crop_image_favicon').click(function(event){
    $image_crop_faivicon.croppie('result', {
      type: 'canvas',
      size: 'viewport'
    }).then(function(response){
      $.ajax({
        url:'insert_image_favicon.php',
        type:'POST',
        data:{"image":response},
        success:function(data){
          $('#insertfaviconModal').modal('hide');
          
          
        }
      })
    });
  });
});  
</script>


