<?php
    include __DIR__."/system/load.php";
    //cekLogin($db, "Customer", $login);

    $login    = getDataLogin();
    $idproduk = $_POST['idproduk']; 

 
        $query = "DELETE FROM WISHLIST WHERE ROW_ID_CUSTOMER = '".$login['row_id_customer']."' and ROW_ID_PRODUK = '$idproduk'";
        $berhasil = executeNonQuery($db, $query);   
        header("location: wishlist.php?delet=1");
?>