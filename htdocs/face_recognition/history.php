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

</head>
<body>
<div id="header"></div> <!--The header of page-->
	

<div class="wrapper">
  <div class="table">
    <table>
        <tr>
            <th>Date</th>
            <th>Employee ID</th>
            <th>Morning</th>
			<th>Afternoon Break</th>
			<th>Afternoon</th>
			<th>Evening Break</th>
			<th>Evening</th>
        </tr>

<?php

include_once('php/connect_database.php');

$history = mysqli_query($conn,"select * from timestamp");
			
while($data = mysqli_fetch_array($history))
{
?>
		<tr> <!--the ['date'] follows the attribute name u created in the table in phpmyadmin-->
            <td><?php echo $data['date'] ?></td>
            <td><?php echo $data['emp_id'] ?></td>
            <td><?php echo $data['t_morning'] ?></td>
			<td><?php echo $data['t_afternoon_break'] ?></td>
			<td><?php echo $data['t_afternoon'] ?></td>
			<td><?php echo $data['t_evening_break'] ?></td>
			<td><?php echo $data['t_evening'] ?></td>
        </tr>
<?php
}
?>
     </table>
</div>


<div id="footer"></div> <!--The footer of page-->
</div>
</body>
</html>
