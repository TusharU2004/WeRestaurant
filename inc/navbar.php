<header class="app-header navbar">
    <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">☰</button>
   
   <?php $getSettings = mysqli_query($conn, "SELECT * FROM `settings` WHERE 1");
   $fetchSettings = mysqli_fetch_array($getSettings);
   $output ='
   <img src="data:image/png;base64,'.base64_encode($fetchSettings['logo']).'"  class="navbar-brand" />
';?>
    <a class="navbar-brand" style="padding:0;" href="index.php"><?php echo $output ;?></a>                                                  
 
    <ul class="navbar-nav ml-md-auto">
        <li class="nav-item pr-2">
            <a class="btn btn-outline-primary" href="logout.php">
                <i class="fa fa-lock"></i> Logout
            </a>
        </li>
    </ul>
    <button class="navbar-toggler sidebar-minimizer d-md-down-none" type="button">☰</button>
</header>