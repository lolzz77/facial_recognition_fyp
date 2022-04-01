<?php
#This file execute SQL UPDATE command
include_once('connect_database.php');

#Data receive from timetable.js - location.href = "php/flag.php" + "?date=" + d;
$date = $_GET["date"];

#Data receive from timetable.js - location.href = "php/flag.php" + "?text=" + id;
$empId = $_GET["text"];


//Get today's date
date_default_timezone_set('Asia/Singapore');
$today = date('Y-m-d');


//SQL UPDATE command
$sql = "DELETE FROM flag
WHERE date = '$date' AND
emp_id = '$empId'";

//date = new selected date
//oldDate = the existing date as recorded in Flag table
//If existing date is older than today's date, no changes is allowed, else will mess up attendance record
//If existing date is newer than today's date, but the selected date is older than today's date, no changes is allowed, else attendance is 100% null
if ($date > $today){
	
	if ($conn->query($sql) === TRUE) {
	  echo "Record deleted successfully";
	} else {
	  echo "Error updating record: " . $conn->error;
	}
	
} else {
	
	echo "Date already passed today's date, deleting is not allowed";

}


//location.href = document.referrer; return false;
//This code will go back to previous page and refresh the page
//Without refresh, the drop down menu will display the old records
echo "<br>";
echo "<button onclick='location.href = document.referrer; return false;'>Back</button>";
	
?>