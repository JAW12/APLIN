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
        showAlertModal('bg-success', '<i class="fas fa-check"></i>', '<h4>Yay!</h4><p>Success Adding to Wishlist</p>', 'Close', '');

    }else{
        showAlertModal('bg-danger', '<i class="fas fa-exclamation-triangle"></i>', '<h4>Ooops!</h4><p>Item Already in Wishlist!</p>', 'Close', '');
    }
?>