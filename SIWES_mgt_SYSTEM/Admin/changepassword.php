<?php include 'header2.php'; 
if(empty($_SESSION['login_email']))
  {   
   header("Location: login.php"); 
   }
?>
<?php
//$email=$_SESSION['login_email'];
$q = "select * from users where email = '$email'";
  $q1 = $conn->query($q);
  while($row = mysqli_fetch_array($q1)){
    extract($row);
    $db_pass = $row['password'];
	//$email = $row['email'];
  }
  
 if(isset($_POST["btnchange"])){
$old = mysqli_real_escape_string($conn,$_POST['txtold_password']);
$pass_new = mysqli_real_escape_string($conn,$_POST['txtnew_password']);
$confirm_new = mysqli_real_escape_string($conn,$_POST['txtconfirm_password']);

  
  if($db_pass!=$old){ ?> 
	<?php $error='Old Password not matched ';?>
  
  <?php } else if($pass_new!=$confirm_new){ ?> 
<?php $error='NEW Password and CONFIRM password not Matched';?>
  <?php } else {
    //$pass = md5($_POST['password']);
   $sql = "update  users set `password`='$confirm_new' where email= '$email'";
  $res = $conn->query($sql);
  
  //send New Password  via email 
			$to = $email;
			$subject = "".$website_name."| Change Password";
			$message = "
				<html>
				<head>
				<title>".$website_name."|Change Password</title>
				</head>
				<body>
				
 				 <img src=\"https://flexi.leastpayproject.com.ng/assets/img/logo.png\">
				<p>Hello ".$_SESSION["fullname"]." ,</p>
                            <p>Your Password Has been Changed Successfully. </p>
							<p>Your New Password is : ".$pass_new." </p>
                                                  
						   <p>Regards,</p>                 
						 <p>".$website_name."</p>     
				</body>
				</html>
				";
			 //dont forget to include content-type on header if your sending html
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= "From: ".$row_website['email']."". "\r\n" ;
		mail($to,$subject,$message,$headers);

//save activity log details
$task= $fullname.' '.'Changed Password'.' '. 'On' . ' '.$current_date;
$sql = 'INSERT INTO activity_log(task) VALUES(:task)';
$statement = $dbh->prepare($sql);
$statement->execute([
	':task' => $task
]);



  ?>
   <?php $success='Password changed Successfully...';?>
  <script>
    //alert('Password changed Successfully...');
    window.location ="logout.php";
  </script> 
  <?php
    }
  }

?>

<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from uxliner.com/adminkit/demo/main/ltr/form-layouts.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 14 May 2021 17:41:22 GMT -->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Change Password|<?php echo $row_website['website_name'];   ?> </title>
<!-- Tell the browser to be responsive to screen width -->
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- v4.0.0 -->
<link rel="stylesheet" href="dist/bootstrap/css/bootstrap.min.css">

<!-- Favicon -->
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo $row_website['favicon'];   ?> ">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

<!-- Theme style -->
<link rel="stylesheet" href="dist/css/style.css">
<link rel="stylesheet" href="dist/css/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="dist/css/et-line-font/et-line-font.css">
<link rel="stylesheet" href="dist/css/themify-icons/themify-icons.css">
<link rel="stylesheet" href="dist/css/simple-lineicon/simple-line-icons.css">

<!-- form wizard -->
<link rel="stylesheet" href="dist/plugins/formwizard/jquery-steps.css">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper boxed-wrapper">

    <p>
      <?php include 'header.php'; ?>
      
      <!-- Left side column. contains the logo and sidebar -->
      <?php include 'sidebar.php'; ?>
      
      <!-- Content Wrapper. Contains page content -->
       </p>
    <div class="content-wrapper"> 
    <!-- Content Header (Page header) -->
	
    <div class="content-header sty-one">
      <h1>Change Password</h1>
      <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><i class="fa fa-angle-right"></i>Change Password</li>
      </ol>
    </div>
    			<?php if($success){?>
          <div class="alert alert-success" role="alert" align="center">  <?php echo ($success); ?></div>
		  <?php } 
					else if($error){?>
           <div class="alert alert-danger" role="alert">  <?php echo ($error); ?></div>
 <?php } ?>
    <!-- Main content -->
    <div class="content">
      <div class="row">
        <div class="col-lg-12">
          <div class="card card-outline">
            <div class="card-header bg-blue">
              <h5 class="text-white m-b-0">Change Password</h5>
            </div>
            <div class="card-body">
                                <form role="form" method="POST">
              <div class="form-group">
                <label for="exampleInputEmail1">Old Password</label>
<input type="text" name="txtold_password" value="<?php if (isset($_POST['txtold_password']))?><?php echo $_POST['txtold_password']; ?>" placeholder="Enter Old Password" class="form-control" required="">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">New Password</label>
                                    <input type="password" name="txtnew_password" value="<?php if (isset($_POST['txtnew_password']))?><?php echo $_POST['txtnew_password']; ?>" placeholder="Enter New Password" class="form-control" required="">
              </div>
               <div class="form-group">
                <label for="exampleInputPassword1">Confirm New Password</label>
                                    <input type="password" name="txtconfirm_password" value="<?php if (isset($_POST['txtconfirm_password']))?><?php echo $_POST['txtconfirm_password']; ?>" placeholder="Confirm New Password" class="form-control" required="">
              </div>
              <div class="checkbox">
                <label>
                  <input type="checkbox">
                  Check me out </label>
              </div>
              <button type="submit" name="btnchange" class="btn btn-success">Change</button>
            </form>
            </div>
          </div>
        </div>
     
      </div>
    </div>
    <!-- /.content --> 
  </div>
  <!-- /.content-wrapper -->
 <footer class="main-footer">
    <div class="pull-left hidden-xs"><?php include'footer.php';  ?>.</footer>
</div>
<!-- ./wrapper --> 

<!-- jQuery 3 --> 
<script src="dist/js/jquery.min.js"></script> 

<!-- v4.0.0-alpha.6 --> 
<script src="dist/bootstrap/js/bootstrap.min.js"></script> 

<!-- template --> 
<script src="dist/js/adminkit.js"></script>

<!-- form wizard --> 
<script src="dist/plugins/formwizard/jquery-steps.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script> 
<script>
    var frmRes = $('#frmRes');
    var frmResValidator = frmRes.validate();
	
    var frmInfo = $('#frmInfo');
    var frmInfoValidator = frmInfo.validate();

    var frmLogin = $('#frmLogin');
    var frmLoginValidator = frmLogin.validate();

    var frmMobile = $('#frmMobile');
    var frmMobileValidator = frmMobile.validate();

    $('#demo1').steps({
      onChange: function (currentIndex, newIndex, stepDirection) {
        console.log('onChange', currentIndex, newIndex, stepDirection);
        // tab1
        if (currentIndex === 0) {
          if (stepDirection === 'forward') {
            var valid = frmRes.valid();
            return valid;
          }
          if (stepDirection === 'backward') {
            frmResValidator.resetForm();
          }
        }
		
		// tab2
        if (currentIndex === 1) {
          if (stepDirection === 'forward') {
            var valid = frmInfo.valid();
            return valid;
          }
          if (stepDirection === 'backward') {
            frmInfoValidator.resetForm();
          }
        }

        // tab3
        if (currentIndex === 2) {
          if (stepDirection === 'forward') {
            var valid = frmLogin.valid();
            return valid;
          }
          if (stepDirection === 'backward') {
            frmLoginValidator.resetForm();
          }
        }

        // tab4
        if (currentIndex === 3) {
          if (stepDirection === 'forward') {
            var valid = frmMobile.valid();
            return valid;
          }
          if (stepDirection === 'backward') {
            frmMobileValidator.resetForm();
          }
        }

        return true;

      },
      onFinish: function () {
        alert('Wizard Completed');
      }
    });
  </script> 
<script>
    $('#demo').steps({
      onFinish: function () {
        alert('Wizard Completed');
      }
    });
  </script>
</body>
</html>
