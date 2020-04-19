<?php
    session_start();
    include "conn.php";
    /** @var PDO $db Prepared Statement */

    //testing 
    if (isset($_SESSION['jenisUser']) && isset($_SESSION['row_id_user_aktif'])) {
        $jenisUser = $_SESSION['jenisUser'];
        $rowIdUserAktif = $_SESSION['row_id_user_aktif'];
    }
    else{
        $jenisUser = "admin";
        $rowIdUserAktif = -1;
    }

    if (isset($_POST['tesAdmin'])) {
        $jenisUser = "admin";
        $rowIdUserAktif = -1;
        updateDataSession("jenisUser", $jenisUser);
        updateDataSession("row_id_user_aktif", $rowIdUserAktif);
    }

    if (isset($_POST['tesCustomer'])) {
        $jenisUser = "customer";
        $rowIdUserAktif = $_POST['tesRowIdUser'];
        updateDataSession("jenisUser", $jenisUser);
        updateDataSession("row_id_user_aktif", $rowIdUserAktif);
        // showAlert("testing");
    }
    //end of testing

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
            //hitung yang accepted
            if ($value['STATUS_PEMBAYARAN'] == 1) {
                $total += $value['TOTAL_TRANS'];
            }
        }
        return $total;
    }

    function showTransactionList($db, $jenisUser, $row_id_cust){
        $query = "SELECT * FROM HTRANS";
        $condition = "";
        $order = " ORDER BY STATUS_PEMBAYARAN ASC, NO_NOTA ASC";
        if ($jenisUser == "customer") {
            $condition = " WHERE ROW_ID_CUSTOMER = '{$row_id_cust}'";
        }
        $query = $query . $condition . $order;

        $dataHTrans = getQueryResultRowArrays($db, $query);

        ?>
            <div class="h1 text-center">Transaction List</div>
            <div class="h3 text-right text-success my-3">
                <?php
                    $pesan = "Total income : ";
                    if ($jenisUser == "customer") {
                        $pesan = "You have spent : ";
                    }
                    echo $pesan . number_format(getTotalTransaction($dataHTrans));
                ?>
            </div>
            <div class="bg-transparent h5 text-left my-3">
                <p class="text-secondary"> <?= count($dataHTrans) ?> transactions found</p>
                <?php
                    if ($jenisUser == "admin") {
                        ?>
                            <p class="text-warning"> 
                                <?= getCountData($dataHTrans, "STATUS_PEMBAYARAN", 0) ?> pending transactions awaiting your approval
                            </p>
                        <?php   
                    }
                ?>
            </div>          
            <table class="table table-hover table-striped table-bordered">
                <thead class="thead-dark text-center">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Row ID</th>
                        <th scope="col">Date</th>
                        <th scope="col">Invoice Number</th>                        
                        <th scope="col">Customer</th>                        
                        <th scope="col">Total</th>       
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (count($dataHTrans) <= 0) {
                            ?>
                                <tr>
                                    <th colspan="8">NO DATA FOUND</th>
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
                                        <th scope="row"><?= $ctrNum ?></th>
                                        <th><?= $value['ROW_ID_HTRANS'] ?></th>
                                        <td> <?= getDateFormatted($value['TANGGAL_TRANS']) ?> </td>
                                        <td> <?= $value['NO_NOTA'] ?> </td>
                                        <td> <?= $namaCustomer ?> </td>
                                        <td class="text-right"> <?= number_format($value['TOTAL_TRANS']) ?> </td>
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
                                                <td colspan="<?= $colspan ?>" class="d-flex flex-wrap justify-content-around">
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
                    <tr class="bg-dark text-light text-center">
                        <td colspan="8">
                            <?php
                                // echo "Last Updated: ".date("F d Y H:i:s.", 
                                // filemtime("transaction-list.php"));
                                echo "~";
                            ?>
                        </td>
                    </tr>            
                </tbody>
            </table>
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
        showAlert("status has been changed");
    }

    if (isset($_POST['rejectOrder'])) {
        updateTransactionStatus($db, $_POST['row_id_htrans'], 2);
        showAlert("status has been changed");
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
         
        <!-- JS Library Import -->
        <script src="js/jquery-3.4.1.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/jQueryUI.js"></script>
        <script type="text/javascript" src="js/datatables.js"></script>

        <!-- CSS Sendiri -->
        <link href="style/index.css" rel="stylesheet">

        <!-- JS Sendiri -->
        <title>Home</title>
    </head>
    <body id="page-top">
        <!-- Header Section -->
        <header>
            <nav class="navbar navbar-expand-lg bg-light navbar-light fixed-top py-3" id="mainNav">
                <a class="navbar-brand js-scroll-trigger" href="#page-top">Logo</a><button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto my-2 my-lg-0 mr-4">
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="">About Us</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="">Contact Us</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="">Products</a></li>
                    </ul>
                    <form class="form-inline my-2 my-lg-0 mr-3">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Search</button>
                    </form>
                    <a class="btn btn-primary" href="login.php" role="button">Login</a>
                </div>
            </nav>
        </header>

        <!-- Main Section -->
        <main>
            <!-- kalau mau pake space ga ush dicomment -->
            <div class="spaceatas"></div>

            <!-- testing -->
            <div class="container my-5">
                <form method="POST">
                    <input type="text" name="tesRowIdUser" class="form-control" placeholder="Row ID Customer">
                    <button type="submit" name="tesAdmin">Testing Admin</button>
                    <button type="submit" name="tesCustomer">Testing Customer</button>
                </form>
            </div>
            
            <!-- container -> jarak ikut bootstrap, container-fluid -> jarak full width, w-(ukuran) -> sesuai persentase, contoh w-80 -> 80% -->
            <div class="container">
                <?php showTransactionList($db,$jenisUser, $rowIdUserAktif); ?>
            </div>

            <!-- Button Contact Us -->
            <div class="text-center my-3">
            <a class="btn btn-lg btn-dark" href="" role="button">CONTACT US</a>
            </div>
        </main>

        <!-- Footer Section -->
        <footer class="bg-dark py-5">
            <div class="container">
                <div class="medium text-center text-light">
                    Copyright ©2020 - Squee Store
                </div>
                <div class="small text-center text-light">
                    Squee Store berusaha menyediakan berbagai macam peralatan dan perlengkapan bahan bangunan dengan kualitas terjamin dan terjangkau.
                </div>   
            </div>
        </footer>
    </body>
</html>