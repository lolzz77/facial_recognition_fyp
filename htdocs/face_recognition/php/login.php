<?php

include_once('connect_database.php');

$username = $_POST['username'];
$password = $_POST['password'];

    $sql =
    "SELECT *
    FROM account
    WHERE user_id='$username' AND
    password='$password'";
    $result = $conn->query($sql);
    $acc_id = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) > 0){
        $json['success']=1;
        $json['acc_id']=$acc_id["ACC_ID"];
    }
    else
        $json['success']=0;

if($json['success']==1) {
    header('Location: /face_recognition/welcome.html');
}
else
    echo "<br>";
    echo "System Login Failed: Wrong username and password";


echo "<br>";
echo "<button onclick='history.back()'>Back</button>";

?>
