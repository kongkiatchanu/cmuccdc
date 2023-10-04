<?php
include 'connect.php';
$sql = "SELECT * FROM source WHERE location_uri = '".mysqli_escape_string($mysqli,$_POST["location_uri"])."'";
$q = $mysqli->query($sql);
if($q->fetch_assoc()) {
	echo "false";
}
else {
	echo "true";
}
?>