<?php
    session_start();
    include "conn.php";
    /** @var PDO $db */ //untuk munculin autocomplete di db

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

    function showDetailTrans($db, $headerTrans, $detailTrans, $dataCust, $jenisUser){
        $lokasiFoto = "res/img/transaksi/no-image.png";
        if (!empty($headerTrans['LOKASI_FOTO_BUKTI_PEMBAYARAN'])) {
            $lokasiFoto = "res/img/transaksi/".$headerTrans['LOKASI_FOTO_BUKTI_PEMBAYARAN'];
        }        
        $namaCustomer = $dataCust['NAMA_DEPAN_CUSTOMER'] . " " . $dataCust['NAMA_BELAKANG_CUSTOMER'];
        $namaCustomer = ucwords(strtolower($namaCustomer));
        ?>
            <div class="container my-5">
                <p class="h1 text-center">Detail Transaction</p>
                <div class="my-0 d-flex flex-wrap justify-content-around">
                    <div class="col-sm-12 col-md-6 mt-5">
                        <!-- untuk upload file harus ada enctype="multipart/form-data" -->
                        <!-- kalo enctype gak di set maka by default : enctype="application/x-www-form-urlencoded" . 
                        yang dikirimkan kayak url method GET -->
                        
                        <?php
                            if ($jenisUser == "admin") {
                                ?>
                                    <p class="h5 text-dark">Change Payment Proof Image</p><br/>
                                    <form method="POST" enctype="multipart/form-data" class="text-left">                            
                                        <input type="file" class="p-1 border border-warning rounded" name="file-upload">
                                        <button type="submit" class="btn btn-warning rounded" name="changePaymentProofImage">Upload</button>
                                    </form>
                                <?php
                            }
                            else{
                                ?>
                                    <p class="h5 text-dark">Payment Proof Image</p><br/>
                                <?php
                            }
                        ?>
                        
                    </div>             
                    <div class="col-sm-12 col-md-6 mt-5">
                        <p class="h5 text-dark">Transaction Info</p>
                        <div class="text-dark text-right">
                            <div>
                                Date : <?= getDateFormatted($headerTrans['TANGGAL_TRANS']) ?>
                            </div>
                            <div>
                                Invoice Number : <?= $headerTrans['NO_NOTA'] ?>
                            </div>
                            <div>
                                Nama Customer : <?= $namaCustomer ?>
                            </div>
                        </div>
                    </div>       
                </div>
                <div class="mt-1 mb-5 d-flex flex-wrap justify-content-around">
                    <div class="col-sm-12 col-md-6 mt-1 d-flex justify-content-center">
                        <div class="img-fit-container">
                            <img src="<?= $lokasiFoto?>" class="img-fit" alt="No Payment Proof Available" class="border"/>
                        </div>         
                    </div>
                    <div class="col-sm-12 col-md-6 mt-1">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark text-center">
                                <th scope="col">#</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">QTY</th>
                                <th scope="col">Price</th>
                                <th scope="col">Subtotal</th>
                            </thead>
                            <tbody>
                                <?php
                                    $ctrNum = 0;
                                    $grandTotal = 0;
                                    if (count($detailTrans) <= 0) {
                                        ?>
                                            <th colspan="5" class="text-center">NO DATA FOUND</th>
                                        <?php
                                    }
                                    else{
                                        foreach ($detailTrans as $key => $value) {
                                            $ctrNum++;
                                            $row_id_produk = $value['ROW_ID_PRODUK'];
                                            $query = "SELECT NAMA_PRODUK FROM PRODUK WHERE ROW_ID_PRODUK = {$row_id_produk}";
                                            $namaProduk = getQueryResultRowField($db, $query, "NAMA_PRODUK");
    
                                            $subtotal = $value['SUBTOTAL'];
                                            $grandTotal += $subtotal;
                                            ?>
                                                <tr>
                                                    <th> <?= $ctrNum ?> </th>
                                                    <td> <?= $namaProduk ?> </td>
                                                    <td class="text-center"> <?= $value['QTY_PRODUK'] ?> </td>
                                                    <td class="text-right"> <?= number_format($value['HARGA_PRODUK']) ?></td>
                                                    <td class="text-right"> <?= number_format($subtotal) ?> </td>
                                                </tr>
                                            <?php
                                        }
                                        ?>
                                        <tr class="bg-dark text-light">
                                            <td colspan="4" class="text-center">Grand Total</td>
                                            <td class="text-right"><?= number_format($grandTotal) ?></td>
                                        </tr>
                                        <?php
                                    }                                                              
                                ?>                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php
    }

    function updateDatabaseFile($db, $lokasiFile, $row_id){
        /** @var PDO $db */ //untuk munculin autocomplete di db
        $query = "UPDATE HTRANS SET LOKASI_FOTO_BUKTI_PEMBAYARAN = :lokasi WHERE ROW_ID_HTRANS = :row_id";
        $stmt = $db->prepare($query);
        $stmt->bindValue(":lokasi", $lokasiFile);
        $stmt->bindValue(":row_id", $row_id);
        $result = $stmt->execute();
        return $result;
    }

    function uploadFile($db, $file, $folderTujuan, $namaFileUpload, $row_id){
        $fileTmp = $file['tmp_name'];
        $namaAsliFileUpload = $file['name'];

        //upload file sesuai dgn nama bawaan
        // $destination =  __DIR__."/uploaded-file/".$namaAsliFileUpload;

        //upload file sesuai dgn nama yg diinputkan di form
        $namaAsliSplit = explode(".",$namaAsliFileUpload);
        $lastIdx = count($namaAsliSplit) - 1;
        $extension = $namaAsliSplit[$lastIdx];      
        
        $namaCustomFileUpload = $namaFileUpload."." .$extension;
        $destination =  __DIR__.$folderTujuan.$namaCustomFileUpload;

        $status = move_uploaded_file($fileTmp, $destination);

        if ($status != false) {
            echo "file berhasil diupload";

            //insert ke db
            $result = updateDatabaseFile($db, $namaCustomFileUpload, $row_id);

            if ($result) {
                refreshPage();
            }
            else{
                showAlert("Updating Database Failed");
            }

        }
        else{
           showAlert("Uploading File Failed");
        }    
    }

    function setSessionData($db, $row_id_htrans){
        $query = "SELECT * FROM DTRANS WHERE ROW_ID_HTRANS = {$row_id_htrans}";
        $detailTrans = getQueryResultRowArrays($db, $query);     
        $query = "SELECT * FROM HTRANS WHERE ROW_ID_HTRANS = {$row_id_htrans}";
        $headerTrans = getQueryResultRow($db, $query);   
        $query = "SELECT * FROM CUSTOMER WHERE ROW_ID_CUSTOMER = {$headerTrans['ROW_ID_CUSTOMER']}";
        $dataCust = getQueryResultRow($db, $query);
                   
        $dataTrans['row_id_htrans'] = $row_id_htrans;
        $dataTrans['customer'] = $dataCust;
        $dataTrans['header'] = $headerTrans;     
        $dataTrans['detail'] = $detailTrans;
        updateDataSession('dataTrans', $dataTrans);
    }

    if (isset($_POST['viewDetail'])) {
        setSessionData($db, $_POST['row_id_htrans']);
    }

    if (isset($_SESSION['dataTrans'])) {
        $dataTrans = $_SESSION['dataTrans'];       
        $row_id_htrans = $dataTrans['row_id_htrans']; 
        $dataCust = $dataTrans['customer'];
        $headerTrans = $dataTrans['header'];
        $detailTrans = $dataTrans['detail'];
    }
    else{        
        $row_id_htrans = 0;
        $dataCust = array();
        $headerTrans = array();
        $detailTrans = array();
    }
    
    if (isset($_POST['changePaymentProofImage'])) {
        $row_id_htrans = $headerTrans['ROW_ID_HTRANS'];
        uploadFile($db, $_FILES['file-upload'], "/res/img/transaksi/", strval( $row_id_htrans), $row_id_htrans);
        setSessionData($db, $row_id_htrans);   
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
        <link href="style/general.css" rel="stylesheet">

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

            <!-- container -> jarak ikut bootstrap, container-fluid -> jarak full width, w-(ukuran) -> sesuai persentase, contoh w-80 -> 80% -->
            <?php showDetailTrans($db, $headerTrans, $detailTrans, $dataCust, $jenisUser) ?>

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