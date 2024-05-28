<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <?php if($_SESSION['adid'] == 1):?>
            <li class="nav-item">
                <a class="nav-link" href="main_page.php"><i class="icon-grid"></i> Tables <span class="badge badge-primary"></span></a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" href="index.php"><i class="icon-speedometer"></i> Dashboard <span class="badge badge-primary"></span></a>
            </li> -->
            <li class="nav-item">
                <a class="nav-link" href="add-menu-item.php"><i class="icon-list"></i> Menu Items <span class="badge badge-primary"></span></a>
            </li>
            <?php endif;?>
            <li class="nav-item">
                <a class="nav-link" href="reports_by_day.php"><i class="icon-chart"></i> Reports <span class="badge badge-primary"></span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="manage_profile.php"><i class="icon-user"></i> Profile <span class="badge badge-primary"></span></a>
            </li>
            <?php if($_SESSION['adid'] == 1):?>
            <li class="nav-item">
                <a class="nav-link" href="manage_tax.php"><i class="icon-paper-clip"></i> Tax <span class="badge badge-primary"></span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="manage_setting.php"><i class="icon-settings"></i> Setting <span class="badge badge-primary"></span></a>
            </li>
            <?php endif;?>
        </ul>
    </nav>
</div>
