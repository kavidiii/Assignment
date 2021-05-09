<?php 
  session_start(); 

  if (!isset($_SESSION['first_name'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['first_name']);
  	header("location: login.php");
  }
?>
 <!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="header">
		<h2>Home Page</h2>
	</div>
	<div class="content">
		 
		<!-- logged in user information -->
		<div class="profile_info">
			<img src="images/user_pro.png"  >

			<div>
				 
            <strong><?php echo $_SESSION['user']['first']; ?></strong> 

					<small>
						<i  style="color: #888;">( Customer )</i> 
						<br>
						<a href="index.php?logout='1'" style="color: red;">logout</a>
					</small>

				 
			</div>
		</div>

	</div>
    <div class>
    <?php
       include "items.php";
    ?>
    </div>
     
</body>
</html>