<?php
include __DIR__."/system/load.php";

if(!isset($_POST['idProduk'])){
    header("location: product-list.php");
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
        <!-- <link href="style/index.css" rel="stylesheet"> -->
        <title>All Reviews For <?=$_POST['namaProduk']?></title>
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

            .ui-tabs .ui-tabs-nav li a {font-size:12pt !important;}

            #tabs p {font-size: 11pt !important;};

            
        </style>
    </head>
    <body id="page-top">
        <main>
            <!-- <div class="spaceatas"></div> -->
            <!-- Header Section -->
            <?php include("header.php");?>
            
            <div id="judul" class="container-fluid text-center my-5" style="background-image: url('res/img/bg18.jpg');">
                <h1 class="text-light display-3 font-weight-bold">
                    All Reviews
                </h1>
            </div>

            <div class="container bg-light mb-3">
                <h2>Reviewed Product</h2>
                <div class="row">
                    <div class="col-3">
                        <?php
                            $query = "SELECT * FROM PRODUK WHERE ROW_ID_PRODUK=$_POST[idProduk]";
                            $produk = getQueryResultRowArrays($db, $query);
                        ?>
                        <div style="width: 100%; height: 100%; background-image: url(res/img/produk/<?=$produk[0]['LOKASI_FOTO_PRODUK']."?".time(); ?>); background-size: contain; background-repeat: no-repeat;  background-position: center;"></div>
                    </div>
                    <div class="col-9">
                        <h3><?= $produk[0]["NAMA_PRODUK"];?></h3>
                        <h4>Rp. <?= number_format($produk[0]["HARGA_PRODUK"], 0, ',', '.')?></h4>
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
                    </div>
                    <hr>
                </div>
            </div>

            <div class="container">
                <?php
                    $query = "SELECT * FROM REVIEW_PRODUK WHERE ROW_ID_PRODUK=$_POST[idProduk] ORDER BY WAKTU_REVIEW DESC";
                    $review = getQueryResultRowArrays($db, $query);
                    foreach ($review as $key => $value) {
                        $temp = $value['BINTANG_REVIEW'];
                        $waktu = $value['WAKTU_REVIEW'];
                        $namaCust = getCustomerName($db,$value['ROW_ID_CUSTOMER']);
                        $isi = $value['KONTEN_REVIEW'];
                        ?>
                            <div class="row mb-3">
                                <div class="col-3">
                                    <h4><?=$namaCust[0]['NAME'] ?></h4>
                                    <h6><?= getDateFormatted($waktu)?></h6>
                                </div>
                                <div class="col-9">
                                    <div class="float-right">
                                    <?php
                                        for ($i=0; $i < $temp; $i++) {
                                            echo "<i class='fas fa-star' style='color: orange'></i>";
                                        }
                                    ?>
                                    </div>
                                    <br>
                                    <div class="text-justify">
                                        <?=$isi?>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        <?php
                    }
                ?>
            </div>
        </main>
        <!-- Footer Section -->
        <?php include("footer.php");?>
        <script>
            $( function() {
                $( "#tabs" ).tabs();
            });
        </script>
    </body>
</html>
<!-- <div class="float-right">
?php
for ($i=0; $i < $temp; $i++) {
    echo "<i class='fas fa-star' style='color: orange'></i>";
}
?>
</div> -->