<?php
    include "system/load.php";

    cekLogin($db, "", $login);

    if (isset($login)) {
        $jenisUser = "admin";
        $rowIdUserAktif = -1;
        if ($login['role'] == 1) {
            $jenisUser = "customer";
        }
        
        if ($jenisUser == "customer") {
            $dataCustomer = getCustomerData($db, $login['username']);
            $rowIdUserAktif = $dataCustomer['ROW_ID_CUSTOMER'];
        }
    }
    
    //--- function ----
    function getListProduk($db){
        $query = "SELECT * FROM PRODUK";
        $condition = "";
        if (isset($_GET['q']) && !empty($_GET['q'])) {
            $condition = $condition . " LOWER(NAMA_PRODUK) LIKE '%{$_GET['q']}%'";
        }
        if (isset($_GET['min']) && !empty($_GET['min'])) {
            $value = $_GET['min'];
            if ($condition != "") {
                $condition = $condition . " AND ";
            } 
            $condition = $condition . " HARGA_PRODUK >= $value ";
        }
        if (isset($_GET['max']) && !empty($_GET['max'])) {
            $value = $_GET['max'];
            if ($condition != "") {
                $condition = $condition . " AND ";
            } 
            $condition = $condition ." HARGA_PRODUK <= $value ";
        }
        if (isset($_GET['availableProduct']) && $_GET['availableProduct'] == "true") {
            if ($condition != "") {
                $condition = $condition . " AND ";
            } 
            $condition = $condition . " STOK_PRODUK > 0 ";
        }
        if ($condition != "") {
            $query = $query . " WHERE ";
        }
        $query = $query . $condition;
        $listProduk = getQueryResultRowArrays($db, $query);
        return $listProduk;
    }

    function showCardProduk($db, $jenisUser, $listProduk){
        if ($listProduk == false) {
            showAlertDiv("We can't find products matching the selection");
        }
        else{
            ?>
            <div class="container-fluid px-1 my-3 mt-5 pl-1">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 card-deck">
                    <?php
                    foreach ($listProduk as $key => $value) {
                        $lokasiFotoProduk = "res/img/produk/".$value['LOKASI_FOTO_PRODUK'];
                        $cl = "";
                        $text = "&nbsp;";
                        if (intval($value['STOK_PRODUK']) <= 0) {
                            $text = "Out of Stock";
                            $cl = "grayscale";
                        }
                        ?>
                            <form method="POST">                            
                                <div class="card border-0 hover-shadow my-4 p-3" style="width: 18rem;box-sizing: border-box">
                                    <div>
                                        <img width="256px" height="256px" src="<?= $lokasiFotoProduk ?>" class="card-img-top <?= $cl ?>" alt="gambar produk">
                                    </div>
                                    <div class="card-body">
                                        <!-- <h5 class="card-title"><?= $value['NAMA_PRODUK'] ?></h5> -->
                                        <p class="card-text">
                                            <?php echo "<p class='font-weight-bold text-danger text-right'> $text </p>" ?>
                                            <p class="font-weight-bold text-left">
                                                Rp. <?= getSeparatorNumberFormatted($value['HARGA_PRODUK']) ?>
                                            </p><br/>
                                            <p>
                                                <button class="btn btn-link text-left text-dark text-decoration-none" style="width : 230px;height:100px;" name="lihatDetail" formaction="product-detail.php">
                                                    <?= $value['NAMA_PRODUK'] ?>
                                                </button>                                                 
                                            </p>
                                        </p>                            
                                    </div>
                                    <div class="card-button p-2 d-flex flex-wrap justify-content-around my-2 mt-n1">
                                        <input type="hidden" name="idProduk" value="<?= $value['ROW_ID_PRODUK'] ?>">
                                        <button class="btn btn-primary w-100 rounded my-2" name="lihatDetail" formaction="product-detail.php">View Detail</button>    
                                        <?php
                                            if ($jenisUser == "customer") {
                                                ?>
                                                    <button class="btn btn-warning w-100 rounded my-2" name="addToWishlist" formaction="wishlist.php">Add to Wishlist</button> 
                                                <?php
                                            }
                                        ?>
                                    </div>
                                </div>              
                            </form>                        
                        <?php
                    }
                    ?>                  
                </div>    
            </div>
            <?php
        }
    }

    //---- form php ----
    $showBarang = false;
    if (isset($_POST['showBarang'])) {
        $showBarang = true;
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
        <style>
            .hover-shadow{
                box-shadow: 0px 0px 0px white;
            }

            .hover-shadow:hover{
                box-shadow: 0px 0px 10px lightgrey;                
            }

            .card-button{
                display: none;
            }

            .grayscale{
                filter: grayscale(100%);
            }

            #judul{
                padding: 0;
                padding-top: 5%;

                padding-bottom: 5%;
                background-repeat:no-repeat;
                background-size: cover;
            }

        </style>

        <!-- JS Sendiri -->
        <title>Product List</title>
    </head>
    <body id="page-top">
        <!-- Header Section -->
        <?php include ("header.php"); ?>

        <!-- Main Section -->
        <main>
            <!-- kalau mau pake space ga ush dicomment -->
            <div id="judul" class="col-12 text-center my-5" style="background-image: url('res/img/bg9.jpg');">
                <h1 class="text-light display-3 font-weight-bold">
                    Product List
                </h1>
            </div>

            <!-- <div class="spaceatas">
                <br/>
            </div> -->
            
            <!-- filter -->
            <div class="container-fluid my-2">
                <div class="container-fluid my-2 d-flex flex-nowrap justify-content-around">
                    <form method="GET" class="form-inline">
                        <?php
                            $keyword = ""; $min = "" ; $max = ""; $checkedStatus = "";
                            if (isset($_GET['q']) && !empty($_GET['q'])) {
                                $keyword = $_GET['q'];
                            }
                            if (isset($_GET['min']) && !empty($_GET['min'])) {
                                $min = $_GET['min'];
                            }
                            if (isset($_GET['max']) && !empty($_GET['max'])) {
                                $max = $_GET['max'];
                            }
                            if (isset($_GET['availableProduct']) && $_GET['availableProduct'] == "true") {
                                $checkedStatus = "checked";
                            }
                        ?>
                        <input type="text" class="form-control mx-2" placeholder="Product Name" name="q" value="<?= $keyword ?>">
                        <input type="number" class="form-control mx-2" placeholder="Minimum Price" name="min" value="<?= $min ?>">
                        <input type="number" class="form-control mx-2" placeholder="Maximum Price" name="max" value="<?= $max ?>">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="cbAvailableProduct" value="true" name="availableProduct" <?= $checkedStatus ?>>
                            <label class="form-check-label" for="cbAvailableProduct">Available Products</label>
                        </div>
                        <button type="submit" class="btn btn-info mx-3">Filter</button>
                        <button type="submit" class="btn btn-info mr-3" formaction="product-list.php">Reset Filter</button>
                        <?php
                            if ($jenisUser == "admin") {
                                ?>
                                    <button type="submit" class="btn btn-warning mr-3" formaction="master-product.php">Master Product</a>
                                <?php
                            }
                        ?>
                    </form>    
                </div>
            </div>

            <section class="w-80">
                <!-- content start here, silahkan dihapus tes tes nya dibawah kalau sudah mulai-->
                <div class="container-fluid">
                    <?php 
                        $listProduk = getListProduk($db);
                        showCardProduk($db, $jenisUser, $listProduk);
                    ?>
                </div>
            </section>

            <!-- Button Contact Us -->
            <div class="text-center my-3">
                <a class="btn btn-lg btn-dark" href="contactus.php" role="button">CONTACT US</a>
            </div>
        </main>

        <!-- Footer Section -->
        <?php include ("footer.php"); ?>
    </body>
</html>