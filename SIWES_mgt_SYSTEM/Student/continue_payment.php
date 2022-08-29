<?php

include('topbar.php');

if(strlen($_SESSION['login_email'])=="")
  {   
  header("Location: ../index.php"); 
  }else if(($_GET['bal'])==0){
 //$_SESSION['error']='You can not proceed further because you have cleared our outstanding';
?>
  <script>
    alert('You can not proceed further because you have cleared our outstanding');
	window.location = "index.php";

    </script>
  <?php 
  }else{
  
  $pl_no=$_GET['pl_no'];
    $es_id=$_GET['es_id'];

$email=$_SESSION['login_email'];
$client_id=$_SESSION['login_client_id'];
$sql = "SELECT * FROM `tblplot` WHERE `client_id`=? ";
$query = $dbh->prepare($sql);
$query->execute(array($client_id));
$row_chk_bal = $query->rowCount();
$fetch = $query->fetch();


$stmt = $dbh->query("SELECT * FROM tblclient where email='$email'");
$row_client = $stmt->fetch();

//Get property details
$stmt = $dbh->query("SELECT tblplot.*, estate.*,tblplot.ID ,sum(tblplot.balance) as balance FROM tblplot JOIN estate ON tblplot.estate_id=estate.ID where tblplot.client_id='$client_id' and tblplot.plot_no
='$pl_no' and tblplot.estate_id='$es_id'");
$row_prop = $stmt->fetch();
$id=$row_prop['ID'];
$plot_no=$row_prop['plot_no'];



if(isset($_POST["btnpayment"]))
{

$amount = $_POST['txtamt'];

if (($amount) > ($row_prop['balance']) ){

$amount_payable=number_format((float) $amount_payable ,2);

$error='Amount Paid can not be greater than'. ' NGN'.$row_prop['balance'];

}else if(($amount) <= (0)){ 
$error='Invalid Amount';
}else{



//Generate invoice no
function randominvoice() {
    $alphabet = "0123456789";
    $refID = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 6; $i++) {
        $n = rand(0, $alphaLength);
       $refID[] = $alphabet[$n];
    }
    return implode($refID); //turn the array into a string
}
$invoice_no = randominvoice();

//flutterwave payment
$curl = curl_init();
$customer_email = $email;
$amount = filter_var($amount, FILTER_SANITIZE_NUMBER_FLOAT);
$currency = "NGN";
$txref = "rave" . uniqid(); // ensure you generate unique references per transaction.
// get your public key from the dashboard.
$PBFPubKey = "FLWPUBK_TEST-2c7a9c3062c7ef43c062e7c1a0463bd1-X"; 
//$PBFPubKey=$row_website['payment_secretkey'];

$redirect_url = "http://localhost/flexi_Homes/Client/invoice2.php?pd=$amount&ID=$id&inv=$invoice_no&pl=$plot_no"; // Set your own redirect URL

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/hosted/pay",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode([
    'amount'=>$amount,
    'customer_email'=>$customer_email,
    'currency'=>$currency,
    'txref'=>$txref,
    'PBFPubKey'=>$PBFPubKey,
    'redirect_url'=>$redirect_url,
  ]),
  CURLOPT_HTTPHEADER => [
    "content-type: application/json",
    "cache-control: no-cache"
  ],
));

$response = curl_exec($curl);
$err = curl_error($curl);

if($err){
  // there was an error contacting the rave API
  die('Curl returned error: ' . $err);
}

$transaction = json_decode($response);

if(!$transaction->data && !$transaction->data->link){
  // there was an error from the API
  print_r('API returned error: ' . $transaction->message);
}

header('Location: ' . $transaction->data->link);

//$error='Problem Making payment ; This is your First Time Registration this Year. Choose Correct Option ';

}
}
}
  ?>

<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from uxliner.com/adminkit/demo/horizontal/ltr/pages-profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 14 May 2021 19:36:56 GMT -->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Payment Page | <?php echo $row_website['website_name'];   ?></title>
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
<script>

 function convert(Num) { //function to add commas to textboxes
        Num += '';
        Num = Num.replace(',', ''); Num = Num.replace(',', ''); Num = Num.replace(',', '');
        Num = Num.replace(',', ''); Num = Num.replace(',', ''); Num = Num.replace(',', '');
        x = Num.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1))
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        return x1 + x2;
    }

</script>
<style type="text/css">
<!--
.style1 {color: #0033FF}
-->


</style>
<script>
function convert(Num) { //function to add commas to textboxes
        Num += '';
        Num = Num.replace(',', ''); Num = Num.replace(',', ''); Num = Num.replace(',', '');
        Num = Num.replace(',', ''); Num = Num.replace(',', ''); Num = Num.replace(',', '');
        x = Num.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1))
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        return x1 + x2;
    }

</script>
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
          <li class="dropdown user user-menu p-ph-res"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <img src="../Admin/<?php echo $row_client['photo']; ?>" class="user-image" alt="User Image"> <span class="hidden-xs"><?php echo $row_client['firstname']." ". $row_client['lastname']; ?>  </span> </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <div class="pull-left user-img"><img src="../Admin/<?php echo $row_client['photo']; ?> " class="img-responsive img-circle" alt="User"></div>
                <p class="text-left"><?php echo $row_client['firstname']." ". $row_client['lastname']; ?>  <small><?php echo $row_client['email']; ?> </small> </p>
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
      <h1>Payment page</h1>
      <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><i class="fa fa-angle-right"></i> payment page</li>
      </ol>
    </div>
    
    <!-- Main content -->
    <div class="content">
      <div class="row">
        <div class="col-lg-4">
          <div class="card m-b-3">
            <div class="card-body">
              <div class="box-body"> 
			  
                <strong><i class="fa-solid fa-dollar-sign margin-r-5"></i>Outstanding (To be Paid)</strong>
                <p class="text-muted style1">NGN<?php echo number_format((float) $row_prop['balance'] ,2); ?></p>
                <hr>
                <strong><i class="fa fa-number margin-r-5"></i> Plot Number </strong>
                <p class="text-muted"><?php echo $row_prop['plot_no']; ?></p>
                <hr>
                <strong><i class="fa fa-map-mar margin-r-5"></i> Plot Address</strong>
                <p> <?php echo $row_prop['plot_address']; ?></p>
				<strong><i class="fa-solid fa-dollar-sign margin-r-5"></i> Estate</strong>
                <p class="text-muted"><?php echo $row_prop['ename']; ?></p>
                <hr>
				<strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>
                <p> <?php echo $row_prop['address']; ?></p>
				<hr>
                <strong><i class="fa fa-number margin-r-5"></i> House Type </strong>
                <p class="text-muted"><?php echo $row_prop['house_type']; ?></p>
                <hr>
                <strong><i class="fa fa-map- margin-r-5"></i> Purpose</strong>
                <p> <?php echo $row_prop['purpose']; ?></p>
				<strong><i class="fa-solid fa-dollar-sign margin-r-5"></i>Description</strong>
                <p class="text-muted"><?php echo $row_prop['description']; ?></p>
                <hr>
                <strong><i class="fa fa-number margin-r-5"></i>Status </strong>
                <p class="text-muted"><?php echo $row_prop['status']; ?></p>
                <hr>
                
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
               
                <li class="nav-item"></li>
              </ul>
              <p>
              
              <!-- Tab panes -->
         
                <!--second tab-->
              
              
                <?php if($success){?>
              <div class="alert alert-success" role="alert" align="center"> <?php echo ($success); ?></div>
              <?php } 
					else if($error){?>
              <div class="alert alert-danger" role="alert"> <?php echo ($error); ?></div>
              <?php } ?>
              </p>
              <div class="tab-pane" id="settings" role="tabpanel">
                  <div class="card-body">
             <form  action="" method="POST" >

                      <div class="form-group">
                        <label class="col-md-12">Amount</label>
                        <div class="col-md-12">
                          <input name="txtamt" class="form-control form-control-line" type="num" placeholder="" onkeyup = "javascript:this.value=convert(this.value);">
						  
                        </div>
                      </div>
					   
                      <div class="form-group">
                        <div class="col-sm-12">
						<button type="submit" name="btnpayment" class="btn btn-success">PAY NOW</button>

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
   <?php include('../Admin/footer.php'); ?></footer>
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

<link rel="stylesheet" href="popup_style.css">
<?php if(!empty($_SESSION['success'])) {  ?>
<div class="popup popup--icon -success js_success-popup popup--visible">
  <div class="popup__background"></div>
  <div class="popup__content">
    <h3 class="popup__content__title">
      <strong>Success</strong> 
    </h1>
    <p><?php echo $_SESSION['success']; ?></p>
    <p>
      <button class="button button--success" data-for="js_success-popup">Close</button>
    </p>
  </div>
</div>
<?php unset($_SESSION["success"]);  
} ?>
<?php if(!empty($_SESSION['error'])) {  ?>
<div class="popup popup--icon -error js_error-popup popup--visible">
  <div class="popup__background"></div>
  <div class="popup__content">
    <h3 class="popup__content__title">
      <strong>Error</strong> 
    </h1>
    <p><?php echo $_SESSION['error']; ?></p>
    <p>
      <button class="button button--error" data-for="js_error-popup">Close</button>
    </p>
  </div>
</div>
<?php unset($_SESSION["error"]);  } ?>
    <script>
      var addButtonTrigger = function addButtonTrigger(el) {
  el.addEventListener('click', function () {
    var popupEl = document.querySelector('.' + el.dataset.for);
    popupEl.classList.toggle('popup--visible');
  });
};

Array.from(document.querySelectorAll('button[data-for]')).
forEach(addButtonTrigger);
    </script>
</body>

<!-- Mirrored from uxliner.com/adminkit/demo/horizontal/ltr/pages-profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 14 May 2021 19:36:56 GMT -->
</html>
