<?php
include 'config.php';
echo $_GET['callback'];
$rs = array();
if($_GET['key']==md5(sha1('signOutz'.date('YmdH')))){
	
	$province = $_GET['provinces'];
	$d_start = $_GET['d_start'];
	$d_end = $_GET['d_end'];
	
	for($i=0; $i<sizeof($province); $i++){
		$sql="SELECT od_hotspot_pv.*,od_province.PROVINCE_ID, od_province.PROVINCE_NAME FROM `od_hotspot_pv` 
			left join od_province ON od_hotspot_pv.pv_id = od_province.PROVINCE_ID
			WHERE od_hotspot_pv.`pv_id` = ".$province[$i]." AND 
			hotspot_datetime BETWEEN '".$d_start." 00:00:00' AND '".$d_end." 23:59:59'";
		$query = $mysqli->query($sql);
		while($row = $query->fetch_assoc())
		{
			array_push($rs,$row);
		}
	}
}
echo "(";
echo json_encode($rs,JSON_NUMERIC_CHECK);
echo ");";
?>
