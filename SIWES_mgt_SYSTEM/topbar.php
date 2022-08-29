
<?php
session_start();
error_reporting(0);
include('Admin/connect2.php');
include('Admin/connect.php');

 
$stmt = $dbh->query("SELECT * FROM websiteinfo");
$row_website = $stmt->fetch();
$logo="Admin/".$row_website['logo'] ;
$favicon="Admin/".$row_website['favicon'] ;

$email=$row_website['email'] ;
$website_name=$row_website['website_name'] ;
$url=$row_website['url'] ;
$phone1=$row_website['phone1'] ;
$phone2=$row_website['phone2'] ;
$secretkey=$row_website['payment_secretkey'] ;
$SMS_username=$row_website['SMS_username'] ;
$SMS_password=$row_website['SMS_password'] ;



date_default_timezone_set('Africa/Lagos');
$current_date = date('Y-m-d H:i:s');
?> 
