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

<script type="text/javascript" src="js/timetable.js"></script>
<link rel="stylesheet" href="css/timetable.css">
	
</head>

<body>
<div id="header"></div> 
<!--The header of page-->

	

	
	
	
<table>
	<tr>
	<th>Date</th>
	<th>Employee</th>
	<th>Shift</th>
</tr>
<tr>
	<td>
		<input type="date" id="myDate">
	</td>
	<td>
		<div class="dropdown">
  			<button id="btn1" onclick="dropMenuFunction(this.id)" class="dropbtn">Select</button>
  			<div id="myDropdown1" class="dropdown-content">
			<!--To retrieve list of employee n append in drop menu list-->
			<?php 
				include_once('php/connect_database.php');
				$sql = "SELECT emp_id, first_n, middle_n, last_n
				FROM employee";
				$result = $conn->query($sql);
				while($row = $result->fetch_assoc()) {
					echo "<a href='#' id=" . $row["emp_id"] . " onclick='getEmpId(this.text)' >";
					echo $row["emp_id"] . ' ' . $row["first_n"] . ' ' . $row["middle_n"] . ' ' . $row["last_n"];
					echo "</a>";
				}
			?>
  			</div>
		</div>
	</td>
	<td>
		<div class="dropdown">
  			<button id="btn2" onclick="dropMenuFunction(this.id)" class="dropbtn">Select</button>
  			<div id="myDropdown2" class="dropdown-content">
    		<a href="#" id = "Morning" onclick="getShift(this.id)">Morning</a>
    		<a href="#" id = "Afternoon" onclick="getShift(this.id)">Afternoon</a>
    		<a href="#" id = "Full" onclick="getShift(this.id)">Full Day</a>
  			</div>
		</div>
	</td>
</tr>	
	

	
	
</table>

<button onclick="insertIntoDB()">Apply</button>


	

	

	
</body>

</html> 

	
	
	
<div id="footer"></div> <!--The footer of page-->
</body>
</html>
