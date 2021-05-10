<?php 
include "config.php";
?>

<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/w3css/3/w3.css">
<style type"text/css">
#outer{
	width:940px;
	margin:auto;
	min-height:600px;
	border:1px solid #000;	
	position:relative;
	z-index:2;
}
#ad-container{
	width:940px;
	margin:auto;
	position:fixed;
	top:20px;
	left:0;
	right:0;	
}
.ad-left{
	float:left;
	width:160px;
	height:600px;
	background:red;
	margin-left:-170px;
}
.ad-right{
	float:right;
	width:160px;
	height:600px;
	background:red;
	margin-right:-170px;
}
.container {
  position: relative;
  width: 100%;
}
/* Make the image responsive */
.container img {
  width: 100%;
  height: auto;
}
/* Style the button and place it in the middle of the container/image */
.container .btn {
  position: absolute;
  top: 50%;
  left: 25%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  background-color:  #ffff66;
  color: black;
  font-size: 18px;
  padding: 12px 24px;
  border: none;
  cursor: pointer;
  border-radius: 5px;
}
.container .btn:hover {
  background-color: pink;
}
</style>
</head>

<body>
<div id="outer">
<body>
<div class="container">
  <img  src="images/it.jpg" alt="Snow"
  style="width:100%">
  <h1><b><span style="color:#FF0000;text-align:center;">Invoice report</h1></span</b>       
   
</div> 

<div id="container"></div>
</body>
  
<script src="https://code.highcharts.com/highcharts.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">
   <!-- Script -->
   <script src='jquery-3.3.1.js' type='text/javascript'></script>
   <script src='jquery-ui.min.js' type='text/javascript'></script>
   <script type='text/javascript'>
   $(document).ready(function(){
     $('.dateFilter').datepicker({
        dateFormat: "yy-mm-dd"
     });
   });
   </script>
   
   <!-- Search filter -->
   <form method='post' action=''>
     Start Date <input type='text' class='dateFilter' name='fromDate' value='<?php if(isset($_POST['fromDate'])) echo $_POST['fromDate']; ?>'>
 <br>
     End Date <input type='text' class='dateFilter' name='endDate' value='<?php if(isset($_POST['endDate'])) echo $_POST['endDate']; ?>'>

     <input type='submit' name='but_search' value='Search'>
   </form>
 
   <!-- Employees List -->
   <div style='height: 80%; overflow: auto;' >
   
     <table border='1' width='100%' style='border-collapse: collapse;margin-top: 20px;'>
       <tr>
         <th>Invoice No</th>
         <th>Date</th>
         <th>Customer</th>
         <th>District</th>
         <th>item_count</th>
         <th>Amount</th>
       </tr>

       <?php
       $emp_query = "SELECT * FROM invoice WHERE 1 ";

       // Date filter
       if(isset($_POST['but_search'])){
          $fromDate = $_POST['fromDate'];
          $endDate = $_POST['endDate'];

          if(!empty($fromDate) && !empty($endDate)){
             $emp_query .= " and date 
                          between '".$fromDate."' and '".$endDate."' ";
          }
        }

        // Sort
        $emp_query .= " ORDER BY date DESC";
        $employeesRecords = mysqli_query($link,$emp_query);

        // Check records found or not
        if(mysqli_num_rows($employeesRecords) > 0){
          while($empRecord = mysqli_fetch_assoc($employeesRecords)){
            $invoice_no= $empRecord['invoice_no'];
            $date = $empRecord['date'];
            $customer = $empRecord['customer'];
             
            $result = mysqli_query($link,"SELECT first_name,middle_name FROM customer WHERE id =$customer");
            $numcus = mysqli_fetch_assoc($result);
             
            $Disresult = mysqli_query($link,"SELECT  district  FROM district  WHERE id =$customer ");
            $Cusdis = mysqli_fetch_assoc($Disresult); 
            
            $item_count = $empRecord['item_count'];
            $amount = $empRecord['amount'];

            echo "<tr>";
            echo "<td>". $invoice_no ."</td>";
            echo "<td>". $date ."</td>";
            echo "<td>". $numcus['first_name']  ." ". $numcus['middle_name']."</td>";
             echo "<td>".$Cusdis['district'] ."</td>";
            echo "<td>". $item_count ."</td>";
            echo "<td>". $amount ."</td>";
            echo "</tr>";
          }
        }else{
          echo "<tr>";
          echo "<td colspan='4'>No record found.</td>";
          echo "</tr>";
        }
        ?>
      </table>
      
    </div>
</div>
<div id="ad-container">
		<div class="ad-left"> </div>
		<div class="ad-right"> </div>
</div>



 
</body>
</html>







 