<?php
include __DIR__."/system/load.php";

if(isset($_SESSION['login'])){
    header("location: index.php");
    exit;
}
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <?php include "head.php"; ?>

        <!-- CSS template login -->
        <!--===============================================================================================-->        
        <link rel="icon" type="image/png" href="res/img/goblin.png" />     
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="vendor/login/animate/animate.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="vendor/login/css-hamburgers/hamburgers.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="vendor/login/animsition/css/animsition.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="vendor/login/select2/select2.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="vendor/login/daterangepicker/daterangepicker.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="style/login/util.css">
        <link rel="stylesheet" type="text/css" href="style/login/main.css">
        <!--===============================================================================================-->

        <!-- CSS Sendiri -->
        <link href="style/lrc.css" rel="stylesheet">

        <title>Sign In As Admin Page</title>
    </head>
    <body>
        <div class="limiter">
            <div class="container-login100" style="background-image: url('res/img/login/bg-06.jpg');">
                <div class="wrap-login100 p-t-30 p-b-50">      
                     <span class="login100-form-title p-b-41">
                        Admin Login
                    </span> -->
                    <div class="card rounded">
                        <div class="text-center mt-5">
                            <img src="res/img/logo.png" class="card-img mx-auto w-50 h-50" alt="...">
                        </div>
                        <div class="card-body" style="box-sizing: border-box">       
                            <div class="alert alert-danger <?= isset($_GET['error']) ? 'd-block' : 'd-none'?>">
                                <?= $_GET['error'] == 'wrongpw' ? 'Wrong Password!' : 'Login Data Not Found'?>
                            </div>                 
                            <form class="login100-form validate-form p-b-33 p-t-5" method="post">
                                <div class="wrap-input100 validate-input" data-validate="Enter username">
                                    <input class="form-control input100" type="text" name="username" placeholder="Username">
                                    <span class="focus-input100" data-placeholder="&#xe82a;"></span>
                                </div>

                                <div class="wrap-input100 input-group validate-input" data-validate="Enter password">
                                    <input class=" form-control input100" type="password" id="inputPass" name="pass" placeholder="Password">
                                    <span class="focus-input100" data-placeholder="&#xe80f;"></span>
                                    <div class="input-group-append" id="show_hide_password">
                                        <button class="btn btn-outline-secondary" type="button" id="btnHide"><i class="fa fa-eye-slash" aria-hidden="true"></i></button>
                                      </div>
                                </div>

                                <div class="container-login100-form-btn m-t-32 d-flex justify-content-around">
                                    <button class="login100-form-btn w-75" formaction="cek_login.php?admin">
                                        Login
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div id="dropDownSelect1"></div>

        <!-- JS template login -->
        <!--===============================================================================================-->
        <script src="vendor/login/animsition/js/animsition.min.js"></script>
        <!--===============================================================================================-->
        <script src="vendor/login/select2/select2.min.js"></script>
        <!--===============================================================================================-->
        <script src="vendor/login/daterangepicker/moment.min.js"></script>
        <script src="vendor/login/daterangepicker/daterangepicker.js"></script>
        <!--===============================================================================================-->
        <script src="vendor/login/countdowntime/countdowntime.js"></script>
        <!--===============================================================================================-->
        <script src="js/login.js"></script>
        <script src="script/index.js"></script>
        <?php include "script.php"; ?>
        <script>
            $(document).ready(function() {
                $("#show_hide_password").on('click', function(event) {
                    event.preventDefault();
                    if($('#inputPass').attr("type") == "text"){
                        $('#inputPass').attr('type', 'password');
                        $('#show_hide_password i').addClass( "fa-eye-slash" );
                        $('#show_hide_password i').removeClass( "fa-eye" );
                    }else if($('#inputPass').attr("type") == "password"){
                        $('#inputPass').attr('type', 'text');
                        $('#show_hide_password i').removeClass( "fa-eye-slash" );
                        $('#show_hide_password i').addClass( "fa-eye" );
                    }
                });
            });
        </script>
    </body>
</html>