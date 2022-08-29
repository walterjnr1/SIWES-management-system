<?php 
error_reporting(0);
include 'header2.php';

$id= $_GET['rid'];        

date_default_timezone_set('Africa/Lagos');
$current_date = date('Y-m-d H:i:s');

$sql = "DELETE FROM tblstudent WHERE reg_num=?";
$stmt= $dbh->prepare($sql);
$stmt->execute([$id]);

//save activity log details
$task= $fullname.' '.'Deleted User'.' '. 'On' . ' '.$current_date;
$sql = 'INSERT INTO activity_log(task) VALUES(:task)';
$statement = $dbh->prepare($sql);
$statement->execute([
	':task' => $task
]);

header("Location: student-record.php"); 
 ?>