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
        <link href="style/index.css" rel="stylesheet">
        <title>All Reviews For <?=$_POST['namaProduk']?></title>
    </head>
    <body id="page-top">
        <main>
            <div class="spaceatas"></br></br></div>
            <!-- Header Section -->
            <?php include("header.php");?>
            <div class="h1 text-center" style="margin-top: 2%; margin-bottom: 3%">All Reviews</div>
            <div class="container text-center">
                <?php
                    $query = "SELECT * FROM REVIEW_PRODUK WHERE ROW_ID_PRODUK=$_POST[idProduk] ORDER BY BINTANG_REVIEW";
                    $review = getQueryResultRowArrays($db, $query);
                    foreach ($review as $key => $value) {
                        $temp = $value['BINTANG_REVIEW'];
                        $waktu = $value['WAKTU_REVIEW'];
                        $namaCust = getCustomerName($db,$value['ROW_ID_CUSTOMER']);
                        $isi = $value['KONTEN_REVIEW'];
                        ?>
                        <div class="text-center">
                            <?=$namaCust[0]['NAME']?> &nbsp;&nbsp;<?=$waktu?>
                            <div class="float-right">
                            <?php
                            for ($i=0; $i < $temp; $i++) {
                                echo "<i class='fas fa-star' style='color: orange'></i>";
                            }
                            ?>
                            </div>
                        </div>
                        <div style="background-color:lightgray">
                            <div class="text-justify">
                                <?=$isi?>
                            </div>
                        </div>
                        <hr class="border border-dark mt-0 mb-5">
                        <?php
                    }
                ?>
            </div>
        </main>
        <!-- Footer Section -->
        <?php include("footer.php");?>
    </body>
</html>
<!-- <div class="float-right">
?php
for ($i=0; $i < $temp; $i++) {
    echo "<i class='fas fa-star' style='color: orange'></i>";
}
?>
</div> -->