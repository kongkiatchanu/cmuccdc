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
	
	
	$source_id = mysqli_real_escape_string($mysqli, $_GET['source']);
	$reporttype = mysqli_real_escape_string($mysqli, $_GET['reportType']);
	$dt = mysqli_real_escape_string($mysqli, $_GET['dt']);
	$de = mysqli_real_escape_string($mysqli, $_GET['de']);
	$h_time_start = mysqli_real_escape_string($mysqli, $_GET['h_time_start']);
	$h_time_end = mysqli_real_escape_string($mysqli, $_GET['h_time_end']);

	// $datatype = mysqli_real_escape_string($mysqli, $_GET['dataType']);
	$datatype = $_GET['dataType'];
	$meter_id = $_GET['meter_id'];

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
	// if($rs['version']=="mini"){
	// 	$db = 'log_mini_2561';
	// }else{
	// 	$db = 'log_data_2562';
	// }
	$db = 'meter_data';

	// echo '<pre>';
	// print_r($rs);
	// print_r($reporttype.' ');
	// print_r($datatype);
	// echo '</pre>';
	// exit();
	
	date_default_timezone_set("Europe/London");
	if($reporttype=="d"){
		if($datatype=="sensor_energy_kWh"){	
			$table_head='Accumulated electricity consumption (kWh)';
			$sql="SELECT data_id,meter_id, round(".$db.".".$datatype.",2) as value, data_time as log_date 
				FROM ".$db." 
				WHERE ".$db.".meter_id =".$meter_id."
				group by data_time
				ORDER BY ".$db.".data_time ASC ";
			$q=$mysqli->query($sql);
			
			while($rs = $q->fetch_assoc()){
				$day_array = array( (strtotime($rs["log_date"])+ 60*60) *1000, $rs["value"]);
				array_push($data,$day_array);
			}
		}
	}
	
	echo $_GET['callback'];
	echo "(";
	echo json_encode($data, JSON_NUMERIC_CHECK);
	echo ");";