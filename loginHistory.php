<?php
echo "123";
$userId=$_SESSION["userId"];
$sql = "SELECT * FROM users WHERE userid=$userId";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$login=$row["login"];
$ip = '';
if (isset($_SERVER['HTTP_CLIENT_IP']))
    $ip = $_SERVER['HTTP_CLIENT_IP'];
else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
else if(isset($_SERVER['HTTP_X_FORWARDED']))
$ip = $_SERVER['HTTP_X_FORWARDED'];
else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
$ip = $_SERVER['HTTP_FORWARDED_FOR'];
else if(isset($_SERVER['HTTP_FORWARDED']))
$ip = $_SERVER['HTTP_FORWARDED'];
else if(isset($_SERVER['REMOTE_ADDR']))
$ip = $_SERVER['REMOTE_ADDR'];
else
$ip = 'UNKNOWN';
echo $ip;
$date = date('Y-m-d H:i:s');
$sql="Insert into loginhistory VALUES (NULL,$userId,'".$login."'".
        ",'".$date."','".$ip."')";
if (mysqli_query($conn, $sql) === TRUE) {
    ?><script>alert("History is maintained.");</script><?php
} else {
    ?><script>alert("Some Problem has occurred while mainting history");</script><?php
}

?>