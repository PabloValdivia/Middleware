<?php

@session_destroy();
@session_start();

require_once('./config/config.php');

?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $_NAME ?></title>
    <link rel="shortcut icon" href="./public/assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./public/assets/css/material-dashboard.min.css">
    <link rel="stylesheet" href="./public/assets/css/custom.css">
</head>
<body class="dark-edition">
    <div class="wrapper">
        <div class="sidebar" data-color="purple" data-background-color="black" data-image="../assets/img/sidebar-2.jpg">
            <div class='logo'>
                <a class="simple-text logo-normal"><?= $_NAME ?></a>    
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li class="nav-item active">
                        <a class="nav-link" data-module="<?= base64_encode('dashboard') ?>" data-controller="<?= base64_encode('read') ?>">
                            <i class="fa fa-dashboard"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-module="<?= base64_encode('brand') ?>" data-controller="<?= base64_encode('read') ?>">
                            <i class="fa fa-building"></i>
                            <p>Brand</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-module="<?= base64_encode('category') ?>" data-controller="<?= base64_encode('read') ?>">
                            <i class="fa fa-tasks"></i>
                            <p>Category</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-module="<?= base64_encode('order') ?>" data-controller="<?= base64_encode('read') ?>">
                            <i class="fa fa-paste"></i>
                            <p>Order</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-module="<?= base64_encode('product') ?>" data-controller="<?= base64_encode('read') ?>">
                            <i class="fa fa-dropbox"></i>
                            <p>Product</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-panel">  
            <header id="navigation-example" class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        <a class="navbar-brand" href="javascript:void(0)">Dashboard</a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation" data-target="#navigation-example">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end">
                        <form class="navbar-form">
                        <span class="bmd-form-group"><div class="input-group no-border">
                            <input type="text" value="" class="form-control" placeholder="Search...">
                            <button type="submit" class="btn btn-default btn-round btn-just-icon">
                            <i class="fa fa-search"></i>
                            <div class="ripple-container"></div>
                            </button>
                        </div></span>
                        </form>
                        <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0)">
                            <i class="fa fa-dashboard"></i>
                            <p class="d-lg-none d-md-block">
                                Stats
                            </p>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="javscript:void(0)" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bell"></i>
                            <span class="notification">5</span>
                            <p class="d-lg-none d-md-block">
                                Some Actions
                            </p>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="javascript:void(0)">Mike John responded to your email</a>
                            <a class="dropdown-item" href="javascript:void(0)">You have 5 new tasks</a>
                            <a class="dropdown-item" href="javascript:void(0)">You're now friend with Andrew</a>
                            <a class="dropdown-item" href="javascript:void(0)">Another Notification</a>
                            <a class="dropdown-item" href="javascript:void(0)">Another One</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0)">
                            <i class="fa fa-user"></i>
                            <p class="d-lg-none d-md-block">
                                Account
                            </p>
                            </a>
                        </li>
                        </ul>
                    </div>
                </div>
            </header>
            <div class="content">
                <div id="app" class="container-fluid">

                </div>
            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <nav class="float-left">
                        <ul>
                            <li><a href="http://market.sumagroups.com/index.php" style="font-family:inherit;">1Click</a></li>
                            <li><a href="erp.sumagroups.com:9073/webui/">iDempiere</a></li>
                            <li><a href="#">License</a></li>
                        </ul>
                    </nav>
                    <div id="date" class="copyright float-right">
                        &copy; <?= date('Y'); ?>, made in <i class="fa fa-users"></i> by <a href="http://www.sumagroups.com/">Suma Groups</a>.
                    </div>
                </div>
            </footer>
        </div> 
    </div>    
    <script src="./vendor/jquery/jquery-3.5.1.min.js"></script>
    <!--   Core JS Files   -->
    <script src="./public/assets/js/core/jquery.min.js"></script>
    <script src="./public/assets/js/core/popper.min.js"></script>
    <script src="./public/assets/js/core/bootstrap-material-design.min.js"></script>
    <script src="./public/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!-- Chartist JS -->
    <script src="./public/assets/js/plugins/chartist.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="./public/assets/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="./public/assets/js/material-dashboard.js?v=2.1.0"></script>
    <script> token = '<?php echo sha1($tkn); ?>' ; </script>
    <script src="./public/assets/js/main.js"></script>   
</body>
</html>