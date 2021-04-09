<html>
    <head>
        <title>Restaurant</title>
        <link rel="stylesheet" href="reserve.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <!--
<script>
function popup(){
    alert("You signed in!");
}
</script>-->
<body>
<div class="login">
<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
    <div class="row"><div class="title">User Name</div><div class="input"><input type="text" name="name" required></div></div>
    <div class="row"><div class="title">Password</div><div class="input"><input type="password" name="password" required></div></div>
    <div class="row"><input type="submit" name="Submit" value="Login here"></div><br>
     <br>
        <hr style="opacity: 0.2;width: 75%; text-align: center;">
        <p style="text-align: center;">Not have an account? <a href="signin.php" onclick="sign()">Sign in</a></p>
</form>
</div><?php   
$host = "localhost";  
$user = "root";  
$password = '';  
$db_name = "restaweb";  
  
$con = mysqli_connect($host, $user, $password, $db_name);  
if(mysqli_connect_errno()) {  
    die("Failed to connect with MySQL: ". mysqli_connect_error());  
}      
else{ 
    session_start();    
    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = test_input($_POST["name"]);
        $password = test_input($_POST["password"]); 
        $_SESSION["user"] = $name;  
        $salt =  "restaweb"; 
      $hashed_password = sha1($password.$salt);
      /*
    //to prevent from mysqli injection  
    $name = stripcslashes($name);  
    $password = stripcslashes($password);  
    $name = mysqli_real_escape_string($con, $name);  
    $password = mysqli_real_escape_string($con, $password);  */
  
    $sql = "select * from signin where Username = '".$name."' and Password = '".$hashed_password."'";  
    $result = mysqli_query($con, $sql);  
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
    $count = mysqli_num_rows($result);  
      
    if($count == 1){       
        header("Location: main.html");
    }  
    else{ 
         echo '<script type="text/javascript">

        window.onload = function () { alert("Invalid username or password!"); }
        
        </script>';
    } }
}    
?> </body></html>