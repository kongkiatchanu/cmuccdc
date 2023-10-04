<?php
include 'config.php';
echo $_GET['callback'];
$rs = array();
if($_GET['key']==md5(sha1('signOutz'.date('YmdHi')))){
	$sql="SELECT * FROM `source` WHERE `location_status` = 1 ORDER BY location_id ASC";
	$query = $mysqli->query($sql);
	while($row = $query->fetch_assoc())
	{
		$sqls="SELECT log_pm10,log_pm25,log_datetime FROM log_data_2561 WHERE source_id = ".$row["source_id"]." ORDER BY log_datetime DESC";
		$query2 = $mysqli->query($sqls);
		$row2 = $query2->fetch_assoc();
		array_push($row,$row2);
		array_push($rs,$row);
	}
}
echo "(";
echo json_encode($rs,JSON_NUMERIC_CHECK);
echo ");";
?>
