<?php
    include __DIR__."/system/load.php";
    if($_POST['jumlahBeliProduk'] > $_POST['stokProduk']){
        showAlertDiv('The amount you requested is currently unavailable');
    }
    else{
        $query = "SELECT * FROM CART WHERE ROW_ID_PRODUK = $_POST[idProduk] AND ROW_ID_CUSTOMER = $_POST[idCust]";
        $cekCart = getQueryResultRowArrays($db, $query);
        if(count($cekCart) > 0){
            try{
                $query = "UPDATE CART SET QTY = :qty WHERE ROW_ID_PRODUK = :produk AND ROW_ID_CUSTOMER = :cust";
                $stmt = $db->prepare($query);
                $qty = $cekCart[0]['QTY'];
                $qty = $qty + $_POST['jumlahBeliProduk'];
                $stmt->bindValue(":qty", $qty);
                $stmt->bindValue(":produk", $_POST['idProduk']);
                $stmt->bindValue(":cust", $_POST['idCust']);
                $result = $stmt->execute();
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            showInfoDiv('Success adding to cart');
        }
        else{
            try {
                $query = "INSERT INTO CART VALUES(:idCust, :idProduk, :qty)";
                $stmt = $db->prepare($query);
                $stmt->bindValue(":idCust", $_POST['idCust'], PDO::PARAM_INT);
                $stmt->bindValue(":idProduk", $_POST['idProduk'], PDO::PARAM_INT);
                $stmt->bindValue(":qty", $_POST['jumlahBeliProduk'], PDO::PARAM_INT);
                $result = $stmt->execute();
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            showInfoDiv('Success adding to cart');
        }
    }