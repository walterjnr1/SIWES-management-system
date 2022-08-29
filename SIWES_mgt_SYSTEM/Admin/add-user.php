<?php include 'header2.php'; 
error_reporting(0);

if(empty($_SESSION['login_email']))
  {   
   header("Location: login.php"); 
   }
?>

<?php

$stmt = $dbh->query("SELECT * FROM users");
$row = $stmt->fetch();

if(isset($_POST["btnsubmit"]))
{

$length = 5;
$password2 = $_POST['txtpassword'];
$last_ip="Not Available";
$lastaccess="Not Available";
$status="Active";


$file_type = $_FILES['avatar']['type']; //returns the mimetype
$allowed = array("image/jpeg", "image/gif","image/jpeg", "image/webp","image/png");
if(!in_array($file_type, $allowed)) {
$error = 'Only jpeg,Webp, gif, and png files are allowed.';
 // exit();

}else{
$image= addslashes(file_get_contents($_FILES['avatar']['tmp_name']));
$image_name= addslashes($_FILES['avatar']['name']);
$image_size= getimagesize($_FILES['avatar']['tmp_name']);
move_uploaded_file($_FILES["avatar"]["tmp_name"],"uploadImage/" . $_FILES["avatar"]["name"]);			
$location="uploadImage/" . $_FILES["avatar"]["name"];
			
///check if email already exist
$stmt = $dbh->prepare("SELECT * FROM users WHERE email=?");
$stmt->execute([$_POST['txtemail']]); 
$user = $stmt->fetch();

if ($user) {
$error='Email Already Exist in our Database ';
} else {
 //Add User details
$sql = 'INSERT INTO users(email,password,fullname,dept,lastaccess,last_ip,groupname,phone,status,photo) VALUES(:email,:password,:fullname,:dept,:lastaccess,:last_ip,:groupname,:phone,:status,:photo)';
$statement = $dbh->prepare($sql);
$statement->execute([
	':email' => $_POST['txtemail'],
	':password' => $password2,
	':fullname' => $_POST['txtfullname'],
		':dept' => $_POST['cmddept'],
	':lastaccess' => $lastaccess,
	':last_ip' => $last_ip,
	':groupname' => $_POST['cmdtype'],
		':phone' => $_POST['txtphone'],
	':status' => $status,
	':photo' => $location

]);
if ($statement){
//send password via SMS
$username=$SMS_username;//Note: urlencodemust be added forusernameand 
$password=$SMS_password;// passwordas encryption code for security purpose.

$sender='SIWES';
$url = "http://portal.nigeriabulksms.com/api/?username=".$username."&password=".$password."&message="."You Account has been created Successfully .Password: $password2." ."&sender=".$sender."&mobiles=".$_POST['txtphone'];

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, 0);
$resp = curl_exec($ch);

//save activity log details
$task= $fullname.' '.'Added New User'.' '. 'On' . ' '.$current_date;
$sql = 'INSERT INTO activity_log(task) VALUES(:task)';
$statement = $dbh->prepare($sql);
$statement->execute([
	':task' => $task
]);

$success='Added User Successfully ';

}else{
$error='Problem Adding New User ';
}
}
}
}
?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from uxliner.com/adminkit/demo/main/ltr/form-layouts.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 14 May 2021 17:41:22 GMT -->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Add New User| <?php echo $row_website['website_name']; ?></title>
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

    <?php include 'header.php'; ?>

  <!-- Left side column. contains the logo and sidebar -->
  <?php include 'sidebar.php'; ?>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> 
    <!-- Content Header (Page header) -->
    <div class="content-header sty-one">
      <h1>&nbsp;</h1>
      <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><i class="fa fa-angle-right"></i>New User</li>
      </ol>
    </div>
    
    <!-- Main content -->
    <div class="content">
      <div class="row" align="center" >
	   <p align="center">	
	   			<?php if($success){?>
          <div class="alert alert-success" role="alert" align="center">  <?php echo ($success); ?></div>
		  <?php } 
					else if($error){?>
           <div class="alert alert-danger" role="alert">  <?php echo ($error); ?></div>
 <?php } ?>
</p>
        
      </div>
      <div class="row m-t-3">
       
        <div class="col-lg-8">
          <div class="card ">
            <div class="card-header bg-blue">
              <h5 class="text-white m-b-0">Create User </h5>
            </div>
            <div class="card-body">
              
             <form  action="" method="POST" enctype="multipart/form-data">
              <div class="row">
                
				
	 <div class="col-md-10">
                  <div class="form-group has-feedback">
                    <label class="control-label">Fullname</label>
                    <input class="form-control" name="txtfullname" value="<?php if (isset($_POST['txtfullname']))?><?php echo $_POST['txtfullname']; ?>" type="text">
                    <span class="fa fa-user form-control-feedback" aria-hidden="true"></span> </div>
                </div>      
				<div class="col-md-10">
                  <div class="form-group has-feedback">
                    <label class="control-label">Password</label>
                    <input class="form-control" name="txtpassword" value="<?php 
					
					//generate 4 characters random string
 function generateRandomString($length = 4, $letters = '1234567890QWERTYUIOPASDFGHJKLZXCVBNM'){
    $s = '';
    $lettersLength = strlen($letters)-1;

    for($i = 0 ; $i < $length ; $i++)
    {
        $s .= $letters[rand(0,$lettersLength)];
    }

    return $s;
} 

echo generateRandomString().generateRandomString();
					
					 ?>" type="text" readonly="">
				    </div>
                </div>              
                <div class="col-md-10">
                  <div class="form-group has-feedback">
                    <label class="control-label">Email</label>
                    <input class="form-control" name="txtemail" value="<?php if (isset($_POST['txtemail']))?><?php echo $_POST['txtemail']; ?>" type="email">
                    <span class="fa fa-envelope form-control-feedback" aria-hidden="true"></span>
				    </div>
                </div>
                <div class="col-md-10">
                  <div class="form-group has-feedback">
                    <label class="control-label">Phone</label>
                    <input class="form-control" name="txtphone" value="<?php if (isset($_POST['txtphone']))?><?php echo $_POST['txtphone']; ?>" type="num">
				    </div>
                </div>
				 <div class="col-md-10">
                  <div class="form-group has-feedback">
                    <label class="control-label">User Type</label>
					<?php
			$sql = "select * from tblgroup where groupname !='Super Admin'";
             $group = $dbh->query($sql);                       
             $group->setFetchMode(PDO::FETCH_ASSOC);
             echo '<select name="cmdtype"  id="cmdtype" class="form-control" >';
			 			     echo '<option value="">Select User Type</option>';
             while ( $row = $group->fetch() ) 
             {
                echo '<option value="'.$row['groupname'].'">'.$row['groupname'].'</option>';
             }

             echo '</select>';
			 ?>  
					</div>
                </div>
                               <div class="col-md-10">
                  <div class="form-group has-feedback">
                    <label class="control-label">Department</label>
					
             <select name="cmddept"  id="cmddept" class="form-control" >
			 	<option value="">Select Department</option>
           <option value="Computer Science">Computer Science</option>
		              <option value="Computer information Systems">Computer information Systems</option>
           <option value="Computer Technology">Computer Technology</option>
 <option value="Computer information Systems">Computer information Systems</option>
           <option value="Software Engineering ">Software Engineering</option>
		              <option value="Information Technology">Information Technology</option>

            </select>
			 
					</div>
                </div> 
                <div class="col-md-10">
                                <p class="text-center">
                        <input type="file" name="avatar" id="avatar" required class="form-control form-control-sm rounded-0" accept="image/png,image/jpeg,image/jpg" onChange="display_img(this)">
                                </p>
								  
                                <p class="text-center">
                                    <img src="dist/img/default.jpg" alt="<?php echo $website_name ;?>" width="142" height="143" id="logo-img">				    </p>
				  </div>
								
                <div class="col-md-10">
                  <button type="submit" name="btnsubmit" class="btn btn-success">Submit</button>
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
    function display_img(input){
        if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#logo-img').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
    }
	</script>
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

<!-- Mirrored from uxliner.com/adminkit/demo/main/ltr/form-layouts.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 14 May 2021 17:41:22 GMT -->
</html>
