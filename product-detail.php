<?php
    include "system/database.php";

    if(isset($_POST['idProduk'])){
        $idProduk = $_POST['idProduk'];
    }
    else{
        $idProduk = "9";
    }
    if(isset($_POST['idCust'])){
        $idCustomer = $_POST['idCust'];
    }
    else{
        $idCustomer = "6";
    }
    $query = "SELECT * FROM PRODUK WHERE ROW_ID_PRODUK=$idProduk";
    $produk = getQueryResultRow($db, $query);
    $fotoProduk=$produk['LOKASI_FOTO_PRODUK'];
    $namaProduk=$produk['NAMA_PRODUK'];
    $hargaProduk=$produk['HARGA_PRODUK'];
    $stokProduk=$produk['STOK_PRODUK'];
    $deskripsiProduk=$produk['DESKRIPSI_PRODUK'];
    $dimensiKemasan=$produk['DIMENSI_KEMASAN'];
    $dimensiProduk=$produk['DIMENSI_PRODUK'];
    $beratProduk=$produk['BERAT_PRODUK'];
    $satuanProduk=$produk['SATUAN_PRODUK'];
    if(isset($_POST['btnBeli'])){
        if($_POST['jumlahBeliProduk']>$stokProduk){
            echo "<script>alert('Maaf stok tidak mencukupi');</script>";
        }
        else{
            try {
                $query = "INSERT INTO CART VALUES(:idCust, :idProduk, :qty)";
                $stmt = $db->prepare($query);
                $stmt->bindValue(":idCust", $_POST['idCust'], PDO::PARAM_INT);
                $stmt->bindValue(":idProduk", $_POST['idProduk'], PDO::PARAM_INT);
                $stmt->bindValue(":qty", $_POST['jumlahBeliProduk'], PDO::PARAM_INT);
                $result = $stmt->execute();
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            try{
                $query = "UPDATE PRODUK SET STOK_PRODUK = :stokBaru WHERE ROW_ID_PRODUK = :id";
                $db->prepare($query);
                $stmt->bindValue(":stokBaru", $stokProduk-intval($_POST['jumlahBeliProduk']), PDO::PARAM_INT);
                $stmt->bindValue(":id", $_POST['idProduk'], PDO::PARAM_INT);
                $stmt->execute();
            }catch (Exception $e) {
                echo $e->getMessage();
            }
            $stokProduk = $stokProduk-intval($_POST['jumlahBeliProduk']);
            echo "<script>alert('Pembelian sukses');</script>";
        }
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
        
        <title>Detail Produk</title>
        <script>
            $( function() {
                $( "#tabs" ).tabs();
            } );
        </script>
    </head>
    <body id="page-top">
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

        <main>
            <div class="container">
            <div class="row mt-5 mb-5">
                <div class="col mt-5">
                    <img src="<?= $fotoProduk?>" width="300px" height="500px"/>
                </div>
                <div class="col mt-5">
                    <h1 class="display-4 font-weight-bold mb-4"><?=$namaProduk?></h1>
                    <h2 class="mb-4" style="color: grey">Rp. <?=number_format($hargaProduk)?></h2>
                    <form method="POST">
                        <input type="hidden" name="idProduk" value="<?=$idProduk?>">
                        <input type="hidden" name="idCust" value="<?=$idCustomer?>">
                        <div class="input-group mb-3">
                            <input type="text" name="jumlahBeliProduk" class="form-control" placeholder="1" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">dari <?=$stokProduk." ".ucfirst("$satuanProduk")?></span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success" name="btnBeli"> <i class="fas fa-shopping-cart"></i>
                        &nbsp;&nbsp;&nbsp;Beli Sekarang</button>
                    </form>
                </div>
            </div>
        </main>
        <div id="tabs">
                <ul>
                    <li><a href="#tabs-1">DESKRIPSI PPRODUK</a></li>
                    <li><a href="#tabs-2">INFORMASI LAINNYA</a></li>
                </ul>
                <div id="tabs-1">
                    <p><?=$deskripsiProduk?></p>
                </div>
                <div id="tabs-2">
                    <p>Dimensi Kemasan : </br>
                    <?= $dimensiKemasan?></p>
                    <p>Dimensi Produk : </br>
                    <?= $dimensiProduk?> </p>
                    <p>Berat Produk : </br>
                    <?= $beratProduk?> </p>
                </div>
            </div>
            <div class="text-center my-3">
                <a class="btn btn-lg btn-dark" href="" role="button">CONTACT US</a>
            </div>
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