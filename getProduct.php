<?php
    include __DIR__."/system/load.php";
    /** @var PDO $db */ //untuk munculin autocomplete di db

    if(isset($_GET['productinfo'])){
        $row_id_produk = $_POST['id'];
        $query = "SELECT * FROM PRODUK WHERE ROW_ID_PRODUK = {$row_id_produk}";
        $produk = getQueryResultRow($db, $query);
        if($produk["LOKASI_FOTO_PRODUK"] == ''){
            $produk["LOKASI_FOTO_PRODUK"] = "res/img/no-image.png";
        }
        else{
            $produk["LOKASI_FOTO_PRODUK"] = "res/img/produk/" . $produk["LOKASI_FOTO_PRODUK"] . "?" . time();
        }
        echo json_encode($produk);
    }
    

    if(isset($_GET['reviewinfo'])){
        $row_id_htrans = $_POST['id_htrans'];
        $row_id_produk = $_POST['id_produk'];
        $query = "SELECT * FROM REVIEW_PRODUK WHERE ROW_ID_HTRANS = {$row_id_htrans} AND ROW_ID_PRODUK = {$row_id_produk}";
        $review = getQueryResultRow($db, $query);
        echo json_encode($review);
    }
?>