<?php
#This file execute SQL INSERT command
include_once('connect_database.php');

#Data receive from timetable.js - location.href = "php/flag.php" + "?date=" + d;
$date = $_GET["date"];

#Data receive from timetable.js - location.href = "php/flag.php" + "?text=" + id;
$empId = $_GET["text"];

#Data receive from timetable.js - location.href = "php/flag.php" + "?id=" + id;
$shift = $_GET["id"];

//Check if same value exist
$sql = "SELECT date, emp_id, shift
FROM flag
WHERE date = '$date' AND
emp_id = '$empId' AND
shift = '$shift'";
$result = $conn->query($sql);

//Check if same value exist, else insert into database
if ($result->num_rows > 0)
	echo "<br> ERROR: Same value existed";
else {
	$sql = "INSERT INTO flag (date, emp_id, shift)
	VALUE
	('$date', '$empId', '$shift')";

	if ($conn->query($sql) === TRUE) 
  		echo "New record created successfully";
	else 
  		echo "Error: " . $sql . "<br>" . $conn->error;
	
}



echo "<br>";
echo "<button onclick='history.back()'>Back</button>";
	
?>