<?php
    include "system/load.php";
    /** @var PDO $db Prepared Statement */

    function showTableDetailTrans($db, $detailTrans){
        ?>
            <table class="table table-bordered">
                <thead class="text-dark text-center">
                    <th scope="col">#</th>
                    <th scope="col">Picture</th>
                    <th scope="col">Name</th>
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
                                <th colspan="6" class="text-center">NO DATA FOUND</th>
                            <?php
                        }
                        else{
                            foreach ($detailTrans as $key => $value) {
                                $ctrNum++;
                                $row_id_produk = $value['ROW_ID_PRODUK'];
                                $query = "SELECT * FROM PRODUK WHERE ROW_ID_PRODUK = {$row_id_produk}";
                                $dataProduk = getQueryResultRow($db, $query);
                                $namaProduk = $dataProduk['NAMA_PRODUK'];
                                $lokasiFoto = "res/img/produk/" . $dataProduk['LOKASI_FOTO_PRODUK'];

                                $subtotal = $value['SUBTOTAL'];
                                $grandTotal += $subtotal;

                                ?>
                                    <tr>
                                        <th class="align-middle"> <?= $ctrNum ?> </th>
                                        <td class="text-center align-middle"> 
                                            <img src="<?= $lokasiFoto?>" width="100px" height="100px" alt="No Photo Available"/>
                                        </td>
                                        <td class="text-left align-middle"> <?= $namaProduk ?> </td>
                                        <td class="text-center align-middle"> <?= $value['QTY_PRODUK'] ?> </td>
                                        <td class="text-right align-middle"> <?= getSeparatorNumberFormatted($value['HARGA_PRODUK']) ?></td>
                                        <td class="text-right align-middle"> <?= getSeparatorNumberFormatted($subtotal) ?> </td>
                                    </tr>
                                <?php
                            }
                            ?>
                            <tr class="bg-warning text-dark font-weight-bold">
                                <td colspan="5" class="text-center">Grand Total</td>
                                <td class="text-right"><?= getSeparatorNumberFormatted($grandTotal) ?></td>
                            </tr>
                            <?php
                        }                                                              
                    ?>                            
                </tbody>
            </table>
        <?php
    }

    function showHeaderInvoice($headerTrans, $namaCustomer){
        ?>
            <div class="container my-2 d-flex justify-content-around nowrap">
                <img src="res/img/logo.png" width="20%">
            </div>
            <div class="container my-2 w-100 text-dark text-center font-weight-bold">
                <p class="text-dark">Jl. Keputih Tegal 8, Surabaya, East Java, Indonesia </p>
                <p class="text-dark">
                    <i class="fab fa-whatsapp"></i> 0822-3302-1555
                    &nbsp; &nbsp; &nbsp;
                    <i class="fas fa-phone"></i> 031-145-4786
                    &nbsp; &nbsp; &nbsp;
                    <i class="far fa-envelope"></i> contactus@squeestore.com
                </p>
            </div>
            <hr class="border border-dark">
            <div class="container my-2 text-left">
                <div class="row">
                    <div class="col-3">
                        <p class="h5 my-2">Customer Name</p>
                    </div>
                    <div class="col">
                        <p class="h5 my-2"> : <?= $namaCustomer ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <p class="h5 my-2">Invoice Number</p>
                    </div>
                    <div class="col">
                        <p class="h5 my-2"> : <?= $headerTrans["NO_NOTA"] ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <p class="h5 my-2">Order Date</p>
                    </div>
                    <div class="col">
                        <p class="h5 my-2"> : <?= getDateFormatted($headerTrans['TANGGAL_TRANS']) ?> </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <p class="h5 my-2">Total Transaction</p>
                    </div>
                    <div class="col">
                        <p class="h5 my-2"> : Rp.  <?= getSeparatorNumberFormatted($headerTrans['TOTAL_TRANS']) ?></p>
                    </div>
                </div>
            </div>
        <?php
    }

    function showInvoice($db, $headerTrans, $detailTrans, $dataCust){
        $namaCustomer = $dataCust['NAMA_DEPAN_CUSTOMER'] . " " . $dataCust['NAMA_BELAKANG_CUSTOMER'];
        $namaCustomer = ucwords(strtolower($namaCustomer));
        ?>
            <div class="container-fluid">
                <div class="container my-2">
                    <?php showHeaderInvoice($headerTrans, $namaCustomer) ?>
                </div>
                <div class="container my-4">
                    <?php showTableDetailTrans($db, $detailTrans) ?>
                </div>
            </div>
        <?php
    }

    if (isset($_GET['invoice']) && !empty($_GET['invoice'])) {
        $invnum = $_GET['invoice'];
        $query = "SELECT * FROM HTRANS WHERE NO_NOTA = {$invnum}";
        $headerTrans = getQueryResultRow($db, $query);

        $row_id_htrans = $headerTrans['ROW_ID_HTRANS'];
        $query = "SELECT * FROM DTRANS WHERE ROW_ID_HTRANS = {$row_id_htrans}";
        $detailTrans = getQueryResultRowArrays($db, $query);     
        $query = "SELECT * FROM CUSTOMER WHERE ROW_ID_CUSTOMER = {$headerTrans['ROW_ID_CUSTOMER']}";
        $dataCust = getQueryResultRow($db, $query);
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
            @media print{
                #imgprint{
                    display: block !important;
                    margin-top :50% !important;
                    z-index: 99 !important;
                    /* transform: rotate(45deg) !important; */
                }
            }
        </style>
        <title>View Invoice</title>
    </head>
    <body>
        <!-- Main Section -->
        <main>
            <div class="container-fluid mb-2 mt-4">
                <div class="container text-right" style="max-width: 80%; box-sizing: border-box;">
                    <button type="button" class="btn btn-warning text-dark rounded mr-0" id="btnPrint">
                        Print Invoice
                    </button>
                </div>
            </div>
            <div class="container-fluid mt-3 mb-5" id="printableArea">
                <img id="imgprint" src="res/img/logo.png" width="80%" style="opacity:0.1; z-index: 0; position: fixed; display: none; margin-left:10%"></img>
                <div class="container border border-warning py-4" id="invoice" style="max-width: 80%; box-sizing: border-box;">
                    <?php showInvoice($db, $headerTrans, $detailTrans, $dataCust) ?>
                </div>
            </div>
        </main>

        <script>
            function setUpLayout(){
                $("#btnPrint").hide();
                $("#invoice").removeClass("border");
                $("#invoice").removeClass("border-warning");
            }

            function resetLayout(){
                $("#btnPrint").show();
                $("#invoice").addClass("border");
                $("#invoice").addClass("border-warning");
            }

            function printInvoice(){
                setUpLayout();
                window.print();
                resetLayout();
            }

            $(document).on("click", "#btnPrint", function(){
                printInvoice();
            });
        </script>
    </body>
</html>
