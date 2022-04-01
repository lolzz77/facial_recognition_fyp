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
		if (isset($_GET['backward'])) {		//check if button is pressed
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
		$total = 0;
		$late = 0;
		$early = 0;
		$nil = 0;
		$lateDate = "";
		$earlyDate = "";
		$nilDate = "";
		switch($shift) {
			//For all cases, u need to check if later/ealier than timer AND also check if NULL.
			//If no check for null, system will treat it as true which we dont want
			case 'Morning': //8AM, 12:30PM-1:30PM, 1:30PM, 5PM
				$total += 4;
				
				if(is_null($row['t_morning'])) {
					$nil ++;
					$nilDate = $row['date'];
				}
				else {//If later than 8:30AM work time
					if (strtotime(($row['t_morning'])) > strtotime("8:30:00")){
						$late ++;
						$lateDate = $row['date'];
					}
						
				}
					
				if(is_null($row['t_afternoon_break'])) {
					$nil ++;
					$nilDate = $row['date'];
				}
				else {//If out earlier than 12:30PM Break time
					if (strtotime(($row['t_afternoon_break'])) < strtotime("12:30:00")){
						$early ++;
						$earlyDate = $row['date'];
					}
						
				}
				
				if(is_null($row['t_afternoon'])) {
					$nil ++;
					$nilDate = $row['date'];
				}
				else {//If later than 1:30PM afternoong work time
					if (strtotime(($row['t_afternoon'])) > strtotime("13:30:00")){
						$late ++;
						$lateDate = $row['date'];
					}
						
				}

				
				if(is_null($row['t_end'])) {
					$nil ++;
					$nilDate = $row['date'];
				}
				else {//IF out earlier than 5PM end time
					if (strtotime(($row['t_end'])) < strtotime("17:00:00")){
						$early ++;
						$earlyDate = $row['date'];
					}
						
				}



				break;
				
			case 'Afternoon': //12:30PM, 4PM-5PM, 9:30PM
				$total += 4;
				
				if(is_null($row['t_afternoon'])) {
					$nil ++;
					$nilDate = $row['date'];
				}
				else {//If later than 1PM work time
					if (strtotime(($row['t_afternoon'])) > strtotime("13:00:00")){
						$late ++;
						$lateDate = $row['date'];
					}
						
				}
				
				if(is_null($row['t_evening_break'])) {
					$nil ++;
					$nilDate = $row['date'];
				}
				else {//If out earlier than 4PM break time
					if (strtotime(($row['t_evening_break'])) < strtotime("16:00:00")){
						$early ++;
						$earlyDate = $row['date'];
					}
						
				}	
				
				if(is_null($row['t_evening'])) {
					$nil ++;
					$nilDate = $row['date'];
				}
				else {//If later than 5:30PM work time
					if (strtotime(($row['t_evening'])) > strtotime("17:30:00")){
						$late ++;
						$lateDate = $row['date'];
					}
						
				}	


				if(is_null($row['t_end'])) {
					$nil ++;
					$nilDate = $row['date'];
				}
				else {//IF out earlier than 9:30PM end time
					if (strtotime(($row['t_end'])) < strtotime("21:30:00")){
						$early ++;
						$earlyDate = $row['date'];
					}
						
				}
				

				break;
				
			case 'Full': //8AM, 12:30PM-1:30PM, 1:30PM, 4PM-5PM, 5PM, 9:30PM
				$total += 6;
				
				if(is_null($row['t_morning'])) {
					$nil ++;
					$nilDate = $row['date'];
				}
				else {//If later than 8:30AM work time
					if (strtotime(($row['t_morning'])) > strtotime("8:30:00")){
						$late ++;
						$lateDate = $row['date'];
					}
						
				}
				

				if(is_null($row['t_afternoon_break'])) {
					$nil ++;
					$nilDate = $row['date'];
				}
				else {//If out earlier than 12:30PM Break time
					if (strtotime(($row['t_afternoon_break'])) < strtotime("12:30:00")){
						$early ++;
						$earlyDate = $row['date'];
					}
						
				}


				if(is_null($row['t_afternoon'])) {
					$nil ++;
					$nilDate = $row['date'];
				}
				else {//If later than 1:30PM afternoong work time
					if (strtotime(($row['t_afternoon'])) > strtotime("13:30:00")){
						$late ++;
						$lateDate = $row['date'];
					}
						
				}


				
				if(is_null($row['t_evening_break'])) {
					$nil ++;
					$nilDate = $row['date'];
				}
				else {//If out earlier than 4PM break time
					if (strtotime(($row['t_evening_break'])) < strtotime("16:00:00")){
						$early ++;
						$earlyDate = $row['date'];
					}
						
				}	
				
				if(is_null($row['t_evening'])) {
					$nil ++;
					$nilDate = $row['date'];
				}
				else {//If later than 5:30PM work time
					if (strtotime(($row['t_evening'])) > strtotime("17:30:00")){
						$late ++;
						$lateDate = $row['date'];
					}
						
				}	
				
				

				if(is_null($row['t_end'])) {
					$nil ++;
					$nilDate = $row['date'];
				}
				else {//IF out earlier than 9:30PM end time
					if (strtotime(($row['t_end'])) < strtotime("21:30:00")){
						$early ++;
						$earlyDate = $row['date'];
					}
						
				}
				
				break;
				
			default:
				echo "Default option triggered";
				break;
		}
		return array($total, $late, $early, $nil, $lateDate, $earlyDate, $nilDate);
		
	}

	//If you encoutner a problem where it says divide by 0 detected. This could be because timestamp data not tally with flag data. For example, timestamp shows 01 May 2021 Employee 1, but in Flag table, it is 01 May 2021 Employee 2.
	function calAtten($total, $late, $early) {
		if ($total == 0)
			echo "0 Detected. Problem could be Flag table doesn't tally with Timestamp table.";
		else {
			$attendance = (($total-$late-$early)/$total) *100;
			return $attendance;
		}
			
	}
	
	
	function getSalary($groupRow, $conn) {
		$sql = "SELECT salary
		FROM position
		WHERE position = 	(SELECT position
							FROM employee
							WHERE emp_id = ".$groupRow['emp_id'].")";
		
		$result = $conn->query($sql) or die($conn->error);
		$row = $result->fetch_assoc();
		$salary = $row['salary'];
		return $salary;
	}
	
	
	function calSalary ($late, $early, $salary) {
		//Too lazy to calculate this shit....
		$SOCSO = 1;
		$EPF = 1;
		$EIS = 1;
		
		$newSalary = $salary - ($late*10) - ($early*10);
		return $newSalary;
	}

	
	function displayReport ($monthInt, $conn, $groupRow, $attendance, $late, $arrLate, $early, $arrEarly, $nil, $arrNil, $salary, $newSalary) { //Same shit from view_attendance.php
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
				
				//Display Employee
				echo "<td>";
				echo $row['emp_id'].' '.$row['first_n'].' '.$row['middle_n'].' '.$row['last_n'];
				echo "</td>";

				//Display attendance result
				echo "<td>";
				echo $attendance;
				echo "</td>";
			
				//Display late result
				echo "<td>";
				echo $late . "Time(s)<br>";
				foreach ($arrLate as $l)
					echo $l;
				echo "</td>";

				//Display early result
				echo "<td>";
				echo $early . "Time(s)<br>";
				foreach ($arrEarly as $e)
					echo $e;
				echo "</td>";
			
				//Display nil result
				echo "<td>";
				echo $nil . "Time(s)<br>";
				foreach ($arrNil as $n)
					echo $n;
				echo "</td>";

				//Display base salary
				echo "<td>";
				echo $salary;
				echo "</td>";

				//Display final salary
				echo "<td>";
				echo $newSalary;
				echo "</td>";



			echo "</tr>";
		}
	}


	

?>
	
	
	
	<!--I dont understand why i put display table header first then display month, but the website coding will display month first then table header-->
  <div class="table">
    <table>
        <tr>
            <th>Employee</th>
			<th>Attendance (%)</th>
			<th>Late</th>
			<th>Early</th>
			<th>No Record</th>
			<th>Base Salary (RM)</th>
			<th>Final Salary (RM)</th>
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
	echo "There's no record for the month";		

else {
	
	
	mysqli_data_seek($groupResult, 0);
	while($groupRow = $groupResult->fetch_assoc()) {
		$total = 0;
		$late = 0;
		$early = 0;
		$nil = 0;
		$salary = 0;
		$newSalary = 0;
		$temp = array();
		$arrLate = array();
		$arrEarly = array();
		$arrNil = array();
		//Joining 3 tables, multiple AND clauses
		//Select the data for each employee ID
		$sql = "SELECT t.date, t.t_morning, t.t_afternoon_break, t.t_afternoon, t.t_evening_break, t.t_evening, t.t_end, e.emp_id, e.first_n, e.middle_n, e.last_n, f.shift
			FROM timestamp t
			CROSS JOIN employee e
			ON t.emp_id = e.emp_id
			CROSS JOIN flag f
			ON t.emp_id = f.emp_id
			AND t.date = f.date
			AND t.emp_id =".$groupRow['emp_id']."
			AND MONTH(t.date)=".$monthInt;

		$result = $conn->query($sql) or die($conn->error);
		while($row = $result->fetch_assoc()) {
			$temp = checkLate($row['shift'], $row);
			$total += $temp[0];
			$late += $temp[1];
			$early += $temp[2];
			$nil += $temp[3];
			array_push($arrLate, $temp[4]);
			array_push($arrEarly, $temp[5]);
			array_push($arrNil, $temp[6]);
		}
		$salary = getSalary($groupRow, $conn);
		$newSalary = calSalary($late, $early, $salary);
		$attendance = calAtten($total, $late, $early);
		displayReport($monthInt, $conn, $groupRow, $attendance, $late, $arrLate, $early, $arrEarly, $nil, $arrNil, $salary, $newSalary);
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
