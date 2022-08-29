<?php include 'header2.php'; 
if(empty($_SESSION['login_email']))
  {   
   header("Location: login.php"); 
   }
$email=$_SESSION['login_email'] ;

$stmt = $dbh->query("SELECT * FROM users where email='$email'");
$row_user = $stmt->fetch();

if(isset($_POST["btnupdate"]))
{

$fullname = $_POST['txtfullname'];
$groupname =$_POST['cmdtype'];

$file_type = $_FILES['logoImage']['type']; //returns the mimetype
$allowed = array("image/jpeg", "image/gif","image/jpeg", "image/webp","image/png");
if(!in_array($file_type, $allowed)) {
$error = 'Only jpeg,Webp, gif, and png files are allowed.';
 // exit();

}else{
$image= addslashes(file_get_contents($_FILES['logoImage']['tmp_name']));
$image_name= addslashes($_FILES['logoImage']['name']);
$image_size= getimagesize($_FILES['logoImage']['tmp_name']);
move_uploaded_file($_FILES["logoImage"]["tmp_name"],"uploadImage/" . $_FILES["logoImage"]["name"]);			
$location="uploadImage/" . $_FILES["logoImage"]["name"];
			

//edit profile details
$sql = "UPDATE users SET fullname=?, groupname=?, photo=? where email=?";
$stmt= $dbh->prepare($sql);
$stmt->execute([$fullname, $groupname, $location,$email]);
if($stmt) {
  
//save activity log details
$task= $fullname.' '.'Updated his Profile'.' '. 'On' . ' '.$current_date;
$sql = 'INSERT INTO activity_log(task) VALUES(:task)';
$statement = $dbh->prepare($sql);
$statement->execute([
	':task' => $task
]);

//$success='Profile Editted Successfully ';
   header("Location: edit-profile.php"); 

}else{
$error='Problem Editting Profile ';
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
<title>Edit Profile |<?php echo $row_website['website_name'];   ?></title>
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
      <h1>Edit Profile</h1>
      <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><i class="fa fa-angle-right"></i>Edit Profile</li>
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
        <div class="col-lg-10">
          <div class="card card-outline">
            <div class="card-header bg-blue">
              <h5 class="text-white m-b-0">Edit Profile</h5>
            </div>
            <div class="card-body">
             <form  action="" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <label for="exampleInputEmail1">Fullname</label>
<input type="text" name="txtfullname" value="<?php echo $row_user['fullname']; ?>"  class="form-control" required="">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Group Name</label>
 			<?php
			$sql = "select * from tblgroup";
             $group = $dbh->query($sql);                       
             $group->setFetchMode(PDO::FETCH_ASSOC);
             echo '<select name="cmdtype"  id="cmdtype" class="form-control" >';
				echo '<option value="'.$row_user['groupname'].'">'.$row_user['groupname'].'</option>';

             while ( $row = $group->fetch() ) 
             {
                echo '<option value="'.$row['groupname'].'">'.$row['groupname'].'</option>';
             }

             echo '</select>';
			 ?>  
 
                </div>
              
              <div class="form-group">
                                <p class="text-center">
                                  <input name="logoImage" type="file" class="form-control" onChange="display_img(this)"/>
                                </p>
								  
                                <p class="text-center">
                                    <img src="<?php echo $row_user['photo'];   ?>" alt="admin photo" width="178" height="154" id="logo-img">   
				    </p>
				  </div>
			  
             
              <button type="submit" name="btnupdate" class="btn btn-success">Update</button>
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
</html>
