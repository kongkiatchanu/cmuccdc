<?php 
	include "connect.php";
	
	date_default_timezone_set("Europe/London");
	
	echo $_GET['callback'];
	
	if($_GET["filename"]=="PM10"){
			
			echo "(";
				/*
				$sql2 = "SELECT count(log_id) as total_row FROM log_data_2562 WHERE source_id = ".mysqli_real_escape_string($mysqli, $_GET["local"]);
				
				$q2=$mysqli->query($sql2);
				$rows = $q2->fetch_assoc();
				$num = $rows['total_row'];*/
				

				$sql="SELECT log_datetime,log_pm10 
				FROM log_data_2562 
				left join source on log_data_2562.source_id = source.source_id
				WHERE 
				log_data_2562.source_id = ".mysqli_real_escape_string($mysqli, $_GET["local"])." AND 
				source.is_cnx= ".$_GET['g']." AND
				log_data_2562.log_datetime 
					BETWEEN ( DATE_SUB( NOW() , INTERVAL 7 day  ) )
					AND ( NOW() )
				group by DATE_FORMAT(log_data_2562.log_datetime, '%Y-%m-%d %H')
				ORDER BY log_data_2562.log_datetime ASC";
			
				$q=$mysqli->query($sql);
				$data = array();
				while($rs=$q->fetch_assoc())
				{
					$newstring = substr($rs["log_datetime"],0,17)."00";
					$day_array = array( (strtotime($newstring)+180) *1000, $rs["log_pm10"]);
					array_push($data,$day_array);
				}
				echo json_encode($data, JSON_NUMERIC_CHECK);
					
			echo ");";
	}else if($_GET["filename"]=="PM25" && !empty($_GET["local"])){
			
			echo "(";
			/*
				$sql2 = "SELECT count(log_id) as total_row FROM log_data_2562 WHERE source_id = ".mysqli_real_escape_string($mysqli, $_GET["local"]);
				
				$q2=$mysqli->query($sql2);
				$rows = $q2->fetch_assoc();
				$num = $rows['total_row'];
				*/
				
				$sql="SELECT log_datetime,log_pm25   
				FROM log_data_2562 
				left join source on log_data_2562.source_id = source.source_id
				WHERE 
				log_data_2562.source_id = ".mysqli_real_escape_string($mysqli, $_GET["local"])." AND 
				source.is_cnx= ".$_GET['g']." AND
				log_data_2562.log_datetime 
					BETWEEN ( DATE_SUB( NOW() , INTERVAL 7 day  ) )
					AND ( NOW() )
				group by DATE_FORMAT(log_data_2562.log_datetime, '%Y-%m-%d %H')
				ORDER BY log_data_2562.log_datetime ASC";
				
				$q=$mysqli->query($sql);
				$data = array();
				while($rs=$q->fetch_assoc())
				{
					$newstring = substr($rs["log_datetime"],0,17)."00";
					$day_array = array( (strtotime($newstring)+180) *1000, $rs["log_pm25"]);
					array_push($data,$day_array);
				}
				echo json_encode($data, JSON_NUMERIC_CHECK);
					
			echo ");";
	}
?>