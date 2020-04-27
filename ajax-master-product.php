<?php
include "system/load.php";
if(isset($_POST['cek'])){
    try {
        $query = "UPDATE PRODUK SET NAMA_PRODUK = :nama, STATUS_AKTIF_PRODUK = :status, HARGA_PRODUK = :harga, DIMENSI_KEMASAN = :dimensikemasan, DIMENSI_PRODUK = :dimensiproduk, BERAT_PRODUK = :berat, SATUAN_PRODUK = :satuan, DESKRIPSI_PRODUK = :deskripsi, LOKASI_FOTO_PRODUK = :gambar, STOK_PRODUK = :stok WHERE ROW_ID_PRODUK = :id";
        $stmt = $db->prepare($query);
        $stmt->bindValue(":nama", $_POST['productName'], PDO::PARAM_STR);
        $stmt->bindValue(":status", $_POST['productStatus'], PDO::PARAM_STR);
        $stmt->bindValue(":harga", $_POST['productPrice'], PDO::PARAM_INT);
        $stmt->bindValue(":dimensikemasan", $_POST['productPackageDimension'], PDO::PARAM_STR);
        $stmt->bindValue(":dimensiproduk", $_POST['productDimension'], PDO::PARAM_STR);
        $stmt->bindValue(":berat", $_POST['productWeight'], PDO::PARAM_STR);
        $stmt->bindValue(":satuan", $_POST['productUnit'], PDO::PARAM_STR);
        $stmt->bindValue(":deskripsi", $_POST['productDescription'], PDO::PARAM_LOB);
        $stmt->bindValue(":gambar", $_POST['productImage'], PDO::PARAM_LOB);
        $stmt->bindValue(":stok", $_POST['productStock'], PDO::PARAM_INT);
        $stmt->bindValue(":id", $_POST['cek'], PDO::PARAM_INT);
        $result = $stmt->execute();
        echo "Successful editing product";
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
else{
    try{
        $query = "INSERT INTO PRODUK VALUES('','', :nama, :status, :harga, :dimensikemasan, :dimensiproduk, :berat, :satuan, :deskripsi, :gambar, :stok)";
        $stmt = $db->prepare($query);
        $stmt->bindValue(":nama", $_POST['productName'], PDO::PARAM_STR);
        $stmt->bindValue(":status", 1, PDO::PARAM_STR);
        $stmt->bindValue(":harga", $_POST['productPrice'], PDO::PARAM_INT);
        $stmt->bindValue(":dimensikemasan", $_POST['productPackageDimension'], PDO::PARAM_STR);
        $stmt->bindValue(":dimensiproduk", $_POST['productDimension'], PDO::PARAM_STR);
        $stmt->bindValue(":berat", $_POST['productWeight'], PDO::PARAM_STR);
        $stmt->bindValue(":satuan", $_POST['productUnit'], PDO::PARAM_STR);
        $stmt->bindValue(":deskripsi", $_POST['productDescription'], PDO::PARAM_LOB);
        $stmt->bindValue(":gambar", $_FILES['productImage'], PDO::PARAM_LOB);
        $stmt->bindValue(":stok", $_POST['productStock'], PDO::PARAM_INT);
        $result = $stmt->execute();
        echo "Successful registering product";
    }catch (Exception $e) {
        echo $e->getMessage();
    }
}