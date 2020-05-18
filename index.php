<?php
    include __DIR__."/system/load.php";
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
        <title>Home</title>
        <style>
        .col-6:hover{
            transform: scale(1.2);
            transition: 2s linear;
        }
        .col-12:hover{
            transform: scale(1.2);
            transition: 2s linear;
        }

        </style>
    </head>
    <body>
        <!-- Header Section -->
        <?php include("header.php"); ?>

        <!-- Main Section -->
        <main>
            <!-- kalau mau pake space ga ush dicomment -->
            <!-- <div class="spaceatas"></div> -->
            
            <div class="container-fluid">
                <div class="row">
                    <div name="gambar1" class="col-12">
                        <img src="res/img/bg14.jpg" style="width: 100%;height:500px;">
                    </div>
                </div>
                    <<div class="row">
                    <div class="col-md-6" style="padding-right:0px;">
                        <img src="res/img/bg15.jpg" style="width: 100%;height:600px;">
                    </div>    
                    <div class="col-md-6" style="padding-left:0px;">
                        <img src="res/img/bg16.jpg" style="width: 100%;height:600px;">
                    </div>
    </div>
                 <div class="row">
                    <div id="gambar4" class="col-12">
                        <img src="res/img/bg17.jpg" style="width: 100%;height:500px;">
                    </div>
                </div>
            </div>
            <?php
                //showModal('Ini judul', 'tes', '');
                //showAlertModal('bg-danger', '<i class="fas fa-exclamation-triangle"></i>', '<h4>Ooops!</h4><p>Error deh!</p>', 'Close', '');
            ?>
        </main>
        <!-- Footer Section -->
        <?php include("footer.php"); ?>
    </body>
</html>