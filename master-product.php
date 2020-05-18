<?php
include __DIR__."/system/load.php";
$login = getDataLogin();
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
        <style>
            #judul{
                padding: 0;
                padding-top: 5%;

                padding-bottom: 5%;
                background-repeat:no-repeat;
                background-size: cover;
            }
        </style>
        <title>Master Product</title>
    </head>
    <body id="page-top">
        <!-- Header Section -->
        <div class="spaceatas"></div>
        <div id="judul" class="col-12 text-center my-5" style="background-image: url('res/img/bg12.jpg');">
            <h1 class="text-light display-3 font-weight-bold">
                Master Product
            </h1>
        </div>
        <?php
        function uploadFile($db, $file, $folderTujuan, $namaFileUpload, $rowID){
            $fileTmp = $file['tmp_name'];
            $namaAsliFileUpload = $file['name'];
        
            //upload file sesuai dgn nama yg diinputkan di form
            $namaAsliSplit = explode(".",$namaAsliFileUpload);
            $lastIdx = count($namaAsliSplit) - 1;
            $extension = $namaAsliSplit[$lastIdx];      
            
            $namaCustomFileUpload = $namaFileUpload."." .$extension;
            $destination =  __DIR__.$folderTujuan.$namaCustomFileUpload;
        
            $status = move_uploaded_file($fileTmp, $destination);
        
            if ($status != false) {
                // echo "file berhasil diupload";
        
                //update ke db
                $query = "UPDATE PRODUK SET LOKASI_FOTO_PRODUK = :lokasi WHERE ROW_ID_PRODUK = :id";
                $stmt = $db->prepare($query);
                $stmt->bindValue(":lokasi", $namaCustomFileUpload);
                $stmt->bindValue(":id", $rowID);
                $result = $stmt->execute();
        
            }
            else{
                showAlertModal('bg-danger', '<i class="fas fa-exclamation-triangle"></i>', '<h4>Uploading File Has Failed</h4>', 'Close', '');
            }    
        }
        if(isset($_POST['idProduk'])){
            $query = "SELECT * FROM PRODUK WHERE ROW_ID_PRODUK=$_POST[idProduk]";
            $produk = getQueryResultRow($db,$query);
            $namaProduk = $produk['NAMA_PRODUK'];
            $statusProduk = $produk['STATUS_AKTIF_PRODUK'];
            $hargaProduk = $produk['HARGA_PRODUK'];
            $dimensiKemasan = $produk['DIMENSI_KEMASAN'];
            $dimensiProduk = $produk['DIMENSI_PRODUK'];
            $beratProduk = $produk['BERAT_PRODUK'];
            $satuanProduk = $produk['SATUAN_PRODUK'];
            $deskripsiProduk = $produk['DESKRIPSI_PRODUK'];
            $fotoProduk = $produk['LOKASI_FOTO_PRODUK'];
            $stokProduk = $produk['STOK_PRODUK'];
            $query = "SELECT ROW_ID_KATEGORI_PARENT FROM KATEGORI_PRODUK WHERE ROW_ID_PRODUK=$_POST[idProduk]";
            $categoryParentEdit = getQueryResultRowField($db,$query,"ROW_ID_KATEGORI_PARENT");
            $query = "SELECT ROW_ID_KATEGORI_CHILD FROM KATEGORI_PRODUK WHERE ROW_ID_PRODUK=$_POST[idProduk]";
            $categoryChildEdit = getQueryResultRowField($db,$query,"ROW_ID_KATEGORI_CHILD");
            $query = "SELECT * FROM KATEGORI WHERE STATUS_PARENT = '1' AND ROW_ID_KATEGORI != $categoryParentEdit";
            $categoryParent = getQueryResultRowArrays($db,$query);
            $query = "SELECT * FROM KATEGORI WHERE STATUS_PARENT = '0' AND ROW_ID_KATEGORI != $categoryChildEdit";
            $categoryChild = getQueryResultRowArrays($db,$query);
        }
        else{
            $query = "SELECT * FROM KATEGORI WHERE STATUS_PARENT = '1'";
            $categoryParent = getQueryResultRowArrays($db,$query);
            $query = "SELECT * FROM KATEGORI WHERE STATUS_PARENT = '0'";
            $categoryChild = getQueryResultRowArrays($db,$query);
        }
        if(isset($_POST['btnSubmit'])){
            if(isset($_POST['cek'])){
                try {
                    $query = "UPDATE PRODUK SET NAMA_PRODUK = :nama, STATUS_AKTIF_PRODUK = :status, HARGA_PRODUK = :harga, DIMENSI_KEMASAN = :dimensikemasan, DIMENSI_PRODUK = :dimensiproduk, BERAT_PRODUK = :berat, SATUAN_PRODUK = :satuan, DESKRIPSI_PRODUK = :deskripsi, STOK_PRODUK = :stok WHERE ROW_ID_PRODUK = :id";
                    $stmt = $db->prepare($query);
                    $stmt->bindValue(":nama", $_POST['productName'], PDO::PARAM_STR);
                    $stmt->bindValue(":status", $_POST['productStatus'], PDO::PARAM_STR);
                    $stmt->bindValue(":harga", $_POST['productPrice'], PDO::PARAM_INT);
                    $stmt->bindValue(":dimensikemasan", $_POST['productPackageDimension'], PDO::PARAM_STR);
                    $stmt->bindValue(":dimensiproduk", $_POST['productDimension'], PDO::PARAM_STR);
                    $stmt->bindValue(":berat", $_POST['productWeight'], PDO::PARAM_STR);
                    $stmt->bindValue(":satuan", $_POST['productUnit'], PDO::PARAM_STR);
                    $stmt->bindValue(":deskripsi", $_POST['productDescription'], PDO::PARAM_LOB);
                    $stmt->bindValue(":stok", $_POST['productStock'], PDO::PARAM_INT);
                    $stmt->bindValue(":id", $_POST['cek'], PDO::PARAM_INT);
                    $result = $stmt->execute();
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
                $query = "SELECT ROW_ID_PRODUK AS 'ROW', ID_PRODUK AS 'ID' FROM PRODUK WHERE NAMA_PRODUK =  '$_POST[productName]'";
                $productId = getQueryResultRowArrays($db, $query);
                if($_FILES['productImage']['error'] <= 0){
                    uploadFile($db, $_FILES['productImage'], "/res/img/produk/", $productId[0]['ID'], $productId[0]['ROW']);
                }
                try {
                    $query = "UPDATE KATEGORI_PRODUK SET ROW_ID_KATEGORI_PARENT = :parent, ROW_ID_KATEGORI_CHILD = :child WHERE ROW_ID_PRODUK = :id";
                    $stmt = $db->prepare($query);
                    $stmt->bindValue(":parent", $_POST['productParentCategory'], PDO::PARAM_STR);
                    $stmt->bindValue(":child", $_POST['productChildCategory'], PDO::PARAM_STR);
                    $stmt->bindValue(":id", $_POST['cek'], PDO::PARAM_INT);
                    $result = $stmt->execute();
                    if ($result) {
                        header('Location: product-detail.php?idProduk='.$productId[0]['ROW']);
                    }
                } catch (Exception $e) {
                    if(isset($_POST['cek'])){
                        showInfoDiv("Failed updating product");
                    }
                    else{
                        showInfoDiv("Failed registering product");
                    }
                }
            }
            else{
                try{
                    $query = "INSERT INTO PRODUK VALUES('','', :nama, :status, :harga, :dimensikemasan, :dimensiproduk, :berat, :satuan, :deskripsi, '', :stok)";
                    $stmt = $db->prepare($query);
                    $stmt->bindValue(":nama", $_POST['productName'], PDO::PARAM_STR);
                    $stmt->bindValue(":status", 1, PDO::PARAM_STR);
                    $stmt->bindValue(":harga", intval($_POST['productPrice']), PDO::PARAM_INT);
                    $stmt->bindValue(":dimensikemasan", $_POST['productPackageDimension'], PDO::PARAM_STR);
                    $stmt->bindValue(":dimensiproduk", $_POST['productDimension'], PDO::PARAM_STR);
                    $stmt->bindValue(":berat", $_POST['productWeight'], PDO::PARAM_STR);
                    $stmt->bindValue(":satuan", $_POST['productUnit'], PDO::PARAM_STR);
                    $stmt->bindValue(":deskripsi", $_POST['productDescription'], PDO::PARAM_STR);
                    $stmt->bindValue(":stok", intval($_POST['productStock']), PDO::PARAM_INT);
                    $result = $stmt->execute();
                }catch (Exception $e) {
                    echo $e->getMessage();
                }
                $query = "SELECT ROW_ID_PRODUK AS 'ROW', ID_PRODUK AS 'ID' FROM PRODUK WHERE NAMA_PRODUK =  '$_POST[productName]'";
                $productId = getQueryResultRowArrays($db, $query);
                if(isset($_FILES['productImage'])){
                    print_r($_FILES['productImage']);
                    uploadFile($db, $_FILES['productImage'], "/res/img/produk/", $productId[0]['ID'], $productId[0]['ROW']);
                }
                try {
                    $query = "INSERT INTO KATEGORI_PRODUK VALUES(:id, :parent, :child)";
                    $stmt = $db->prepare($query);
                    $stmt->bindValue(":id", $productId[0]['ROW'], PDO::PARAM_INT);
                    $stmt->bindValue(":parent", $_POST['productParentCategory'], PDO::PARAM_INT);
                    $stmt->bindValue(":child", $_POST['productChildCategory'], PDO::PARAM_INT);
                    $result = $stmt->execute();
                } catch (Exception $e) {
                    if(isset($_POST['cek'])){
                        showInfoDiv("Failed updating product");
                    }
                    else{
                        showInfoDiv("Failed registering product");
                    }
                }
            }
            include("header.php");
        }
        ?>

        <!-- Main Section -->
        <main>
            
            <!-- container -> jarak ikut bootstrap, container-fluid -> jarak full width, w-(ukuran) -> sesuai persentase, contoh w-80 -> 80% -->
            <section class="w-80">
                <form method="POST" class="container" enctype="multipart/form-data">
                    Product Name : </br>
                    <input type="text" class="form-control" name="productName" value="<?= isset($_POST['idProduk']) ? $namaProduk : "" ?>" /></br>
                    Product Price : </br>
                    <input type="number" class="form-control" name="productPrice" value="<?= isset($_POST['idProduk']) ? $hargaProduk : "" ?>" /></br>
                    Product Parent Category : </br>
                    <select class="form-control" name="productParentCategory">
                    <?php
                    if (isset($_POST['idProduk'])){
                        $query = "SELECT * FROM KATEGORI WHERE ROW_ID_KATEGORI = $categoryParentEdit";
                        $categoryParentSelected = getQueryResultRow($db,$query);
                        echo "<option value='$categoryParentSelected[ROW_ID_KATEGORI]'>$categoryParentSelected[NAMA_KATEGORI]</option>";
                    }
                    foreach ($categoryParent as $key => $value) {
                        echo "<option value='$value[ROW_ID_KATEGORI]'>$value[NAMA_KATEGORI]</option>";
                    }
                    ?>
                    </select>
                    </br>
                    Product Child Category : </br>
                    <select class="form-control" name="productChildCategory"></br>
                    <?php
                    if (isset($_POST['idProduk'])){
                        $query = "SELECT * FROM KATEGORI WHERE ROW_ID_KATEGORI = $categoryChildEdit";
                        $categoryChildSelected = getQueryResultRow($db,$query);
                        echo "<option value='$categoryChildSelected[ROW_ID_KATEGORI]'>$categoryChildSelected[NAMA_KATEGORI]</option>";
                    }
                    foreach ($categoryChild as $key => $value) {
                        echo "<option value='$value[ROW_ID_KATEGORI]'>$value[NAMA_KATEGORI]</option>";
                    }
                    ?>
                    </select></br>
                    <?php
                    if(isset($_POST['idProduk'])){
                        echo "<input type=hidden name='cek' value='$_POST[idProduk]'/>";
                        ?>
                        Product Status : </br>
                        <?php
                        if($statusProduk == 1){
                            ?>
                            <input type="radio" name="productStatus" value="1" checked>
                            <label >Active</label><br>
                            <input type="radio" name="productStatus" value="0">
                            <label>Inactive</label><br>
                            <?php
                        }
                        else{
                            ?>
                            <input type="radio" name="productStatus" value="1">
                            <label >Active</label><br>
                            <input type="radio" name="productStatus" value="0" checked>
                            <label>Inactive</label><br>
                            <?php
                        }
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
                    <h8 class="display-5" style="color: red"><i>Image must be a .PNG</i></h8>
                    <input type="file" id="files" class="form-control-file" name="productImage" value="<?= isset($_POST['idProduk']) ? $fotoProduk : "" ?>">
                    <img id="fotoFile"></br></br>
                    Product Stock : </br>
                    <input type="number" class="form-control" name="productStock" value="<?= isset($_POST['idProduk']) ? $stokProduk : "" ?>" /></br>
                    </br>
                    <input type="hidden" name="idProduk" value="<?= $_POST['idProduk'] ?>"/>
                    <button type="submit" name="btnSubmit" class="btn btn-success"><?= isset($_POST['idProduk']) ? "Edit Product" : "Add Product" ?></button>
                </form>
            </section>
        </main>

        <!-- Footer Section -->
        <?php include("footer.php"); ?>
    </body>
</html>
<script>
    $(function(){
        $("#files").change(function() {
            readURL(this);
        });
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                $('#fotoFile').attr('width', '100px');
                $('#fotoFile').attr('height', '100px');
                $('#fotoFile').addClass('mt-4');
                $('#fotoFile').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }
</script>