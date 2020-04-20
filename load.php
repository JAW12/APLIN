<?php 
    session_start();
    include "conn.php";
    
    function cekLogin($db, $role){
        if(isset($_SESSION['login'])){
            $login = $_SESSION['login'];
        }
        else{
            header("location: index.php");
            exit;
        }

        if(isset($login)){
            if($role == 'Admin'){
                if(!cekPassword($login['password'], 'admin', false)){
                    header("location: index.php");
                    exit;
                }
                if($login['role'] == 1){
                    header("location: index.php");
                    exit;
                }
            }
            else if($role == 'Customer'){
                $query = "SELECT * FROM customer WHERE username = '$login[username]'";
                $user = getQueryResultRow($db, $query);
                if($user != false){
                    if(!cekPassword($login['password'], $user['PASSWORD'], false)){ // true => hash, false => gapake
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
?>