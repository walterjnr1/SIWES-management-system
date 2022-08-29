<?php  include 'topbar.php'; ?>
<?php
							//Get IP Address
function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
$ip_address = get_client_ip()

?>
<?php  


$email=$_SESSION['login_email'];
$sql = "UPDATE tblclient SET last_login=?,last_ip=? where email=?";
$stmt= $dbh->prepare($sql);
$stmt->execute([$current_date,$ip_address, $email]);

//Add Activity Log
$task= $fullname.' '.'logged Out'.' '. 'On' . ' '.$current_date;
$sql = 'INSERT INTO activity_log(task) VALUES(:task)';
$statement = $dbh->prepare($sql);
$statement->execute([
	':task' => $task
]);
session_destroy(); //destroy the session
?>

<script>
window.location="../index.php";
</script>
<?php
//to redirect back to "index.php" after logging out
  exit;
?>