<?php include 'header2.php'; 
if(empty($_SESSION['login_email']))
  {   
   header("Location: login.php"); 
   }
?>

<?php

$stmt = $dbh->query("SELECT * FROM websiteinfo");
$row_website = $stmt->fetch();

if(isset($_POST["btnsubmit"]))
{

$websitename =$_POST['txtwebsitename'];
$email = $_POST['txtemail'];
$phone1 = $_POST['txtphone1'];
$phone2 = $_POST['txtphone2'];
$url = $_POST['txturl'];
$address = $_POST['txtaddress'];
$SMS_username = $_POST['txtsms_username'];
$SMS_password = $_POST['txtsms_password'];


$image= addslashes(file_get_contents($_FILES['logoImage']['tmp_name']));
$image_name= addslashes($_FILES['logoImage']['name']);
$image_size= getimagesize($_FILES['logoImage']['tmp_name']);
move_uploaded_file($_FILES["logoImage"]["tmp_name"],"uploadImage/" . $_FILES["logoImage"]["name"]);			
$location1="uploadImage/" . $_FILES["logoImage"]["name"];
			
$image= addslashes(file_get_contents($_FILES['faviconImage']['tmp_name']));
$image_name= addslashes($_FILES['faviconImage']['name']);
$image_size= getimagesize($_FILES['faviconImage']['tmp_name']);
move_uploaded_file($_FILES["faviconImage"]["tmp_name"],"uploadImage/" . $_FILES["faviconImage"]["name"]);			
$location2="uploadImage/" . $_FILES["faviconImage"]["name"];

 //edit website details
$sql = "UPDATE websiteinfo SET website_name=?, email=?, phone1=?,phone2=?,address=?, url=?, logo=?,favicon=?,SMS_username=? ,SMS_password=? ";
$stmt= $dbh->prepare($sql);
$stmt->execute([$websitename, $email, $phone1, $phone2,$address,$url,$location1,$location2,$SMS_username,$SMS_password]);
if($stmt) {
  
//save activity log details
$task= $fullname.' '.'Updated Website'.' '. 'On' . ' '.$current_date;
$sql = 'INSERT INTO activity_log(task) VALUES(:task)';
$statement = $dbh->prepare($sql);
$statement->execute([
	':task' => $task
]);

$success='Website Setup Successfully ';

}else{
$error='Problem Setting up Website ';
}
}
?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from uxliner.com/adminkit/demo/main/ltr/form-layouts.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 14 May 2021 17:41:22 GMT -->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>SetUp Website - i-Support</title>
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
        <li><i class="fa fa-angle-right"></i> Setup Website</li>
      </ol>
    </div>
    
    <!-- Main content -->
    <div class="content">
      <div class="row" >
	  
	  <div class="" >
				<?php if($success){?>
          <div class="alert alert-success" role="alert" align="center">  <?php echo ($success); ?></div>
		  <?php } 
					else if($error){?>
           <div class="alert alert-danger" role="alert">  <?php echo ($error); ?></div>
 <?php } ?>
					
							
            <p>&nbsp;</p>
        </div>
        
      </div>
      <div class="row m-t-3">
        <div class="col-lg-12">
          <div class="card ">
            <div class="card-header bg-blue">
              <h5 class="text-white m-b-0">Setup Website </h5>
            </div>
            <div class="card-body">
              
             <form  action="" method="POST" enctype="multipart/form-data">
              <div class="row">
                
				
				
				<div class="col-md-6">
                  <div class="form-group has-feedback">
                    <label class="control-label">Website Name</label>
                    <input class="form-control" name="txtwebsitename" value="<?php echo $row_website['website_name'];   ?>" type="text">
					</div>
                </div>
                <div class="col-md-6">
                  <div class="form-group has-feedback">
                    <label class="control-label">Email</label>
                    <input class="form-control" name="txtemail" value="<?php echo $row_website['email'];   ?>" type="email">
                    <span class="fa fa-envelope form-control-feedback" aria-hidden="true"></span>
				    </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group has-feedback">
                    <label class="control-label">Phone 1</label>
                    <input class="form-control" name="txtphone1" value="<?php echo $row_website['phone1'];   ?>" type="text">
					<span class="fa fa-phone form-control-feedback" aria-hidden="true"></span> 

					</div>
                </div>
                <div class="col-md-6">
                  <div class="form-group has-feedback">
                    <label class="control-label">Phone 2</label>
                    <input class="form-control" name="txtphone2" value="<?php echo $row_website['phone2'];   ?>" type="text">
                    <span class="fa fa-phone form-control-feedback" aria-hidden="true"></span> 
					</div>
                </div>
                <div class="col-md-12">
                  <div class="form-group has-feedback">
                    <label class="control-label">Address</label>
                    <input class="form-control" name="txtaddress" value="<?php echo $row_website['address'];   ?>" type="text">
                    <span class="fa fa-address form-control-feedback" aria-hidden="true"></span> 
					</div>
                </div>
                <div class="col-md-6">
                  <div class="form-group has-feedback">
                    <label class="control-label">Url</label>
                    <input class="form-control" name="txturl" value="<?php echo $row_website['url'];   ?>" type="text">
                    <span class="fa fa-globe form-control-feedback" aria-hidden="true"></span> </div>
                </div>
				
                <div class="col-md-6">
                  <div class="form-group has-feedback">
                    <label class="control-label">SMS username</label>
                    <input class="form-control" name="txtsms_username" value="<?php echo $row_website['SMS_username'];   ?>" type="text">
					</div>
                </div>
				<div class="col-md-12">
                  <div class="form-group has-feedback">
                    <label class="control-label">SMS Password</label>
                    <input class="form-control" name="txtsms_password" value="<?php echo $row_website['SMS_password'];   ?>" type="text">
					</div>
                </div>
			
                <div class="col-md-12">
                <p class="text-left">
				 <label class="control-label">Logo</label>
				  </p>

                    <input name="logoImage" type="file" class="form-control" onChange="display_img(this)"/>
								                                <p class="text-center">
  
                   <img src="<?php echo $row_website['logo'];   ?>" alt="flexhomes" width="199" height="154" id="logo-img">  
				                                   </p>
 
				  </div>
					 <div class="col-md-12">
                     <p class="text-left">
	 <label class="control-label">Favicon</label>
</p>
                                  <input name="faviconImage" type="file" class="form-control" onChange="display_favicon(this)"/>
                                
								  
                                <p class="text-center">
                    <img src="<?php echo $row_website['favicon'];   ?>" alt="flexhomes" width="199" height="154" id="logo-favicon">   
				    </p>
				  </div>		
                <div class="col-md-12">
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
<script>
    function display_favicon(input) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#logo-favicon').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
   
</script>
</body>

<!-- Mirrored from uxliner.com/adminkit/demo/main/ltr/form-layouts.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 14 May 2021 17:41:22 GMT -->
</html>
