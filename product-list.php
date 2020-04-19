<?php
    include "conn.php";

    // ngambil nama produk dari row pertama
    // $query = "SELECT NAMA_PRODUK FROM PRODUK";
    // $nama = getQueryResultRowField($db, $query,"NAMA_PRODUK");
    // showAlert(strval($nama));

    //--- function ----
    function showCardProduk($db){
        $query = "SELECT * FROM PRODUK";
        $condition = "";
        if (isset($_GET['q'])) {
            $condition = " WHERE LOWER(NAMA_PRODUK) LIKE '%{$_GET['q']}%'";
        }
        $query = $query . $condition;
        $listProduk = getQueryResultRowArrays($db, $query);
        if ($listProduk == false) {
            showAlert("list produk tidak ada");
        }
        else{
            ?>
            <div class="container-fluid px-2 my-3 d-flex justify-content-around">
                <!-- <div class="col-2">
                    <label>Harga</label>
                </div> -->
                <div class="col-12">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 card-deck">
                        <?php
                        // echo "<pre>";
                        // print_r($listProduk);
                        // echo "</pre>";
                        foreach ($listProduk as $key => $value) {
                            $lokasiFotoProduk = "res/img/produk/".$value['LOKASI_FOTO_PRODUK'];
                            ?>
                                <form method="POST">                            
                                    <div class="card border-0 hover-shadow my-4 p-3" style="width: 18rem;box-sizing: border-box">
                                        <div>
                                            <img width="256px" height="256px" src="<?= $lokasiFotoProduk ?>" class="card-img-top" alt="gambar produk">
                                        </div>
                                        <div class="card-body">
                                            <!-- <h5 class="card-title"><?= $value['NAMA_PRODUK'] ?></h5> -->
                                            <p class="card-text">
                                                <?php
                                                    if (intval($value['STOK_PRODUK']) <= 0) {
                                                        echo "<p class='font-weight-bold text-danger text-right'>Out of Stock</p>";
                                                    }
                                                    else{                                                
                                                        echo "<p> &nbsp; </p>";
                                                    }
                                                ?>
                                                <p class="font-weight-bold text-left">
                                                    Rp. <?= $value['HARGA_PRODUK'] ?>
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
                                            <button class="btn btn-warning w-100 rounded my-2" name="addToWishlist" formaction="wishlist.php">Add to Wishlist</button>                           
                                        </div>
                                    </div>              
                                </form>                        
                            <?php
                        }
                        ?>                  
                    </div>        
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
        </style>

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
                    <!-- <form class="form-inline my-2 my-lg-0 mr-3">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Search</button>
                    </form> -->
                    <a class="btn btn-primary" href="login.php" role="button">Login</a>
                </div>
            </nav>
        </header>

        <!-- Main Section -->
        <main>
            <!-- kalau mau pake space ga ush dicomment -->
            <div class="spaceatas"></div>
            
            <!-- container -> jarak ikut bootstrap, container-fluid -> jarak full width, w-(ukuran) -> sesuai persentase, contoh w-80 -> 80% -->
            <div class="container">
                <div class="container-fluid px-2 my-3 d-flex flex-nowrap justify-content-around">
                    <div class="col-2">
                        &nbsp;
                    </div>
                    <div class="col-10">        
                        <form method="GET" class="form-inline">
                            <?php
                                $keyword = "";
                                if (isset($_GET['q'])) {
                                    $keyword = $_GET['q'];
                                }                                
                            ?>
                            <input type="text" class="form-control ml-5" style="width: 60%" placeholder="Search Products By Name" 
                            name="q" value='<?= $keyword ?>'>                
                            <button type="submit" class="btn btn-info ml-3">Search</button>
                            <!-- <a href="master-product.php" class="btn btn-danger ml-3">Master Product</a> -->
                        </form>       
                    </div>    
                </div>
            </div>

            <section class="w-80">
                <!-- content start here, silahkan dihapus tes tes nya dibawah kalau sudah mulai-->
                <?php showCardProduk($db);?>
            </section>

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