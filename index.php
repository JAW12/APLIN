<?php
    include __DIR__."/system/load.php";
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <?php include "head.php"; ?>
        <title>Home</title>
        <style>
        .col-md-6:hover{
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
                    <div class="row">
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
        <?php include "script.php"; ?>
        <!-- Footer Section -->
        <?php include("footer.php"); ?>
    </body>
</html>