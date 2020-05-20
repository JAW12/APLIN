<?php
include __DIR__."/system/load.php";
if(isset($_GET['customer'])){
    $u = $_POST['username'];
    $p = $_POST['pass'];
    $query = "SELECT * FROM CUSTOMER WHERE USERNAME = '$u' OR EMAIL = '$u'";
    $user = getQueryResultRow($db, $query);
    if($user != false){
        if(cekPassword($p, $user['PASSWORD'], true)){ // true => hash, false => gapake
            // $row_id_customer = $user['ROW_ID_CUSTOMER'];
            // $q = "SELECT * FROM VERIFIKASI_EMAIL WHERE ROW_ID_CUSTOMER = '$row_id_customer'";
            // $status = getQueryResultRow($db, $q);
            // if($status != false)
            // {
            //     if($status['STATUS_VERIFIKASI'] == 1){
            //         updateDataSession('login', array(
            //             "row_id_customer" => $user["ROW_ID_CUSTOMER"],
            //             "username" => $user['USERNAME'],
            //             "password" => hashPassword($p, false), // true => hash, false => gapake
            //             "role" => 1
            //         ));
            //         header("location: index.php");
            //         exit;
            //     }
            //     else{
            //         header("location: login.php?error=unverified");
            //     exit; 
            //     }
            // }
            // else{
            //     header("location: login.php?error=unverified");
            //     exit; 
            // }
            updateDataSession('login', array(
                "row_id_customer" => $user["ROW_ID_CUSTOMER"],
                "username" => $user['USERNAME'],
                "firstname" => $user['NAMA_DEPAN_CUSTOMER'],
                "lastname" => $user['NAMA_BELAKANG_CUSTOMER'],
                "password" => hashPassword($p, false), // true => hash, false => gapake
                "role" => 1
            ));
            header("location: index.php");
            exit;
        }
        else{
            header("location: login.php?error=wrongpw");
            exit;
        }
    }
    else{
        header("location: login.php?error=notfound");
        exit;
    }
}
else if(isset($_GET['admin'])){
    $u = $_POST['username'];
    $p = $_POST['pass'];
    if($u == 'admin' && $p == 'admin'){
        updateDataSession('login', array(
            "username" => $u,
            "password" => hashPassword($p, false), // true => hash, false => gapake
            "role" => 0
        ));
        header("location: index.php");
        exit;
    }
    else if($u == 'admin' && $p != 'admin'){
        header("location: admin_login.php?error=wrongpw");
        exit;
    }
    else if($u != 'admin'){
        header("location: admin_login.php?error=notfound");
        exit;
    }
}


?>