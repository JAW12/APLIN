<?php
    include "system/load.php";

    $id     = $_POST['id']; 
    $query1 = "SELECT CUSTOMER.*, VERIFIKASI_EMAIL.KODE_VERIFIKASI FROM CUSTOMER, VERIFIKASI_EMAIL where  CUSTOMER.ROW_ID_CUSTOMER = VERIFIKASI_EMAIL.ROW_ID_CUSTOMER and CUSTOMER.ROW_ID_CUSTOMER = '$id'";
    $wish = getQueryResultRow($db, $query1);
    if(!($wish == false)){
        echo json_encode($wish); 
    }
?>