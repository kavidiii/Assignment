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
     
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
     
</head>
<body>
	<div class="header">
		<h2>Admin Dashboard</h2>
	</div>
	<div class="content">
		 
		<!-- logged in user information -->
		<div class="profile_info">
			<img src="images/user_pro.png"  >

			<div>
				 
					<strong><?php echo $_SESSION['user']['first']; ?></strong>

					<small>
						<i  style="color: #888;">( System Admin )</i> 
						<br>
						<a href="index.php?logout='1'" style="color: red;">logout</a>
                        <br>
                        <br>
					</small>
                    <a href="search.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i>Search Invoice report</a>
				 
			</div>
		</div>
	</div>
    <div class>
    <?php
       include "item/index.php";
    ?>
    </div>
    <div class="content">
    <h4> Register User List </h4>
    <?php 
$mysqli = mysqli_connect("localhost", 'root', '', 'assignment'); 
$query = "SELECT * FROM customer";

echo '<table  id=\"my_table\" border=1"; > 
      <tr> 
          <td> <font face="Arial">ID</font> </td> 
          <td> <font face="Arial">Title</font> </td> 
          <td> <font face="Arial">First Name</font> </td> 
          <td> <font face="Arial">Middle Name</font> </td> 
          <td> <font face="Arial">Last Name</font> </td> 
		  <td> <font face="Arial">Contact NO</font> </td> 
          <td> <font face="Arial">District</font> </td> 
          <td> <font face="Arial">Delete User</font> </td> 
           
      </tr>';

if ($result = $mysqli->query($query)) {
    while ($row = $result->fetch_assoc()) {
        $field1name = $row["id"];
        $field2name = $row["title"];
        $field3name = $row["first_name"];
        $field4name = $row["middle_name"];
        $field5name = $row["last_name"]; 
		$field6name = $row["contact_no"]; 
		$field7name = $row["district"]; 
         
        echo '<tr> 
                  <td>'.$field1name.'</td> 
                  <td>'.$field2name.'</td> 
                  <td>'.$field3name.'</td> 
                  <td>'.$field4name.'</td> 
                  <td>'.$field5name.'</td> 
				  <td>'.$field6name.'</td> 
                  <td>'.$field7name.'</td> 
                  <td><a href="deleteCustomer.php?id='. $row['id'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a> </td>
                   
              </tr>';
    }
    $result->free();
}  
?>
</div>

 
</body>
</html>
 