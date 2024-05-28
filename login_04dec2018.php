<?php  	session_start();
    if( isset($_SESSION["adid"])) { header("location: logged_in.php"); exit; }
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="CoreUI Bootstrap 4 Admin Template">
    <meta name="author" content="Lukasz Holeczek">
    <meta name="keyword" content="CoreUI Bootstrap 4 Admin Template">
    <!-- <link rel="shortcut icon" href="assets/ico/favicon.png"> -->

    <title>Login | We Restaurants</title>

    <!-- Icons -->
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/simple-line-icons.css" rel="stylesheet">

    <!-- Main styles for this application -->
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="app flex-row align-items-center">
    <div style="display: none;">
        <img src="img/login_img/bg1.jpg" />
        <img src="img/login_img/bg2.jpg" />
        <img src="img/login_img/bg3.jpg" />
        <img src="img/login_img/bg4.jpg" />
        <img src="img/login_img/bg5.jpg" />
        <img src="img/login_img/bg6.jpg" />
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-group mb-0">
                    <div class="card p-4">
                        <div class="card-body">
                            <h1>Login</h1>
                            <p class="text-muted">Sign In to your account</p>
                            <form action="process_login.php" method="POST">
                                <div class="input-group mb-3">
                                    <span class="input-group-addon"><i class="icon-user"></i>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Username" name="username" tabindex="1">
                                </div>
                                <div class="input-group mb-4">
                                    <span class="input-group-addon"><i class="icon-lock"></i>
                                    </span>
                                    <input type="password" class="form-control" placeholder="Password" name="password" tabindex="2">
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary px-4" tabindex="3">Login</button>
                                    </div>
                                    <div class="col-6 text-right">
                                        <!-- <button type="button" class="btn btn-link px-0">Forgot password?</button> -->
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap and necessary plugins -->
    <script src="js/libs/jquery.min.js"></script>
    <script src="js/libs/index.js"></script>
    <script src="js/libs/bootstrap.min.js"></script>
    <script src="js/libs/pace.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.js"></script>
    <script src="https://unpkg.com/vue@2.4.4/dist/vue.js"></script>

    <script type="text/javascript">
        $(function() {
            var body = $('body');
            var backgrounds = new Array(
                'url(img/login_img/bg1.jpg) no-repeat center center fixed',
                'url(img/login_img/bg2.jpg) no-repeat center center fixed',
                'url(img/login_img/bg3.jpg) no-repeat center center fixed',
                'url(img/login_img/bg4.jpg) no-repeat center center fixed',
                'url(img/login_img/bg5.jpg) no-repeat center center fixed',
                'url(img/login_img/bg6.jpg) no-repeat center center fixed',
            );
            var current = 0;
            function nextBackground() {
                body.css('background', backgrounds[current = ++current % backgrounds.length]);
                body.css('background-size', 'cover');
                setTimeout(nextBackground, 5000);
            }
            setTimeout(nextBackground, 5000);
            body.css('background', backgrounds[0]);
            body.css('background-size', 'cover');
        });
    </script>

</body>

</html>