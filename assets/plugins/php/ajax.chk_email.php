<?php
include 'config.php';
$sql = "SELECT * FROM member WHERE member_email = '".mysqli_escape_string($mysqli,$_POST["member_email"])."'";
$q = $mysqli->query($sql);
if($q->fetch_assoc()) {
	echo "false";
}
else {
	echo "true";
}
?>