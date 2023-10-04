<?php
include 'config.php';
$sql = "SELECT * FROM page WHERE page_rewrite = '".mysqli_escape_string($mysqli,$_POST["page_rewrite"])."'";
$q = $mysqli->query($sql);
if($q->fetch_assoc()) {
	echo "false";
}
else {
	echo "true";
}
?>