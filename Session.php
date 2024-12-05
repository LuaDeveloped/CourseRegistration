<?php
// PHP runs on the server
$servername ="localhost";
$username = "cs4500";
$password = "24Indianatech-";
$dbname = "CourseRegistration";

//Test for connectivity
$conn = new mysqli($username,$password);
if($conn -> connect_error){
    die("Connection failed");
}
else {
    echo "Connected success";
}

// Generate the frontend HTML
echo "<!DOCTYPE html>";
echo "<html>";
echo "<head><title>LOGIN</title></head>";
echo "<body>";
echo "<h1>New Test<h1>";
echo "<h1>USERNAME: </h1>";
echo "<h1>PASSWORD: </h1>";
echo "</body>";
echo "</html>";
?>
