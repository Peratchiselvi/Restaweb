<?php       
$host = "localhost";  
$user = "root";  
$password = '';  
$db_name = "restareserve";
session_start();   
  
$conn = mysqli_connect($host, $user, $password, $db_name);  
if(mysqli_connect_errno()) {  
    die("Failed to connect with MySQL: ". mysqli_connect_error());  
}
    
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = test_input($_SESSION["user"]);
  $persons = test_input($_POST["persons"]);
  $date = test_input($_POST["date"]);
  $time = test_input($_POST["time"]); 
  $checkbox1 = $_POST["item"];
  $tables = intval(intval($persons)/4);  
  $exact_tables = intval($persons)%4;
  if($exact_tables != 0){
      $tables = $tables + 1;
  }
  /*
    //to prevent from mysqli injection  
    $username = stripcslashes($username);  
    $password = stripcslashes($password);  
    $username = mysqli_real_escape_string($con, $username);  
    $password = mysqli_real_escape_string($con, $password);  */     
    $sql = "select * from reservation where Date='$date' and Time='$time'";  
    $result = mysqli_query($conn, $sql); 
    $booked_tables = 0; 
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $booked_tables += $row["Tables"];
    } 
    $checking_tables = $booked_tables + $tables; 
    if($checking_tables <= 4){  
      $chk="";  
      $i=0;
      $arrlen = count($checkbox1);
      foreach($checkbox1 as $chk1)  
         {  
            $chk .= $chk1;  
            $i += 1;
            if($i < $arrlen){
            $chk .= ',';
            }
         }  
         $INSERT = "INSERT Into reservation(Tables, Date, Time, Menu) values(?, ?, ?, ?)";  
        $stmt = $conn->prepare($INSERT); 
        $stmt->bind_param("ssss",$tables, $date, $time, $chk);
        $stmt->execute();    
  echo '{"success":true}'; 
    }/* ?>
<script src="reserve.js"></script>
<?php
if(isset($_SESSION['success'] && $_SESSION['success'] != '')){?>
<script>swal({
  title: "Good job!",
  text: "You clicked the button!",
  icon: "success",
  button: "Aww yiss!",
});</script>
<?php*/
    }  

?> 