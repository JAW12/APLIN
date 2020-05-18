<?php
    include __DIR__."/system/load.php";
    include __DIR__."/generatecode.php";
    $noregis    = $_POST['temp']; 
    $kode       = $_POST['emailCode'];
    $query1     = "SELECT * FROM VERIFIKASI_EMAIL where  row_id_customer = '$noregis' and kode_verifikasi='$kode'";

    $wish       = getQueryResultRow($db,$query1);
    if($wish == false) {
        header("location:verification.php?gagal=1&temp=$noregis");
    } 
    else {
        $query = "UPDATE VERIFIKASI_EMAIL set status_verifikasi = '1' where row_id_customer = $noregis";
        $berhasil = executeNonQuery($db, $query);
        header("location:berhasilregistrasi.php");
    }
?>