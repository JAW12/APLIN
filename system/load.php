<?php 
    session_start();
    include  __DIR__ . "/conn.php";
    include __DIR__ . "/function-library.php";
    
    $login = array();
    function cekLogin($db, $role, &$login){
        if(isset($_SESSION['login'])){
            $login = $_SESSION['login'];
        }
        else{
            header("location: index.php");
            exit;
        }

        if(isset($login)){
            if($role == 'Admin'){
                if(!cekPassword($login['password'], 'admin', true)){
                    header("location: index.php");
                    exit;
                }
                if($login['role'] == 1){
                    header("location: index.php");
                    exit;
                }
            }
            else if($role == 'Customer'){
                $query = "SELECT * FROM CUSTOMER WHERE USERNAME = '$login[username]'";
                $user = getQueryResultRow($db, $query);
                if($user != false){
                    if(!cekPassword($login['password'], $user['PASSWORD'], true)){ // true => hash, false => gapake
                        header("location: login.php");
                        exit;
                    }
                }
                else{
                    header("location: index.php");
                    exit;
                }

                if($login['role'] == 0){
                    header("location: index.php");
                    exit;
                }
            }
        }
    }

    function getDataLogin(){
        if(isset($_SESSION['login'])){
            $login = $_SESSION['login'];
            return $login;
        }
        else{
            return false;
        }
    }
?>