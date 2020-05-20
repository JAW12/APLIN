<?php
    include __DIR__."/system/load.php";
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
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <?php include "head.php"; ?>
        <!-- CHART.JS LIBRARY -->
        <link rel="stylesheet" type="text/css" href="vendor/chart/dist/Chart.css">
        <link rel="stylesheet" type="text/css" href="vendor/chart/dist/Chart.min.css">

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

            .height-setting{                
                max-height: 600px !important;                
                max-width: 800px !important;
                height : auto;
                width: auto;
                margin: auto;
            }
        </style>

        <title>Transaction List</title>
    </head>
    <body id="page-top">
        <!-- Header Section -->
        <?php include ("header.php"); ?>

        <!-- Main Section -->
        <main>
            <!-- kalau mau pake space ga ush dicomment -->
            <!-- <div class="spaceatas"></div> -->

            <input type="hidden" id="jenisUserHolder" value="<?= $jenisUser ?>">
            <div id="judul" class="col-12 text-center my-5" style="background-image: url('res/img/bg12.jpg');">
                <h1 class="text-light display-3 font-weight-bold">
                    Transaction List
                </h1>
            </div>

            <div class="row d-flex justify-content-around">
                <!-- filter -->
                <div class="col-sm-6 col-md-4 col-lg-4 col-xl-2 pr-2">   
                    <div class="container-fluid w-100 ml-5">
                        <div class="container my-4 d-flex justify-content-around flex-wrap">
                            <form method="GET" class="form-inline" id="formFilter">
                                <input type="hidden" name="view" id="inputMode">
                                <?php
                                    $class_hr = "border border-dark w-100 float-left mb-2";
                                ?>                                
                                <div class="my-2 align-middle w-100">
                                    <div class="form-inline">
                                        <button type="button" class="btn btn-light rounded-circle mr-2 btn-angle">
                                            <i class="fas fa-angle-up"></i>
                                        </button>
                                        <span class="font-weight-bold font-italic">Viewing Mode</span>
                                    </div>
                                    
                                    <div class="container-filter w-100 text-left">
                                        <select class="form-control form-control-sm w-100 my-2" name="cbViewMode" id="cbViewMode">
                                            <option value="table">Table</option>
                                            <option value="graphics">Graphics</option>
                                        </select>
                                    </div>                                    
                                </div>
                                <hr class="<?= $class_hr ?>">
                                <div class="my-2 align-middle w-100">
                                    <div class="form-inline">
                                        <button type="button" class="btn btn-light rounded-circle mr-2 btn-angle">
                                            <i class="fas fa-angle-up"></i>
                                        </button>
                                        <span class="font-weight-bold font-italic">Transaction Info</span>
                                    </div>
                                    
                                    <div class="container-filter w-100 text-left">
                                        <p class="text-sm-left mx-2 my-2">Invoice Number</p>
                                        <input type="number" class="form-control form-control-sm mx-2 w-100" placeholder="Invoice Number" name="q">
                                        <p class="text-sm-left mx-2 my-2 mt-3">Status</p>
                                        <select class="form-control form-control-sm mx-2 w-100" name="status" id="status">
                                            <option value="3">All</option>
                                            <option value="0">Pending</option>
                                            <option value="1">Accepted</option>
                                            <option value="2">Rejected</option>
                                        </select>
                                    </div>                                    
                                </div>
                                <hr class="<?= $class_hr ?>">
                                <div class="my-2 align-middle" style="width: 100%">
                                    <div class="form-inline">
                                        <button type="button" class="btn btn-light rounded-circle mr-2 btn-angle">
                                            <i class="fas fa-angle-up"></i>
                                        </button>
                                        <span class="font-weight-bold font-italic">Transaction Range</span>
                                    </div>
                                    
                                    <div class="container-filter w-100">
                                        <p class="text-sm-left mx-2 my-2">Total Amount Range</p>
                                        <input type="number" class="form-control form-control-sm mx-2 my-2 w-100" placeholder="Minimum Total" name="min">
                                        <input type="number" class="form-control form-control-sm mx-2 my-2 w-100" placeholder="Maximum Total" name="max">

                                        <p class="text-sm-left mx-2 my-2 mt-3 w-100">
                                            <span class="align-middle">Date Range</span><br/>
                                            <button type="button" class="btn btn-secondary btn-sm float-right" id="btnSetAsToday">Set As Today</button>
                                        </p>                 
                                        <input type="text" onfocus="this.type='date'" onfocusout="this.type='text'" placeholder="Start Date" class="form-control form-control-sm mx-2 my-2 w-100 date-field" name="start">
                                        <input type="text" onfocus="this.type='date'" onfocusout="this.type='text'" placeholder="End Date" class="form-control form-control-sm mx-2 my-2 w-100 date-field" name="end">
                                    </div>                                    
                                </div>
                                <hr class="<?= $class_hr ?>">
                                <div class="my-1 w-100">
                                    <!-- <button type="submit" class="btn btn-info w-100 mx-2 my-2" id="btnShow">Show</button> -->
                                    <button type="button" class="btn btn-info w-100 my-2 mx-2" id="btnReset">Clear All</button>
                                </div>
                            </form>    
                        </div>
                    </div>
                </div>
                <!-- content transaction list -->
                <div class="col">
                    <div class="container-fluid" id="containerAlert">

                    </div>
                    <div class="container-fluid" id="containerDataTrans">
                        
                    </div>
                </div>

                <div class="col-12" id="spaceContainer">
                    &nbsp;
                </div>
            </div>

           
        </main>
        <?php include "script.php"; ?>
       <!-- Footer Section -->
       <?php include ("footer.php"); ?>

        <!-- CHART.JS LIBRARY -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

        <!-- JS SENDIRI -->
        <script>
            function setValueStatus(value){
                $("#status").val(value);
            }

            function loadTableMode(){
                $("#inputMode").val("table");
                $.ajax({
                    method : "GET",
                    url : "ajax-transaction-list.php",
                    data : $("#formFilter").serialize(),
                    success : function(res){
                        $("#containerDataTrans").html(res);
                    }
                });
            }

            function resetFilter(){
                $("#formFilter input").val("");
                setValueStatus(3);
            }

            // START OF CHART 
            function getArrayValueByChildIndex(idxArray, array){
                let returnArray = [];
                for (let i = 0; i < array.length; i++) {
                    let eachTrans = array[i];
                    returnArray.push(eachTrans[idxArray]);
                }
                return returnArray;
            }

            function getArrayValueByGrandChildIndex(idxArray, array){
                let returnArray = [];
                for (let i = 0; i < array.length; i++) {
                    let eachTrans = array[i];
                    for (let j = 0; j < eachTrans.length; j++) {
                        let val = eachTrans[j];
                        returnArray.push(val[idxArray]);                        
                    }
                }
                return returnArray;
            }

            function setUpChartContainer(){
                //setting up chart container                
                let htmlCanvas = `        
                <div class="row d-flex flex-nowrap justify-content-around">
                    <div class="col-12 mb-5">
                        <div class="container my-2 mt-5 mb-4 col-sm-12 col d-flex flex-wrap justify-content-around height-setting" style="position:relative;"> 
                            <div class="h3 my-3 col-12" id="labelChartSales">Sales</div>                   
                            <canvas id="chartSales" class="mb-5 mx-3" width="400" height="400"></canvas>
                        </div>
                    </div>                   
                </div>
                <div class="col-12 my-5 py-2 mx-0">
                    &nbsp;
                </div>
                <div class="row d-flex flex-nowrap justify-content-around">
                    <div class="col-12 my-5">
                        <div class="container my-2 mt-5 mb-4 col-sm-12 col d-flex flex-wrap justify-content-around height-setting" style="position:relative;"> 
                            <div class="h3 my-3 col-12" id="labelChartProduct">Top 10 Sold Products</div>
                            <div class="col-12 my-1 text-sm-left text-secondary" id="labelKeterangan">*) if there are more than 10 datas, graphics will only show top 10 sold products</div>
                            <canvas id="chartProduct" class="mb-5 mx-3" width="400" height="400"></canvas>
                        </div>
                    </div>
                </div>                    
                `;

                $("#containerDataTrans").html(htmlCanvas);

                //set up isi label
                let jenisUser = $("#jenisUserHolder").val();
                console.log(jenisUser);
                if (jenisUser == "customer") {
                    $("#labelChartSales").text("Your Transactions");
                    $("#labelChartProduct").text("Top 10 Bought Products");
                    $("#labelKeterangan").text("*) if there are more than 10 datas, graphics will only show top 10 bought products");
                }                
            }

            function generateSpaceBawah(){
                let html = `
                <div class="col-12 my-5">
                    &nbsp;
                </div>
                `;
                $("#spaceContainer").html(html + html + html);
            }

            function buildGraphicsLine(dataValue, dataLabels, containerID, dsLabel){
                //building chart
                let ctx = document.getElementById(containerID).getContext('2d');
                let chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: dataLabels,
                        datasets: [{
                            label: dsLabel,
                            data: dataValue,
                            backgroundColor: [
                                'rgba(153, 102, 255, 0.2)',
                            ],
                            borderColor: [
                                'rgba(153, 102, 255, 1)',
                            ],
                            borderWidth: 2,
                            responsive: true,
                            aspectRation: 1,
                            maintainAspectRatio: true //set false kalo mau height-nya bisa diatur
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    fontSize: 14
                                }
                            }],
                            xAxes: [{
                                ticks: {
                                fontSize: 14
                                }
                            }]
                        }
                    }
                });

                //setting up chart size
                // chart.height = 800;
            }

            function getRepeatedArrayColors(color, ctrRepeat){
                let arr = [];
                for (let i = 0; i < ctrRepeat; i++) {
                    arr.push(color);                    
                }
                return arr;
            }

            function buildGraphicsBar(dataValue, dataLabels, containerID, dsLabel){
                //building chart
                let ctx = document.getElementById(containerID).getContext('2d');
                let chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: dataLabels,
                        datasets: [{
                            label: dsLabel,
                            data: dataValue,
                            backgroundColor: getRepeatedArrayColors('rgba(153, 102, 255, 0.2)', dataValue.length),
                            borderColor: getRepeatedArrayColors('rgba(153, 102, 255, 1)', dataValue.length),
                            borderWidth: 2,
                            responsive: true,
                            aspectRation: 1,
                            maintainAspectRatio: true //set false kalo mau height-nya bisa diatur
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    fontSize: 14
                                }
                            }],
                            xAxes: [{
                                ticks: {
                                fontSize: 14
                                }
                            }]
                        }
                    }
                });

                //setting up chart size
                // chart.width = 800;
            }


            function loadChartSales(){
                $("#inputMode").val("graphicsSales");
                $.ajax({
                    method : "GET",
                    url : "ajax-transaction-list.php",
                    data : $("#formFilter").serialize(),
                    success : function(dataJSON){
                        let dataArray = JSON.parse(dataJSON);
                        let dataTanggal = getArrayValueByChildIndex("TANGGAL_TRANS", dataArray);
                        let dataTotal = getArrayValueByChildIndex("TOTAL_TRANS", dataArray);

                        buildGraphicsLine(dataTotal, dataTanggal, "chartSales", "Total Transactions");
                    }
                });
            }

            function loadChartProduct(){
                $("#inputMode").val("graphicsProduct");
                $.ajax({
                    method : "GET",
                    url : "ajax-transaction-list.php",
                    data : $("#formFilter").serialize(),
                    success : function(dataJSON){
                        let dataArray = JSON.parse(dataJSON);
                        console.log(dataArray);
                        let dataNamaProduk = getArrayValueByChildIndex("NAMA_PRODUK", dataArray);
                        let dataQtyTerjual = getArrayValueByChildIndex("QTY_PRODUK", dataArray);
                        
                        buildGraphicsBar(dataQtyTerjual, dataNamaProduk, "chartProduct", "Product QTY");
                    }
                });
            }

            function loadGraphicsMode(){
                try {
                    setUpChartContainer();
                    loadChartSales();
                    loadChartProduct();
                    generateSpaceBawah()
                } catch (error) {
                    document.write(error);
                }
            }
            // END OF CHART

            function loadDataTrans(){
                //reset isi data trans
                $("#containerDataTrans").html("");

                //ubah isi data trans sesuai dgn view mode
                let mode = $("#cbViewMode").val();
                if (mode == "table") {
                    loadTableMode();
                }
                else if (mode == "graphics") {
                    loadGraphicsMode();
                }
            }

            function changeStatusTrans(new_status, row_id){
                $.ajax({
                    method : "POST",
                    url : "ajax-transaction-list.php",
                    data : {
                        changeStatus : new_status,
                        row_id_htrans : row_id
                    }, 
                    success : function(res){
                        $("#containerAlert").html(res);
                    } 
                });
            }

            function getTodayDateString(){
                // let asiaTime = new Date().toLocaleString("en-US", {timeZone: "Asia/Jakarta"});  
                var today = new Date($.now());
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                var yyyy = today.getFullYear();

                today = yyyy + "-" + mm + "-" + dd;
                return today;
            }

            //setiap kali ada perubahan isi fields filter auto muncul hasil search nya
            $("#formFilter").children().change(function(){
                loadDataTrans();
            })

            $("#formFilter .btn-angle").click(function(){
                let containerFields = $(this).parent().siblings(".container-filter");
                let icon = $(this).children();

                //slide toggle fields
                $(containerFields).slideToggle(200, "linear");

                //ubah icon
                console.log(icon);
                if ($(icon).hasClass("fa-angle-down")) {
                    $(icon).removeClass("fa-angle-down");
                    $(icon).addClass("fa-angle-up");
                }
                else if ($(icon).hasClass("fa-angle-up")) {
                    $(icon).removeClass("fa-angle-up");
                    $(icon).addClass("fa-angle-down");
                }
                return false;
            })

            $("#formFilter").submit(function(e){
                e.preventDefault();
                loadDataTrans();
            });

            $("#btnReset").click(function(){
                resetFilter();
                loadDataTrans();
            });

            $("#cbViewMode").change(function(){
                loadDataTrans();
            })

            $("#btnSetAsToday").click(function(){
                let dateFields = $(this).parent().siblings(".date-field");
                let today = getTodayDateString();
                dateFields.each(function(){
                    $(this).val(today);
                });
                loadDataTrans();
            })

            $(document).on("click", ".btnAccept", function(e){
                changeStatusTrans("accept", $(this).attr("row_id"));
                loadDataTrans();
            });

            $(document).on("click", ".btnReject", function(e){
                changeStatusTrans("reject", $(this).attr("row_id"));
                loadDataTrans();
            });

            $(document).ready(function(){
                //load untuk pertama kali
                loadDataTrans();
                setValueStatus(3);

                //data akan diperbarui setiap 1 menit sekali
                setInterval(() => {
                    loadDataTrans();
                }, 60 * 1000);
            });
        </script>

        <?php
            if (isset($_GET['status'])) {
                $status = $_GET['status'];
                echo "<script>setValueStatus('{$status}')</script>";
            }
        ?>
    </body>
    
</html>