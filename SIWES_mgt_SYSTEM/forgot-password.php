<?php
error_reporting(0);
include('topbar.php');

if(isset($_POST['btn_forgot']))
{
$otp = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 8)), 0, 8);

$text_email=$_POST['txtemail'];

$sql = "SELECT * FROM tblclient where email ='".$text_email."' " ;
$ans = $conn->query($sql);
$res=mysqli_fetch_array($ans);
   $realemail=$res['email'];
  $firstname=$res['firsname'];  
  //$username = $res['username'];


if($text_email == $realemail){
$sql2 = "UPDATE tblclient SET password ='$otp' WHERE email='$text_email'";
$ans1 = $conn->query($sql2);
} else if ($ans1){

 
//send New Password  via email 
			$to = $realemail;
			$subject = " Forgot Password|".$row_website['website_name']."";
			$message = "
				<html>
				<head>
				<title> Forgot Password|".$row_website['website_name']."</title>
				</head>
				<body>
				
 				 <img src=\"https://www.flexi.leastpayproject.com.ng/assets/img/banner2.png\">
				<p>Hello ".$firstname." ,</p>
                            <p>Your New Password is : ".$otp_pass." </p>
									
						   <p>Regards,</p>                 
						 <p>".$row_website['website_name']."</p>     
				</body>
				</html>
				";
			 //dont forget to include content-type on header if your sending html
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= "From: ".$row_website['email']."". "\r\n" ;
		mail($to,$subject,$message,$headers);
		
		    header("Location: index.php"); 

		}else{
 $message = '
 <div class="alert alert-danger"> Problem Retrieving Password  </div>
 ';
		}
		}
	//	}
?>

<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from brandio.io/envato/iofrm/html/login15.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 08 May 2022 19:01:51 GMT -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Forgot Password|<?php echo $website_name ;?></title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="css/iofrm-theme15.css">
	  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $favicon; ?>">

</head>
<body>
    <div class="form-body">
        <div class="website-logo">
            <a href="index.php">
                <div class="logos"></div>
          </a>
      </div>
        <div class="row">
            <div class="img-holder">
                <div class="bg"></div>
                <div class="info-holder">
                    <h3>&nbsp;</h3>
              </div>
            </div>
           <div class="form-holder">
                <div class="form-content">
                    <div class="form-items"><h4 ><?php echo $message; ?></h4>
                      <p align="center" ><a href="index.php"><span class="logos"><img class="logo-size" src="<?php echo $logo; ?>" alt="" height="110" width="360"></span></a></p>
                      <h3><?php echo $website_name ;?> - Forgot Password</h3>
                        <p>&nbsp;</p>
                        <p> </p>
                        
                       		             <form  action="" method="POST"  class="registration-form">
                            <input class="form-control" type="text" name="txtemail" placeholder="E-mail Address" required>
                            <div class="form-button">
                                <button id="submit" name="btn_forgot" type="submit" class="ibtn">Request New Password</button>
                            </div>
							<div class="form-button">
                              <a href="index.php">Back</a></div>
                        </form>
                        
                    </div>
                </div>
          </div>
        </div>
    </div>
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
</body>

<!-- Mirrored from brandio.io/envato/iofrm/html/login15.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 08 May 2022 19:01:53 GMT -->
</html>