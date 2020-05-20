<?php
include __DIR__."/system/function-library.php";
date_default_timezone_set('Asia/Jakarta');
$link = "localhost/proyek/index.php";

$subject = "[SqueeStore Contact Form] - " . $_POST['name'] . ' ' . $_POST['surname'];

// Ini bagian head html
$body = "
        <html>
            <head>
                <style>
                    *,
                    *::before,
                    *::after {
                    box-sizing: border-box;
                    }

                    html {
                        font-family: sans-serif;
                        line-height: 1.15;
                        -webkit-text-size-adjust: 100%;
                        -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
                    }

                    a {
                        color: #007bff;
                        text-decoration: none;
                        background-color: transparent;
                    }

                    .container {
                        width: 100%;
                        padding-right: 15px;
                        padding-left: 15px;
                        margin-right: auto;
                        margin-left: auto;
                    }

                    .my-2 {
                        margin-top: 0.5rem !important;
                    }

                    .d-flex {
                        display: -ms-flexbox !important;
                        display: flex !important;
                    }

                    .justify-content-around {
                        -ms-flex-pack: distribute !important;
                        justify-content: space-around !important;
                    }

                    img {
                        vertical-align: middle;
                        border-style: none;
                    }

                    .border {
                        border: 1px solid #dee2e6 !important;
                    }
                    
                    .border-warning {
                        border-color: #ffc107 !important;
                    }

                    .py-4 {
                        padding-bottom: 1.5rem !important;
                    }

                    #logo{
                        background-image: url(\"https://i.ibb.co/N6JpK0n/logo.png\");
                        background-size: contain;
                        background-repeat: no-repeat;
                        width: 300px;
                        height: 150px;
                        margin: 0 auto;
                        margin-top: 25px;
                    }

                    .w-100 {
                        width: 100% !important;
                    }

                    .text-dark {
                        color: #343a40 !important;
                    }

                    .text-center {
                        text-align: center !important;
                    }

                    .font-weight-bold {
                        font-weight: 700 !important;
                    }

                    p {
                        margin-top: 0;
                        margin-bottom: 1rem;
                    }

                    p,
                    h2,
                    h3 {
                        orphans: 3;
                        widows: 3;
                    }

                    #lwa, #lphone, #lemail{
                        background-size: contain;
                        background-repeat: no-repeat;
                        padding-left: 25px;
                        height: 20px;
                        display: inline;
                    }

                    #lwa{
                        background-image: url(\"https://i.ibb.co/2drXYNM/5a4e2ef62da5ad73df7efe6e.png\");
                    }

                    #lphone{
                        background-image: url(\"https://i.ibb.co/2KDYRWR/Pin-Clipart-com-transmission-clipart-4126103.png\");
                        padding-left: 20px;
                        margin-left: 15px;
                    }

                    #lemail{
                        background-image: url(\"https://www.freepnglogos.com/uploads/email-logo-png-27.png\");
                        padding-left: 25px;
                        margin-left: 15px;
                    }

                    .border {
                        border: 1px solid #dee2e6 !important;
                    }

                    .border-dark {
                        border-color: #343a40 !important;
                    }

                    .text-right {
                        text-align: right !important;
                    }

                    .table {
                    width: 100%;
                    margin-bottom: 1rem;
                    color: #212529;
                    }
                    
                    .table th,
                    .table td {
                    padding: 0.75rem;
                    vertical-align: top;
                    border-top: 1px solid #dee2e6;
                    }
                    
                    .table thead th {
                    vertical-align: bottom;
                    border-bottom: 2px solid #dee2e6;
                    }
                    
                    .table tbody + tbody {
                    border-top: 2px solid #dee2e6;
                    }

                    .table-sm th,
                    .table-sm td {
                    padding: 0.3rem;
                    }

                    .table-bordered {
                    border: 1px solid #dee2e6;
                    }

                    .table-bordered th,
                    .table-bordered td {
                    border: 1px solid #dee2e6;
                    }

                    .table-bordered thead th,
                    .table-bordered thead td {
                    border-bottom-width: 2px;
                    }

                    .text-left {
                        text-align: left !important;
                    }

                    .text-justify {
                        text-align: justify !important;
                    }

                </style>
            </head>";

// Ini untuk Body bagian header
        $body .= "
            <body>
                <div class=\"container border border-warning py-4\" style=\"max-width: 80%; box-sizing: border-box;\">
                    <div class=\"container my-2\">
                        <a href=\"" . $link . "\"><div id=\"logo\" alt=\"logo\" border=\"0\"></div></a>
                    </div>
                    <div class=\"container my-2 w-100 text-center font-weight-bold\">
                        <p class=\"text-dark\">Jl. Keputih Tegal 8, Surabaya, East Java, Indonesia</p>
                        <div class=\"text-center\">
                            <div id=\"lwa\">0822-3302-1555
                            </div>
                            <div id=\"lphone\">031-145-4786
                            </div>
                            <div id=\"lemail\">contactus@squeestore.com
                            </div>
                        </div>
                        <hr class=\"border border-dark\">
                    </div>";

// Ini untuk Body bagian content
        $body .= "<div class=\"container my-2 w-100 text-center\">
                    <h3 class=\"text-right\">" . getDateFormatted(date("Y-m-d H:i:s"))
                    . "</h3>
                    <h1>You have received a new message!</h1>
                    <h3>Here's the message information</h3>
                    <table class=\"table table-bordered text-left\" style=\"width: 80%; margin: 0 auto;\">
                        <tr>
                        <th>Full Name</th>
                        <td>" . $_POST['name'] . ' ' . $_POST['surname'] . "</td>
                        </tr>
                        <tr>
                        <th>Email Address</th>
                        <td>" . $_POST['email'] . "</td>
                        </tr>
                        <tr>
                        <th>Need Specification</th>
                        <td>" . $_POST['need'] . "</td>
                        </tr>
                        <tr>
                        <th>Message</th>
                        <td class=\"text-justify\">
                            " . $_POST['message'] . "
                        </td>
                        </tr>
                    </table>

            ";

// Ini untuk Body bagian penutup
        $body .= "
                    </div>
                </div>
            </body>
        </html>";

echo $body;

sendEmail("squeestore123@gmail.com", $subject, $body);
