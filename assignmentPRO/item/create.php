<?php

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

// ADD Item
if (isset($_POST['reg_item'])) {
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
  
  // Finally, add item if there are no errors in the form
  if (count($errors) == 0) {
    $query = "INSERT INTO item (item_code,item_category,item_subcategory,item_name,quantity,unit_price) 
              VALUES('$item_code',(SELECT id from item_category where category = '$item_category'),(SELECT id from item_subcategory where sub_category = '$item_subcategory') ,'$item_name', '$quantity','$unit_price')";
    mysqli_query($db, $query);
   
  header("location: index.php");   }
}
?>
 
 <!DOCTYPE html>
<html>
<head>
   
  <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
  <div class="header">
  	<h2>ADD NEW ITEM</h2>
  </div>
	
  <form method="post" action="item/create.php">
  <?php include('../errors.php'); ?>
  <div class="input-group">
  	  <label>Item code</label>
  	  <input type="text" name="item_code" value="<?php echo $item_code; ?>">
  	</div>
   <div class="input-group">  
   <label>Item category</label>  
   <select name="item_category" id="item_category">
        <option>Printers</option>
        <option>Laptops</option>
        <option>Gadgets</option>
        <option>Ink bottels</option>
        <option>Cartridges</option>
   </select>
   </div>
   <div class="input-group">  
   <label>Item subcategory</label>  
   <select name="item_subcategory" id="item_subcategory">
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
  	</div>
	  <div class="input-group">
  	  <button type="submit" class="btn" name="reg_item">ADD</button>
  	</div>
      </form>
</body>
</html>