<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- CSS Library Import -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="css/datatables.css"/>
        <link href="css/all.css" rel="stylesheet">
        <link rel="icon" type="image/png" href="res/img/goblin.png" />         

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

        <!-- JS Sendiri -->
        <title>Register Page</title>
    </head>
    <body>
<?php 
    if(isset($_GET['suksesid'])) {
        include "system/load.php";
        $id       = $_GET['suksesid']; 
        $query    = "update verifikasi_email set status_verifikasi = 1 where row_id_customer = $id"; 
        $berhasil = executeNonQuery($db, $query);
    }
?>

    <div class="limiter">
            <div class="container-login100" style="background-image: url('res/img/login/bg-06.jpg');">
                <div class="wrap-login100 p-t-30 p-b-50">      
                    <!-- <span class="login100-form-title p-b-41">
                        Account Login
                    </span> -->
                    <div class="card rounded">
                        <div class="text-center mt-5">
                            <img src="res/img/logo.png" class="card-img mx-auto w-50 h-50" alt="...">
                        </div>
                        <div class="card-body" style="box-sizing: border-box">   
                            <form class="login100-form validate-form p-b-33 p-t-5" method="post">
                                <h3 style='text-align:center;'>congratulations</h3>                                
                            </form>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>

        <!-- JS Library Import -->
        <script src="js/jquery-3.4.1.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/jQueryUI.js"></script>
        <script type="text/javascript" src="js/datatables.js"></script>
        
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
    </body>
</html>