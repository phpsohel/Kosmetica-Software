<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kosmetica";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>
<style>
    table.dataTable.display tbody td {
   
    font-size: 12px !important;
}
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.0/css/jquery.dataTables.css" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<table class="display" style="width:95%" id="example">
<thead>
     <th>Name</th>
     <?php
        $sql1 = "select id, name from warehouses order by id";
        $war_result = $conn->query($sql1);
        
          while($row1 = $war_result->fetch_assoc()) {
             
            echo "<th>" . $row1["name"]. "</th>";
           
        }
       
     ?>
     <th>QTY</th>
   
</thead>
<tbody>
<?php
//$sql = "select categories.name as cname, categories.id as catid, sum(products.qty) as total_stock from categories, products where products.category_id=categories.id group by categories.name";
$sql = "select categories.name as cname, categories.id as catid, sum(products.qty) as total_stock from categories, products where products.category_id=categories.id group by categories.id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  
  while($row = $result->fetch_assoc()) {
      
      echo " <tr>";
      echo "<td>" . $row["cname"]. "</td>";
    
        $war_result = $conn->query($sql1);
        
          while($row1 = $war_result->fetch_assoc()) {
             
           
           echo "<td>0</td>";
           
            $prosql1 = "select id from products where category_id=1";
            $proresult12 = $conn->query($prosql1);
              
              while($prow12 = $proresult12->fetch_assoc()) {
                $sumqty=0; 
                $sql12 = "select qty from product_warehouse where product_id='$prow12[id]' AND warehouse_id='$row1[id]'";
                $result12 = $conn->query($sql12);
                $qtyprow12 = $result12->fetch_assoc();
                $sumqty=$sumqty+$qtyprow12["qty"];
              }
              echo "<th>" . $sumqty. "</th>";
              
              
          }
        
        
    echo "<td>" . $row["total_stock"]."</td>";
    echo " </tr>";
  }
  
} else {
  echo "0 results";
}
$conn->close();
?>
</tbody>

</table>


<script src="https://cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
<script>
$(document).ready(function () {
    $('#example').DataTable();
});
</script>