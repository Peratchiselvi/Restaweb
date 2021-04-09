<!DOCTYPE html> 
<html lang="en">
    <head>
        <title>Restaurant</title>
        <link rel="stylesheet" href="reserve.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style> 
    body{
        color: black;
    background: linear-gradient( rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4) ), url("menuback.jpg");
    }
    .sticky + .myreserve{
    padding-top: 60px;
  }
    .myreserve{
        background: none;
        margin-top: 20px;
        margin-bottom: 20px;
        width: 100%;
    }
        table { 
            margin: auto; 
            width: 50%;
            font-size: large; 
            color: grey;
            background-color: white;
            border-spacing: 0px;
        }
  
        h1 { 
            text-align: center; 
            color: #006600;
            font-size: xx-large; 
            font-family: 'Gill Sans', 'Gill Sans MT',  
            ' Calibri', 'Trebuchet MS', 'sans-serif'; 
        } 
  
        th, 
        td { 
            font-weight: bold;
            border: 1px solid rgba(192,192,192,0.3); 
            padding: 10px; 
            text-align: center; 
        } 
  
        td { 
            font-weight: lighter; 
        } 
        th{
            background-color: rgba(36, 36, 36, 0.9);
            color: white;
        }
    </style> 
</head> 
  
<body>
<div class = "navbar" id="navbar">
    <a href = "main.html" class="home">Home</a>
    <div class="navright">
    <a href = "menu.html" class="navabout">Menus</a>
    <a href = "reserve.html">Reservation</a>
    <a href = "myreservation.php">My Reservations</a>
    <a href="javascript:void(0);" class="icon" onclick="menu()">
        <i class="fa fa-bars"></i>
    </a></div>
</div>
<?php
$servername = "localhost";
$username = "root";
$password = '';
$dbname = "restareserve";

session_start(); 
$name_myreserve = $_SESSION["user"]; 
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM reservation where Username='$name_myreserve'";
$result = $conn->query($sql);
if (!$result) {
    trigger_error('Invalid query: ' . $conn->error);
}

if ($result->num_rows > 0) {?>
    <div class="myreserve">
<h1>Reservation Details</h1>  <table> 
            <tr> 
                <th>Tables</th>
                <th>Date</th> 
                <th>Time</th> 
                <th>Ordered Food</th> 
            </tr> 
            <tr>
            <?php
    while($row = $result->fetch_assoc()) {
        ?> 
        <td><?php echo $row['Tables'];?></td>
                <td><?php echo $row['Date'];?></td> 
                <td><?php echo $row['Time'];?></td> 
                <td><?php echo $row['Menu'];?></td> 
            </tr> </table>
 <?php
    }}
    else{
     ?> <h4 style="text-align: center; margin-top:35px;">You didn't reserve anything yet!</h4>
      <h2 style="text-align: center;">Can't Wait?<a href="reserve.html">Reserve Here</a></h2>
   <?php }

?>
</div> 
<script> 
  var navbar = document.getElementById("navbar");
  var sticky = navbar.offsetTop;
  if (window.matchMedia("(min-width: 600px)").matches){
  window.onscroll = function() {myFunction()}; }
function menu() {
  var x = document.getElementById("navbar");
  if (x.className === "navbar") {
    x.className += " responsive";
  } else {
    x.className = "navbar";
  }
}
  
  function myFunction() {
    if (window.pageYOffset >= sticky) {
      navbar.classList.add("sticky");
    } else {
      navbar.classList.remove("sticky");
    }
  }
  </script>
</body> 
  
</html> 