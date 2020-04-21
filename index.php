<?php
    include "load.php";
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
        <?php include("header.php"); ?>

        <!-- Main Section -->
        <main>
            <!-- kalau mau pake space ga ush dicomment -->
            <!-- <div class="spaceatas"></div> -->
            
            <div class="container-fluid">
                <div class="row">
                    <div class="col-1"></div>
                    <div id="gambar" class="col-5">
                        <img src="res/img/bg6.jpg" class="img-fluid" style="width: 100%;height:60%;">
                    </div>
                    <div class="col-1"></div>
                    <div id="gambar" class="col-5">
                        <img src="res/img/bg7.jpg" class="img-fluid" style="width: 100%;height:60%;">
                    </div>
                    <div id="gambar" class="col-5">
                        <img src="res/img/bg3.jpg" class="img-fluid" style="width: 100%;height:60%;">
                    </div>
                    <div id="gambar" class="col-5">
                        <img src="res/img/bg8.jpg" class="img-fluid" style="width: 100%;height:60%;">
                    </div>
                </div>
            </div>
        </main>
        <!-- Footer Section -->
        <?php include("footer.php"); ?>
    </body>
</html>