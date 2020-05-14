<?php
    include __DIR__."/system/load.php";
    // session_start();
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- CSS Library Import -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="css/datatables.css"/>
        <link href="css/all.css" rel="stylesheet">
        <link rel="icon" type="image/png" href="res/img/goblin.png" />    

        <!-- JS Library Import -->
        <script src="js/jquery-3.4.1.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/jQueryUI.js"></script>
        <script type="text/javascript" src="js/datatables.js"></script>
        <script src="script/index.js"></script>

        <!-- CSS Sendiri -->
        <link href="style/index.css" rel="stylesheet">
        <style>
            #judul{
                padding: 0;
                padding-top: 5%;

                padding-bottom: 5%;
                background-repeat:no-repeat;
                background-size: cover;
            }
        </style>
        <title>Cart</title>
    </head>
    <body id="page-top">
        <div class="spaceatas"></div>
        <div id="judul" class="col-12 text-center my-5" style="background-image: url('res/img/bg12.jpg');">
            <h1 class="text-light display-3 font-weight-bold">
                Cart
            </h1>
        </div>
        <!-- Header Section -->
        <?php include("header.php"); 
            if(isset($_SESSION['regisdtrans'])){
                $registerdtrans = $_SESSION['regisdtrans'];
            }
            if(isset($_POST['idProduk'])){
                $idProduk = $_POST['idProduk'];
            }
            if(isset($_POST['grand'])){
                $grandTotal = $_POST['grand'];
            }
            if(isset($_SESSION['login'])){
                $idCustomer = $_SESSION['login']['row_id_customer'];
            }
            if(isset($_POST['btnDelete'])){
                try {
                    $query = "DELETE FROM CART WHERE ROW_ID_PRODUK = :id AND ROW_ID_CUSTOMER = :idCust";
                    $stmt = $db->prepare($query);
                    $stmt->bindValue(":id", $idProduk, PDO::PARAM_INT);
                    $stmt->bindValue(":idCust", $idCustomer, PDO::PARAM_INT);
                    $result = $stmt->execute();
                    showInfoDiv("Successfully delete an item from cart");
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }
            if(isset($_POST['btnConfirm'])){
                try {
                    $db->beginTransaction();
                    $query = "INSERT INTO HTRANS VALUES('',:idCust,:tanggal, '', '', :status, '')";
                    $stmt = $db->prepare($query);
                    $stmt->bindValue(":idCust", $idCustomer, PDO::PARAM_INT);
                    date_default_timezone_set('asia/jakarta');
                    $stmt->bindValue(":tanggal",date('Y-m-d H:i:s'), PDO::PARAM_STR);
                    $stmt->bindValue(":status", 0, PDO::PARAM_INT);
                    $result = $stmt->execute();
                    if($result){
                        $rowIdHtrans = $db->lastInsertId();
                        foreach ($registerdtrans as $key => $value) {
                            $query = "INSERT INTO DTRANS VALUES(:htrans, :idProduk, :qty, '', '')";
                            $stmt = $db->prepare($query);
                            $stmt->bindValue(":htrans", $rowIdHtrans, PDO::PARAM_INT);
                            $stmt->bindValue(":idProduk", $value['id'], PDO::PARAM_INT);
                            $stmt->bindValue(":qty", $value['qty'], PDO::PARAM_INT);
                            $result = $stmt->execute();
                        }
                        unset($_SESSION['regisdtrans']);
                    }
                    showInfoDiv("Purchase Confirmed");
                    try {
                        $query = "DELETE FROM CART WHERE ROW_ID_CUSTOMER = :idCust";
                        $stmt = $db->prepare($query);
                        $stmt->bindValue(":idCust", $idCustomer, PDO::PARAM_INT);
                        $result = $stmt->execute();
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
                    $db->commit();
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
                $_SESSION['regisdtrans'] = [];
            }
        ?>
        <main>
        <table class="table table-hover table-striped table-bordered container">
            <thead class="thead-dark text-center">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Picture</th>
                    <th scope="col">Name</th>                        
                    <th scope="col">Price</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Subtotal</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $query = "SELECT * FROM CART WHERE ROW_ID_CUSTOMER='$idCustomer'";
                    $cartData = getQueryResultRowArrays($db, $query);
                    if (count($cartData) <= 0) {
                        ?>
                            <tr>
                                <th colspan="7" class="text-center">
                                    <span class="text-dark">You don't have any item in your cart yet</span> <br/>
                                    <a class="btn btn-warning text-dark rounded mx-2 my-2" href="product-list.php">
                                        Start shopping now
                                    </a>
                                </th>
                            </tr>
                        <?php
                    }
                    else{
                        $ctrNum = 0;
                        $grandTotal = 0;
                        foreach ($cartData as $key => $value) {
                            $ctrNum++;
                            $query = "SELECT * FROM PRODUK WHERE ROW_ID_PRODUK = $value[ROW_ID_PRODUK]";
                            $itemData = getQueryResultRow($db, $query);
                            $fotoItem="res/img/produk/".$itemData['LOKASI_FOTO_PRODUK'];
                            $namaItem=$itemData['NAMA_PRODUK'];
                            $hargaItem = intval($itemData['HARGA_PRODUK']);
                            $jumlahItem = intval($value['QTY']);
                            $subtotalItem=intval($itemData['HARGA_PRODUK'])*intval($value['QTY']);
                            $registerdtransbaru = array(
                                "id" => $itemData['ROW_ID_PRODUK'],
                                "harga" => $itemData['HARGA_PRODUK'],
                                "qty" => $value['QTY'],
                                "subtotal" => $hargaItem
                            );
                            $registerdtrans[$itemData['ROW_ID_PRODUK']] = $registerdtransbaru;
                            $_SESSION['regisdtrans'] = $registerdtrans;
                            if($itemData['STATUS_AKTIF_PRODUK'] == "1"){
                                echo "<tr>";
                                echo "<td>$ctrNum</td>";
                                ?>
                                <td><div class="text-center"><img src="<?= $fotoItem?>" width="100px" height="100px"/></div></td>
                                <?php
                                echo "<td>$namaItem</td>";
                                ?>
                                <td style="text-align: right"><?= number_format($hargaItem, 0, ',', '.')?></td>
                                <td style="text-align: right"><?= $jumlahItem ?></td>
                                <td style="text-align: right"><?= number_format($subtotalItem, 0, ',', '.')?></td>
                                <?php
                                ?>
                                <form method="POST">
                                    <input type="hidden" name="idProduk" value="<?=$itemData['ROW_ID_PRODUK']?>"/>
                                    <td style="text-align: center;"><button class="btn btn-danger" name="btnDelete">Delete Item</button></td>
                                </form>
                                <?php
                                $grandTotal = $grandTotal + $subtotalItem;
                                echo "</tr>";
                            }
                            ?>
                            <?php
                        }
                        ?>
                        <tr class="text-dark font-weight-bold">
                            <td colspan="5" class="text-center bg-warning">Total Price</td>
                            <td colspan="1" style="text-align: right" class="bg-warning"><?= number_format($grandTotal, 0, ',', '.') ?></td>
                            <td class="text-center bg-dark" colspan="1"></td>
                        </tr>
                        <?php
                    }
                ?>
            </tbody>
        </table>
        <div class="container text-right">
        <form method="POST">
                <input type="hidden" name="grand" value="<?=$grandTotal?>"/>
                <button class="btn btn-success text-center px-3" name="btnConfirm">Confirm Purchase</button>
        </form>
        </div>
        </main>
        

        <!-- Footer Section -->
        <?php include("footer.php"); ?>
    </body>
</html>