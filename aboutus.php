<?php
    include "system/load.php";
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

        <title>About Us</title>
        <style>
            #judul{
                padding: 0;
                padding-top: 5%;

                padding-bottom: 5%;
                background-repeat:no-repeat;
                background-size: cover;
            }
        </style>
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
                    <div id="judul" class="col-12 text-center my-5" style="background-image: url('res/img/bg1.jpg');">
                        <h1 class="text-light display-3 font-weight-bold">
                            About Us</h1>
                    </div>
                   
                    <div class="col-1"></div>

                    <div id="tentang" class="col-5 text-justify">
                        <br><br><br>
                        <p style="text-indent: 2em;">The market for building materials and home appliances is currently growing rapidly. The concept of shopping for building materials and home appliances under one roof has become a trend. This development is not only happening Jabodetabek area, but also other major cities in Indonesia. SqueeStore responded to this trend by expanding business networks and applying the concept of retail building materials and home appliances that are close to customers with the concept of one stop shopping for home.</p>

                        <p style="text-indent: 2em;">
                        With the concept of one-stop shopping, SqueeStore creates a clean and comfortable shopping environment and atmosphere as all customers want. An attractive product layout, provision of informative product catalogs, price quotes with competitive price guarantees are part of efforts to add and strengthen the quality of SqueeStore services. The slogan "Cheap, Complete, and Comfortable" is SqueeStore's guide in serving and meeting the needs of all its customers.</p>
                    </div>

                    <div id="gambar" class="col-5">
                        <img src="res/img/aboutus/1.jpg" class="img-fluid" style="width: 120%;" alt="Gambar Toko">
                    </div>
                    <div class="col-1"></div>

                    <div class="col-1"></div>
                    <hr class="col-9 mt-4">
                    <div class="col-1"></div>

                    <div class="col-12 mt-3 mb-2">
                        <h1 class="text-center">Our History</h1>
                    </div>
                    <div class="col-1"></div>
                    <div class="col-5 text-justify mb-3">
                        <p style="text-indent: 2em;">
                        PT Squee Store Indonesia (SQS) with the SqueeStore brand, which is a subsidiary of PT Squee Company (SQC), is the first modern retail that gave birth to the concept of shopping for building materials and home appliances under one roof in Indonesia. At its inception, in 1997-1998, SqueeStore opened 10 supermarkets in the Greater Jakarta area. Furthermore, with aggressive business expansion, the total of SqueeStore stores has so far reached 34 stores, spread across Jabodetabek, Cibarusah Cikarang, Karawang, Cirebon, Yogyakarta, Solo, Sidoarjo, Surabaya, Bali, Lampung, Palembang, Medan, Batam, and Makassar. SqueeStore will also be present at a number of other strategic locations. The expansion of the business wing will continue with the target of reaching a total of 50 stores in the next two years in Indonesia.
                        </p>
                    </div>
                    <div class="col-5 text-justify">
                        <p style="text-indent: 2em;">
                        Wanting to take advantage of market opportunities in the digital era which is currently developing very rapidly, in 2016 SqueeStore started running an e-commerce business with the address of SqueeStore.com's store. For this online business, customers can not only order products through the website and then send it to their address (delivery home), but also provide their own pick-up service to the nearest store after ordering it online (click & collect). Through this online business, SqueeStore wants to reach wider customers and help them get goods in an easier and cheaper way.
                        </p>
                    </div>
                    <div class="col-1"></div>
                    
                    <div class="col-1"></div>
                    <hr class="col-9 mb-4">
                    <div class="col-1"></div>

                    <div class="col-1"></div>
                    <div id="gambar" class="col-5 mb-4">
                        <img src="res/img/aboutus/2.jpg" class="img-fluid" style="width: 120%;" alt="Gambar Toko">
                    </div>

                    <div id="produk" class="col-5 text-justify">
                        <br>
                        <br>
                        <h1>Our Products</h1>
                        <p style="text-indent: 2em;">Starting from only marketing 10 thousand types of products, now SqueeStore has grown to become a distributor that sells more than 65 thousand types of quality products to meet the needs of building materials and household appliances. Customer trust in SqueeStore products makes SqueeStore, which has 600 sources of suppliers, now also carries well-known brands that are no doubt in its home country and also has reliable in-house brands, including Zehn, Tidy, Sincere, Fiorano, and Durafloor.</p>

                        <p style="text-indent: 2em;">
                        At present, the number of products owned is continuously developed by a reliable team that always sees the need for quality and quantity of goods needed by all customers. All products are divided into 13 categories, ranging from paint and sundries, flooring and walls, baths, kitchens, doors and windows, plumbing, building materials, electrical and lighting, hardware, tools, hobbies, houseware, to appliances.</p>
                    </div>
                    
                </div>
            </div>
        </main>

        <!-- Footer Section -->
        <?php include("footer.php"); ?>
    </body>
</html>