<?php
include 'topbar.php';
error_reporting(0);
include '../Admin/connect.php';

// Get the  id
$refplotno = $_REQUEST['refplotno'];
$refestate = $_REQUEST['refestate'];

if ($refplotno !== "") {
	
	// Get corresponding first name and
	// last name for that user id	
	$query = mysqli_query($conn, "SELECT * FROM tblplot WHERE plot_no='$refplotno' and estate_id='$refestate'");
	$row = mysqli_fetch_array($query);
	$total_payable = $row["total_payable"];
	$status = $row["status"];
		
	$_SESSION['refplotno']=$refplotno;	
	$_SESSION['refestate']=$refestate;	

}
// Store it in a array
$result = array("$total_payable", "$status");

// Send in JSON encoded form
$myJSON = json_encode($result);
echo $myJSON;
?>
