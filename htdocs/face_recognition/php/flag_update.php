<?php
#This file execute SQL UPDATE command
include_once('connect_database.php');

#Data receive from timetable.js - location.href = "php/flag.php" + "?date=" + d;
$date = $_GET["date"];

#Data receive from timetable.js - location.href = "php/flag.php" + "?text=" + id;
$empId = $_GET["text"];

#Data receive from timetable.js - location.href = "php/flag.php" + "?id=" + id;
$shift = $_GET["id"];

//Old date = existing date recorded in Flag table, need it to do SQL WHERE query
$oldDate = $_GET["old_date"];
//Old emp ID = existing empl ID recorded in Flag table, need it to do SQL WHERE query
$oldEmpId = $_GET["old_id"];

//Get today's date
date_default_timezone_set('Asia/Singapore');
$today = date('Y-m-d');


//SQL UPDATE command
$sql = "UPDATE flag
SET date = '$date',
emp_id = '$empId',
shift = '$shift'
WHERE date = '$oldDate' AND
emp_id = '$oldEmpId'";

//date = new selected date
//oldDate = the existing date as recorded in Flag table
//If existing date is older than today's date, no changes is allowed, else will mess up attendance record
//If existing date is newer than today's date, but the selected date is older than today's date, no changes is allowed, else attendance is 100% null
if ($oldDate > $today && $date > $today){
	
	if ($conn->query($sql) === TRUE) {
	  echo "Record updated successfully";
	} else {
	  echo "Error updating record: " . $conn->error;
	}
	
} else {
	
	echo "Date already passed today's date, changes is not allowed";

}


//location.href = document.referrer; return false;
//This code will go back to previous page and refresh the page
//Without refresh, the drop down menu will display the old records
echo "<br>";
echo "<button onclick='location.href = document.referrer; return false;'>Back</button>";
	
?>