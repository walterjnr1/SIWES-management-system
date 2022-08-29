<?php
session_start();
error_reporting(0);
include('topbar.php');

if(strlen($_SESSION['login_reg_num'])=="")
  {   
  header("Location: ../index.php"); 
  }

  $reg_num=$_SESSION['login_reg_num'];

$stmt = $dbh->query("SELECT * FROM tblstudent where reg_num='$reg_num'");
$row_student = $stmt->fetch();
  

if(isset($_POST["btnupdate"]))
{
$fullname = $_POST['txtfullname'];
$email = $_POST['txtemail'];
$address = $_POST['txtaddress'];
$state = $_POST['cmdstate'];
$dept = $_POST['cmddept'];

	
//edit profile details
$sql = "UPDATE tblstudent SET fullname=?, email=?,address=?, state=?, dept=? where reg_num=?";
$stmt= $dbh->prepare($sql);
$stmt->execute([$fullname,$email,$address, $state,$dept,$reg_num]);
if($stmt) {
  
//save activity log details
$task= $fullname.' '.'Updated his Profile'.' '. 'On' . ' '.$current_date;
$sql = 'INSERT INTO activity_log(task) VALUES(:task)';
$statement = $dbh->prepare($sql);
$statement->execute([
	':task' => $task
]);

//$success='Profile Updated Successfully ';
header("Location: profile.php"); 

}else{
$error='Problem Editing Profile ';
}
}

  ?>

<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from uxliner.com/adminkit/demo/horizontal/ltr/pages-profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 14 May 2021 19:36:56 GMT -->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Profile (<?php echo $row_student['fullname']; ?>) | <?php echo $row_website['website_name'];   ?></title>
<!-- Tell the browser to be responsive to screen width -->
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- v4.0.0 -->
<link rel="stylesheet" href="dist/bootstrap/css/bootstrap.min.css">

<!-- Favicon -->
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $favicon; ?>">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

<!-- Theme style -->
<link rel="stylesheet" href="dist/css/style.css">
<link rel="stylesheet" href="dist/css/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="dist/css/et-line-font/et-line-font.css">
<link rel="stylesheet" href="dist/css/themify-icons/themify-icons.css">
<link rel="stylesheet" href="dist/css/simple-lineicon/simple-line-icons.css">

<!-- hmenu -->
<link rel="stylesheet" href="dist/plugins/hmenu/ace-responsive-menu.css">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<style type="text/css">
<!--
.style1 {color: #000000}
-->
</style>
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper boxed-wrapper">
  <header class="main-header"> 
  <!-- Logo --> 
    <a href="index.php" class="logo blue-bg"> 
    <!-- mini logo for sidebar mini 50x50 pixels --> 
    <span class="logo-mini"><img src="<?php echo $logo; ?>" alt=""></span> 
    <!-- logo for regular state and mobile devices --> 
    <span class="logo-lg"><img src="<?php echo $logo; ?>" alt="" width="122" height="55"></span> </a> 
    <!-- Header Navbar -->
    <nav class="navbar blue-bg navbar-static-top"> 
      <!-- Sidebar toggle button-->
      <div class="pull-left search-box">
        <form action="#" method="get" class="search-form">
          <div class="input-group">
            <input name="search" class="form-control" placeholder="" type="text">
            <span class="input-group-btn">
            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i> </button>
            </span></div>
        </form>
        <!-- search form --> </div>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
         
          <!-- User Account  -->
          <li class="dropdown user user-menu p-ph-res"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <img src="../Admin/<?php echo $row_student['photo']; ?>" class="user-image" alt="User Image"> <span class="hidden-xs"><?php echo $row_student['fullname']; ?>  </span> </a>
          <ul class="dropdown-menu">
              <li class="user-header">
                <div class="pull-left user-img"><img src="../Admin/<?php echo $row_student['photo']; ?> " class="img-responsive img-circle" alt="User"></div>
                <p class="text-left"><?php echo $row_student['fullname']; ?>  <small><?php echo $row_student['email']; ?> </small> </p>
              </li>
              <li><a href="profile.php"><i class="icon-profile-male"></i> My Profile</a></li>
			   <li role="separator" class="divider"></li>
              <li><a href="changepassword.php"><i class="icon-gears"></i> Change Password</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  
  <!-- Main Nav -->
 <?php include('sidebar.php'); ?>
  <!-- Main Nav -->
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> 
    <!-- Content Header (Page header) -->
    <div class="content-header sty-one">
      <h1>Profile page</h1>
      <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><i class="fa fa-angle-right"></i> Profile page</li>
      </ol>
    </div>
    
    <!-- Main content -->
    <div class="content">
      <div class="row">
        <div class="col-lg-4">
          <div class="user-profile-box m-b-3">
            <div class="box-profile text-white"> <img class="profile-user-img img-responsive img-circle m-b-2" src="../Admin/<?php echo $row_student['photo']; ?>" alt="client profile picture">
              <h3 class="profile-username text-center style1"><?php echo $row_student['fullname']; ?> </h3>
              <p class="text-center"></p>
            </div>
          </div>
          <div class="card m-b-3">
            <div class="card-body">
              <div class="box-body"> 
			  
               
                <strong><i class="fa fa-envelope margin-r-5"></i> Reg No</strong>
                <p class="text-muted"><?php echo $row_student['reg_num']; ?></p>
                <hr>
                <strong><i class="fa fa-phone margin-r-5"></i>SIWES Place</strong>
                <p><?php echo $row_student['siwes_place']; ?></p>
              <hr>
                <strong><i class="fa fa-phone margin-r-5"></i>Supervisor</strong>
                <p><?php echo $row_student['siwes_supervisor']; ?></p>
              </div>
              <!-- /.box-body --> 
            </div>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="info-box">
            <div class="card tab-style1"> 
              <!-- Nav tabs -->
              <ul class="nav nav-tabs profile-tab" role="tablist">
               
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#settings" role="tab">Details</a></li>
              </ul>
              <p><?php if($success){?>
          <div class="alert alert-success" role="alert" align="center">  <?php echo ($success); ?></div>
		  <?php } 
					else if($error){?>
           <div class="alert alert-danger" role="alert">  <?php echo ($error); ?></div>
 <?php } ?></p>
              <ul class="nav nav-tabs profile-tab" role="tablist">
                <li class="nav-item"> </li>
              </ul>
              <!-- Tab panes -->
         
                <!--second tab-->
              
                <div class="tab-pane" id="settings" role="tabpanel">
                  <div class="card-body">
             <form  action="" method="POST" enctype="multipart/form-data">

                      <div class="form-group">
                        <label class="col-md-12">Full Name</label>
                        <div class="col-md-12">
                          <input name="txtfullname" class="form-control form-control-line" type="text" value="<?php echo $row_student['fullname']; ?>">
                        </div>
                      </div>
					   
					   <div class="form-group">
                        <label class="col-md-12">Email Address</label>
                        <div class="col-md-12">
                          <input class="form-control form-control-line" name="txtemail" type="text" value="<?php echo $row_student['email']; ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="example-email" class="col-md-12">Address</label>
                        <div class="col-md-12">
                          <input value="<?php echo $row_student['address']; ?>" class="form-control form-control-line" name="txtaddress" id="example-email" type="text">
                        </div>
                      </div>
                        <div class="form-group">
                        <label class="col-md-12">State</label>
                        <div class="col-md-12">
<select name="cmdstate" class="form-last-name form-control" id="state" >
          <option value="<?php echo $row_student['state']; ?>"><?php echo $row_student['state']; ?></option>
          <option value="Abia">Abia</option>
          <option value="Adamawa">Adamawa</option>
          <option value="Akwa Ibom">Akwa Ibom</option>
          <option value="Anambra">Anambra</option>
          <option value="Bauchi">Bauchi</option>
          <option value="Bayelsa">Bayelsa</option>
          <option value="Benue">Benue</option>
          <option value="Borno">Borno</option>
          <option value="Cross River">Cross River</option>
          <option value="Delta">Delta</option>
          <option value="Ebonyi">Ebonyi</option>
          <option value="Edo">Edo</option>
          <option value="Ekiti">Ekiti</option>
          <option value="Enugu">Enugu</option>
          <option value="FCT">FCT</option>
          <option value="Gombe">Gombe</option>
          <option value="Imo">Imo</option>
          <option value="Jigawa">Jigawa</option>
          <option value="Kaduna">Kaduna</option>
          <option value="Kano">Kano</option>
          <option value="Kastina">Kastina</option>
          <option value="Kebbi">Kebbi</option>
          <option value="Kogi">Kogi</option>
          <option value="Kwara">Kwara</option>
          <option value="Lagos">Lagos</option>
          <option value="Nasarawa">Nasarawa</option>
          <option value="Niger">Niger</option>
          <option value="Ogun">Ogun</option>
          <option value="Ondo">Ondo</option>
          <option value="Osun">Osun</option>
          <option value="Oyo">Oyo</option>
          <option value="Plateau">Plateau</option>
          <option value="Rivers">Rivers</option>
          <option value="Sokoto">Sokoto</option>
          <option value="Taraba">Taraba</option>
          <option value="Yobe">Yobe</option>
          <option value="Zamfara">Zamfara</option>
        </select>
		                </div>
                      </div>
                    
					
				 <div class="form-group">
                        <label class="col-md-12">Department</label>
                        <div class="col-md-12">
<select name="cmddept"  id="cmddept" class="form-control" >
          <option value="<?php echo $row_student['dept']; ?>"><?php echo $row_student['dept']; ?></option>
       		    <option value="Computer Science">Computer Science</option>
		         <option value="Computer information Systems">Computer information Systems</option>
          		 <option value="Computer Technology">Computer Technology</option>
 				<option value="Computer information Systems">Computer information Systems</option>
      	    	 <option value="Software Engineering ">Software Engineering</option>
		         <option value="Information Technology">Information Technology</option>
            </select>
		                </div>
                      </div>
                    
				
                      </div>
					
                      <div class="form-group">
                        <div class="col-sm-12">
						<button type="submit" name="btnupdate" class="btn btn-success">Update Profile</button>

                        </div>
                      </div>
                    </form>
                  </div>
                </div>
            </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Main row --> 
    </div>
    <!-- /.content --> 
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs"></div>
   <?php include('footer.php'); ?></footer>
</div>
<!-- ./wrapper --> 

<!-- jQuery 3 --> 
<script src="dist/js/jquery.min.js"></script>
 
<script src="dist/plugins/popper/popper.min.js"></script>

<!-- v4.0.0-alpha.6 -->
<script src="dist/bootstrap/js/bootstrap.min.js"></script>

<!-- template --> 
<script src="dist/js/adminkit.js"></script>

<!-- Chart Peity JavaScript --> 
<script src="dist/plugins/peity/jquery.peity.min.js"></script> 
<script src="dist/plugins/functions/jquery.peity.init.js"></script>
<script src="dist/plugins/hmenu/ace-responsive-menu.js" ></script> 
<!--Plugin Initialization--> 
<script >
         $(document).ready(function () {
             $("#respMenu").aceResponsiveMenu({
                 resizeWidth: '768', // Set the same in Media query       
                 animationSpeed: 'fast', //slow, medium, fast
                 accoridonExpAll: false //Expands all the accordion menu on click
             });
         });
</script>
<script>
    function display_img(input) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#logo-img').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
   
</script>
</body>

<!-- Mirrored from uxliner.com/adminkit/demo/horizontal/ltr/pages-profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 14 May 2021 19:36:56 GMT -->
</html>
