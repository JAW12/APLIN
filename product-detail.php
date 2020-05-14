<?php
include __DIR__."/system/load.php";

if(!isset($_GET['idProduk'])){
    header("location: product-list.php");
}
$jenisUser = "";
if(isset($_SESSION['login'])){
    if($_SESSION['login']['username'] == "admin"){
        $jenisUser = "admin";
    }
    else{
        $jenisUser = "customer";
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
        <script src="script/index.js"></script>

        <!-- CSS Sendiri -->
        <link href="style/index.css" rel="stylesheet">
        
        <title>Detail Produk</title>
    </head>
    <body id="page-top">
        <div class="spaceatas"></br></br></div>
        <!-- Header Section -->
        <?php include("header.php");

        if(isset($_GET['idProduk'])){
            $idProduk = $_GET['idProduk'];
        }
        if(isset($_POST['idProduk'])){
            $idProduk = $_POST['idProduk'];
        }
        if(isset($_SESSION['login'])&&  $jenisUser == "customer"){
            $idCustomer = $_SESSION['login']['row_id_customer'];
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
            if($_POST['jumlahBeliProduk'] > $stokProduk){
                showAlertDiv('The amount you requested is currently unavailable');
            }
            else{
                $query = "SELECT * FROM CART WHERE ROW_ID_PRODUK = $_POST[idProduk] AND ROW_ID_CUSTOMER = $idCustomer";
                $cekCart = getQueryResultRowArrays($db, $query);
                if(count($cekCart) > 0){
                    try{
                        $query = "UPDATE CART SET QTY = :qty WHERE ROW_ID_PRODUK = :produk AND ROW_ID_CUSTOMER = :cust";
                        $stmt = $db->prepare($query);
                        $qty = $cekCart[0]['QTY'];
                        $qty = $qty + $_POST['jumlahBeliProduk'];
                        $stmt->bindValue(":qty", $qty);
                        $stmt->bindValue(":produk", $_POST['idProduk']);
                        $stmt->bindValue(":cust", $idCustomer);
                        $result = $stmt->execute();
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
                    showInfoDiv('Success adding to cart');
                }
                else{
                    try {
                        $query = "INSERT INTO CART VALUES(:idCust, :idProduk, :qty)";
                        $stmt = $db->prepare($query);
                        $stmt->bindValue(":idCust", $idCustomer, PDO::PARAM_INT);
                        $stmt->bindValue(":idProduk", $_POST['idProduk'], PDO::PARAM_INT);
                        $stmt->bindValue(":qty", $_POST['jumlahBeliProduk'], PDO::PARAM_INT);
                        $result = $stmt->execute();
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
                    showInfoDiv('Success adding to cart');
                }
            }
        }
        ?>
        <main>
            <div class="container">
            <div class="row mt-3 mb-5">
                <div class="col">
                    <img src="<?= $fotoProduk?>" width="500px" height="500px"/>
                </div>
                <div class="col mt-5">
                    <h1 class="display-5 font-weight-bold mb-4"><?=$namaProduk?></h1>
                    <h2 class="mb-4" style="color: grey">Rp. <?=number_format($hargaProduk, 0, ',', '.')?></h2>
                    <?php
                    if ($jenisUser == "admin") {
                        ?>
                        <form method="POST">
                            <input type="hidden" name="idProduk" value="<?=$idProduk?>">
                            <button type="submit" class="btn btn-warning mr-3" formaction="master-product.php">Edit Product</button>
                        </form>
                        <?php
                    }
                    else{
                        ?>
                        <form method="POST">
                            <input type="hidden" name="idProduk" value="<?=$idProduk?>">
                            <input type="hidden" name="idCust" value="<?=$idCustomer?>">
                            <div class="input-group mb-3">
                                <input type="number" name="jumlahBeliProduk" class="form-control" placeholder="1" aria-describedby="basic-addon2" min="1" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">of <?=$stokProduk." ".strtolower("$satuanProduk")?></span>
                                </div>
                            </div>
                            <?php
                            if($jenisUser != ""){
                            ?>
                                <button type='button' class='btn btn-warning w-100 rounded my-2' name='addToWishlist' onclick=addtowish('<?=$idProduk?>') formaction='wishlist.php'>Add to Wishlist</button>
                                <?php
                                if($stokProduk > 0){
                                ?>
                                <button type="submit" class="btn btn-success form-control" name="btnBeli"> <i class="fas fa-shopping-cart"></i>
                                &nbsp;&nbsp;&nbsp;Buy Now</button>
                            <?php
                                }
                                else{
                                    ?>
                                    <button type="submit" style="pointer-events: none;" class="btn btn-danger form-control disabled" name="btnBeli"> <i class="fas fa-times"></i>
                                    &nbsp;&nbsp;&nbsp;Out of Stock</button>
                                    <?php
                                }
                            }
                            ?>
                        </form>
                        <?php
                    }
                    $query = "SELECT * FROM REVIEW_PRODUK WHERE ROW_ID_PRODUK=$idProduk";
                    $review = getQueryResultRowArrays($db, $query);
                    $temp=-1;
                    foreach ($review as $key => $value) {
                        if($temp<$value['BINTANG_REVIEW']){
                            $temp = $value['BINTANG_REVIEW'];
                            $waktu = $value['WAKTU_REVIEW'];
                            $namaCust = getCustomerName($db,$value['ROW_ID_CUSTOMER']);
                            $isi = $value['KONTEN_REVIEW'];
                            $idReview = $value['ROW_ID_PRODUK'];
                        }
                    }
                    ?>
                    <h3 class="display-5 mt-4">Product Review (<?= count($review)?>):</h3>
                    <?php
                    if(count($review)==0){
                        ?>
                        <h4 class="display-5 mb-4">This product does not have a review yet</h4>
                        <?php
                    }
                    else{
                        ?>
                        <div class="float-right">
                        <?php
                        for ($i=0; $i < $temp; $i++) {
                            echo "<i class='fas fa-star' style='color: orange'></i>";
                        }
                        ?>
                        </div>
                        <?=$namaCust[0]['NAME']?> &nbsp;&nbsp;<?=$waktu?>
                        <div class="mt-3" style="width: 100%; height: 150px; overflow-y: auto;">
                            <?php
                            echo $isi;
                            ?>
                        </div>
                        <form method="POST">
                            <input type="hidden" name="idProduk" value="<?= $idReview ?>">
                            <input type="hidden" name="namaProduk" value="<?=$namaProduk?>">
                            <button type="submit" class="btn text-center form-control mt-4" style="background-color: orange" name="btnBeli" formaction="showReview.php">See All Other Reviews</button>
                        </form>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </main>
        <div id="tabs" class="container">
                <ul>
                    <li><a href="#tabs-1">Product Description</a></li>
                    <li><a href="#tabs-2">Other Information</a></li>
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
        <div class="container px-1 pl-1">
            <h3 class="display-4 mt-3">Similar Product :</h3>
            <div class="row row-cols-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-4 card-deck">
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
                    if($ctr!="" && $ctr>0){
                        while($ctr>0){
                            foreach ($produk as $key => $value) {
                                if($value['ROW_ID_PRODUK']==$ctrId[$ctr-1]){
                                    ?>
                                    <div class="card border-0 hover-shadow my-4 p-3" style="width: 18rem;box-sizing: border-box">
                                        <form method="post">
                                            <input type="hidden" name="idProduk" value="<?= $value['ROW_ID_PRODUK']?>"/>
                                            <button type="submit" class="btn btn-link"><img src="<?= "res/img/produk/".$value['LOKASI_FOTO_PRODUK'];?>" width="200px" height="200px"/></button>
                                        </form>
                                    </div>
                                    <?php
                                    $ctr = $ctr-1;
                                    if($ctr == 0){
                                        break;
                                    }
                                }
                            }
                        }
                    }
                    else{
                        ?>
                        <h4 class="display-5 ml-3">There are no similar product</h4>
                        <?php
                    }
                }
            else{
                ?>
                <h4 class="display-5">There are no similar product</h4>
                <?php
            }
            ?>
            </div>
        </div>
        <!-- Footer Section -->
        <?php include("footer.php"); ?>

        <script>
            $( function() {
                $( "#tabs" ).tabs();
            });
            
            function addtowish(idproduk) {
                $.post("addtowish.php", 
                    { idproduk: idproduk },
                    function(result) {
                        if(result=="berhasil"){
                        alert('Success adding to WishList');
                        }
                        else{
                            alert('Item Already in WishList');
                        }
                    }
                );
            }
        </script>
    </body>
</html>
