<?php
    include __DIR__."/system/load.php";
    if(isset($_SESSION['login'])){
        unset($_SESSION['login']);
    }
    header("location: index.php");
    exit;
?>