<?php
    include __DIR__."/system/load.php";
    //cekLogin($db, "Customer", $login);
    include "generatecode.php";
    $username = $_POST['username']; 
    $gender="";
    $pass= $_POST['pass']; 
    $email= $_POST['email']; 
    $fistname= $_POST['firstname']; 
    $lastname= $_POST['lastname']; 
    $gendernya= $_POST['gridRadios']; 
    if($gendernya=="laki"){
        $gende="L";
    }
    else {
        $gende="P";
    }
    $query1 = "SELECT * FROM CUSTOMER where  USERNAME = '$username'";
    $wish = getQueryResultRow($db, $query1);
    if($wish == false){
        $query = "INSERT INTO CUSTOMER VALUES(0,'$username', '$pass', '$email', '$fistname', '$lastname', '$gende')";
        $berhasil = executeNonQuery($db, $query);
        $temp= $db->lastInsertId();
        $kodebaru=uniquecodeemailForRegistration();
        $query2 = "INSERT INTO verifikasi_email (ROW_ID_CUSTOMER,KODE_VERIFIKASI,STATUS_VERIFIKASI) VALUES ($temp,$kodebaru,'0')";
        $berhasil = executeNonQuery($db, $query2);
        header("location:register.php?saved=1&temp=$temp");
    }else{
        header("location:register.php?notsaved=2");
    }
    
?>