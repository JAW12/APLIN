<?php
    include __DIR__."/system/load.php";
    // session_start();
?>
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

        <!-- JS Library Import -->
        <script src="js/jquery-3.4.1.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/jQueryUI.js"></script>
        <script type="text/javascript" src="js/datatables.js"></script>
        <script src="script/index.js"></script>

        <!-- CSS Sendiri -->
        <link href="style/index.css" rel="stylesheet">
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
            <table id="tableProduct" class="table table-hover table-striped table-bordered container">
                <td>a</td>
            </table>
            <div class="container text-right">
                <form method="POST" id="confirmPurchase">
                    <input type="hidden" name="grand" value="<?=$grandTotal?>"/>
                    <input type="hidden" name="idCust" value="<?=$idCustomer?>">
                    <button class="btn btn-success text-center px-3" name="btnConfirm">Confirm Purchase</button>
                </form>
            </div>
            
            <!-- Footer Section -->
        </main>
        
        <?php include("footer.php"); ?>

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
                console.log(this);
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
                        var success = `
                        <thead class="thead-dark text-center">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Picture</th>
                                <th scope="col">Name</th>                        
                                <th scope="col">Price</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Subtotal</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>       
                        <tbody>                         
                            <tr>
                                <th colspan="7" class="text-center">
                                    <span class="text-dark">You don't have any item in your cart yet</span> <br/>
                                    <a class="btn btn-warning text-dark rounded mx-2 my-2" href="product-list.php">
                                        Start shopping now
                                    </a>
                                </th>
                            </tr>
                        </tbody>`;
                        $("#tableProduct").html(success);
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