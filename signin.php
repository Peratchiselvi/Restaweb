<html>
    <head>
        <title>Restaurant</title>
        <link rel="stylesheet" href="reserve.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <!--
<script>
function popup(){
    alert("You signed in!");
}
</script>-->
<body>
<div class="signin">
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
    <div class="row"><div class="title">User Name</div><div class="input"><input type="text" name="name" required></div></div>
    <div class="row"><div class="title">Contact Number</div><div class="input"><input type="tel" name="no" required></div></div>
    <div class="row"><div class="title">Mail Id</div><div class="input"><input type="email" name="mail"  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required></div></div>
    <div class="row"><div class="title" style="align-items: flex-start;">Password</div><div class="input"><input type="password" pattern="(?=.*[A-Z]).{8,}" min="8" name="password" placeholder="Atleat 8 characters with one uppercaseletter" required></div></div>
    <!--<p style="opacity: 0.4; width: 75%; margin: auto; font-weight: 100; font-size: 15px; font-family: sanserif;">Password </p>-->
    <div class="row"><input type="submit" name="Submit" value="Sign In" id="signin_button"></div>
     <!--
        <div class="formrow"><div class="title"><label>User Name</label></div><div class="field"><input type="text" name="name" required></div></div>
        <div class="formrow"><div class="title"><label>Contact Number</label></div><div class="field"><input type="tel" name="no"></div></div>
        <div class="formrow"><div class="title"><label>Mail Id</label></div><div class="field"><input type="email" name="mail"></div></div>
        <div class="formrow"><div class="title"><label>Password</label></div><div class="field"><input type="password" name="password" required></div></div>
        <div class="formrow"><input type="submit" name="Submit" onclick="popup()"></div>-->
    </form>    
</div><?php
$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "restaweb";
//create connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
if(mysqli_connect_error()){
 die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
} 
else {     
    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $name = test_input($_POST["name"]);
      $no = test_input($_POST["no"]);
      $mail = test_input($_POST["mail"]);
      $password = test_input($_POST["password"]); 
      $salt =  "restaweb"; 
    $hashed_pass = sha1($password.$salt);
    $INSERT = "INSERT Into signin(Username, ContactNo, MailId, Password) values(?, ?, ?,?)";
    $sql = "SELECT * From signin Where Username = '".$name."'";    
    $result = mysqli_query($conn, $sql);  
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
    $count = mysqli_num_rows($result);  
    $sql1 = "SELECT * From signin Where Mailid = '$mail'";    
    $result1 = mysqli_query($conn, $sql1);  
    $row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);  
    $count1 = mysqli_num_rows($result1);  
         
    if($count == 0 && $count1 == 0){              
     $stmt = $conn->prepare($INSERT);
     $stmt->bind_param("ssss", $name, $no, $mail, $hashed_pass);
     $stmt->execute(); 
     session_start();  
     $_SESSION["user"] = $name;   
     echo '<script type="text/javascript">
     
     window.onload = function () { alert("Signed in successfully"); }
     
     </script>'; 
     header("Location: main.html");
     } 
     elseif($count != 0 && $count1 != 0){
         echo '<script type="text/javascript">
         
         window.onload = function () { alert("Someone already sign in using this Username and Mailid"); }
         
         </script>';
     }
     elseif($count != 0){    
        echo '<script type="text/javascript">
        
        window.onload = function () { alert("Someone already sign in using this Username"); }
        
        </script>';   
    }
    else{
        echo '<script type="text/javascript">
        
        window.onload = function () { alert("Someone already sign in using this Mailid"); }
        
        </script>';    
    }
}}

?>
</body></html>