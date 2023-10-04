<?php 
include "connect.php";
	$sql="SELECT * FROM airinfo ORDER BY air_id ASC ";
	$q=$mysqli->query($sql);
	$air_data = array();
	while($air_detail=$q->fetch_assoc()){
		array_push($air_data,$air_detail);
	}

	echo '<pre>';
	print_r($air_data);
	echo '</pre>';
	
	echo $air_data[0]['air_detail'];
?>