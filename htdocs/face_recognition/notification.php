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
	
	function checkLate($shift, $row){ 
		$date = "";
		$tempShift = ""; //Temporary shift, use to display shift (Morning, Afternoon) for function DisplayReport
		$lateNotice = "";
		$earlyNotice = "";
		$arrNotice = array();
		switch($shift) {
			case 'Morning': //8AM, 12:30PM-1:30PM, 1:30PM, 5PM

				if(strtotime(($row['t_morning'])) > strtotime("8:30:00")) {//If later than 8:30AM work time
						$tempShift = "Morning";
						$date = $row['date'];
						$lateNotice = "Late to work on Morning Session today";
						array_push($arrNotice, $lateNotice);
				}

				if((strtotime(($row['t_afternoon_break']))) < strtotime("12:30:00")) { //If out earlier than 12:30PM Break time
						$tempShift = "Morning";
						$date = $row['date'];
						$earlyNotice = "Leaving early on Afternoon Break Session today";
						array_push($arrNotice, $earlyNotice);
				}

				if (strtotime(($row['t_afternoon'])) > strtotime("13:30:00")) {//If later than 1:30PM afternoong work time
						$tempShift = "Morning";
						$date = $row['date'];
						$lateNotice = "Late to work on Afternoon Session today";
						array_push($arrNotice, $lateNotice);
				}

				if (strtotime(($row['t_end'])) < strtotime("17:00:00")) {//IF out earlier than 5PM end time
						$tempShift = "Morning";
						$date = $row['date'];
						$earlyNotice = "Leaving early before work ends today";
						array_push($arrNotice, $earlyNotice);
				}

				break;
				
			case 'Afternoon': //12:30PM, 4PM-5PM, 9:30PM

				
				if((strtotime(($row['t_afternoon']))) > strtotime("13:00:00")) {  //If later than 1PM work time
						$tempShift = "Afternoon";
						$date = $row['date'];
						$lateNotice = "Late to work on Afternoon Session today";
						array_push($arrNotice, $lateNotice);
				}


				if (strtotime(($row['t_evening_break'])) < strtotime("16:00:00")) { //If out earlier than 4PM break time
						$tempShift = "Afternoon";
						$date = $row['date'];
						$earlyNotice = "Leaving early on Evening Break Session today";
						array_push($arrNotice, $earlyNotice);
				}


				if (strtotime(($row['t_evening'])) > strtotime("17:30:00")) {  //If later than 5:30PM work time
						$tempShift = "Afternoon";
						$date = $row['date'];
						$lateNotice = "Late to work on Evening Session today";
						array_push($arrNotice, $lateNotice);
				}


				if (strtotime(($row['t_end'])) < strtotime("21:30:00")) {//IF out earlier than 9:30 PM end time
						$tempShift = "Afternoon";
						$date = $row['date'];
						$earlyNotice = "Leaving early before work ends today";
						array_push($arrNotice, $earlyNotice);
				}

				break;
				
			case 'Full': //8AM, 12:30PM-1:30PM, 1:30PM, 4PM-5PM, 5PM, 9:30PM

				
				if(strtotime(($row['t_morning'])) > strtotime("8:30:00")) { //If later than 8:30AM work time
						$tempShift = "Full";
						$date = $row['date'];
						$lateNotice = "Late to work on Morning Session today";
						array_push($arrNotice, $lateNotice);
				}


				if((strtotime(($row['t_afternoon_break']))) < strtotime("12:30:00")) { //If out earlier than 12:30PM Break time
						$tempShift = "Full";
						$date = $row['date'];
						$earlyNotice = "Leaving early on Afternoon Break Session today";
						array_push($arrNotice, $earlyNotice);
				}


				if (strtotime(($row['t_afternoon'])) > strtotime("13:30:00")) { //If later than 1:30PM afternoong work time
						$tempShift = "Full";
						$date = $row['date'];
						$lateNotice = "Late to work on Afternoon Session today";
						array_push($arrNotice, $lateNotice);
				}


				if (strtotime(($row['t_evening_break'])) < strtotime("16:00:00")) { //If out earlier than 4PM break time
						$tempShift = "Full";
						$date = $row['date'];
						$earlyNotice = "Leaving early on Evening Break Session today";
						array_push($arrNotice, $earlyNotice);
				}


				if (strtotime(($row['t_evening'])) > strtotime("17:30:00")) { //If later than 5:30PM work time
						$tempShift = "Full";
						$date = $row['date'];
						$lateNotice = "Late to work on Evening Session today";
						array_push($arrNotice, $lateNotice);
				}


				if (strtotime(($row['t_end'])) < strtotime("21:30:00")) { //IF out earlier than 9:30 PM end time
						$tempShift = "Full";
						$date = $row['date'];
						$earlyNotice = "Leaving early before work ends today";
						array_push($arrNotice, $earlyNotice);
				}
				
				break;
				
			default:
				echo "Default option triggered";
				break;
		}
		//Since im returning array + const string, so i put the const string into the array as well, then i get them by using counting element inside array, get the last 2 elements
		
		if(is_null($date) || is_null($tempShift))
			return NULL;
		else {
			array_push($arrNotice, $date, $tempShift);
			return $arrNotice;
		}
			
		
	}

	function writeLetter ($monthInt, $row, $arrNotice, $date) {
		$monthDate = date('d-M-Y', strtotime($date));
		$monthName = date('F', mktime(0, 0, 0, $monthInt, 10)); //get month name
		$year = date('Y', strtotime($date)); //get year
		
		$list = ""; //To show the list of having unsatisfactory attendance
		$counter = 1;
		foreach ($arrNotice as $n) {
			$list = $list. $counter. ". " . $n . "\n";
			$counter ++;
		}
		
		$text = 
"To,
Name: ".$row['first_n'].' '.$row['middle_n'].' '.$row['last_n']."
Employee ID: ".$row['emp_id'].
"

Your attendance dated ".$monthDate." has been found to be unsatisfactory.

The following summarized the detail of your misconduct.
	
	
"
.$list.
"

You are accordingly hereby warned.

You are further advised in your own interest to be cautious and not to repeat such an act in future.



__________________ 
AUTHORISED SIGNATORY
";
		
		$filename = './warning_letter/'.$year.' '.$monthName.' '.$row['emp_id'].' '.$row['first_n'].' '.$row['middle_n'].' '.$row['last_n'].'.doc';
		
		$file = fopen($filename, 'w+');
		fwrite($file, $text);
		fclose($file);
		
		return $filename;
	}
	

	
	function displayReport ($monthInt, $conn, $groupRow, $date, $shift, $arrNotice) { //Same shit from view_attendance.php
		$temp = array();
		$temp = getMonthF(0);
		$month = $temp; 

		$sql = "SELECT emp_id, first_n, middle_n, last_n
		FROM employee
		WHERE emp_id=".$groupRow['emp_id'];
		$result = $conn->query($sql) or die($conn->error);
		
		mysqli_data_seek($result, 0);
		while($row = $result->fetch_assoc()) {
			echo "<tr>";
				
				//Date
				echo "<td>";
				echo date('d-M-Y', strtotime($date)); //Display in 04 April 2021 format
				echo "</td>";
				
				//Display Employee
				echo "<td>";
				echo $row['emp_id'].' '.$row['first_n'].' '.$row['middle_n'].' '.$row['last_n'];
				echo "</td>";

				//Display shift
				echo "<td>";
				echo $shift;
				echo "</td>";
			
				
				//Display notice
				echo "<td>";
				foreach ($arrNotice as $n)
					echo $n . "<br>";
				echo "</td>";

				echo "<td>";
				$filename = writeLetter($monthInt, $row, $arrNotice, $date);
				echo "<a href='".$filename."' download>  <button type='button'>Download</button> </a>";
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
			<th>Notice</th>
			<th>Warning Letter</th>
        </tr>

<?php

$monthInt = getMonthF(0); //Get Month Int, 1=Jan, 2=Feb
$monthName = date('F', mktime(0, 0, 0, $monthInt, 10)); //Convert Int to Jan,Feb..
echo "<p> Month: ".$monthName."</p>"; //Display Jan, Feb...

//To select grouped employee id found in timestamp
//e.g There are 5 employees taken attendance in April, SQL returns 5 IDs
$groupSQL = "SELECT emp_id
		FROM timestamp 
		WHERE MONTH(date)=".$monthInt."
		GROUP BY emp_id
		ORDER BY emp_id ASC";
$groupResult = $conn->query($groupSQL) or die($conn->error);
		
if ($groupResult->fetch_assoc() == 0) //If database so such SQL, display NIL
	echo "There's no attendance record for the month";	
		
else {
	
	mysqli_data_seek($groupResult, 0);
	while($groupRow = $groupResult->fetch_assoc()) {
		$arrNotice = array();
		$date = "";
		$shift = "";
		$temp = array();
		//Joining 3 tables, multiple AND clauses
		//Select the data for each employee ID
		$sql = "SELECT t.date, t.t_morning, t.t_afternoon_break, t.t_afternoon, t.t_evening_break, t.t_evening, t.t_end, e.emp_id, e.first_n, e.middle_n, e.last_n, f.shift
			FROM timestamp t
			CROSS JOIN employee e
			ON t.emp_id = e.emp_id
			CROSS JOIN flag f
			ON f.emp_id = t.emp_id
			AND t.emp_id =".$groupRow['emp_id']."
			AND MONTH(t.date)=".$monthInt."
			ORDER BY t.date ASC"; #ORDER BY Date will only work for that one particular employee here. 

		$result = $conn->query($sql) or die($conn->error);
		while($row = $result->fetch_assoc()) {
			$temp = checkLate($row['shift'], $row);
			if(!is_null($temp)) {
				$shift = end($temp); //The last index of array
				array_pop($temp); //Delete the last index, now the last index is $date
				$date = end($temp); //The last index of array
				array_pop($temp); //Delete again the last index, now array only contains the Notification string
				$arrNotice = $temp; 
			}
		}
		if (is_null($temp))
			echo "<br>No notification for this month";
		else
			displayReport($monthInt, $conn, $groupRow, $date, $shift, $arrNotice);
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
