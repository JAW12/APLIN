<?php
    include "conn.php";

    function showDetailTrans($db, $detailTrans, $headerTrans){
        $lokasiFoto = "";
        $lokasiFoto = __DIR__."/res/img/transaksi/".$headerTrans['LOKASI_FOTO_BUKTI_PEMBAYARAN'];
        ?>
            <div class="container my-5">
                <p class="h1 text-center">Detail Transaction</p>
                <div class="row mt-5 mb-5">
                    <div class="col-3 mt-5">
                        <img src="<?= $lokasiFoto?>" width="500px" height="500px" alt="Payment Proof" class="border"/>
                        <a href="<?= $lokasiFoto ?>"><?= $lokasiFoto ?></a>
                    </div>
                    <div class="col-9 mt-5">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark text-center">
                                <th scope="col">#</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">QTY</th>
                                <th scope="col">Price</th>
                                <th scope="col">Subtotal</th>
                            </thead>
                            <tbody>
                                <?php
                                    $ctrNum = 0;
                                    $grandTotal = 0;
                                    foreach ($detailTrans as $key => $value) {
                                        $ctrNum++;
                                        $row_id_produk = $value['ROW_ID_PRODUK'];
                                        $query = "SELECT NAMA_PRODUK FROM PRODUK WHERE ROW_ID_PRODUK = {$row_id_produk}";
                                        $namaProduk = getQueryResultRowField($db, $query, "NAMA_PRODUK");

                                        $subtotal = $value['SUBTOTAL'];
                                        $grandTotal += $subtotal;
                                        ?>
                                            <tr>
                                                <th> <?= $ctrNum ?> </th>
                                                <td> <?= $namaProduk ?> </td>
                                                <td> <?= $value['QTY_PRODUK'] ?> </td>
                                                <td> <?= $value['HARGA_PRODUK']?></td>
                                                <td> <?= $subtotal ?> </td>
                                            </tr>
                                        <?php
                                    }
                                    ?>
                                        <tr class="bg-dark text-light">
                                            <td colspan="4" class="text-center">Grand Total</td>
                                            <td><?=$grandTotal ?></td>
                                        </tr>
                                    <?                                
                                ?>                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php
    }

    if (isset($_POST['viewDetail'])) {
        $row_id_htrans = $_POST['row_id_htrans'];
        $query = "SELECT * FROM DTRANS WHERE ROW_ID_HTRANS = {$row_id_htrans}";
        $detailTrans = getQueryResultRowArrays($db, $query);     
        $query = "SELECT * FROM HTRANS WHERE ROW_ID_HTRANS = {$row_id_htrans}";
        $headerTrans = getQueryResultRow($db, $query);           
    }
    else{
        $detailTrans = array();
        $headerTrans = array();
    }
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

        <!-- CSS Sendiri -->
        <link href="style/index.css" rel="stylesheet">

        <!-- JS Sendiri -->

        <title>Home</title>
    </head>
    <body id="page-top">
        <!-- Header Section -->
        <header>
            <nav class="navbar navbar-expand-lg bg-light navbar-light fixed-top py-3" id="mainNav">
                <a class="navbar-brand js-scroll-trigger" href="#page-top">Logo</a><button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto my-2 my-lg-0 mr-4">
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="">About Us</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="">Contact Us</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="">Products</a></li>
                    </ul>
                    <form class="form-inline my-2 my-lg-0 mr-3">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Search</button>
                    </form>
                    <a class="btn btn-primary" href="login.php" role="button">Login</a>
                </div>
            </nav>
        </header>

        <!-- Main Section -->
        <main>
            <!-- kalau mau pake space ga ush dicomment -->
            <div class="spaceatas"></div>
            
            <!-- container -> jarak ikut bootstrap, container-fluid -> jarak full width, w-(ukuran) -> sesuai persentase, contoh w-80 -> 80% -->
            <?php showDetailTrans($db, $detailTrans, $headerTrans) ?>

            <!-- Button Contact Us -->
            <div class="text-center my-3">
            <a class="btn btn-lg btn-dark" href="" role="button">CONTACT US</a>
            </div>
        </main>

        <!-- Footer Section -->
        <footer class="bg-dark py-5">
            <div class="container">
                <div class="medium text-center text-light">
                    Copyright ©2020 - Squee Store
                </div>
                <div class="small text-center text-light">
                    Squee Store berusaha menyediakan berbagai macam peralatan dan perlengkapan bahan bangunan dengan kualitas terjamin dan terjangkau.
                </div>   
            </div>
        </footer>
    </body>
</html>