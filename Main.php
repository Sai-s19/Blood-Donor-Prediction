<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial, Helvetica, sans-serif;}


input[type=text], input[type=password] {
    width: 10%;
    padding: 12px 16px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

button {
    background-color: maroon;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 10%;
}

button:hover {
    opacity: 0.8;
}

.imgcontainer {
    text-align: center;
    margin: 24px 0 12px 0;
}

img.avatar {
    width: 10%;
    border-radius: 10%;
}

.container {
    text-align: center;
    padding: 16px;
}


</style>
</head>
<body>
<?php

     $servername = "localhost";
     $username = "sye19";
     $password = "password";
     $dbname = "admin";

     // Create connection
     $conn = new mysqli($servername, $username, $password,$dbname);
      
     // Check connection
     if ($conn->connect_error) {
           die("Connection failed: " . $conn->connect_error);
     } 
      $uname = $_POST['uname'];
      $pswd = $_POST['psw'];
   
      $sql = "SELECT * FROM logins WHERE name = '$uname' AND pswd = '$pswd'";

      $result = $conn->query($sql);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
		
      if($result->num_rows == 1){ 
         header("Location: home.html");
      }else {
         echo "Your Login Name or Password is invalid";	
      }
   
?>
<h2>Admin Login</h2>

<form action="" method="POST">
  <div class="imgcontainer">
    <img src="img_avatar2.png" alt="Avatar" class="avatar">
  </div>

  <div class="container">
    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="uname" required><br />

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required><br />
        
    <button type="submit" value="Submit">Login</button><br />
  </div>

</form>

</body>
</html>

