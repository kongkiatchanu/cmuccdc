<?php
include 'config.php';
$sql = "SELECT * FROM tbmember WHERE member_code = '".mysqli_escape_string($mysqli,$_POST["member_code"])."'";
$q = $mysqli->query($sql);
if($q->fetch_assoc()) {
	echo "false";
}
else {
	echo "true";
}
?>