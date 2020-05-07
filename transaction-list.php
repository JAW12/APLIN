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

            <!-- filter -->
            <div class="container-fluid mt-2 mb-4">
                <div class="container-fluid my-4 d-flex justify-content-around">
                    <form method="GET" class="form-inline" id="formFilter">
                        <input type="hidden" name="view">
                        <input type="number" class="form-control mx-2" placeholder="Invoice Number" name="q">
                        <input type="number" class="form-control mx-2" placeholder="Minimum Total" name="min">
                        <input type="number" class="form-control mx-2" placeholder="Maximum Total" name="max">
                        <select class="form-control" name="status" id="status">
                            <option value="3">All</option>
                            <option value="0">Pending</option>
                            <option value="1">Accepted</option>
                            <option value="2">Rejected</option>
                        </select>
                        <input type="text" onfocus="this.type='date'" onfocusout="this.type='text'" placeholder="Start Date" class="form-control mx-2" name="start">
                        <div class="font-weight-bold font-italic py-1">Until</div>
                        <input type="text" onfocus="this.type='date'" onfocusout="this.type='text'" placeholder="End Date" class="form-control mx-2" name="end">

                        <button type="submit" class="btn btn-info mx-3">Show</button>
                        <!-- <a class="btn btn-info mr-3" href="transaction-list.php">Reset Filter</a> -->
                        <button type="button" class="btn btn-info mr-3" id="btnReset">Reset Filter</button>
                    </form>    
                </div>
            </div>

            <!-- content -->
            <div class="container my-2" id="containerAlert">

            </div>
            <div class="container my-4" id="containerDataTrans">
               
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

            function loadTableMode(mode){
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

            function loadGraphicsMode(){
                
            }

            function loadDataTrans(){
                let mode = "table";
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

            $("#formFilter").submit(function(e){
                e.preventDefault();
                loadDataTrans();
            });

            $("#btnReset").click(function(){
                resetFilter();
                loadDataTrans();
            });

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