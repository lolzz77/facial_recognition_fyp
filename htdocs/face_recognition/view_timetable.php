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

	
<?php
	//The cookie code is not perfect tho, once load, sometimes the date is not this week's day, gotta manually press previous date button to make the date display this week's date
	
	//TO connect database, $conn was needed from this
	include_once('php/connect_database.php');

	function getDateF($add) {
		$cookie_name = "weekCookie";
		date_default_timezone_set('Asia/Singapore');
		if(!isset($_COOKIE[$cookie_name])) { //If no cookie is set
			$day = date('w'); //Get int of the day Sunday = 6, so value is 6

		}
		else {
			$day = date('w');
			$day += $add; //Add days (for forward/backward button)
			$day = $day + $_COOKIE[$cookie_name]; //use "+" becos +(-7)=-7 and +(+7)=+7"

		}
		$week_start = date('m-d-Y', strtotime('-'.($day-1).' days')); //Monday of week, value will be in Date m-d-Y format eg: 05-28-2021
		//Tried changing format to 'd-M-Y', but it will cause error where wrong employee display on wrong date.
		$week_end = date('m-d-Y', strtotime('+'.(7-$day).' days')); //Sunday of week
		return array($day, $week_start, $week_end); //return int of day, m-d-Y format Date of Monday of week, m-d-Y format Date of Sunday of week
	}
	
	function getFirstWeek ($add) { //Get date of Monday of week
		$temp = getDateF($add); //This function returns an array
		$week_start = $temp[1]; //Index 1 is the week_start value
		return $week_start;
	}
	
	function displayDate($week_start) {
		//By using = date('d-M-Y', strtotime($week_start)); method, error date will be generated.
		//By using this method, no problem.
		$myDateTime = DateTime::createFromFormat('m-d-Y', $week_start);
		$newDateString = $myDateTime->format('d-M-Y');
		echo $newDateString;
	}
	
	
	function forwardDate() {
		$cookie_name = "weekCookie";
		if (isset($_GET['forward'])) {	//Check if the forward button is pressed. Without this, PHP will run following code for once when loading the page without caring if button is pressed.
			if(!empty($_GET[$cookie_name])) { //Check if cookie is empty, there are 2 types of checking: isset() and empty()
			//isset() Is a positive check that the variable/index is set and not NULL
			//empty() Is a negative check that the index/variable does not exists or has a value that is considered empty (NULL, 0, '', array()).
				
			//i... actually have no idea how this works.... I tot should put if(!empty($_COOKIE[$cookie_name])) but date will only forward once if that way
			//However, if i put if(!empty($_GET[$cookie_name])), no problem, date will keep forwarding without problem.
			//If it works, fk it, dont touch it anymore
				$cookie_value = 0; //If cookie is empty, assign 0 value and add 7 days
				setcookie($cookie_name, $cookie_value-7); //minus 7 means next 7 days
			}
			else { //if cookie is not empty, get cookie
				$temp = $_COOKIE[$cookie_name];
				setcookie($cookie_name, $temp-7); //minus 7 means next 7 days
			}
			header('Location: '.$_SERVER['PHP_SELF']); //Refresh page by redirecting to back to self, this is to get rid of cookie stored in $_POST/$_GET. Without this, date will be forwarded/backwarded everytime u press F5, this happens when u clicked forward button once.
		}

	}

	
	
	function backwardDate() { //Same shit as forward date
		$cookie_name = "weekCookie";
		if (isset($_GET['backward'])) {		
			if(!empty($_GET[$cookie_name])) { //If no cookie found, set cookie
				$cookie_value = 0;
				setcookie($cookie_name, $cookie_value+7); //minus 7 means next 7 days
			}
			else { //if cookie found, get cookie
				$temp = $_COOKIE[$cookie_name];
				setcookie($cookie_name, $temp+7); //minus 7 means next 7 days
			}
			header('Location: '.$_SERVER['PHP_SELF']);
		}

	}
	
	function displayTimetable ($shift, $day_name, $conn) {
		$temp = array();
		$temp = getDateF(0); //function return array, 0 means add 0 day
		$day = $temp[0]; //the first index is day
		$week_start = $temp[1]; //second index is date of the first day of week
		$week_end = $temp[2]; //third index is the date of the last day of week

		$sql = "SELECT f.date, e.emp_id, e.first_n, e.middle_n, e.last_n
		FROM employee e 
		CROSS JOIN flag f
		ON e.emp_id = f.emp_id
		AND f.shift = '$shift'";
		$result = $conn->query($sql) or die($conn->error); //"or die" code is important to troubleshoot error. In this case, u actually have error in SQL SELECT statement;
		$arrDay = array(); //Array to store monday date
		echo "<td>";
		if ($result->fetch_assoc() == 0) //If database so such SQL, display NIL
			echo "Nil";
		else {
			//Reset query pointer, without this, the 1st row query is skipped
			//Becos u called it once when defining a function
			mysqli_data_seek($result, 0);
			while($row = $result->fetch_assoc()) {
				$temp = $row['date'];
				$day_date = date('m-d-Y', strtotime($temp)); //Change date format to m-d-Y for checking if date is in between 2 dates purposes
				if(($day_date >= $week_start) && ($day_date <= $week_end)){ //if date is between the 2 dates (first day of week & last day of week)
					$d = date('l', strtotime($row['date'])); //Get day (M,T,W...) from Date
					if ($d == "$day_name") {//If is Monday, store into array, and display employee
						array_push($arrDay, $row['date']); //Append to array, at the end, if array is empty, will display NIL
						echo $row['emp_id'] . ' ' . $row['first_n'] . ' ' . $row['middle_n'] . ' ' . $row['last_n']; //Display employee detail
						echo "<br>";
					}
				}

			}
			if (empty($arrDay))//If array is empty, display nil
				echo "Nil";
		}
		echo "</td>"; 

	}
	

?>

	
<table>
	<tr>
		<th>Shift</th>
		<!-- (-1) means next day -->
		<!-- (-2) means next 2 day -->
		<!-- (-3) means next 3 day !!!-->
		<th><p id="monday"><?php $week_start = getFirstWeek(0); displayDate($week_start) ?></p>Monday</th>
		<th><p id="tuesday"><?php $week_start = getFirstWeek(-1); displayDate($week_start) ?></p>Tuesday</th> 
		<th><p id="wednesday"><?php $week_start = getFirstWeek(-2); displayDate($week_start) ?></p>Wednesday</th>
		<th><p id="thursday"><?php $week_start = getFirstWeek(-3); displayDate($week_start) ?></p>Thursday</th>
		<th><p id="friday"><?php $week_start = getFirstWeek(-4); displayDate($week_start) ?></p>Friday</th>
		<th><p id="saturday"><?php $week_start = getFirstWeek(-5); displayDate($week_start) ?></p>Saturday</th>
		<th><p id="sunday"><?php $week_start = getFirstWeek(-6); displayDate($week_start) ?></p>Sunday</th>
	</tr>
	<tr>
		<td>Morning</td>
		<?php 	
			displayTimetable("Morning", "Monday", $conn);
			displayTimetable("Morning", "Tuesday", $conn);
			displayTimetable("Morning", "Wednesday", $conn);
			displayTimetable("Morning", "Thursday", $conn);
			displayTimetable("Morning", "Friday", $conn);
			displayTimetable("Morning", "Saturday", $conn);
			displayTimetable("Morning", "Sunday", $conn);
		?>
	</tr>
	<tr>
		<td>Afternoon</td>
		<?php 	
			displayTimetable("Afternoon", "Monday", $conn);
			displayTimetable("Afternoon", "Tuesday", $conn);
			displayTimetable("Afternoon", "Wednesday", $conn);
			displayTimetable("Afternoon", "Thursday", $conn);
			displayTimetable("Afternoon", "Friday", $conn);
			displayTimetable("Afternoon", "Saturday", $conn);
			displayTimetable("Afternoon", "Sunday", $conn);
		?>
	</tr>
	<tr>
		<td>Full</td>
		<?php 	
			displayTimetable("Full", "Monday", $conn);
			displayTimetable("Full", "Tuesday", $conn);
			displayTimetable("Full", "Wednesday", $conn);
			displayTimetable("Full", "Thursday", $conn);
			displayTimetable("Full", "Friday", $conn);
			displayTimetable("Full", "Saturday", $conn);
			displayTimetable("Full", "Sunday", $conn);
		?>
	</tr>

	

	
	
</table>
	<!--HTML Button to call PHP function, must use <form> to trigger $_GET/$_POST, PHP function will only be triggered through $_GET/$_POST-->
	<form method="get">
	<!--name = used to call PHP function. value = The button name -->
	<!--I have to include if (isset($_GET['backward'])), else the PHP will run the function while u first load this HTML. -->
	<!--But i already included the same code in the function, i dont know if this code is needed here, but fk it, just put it. -->
	<input type="submit" name="backward" value="Previous Week" onclick="<?php if (isset($_GET['backward'])) {backwardDate();} ?>">
		
	<input type="submit" name="forward" value="Next Week" onclick="<?php if (isset($_GET['forward'])) {forwardDate();} ?>"> 
	</form>



	

	

	
</body>

</html> 

	
	
	
<div id="footer"></div> <!--The footer of page-->
</body>
</html>
