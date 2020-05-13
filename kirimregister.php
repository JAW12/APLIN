<?php
include __DIR__."/system/function-library.php";

// var_dump($_POST);

$subject = "[SqueeStore Contact Form] - " . $_POST['name'] . ' ' . $_POST['surname'];
$body = "You have received a new message from your Register form. <br>=============================================<br>";
$body .= '<table>';
$body .= '<tr>';
$body .= '<th style="text-align: left">Full Name</th>';
$body .= '<td>: ' . $_POST['name'] . ' ' . $_POST['surname'] . '<td>';
$body .= '</tr>';

$body .= '<tr>';
$body .= '<th style="text-align: left">Type</th>';
$body .= '<td>: ' . $_POST['need'] . '<td>';
$body .= '</tr>';

$body .= '<tr>';
$body .= '<th style="text-align: left">Code</th>';
$body .= '<td>: ' . $_POST['message'] . '<td>';
$body .= '</tr>';
$body .= '</table>';
$body .= '<<br><br>';
$body .= "<a href='http://localhost/proyek-aplin/berhasilregistrasi.php?suksesid=".$_POST['id']."'><h4>Klik Disini untuk Mengaktifkan user Anda</h4></a>";


$emailnya= $_POST['email'];
sendEmail("$emailnya", $subject, $body);
