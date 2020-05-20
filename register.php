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

        <!-- JS Sendiri -->
        <title>Register Page</title>
        <style>

            .bd-example-modal-lg .modal-dialog{
				display: table;
				position: relative;
				margin: 0 auto;
				top: calc(50% - 24px);
			}
			
			.bd-example-modal-lg .modal-dialog .modal-content{
				background-color: transparent;
				border: none;
			}
        </style>
    </head>
    <body>
    <div id="loading" class="modal fade bd-example-modal-lg" data-BACKdrop="static" data-keyboard="false" tabindex="-1">
			<div class="modal-dialog modal-sm">
				<div class="modal-content" style="width: 48px">
					<span class="fa fa-spinner fa-spin fa-3x"></span>
				</div>
			</div>
        </div>
<?php 
    if(isset($_GET['saved'])) {
        echo "<input type='hidden' id='txtsaved' value='1'>"; 
        if(isset($_GET['temp'])) {
            echo "<input type='hidden' id='temp' value='".$_GET['temp']."'>";
        }
        else {
            echo "<input type='hidden' id='temp' value=''>";
        }
    }
    else {
        echo "<input type='hidden' id='txtsaved' value='0'>"; 
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
                            <?php 
                                if(isset($_GET['saved'])) {
                                    echo "<h4 style='color:red;'>Registration has been successful. 
                                    Please check your email to verify your account</h4>"; 
                                }else if(isset($_GET['notsaved'])) {
                                    echo "<h4 style='color:red;'>Username must be unique</h4>";  
                                }else if(isset($_GET['notemail'])) {
                                    echo "<h4 style='color:red;'>Email is already in use </h4>";  
                                }
                            ?>
                            <form class="login100-form validate-form p-b-33 p-t-5" method="post">
                                <div class="wrap-input100 validate-input" data-validate="Enter Username">
                                    <input class="input100 form-control" type="text" name="username" placeholder="Username">
                                    <span class="focus-input100" data-placeholder="&#xe82a;"></span>
                                </div>

                                <div class="wrap-input100 input-group validate-input" data-validate="Enter Password">
                                    <input class="input100 form-control" type="password" name="pass" id="inputPass" placeholder="Password">
                                    <span class="focus-input100" data-placeholder="&#xe80f;"></span>
                                    <div class="input-group-append" id="show_hide_password">
                                        <button class="btn btn-outline-secondary" type="button" id="btnHide"><i class="fa fa-eye-slash" aria-hidden="true"></i></button>
                                      </div>
                                </div>
                                
                                <div class="wrap-input100 validate-input" data-validate="Enter Email">
                                    <input class="input100 form-control" type="text" name="email" placeholder="Email">
                                    <span class="focus-input100" data-placeholder="&#xe818;"></span>
                                </div>
                                <div class="wrap-input100 validate-input" data-validate="Enter First Name">
                                    <input class="input100 form-control" type="text" name="firstname" placeholder="First Name">
                                    <span class="focus-input100" data-placeholder="&#xe890;"></span>
                                </div>
                                <div class="wrap-input100 validate-input" data-validate="Enter Last Name">
                                    <input class="input100 form-control" type="text" name="lastname" placeholder="Last Name">
                                    <span class="focus-input100" data-placeholder="&#xe892;"></span>
                                </div>
                                <div class="wrap-input100 validate-input" data-validate="Enter Gender">
                                    <select class="input100 form-control" name="gridRadios" placeholder="Laki - Laki">
                                    <option value="laki">Male</option>
                                    <option value="perempuan">Female</option>
                                    <option value="undefiend">Rather Not Say</option>
                                    </select>
                                    <span class="focus-input100" data-placeholder="&#xe82b;"></span>
                                </div>
                                <!-- <div class="row">
                                <legend class="col-form-label col-sm-3 pt-0">Gender</legend>
                                <div class="col-sm-9">
                                <div class="form-group">
                                    <select class="form-control" name="gridRadios">
                                    <option value="laki">Laki-Laki</option>
                                    <option value="perempuan">Perempuan</option>
                                    <option value="undefiend">Undefiend</option>
                                    </select>
                                </div>
                                </div>
                                </div> -->
                                <div class="container-login100-form-btn m-t-32 d-flex justify-content-around">
                                    <button type='submit' class="login100-form-btn w-75" formaction="registeruser.php?user">
                                        Register
                                    </button>
                                </div>
                                <div class="container text-center">
                                    <button class="mt-4 text-decoration-none">
                                        <span class="text-secondary mt-2"> have an account?</span>
                                        <a href="login.php" class="text-primary font-weight-bold"> &nbsp;Log in</a>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
        
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

        <script language="javascript">
        var saved = $("#txtsaved").val(); 
        if(saved == "1") {
            $('#loading').modal('show');
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
                                window.location = "verification.php?temp="+temp;
                            }
                        );
                    }
                );        
            }
        }
        </script>
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