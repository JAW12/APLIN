<?php
    include "load.php";

    if(isset($_POST['idProduk'])){
        $idProduk = $_POST['idProduk'];
    }
    if(isset($_POST['idCust'])){
        $idCustomer = $_POST['idCust'];
    }
    else{
        $idCustomer = "6";
    }
    $query = "SELECT * FROM PRODUK WHERE ROW_ID_PRODUK=$idProduk";
    $produk = getQueryResultRow($db, $query);
    $fotoProduk="res/img/produk/".$produk['LOKASI_FOTO_PRODUK'];
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
            try {
                $query = "UPDATE PRODUK SET STOK_PRODUK = :jumlahBaru WHERE ROW_ID_PRODUK = :id";
                $stmt = $db->prepare($query);
                $stmt->bindValue(":jumlahBaru", intval($stokProduk-intval($_POST['jumlahBeliProduk'])), PDO::PARAM_INT);
                $stmt->bindValue(":id", $idProduk, PDO::PARAM_INT);
                $result = $stmt->execute();
    
            } catch (Exception $e) {
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
        <!-- Header Section -->
        <?php include("header.php"); ?>

        <main>
            <div class="container">
            <div class="row mt-5 mb-5">
                <div class="col mt-5">
                    <img src="<?= $fotoProduk?>" width="500px" height="500px"/>
                </div>
                <div class="col mt-5">
                    <h1 class="display-5 font-weight-bold mb-4"><?=$namaProduk?></h1>
                    <h2 class="mb-4" style="color: grey">Rp. <?=number_format($hargaProduk)?></h2>
                    <form method="POST">
                        <input type="hidden" name="idProduk" value="<?=$idProduk?>">
                        <input type="hidden" name="idCust" value="<?=$idCustomer?>">
                        <div class="input-group mb-3">
                            <input type="text" name="jumlahBeliProduk" class="form-control" placeholder="1" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">of <?=$stokProduk." ".strtolower("$satuanProduk")?></span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-info" name="btnWishlist">
                        Add To Wishlist</button>
                        <button type="submit" class="btn btn-success" name="btnBeli"> <i class="fas fa-shopping-cart"></i>
                        &nbsp;&nbsp;&nbsp;Buy Now</button>
                    </form>
                    </br></br>
                </div>
            </div>
        </main>
        <div id="tabs" class="container">
                <ul>
                    <li><a href="#tabs-1">PRODUCT DESCRIPTION</a></li>
                    <li><a href="#tabs-2">OTHER INFORMATION</a></li>
                </ul>
                <div id="tabs-1">
                    <p><?=$deskripsiProduk?></p>
                </div>
                <div id="tabs-2">
                    <p>Package Dimension : </br>
                    <?= $dimensiKemasan?></p>
                    <p>Product Dimension : </br>
                    <?= $dimensiProduk?> </p>
                    <p>Product Weight : </br>
                    <?= $beratProduk?> </p>
                </div>
        </div>
        <div class="container">
        <h3 class="display-5">Similar Product :</h3>
            <?php
                $query = "SELECT * FROM KATEGORI_PRODUK WHERE ROW_ID_PRODUK = $idProduk";
                $kategoriProduk = getQueryResultRowArrays($db, $query);
                foreach ($kategoriProduk as $key => $value) {
                        $kategoriParent=$value['ROW_ID_KATEGORI_PARENT'];
                        $kategoriChild=$value['ROW_ID_KATEGORI_CHILD'];
                    }
                $query = "SELECT * FROM KATEGORI_PRODUK WHERE ROW_ID_PRODUK != $idProduk";
                $kategoriProduk = getQueryResultRowArrays($db, $query);
                $ctrId = [];
                $ctr=0;
                if(isset($kategoriParent)){
                    foreach ($kategoriProduk as $key => $value) {
                        if($value['ROW_ID_KATEGORI_PARENT'] == $kategoriParent && $value['ROW_ID_KATEGORI_CHILD'] == $kategoriChild){
                                $ctrId[$ctr] = $value['ROW_ID_PRODUK'];
                                $ctr = $ctr+1;
                        }
                    }
                    $query = "SELECT * FROM PRODUK";
                    $produk = getQueryResultRowArrays($db, $query);
                    if($ctr!=""){
                        foreach ($produk as $key => $value) {
                            if($ctr>0){
                                if($value['ROW_ID_PRODUK']==$ctrId[$ctr-1]){
                                    ?>
                                    <form method="post">
                                        <input type="hidden" name="idProduk" value="<?= $value['ROW_ID_PRODUK']?>"/>
                                        <button type="submit" class="btn btn-link"><img src="<?= "res/img/produk/".$value['LOKASI_FOTO_PRODUK'];?>" width="200px" height="200px"/></button>
                                    </form>
                                    <?php
                                    $ctr = $ctr-1;
                                }
                            }
                            else{
                                break;
                            }
                        }
                    }
                    else{
                        ?>
                        <h2 class="display-5">There are no similar product</h2>
                        <?php
                    }
                }
            else{
                ?>
                <h2 class="display-5">There are no similar product</h2>
                <?php
            }
            ?>
        </div>
        <!-- Button Contact Us -->
        <div class="text-center my-3">
        <a class="btn btn-lg btn-dark" href="contactus.php" role="button">CONTACT US</a>
        </div>

        <!-- Footer Section -->
        <?php include("footer.php"); ?>
    </body>
</html>