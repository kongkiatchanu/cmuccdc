<?php 
	include "connect.php";
	
	date_default_timezone_set("Europe/London");
	
	echo $_GET['callback'];
	
	if($_GET["filename"]=="pm10" && !empty($_GET["local"])){
			
			echo "(";
				
				$sql="SELECT source_id, avg(log_pm10) as avg_pm10, avg(log_pm25) as avg_pm25, DATE_FORMAT(log_datetime,'%Y-%m-%d') as log_date  FROM `log_data_2561` WHERE `source_id` = ".mysqli_real_escape_string($mysqli, $_GET["local"])." 
					AND location_status = 1 group by DATE_FORMAT(log_datetime, '%Y%m%d')
					ORDER BY log_datetime ASC LIMIT 7";
				$q=$mysqli->query($sql);
				$data = array();
				while($rs=$q->fetch_assoc())
				{
					$day_array = array( (strtotime($rs["log_date"])+3600) *1000, $rs["avg_pm10"]);
					array_push($data,$day_array);
				}
				echo json_encode($data, JSON_NUMERIC_CHECK);
					
			echo ");";
	}else if($_GET["filename"]=="pm2.5" && !empty($_GET["local"])){
			
			echo "(";
				
				$sql="SELECT source_id, avg(log_pm10) as avg_pm10, avg(log_pm25) as avg_pm25, DATE_FORMAT(log_datetime,'%Y-%m-%d') as log_date  FROM `log_data_2561` WHERE `source_id` = ".mysqli_real_escape_string($mysqli, $_GET["local"])." 
					AND location_status = 1 group by DATE_FORMAT(log_datetime, '%Y%m%d')
					ORDER BY log_datetime ASC LIMIT 7";
				$q=$mysqli->query($sql);
				$data = array();
				while($rs=$q->fetch_assoc())
				{
					$day_array = array( (strtotime($rs["log_date"])+3600) *1000, $rs["avg_pm25"]);
					array_push($data,$day_array);
				}
				echo json_encode($data, JSON_NUMERIC_CHECK);
					
			echo ");";
	}
?>