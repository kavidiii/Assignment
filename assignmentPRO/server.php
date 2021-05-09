<?php
session_start();

// initializing variables
$title = "";
$first_name = "";
$middle_name    = "";
$last_name = "";
$contact_no ="";
$district = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'assignment');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $title = mysqli_real_escape_string($db, $_POST['title']);
  $first_name = mysqli_real_escape_string($db, $_POST['first_name']);
  $middle_name = mysqli_real_escape_string($db, $_POST['middle_name']);
  $last_name = mysqli_real_escape_string($db, $_POST['last_name']);
  $contact_no = mysqli_real_escape_string($db, $_POST['contact_no']);
  $district = mysqli_real_escape_string($db, $_POST['district']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($title)) { array_push($errors, "Title is required"); }
  if (empty($first_name)) { array_push($errors, "First name is required"); }
  if (empty($middle_name)) { array_push($errors, "Middle Name is required"); }
  if (empty($last_name)) { array_push($errors, "Last Name is required"); }
  if (empty($contact_no)) { array_push($errors, "Contact NO is required"); }
  if (empty($district)) { array_push($errors, "District is required"); }
  

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM customer WHERE first_name='$first_name' OR middle_name='$middle_name' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['first_name'] === $first_name) {
      array_push($errors, "First Name already exists");
    }

    if ($user['middle_name'] === $middle_name) {
      array_push($errors, "Middle Name already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$query = "INSERT INTO customer (title,first_name,middle_name,last_name,contact_no,district) 
  			  VALUES('$title', '$first_name', '$middle_name','$last_name', '$contact_no',(SELECT id from district where district = '$district'))";
  	mysqli_query($db, $query);
    $_SESSION['user']=array(
      'first'=>$first_name ,
      'middle'=>$middle_name
      );
  	$_SESSION['first_name'] = $first_name;
  	$_SESSION['success'] = "You are now logged in";
    if ( $first_name == 'admin'|| $first_name == 'Admin') {header("location: dashboard.php");die();  }else{header("location: index.php");die();  }
  }
}

if (isset($_POST['login_user'])) {
    $first_name = mysqli_real_escape_string($db, $_POST['first_name']);
    $middle_name = mysqli_real_escape_string($db, $_POST['middle_name']);
  
    if (empty($first_name)) {
        array_push($errors, "First Name is required");
    }
    if (empty($middle_name)) {
        array_push($errors, "Middle name is required");
    }
  
    if (count($errors) == 0) {
         
        $query = "SELECT * FROM customer WHERE first_name='$first_name' AND middle_name='$middle_name'";
        $results = mysqli_query($db, $query);
        $row= mysqli_fetch_assoc($results);
        $count=mysqli_num_rows($results);
         
        if ($count == 1) { // user found
          // check if user is admin or user
          $_SESSION['user']=array(
            'first'=>$row['first_name'],
            'middle'=>$row['middle_name']
            );
            $role=$_SESSION['user']['first']; 
            $_SESSION['first_name'] = $first_name; 
          $logged_in_user = mysqli_fetch_assoc($results);
          if (  $role == 'admin'|| $role == 'Admin') {
            header('location: dashboard.php');
            die();   
            
          }else{
            header('location: index.php');
            die();   
            
           
          }
        }else {
          array_push($errors, "Wrong username/password combination");
        }
    }
  }
  
  ?>