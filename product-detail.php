<?php
    include "system/database.php";

    if(isset($_POST['idProduk'])){
        $idProduk = $_POST['idProduk'];
    }
    else{
        $idProduk = "7";
    }
    $query = "SELECT * FROM PRODUK WHERE ROW_ID_PRODUK=$idProduk";
    $produk = getQueryResultRow($db, $query);
    $fotoProduk=$produk['LOKASI_FOTO_PRODUK'];
    $namaProduk=$produk['NAMA_PRODUK'];
    $hargaProduk=$produk['HARGA_PRODUK'];
    $stokProduk=$produk['STOK_PRODUK'];
    if(isset($_POST['btnBeli'])){
        if($_POST['jumlahBeliProduk']>$stokProduk){
            echo "<script>alert('Maaf stok tidak mencukupi');</script>";
        }
        else{
            
            echo "<script>alert('Pembelian sukses');</script>";
        }
    }
?>
<div>
    <div style="width: 40%">
        <img src="<?= $fotoProduk?>" width="300px" height="300px"/>
    </div>
    <div style="width: 40%">
        <h1><?=$namaProduk?></h1>
        <h2><?=$hargaProduk?></h2>
    </div>
    <form method="POST">
        <input type="hidden" name="idProduk" value="<?=$idProduk?>">
        <input type="text" name="jumlahBeliProduk" placeholder="1">
        <button type="submit" name="btnBeli">Beli Sekarang</button>
    </form>
</div>
