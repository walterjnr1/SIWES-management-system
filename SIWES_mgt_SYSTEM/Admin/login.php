<?php 
include 'header2.php'; 
if(isset($_POST['btnlogin']))
{
if($_POST['txtemail'] != "" || $_POST['txtpassword'] != ""){

$email =$_POST['txtemail'];
$password = $_POST['txtpassword'];
$status = 'Active';

$sql = "SELECT * FROM `users` WHERE `email`=? AND `password`=? AND `status`=?";
			$query = $dbh->prepare($sql);
			$query->execute(array($email,$password,$status));
			$row = $query->rowCount();
			$fetch = $query->fetch();
			if($row > 0) {
			$_SESSION['login_email'] = $fetch['email'];
			$_SESSION['login_fullname'] = $fetch['fullname'];
		$_SESSION['login_pic'] = $fetch['photo'];
		$_SESSION['login_groupname'] = $fetch['groupname'];
		$_SESSION['logged']=time();
		
//save activity log details
$fullname=$fetch['fullname'];
$task= $fullname.' '.'Logged In'.' '. 'On' . ' '.$current_date;

$sql = 'INSERT INTO activity_log(task) VALUES(:task)';
$statement = $dbh->prepare($sql);
$statement->execute([
	':task' => $task
]);

header("Location: index.php");

} else{
$error='Invalid Email/Password';
}
}else{
$error='Must Fill-in All Fields ';

}
}

?>
<!DOCTYPE html>
<html lang="en">
  
<!-- Mirrored from www.bootstrapdash.com/demo/star-admin-free/jquery/src/pages/samples/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 12 May 2022 12:43:45 GMT -->
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Admin Login|<?php echo $row_website['website_name'];   ?></title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/ionicons/dist/css/ionicons.css">
    <link rel="stylesheet" href="assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.addons.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="assets/css/shared/style.css">
    <!-- endinject -->
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo $row_website['favicon'];   ?> ">
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
          <div class="row w-100">
            <div class="col-lg-4 mx-auto">
              <div class="auto-form-wrapper">
    <form action="" method="post">
                  <div class="form-group">
				  <?php if($success){?>
          <div class="alert alert-success" role="alert" align="center">  <?php echo ($success); ?></div>
		  <?php } 
					else if($error){?>
           <div class="alert alert-danger" role="alert">  <?php echo ($error); ?></div>
 <?php } ?>
                    <label class="label">Email</label>
                    <div class="input-group">
                      <input type="text" name="txtemail" class="form-control" placeholder="Email Address">
                      <div class="input-group-append">
                        <span class="input-group-text">
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="label">Password</label>
                    <div class="input-group">
                      <input type="password" name="txtpassword" class="form-control" placeholder="*********">
                      <div class="input-group-append">
                        <span class="input-group-text">
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <button class="btn btn-primary submit-btn btn-block" name="btnlogin">Login</button>
                  </div>
                  <div class="form-group d-flex justify-content-between">
                    
                    <a href="forgot-password.php" class="text-small forgot-password text-black">Forgot Password</a>
                  </div>
                  
                </form>
              </div>
              <ul class="auth-footer">
                <li></li>
              </ul>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../../assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="../../assets/vendors/js/vendor.bundle.addons.js"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="../../assets/js/shared/off-canvas.js"></script>
    <script src="../../assets/js/shared/misc.js"></script>
    <!-- endinject -->
    <script src="../../assets/js/shared/jquery.cookie.js" type="text/javascript"></script>
  </body>

<!-- Mirrored from www.bootstrapdash.com/demo/star-admin-free/jquery/src/pages/samples/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 12 May 2022 12:44:55 GMT -->
</html>