<?php
include "system/load.php";

$jenisUser = "";
if (isset($login) && is_array($login)) {
    $jenisUser = "admin";
    $rowIdUserAktif = -1;
    if ($login['role'] == 1) {
        $jenisUser = "customer";
    }
    
    if ($jenisUser == "customer") {
        header("location: login.php");
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

        <!-- JS Sendiri -->

        <title>Master Product</title>
    </head>
    <body id="page-top">
        <!-- Header Section -->
        <?php include("header.php"); 
        if(isset($_POST['idProduk'])){
            $query = "SELECT * FROM PRODUK WHERE ROW_ID_PRODUK=$_POST[idProduk]";
            $produk = getQueryResultRow($db,$query);
            $namaProduk=$produk['NAMA_PRODUK'];
            $hargaProduk=$produk['HARGA_PRODUK'];
            $dimensiKemasan=$produk['DIMENSI_KEMASAN'];
            $dimensiProduk=$produk['DIMENSI_PRODUK'];
            $beratProduk=$produk['BERAT_PRODUK'];
            $satuanProduk=$produk['SATUAN_PRODUK'];
            $deskripsiProduk=$produk['DESKRIPSI_PRODUK'];
            $fotoProduk=$produk['LOKASI_FOTO_PRODUK'];
            $stokProduk=$produk['STOK_PRODUK'];
        }
        ?>

        <!-- Main Section -->
        <main>
            
            <!-- container -> jarak ikut bootstrap, container-fluid -> jarak full width, w-(ukuran) -> sesuai persentase, contoh w-80 -> 80% -->
            <section class="w-80">
                <div class="h1 text-center" style="margin-top: 2%; margin-bottom: 3%">Master Product</div>
                <form id="formInsert" class="container">
                    Product Name : </br>
                    <input type="text" class="form-control" name="productName" value="<?= isset($_POST['idProduk']) ? $namaProduk : "" ?>" /></br>
                    Product Price : </br>
                    <input type="number" class="form-control" name="productPrice" value="<?= isset($_POST['idProduk']) ? $hargaProduk : "" ?>" /></br>
                    <?php
                    if(isset($_POST['idProduk'])){
                        echo "<input type=hidden name='cek' value='$_POST[idProduk]'/>";
                        ?>
                        Product Status : </br>
                        <input type="radio" name="productStatus" value="1" checked>
                        <label >Active</label><br>
                        <input type="radio" name="productStatus" value="0">
                        <label>Inactive</label><br>
                        <?php
                    }
                    ?>
                    Package Dimension : </br>
                    <input type="text" class="form-control" name="productPackageDimension" value="<?= isset($_POST['idProduk']) ? $dimensiKemasan : "" ?>" /></br>
                    Product Dimension : </br>
                    <input type="text" class="form-control" name="productDimension" value="<?= isset($_POST['idProduk']) ? $dimensiProduk : "" ?>" /></br>
                    Product Weight : </br>
                    <input type="text" class="form-control" name="productWeight" value="<?= isset($_POST['idProduk']) ? $beratProduk : "" ?>" /></br>
                    Product Units : </br>
                    <input type="text" class="form-control" name="productUnit" value="<?= isset($_POST['idProduk']) ? $satuanProduk : "" ?>" /></br>
                    Product Description : </br>
                    <textarea class="form-control" name="productDescription" rows="6" value="<?= isset($_POST['idProduk']) ? $deskripsiProduk : "" ?>"><?= isset($_POST['idProduk']) ? $deskripsiProduk : "" ?></textarea></br>
                    Product Image : </br>
                    <input type="file" class="form-control-file" name="productImage" value="<?= isset($_POST['idProduk']) ? $fotoProduk : "" ?>"></br>
                    Product Stock : </br>
                    <input type="number" class="form-control" name="productStock" value="<?= isset($_POST['idProduk']) ? $stokProduk : "" ?>" /></br>
                    </br>
                    <button type="submit" class="btn btn-success"><?= isset($_POST['idProduk']) ? "Edit Product" : "Add Product" ?></button>
                </form>
            </section>
        </main>

        <!-- Footer Section -->
        <?php include("footer.php"); ?>
    </body>
</html>
<script>
    $(function(){
        $("#formInsert").submit(function(e){
            e.preventDefault();

            $.ajax({
                method: "post",
                url: "ajax-master-product.php",
                data : $("#formInsert").serialize(),
                success : function(res){
                    alert(res);
                }
            })
        });
    });
</script>