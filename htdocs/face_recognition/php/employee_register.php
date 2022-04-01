<?php

include_once('connect_database.php');

$emp_id = $_POST['emp_id'];
$first_n = $_POST['first_n'];
$middle_n = $_POST['middle_n'];
$last_n = $_POST['last_n'];
$position = $_POST['job_position'];

$sql="INSERT INTO employee 
(emp_id, first_n, middle_n, last_n, position)
VALUE
('$emp_id', '$first_n', '$middle_n', '$last_n', '$position')";


if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

echo "<br>";
echo "<button onclick='history.back()'>Back</button>";

?>
