<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Register</h2>
  </div>
	
  <form method="post" action="register.php">
  	<?php include('errors.php'); ?>
   <div class="input-group">  
   <label>Title</label>  
   <select name="title" id="title">
        <option>Mr</option>
        <option>Mrs</option>
        <option>Miss</option>
        <option>Dr</option>
   </select>
   </div>
  	<div class="input-group">
  	  <label>First Name</label>
  	  <input type="text" name="first_name" value="<?php echo $first_name; ?>">
  	</div>
    <div class="input-group">
  	  <label>Middle Name</label>
  	  <input type="text" name="middle_name" value="<?php echo $middle_name; ?>">
  	</div>
    <div class="input-group">
  	  <label>Last Name</label>
  	  <input type="text" name="last_name" value="<?php echo $last_name; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Contact NO</label>
  	  <input type="text" name="contact_no" value="<?php echo $contact_no; ?>">
  	</div>
  	<div class="input-group">
  	  <label>District</label>
  	  <input type="text" name="district" value="<?php echo $district; ?>">
  	</div>
	  <div class="input-group">
  	  <button type="submit" class="btn" name="reg_user">Register</button>
  	</div>
  	<p>
  		Already a member? <a href="login.php">Sign in</a>
  	</p>
  </form>
</body>
</html>