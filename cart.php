<?php
    include __DIR__."/system/load.php";
    $login = getDataLogin();

?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

       <?php include "head.php"; ?>
        <style>
            #judul{
                padding: 0;
                padding-top: 5%;

                padding-bottom: 5%;
                background-repeat:no-repeat;
                background-size: cover;
            }

            html, body{ height:100%; margin:0; }
            body{ 
                display:flex; 
                flex-direction:column; 
            }

            footer{
                margin-top:auto; 
            }
            .grayscale{
                filter: grayscale(100%);
            }
        </style>
        <title>Cart</title>
    </head>
    <body id="page-top">
        <!-- <div class="spaceatas"></div> -->
        <div id="judul" class="container-fluid text-center my-5" style="background-image: url('res/img/bg19.jpg');">
            <h1 class="text-light display-3 font-weight-bold">
                Cart
            </h1>
        </div>
        <!-- Header Section -->
        <?php include("header.php"); 
            if(isset($_POST['idProduk'])){
                $idProduk = $_POST['idProduk'];
            }
            if(isset($_POST['grand'])){
                $grandTotal = $_POST['grand'];
            }
        ?>
        <div class="container" id="succeessAdd">

        </div>
        <main>
            <div class="container my-2 table-responsive">
                <table id="tableProduct" class="table table-hover table-striped table-bordered container">
                    <td>Table is loading</td>
                </table>
            </div>
            <div class="container text-right">
                <form method="POST" id="confirmPurchase">
                    <input type="hidden" name="grand" value="<?=$grandTotal?>"/>
                    <input type="hidden" name="idCust" value="<?=$login['row_id_customer']?>">
                    <button class="btn btn-success text-center px-3" name="btnConfirm">Confirm Purchase</button>
                </form>
            </div>
            
            <!-- Footer Section -->
        </main>
        <?php include("footer.php"); ?>
        <?php include "script.php"; ?>
        <script>
             $(document).ready(function(){
                showCart();
                //data akan diperbarui setiap 1 menit sekali
                setInterval(() => {
                    showCart();
                }, 60 * 1000);
            });

            $( function() {
                $( "#tabs" ).tabs();
            });

            $(document).on( "click", ".btn-delete", function(e){
                // e.preventDefault();
                // console.log(this);
                let form = $(this).parent();
                console.log(form);
                $.ajax({
                    method : "POST",
                    url : "ajax-cart.php",
                    data : $(form).serialize(),
                    success : function(res){
                        $("#succeessAdd").html(res);
                        showCart();
                    }
                });
            });

            $("#confirmPurchase").submit(function(e){
                e.preventDefault();
                $.ajax({
                    method : "POST",
                    url : "ajax-cart.php",
                    data : $("#confirmPurchase").serialize(),
                    success : function(res){
                        $("#succeessAdd").html(res);
                        showCart();
                    }
                });
            });

            function showCart(){
                $.ajax({
                    method: "post",
                    url: "ajax-cart.php",
                    data : {
                        load : "true"
                    },
                    success : function(res){
                        $("#tableProduct").html(res);
                    }
                });
            }
        </script>

    </body>
</html>