<?php
//Database Configuration
$servername ="localhost";
$username = "cs4500";
$password = "24Indianatech-";
$dbname = "CourseRegistration";

session_start();

$conn = mysqli_connect($servername,$username,$password,$dbname);

//Check for connection
if($conn -> connect_error){
    die("Connection failed");
    echo "Connection Failed";
}

?>

