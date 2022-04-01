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
	<link rel="stylesheet" href="css/timetable.css">
	<link rel="stylesheet" href="css/table.css">
</head>

<body>
<div id="header"></div> <!--The header of page-->

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
		if (isset($_GET['forward'])) {	
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
		if (isset($_GET['backward'])) {		
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
	
	function checkLate($shift, $period, $row){ //Shift = Morning/Afternoon..
		//Period = t_morning, t_afternoon..
		//Row = the result gotten from SQL query
		switch($shift) {
			case 'Morning': //8AM, 12:30PM-1:30PM, 1:30PM, 5PM
				if($period == 't_morning') {
					
					if(is_null($row['t_morning']))
						echo "NO RECORD";
					else if(strtotime(($row['t_morning'])) > strtotime("8:30:00")) //If later than 8:30AM work time
						echo "LATE";
				}
				else if ($period == 't_afternoon_break') {
					
					if(is_null($row['t_afternoon_break']))
						echo "NO RECORD";
					else if((strtotime(($row['t_afternoon_break']))) < strtotime("12:30:00"))  //If out earlier than 12:30PM Break time
						echo "EARLY OUT";
				}
				else if ($period == 't_afternoon') {
					
					if(is_null($row['t_afternoon']))
						echo "NO RECORD";
					else if (strtotime(($row['t_afternoon'])) > strtotime("13:30:00"))  //If later than 1:30PM afternoong work time
						echo "LATE";
				}
				else if ($period == 't_end') {
					
					if(is_null($row['t_end']))
						echo "NO RECORD";
					else if (strtotime(($row['t_end'])) < strtotime("17:00:00"))//IF out earlier than 5PM end time
						echo "EARLY OUT";
				}
				
				//To display error for timestamp that is not part of the shift
				//e.g evening break timestamp for Morning Shift,
				else if ($period == 't_evening_break') {
					if(!is_null($row['t_evening_break']))	
						echo "ERROR";
					else
						echo "Nil";
				}
				else if ($period == 't_evening') {
					if(!is_null($row['t_evening']))	
						echo "ERROR";
					else
						echo "Nil";
				}
				
				
				
				
				break;
				
			case 'Afternoon': //12:30PM, 4PM-5PM, 9:30PM
				if ($period == 't_afternoon') {
					if(is_null($row['t_afternoon']))
						echo "NO RECORD";
					else if((strtotime(($row['t_afternoon']))) > strtotime("13:00:00"))  //If later than 1PM work time
						echo "LATE";
					
				}
				else if ($period == 't_evening_break') {
					if(is_null($row['t_evening_break']))
						echo "NO RECORD";
					else if (strtotime(($row['t_evening_break'])) < strtotime("16:00:00"))  //If out earlier than 4PM break time
						echo "EARLY OUT";
					
				}
				else if ($period == 't_evening') {
					if(is_null($row['t_evening']))
						echo "NO RECORD";
					else if (strtotime(($row['t_evening'])) > strtotime("17:30:00"))  //If later than 5:30PM work time
						echo "LATE";
					
				}
				else if ($period == 't_end') {
					if(is_null($row['t_end']))
						echo "NO RECORD";
					else if (strtotime(($row['t_end'])) < strtotime("21:30:00"))//IF out earlier than 9:30 PM end time
						echo "EARLY OUT";
					
				}
				
				
				//To display error for timestamp that is not part of the shift
				//e.g evening break timestamp for Morning Shift,
				else if ($period == 't_morning') {
					if(!is_null($row['t_morning']))	
						echo "ERROR";
					else
						echo "Nil";
				}
				else if ($period == 't_afternoon_break') {
					if(!is_null($row['t_afternoon_break']))	
						echo "ERROR";
					else
						echo "Nil";
				}
				
				
				
				
				break;
				
			case 'Full': //8AM, 12:30PM-1:30PM, 1:30PM, 4PM-5PM, 5PM, 9:30PM
				if($period == 't_morning') {
					if(is_null($row['t_morning']))
						echo "NO RECORD";
					else if(strtotime(($row['t_morning'])) > strtotime("8:30:00")) //If later than 8:30AM work time
						echo "LATE"; 
					
				}
				else if ($period == 't_afternoon_break') {
					if(is_null($row['t_afternoon_break']))
						echo "NO RECORD";
					else if((strtotime(($row['t_afternoon_break']))) < strtotime("12:30:00"))  //If out earlier than 12:30PM Break time
						echo "EARLY OUT";
					
				}
				else if ($period == 't_afternoon') {
					if(is_null($row['t_afternoon']))
						echo "NO RECORD";
					else if (strtotime(($row['t_afternoon'])) > strtotime("13:30:00"))  //If later than 1:30PM afternoong work time
						echo "LATE";
					
				}
				else if ($period == 't_evening_break') {
					if(is_null($row['t_evening_break']))
						echo "NO RECORD";
					else if (strtotime(($row['t_evening_break'])) < strtotime("16:00:00"))  //If out earlier than 4PM break time
						echo "EARLY OUT";
					
				}
				else if ($period == 't_evening') {
					if(is_null($row['t_evening']))
						echo "NO RECORD";
					else if (strtotime(($row['t_evening'])) > strtotime("17:30:00"))  //If later than 5:30PM work time
						echo "LATE";
					
				}
				else if ($period == 't_end') {
					if(is_null($row['t_end']))
						echo "NO RECORD";
					else if (strtotime(($row['t_end'])) < strtotime("21:30:00"))//IF out earlier than 9:30 PM end time
						echo "EARLY OUT";
					
				}
				break;
				
			default:
				echo "Default option triggered";
				break;
		}
	}
	
	function displayTimetable ($monthInt, $conn, $result) {
		$temp = array();
		$temp = getMonthF(0);
		$month = $temp; 

		mysqli_data_seek($result, 0);
		while($row = $result->fetch_assoc()) {
			echo "<tr>";
			//Note: For this data to be displayed, make sure Flag table has set for the particular employee on the particular month

				//Display date
				echo "<td>";
				echo $row['date'] = date ('d-M-Y', strtotime($row['date']));
				echo "</td>";

				//Display Employee
				echo "<td>";
				echo $row['emp_id'].' '.$row['first_n'].' '.$row['middle_n'].' '.$row['last_n'];
				echo "</td>";

				//Display Shift
				echo "<td>";
				echo $row['shift'];
				echo "</td>";
			
				//Display morning time
				echo "<td>";
				if ($row['t_morning'] == null)
					checkLate($row['shift'],'t_morning', $row);
				else {
					echo $row['t_morning'];
					echo "<br>";
					checkLate($row['shift'],'t_morning', $row);
				}
				echo "</td>";

				//Display afternoon break
				echo "<td>";
				if ($row['t_afternoon_break'] == null)
					checkLate($row['shift'],'t_afternoon_break', $row);
				else {
					echo $row['t_afternoon_break'];
					echo "<br>";
					checkLate($row['shift'],'t_afternoon_break', $row);
				}
				echo "</td>";


				//Display afternoon time
				echo "<td>";
				if ($row['t_afternoon'] == null)
					checkLate($row['shift'],'t_afternoon', $row);
				else {
					echo $row['t_afternoon'];
					echo "<br>";
					checkLate($row['shift'],'t_afternoon', $row);
				}
				echo "</td>";

				//Display Evening break
				echo "<td>";
				if ($row['t_evening_break'] == null)
					checkLate($row['shift'],'t_evening_break', $row);
				else {
					echo $row['t_evening_break'];
					echo "<br>";
					checkLate($row['shift'],'t_evening_break', $row);
				}
				echo "</td>";


				//Display evening
				echo "<td>";
				if ($row['t_evening'] == null)
					checkLate($row['shift'],'t_evening', $row);
				else {
					echo $row['t_evening'];
					echo "<br>";
					checkLate($row['shift'],'t_evening', $row);
				}
				echo "</td>";


				//Display end time
				echo "<td>";
				if ($row['t_end'] == null)
					checkLate($row['shift'],'t_end', $row);
				else {
					echo $row['t_end'];
					echo "<br>";
					checkLate($row['shift'],'t_end', $row);
				}
				echo "</td>";


			echo "</tr>";
		}
	}


	

?>
	
	
	
	
  <div class="table">
    <table>
        <tr>
			<th>Date</th>
            <th>Employee</th>
			<th>Shift</th>
            <th>Morning</th>
			<th>Afternoon Break</th>
			<th>Afternoon</th>
			<th>Evening Break</th>
			<th>Evening</th>
			<th>End</th>
        </tr>

<?php

$monthInt = getMonthF(0); //Get Month Int, 1=Jan, 2=Feb
$monthName = date('F', mktime(0, 0, 0, $monthInt, 10)); //Convert Int to Jan,Feb..
echo "<p> Month: ".$monthName."</p>"; //Display Jan, Feb...
//Joining 3 tables
$sql = "SELECT t.date, t.t_morning, t.t_afternoon_break, t.t_afternoon, t.t_evening_break, t.t_evening, t.t_end, e.emp_id, e.first_n, e.middle_n, e.last_n, f.shift
		FROM timestamp t
		CROSS JOIN employee e
		ON t.emp_id = e.emp_id
		CROSS JOIN flag f
		ON t.emp_id = f.emp_id
		AND t.date = f.date
		AND MONTH(t.date)=".$monthInt."
		ORDER BY t.date ASC; ";
$result = $conn->query($sql) or die($conn->error);
if ($result->fetch_assoc() == 0) //If database so such SQL, display NIL
	echo "There's no record for the month";
else {
	mysqli_data_seek($result, 0);
	while($row = $result->fetch_assoc()) {
		displayTimetable($monthInt, $conn, $result);		
	}

}
		
?>
     </table>
</div>

<form method="get">
	<input type="submit" name="backward" value="Previous Month" onclick="<?php if (isset($_GET['backward'])) {backwardMonth();} ?>">
		
	<input type="submit" name="forward" value="Next Month" onclick="<?php if (isset($_GET['forward'])) {forwardMonth();} ?>"> 
</form>

	
	
	
<div id="footer"></div> <!--The footer of page-->
</body>
</html>
