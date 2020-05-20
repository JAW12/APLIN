<?php 
    if(isset($_GET['temp'])) {
        $temp = $_GET['temp']; 
    }
    else {
        header("location:register.php"); 
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

        <title>Sign In Page</title>
    </head>
    <body>

        <?php 
            $gagal = ""; 
            if(isset($_GET['gagal'])) {
                $gagal = $_GET['gagal'];
            }
        ?>
        <div class="limiter">
            <div class="container-login100" style="background-image: url('res/img/login/bg-06.jpg');">
                <div class="wrap-login100 p-t-30 p-b-50">      
                    <!-- <span class="login100-form-title p-b-41">
                        Account Login
                        &#xe81b -> eye
                        &#xe81a
                        &#xe81e
                        &#xe82e; -> cart
                    </span> -->
                    <div class="card rounded">
                        <div class="text-center mt-5">
                            <img src="res/img/logo.png" class="card-img mx-auto w-50 h-50" alt="...">
                        </div>
                        <div class="card-body" style="box-sizing: border-box">                        
                            <form class="login100-form validate-form p-b-33 p-t-5" method="post">
                                <?php 
                                    if(isset($_GET['temp'])) {
                                        echo "<input class='input100' type='hidden' id='temp'name='temp' value='$temp'>";    
                                    }
                                ?>
                                <?php
                                if($gagal != "") {
                                    echo "<div class='validate-input' style='color:red;'>";
                                        echo "<center><span class='text-secondary mt-2'>Your Code is wrong</span></center>"; 
                                    echo "</div>"; 
                                }
                                ?>
                                <div class="wrap-input100 validate-input" data-validate="Enter code">
                                    <input class="input100" type="text" name="emailCode" placeholder="Input Your Code">
                                    <span class="focus-input100" data-placeholder="&#xe86b;"></span>
                                </div>

                                <div class="container-login100-form-btn m-t-32 d-flex justify-content-around">
                                    <button class="login100-form-btn w-75" type="submit" formaction="verif.php?user">
                                        Submit
                                    </button>
                                </div>

                                <div class="container text-center">
                                    <button class="btn btn-link mt-4 text-decoration-none">
                                        <span class="text-secondary mt-2">Didn't receive a code?</span>
                                        <input type='button' class='btn-btn-primary' value='Resend Code' onclick='resend()'>
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>

        <div id="dropDownSelect1"></div>

        <script language='Javascript'>
            function resend() {
                var temp = $("#temp").val();
               
                if(temp != "") {
                    $.post("getdatauser.php",
                        { id: temp },
                        function(result) {
                            var node = JSON.parse(result); 

                            var vnama    = node.NAMA_DEPAN_CUSTOMER; 
                            var vsurnama = node.NAMA_BELAKANG_CUSTOMER; 
                            var vemail   = node.EMAIL; 
                            var vneed    = "Confirmation Email"; 
                            var vmsg     = node.KODE_VERIFIKASI;
                            //alert(vnama + "-" + vsurnama + "-" + vemail + "-" + vneed + "-" + vmsg); 

                            $.post("kirimregister.php",
                                { id: temp, name: vnama, surname: vsurnama, email: vemail, need: vneed, message: vmsg },
                                function(result) {
                                }
                            );
                        }
                    );        
                }
            }
        </script>
        <?php include "script.php"; ?>

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