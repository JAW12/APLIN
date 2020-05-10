<?php
    include "system/load.php";

    cekLogin($db, "", $login);

    if (isset($login)) {
        $jenisUser = "admin";
        $rowIdUserAktif = -1;
        if ($login['role'] == 1) {
            $jenisUser = "customer";
        }
        
        if ($jenisUser == "customer") {
            $dataCustomer = getCustomerData($db, $login['username']);
            $rowIdUserAktif = $dataCustomer['ROW_ID_CUSTOMER'];
        }
    }

    function getStatusPembayaran($status){
        $status_str = "";
        if ($status == 0) {
            $status_str = "Pending";
        }
        else if ($status == 1) {
            $status_str = "Accepted";
        }
        else if ($status == 2) {
            $status_str = "Rejected";
        }
        return $status_str;
    }

    function getCountData($data, $idxData, $valueData){
        $ctr = 0;
        foreach ($data as $key => $value) {
            if ($value[$idxData] == $valueData) {
                $ctr++;
            }
        }
        return $ctr;
    }

    function getTotalTransaction($dataHTrans){
        $total = 0;
        foreach ($dataHTrans as $key => $value) {
            if ($value['STATUS_PEMBAYARAN'] == 1) {
                $total += $value['TOTAL_TRANS'];
            }
        }
        return $total;
    }

    function getDataHtrans($db, $jenisUser, $row_id_cust){
        $query = "SELECT * FROM HTRANS";
        $condition = "";
        $order = " ORDER BY STATUS_PEMBAYARAN ASC, NO_NOTA ASC";
        if ($jenisUser == "customer") {
            $condition = " WHERE ROW_ID_CUSTOMER = '{$row_id_cust}'";
        }

        if (isset($_GET['q']) && !empty($_GET['q'])) {
            if ($condition != "") {
                $condition .= " AND ";
            }
            $condition .=  " NO_NOTA LIKE '%{$_GET['q']}%'";
        }
        if (isset($_GET['min']) && !empty($_GET['min'])) {
            $min = $_GET['min'];
            if ($condition != "") {
                $condition .= " AND ";
            }
            $condition .=  " TOTAL_TRANS >= $min";
        }
        if (isset($_GET['max']) && !empty($_GET['max'])) {
            $max = $_GET['max'];
            if ($condition != "") {
                $condition .= " AND ";
            }
            $condition .=  " TOTAL_TRANS <= $max";
        }
        if (isset($_GET['status']) && $_GET['status'] != "3") {
            $status = $_GET['status'];
            if ($condition != "") {
                $condition .= " AND ";
            }
            $condition .=  " STATUS_PEMBAYARAN = '{$status}'";
        }
        if (isset($_GET['start']) && !empty($_GET['start'])) {
            $date = $_GET['start'];
            if ($condition != "") {
                $condition .= " AND ";
            }
            $condition .=  " TANGGAL_TRANS >= '$date'";
        }
        if (isset($_GET['end']) && !empty($_GET['end'])) {
            $date = $_GET['end'];
            if ($condition != "") {
                $condition .= " AND ";
            }
            $condition .=  " TANGGAL_TRANS <= '$date'";
        }
                
        if ($jenisUser == "admin" && $condition != "") {
            $query .= " WHERE ";
        }

        $query .= $condition . $order;
        // echo $query;
        $dataHTrans = getQueryResultRowArrays($db, $query);
        return $dataHTrans;
    }

    function showOverviewTransaction($dataHTrans, $jenisUser){
        ?>
            <!-- <div class="h1 text-center">Transaction List</div> -->
            <div class="container mb-2 mt-4">
                <div class="h3 text-right text-success mt-5 mb-2">
                    <?php
                        $pesan = "Total income : ";
                        if ($jenisUser == "customer") {
                            $pesan = "You have spent : ";
                        }
                        echo $pesan . getSeparatorNumberFormatted(getTotalTransaction($dataHTrans));
                    ?>
                </div>
                <div class="bg-transparent h5 text-left my-3">
                    <p class="text-secondary"> <?= count($dataHTrans) ?> transactions found</p>
                    <?php
                        $text = "admin's";
                        if ($jenisUser == "admin") {
                            $text = "your";
                        }
                        ?>
                            <p class="text-warning"> 
                                <?= getCountData($dataHTrans, "STATUS_PEMBAYARAN", 0) ?> pending transactions awaiting <?= $text ?> approval
                            </p>
                        <?php   
                    ?>
                </div>    
            </div>      
        <?php
    }

    function showTransactionList($db, $jenisUser, $row_id_cust, $dataHTrans){
        ?>
        <div class="container my-2">
            <table class="table table-hover table-striped table-bordered">
                <thead class="thead-dark text-center">
                    <tr>
                        <th scope="col">#</th>
                        <?php
                            if ($jenisUser == "admin") {
                                echo '<th scope="col">Row ID</th>';
                            }
                        ?>
                        <th scope="col">Date</th>
                        <th scope="col">Invoice Number</th>                        
                        <?php
                            if ($jenisUser == "admin") {
                                echo '<th scope="col">Customer</th>';
                            }
                        ?>
                        <th scope="col">Total</th>       
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $totalCol = 8;
                        if ($jenisUser == "customer") {
                            $totalCol = 6;
                        }
                        if (count($dataHTrans) <= 0) {
                            ?>
                                <tr>
                                    <th colspan="<?= $totalCol ?>" class="text-center">
                                        <span class="text-dark">We can't find transactions matching the selection</span> <br/>
                                        <a class="btn btn-warning text-dark rounded mx-2 my-2" href="product-list.php" target="_blank">
                                            start shopping now
                                        </a>
                                    </th>
                                </tr>
                            <?php
                        }
                        else{
                            $ctrNum = 0;
                            foreach ($dataHTrans as $key => $value) {
                                $ctrNum++;
                                $row_id_cust = $value['ROW_ID_CUSTOMER'];
                                $query="SELECT * FROM CUSTOMER WHERE ROW_ID_CUSTOMER = '{$row_id_cust}'";
                                $dataCustomer = getQueryResultRow($db, $query);
                                $namaCustomer = $dataCustomer['NAMA_DEPAN_CUSTOMER'] . " " . $dataCustomer['NAMA_BELAKANG_CUSTOMER'];
                                $namaCustomer = ucwords(strtolower($namaCustomer));

                                $status = $value['STATUS_PEMBAYARAN'];
                                $status_str = getStatusPembayaran($status);

                                $cl = "";
                                if ($status_str == "Pending") {
                                    $cl = "bg-warning text-dark";
                                }
                                else if ($status_str == "Accepted") {
                                    $cl = "bg-success text-light";
                                }
                                else if ($status_str == "Rejected") {
                                    $cl = "bg-danger text-light";
                                }                                
                                
                                ?>
                                <form method="POST" class="formPerTrans">
                                    <tr>
                                        <input type="hidden" name="row_id_htrans" value='<?= $value['ROW_ID_HTRANS'] ?>'>
                                        <th scope="row" class="text-center align-middle"><?= $ctrNum ?></th>
                                        <?php
                                            if ($jenisUser == "admin") {
                                                ?>
                                                    <th class="text-center align-middle"><?= $value['ROW_ID_HTRANS'] ?></th>
                                                <?php
                                            }
                                        ?>                                        
                                        <td class="align-middle"> <?= getDateFormatted($value['TANGGAL_TRANS']) ?> </td>
                                        <td class="align-middle"> <?= $value['NO_NOTA'] ?> </td>
                                        <?php
                                            if ($jenisUser == "admin") {
                                                ?>
                                                    <td class="align-middle"> <?= $namaCustomer ?> </td>
                                                <?php
                                            }
                                        ?>
                                        <td class="text-right align-middle"> <?= getSeparatorNumberFormatted($value['TOTAL_TRANS']) ?> </td>
                                        <td class="<?= $cl ?> text-center align-middle"> <?= $status_str ?> </td>
                                        <?php    
                                            if ($status_str == "Pending" && $jenisUser != "customer") {
                                                ?>
                                                    <td class="d-flex flex-wrap justify-content-around">
                                                        <button type="submit" class="btn btn-success rounded ml-2 btnAccept" name="acceptOrder" row_id='<?= $value['ROW_ID_HTRANS'] ?>'>
                                                            <i class="fas fa-check" aria-hidden="true"></i>
                                                        </button>
                                                        <button type="submit" class="btn btn-danger rounded btnReject" name="rejectOrder" row_id='<?= $value['ROW_ID_HTRANS'] ?>'>
                                                            <i class="fas fa-times" aria-hidden="true"></i>
                                                        </button>
                                                        <br/>          
                                                    </td>    
                                                <?php
                                            }                                                
                                        ?>    
                                        <?php
                                            $colspan = 2;
                                            if ($status_str == "Pending") {
                                                $colspan = "";
                                            }
                                            ?>
                                                <td colspan="<?= $colspan ?>" class="d-flex flex-wrap justify-content-around align-middle">
                                                    <a class="btn btn-info rounded" name="viewDetail" href="transaction-detail.php?invoice='<?= $value['NO_NOTA'] ?>'">
                                                        View Detail
                                                    </a>   
                                                </td>  
                                            <?php
                                        ?>
                                                            
                                    </tr>
                                </form>
                                
                                <?php
                            }
                        }
                    ?>        
                    <tr class="bg-dark text-warning font-weight-bold text-center">
                        <td colspan="<?= $totalCol ?>" class="align-middle">
                            &nbsp;
                        </td>
                    </tr>           
                </tbody>
            </table>
        </div>
        <?php   
    }

    function updateTransactionStatus($db, $row_id_htrans, $newStatus){
        /** @var PDO $db Prepared Statement */
        $query = "UPDATE HTRANS SET STATUS_PEMBAYARAN = :new_status WHERE ROW_ID_HTRANS = :row_id";
        $stmt = $db->prepare($query);
        $stmt->bindValue(":new_status", $newStatus);
        $stmt->bindValue(":row_id", $row_id_htrans);
        $result = $stmt->execute();
    }

    function changeProductStock($db, $row_id_htrans){
        $query = "SELECT * FROM DTRANS WHERE ROW_ID_HTRANS = {$row_id_htrans}";
        $dataDetail = getQueryResultRowArrays($db, $query);

        foreach ($dataDetail as $key => $value) {
            $row_id_produk = $value['ROW_ID_PRODUK'];
            $qtyBeli = $value['QTY_PRODUK'];

            $query = "UPDATE PRODUK SET STOK_PRODUK = STOK_PRODUK - $qtyBeli WHERE ROW_ID_PRODUK = $row_id_produk";
            echo $query . "<br/>";
            executeNonQuery($db, $query);
        }
    }

    function get10ValueArray($array){
        $tmp = array();
        $ctr = 0;
        foreach ($array as $key => $value) {
            if ($ctr < 10) {
                $tmp[]=$value;
            }
            $ctr++;
        }
        return $tmp;
    }

    function getProductDetail($db, $row_id_htrans){
        $query = "SELECT D.ROW_ID_PRODUK, P.NAMA_PRODUK, D.QTY_PRODUK
                FROM PRODUK P, DTRANS D WHERE D.ROW_ID_PRODUK = P.ROW_ID_PRODUK AND D.ROW_ID_HTRANS = {$row_id_htrans} ORDER BY D.QTY_PRODUK DESC";
        $result = getQueryResultRowArrays($db, $query);
        // $returnArray = get10ValueArray($result);
        return $result;    
    }

    if (isset($_POST['changeStatus'])) {
        $newStatus = $_POST['changeStatus'];
        $row_id_htrans = $_POST['row_id_htrans'];
        $message = "changing transaction status process has failed";
        if ($newStatus == "accept") {
            updateTransactionStatus($db, $row_id_htrans , 1);
            changeProductStock($db, $row_id_htrans);

            $message = "transaction has been accepted";
            showInfoDiv($message);
        }
        else if ($newStatus == "reject") {
            updateTransactionStatus($db, $row_id_htrans, 2);

            $message = "transaction has been rejected";
            showInfoDiv($message);
        }
        else{
            showAlertDiv($message);
        }        
    }

    if (isset($_GET['view'])) {
        $dataHTrans = getDataHtrans($db, $jenisUser, $rowIdUserAktif);
        if ($_GET['view'] == "table") {            
            showOverviewTransaction($dataHTrans, $jenisUser);
            showTransactionList($db,$jenisUser, $rowIdUserAktif, $dataHTrans); 
        }
        else if ($_GET['view'] == "graphicsSales") {
            echo json_encode($dataHTrans);
        }
        else if ($_GET['view'] == "graphicsProduct") {
            $dataProduct = array();
            foreach ($dataHTrans as $key => $value) {
                $dataDTrans = getProductDetail($db, $value['ROW_ID_HTRANS']);
                $dataProduct[] = $dataDTrans;
            }
            echo json_encode($dataProduct);
        }
    }

    if (isset($_GET['getCurrentDate'])) {
        $today = getCurrentDate();
        echo $today;
    }

    
?>