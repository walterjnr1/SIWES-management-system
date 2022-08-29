<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception; 
include 'header2.php'; 

if(strlen($_SESSION['login_email'])=="")
  {   
   header("Location: login.php"); 
   }
   
   
if(isset($_POST['btncompose'])){
 
    $email = $_POST['cmdclient'];
    $subject = $_POST['txtsubject'];
    $message = $_POST['txtmsg'];
 
  //  $filename = $_FILES['attachment']['name'];
   // $location = 'attachment/' . $filename;
   // move_uploaded_file($_FILES['attachment']['tmp_name'], $location);
 
    //Load composer's autoloader
    require 'vendor/autoload.php';
 
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        //Server settings
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'newleastpaysolution@gmail.com';     // Your Email/ Server Email
        $mail->Password = 'escobar2012';                     // Your Password
        $mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
        );                         
        $mail->SMTPSecure = 'ssl';                           
        $mail->Port = 465;                                   
 
        //Send Email
        $mail->setFrom('newleastpaysolution@gmail.com');
 
        //Recipients
        $mail->addAddress($email);              
        $mail->addReplyTo('newleastpaysolution@gmail.com');
 
        //Attachment
       // if(!empty($filename)){
        //    $mail->addAttachment($location, $filename); 
       // }
 
        //Content
        $mail->isHTML(true);                                  
        $mail->Subject = $subject;
        $mail->Body    = $message;
 
        $mail->send();
        $success = 'Message has been sent';
    } catch (Exception $e) {
        $error = 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
    }
 
    //header('location:index.php');
}
//else{
   // $error = 'Please fill up the form first';
    //header('location:index.php');
//}
   
   
   ?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from uxliner.com/adminkit/demo/main/ltr/apps-compose-mail.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 14 May 2021 17:40:20 GMT -->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Compose Mail| <?php echo $row_website['website_name']; ?></title>
<!-- Tell the browser to be responsive to screen width -->
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- v4.0.0 -->
<link rel="stylesheet" href="dist/bootstrap/css/bootstrap.min.css">

<!-- Favicon -->
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo $row_website['favicon'];   ?>">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

<!-- Theme style -->
<link rel="stylesheet" href="dist/css/style.css">
<link rel="stylesheet" href="dist/css/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="dist/css/et-line-font/et-line-font.css">
<link rel="stylesheet" href="dist/css/themify-icons/themify-icons.css">
<link rel="stylesheet" href="dist/css/simple-lineicon/simple-line-icons.css">

<!-- iCheck -->
<link rel="stylesheet" href="dist/plugins/iCheck/flat/blue.css">

<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="dist/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

<!-- Dropzone -->
<link rel="stylesheet" href="dist/plugins/dropzone-master/dropzone.css">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper boxed-wrapper">

    <?php include 'header.php'; ?>

  <!-- Left side column. contains the logo and sidebar -->
  <?php include 'sidebar.php'; ?>
  
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> 
    <!-- Content Header (Page header) -->
    <div class="content-header sty-one">
      <h1>Compose Mail</h1>
      <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><i class="fa fa-angle-right"></i> Compose Mail</li>
      </ol>
    </div>
    
    <!-- Main content -->
    <div class="content">
      <div class="row">
        <div class="col-lg-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">
			  <p align="center">	
	   			<?php if($success){?>
          <div class="alert alert-success" role="alert" align="center">  <?php echo ($success); ?></div>
		  <?php } 
					else if($error){?>
           <div class="alert alert-danger" role="alert">  <?php echo ($error); ?></div>
 <?php } ?>
</p>
</h3>
            </div>
            <!-- /.box-header -->
			                                <form role="form" method="POST">

            <div class="box-body pad-10">
              <div class="form-group">
				<?php
			$sql = "select CONCAT(firstname,' ', lastname) AS fullname,email from tblclient order by firstname ASC";
             $group = $dbh->query($sql);                       
             $group->setFetchMode(PDO::FETCH_ASSOC);
             echo '<select name="cmdclient"  id="cmdclient" class="form-control" required >';
			   echo '<option value="">Select Client</option>';
             while ( $row = $group->fetch() ) 
             {
                echo '<option value="'.$row['email'].'">'.$row['email'].'</option>';
             }

             echo '</select>';
			 ?>  				
              </div>
              <div class="form-group">
                <input class="form-control" name="txtsubject" placeholder="Subject:" required>
              </div>
              <div class="form-group">
                <textarea id="compose-textarea" name="txtmsg" class="form-control" style="height: 300px"></textarea>
              </div>
             
            </div>
            <!-- /.box-body -->
            <div class="box-footer m-b-2">
              <div class="pull-right">
                <button type="submit" name="btncompose" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
              </div>
            </div>
			            </form>

            <!-- /.box-footer --> 
          </div>
          <!-- /. box --> 
        </div>
      </div>
      <!-- Main row --> 
    </div>
    <!-- /.content --> 
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-left hidden-xs"><?php include'footer.php';  ?>.</div>
	</footer>
</div>
<!-- ./wrapper --> 

<!-- jQuery 3 --> 
<script src="dist/js/jquery.min.js"></script> 

<!-- v4.0.0-alpha.6 --> 
<script src="dist/bootstrap/js/bootstrap.min.js"></script> 

<!-- template --> 
<script src="dist/js/adminkit.js"></script> 

<!-- iCheck --> 
<script src="dist/plugins/iCheck/icheck.min.js"></script> 

<!-- Bootstrap WYSIHTML5 --> 
<script src="dist/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script> 

<!-- Dropzone --> 
<script src="dist/plugins/dropzone-master/dropzone.js"></script> 
<script>
  $(function () {
    //Add text editor
    $("#compose-textarea").wysihtml5();
  });
</script>
</body>

<!-- Mirrored from uxliner.com/adminkit/demo/main/ltr/apps-compose-mail.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 14 May 2021 17:40:23 GMT -->
</html>
