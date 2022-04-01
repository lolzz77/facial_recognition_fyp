<!doctype html>
<html>
<head>

<script
    src="https://code.jquery.com/jquery-3.3.1.js"
    integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
    crossorigin="anonymous">
</script>
<script> 
$(function(){ //This is to load the header & footer of page
  $("#header").load("header.html"); 
  $("#footer").load("footer.html"); 
});
</script> 
<script type="text/javascript" src="js/employee.js"></script>
<link rel="stylesheet" href="css/timetable.css">
	<link rel="stylesheet" href="css/table.css">
	
</head>

<body>
<div id="header"></div> 
<!--The header of page-->

	
<?php 

	include_once('php/connect_database.php');

?>


	<div class="table">
	<table>
		<tr>
		<th>Delete Employee</th>
		</tr>
		<tr>
		<td>
<div class="dropdown">
	<button id="btn1" onclick="dropMenuFunction(this.id)" class="dropbtn">SELECT</button>
		<div id="myDropdown1" class="dropdown-content">
		<!--To retrieve list of employee n append in drop menu list-->
		<?php 
			$sql = "SELECT *
			FROM employee
			ORDER BY emp_id ASC";
			
			$result = $conn->query($sql) or die($conn->error);
			if($result->fetch_assoc() == 0) {
				echo "List is empty";
			} else {
				mysqli_data_seek($result, 0);
				while($row = $result->fetch_assoc()) {
					echo "<a href='#' id=" . $row["emp_id"] . " onclick='getEmpId(this.text)' >";
					echo $row['emp_id'] . ' ' . $row["first_n"] . ' ' . $row["middle_n"] . ' ' . $row["last_n"] . ' ' . $row['position'];
					echo "</a>";
				}
			}
			
		?>
		</div>
</div>
</td>
</tr>
		
		
<br>
		<tr>
		<td>
<button onclick="deleteData()">Click to Delete</button>
		</td>
		</tr>
	</table>
	</div>
	
	
	
<br><br><br>


</body>

</html> 

	
	
	
<div id="footer"></div> <!--The footer of page-->
</body>
</html>
