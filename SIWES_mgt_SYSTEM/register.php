<?php
session_start();
error_reporting(0);
include('topbar.php');

$message = '';
if(isset($_POST["btnsubmit"]))
{
 sleep(5);
 
$status=0;

if (strlen($_POST["txtpassword"]) > 15){
$message = ' <div class="alert alert-danger">Password Length can not be more than 15</div> ';

}else if (strlen($_POST["txtpassword"]) < 4){
$message = ' <div class="alert alert-danger">Password Length can not be less than 4</div> ';

}
///check if reg no already exist
$stmt = $dbh->prepare("SELECT * FROM tblstudent WHERE reg_num=?");
$stmt->execute([$_POST["txtregno"]]); 
$client = $stmt->fetch();

if ($client) {

$message = '
 <div class="alert alert-danger">This Reg Number Already Exist</div>
 ';
 
  
} else {

//Fetch Supervisor randomly for this Student
$q = "select * from users ORDER BY RAND() LIMIT 1";
  $q1 = $conn->query($q);
  while($row = mysqli_fetch_array($q1)){
    extract($row);
    $fullname = $row['ID'];
  }
  

$query = "
 INSERT INTO tblstudent (reg_num,password, fullname, email, address,state,dept,siwes_place,siwes_supervisor,status,photo) VALUES (:reg_num,:password, :fullname, :email, :address,:state,:dept,:siwes_place,:siwes_supervisor,:status,:photo)";
 
 $user_data = array(
  ':reg_num'  => $_POST["txtregno"],
  ':password'   => $_POST["txtpassword"],
    ':fullname'   => $_POST["txtfullname"],
  ':email'   => $_POST["txtemail"],
  ':address'   => $_POST["txtaddress"],
   ':state'  => $_POST["cmdstate"],
   ':dept'  => $_POST["cmddept"],
      ':siwes_place'  => $_POST["txtsiwes"],
      ':siwes_supervisor'  =>$fullname,
	    ':status'  => 1,
      ':photo'  => 'uploadImage/default.jpg'
  );
  
 $statement = $dbh->prepare($query);
 if($statement->execute($user_data))
 {


//save activity log details
$fullname = $firstname." ".$lastname;
$task= $fullname.' '.'Registered'.' '. 'On' . ' '.$current_date;
 $query_log = "
 INSERT INTO activity_log (task) VALUES (:task)";
 
 $log_data = array(
  ':task'  => $task
 );
 $statement = $dbh->prepare($query_log);
 
//get supervisor name
$stmt = $dbh->query("SELECT * FROM tblstudent INNER JOIN users ON tblstudent.siwes_supervisor=users.ID WHERE tblstudent.reg_num='".$_POST["txtregno"]."'");
$row_supervisor = $stmt->fetch();
$alert_supervisor = $row_supervisor['fullname'] ;
 
 $message = ' <div class="alert alert-success">Your Registration Was successful. Your SIWES Supervisor is '.$alert_supervisor.'</div>';

 } else {
 
  $message = '
 <div class="alert alert-danger"> There is an error in Registration  </div> ';
 }
}
}
?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from brandio.io/envato/iofrm/html/login15.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 08 May 2022 19:01:51 GMT -->
<head>
      <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	 <title>Siwes Registration Form| <?php echo $website_name ;?></title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="css/iofrm-theme2.css">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo $favicon; ?>">
    <link rel="stylesheet" type="text/css" href="css/iofrm-theme15.css">
</head>
<body>
    <div class="form-body">
        <div class="website-logo">
            <a href="index.php">
                <div class="logddo"></div>
            </a>
        </div>
        <div class="row">
            <div class="img-holder">
                <div class="bg"></div>
                <div class="info-holder">
                    
                </div>
            </div>
           <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">                         
                      <p ><a href="index.php"><span class="logos"><img class="logo-size" src="<?php echo $logo; ?>" alt="logo" height="110" width="360"></span></a></p>
                      <h3><?php echo $website_name ;?> - Student Registration Form</h3>
                        <p><h4 ><?php echo $message; ?></h4></p>
                        <p> </p>
                        <div class="page-links">
                            <a href="index.php">Login</a><a href="register.php" class="active">Register</a>
                        </div>
                <form  action="" method="POST"  class="registration-form">
              <input class="form-control" type="text" name="txtregno" value="<?php if (isset($_POST['txtregno']))?><?php echo $_POST['txtregno']; ?>"  placeholder="Registration No" required>
				<input class="form-control" type="password" name="txtpassword" value="<?php if (isset($_POST['txtpassword']))?><?php echo $_POST['txtpassword']; ?>"  placeholder="password" required>
            <input class="form-control" type="text" name="txtfullname" value="<?php if (isset($_POST['txtfullname']))?><?php echo $_POST['txtfullname']; ?>"  placeholder="Fullname" required>
           <input class="form-control" type="email" name="txtemail" value="<?php if (isset($_POST['txtemail']))?><?php echo $_POST['txtemail']; ?>"  placeholder="Email Address" required>
		 <textarea name="txtaddress" class="form-control" value="<?php if (isset($_POST['txtaddress']))?><?php echo $_POST['txtaddress']; ?>"  placeholder="Address" required="required"></textarea>
			

			<select class="form-control" name="cmdstate" class="form-control" id="state" >
          <option value="">Select your State</option>
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
				 <p> </p>
				<select name="cmddept"  id="cmddept" class="form-control" >
			 	<option value="">Select Department</option>
       		    <option value="Computer Science">Computer Science</option>
		         <option value="Computer information Systems">Computer information Systems</option>
          		 <option value="Computer Technology">Computer Technology</option>
 				<option value="Computer information Systems">Computer information Systems</option>
      	    	 <option value="Software Engineering ">Software Engineering</option>
		         <option value="Information Technology">Information Technology</option>
            </select>
				 <p> </p>

					 <textarea name="txtsiwes" class="form-control" value="<?php if (isset($_POST['txtsiwes']))?><?php echo $_POST['txtsiwes']; ?>"  placeholder="Place of SIWES" required="required"></textarea>

                            <div class="form-button">
                                <button id="submit" name="btnsubmit" type="submit" class="ibtn">Register</button>
                            </div>
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