<?php
include __DIR__."/system/load.php";
if(isset($_GET['customer'])){
    $u = $_POST['username'];
    $p = $_POST['pass'];
    $query = "SELECT * FROM CUSTOMER WHERE USERNAME = '$u' OR EMAIL = '$u'";
    $user = getQueryResultRow($db, $query);
    if($user != false){
        if(cekPassword($p, $user['PASSWORD'], true)){ // true => hash, false => gapake
            updateDataSession('login', array(
                "row_id_customer" => $user["ROW_ID_CUSTOMER"],
                "username" => $user['USERNAME'],
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