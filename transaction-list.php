<?php
    include "system/load.php";
    /** @var PDO $db Prepared Statement */

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
            $keyword = $_GET['q'];
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
        if (isset($_GET['status']) && !empty($_GET['status']) && $_GET['status'] != "3") {
            $status = $_GET['status'];
            if ($status == "pending") {
                $status = 0;
            }
            if ($condition != "") {
                $condition .= " AND ";
            }
            $condition .=  " STATUS_PEMBAYARAN = $status";
        }

        $query = $query . $condition . $order;

        $dataHTrans = getQueryResultRowArrays($db, $query);
        return $dataHTrans;
    }

    function showOverviewTransaction($dataHTrans, $jenisUser){
        ?>
            <!-- <div class="h1 text-center">Transaction List</div> -->
            <div class="container-fluid mb-2 mt-4">
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
        <div class="container-fluid my-2">
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
                                        <span class="text-dark">You haven't done any transaction yet</span> <br/>
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
                                <form method="POST">
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
                                                        <button type="submit" class="btn btn-success rounded ml-2" name="acceptOrder">
                                                            <i class="fas fa-check" aria-hidden="true"></i>
                                                        </button>
                                                        <button type="submit" class="btn btn-danger rounded" name="rejectOrder">
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
                                                    <button type="submit" class="btn btn-info rounded" name="viewDetail" formaction="transaction-detail.php">
                                                            View Detail
                                                    </button>   
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

    if (isset($_POST['acceptOrder'])) {
        updateTransactionStatus($db, $_POST['row_id_htrans'], 1);
        refreshPage();
        // showAlertModal('bg-success', '<i class="fas fa-exclamation-triangle"></i>', '<h4>Status Has Been Changed</h4>', 'Close', '');
    }

    if (isset($_POST['rejectOrder'])) {
        updateTransactionStatus($db, $_POST['row_id_htrans'], 2);
        refreshPage();
        // showAlertModal('bg-success', '<i class="fas fa-exclamation-triangle"></i>', '<h4>Status Has Been Changed</h4>', 'Close', '');
    }

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
         
        <!-- CSS Sendiri -->
        <link href="style/index.css" rel="stylesheet">
        <link rel="stylesheet" href="css/datepicker.css">

        <style>
            /* .footer {
                position: absolute;
                bottom: 0;
                width: 100%;
            } */

            #judul{
                padding: 0;
                padding-top: 5%;

                padding-bottom: 5%;
                background-repeat:no-repeat;
                background-size: cover;
            }
        </style>

        <!-- JS Sendiri -->
        <title>Transaction Detail</title>
    </head>
    <body id="page-top">
        <!-- Header Section -->
        <?php include ("header.php"); ?>

        <!-- Main Section -->
        <main>
            <!-- kalau mau pake space ga ush dicomment -->
            <!-- <div class="spaceatas"></div> -->
            <div id="judul" class="col-12 text-center my-5" style="background-image: url('res/img/bg12.jpg');">
                <h1 class="text-light display-3 font-weight-bold">
                    Transaction List
                </h1>
            </div>

            <!-- filter -->
            <div class="container-fluid mt-2 mb-4">
                <div class="container-fluid my-4 d-flex flex-nowrap justify-content-around">
                    <form method="GET" class="form-inline">
                        <?php
                            $keyword = ""; $min = "" ; $max = ""; $checkedStatus = "";
                            if (isset($_GET['q']) && !empty($_GET['q'])) {
                                $keyword = $_GET['q'];
                            }
                            if (isset($_GET['min']) && !empty($_GET['min'])) {
                                $min = $_GET['min'];
                            }
                            if (isset($_GET['max']) && !empty($_GET['max'])) {
                                $max = $_GET['max'];
                            }
                            if (isset($_GET['status'])) {
                                $status = $_GET['status'];
                            }
                        ?>
                        <input type="number" class="form-control mx-2" placeholder="Invoice Number" name="q" value="<?= $keyword ?>">
                        <input type="number" class="form-control mx-2" placeholder="Minimum Total" name="min" value="<?= $min ?>">
                        <input type="number" class="form-control mx-2" placeholder="Maximum Total" name="max" value="<?= $max ?>">
                        <select class="form-control" name="status" id="status">
                            <option value="3">All</option>
                            <option value="pending">Pending</option>
                            <option value="1">Accepted</option>
                            <option value="2">Rejected</option>
                        </select>

                        <button type="submit" class="btn btn-info mx-3">Filter</button>
                        <a class="btn btn-info mr-3" href="transaction-list.php">Reset Filter</a>
                    </form>    
                </div>
            </div>

            <!-- content -->
            <div class="container my-4">
                <?php 
                    $dataHTrans = getDataHtrans($db, $jenisUser, $rowIdUserAktif);
                    showOverviewTransaction($dataHTrans, $jenisUser);
                    showTransactionList($db,$jenisUser, $rowIdUserAktif, $dataHTrans); 
                ?>
            </div>
        </main>

        <!-- Footer Section -->
        <?php include ("footer.php"); ?>

        <!-- JS Library Import -->
        <script src="js/jquery-3.4.1.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/jQueryUI.js"></script>
        <script type="text/javascript" src="js/datatables.js"></script>
        <script src="script/index.js"></script>
        <script>
            function setValueStatus(value){
                $("#status").val(value);
            }
        </script>

        <?php
            if (isset($_POST['acceptOrder'])) {
                showAlertModal('bg-success', '<i class="fas fa-exclamation-triangle"></i>', '<h4>Status Has Been Changed</h4>', 'Close', '');
            }
        
            if (isset($_POST['rejectOrder'])) {
                showAlertModal('bg-success', '<i class="fas fa-exclamation-triangle"></i>', '<h4>Status Has Been Changed</h4>', 'Close', '');
            }

            if (isset($_GET['status'])) {
                $status = $_GET['status'];
                echo "<script>setValueStatus({$status})</script>";
            }
        ?>
    </body>
    
</html>