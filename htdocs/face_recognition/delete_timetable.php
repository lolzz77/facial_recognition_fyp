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
	<link rel="stylesheet" href="css/table.css">
	
</head>

<body>
<div id="header"></div> 
<!--The header of page-->

	
<?php //same shit as in view_timetable.php

	include_once('php/connect_database.php');

	function getMonthF($add) {
		$cookie_name = "monthCookie";
		date_default_timezone_set('Asia/Singapore');
		if(!isset($_COOKIE[$cookie_name])) { 
			$month = date('n'); //Get int of the month Jan=1, Feb=2...
		}
		else {
			$month = date('n');
			$month += $add; 
			$month = $month + $_COOKIE[$cookie_name]; 
		}
		return $month; 
	}

	
	
	function forwardMonth() {
		$cookie_name = "monthCookie";
		if (isset($_GET['forward'])) {	//check if button is pressed
			if(!empty($_GET[$cookie_name])) { 
				$cookie_value = 0; 
				setcookie($cookie_name, $cookie_value+1); //Here, add means next month
			}
			else { 
				$temp = $_COOKIE[$cookie_name];
				setcookie($cookie_name, $temp+1);
			}
			header('Location: '.$_SERVER['PHP_SELF']);
		}
	}

	
	function backwardMonth() {
		$cookie_name = "monthCookie";
		if (isset($_GET['backward'])) { //check if button is pressed	
			if(!empty($_GET[$cookie_name])) { 
				$cookie_value = 0;
				setcookie($cookie_name, $cookie_value-1); //Here, minus means previous month
			}
			else { 
				$temp = $_COOKIE[$cookie_name];
				setcookie($cookie_name, $temp-1); 
			}
			header('Location: '.$_SERVER['PHP_SELF']);
		}

	}
	
	


	

?>


<?php
	$monthInt = getMonthF(0); //Get Month Int, 1=Jan, 2=Feb
	$monthName = date('F', mktime(0, 0, 0, $monthInt, 10)); //Convert Int to Jan,Feb..
	echo "<p> Month: ".$monthName."<p>"; //Display Jan, Feb...	
?>


	<div class="table">
	<table>
		<tr>
		<th>Delete Timetable</th>
		</tr>
		
		
		<tr>
		<td>
<div class="dropdown">
	<button id="btn4" onclick="dropMenuFunction(this.id)" class="dropbtn">SELECT</button>
		<div id="myDropdown4" class="dropdown-content">
		<!--To retrieve list of employee n append in drop menu list-->
		<?php 
			$sql = "SELECT f.date, f.shift, e.emp_id, e.first_n, e.middle_n, e.last_n
			FROM flag f
			CROSS JOIN employee e
			ON f.emp_id = e.emp_id
			AND MONTH(f.date)=".$monthInt."
			ORDER BY f.date ASC";
			$result = $conn->query($sql) or die($conn->error);
			if($result->fetch_assoc() == 0) {
				echo "List is empty";
			} else {
				mysqli_data_seek($result, 0);
				while($row = $result->fetch_assoc()) {
					echo "<a href='#' id=" . $row["emp_id"] . " onclick='getEmpId4(this.text)' >";
					echo $row['date'] . ' ' . $row["emp_id"] . ' ' . $row["first_n"] . ' ' . $row["middle_n"] . ' ' . $row["last_n"] . ' ' . $row['shift'];
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
	
<form method="get">
	<input type="submit" name="backward" value="Previous Month" onclick="<?php if (isset($_GET['backward'])) {backwardMonth();} ?>">
		
	<input type="submit" name="forward" value="Next Month" onclick="<?php if (isset($_GET['forward'])) {forwardMonth();} ?>"> 

</form>

<br>

</body>

</html> 

	
	
	
<div id="footer"></div> <!--The footer of page-->
</body>
</html>
