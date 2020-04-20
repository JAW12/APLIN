<?php
    include "load.php";
    if(isset($_SESSION['login'])){
        unset($_SESSION['login']);
    }
    header("location: index.php");
    exit;
?>