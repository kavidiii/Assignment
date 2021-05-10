<?php
require_once "config.php";
session_start();

// initializing variables
 
$item_code= "";
$item_category ="";
$item_subcategory = "";
$item_name ="";
$quantity = "";
$unit_price = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'assignment');

// Processing form data when form is submitted 
if (isset($_POST["id"]) && !empty($_POST["id"])) {
  $id = $_POST["id"];
   
  // receive all input values from the form
  $item_code = mysqli_real_escape_string($db, $_POST['item_code']);
  $item_category = mysqli_real_escape_string($db, $_POST['item_category']);
  $item_subcategory = mysqli_real_escape_string($db, $_POST['item_subcategory']);
  $item_name = mysqli_real_escape_string($db, $_POST['item_name']);
  $quantity = mysqli_real_escape_string($db, $_POST['quantity']);
  $unit_price = mysqli_real_escape_string($db, $_POST['unit_price']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($item_code)) { array_push($errors, "Item code is required"); }
  if (empty($item_category)) { array_push($errors, "Item category is required"); }
  if (empty($item_subcategory)) { array_push($errors, "Item subcategory is required"); }
  if (empty($item_name)) { array_push($errors, "Item name is required"); }
  if (empty($quantity)) { array_push($errors, "Quantity is required"); }elseif(!ctype_digit($quantity)){array_push($errors, "Please enter a positive integer value"); }
  if (empty($unit_price)) { array_push($errors, "Unit price is required"); }elseif(!ctype_digit($unit_price)){array_push($errors, "Please enter a positive value"); }
  
  // Finally, update item if there are no errors in the form
  if (count($errors) == 0) {
    $query = "UPDATE item SET item_code=$item_code  ,item_category = SELECT id from item_category where category = '$category',item_subcategory= SELECT id from item_subcategory where sub_category = '$sub_category',item_name=$item_name,quantity=$quantity,unit_pricename=$unit_price WHERE id=$id ";
              
    mysqli_query($db, $query);
   
  header("location: dashboard.php");   }
}else{
  // Check existence of id parameter before processing further
  if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
      // Get URL parameter
      $id =  trim($_GET["id"]);
      
      // Prepare a select statement
      $sql = "SELECT * FROM item WHERE id = ?";
      if($stmt = mysqli_prepare($db, $sql)){
          // Bind variables to the prepared statement as parameters
          mysqli_stmt_bind_param($stmt, "i", $param_id);
          
          // Set parameters
          $param_id = $id;
          
          // Attempt to execute the prepared statement
          if(mysqli_stmt_execute($stmt)){
              $result = mysqli_stmt_get_result($stmt);
  
              if(mysqli_num_rows($result) == 1){
                  /* Fetch result row as an associative array. Since the result set
                  contains only one row, we don't need to use while loop */
                  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                  
                  // Retrieve individual field value
                  $item_code= $row["item_code"] ;
                  $item_category = $row["item_category"];
                  $item_subcategory = $row["item_subcategory"] ;
                  $item_name = $row["item_name"];
                  $quantity =  $row["quantity"];
                  $unit_price = $row["unit_price"];
 
              } else{
                  // URL doesn't contain valid id. Redirect to error page
                  header("location: error.php");
                  exit();
              }
              
          } else{
              echo "Oops! Something went wrong. Please try again later.";
          }
      }
      
      // Close statement
      mysqli_stmt_close($stmt);
      
      // Close connection
      mysqli_close($db);
  }  else{
      // URL doesn't contain id parameter. Redirect to error page
      header("location: error.php");
      exit();
  }
}

?>
 
 <!DOCTYPE html>
<html>
<head>
   
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>UPDATE ITEM DETAILS</h2>
  </div>
	
  <form method="post" action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>">
  <?php include('errors.php'); ?>
  <div class="input-group">
  	  <label>Item code</label>
  	  <input type="text" name="item_code" value="<?php echo $item_code; ?>">
  	</div>
   <div class="input-group">  
   <label>Item category</label>  
   <select name="item_category" id="item_category" value="<?php echo $item_category ; ?>">
   
        <option>Printers</option>
        <option>Laptops</option>
        <option>Gadgets</option>
        <option>Ink bottels</option>
        <option>Cartridges</option>
   </select>
   </div>
   <div class="input-group">  
   <label>Item subcategory</label>  
   <select name="item_subcategory" id="item_subcategory" value="<?php echo $item_subcategory; ?>">
        <option>HP</option>
        <option>Dell</option>
        <option>Lenovo</option>
        <option>Acer</option>
        <option>Samsung</option>
   </select>
   </div>
  	<div class="input-group">
  	  <label>Item name</label>
  	  <input type="text" name="item_name" value="<?php echo $item_name; ?>">
  	</div>
    <div class="input-group">
  	  <label>Quantity</label>
  	  <input type="text" name="quantity" value="<?php echo $quantity; ?>">
  	</div>
    <div class="input-group">
  	  <label>Unit price</label>
  	  <input type="text" name="unit_price" value="<?php echo $unit_price; ?>">
      <input type="hidden" name="id" value="<?php echo $id; ?>"/>
  	</div>
	  <div class="input-group">
  	  <button type="submit" class="btn" name="reg_item">UPDATE</button>
  	</div>
      </form>
</body>
</html>