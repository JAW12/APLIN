<?php
    include __DIR__."/system/load.php";
    /** @var PDO $db */ //untuk munculin autocomplete di db

    if (isset($_POST['invnum'])) {
        $invnum = $_POST['invnum'];

        $query = "SELECT LOKASI_FOTO_BUKTI_PEMBAYARAN FROM HTRANS WHERE NO_NOTA = $invnum";
        $res = getQueryResultRowField($db, $query, "LOKASI_FOTO_BUKTI_PEMBAYARAN");
        if (!empty($res)) {
            echo $res;
        }
        else{
            echo "-";
        }
    }

?>