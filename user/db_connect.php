<?php
// db_connect.php

$host = "localhost";      // usually localhost for XAMPP
$user = "root";           // default MySQL username
$pass = "";               // default password for XAMPP is empty
$dbname = "flower_db";   // database name

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    //die("Database Connection Failed: " . $conn->connect_error);
    
}
//check connection
/*if($conn)
{
    echo "connection done";
}
else{
    echo"error";
}*/

// echo "Database connected successfully!";
?>



