<?php
/* Local Database*/
$servername_db = "localhost";
$username_db = "root";
$password_db = "";
$dbname_db = "siwes";

//$servername_db = "localhost";
//$username_db = "cpisuppo_root";
//$password_db = "isupport123456789";
//$dbname_db = "cpisuppo_isupport";


// Create connection
$conn = mysqli_connect($servername_db, $username_db, $password_db, $dbname_db);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


?> 