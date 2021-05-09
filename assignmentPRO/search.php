<?php 
include "config.php";
?>
<!doctype html>
<html>
<head>

</head>
 <body >
   <!-- CSS -->
   
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
   <div class="content">
   <!-- Search filter -->
   <form method='post' action=''>
     Start Date <input type='text' class='dateFilter' name='fromDate' value='<?php if(isset($_POST['fromDate'])) echo $_POST['fromDate']; ?>'>
 
     End Date <input type='text' class='dateFilter' name='endDate' value='<?php if(isset($_POST['endDate'])) echo $_POST['endDate']; ?>'>

     <input type='submit' name='but_search' value='Search'>
   </form>
</div>
   <!-- Employees List -->
   <div style='height: 80%; overflow: auto;' >
   <div class="content">
     <table border='1' width='100%' style='border-collapse: collapse;margin-top: 20px;'>
       <tr>
         <th>Name</th>
         <th>Date of Join</th>
         <th>Gender</th>
         <th>Email</th>
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
            $id = $empRecord['id'];
            $empName = $empRecord['customer'];
            $date_of_join = $empRecord['date'];
            $gender = $empRecord['item_count'];
            $email = $empRecord['amount'];

            echo "<tr>";
            echo "<td>". $empName ."</td>";
            echo "<td>". $date_of_join ."</td>";
            echo "<td>". $gender ."</td>";
            echo "<td>". $email ."</td>";
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
 </body>
</html>