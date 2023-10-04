<?php 
	include 'connect.php';
	if($_GET['key']!=md5('s'.date('ymdh'))){
		exit;
	}
	
	function map($v,$v1,$v2,$a1,$a2){
		return round($a1+ ($a2-$a1)*($v-$v1)/($v2-$v1));
	}

	function calAQIPM25($val){
		if(round($val)<=25){
			$data =map(round($val),0,25,0,25);
		}else if(round($val)>25 && round($val)<=37){
			$data = map(round($val),26,37,26,50);
		}else if(round($val)>37 && round($val)<=50){
			$data = map(round($val),38,50,51,100);
		}else if(round($val)>50 && round($val)<=90){
			$data = map(round($val),51,90,101,200);
		}else if(round($val)>90){
			$data = round($val)-90+200;
		}
		return $data;
	}
	
	function usPM25AQI($val){
		$data = 0;
		if($val>0){
			if($val<=12){
				$data=(((50-0)*($val-0))/(12-0))+0;
			}
			else if( ($val<=35.4) && ($val>12) ){
				$data=(((100-50)*($val-12))/(35.4-12))+50;
			}
			else if( ($val<=55.4) && ($val>35.4) ){
				$data=(((150-100)*($val-35.4))/(55.4-35.4))+100;
			}
			else if( ($val<=150.4) && ($val>55.4) ){
				$data=(((200-150)*($val-55.4))/(150.4-55.4))+150;
			}
			else if( ($val<=250.4) && ($val>150.4) ){
				$data=(((300-200)*($val-150.4))/(250.4-150.4))+200;
			}
			else if( ($val<=350.4) && ($val>250.4) ){
				$data=(((400-300)*($val-250.4))/(350.4-250.4))+300;
			}
			else if( ($val>350.4) ){
				$data=(((500-400)*($val-350.4))/(500.4-350.4))+400;
			}
			return ceil($data);
		}
	}
	
	
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
	
	
	date_default_timezone_set("Europe/London");
	if($reporttype=="h"){
		if($datatype=="pm25"){	

			$table_head='PM2.5 (ug/m3)';
			$sql="SELECT source.location_id, source.location_name, source.source_id, round(avg(".$db.".log_pm25),2) as avg_value, DATE_FORMAT(log_datetime,'%Y-%m-%d %H') as log_date 
				FROM ".$db." 
				left join source on ".$db.".source_id = source.source_id
				WHERE ".$db.".source_id =".$source_id." AND
				".$db.".log_datetime 
				BETWEEN '{$dt} 00:00:00' AND '{$h_time_end}:59:59'
				group by DATE_FORMAT(".$db.".log_datetime, '%Y-%m-%d %H') 
				ORDER BY ".$db.".log_datetime ASC ";
			//echo $sql;
			$q=$mysqli->query($sql);
			while($rs = $q->fetch_assoc()){
				$rs['log_date'] = $rs['log_date'].':00:00';
				$day_array = array( (strtotime($rs["log_date"])+ 60*60) *1000, ceil($rs["avg_value"]));
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
				$day_array = array( (strtotime($rs["log_date"])) *1000, $rs["avg_value"]);
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
				$day_array = array( (strtotime($rs["log_date"])) *1000, ceil($rs["avg_value"]));
				array_push($data,$day_array);
			}
		}else if($datatype=="pm25thaqi"){
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
				$day_array = array( (strtotime($rs["log_date"])) *1000, usPM25AQI(ceil($rs["avg_value"])));
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
	
	echo $_GET['callback'];
	echo "(";
	echo json_encode($data, JSON_NUMERIC_CHECK);
	echo ");";