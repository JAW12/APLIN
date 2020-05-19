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
        
        <title>Product Detail</title>
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
        $fotoProduk = "res/img/no-image.png";
        if (!empty($produk['LOKASI_FOTO_PRODUK'])) {
            $fotoProduk="res/img/produk/".$produk['LOKASI_FOTO_PRODUK']."?".time();
        }            
        $namaProduk=$produk['NAMA_PRODUK'];
        $hargaProduk=$produk['HARGA_PRODUK'];
        $stokProduk=$produk['STOK_PRODUK'];
        $deskripsiProduk=$produk['DESKRIPSI_PRODUK'];
        $dimensiKemasan=$produk['DIMENSI_KEMASAN'];
        $dimensiProduk=$produk['DIMENSI_PRODUK'];
        $beratProduk=$produk['BERAT_PRODUK'];
        $satuanProduk=$produk['SATUAN_PRODUK'];
        ?>
        <div class="container" id="succeessAdd">

        </div>
        <main>
            <div class="container">
            <div class="row mt-3 mb-5">
                <div class="col">
                    <figure><img src="<?= $fotoProduk?>" width="500px" height="500px"/></figure>
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
                        <form method="POST" id="addCart">
                            <input type="hidden" name="idProduk" value="<?=$idProduk?>">
                            <input type="hidden" name="idCust" value="<?=$idCustomer?>">
                            <input type="hidden" name="stokProduk" value="<?=$stokProduk?>">
                            <?php
                            if($jenisUser != ""){
                            ?>
                                <?php
                                if($stokProduk > 0){
                                ?>
                                <div class="input-group mb-3">
                                    <input type="number" name="jumlahBeliProduk" class="form-control" placeholder="1" aria-describedby="basic-addon2" min="1" value="1" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">of <?=$stokProduk." ".strtolower("$satuanProduk")?></span>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success form-control" name="btnBeli" id="btnAdd"> <i class="fas fa-shopping-cart"></i>
                                &nbsp;&nbsp;&nbsp;Buy Now</button>
                                <button type='button' class='btn btn-warning w-100 rounded my-2' name='addToWishlist' onclick=addtowish('<?=$idProduk?>') formaction='wishlist.php'>Add to Wishlist</button>
                            <?php
                                }
                                else{
                                    ?>
                                    <button type="submit" style="pointer-events: none;" class="btn btn-danger form-control disabled" name="btnBeli"> <i class="fas fa-times"></i>
                                    &nbsp;&nbsp;&nbsp;Out of Stock</button>
                                    <button type='button' class='btn btn-warning w-100 rounded my-2' name='addToWishlist' onclick=addtowish('<?=$idProduk?>') formaction='wishlist.php'>Add to Wishlist</button>
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
        <div class="container">
            <?php
            $query = "SELECT * FROM PRODUK WHERE ROW_ID_PRODUK=$idProduk";
            $produk = getQueryResultRowArrays($db, $query);
            ?>
            <ul class="nav nav-tabs mt-3">
                <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#home">Product Description</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#menu1">Other Information</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div id="home" class="container tab-pane active" style="min-height: 225px;"><br>
                <p><?= $produk[0]["DESKRIPSI_PRODUK"];?></p>
                </div>
                <div id="menu1" class="container tab-pane fade"><br>
                <h6>Package Dimension</h6>
                <p><?= $produk[0]["DIMENSI_KEMASAN"];?></p>
                <h6>Product Dimension</h6>
                <p><?= $produk[0]["DIMENSI_PRODUK"];?></p>
                <h6>Product Weight</h6>
                <p><?= $produk[0]["BERAT_PRODUK"];?></p>
                </div>
            </div>
        </div>
        <div class="container px-1 pl-1">
            <h3 class="display-4 mt-3">Similar Product :</h3>
            <div class="row row-cols-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-4 card-deck">
            <?php
                $query = "SELECT * FROM KATEGORI_PRODUK WHERE ROW_ID_PRODUK = $idProduk";
                // $kategoriProduk = getQueryResultRowArrays($db, $query);
                // foreach ($kategoriProduk as $key => $value) {
                //     $kategoriParent=$value['ROW_ID_KATEGORI_PARENT'];
                //     $kategoriChild=$value['ROW_ID_KATEGORI_CHILD'];
                // }
                $kategoriProduk = getQueryResultRow($db, $query);
                $kategoriParent = $kategoriProduk['ROW_ID_KATEGORI_PARENT'];
                $kategoriChild = $kategoriProduk['ROW_ID_KATEGORI_CHILD'];
                // $query = "SELECT * FROM KATEGORI_PRODUK WHERE ROW_ID_PRODUK != $idProduk";
                // $kategoriProduk = getQueryResultRowArrays($db, $query);
                // $ctrId = [];
                // $ctr=0;
                if(isset($kategoriParent)){
                    // foreach ($kategoriProduk as $key => $value) {
                    //     if($value['ROW_ID_KATEGORI_PARENT'] == $kategoriParent && $value['ROW_ID_KATEGORI_CHILD'] == $kategoriChild){
                    //             $ctrId[$ctr] = $value['ROW_ID_PRODUK'];
                    //             $ctr = $ctr+1;
                    //     }
                    // }
                    // $query = "SELECT * FROM PRODUK WHERE 1=2";
                    $query = "SELECT * FROM PRODUK P, KATEGORI_PRODUK KP WHERE P.ROW_ID_PRODUK = KP.ROW_ID_PRODUK AND KP.ROW_ID_KATEGORI_PARENT = {$kategoriParent} AND KP.ROW_ID_KATEGORI_CHILD = {$kategoriChild} AND STATUS_AKTIF_PRODUK = 1 ORDER BY P.NAMA_PRODUK ASC LIMIT 5";
                    $produk = getQueryResultRowArrays($db, $query);
                    $ctr = count($produk);
                    if($ctr!="" && $ctr>0){
                        // while($ctr>0){
                            foreach ($produk as $key => $value) {
                                // if($value['ROW_ID_PRODUK']==$ctrId[$ctr-1]){
                                    $fotoSimiliar = "res/img/no-image.png";
                                    if (!empty($value['LOKASI_FOTO_PRODUK'])) {
                                        $fotoSimiliar = "res/img/produk/".$value['LOKASI_FOTO_PRODUK']."?".time();
                                    }
                                    ?>
                                    <div class="card border-0 hover-shadow my-4 p-3" style="width: 18rem;box-sizing: border-box">
                                        <form method="post">
                                            <input type="hidden" name="idProduk" value="<?= $value['ROW_ID_PRODUK']?>"/>
                                            <button type="submit" class="btn btn-link"><img src="<?= $fotoSimiliar ?>" width="200px" height="200px"/></button>
                                        </form>
                                    </div>
                                    <?php
                                    // $ctr = $ctr-1;
                                    // if($ctr == 0){
                                    //     break;
                                    // }
                                // }
                            }
                        // }
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

        <div id="alert"></div>
        <!-- Footer Section -->
        <?php include("footer.php"); ?>

        <script>

            $("#addCart").submit(function(e){
                e.preventDefault();
                $.ajax({
                    method : "POST",
                    url : "ajax-product-detail.php",
                    data : $("#addCart").serialize(),
                    success : function(res){
                        $("#succeessAdd").html(res);
                    }
                });
            });

            function addtowish(idproduk) {
                $.post("addtowish.php", 
                    { idproduk: idproduk },
                    function(result) {
                        $("#alert").html(result);
                        $("#alertModal").modal();
                    }
                );
            }
        </script>
    </body>
</html>
