<?php
    include "system/load.php";
    /** @var PDO $db */ //untuk munculin autocomplete di db

    cekLogin($db, "Customer", $login);

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
    $row_id_htransm = '';
    //tambahan winda
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

    // $row_id_htrans = -1;
    // if (isset($_GET['row_id_htrans'])) {
    //     $row_id_htrans = $_POST['row_id_htrans'];
    //     showAlert($row_id_htrans);
    // }

    // if (isset($_SESSION['dataTrans'])) {
    //     $dataTrans = $_SESSION['dataTrans'];       
    //     $row_id_htrans = $dataTrans['row_id_htrans']; 
    //     $detailTrans = $dataTrans['detail'];
    // }
    // else{        
    //     $row_id_htrans = 0;
    //     $dataCust = array();
    //     $headerTrans = array();
    //     $detailTrans = array();
    // }

    function showReviewTable($db, $detailTrans){
        ?>
            <table class="table table-striped table-bordered border-dark mt-3">
                <thead class="thead-dark text-center">
                    <th scope="col">#</th>
                    <th scope="col">Product Photo</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">QTY</th>
                    <th scope="col">Price</th>
                    <th scope="col">Subtotal</th>
                    <th scope="col">Action</th>
                </thead>
                <tbody>
                    <?php
                        $ctrNum = 0;
                        $grandTotal = 0;
                        if (count($detailTrans) <= 0) {
                            ?>
                                <th colspan="7" class="text-center">NO DATA FOUND</th>
                            <?php
                        }
                        else{
                            $invnum = $_GET['invoice'];
                            $query = "SELECT * FROM HTRANS WHERE NO_NOTA = {$invnum}";
                            $headerTrans = getQueryResultRow($db, $query);

                            $row_id_htrans = $headerTrans['ROW_ID_HTRANS'];
                            foreach ($detailTrans as $key => $value) {
                                $ctrNum++;
                                $row_id_produk = $value['ROW_ID_PRODUK'];
                                $query = "SELECT NAMA_PRODUK FROM PRODUK WHERE ROW_ID_PRODUK = {$row_id_produk}";
                                $namaProduk = getQueryResultRowField($db, $query, "NAMA_PRODUK");
                                $query = "SELECT LOKASI_FOTO_PRODUK FROM PRODUK WHERE ROW_ID_PRODUK = {$row_id_produk}";
                                $fotoProduk = getQueryResultRowField($db, $query, "LOKASI_FOTO_PRODUK");
                                $subtotal = $value['SUBTOTAL'];
                                $grandTotal += $subtotal;
                                ?>
                                    <tr>
                                        <th class="align-middle text-center"> <?= $ctrNum ?> </th>
                                        <td class="text-center"> <img src="res/img/produk/<?= $fotoProduk ?>" style="width: 150px; height: 150px;"></img> </td>
                                        <td class="align-middle"> <?= $namaProduk ?> </td>
                                        <td class="text-center align-middle"> <?= $value['QTY_PRODUK'] ?> </td>
                                        <td class="text-right align-middle"> <?= getSeparatorNumberFormatted($value['HARGA_PRODUK']) ?></td>
                                        <td class="text-right align-middle"> <?= getSeparatorNumberFormatted($subtotal) ?> </td>
                                        <td class="text-center align-middle"><button trans="<?= $row_id_htrans ?>" value="<?= $row_id_produk ?>" class="btn btn-info btnReview" type="button">Review</button></td>
                                    </tr>
                                <?php
                            }
                            ?>
                            <tr class="bg-warning text-dark font-weight-bold">
                                <td colspan="5" class="text-center">Grand Total</td>
                                <td class="text-right"><?= getSeparatorNumberFormatted($grandTotal) ?></td>
                                <td class="bg-dark"></td>
                            </tr>
                            <?php
                        }                                                              
                    ?>                            
                </tbody>
            </table>
        <?php
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

        <!-- JS Sendiri -->

        <title>Review</title>
        <style>
            #judul{
                padding: 0;
                padding-top: 5%;
                padding-bottom: 5%;
                background-repeat:no-repeat;
                background-size: cover;
            }
            
            .rating {
                display: flex;
                flex-direction: row-reverse;
                justify-content: center
            }

            .rating>input {
                display: none
            }

            .rating>label {
                position: relative;
                width: 1em;
                font-size: 24pt;
                color: #FFD600;
                cursor: pointer
            }

            .rating>label::before {
                content: "\2605";
                position: absolute;
                opacity: 0
            }

            .rating>label:hover:before,
            .rating>label:hover~label:before {
                opacity: 1 !important
            }

            .rating>input:checked~label:before {
                opacity: 1
            }

            .rating:hover>input:checked~label:before {
                opacity: 0.4
            }

            .modal-confirm {		
                color: #434e65;
                width: 525px;
            }
            .modal-confirm .modal-content {
                padding: 20px;
                font-size: 16px;
                border-radius: 5px;
                border: none;
            }
            .modal-confirm .modal-header {
                border-bottom: none;   
                position: relative;
                text-align: center;
                margin: -20px -20px 0;
                border-radius: 5px 5px 0 0;
                padding: 35px;
            }
            .modal-confirm h4 {
                text-align: center;
                font-size: 36px;
                margin: 10px 0;
            }
            .modal-confirm .form-control, .modal-confirm .btn {
                min-height: 40px;
                border-radius: 3px; 
            }
            .modal-confirm .close {
                position: absolute;
                top: 15px;
                right: 15px;
                color: #fff;
                text-shadow: none;
                opacity: 0.5;
            }
            .modal-confirm .close:hover {
                opacity: 0.8;
            }
            .modal-confirm .icon-box {
                color: #fff;		
                width: 95px;
                height: 95px;
                display: inline-block;
                border-radius: 50%;
                z-index: 9;
                border: 5px solid #fff;
                padding: 15px;
                margin: 0 auto;
            }
            .modal-confirm .icon-box i {
                font-size: 58px;
                margin: -2px 0 0 -2px;
            }
            .modal-confirm.modal-dialog {
                margin-top: 80px;
            }
            .modal-confirm .btn {
                color: #fff;
                border-radius: 4px;
                text-decoration: none;
                transition: all 0.4s;
                line-height: normal;
                border-radius: 30px;
                margin-top: 10px;
                padding: 6px 20px;
                min-width: 150px;
                border: none;
            }
            .modal-confirm .btn:hover, .modal-confirm .btn:focus {
                background: #014d92;
                outline: none;
            }
        </style>
    </head>
    <body id="page-top">
        <div id="alertModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="alertModal" aria-hidden="true">
            <div class="modal-dialog modal-confirm text-center">
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <div class="icon-box">
                            <i class="fas fa-check"></i>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <h4>Yey!</h4><p>Berhasil Review!</p>          
                        <button class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header Section -->
        <?php include("header.php"); ?>
        
        <!-- Main Section -->
        <main>
        <div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="reviewModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="formReview" onsubmit="return review()">
                <div class="modal-body" id="reviewModalBody">
                </div>
                <div class="modal-footer">
                    <button id="btnCancel" name="btnCancel" type="button" class="btn" data-dismiss="modal">Cancel</button>
                    <button id="btnSubmit" name="btnSubmit" type="submit" class="btn btn-success" value="">Submit</button>
                </div>
                </form>
                </div>
            </div>
        </div>

        </div>
            <!-- kalau mau pake space ga ush dicomment -->
            <div id="judul" class="col-12 text-center my-5" style="background-image: url('res/img/bg12.jpg');">
                <h1 class="text-light display-3 font-weight-bold">
                    Transaction List
                </h1>
            </div>
            <form action="transaction-detail.php" method="post">
                <!-- <button class="btn btn-lg btn-light ml-5" type="submit">< Back</button> -->
                <input type="hidden" name="row_id_htrans" value="$row_id_htrans">
            </form>

            <div class="container mb-5">
                <p class="h1 text-center">Review Transaction</p>
                <?php showReviewTable($db, $detailTrans) ?>
            </div>
        </main>

        <!-- Footer Section -->
        <?php include("footer.php"); ?>
        <script>
            $(function(){
                $(".btnReview").click(function(){
                    let val = $(this).val();
                    let trans = $(this).attr("trans");
                    $.ajax({
                        method: "post",
                        url: "getProduct.php?productinfo",
                        data: {id : val},
                        success: function(res){
                            let produk = JSON.parse(res);
                            $("#reviewModal").modal();
                            $("#reviewModalTitle").text(produk["NAMA_PRODUK"]);
                            var isi = `<div class="text-center">
                                <img style="width: 400px; height: 400px;" src="res/img/produk/` + produk["LOKASI_FOTO_PRODUK"] + `">
                                </div>`;

                            $.ajax({
                            method: "post",
                            url: "getProduct.php?reviewinfo",
                            data: {
                                id_htrans : trans,
                                id_produk : produk["ROW_ID_PRODUK"]
                            },
                            success: function(res){
                                if(res == 'false'){
                                    isi += '<input name="id_htrans" type="hidden" value=' + trans + '>';
                                    isi += '<input name="id_product" type="hidden" value=' + produk["ROW_ID_PRODUK"] + '>';
                                    isi += '<div class="rating"><input type="radio" name="rating" value="5" id="5"><label for="5">☆</label> <input type="radio" name="rating" value="4" id="4"><label for="4">☆</label> <input type="radio" name="rating" value="3" id="3"><label for="3">☆</label> <input type="radio" name="rating" value="2" id="2"><label for="2">☆</label> <input type="radio" name="rating" value="1" id="1"><label for="1">☆</label></div>';
                                    isi += '<div class="form-group"><label for="textArea">Comment</label><textarea class="form-control" id="textArea" rows="3" style="max-height: 250px; min-height: 100px;" name="comment"></textarea></div><div id="reviewAlert"></div>';
                                    $("#reviewModalBody").html(isi);
                                    if($("#btnCancel").hasClass("btn-secondary")){
                                        $("#btnCancel").removeClass("btn-secondary");
                                    }
                                    $("#btnCancel").addClass("btn-danger");
                                    $("#btnCancel").text("Cancel");
                                    $("#btnSubmit").show();
                                }
                                else{
                                    res = JSON.parse(res);
                                    isi += '<div class="rating"><input type="radio" name="rating" value="5" id="5" disabled><label for="5">☆</label> <input type="radio" name="rating" value="4" id="4" disabled><label for="4">☆</label> <input type="radio" name="rating" value="3" id="3" disabled><label for="3">☆</label> <input type="radio" name="rating" value="2" id="2" disabled><label for="2">☆</label> <input type="radio" name="rating" value="1" id="1" disabled><label for="1">☆</label></div>';
                                    isi += '<div class="form-group"><label for="textArea">Comment</label><textarea class="form-control" id="textArea" rows="3" name="comment" style="max-height: 250px; min-height: 100px;" readonly>';
                                    isi += res["KONTEN_REVIEW"];
                                    isi+= '</textarea></div>';
                                    $("#reviewModalBody").html(isi);
                                    if(res['BINTANG_REVIEW'] == 1){
                                        $("input[type=radio][id=1]").attr("checked", true);
                                    }
                                    else if(res['BINTANG_REVIEW'] == 2){
                                        $("input[type=radio][id=2]").attr("checked", true);
                                    }
                                    else if(res['BINTANG_REVIEW'] == 3){
                                        $("input[type=radio][id=3]").attr("checked", true);
                                    }
                                    else if(res['BINTANG_REVIEW'] == 4){
                                        $("input[type=radio][id=4]").attr("checked", true);
                                    }
                                    else if(res['BINTANG_REVIEW'] == 5){
                                        $("input[type=radio][id=5]").attr("checked", true);
                                    }
                                    if($("#btnCancel").hasClass("btn-danger")){
                                        $("#btnCancel").removeClass("btn-danger");
                                    }
                                    $("#btnCancel").addClass("btn-secondary");
                                    $("#btnCancel").text("Close");
                                    $("#btnSubmit").hide();
                                }
                            }
                            });
                        }
                    });
                });
            });
            
            function review(){
                $.ajax({
                    method: "post",
                    url: "reviewProduct.php",
                    data: $("#formReview").serialize(),
                    success: function(res){
                        if(res.includes("Not Complete")){
                            $("#reviewAlert").html('<div class="alert alert-danger">Data Tidak Lengkap!</div>');
                            return true;
                        }
                        else if(res.includes("Error")){
                            $("#reviewAlert").html('<div class="alert alert-danger">Error!</div>');
                            return true;
                        }
                        else{
                            $("#reviewModal").modal('hide');
                            $("#alertModal").modal('show');
                        }
                    }
                });
                return false;
            }
        </script>
    </body>
</html>