<?php

include_once('connect_database.php');

$username = $_POST['username'];
$password = $_POST['password'];
    
$sql="INSERT INTO account 
(user_id, password)
VALUE 
('$username', '$password')";


if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

echo "<br>";
echo "<button onclick='history.back()'>Back</button>";

?>