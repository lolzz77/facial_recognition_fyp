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
	
	<div class="wrapper">
  <div class="table">
    <table>
        <tr>
            <th>Employee ID</th>
            <th>First Name</th>
			<th>Middle Name</th>
			<th>Last Name</th>
			<th>Position</th>
        </tr>

<?php

include_once('php/connect_database.php');
$sql = "SELECT *
FROM employee
ORDER BY emp_id ASC";
$history = mysqli_query($conn,$sql);
			
while($data = mysqli_fetch_array($history))
{
?>
		<tr> <!--the ['date'] follows the attribute name u created in the table in phpmyadmin-->
            <td><?php echo $data['emp_id'] ?></td>
            <td><?php echo $data['first_n'] ?></td>
			<td><?php echo $data['middle_n'] ?></td>
			<td><?php echo $data['last_n'] ?></td>
            <td><?php echo $data['position'] ?></td>
        </tr>
<?php
}
?>
     </table>
</div>
	
	
	
<div id="footer"></div> <!--The footer of page-->
</body>
</html>
