<?php
    include "system/load.php";
    /** @var PDO $db */ //untuk munculin autocomplete di db
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

        <title>Contact Us</title>
        <style>
            #judul{
                padding: 0;
                padding-top: 5%;

                padding-bottom: 5%;
                background-repeat:no-repeat;
                background-size: cover;
            }

            #map {
                height: 400px;  /* The height is 400 pixels */
                width: 100%;  /* The width is the width of the web page */
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
                    <div id="judul" class="col-12 text-center my-5" style="background-image: url('res/img/bg2.jpg');">
                        <h1 class="text-light display-3 font-weight-bold">
                            Contact Us</h1>
                    </div>
                   
                    <!-- <div id="map"></div> -->
                    <div class="col-1"></div>
                    <div class="col-4"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d588.2906732009446!2d112.80127418417875!3d-7.293957288475931!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwMTcnMzguNSJTIDExMsKwNDgnMDUuNiJF!5e0!3m2!1sen!2sid!4v1587381294169!5m2!1sen!2sid" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe></div>
                    <div class="col-4">
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <h2>Store Location:</h2>
                        <p class="lead">Jl. Keputih Tegal 8, Keputih, Kec. Sukolilo <br>
                            East Surabaya, East Java, Indonesia </p>
                        <p class="lead">
                        <a href="whatsapp://send?text=Hello&phone=+6282233021555"><i class="fab fa-whatsapp"></i> 0822-3302-1555</a> &nbsp;
                        <a href="tel:031-145-4786"><i class="fas fa-phone"></i> 031-145-4786</a> &nbsp;
                        <a href="mailto:contactus@squeestore.com"><i class="far fa-envelope"></i> contactus@squeestore.com</a>
                        <p class="lead small">Available during Workdays (Monday - Friday) 08.00 AM - 18.00 PM</p>
                        </p>
                    </div>
                    <div class="col-3"></div>

                    <hr class="col-10 my-5">
                    <div class="col-12 mb-4">
                        <div class="text-center dark-grey-text w-70">
                            <h1>Send us a message.</h1>
                            <p class="lead">Do you have any questions? Please do not hesitate to contact us directly. <br> Our team will come back to you within a matter of hours to help you.</p>

                        <form id="contact-form" method="post" action="" role="form">
                            <div class="mt-4"></div>
                            <div class="controls">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="form_name">First Name</label>
                                            <input id="form_name" type="text" name="name" class="form-control" placeholder="John" required="required" data-error="Firstname is required.">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="form_lastname">Last Name</label>
                                            <input id="form_lastname" type="text" name="surname" class="form-control" placeholder="Doe" required="required" data-error="Lastname is required.">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="form_email">Email</label>
                                            <input id="form_email" type="email" name="email" class="form-control" placeholder="johndoe@gmail.com" required="required" data-error="Valid email is required.">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="form_need">Specify your need</label>
                                            <select id="form_need" name="need" class="form-control" required="required" data-error="Please specify your need.">
                                                <option value="Request quotation">Request quotation</option>
                                                <option value="Request order status">Request order status</option>
                                                <option value="Request copy of an invoice">Request copy of an invoice</option>
                                                <option value="Other">Other</option>
                                            </select>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="form_message">Message</label>
                                            <textarea id="form_message" name="message" class="form-control" placeholder="Hey can you please help me with ... " rows="4" required="required" data-error="Please, leave us a message."></textarea>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                <div id="alertContact" class="col-12 mt-2"></div>

                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <p class="text-danger">
                                            <strong>*</strong> All fields are required.
                                    </div>
                                    <div class="col-md-10 mb-2 text-right">
                                        <input type="submit" class="btn btn-success btn-send" value="Send message">
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer Section -->
        <?php include("footer.php"); ?>

        <!-- <script>
        // Initialize and add the map
        function initMap() {
            // The location of Uluru
            var uluru = {lat: -7.29403, lng: 112.801563};
            // The map, centered at Uluru
            var map = new google.maps.Map(
                document.getElementById('map'), {zoom: 4, center: uluru});
            // The marker, positioned at Uluru
            var marker = new google.maps.Marker({position: uluru, map: map});
        }
        </script> -->

        <!-- <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap">
        </script> -->

        <script>
            $(function(){
                $("#contact-form").submit(function(e){
                    e.preventDefault();

                    $.ajax({
                        method: "post",
                        url: "contact.php",
                        data: $("#contact-form").serialize(),
                        success: function(res){
                            if(res.includes("Message has been sent!")){
                                $("#alertContact").html('<div class="alert alert-success">Email Berhasil Dikirim!</div>');
                                // showAlertModal('bg-success', '<i class="fas fa-check"></i>', '<h4>Yay!</h4><p>Email Berhasil Dikirim!</p>', 'Close', '');
                            }
                            else{
                                $("#alertContact").html('<div class="alert alert-danger">Email Gagal Dikirim!</div>');
                                // showAlertModal('bg-danger', '<i class="fas fa-exclamation-triangle"></i>', '<h4>Ooops!</h4><p>Email Gagal Dikirim!</p>', 'Close', '');
                            }
                            $(':input','#contact-form')
                                .not(':button, :submit, :reset, :hidden')
                                .val('')
                                .prop('checked', false)
                                .prop('selected', false);

                                $("#form_need").val("Request quotation");           
                        }
                    });
                });
            });
        </script>
    </body>
</html>