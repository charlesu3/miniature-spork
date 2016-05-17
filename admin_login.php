<?php
session_start();

  include "db.inc.php";

//Connect and check connection to the database
  $conn=mysqli_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PASSWORD,MYSQL_DB);
  if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}
//echo "Successfully Connected";

//filter incomming values
$username = (isset($_POST['username']))? trim($_POST['username']) : '';
$password = (isset($_POST['password'])) ? $_POST['password'] : '';
$redirect = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] :
 'primary.php';


 
 
 
 If (isset($_POST['submit'])){


$query = 'SELECT  username FROM admin WHERE '  .
       'username ="' . mysqli_real_escape_string($conn,$username) . '" AND ' .
       'password = PASSWORD( "' . mysqli_real_escape_string($conn,$password) . '")';

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    
	//$row = mysqli_fetch_assoc($result);
    $_SESSION['username'] = $username;
    $_SESSION['logged'] = 1;
    header('Refresh: 5;URL=' . $redirect);
    echo'<p>You will be redirected to your original page request.</p>';
    echo'<p>If your browser doen\'t redirect you automatically.' .
      '<a href="' .$redirect . '">click here</a>.</p>';
    mysqli_free_result($result);
    mysqli_close($conn);
    die();
 } else {
   // set explicitly just to make sure
   $_SESSION['username']= '';
   $_SESSION['logged'] = 0;		
   
   $error = '<p><strong>You have supplied invalid login details</strong></p>';
 }
 mysqli_free_result($result);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <!--
      Reference: JavaScript 6th Edition
      Case: TAMS KPI Weekly Monitor
      Author: Charles Ulrich
      Date:  2015/12/12
      Filename: admin_login.php
   -->
   <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width,initial-scale=1.0">
   <title>TAMS KPI Weekly Monitor: Admin Login</title>
   <link rel="stylesheet" media="screen and (max-device-width: 999px)" href="adminstyleshh.css" />
   <link rel="stylesheet" media="screen and (min-device-width: 1000px)" href="adminstyles.css" />
   <script src="modernizr.custom.65897.js"></script>
</head>
 <body>
 
 <div id="container">
      <header>
         <h1>
            <img src="images/park.png" width="319" height="118" alt="person fishing next to a rock pile" title="" />
            <span>TAMS KPI Weekly Monitor</span>
         </h1>
      </header>
   
      <nav>
         <ul>
            <li><a href="index.php">Home</a></li>
            <li class="currentPage"><a href="#">Login</a></li>
            <li><a href="admin_register.php">Register</a></li>
            <li><a href="admin_list.php">List</a></li> 
          </ul>
      </nav>
   </div>
<article>
  
  <h2>Administrators</h2>
  <h3>Login Here</h3>
 <?php 
 if (isset($error)){
 echo $error;
 }
 ?>
 
 <form action="admin_login.php" method="post">
         <fieldset class="text">
           
			<label for="uname">Username</label>
            <input type="text" name="username" id="uname"  required="required" value="<?php echo $username;?>"/>
            <p id="usernameError" class="errorMsg"></p>
            <label for="pw1">Password</label>
            <input type="password" name="password" id="pw1" required="required" value="<?php echo $password;?>"/>
            <input type="hidden" name="redirect" value="<?php echo $redirect ?>"/>
         </fieldset>
   
         <p><input type="submit" name="submit" value="login"/></p>
        </form>
      
   
    
   
   </article>
   <footer>
  <p>TAMS KPI Weekly Monitor &bull;  Bigsky Revelations </p>
  
  </footer>
  <!--  <script src="loginfiles.js"></script> -->
</body>
</html>
<?php mysqli_close($conn);
?>

