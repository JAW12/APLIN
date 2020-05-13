<?php
include __DIR__."/system/function-library.php";

// var_dump($_POST);

$subject = "[SqueeStore Contact Form] - " . $_POST['name'] . ' ' . $_POST['surname'];
$body = "You have received a new message from your contact from. <br>=============================================<br>";
$body .= '<table>';
$body .= '<tr>';
$body .= '<th style="text-align: left">Full Name</th>';
$body .= '<td>: ' . $_POST['name'] . ' ' . $_POST['surname'] . '<td>';
$body .= '</tr>';

$body .= '<tr>';
$body .= '<th style="text-align: left">Email Address</th>';
$body .= '<td>: ' . $_POST['email'] . '<td>';
$body .= '</tr>';

$body .= '<tr>';
$body .= '<th style="text-align: left">Need Specification</th>';
$body .= '<td>: ' . $_POST['need'] . '<td>';
$body .= '</tr>';

$body .= '<tr>';
$body .= '<th style="text-align: left">Message</th>';
$body .= '<td>: ' . $_POST['message'] . '<td>';
$body .= '</tr>';

sendEmail("squeesquee.store@gmail.com", $subject, $body);
