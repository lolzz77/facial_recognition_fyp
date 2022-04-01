<?php
#This file execute SQL UPDATE command
include_once('connect_database.php');

$empId = $_GET["id"];



//SQL DELETE command
$sql = "DELETE FROM employee
WHERE emp_id = '$empId'";


if ($conn->query($sql) === TRUE) {
	  echo "Record deleted successfully";
} else {
	 echo "Error updating record: " . $conn->error;
}


//location.href = document.referrer; return false;
//This code will go back to previous page and refresh the page
//Without refresh, the drop down menu will display the old records
echo "<br>";
echo "<button onclick='location.href = document.referrer; return false;'>Back</button>";
	
?>