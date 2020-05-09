<?php
    include "system/load.php";
    /** @var PDO $db Prepared Statement */
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
                width: 800px;
                max-height: 600px !important;
                height : auto;
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
                                        <select class="form-control w-100 my-2" name="cbViewMode" id="cbViewMode">
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
                                        <input type="number" class="form-control form-control-sm mx-2 w-75" placeholder="Invoice Number" name="q">
                                        <p class="text-sm-left mx-2 my-2 mt-3">Status</p>
                                        <select class="form-control form-control-sm mx-2 w-75" name="status" id="status">
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
                                        <input type="number" class="form-control form-control-sm mx-2 my-2 w-75" placeholder="Minimum Total" name="min">
                                        <input type="number" class="form-control form-control-sm mx-2 my-2 w-75" placeholder="Maximum Total" name="max">

                                        <p class="text-sm-left mx-2 my-2 mt-3">Date Range</p>
                                        <input type="text" onfocus="this.type='date'" onfocusout="this.type='text'" placeholder="Start Date" class="form-control form-control-sm mx-2 my-2 w-75" name="start">
                                        <input type="text" onfocus="this.type='date'" onfocusout="this.type='text'" placeholder="End Date" class="form-control form-control-sm mx-2 my-2 w-75" name="end">
                                    </div>                                    
                                </div>
                                <hr class="<?= $class_hr ?>">
                                <div class="my-1 w-100">
                                    <!-- <button type="submit" class="btn btn-info w-100 mx-2 my-2" id="btnShow">Show</button> -->
                                    <button type="button" class="btn btn-info w-100 my-2" id="btnReset">Reset Filter</button>
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
            </div>

            <div class="col-12" id="spaceContainer">
                &nbsp;
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

        <!-- CHART.JS LIBRARY -->
        <script src="vendor/chart/dist/Chart.js"></script>
        <script src="vendor/chart/dist/Chart.min.js"></script>

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

            function setUpChartContainer(){
                //setting up chart container
                let htmlCanvas = `
                    <div class="container my-2 mb-4 col-sm-12 col height-setting" style="position:relative;">                    
                        <canvas id="myChart" class="mb-5" width="400" height="400"></canvas>
                    </div>
                `;
                $("#containerDataTrans").html(htmlCanvas);
            }

            function generateSpaceBawah(){
                let html = `
                <div class="col-12 my-5">
                    &nbsp;
                </div>
                `;
                $("#spaceContainer").append(html);
            }

            function buildGraphics(dataValue, dataLabels){
                //building chart
                var ctx = document.getElementById('myChart').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: dataLabels,
                        datasets: [{
                            label: 'Transaction Total',
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
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });

                //setting up chart size
                // chart.height = 800;
            }

            function loadGraphicsMode(){
                $("#inputMode").val("graphics");
                $.ajax({
                    method : "GET",
                    url : "ajax-transaction-list.php",
                    data : $("#formFilter").serialize(),
                    success : function(dataJSON){
                        let dataArray = JSON.parse(dataJSON);
                        let dataTanggal = getArrayValueByChildIndex("TANGGAL_TRANS", dataArray);
                        let dataTotal = getArrayValueByChildIndex("TOTAL_TRANS", dataArray);

                        setUpChartContainer();
                        buildGraphics(dataTotal, dataTanggal);
                        generateSpaceBawah();
                    }
                });
                
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