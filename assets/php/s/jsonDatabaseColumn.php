<?php 
	include 'connect.php';
	if($_GET['key']!=md5('s'.date('ymdh'))){
		exit;
	}
	date_default_timezone_set("Europe/London");
	echo $_GET['callback'];
	
	$source_id = mysqli_real_escape_string($mysqli, $_GET['source']);
	$datatype = mysqli_real_escape_string($mysqli, $_GET['dataType']);
	$reporttype = mysqli_real_escape_string($mysqli, $_GET['reportType']);
	$dt = mysqli_real_escape_string($mysqli, $_GET['dt']);
	$de = mysqli_real_escape_string($mysqli, $_GET['de']);
	$h_time_start = mysqli_real_escape_string($mysqli, $_GET['h_time_start']);
	$h_time_end = mysqli_real_escape_string($mysqli, $_GET['h_time_end']);
	$data = array();
	
	$sql="SELECT * FROM source WHERE source_id =".$source_id;
	$q=$mysqli->query($sql);
	if($q->num_rows)
	{
		$rs=$q->fetch_assoc();
	}else{
		header("Location: /");
		exit();
	}
	
	if($rs['version']=="mini"){
		$db = 'log_mini_2561';
	}else{
		$db = 'log_data_2562';
	}
	
	if($reporttype=="h"){
		if($datatype=="pm25"){	
			$table_head='PM2.5 (ug/m3)';
			$sql="SELECT source.location_id, source.location_name, source.source_id, round(avg(".$db.".log_pm25),2) as avg_value, DATE_FORMAT(log_datetime,'%Y-%m-%d %H') as log_date 
				FROM ".$db." 
				left join source on ".$db.".source_id = source.source_id
				WHERE ".$db.".source_id =".$source_id." AND
				".$db.".log_datetime 
				BETWEEN '{$dt} {$h_time_start}' AND '{$de} {$h_time_end}'
				group by DATE_FORMAT(".$db.".log_datetime, '%Y-%m-%d %H') 
				ORDER BY ".$db.".log_datetime ASC ";
			$q=$mysqli->query($sql);
			while($rs = $q->fetch_assoc()){
				$rs['log_date'] = $rs['log_date'].':00:00';
				$day_array = array( (strtotime($rs["log_date"])+60*60) *1000, ceil($rs["avg_value"]));
				array_push($data,$day_array);
			}
		}else if($datatype=="pm10"){
			$table_head='PM10 (ug/m3)';
			$sql="SELECT source.location_id, source.location_name, source.source_id, round(avg(".$db.".log_pm10),2) as avg_value, DATE_FORMAT(log_datetime,'%Y-%m-%d %H') as log_date 
				FROM ".$db." 
				left join source on ".$db.".source_id = source.source_id
				WHERE ".$db.".source_id =".$source_id." AND
				".$db.".log_datetime 
				BETWEEN '{$dt} {$h_time_start}' AND '{$de} {$h_time_end}'
				group by DATE_FORMAT(".$db.".log_datetime, '%Y-%m-%d %H') 
				ORDER BY ".$db.".log_datetime ASC ";
			$q=$mysqli->query($sql);
			while($rs = $q->fetch_assoc()){
				$rs['log_date'] = $rs['log_date'].':00:00';
				$day_array = array( (strtotime($rs["log_date"])+60*60) *1000, $rs["avg_value"]);
				array_push($data,$day_array);
			}
		}else if($datatype=="temp"){
			$table_head='Temperature (c)';
			$sql="SELECT source.location_id, source.location_name, source.source_id, round(avg(".$db.".temp),2) as avg_value, DATE_FORMAT(log_datetime,'%Y-%m-%d %H') as log_date 
				FROM ".$db." 
				left join source on ".$db.".source_id = source.source_id
				WHERE ".$db.".source_id =".$source_id." AND
				".$db.".log_datetime 
				BETWEEN '{$dt} {$h_time_start}' AND '{$de} {$h_time_end}'
				group by DATE_FORMAT(".$db.".log_datetime, '%Y-%m-%d %H') 
				ORDER BY ".$db.".log_datetime ASC ";
			$q=$mysqli->query($sql);
			while($rs = $q->fetch_assoc()){
				$rs['log_date'] = $rs['log_date'].':00:00';
				$day_array = array( (strtotime($rs["log_date"])) *1000, $rs["avg_value"]);
				array_push($data,$day_array);
			}
		}else if($datatype=="humid"){
			$table_head='Humidity (RH)';
			$sql="SELECT source.location_id, source.location_name, source.source_id, avg(".$db.".humid) as avg_value, DATE_FORMAT(log_datetime,'%Y-%m-%d %H') as log_date 
				FROM ".$db." 
				left join source on ".$db.".source_id = source.source_id
				WHERE ".$db.".source_id =".$source_id." AND
				".$db.".log_datetime 
				BETWEEN '{$dt} {$h_time_start}' AND '{$de} {$h_time_end}'
				group by DATE_FORMAT(".$db.".log_datetime, '%Y-%m-%d %H') 
				ORDER BY ".$db.".log_datetime ASC ";
			$q=$mysqli->query($sql);
			while($rs = $q->fetch_assoc()){
				$rs['log_date'] = $rs['log_date'].':00:00';
				$day_array = array( (strtotime($rs["log_date"])) *1000, $rs["avg_value"]);
				array_push($data,$day_array);
			}
		}
		
	}else if($reporttype=="d"){
		if($datatype=="pm25"){	
			$table_head='PM2.5 (ug/m3)';
			$sql="SELECT source.location_id, source.location_name, source.source_id, round(avg(".$db.".log_pm25),2) as avg_value, DATE_FORMAT(log_datetime,'%Y-%m-%d') as log_date 
				FROM ".$db." 
				left join source on ".$db.".source_id = source.source_id
				WHERE ".$db.".source_id =".$source_id." AND
				".$db.".log_datetime 
				BETWEEN '{$dt} 00:00:00' AND '{$de} 23:59:59'
				group by DATE_FORMAT(".$db.".log_datetime, '%Y-%m-%d') 
				ORDER BY ".$db.".log_datetime ASC ";
			$q=$mysqli->query($sql);
			while($rs = $q->fetch_assoc()){
				$day_array = array( (strtotime($rs["log_date"])) *1000, $rs["avg_value"]);
				array_push($data,$day_array);
			}
		}else if($datatype=="pm10"){
			$table_head='PM10 (ug/m3)';
			$sql="SELECT source.location_id, source.location_name, source.source_id, round(avg(".$db.".log_pm10),2) as avg_value, DATE_FORMAT(log_datetime,'%Y-%m-%d') as log_date 
				FROM ".$db." 
				left join source on ".$db.".source_id = source.source_id
				WHERE ".$db.".source_id =".$source_id." AND
				".$db.".log_datetime 
				BETWEEN '{$dt} 00:00:00' AND '{$de} 23:59:59'
				group by DATE_FORMAT(".$db.".log_datetime, '%Y-%m-%d') 
				ORDER BY ".$db.".log_datetime ASC ";
			$q=$mysqli->query($sql);
			while($rs = $q->fetch_assoc()){
				$day_array = array( (strtotime($rs["log_date"])) *1000, $rs["avg_value"]);
				array_push($data,$day_array);
			}
		}else if($datatype=="temp"){
			$table_head='Temperature (c)';
			$sql="SELECT source.location_id, source.location_name, source.source_id, round(avg(".$db.".temp),2) as avg_value, DATE_FORMAT(log_datetime,'%Y-%m-%d') as log_date 
				FROM ".$db." 
				left join source on ".$db.".source_id = source.source_id
				WHERE ".$db.".source_id =".$source_id." AND
				".$db.".log_datetime 
				BETWEEN '{$dt} 00:00:00' AND '{$de} 23:59:59'
				group by DATE_FORMAT(".$db.".log_datetime, '%Y-%m-%d') 
				ORDER BY ".$db.".log_datetime ASC ";
			$q=$mysqli->query($sql);
			while($rs = $q->fetch_assoc()){
				$day_array = array( (strtotime($rs["log_date"])) *1000, $rs["avg_value"]);
				array_push($data,$day_array);
			}
		}else if($datatype=="humid"){
			$table_head='Humidity (RH)';
			$sql="SELECT source.location_id, source.location_name, source.source_id, avg(".$db.".humid) as avg_value, DATE_FORMAT(log_datetime,'%Y-%m-%d') as log_date 
				FROM ".$db." 
				left join source on ".$db.".source_id = source.source_id
				WHERE ".$db.".source_id =".$source_id." AND
				".$db.".log_datetime 
				BETWEEN '{$dt} 00:00:00' AND '{$de} 23:59:59'
				group by DATE_FORMAT(".$db.".log_datetime, '%Y-%m-%d') 
				ORDER BY ".$db.".log_datetime ASC ";
			$q=$mysqli->query($sql);
			while($rs = $q->fetch_assoc()){
				$day_array = array( (strtotime($rs["log_date"])) *1000, $rs["avg_value"]);
				array_push($data,$day_array);
			}
		}
	}else if($reporttype=="m"){
		if($datatype=="pm25"){	
			$table_head='PM2.5 (ug/m3)';
			$sql="SELECT source.location_id, source.location_name, source.source_id, round(avg(".$db.".log_pm25),2) as avg_value, DATE_FORMAT(log_datetime,'%Y-%m') as log_date 
				FROM ".$db." 
				left join source on ".$db.".source_id = source.source_id
				WHERE ".$db.".source_id =".$source_id." AND
				".$db.".log_datetime 
				BETWEEN '{$dt}-01 00:00:00' AND '{$de}-01 23:59:59'
				group by DATE_FORMAT(".$db.".log_datetime, '%Y-%m') 
				ORDER BY ".$db.".log_datetime ASC ";
			$q=$mysqli->query($sql);
			while($rs = $q->fetch_assoc()){
				$rs['log_date'] = $rs['log_date'].'-01'.date('H:i:s');
				$day_array = array( (strtotime($rs["log_date"])) *1000, $rs["avg_value"]);
				array_push($data,$day_array);
			}
		}else if($datatype=="pm10"){
			$table_head='PM10 (ug/m3)';
			$sql="SELECT source.location_id, source.location_name, source.source_id, round(avg(".$db.".log_pm10),2) as avg_value, DATE_FORMAT(log_datetime,'%Y-%m') as log_date 
				FROM ".$db." 
				left join source on ".$db.".source_id = source.source_id
				WHERE ".$db.".source_id =".$source_id." AND
				".$db.".log_datetime 
				BETWEEN '{$dt}-01 00:00:00' AND '{$de}-01 23:59:59'
				group by DATE_FORMAT(".$db.".log_datetime, '%Y-%m') 
				ORDER BY ".$db.".log_datetime ASC ";
			$q=$mysqli->query($sql);
			while($rs = $q->fetch_assoc()){
				$rs['log_date'] = $rs['log_date'].'-01'.date('H:i:s');
				$day_array = array( (strtotime($rs["log_date"])) *1000, $rs["avg_value"]);
				array_push($data,$day_array);
			}
		}else if($datatype=="temp"){
			$table_head='Temperature (c)';
			$sql="SELECT source.location_id, source.location_name, source.source_id, round(avg(".$db.".temp),2) as avg_value, DATE_FORMAT(log_datetime,'%Y-%m') as log_date 
				FROM ".$db." 
				left join source on ".$db.".source_id = source.source_id
				WHERE ".$db.".source_id =".$source_id." AND
				".$db.".log_datetime 
				BETWEEN '{$dt}-01 00:00:00' AND '{$de}-01 23:59:59'
				group by DATE_FORMAT(".$db.".log_datetime, '%Y-%m') 
				ORDER BY ".$db.".log_datetime ASC ";
			$q=$mysqli->query($sql);
			while($rs = $q->fetch_assoc()){
				$rs['log_date'] = $rs['log_date'].'-01'.date('H:i:s');
				$day_array = array( (strtotime($rs["log_date"])) *1000, $rs["avg_value"]);
				array_push($data,$day_array);
			}
		}else if($datatype=="humid"){
			$table_head='Humidity (RH)';
			$sql="SELECT source.location_id, source.location_name, source.source_id, avg(".$db.".humid) as avg_value, DATE_FORMAT(log_datetime,'%Y-%m') as log_date 
				FROM ".$db." 
				left join source on ".$db.".source_id = source.source_id
				WHERE ".$db.".source_id =".$source_id." AND
				".$db.".log_datetime 
				BETWEEN '{$dt}-01 00:00:00' AND '{$de}-01 23:59:59'
				group by DATE_FORMAT(".$db.".log_datetime, '%Y-%m') 
				ORDER BY ".$db.".log_datetime ASC ";
			$q=$mysqli->query($sql);
			while($rs = $q->fetch_assoc()){
				$rs['log_date'] = $rs['log_date'].'-01'.date('H:i:s');
				$day_array = array( (strtotime($rs["log_date"])) *1000, $rs["avg_value"]);
				array_push($data,$day_array);
			}
		}
	}
	
	echo "(";
	echo json_encode($data, JSON_NUMERIC_CHECK);
	echo ");";