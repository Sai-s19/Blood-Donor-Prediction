<?php
   define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'sye19');
   define('DB_PASSWORD', 'password');
   define('DB_DATABASE', 'admin');
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
   } 
?>
