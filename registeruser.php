<?php
    include "system/load.php";
    //cekLogin($db, "Customer", $login);

    $username = $_POST['username']; 

    $query = "INSERT INTO CUSTOMER VALUES(17, '$username', '1', '1', '1', '1', '1')";
    $berhasil = executeNonQuery($db, $query);

    header("location:register.php?saved=1");
?>