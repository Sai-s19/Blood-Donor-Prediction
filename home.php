<!DOCTYPE html>

<html>
<head> <meta charset="utf-8">

  <link rel="stylesheet" type="text/css" href="mystyle.css">
  <title>Blood Bank</title>

</head>

<body>

<div class="slideshow-container">

<div class="mySlides fade">
  <div class="numbertext">1 / 3</div>
  <img src="img1.jpg" style="height:200px">
  <div class="text">Caption Text</div>
</div>

<div class="mySlides fade">
  <div class="numbertext">2 / 3</div>
  <img src="img2.jpg" style="height:200px">
  <div class="text">Caption Two</div>
</div>

<div class="mySlides fade">
  <div class="numbertext">3 / 3</div>
  <img src="img3.jpg" style="height:200px">
  <div class="text">Caption Three</div>
</div>

</div>
<br>

<div style="text-align:center">
  <span class="dot"></span> 
  <span class="dot"></span> 
  <span class="dot"></span> 
</div>

<script>
var slideIndex = 0;
showSlides();
function showSlides() {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("dot");
    for (i = 0; i < slides.length; i++) {
       slides[i].style.display = "none";  
    }
    slideIndex++;
    if (slideIndex > slides.length) {slideIndex = 1}    
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";  
    dots[slideIndex-1].className += " active";
    setTimeout(showSlides, 2000); // Change image every 2 seconds
}
</script> 
</div>

<div>
    <div>
      <ul>
        <li><a class="active" href='home.html'>Home</a></li>
        <li><a href='hospitals.html'>Hospitals</a></li>
        <li><a href='news.html'>News And Events</a></li>
        <li><a href='contact.html'>Contact us</a></li>
      </ul>
    </div><br /><br />
</div>
<div style="border-radius: 5px; border-width: 10px; background-color: #f2f2f2; padding: 10px;">

<table style="width:100% ;">
  
  <tr>
    <th>Name</th>
    <th>Age</th> 
    <th>Gender</th>
    <th>Blood Group</th>
    <th>Email</th>
    <th>Contact No.</th>
    <th>City</th>
  </tr>
  
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
   

     //be sure to validate and clean your variables
     $City = $_POST['City'];
     $Blood = $_POST['Blood_Group'];

     $sql = "SELECT * FROM Details WHERE City = '$City' AND Blood_Group = '$Blood' AND CLASS = 1";
     $result = $conn->query($sql);

     if ($result->num_rows > 0) {
          while ($rows = $result->fetch_assoc()) {
    
              echo "<tr><td>". $rows['Name'] ."</td><td>". $rows['Age'] ."</td><td>". $rows['Gender'] ."</td><td>". $rows['Blood_Group'] ."</td><td>". $rows['Email'] ."</td><td>". $rows['Contact_No'] ."</td><td>". $rows['City'] ."</td></tr>";
          }
     }
     
     else{
	  echo "<tr><td> No Match Found!!! </td></tr>";
     }
     $conn->close();
  ?>
   
</table>

</div>

</body>

</html>
