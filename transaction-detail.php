<?php
    include "system/load.php";
    /** @var PDO $db */ //untuk munculin autocomplete di db

    //dapetin data
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

    function showTableDetailTrans($db, $detailTrans){
        ?>
            <table class="table table-striped table-bordered border-dark">
                <thead class="thead-dark text-center">
                    <th scope="col">#</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Qty</th>
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
                                        <td class="text-right"> <?= getSeparatorNumberFormatted($value['HARGA_PRODUK']) ?></td>
                                        <td class="text-right"> <?= getSeparatorNumberFormatted($subtotal) ?> </td>
                                    </tr>
                                <?php
                            }
                            ?>
                            <tr class="bg-warning text-dark font-weight-bold">
                                <td colspan="4" class="text-center">Grand Total</td>
                                <td class="text-right"><?= getSeparatorNumberFormatted($grandTotal) ?></td>
                            </tr>
                            <?php
                        }                                                              
                    ?>                            
                </tbody>
            </table>
        <?php
    }

    function getStatusString($status){
        $status_set = array();
        if ($status == 0) {
            $cl = "text-danger";
            $str = "Pending";
        }
        else if ($status == 1) {
            $cl = "text-success";
            $str = "Accepted";
        }
        else if ($status == 2) {
            $cl = "text-danger";
            $str = "Rejected";
        }
        $status_set['warna'] = $cl;
        $status_set['value'] = $str;
        return $status_set;
    }

    function showHeaderInvoice($headerTrans, $namaCustomer){
        ?>
            <div class="container my-2">
                <div class="row">
                    <?php 
                        $status_set =  getStatusString(intval($headerTrans['STATUS_PEMBAYARAN']));
                        $cl = $status_set['warna'];
                        $val = $status_set['value'];
                    ?>
                    <div class="col text-right h4 <?= $cl ?>">
                        <?= $val ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <p class="h5 my-2">Customer Name</p>
                    </div>
                    <div class="col">
                        <p class="h5 my-2"> : <?= $namaCustomer ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <p class="h5 my-2">Invoice Number</p>
                    </div>
                    <div class="col">
                        <p class="h5 my-2"> : <?= $headerTrans["NO_NOTA"] ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <p class="h5 my-2">Order Date</p>
                    </div>
                    <div class="col">
                        <p class="h5 my-2"> : <?= getDateFormatted($headerTrans['TANGGAL_TRANS']) ?> </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <p class="h5 my-2">Total Transaction</p>
                    </div>
                    <div class="col">
                        <p class="h5 my-2"> : Rp.  <?= getSeparatorNumberFormatted($headerTrans['TOTAL_TRANS']) ?></p>
                    </div>
                </div>
            </div>
        <?php
    }

    function showDetailTrans($db, $headerTrans, $detailTrans, $dataCust, $jenisUser){
        $row_id_htrans = $headerTrans['ROW_ID_HTRANS'];
        $statusTrans = $headerTrans['STATUS_PEMBAYARAN'];
        $lokasiFoto = "res/img/transaksi/no-image.png";
        if (!empty($headerTrans['LOKASI_FOTO_BUKTI_PEMBAYARAN'])) {
            $lokasiFoto = "res/img/transaksi/".$headerTrans['LOKASI_FOTO_BUKTI_PEMBAYARAN'];
        }        
        $namaCustomer = $dataCust['NAMA_DEPAN_CUSTOMER'] . " " . $dataCust['NAMA_BELAKANG_CUSTOMER'];
        $namaCustomer = ucwords(strtolower($namaCustomer));
        $invoice = $headerTrans['NO_NOTA'];
        ?>
            <div class="container my-5">
                <?php showHeaderInvoice($headerTrans, $namaCustomer) ?>
                <div class="my-0 d-flex flex-wrap justify-content-around">
                    <div class="col-sm-12 col-md-6 mt-5 py-2">
                        <p class="h5 text-dark">Change Payment Proof Image</p><br/>
                        <form method="POST" enctype="multipart/form-data" class="text-left">                            
                            <input type="file" class="p-1 border border-warning rounded" name="file-upload">
                            <button type="submit" class="btn btn-warning rounded" name="changePaymentProofImage">Upload</button>
                        </form>
                    </div>             
                    <div class="col-sm-12 col-md-6 mt-5 py-2">
                        <p class="h5 text-dark mb-4">Order Detail</p>
                        <?php
                            if ($statusTrans == 1 && $jenisUser == "customer") {
                            ?>
                                <form method="POST" class="form-inline float-right mt-1">
                                    <input type="hidden" name="row_id_htrans" value="<?= $row_id_htrans ?>">
                                    <button type="submit" class="btn btn-warning text-dark rounded mx-2" 
                                            name="lihatReview" formaction="review.php">
                                        Review Product
                                    </button>
                                    <a class="btn btn-warning text-dark rounded mx-2" target="_blank" href="generate-invoice.php?invoice=<?=$invoice?>">
                                        View Invoice
                                    </a>
                                </form>
                            <?php
                            }
                        ?>            
                </div>
                <div class="mt-1 mb-5 d-flex flex-wrap justify-content-around">
                    <div class="col-sm-12 col-md-6 mt-1 d-flex justify-content-center">
                        <div class="img-fit-container">
                            <img src="<?= $lokasiFoto?>" class="img-fit" alt="No Payment Proof Available" class="border"/>
                        </div>         
                    </div>
                    <div class="col-sm-12 col-md-6 mt-1">
                        <?php showTableDetailTrans($db, $detailTrans) ?>
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

        //upload file sesuai dgn nama yg diinputkan di form
        $namaAsliSplit = explode(".",$namaAsliFileUpload);
        $lastIdx = count($namaAsliSplit) - 1;
        $extension = $namaAsliSplit[$lastIdx];      
        
        $namaCustomFileUpload = $namaFileUpload."." .$extension;
        $destination =  __DIR__.$folderTujuan.$namaCustomFileUpload;

        $status = move_uploaded_file($fileTmp, $destination);

        if ($status != false) {
            // echo "file berhasil diupload";

            //insert ke db
            $result = updateDatabaseFile($db, $namaCustomFileUpload, $row_id);

            if ($result) {
                refreshPage();
            }
            else{
                showAlertModal('bg-danger', '<i class="fas fa-exclamation-triangle"></i>', '<h4>Updating Database Has Failed</h4>', 'Close', '');
            }

        }
        else{
            showAlertModal('bg-danger', '<i class="fas fa-exclamation-triangle"></i>', '<h4>Uploading File Has Failed</h4>', 'Close', '');
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
        <script src="script/index.js"></script>

        <!-- CSS Sendiri -->
        <link href="style/index.css" rel="stylesheet">
        <link href="style/general.css" rel="stylesheet">
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
                    Transaction Detail
                </h1>
            </div>

            <?php showDetailTrans($db, $headerTrans, $detailTrans, $dataCust, $jenisUser) ?>

        </main>

        <!-- Footer Section -->
        <?php include ("footer.php"); ?>

        <script>
            function printHTML(html){
                var printContents = html;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;

                window.print();

                document.body.innerHTML = originalContents;
            }

            function printInvoice(btn, divName){
                let row_id_htrans = $(btn).attr("row_id_htrans");
                $.ajax({
                    method : "POST",
                    url : "generate-invoice.php",
                    data : {
                        print_invoice : "true",
                        row_id_htrans : row_id_htrans
                    },
                    success : function(res){
                        printHTML(res);
                    }
                });
            }

            $(document).on("click", "#btnPrint", function(){
                // printDiv("printableArea");
                printInvoice(this, "printableArea");
                console.log(this);
            });
        </script>
    </body>
</html>