<?php
include('topbar.php');
if(strlen($_SESSION['login_reg_num'])=="")
  {   
  header("Location: ../index.php"); 
  }
?>

<?php

$reg_num=$_SESSION['login_reg_num'];

$stmt = $dbh->query("SELECT * FROM tblstudent where reg_num='$reg_num'");
$row_student = $stmt->fetch();


if(isset($_POST["btnupload"]))
{
$image= addslashes(file_get_contents($_FILES['logbook']['tmp_name']));
$image_name= addslashes($_FILES['logbook']['name']);
$image_size= getimagesize($_FILES['logbook']['tmp_name']);
move_uploaded_file($_FILES["logbook"]["tmp_name"],"../Admin/Upload_SIWES/" . $_FILES["logbook"]["name"]);			
$logbook="Upload_SIWES/" . $_FILES["logbook"]["name"];
			
///check if logbook already exist
$stmt = $dbh->prepare("SELECT * FROM upload_logbook WHERE reg_num=? and log_week=?");
$stmt->execute([$reg_num,$_POST['txtweek']]); 
$user = $stmt->fetch();

if ($user) {
$error='Log book Already Exist for this week ';
} else {
 //Add logbook details
$sql = 'INSERT INTO upload_logbook(log_week,date_upload,reg_num,topic,log_book,comment) VALUES(:log_week,:date_upload,:reg_num,:topic,:log_book,:comment)';
$statement = $dbh->prepare($sql);
$statement->execute([
	':log_week' => $_POST['txtweek'],
	':date_upload' => $_POST['txtdate'],
	':reg_num' => $reg_num,
		':topic' => $_POST['txttopic'],
	':log_book' => $logbook,
	':comment' => ''
	]);
if ($statement){

//save activity log details
$task= $fullname.' '.'Uploaded Log book'.' '. 'On' . ' '.$current_date;
$sql = 'INSERT INTO activity_log(task) VALUES(:task)';
$statement = $dbh->prepare($sql);
$statement->execute([
	':task' => $task
]);

$success='Log Book Uploaded Successfully for week '.''.$_POST['txtweek'] ;
}else{
$error='Problem Uploading SIWES Log book';

}
}
}

?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from uxliner.com/adminkit/demo/horizontal/ltr/form-layouts.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 14 May 2021 19:36:37 GMT -->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Upload Log Book| <?php echo $row_website['website_name'];   ?></title>
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

<!-- form wizard -->
<link rel="stylesheet" href="dist/plugins/formwizard/jquery-steps.css">

<!-- hmenu -->
<link rel="stylesheet" href="dist/plugins/hmenu/ace-responsive-menu.css">
<!-- dropify -->
<link rel="stylesheet" href="dist/plugins/dropify/dropify.min.css">

<!-- hmenu -->
<link rel="stylesheet" href="dist/plugins/hmenu/ace-responsive-menu.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

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
      <h1>Upload Log Book</h1>
      <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><i class="fa fa-angle-right"></i>Upload Log Book</li>
      </ol>
    </div>
    
    <!-- Main content -->
    <div class="content">
      <div class="row">
        <div class="col-lg-9">
          <div class="card card-outline">
            <div class="card-header bg-blue">
              <h5 class="text-white m-b-0">Upload</h5>
            </div>
            <div class="card-body">
			<?php if($success){?>
          <div class="alert alert-success" role="alert" align="center">  <?php echo ($success); ?></div>
		  <?php } 
					else if($error){?>
           <div class="alert alert-danger" role="alert">  <?php echo ($error); ?></div>
 <?php } ?>
             <form  action="" method="POST" enctype="multipart/form-data">
              
              <div class="form-group">
           
			   
		    <label for="exampleInputEmail1">Week (Figure)</label>

		<input type="number" class="form-control" id="txtold_password" name="txtweek" value="<?php if (isset($_POST['txtweek']))?><?php echo $_POST['txtweek']; ?>" required>

              </div>
			  <div class="form-group">
                <label for="exampleInputEmail1">Date</label>
		<input type="date" class="form-control" id="refplotno" name="txtdate" value="<?php if (isset($_POST['txtdate']))?><?php echo $_POST['txtdate']; ?>" required>

              </div>
			  <div class="form-group">
                <label for="exampleInputEmail1">Project/Job For the Week</label>
		<input type="text" class="form-control" id="refplotno" name="txttopic" value="<?php if (isset($_POST['txttopic']))?><?php echo $_POST['txttopic']; ?>" required>

              </div>
            <div class="form-group">
              <label for="input-file-now">Log Book (image only)</label>
              <input type="file" name="logbook" id="logbook" class="dropify" />
            </div>
              
 
		<button type="submit" name="btnupload" class="btn btn-primary" >Submit</button>
 
            </form>
            </div>
          </div>
        </div>
      </div>
      <div class="row m-t-3"></div>
	        <div class="row m-t-3"></div>
      <div class="row m-t-3"></div>
      <div class="row m-t-3"></div>

    </div>
    <!-- /.content --> 
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs"></div>
  <?php include('../Admin/footer.php');?></footer>
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
<!-- dropify --> 
<script src="dist/plugins/dropify/dropify.min.js"></script> 
<script>
            $(document).ready(function(){
                // Basic
                $('.dropify').dropify();

                // Translated
                $('.dropify-fr').dropify({
                    messages: {
                        default: 'Glissez-déposez un fichier ici ou cliquez',
                        replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                        remove:  'Supprimer',
                        error:   'Désolé, le fichier trop volumineux'
                    }
                });

                // Used events
                var drEvent = $('#input-file-events').dropify();

                drEvent.on('dropify.beforeClear', function(event, element){
                    return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
                });

                drEvent.on('dropify.afterClear', function(event, element){
                    alert('File deleted');
                });

                drEvent.on('dropify.errors', function(event, element){
                    console.log('Has Errors');
                });

                var drDestroy = $('#input-file-to-destroy').dropify();
                drDestroy = drDestroy.data('dropify')
                $('#toggleDropify').on('click', function(e){
                    e.preventDefault();
                    if (drDestroy.isDropified()) {
                        drDestroy.destroy();
                    } else {
                        drDestroy.init();
                    }
                })
            });
        </script>
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



</body>

<!-- Mirrored from uxliner.com/adminkit/demo/horizontal/ltr/form-layouts.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 14 May 2021 19:36:37 GMT -->
</html>
