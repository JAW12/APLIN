<?php
    include "system/load.php";
    //cekLogin($db, "Customer", $login);

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
        $query = "INSERT INTO CUSTOMER VALUES('0','$username', '$pass', '$email', '$fistname', '$lastname', '$gende')";
        $berhasil = executeNonQuery($db, $query);
        header("location:register.php?saved=1");
    }else{
        header("location:register.php?notsaved=2");
    }
   

    
?>