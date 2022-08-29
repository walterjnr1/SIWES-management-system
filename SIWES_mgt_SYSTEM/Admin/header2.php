
<?php
session_start();
error_reporting(0);
ob_start();


//Automatic logout
$t=time();
if (isset($_SESSION['logged']) && ($t - $_SESSION['logged'] > 3600)) {
	
	session_destroy();
    session_unset();
	echo ("<script LANGUAGE='JavaScript'>
    window.alert('Sorry , You have been Logout because of inactivity. Try Again');
    window.location.href='index.php';
    </script>");
	}else {
    $_SESSION['logged'] = time();
}      


$fullname=$_SESSION['login_fullname'] ;

include('connect.php');
include('connect2.php');


   
date_default_timezone_set('Africa/Lagos');
$current_date = date('Y-m-d H:i:s');

 
$stmt = $dbh->query("SELECT * FROM websiteinfo");
$row_website = $stmt->fetch();
$logo=$row_website['logo'] ;
$favicon=$row_website['favicon'] ;

$email=$row_website['email'] ;
$website_name=$row_website['website_name'] ;
$phone1=$row_website['phone1'] ;
$phone2=$row_website['phone2'] ;


$SMS_username=$row_website['SMS_username'];
$SMS_password=$row_website['SMS_password'];

?> 
