<?php
    include __DIR__."/system/load.php";
    cekLogin($db, "Customer", $login);

    if(isset($_POST['rating'])){
        $id_product = $_POST['id_product'];
        $id_htrans = $_POST['id_htrans'];
        $rating = $_POST['rating'];
        $comment = $_POST['comment'];
        echo $id_product . ' ' . $id_htrans . ' ' . $rating . ' ' . $comment . '<br>';
        if($comment != ''){
            $query = "INSERT INTO REVIEW_PRODUK VALUES('', '$login[row_id_customer]', '$id_htrans', '$id_product', now(), '$comment', $rating)";
            $berhasil = executeNonQuery($db, $query);
            if($berhasil != true){
                echo "Error";
            }
        }
        else{
            echo "Not Complete";
        }
    }
    else{
        echo "Not Complete";
    }

    

?>