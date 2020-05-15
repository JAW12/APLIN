<?php
    include "system/load.php";
    //cekLogin($db, "Customer", $login);

    $login    = getDataLogin();
    $idproduk = $_POST['idproduk']; 

    $query = "SELECT * FROM wishlist where ROW_ID_CUSTOMER = '".$login['row_id_customer']."' and ROW_ID_PRODUK = '$idproduk'";
    $wish = getQueryResultRow($db, $query);
    if($wish == false){
        $query = "INSERT INTO WISHLIST VALUES('".$login['row_id_customer']."', '$idproduk')";
        $berhasil = executeNonQuery($db, $query);  
       
    }else{
        showAlertDiv("Item Already in WishList");
    }
?>