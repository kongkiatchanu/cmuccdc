<?php 
	include "connect.php";
	if($_GET['key']!=md5('s'.date('ymdh'))){
		exit;
	}
	
	date_default_timezone_set("Europe/London");
	
	echo $_GET['callback'];
	
	
	if($_GET['dd']=="mini"){
		$db = 'log_mini_2561';
	}else{
		$db = 'log_data_2562';
	}
	
	if($_GET["filename"]=="pm10" && !empty($_GET["local"])){
			
			echo "(";
				
				$sql2 = "SELECT count(log_id) as total_row FROM ".$db." WHERE source_id = ".mysqli_real_escape_string($mysqli, $_GET["local"]). " group by DATE_FORMAT(".$db.".log_datetime, '%Y-%m-%d %H')";
				
				$q2=$mysqli->query($sql2);
				$rows = $q2->fetch_assoc();
				$num = $rows['total_row'];
				
				if($num > 2000){
					$stat = $num - 500;
					$sql="SELECT log_datetime,ROUND(avg(".$db.".log_pm10),2) as log_pm10 FROM ".$db." WHERE source_id = ".mysqli_real_escape_string($mysqli, $_GET["local"])." group by DATE_FORMAT(".$db.".log_datetime, '%Y-%m-%d %H') ORDER BY ".$db.".log_datetime ASC LIMIT {$stat},500";
				}else{
					$sql="SELECT log_datetime,ROUND(avg(".$db.".log_pm10),2) as log_pm10 FROM ".$db." WHERE source_id = ".mysqli_real_escape_string($mysqli, $_GET["local"])." group by DATE_FORMAT(".$db.".log_datetime, '%Y-%m-%d %H') ORDER BY ".$db.".log_datetime ASC";
				}
				$q=$mysqli->query($sql);
				$data = array();
				while($rs=$q->fetch_assoc())
				{
					$day_array = array( (strtotime($rs["log_datetime"])) *1000, $rs["log_pm10"]);
					array_push($data,$day_array);
				}
				echo json_encode($data, JSON_NUMERIC_CHECK);
					
			echo ");";
	}else if($_GET["filename"]=="pm2.5" && !empty($_GET["local"])){
			
			echo "(";
				$sql2 = "SELECT count(log_id) as total_row FROM ".$db." WHERE source_id = ".mysqli_real_escape_string($mysqli, $_GET["local"])." group by DATE_FORMAT(".$db.".log_datetime, '%Y-%m-%d %H')";
				
				$q2=$mysqli->query($sql2);
				$rows = $q2->fetch_assoc();
				$num = $rows['total_row'];
				
				if($num > 2000){
					$stat = $num - 500;
					$sql="SELECT log_datetime,ROUND(avg(".$db.".log_pm25),2) as log_pm25 FROM ".$db." WHERE source_id = ".mysqli_real_escape_string($mysqli, $_GET["local"])." group by DATE_FORMAT(".$db.".log_datetime, '%Y-%m-%d %H') ORDER BY ".$db.".log_datetime ASC LIMIT {$stat},500";
				}else{
					$sql="SELECT log_datetime,ROUND(avg(".$db.".log_pm25),2) as log_pm25 FROM ".$db." WHERE source_id = ".mysqli_real_escape_string($mysqli, $_GET["local"])." group by DATE_FORMAT(".$db.".log_datetime, '%Y-%m-%d %H') ORDER BY ".$db.".log_datetime ASC";
				}
				
				$q=$mysqli->query($sql);
				$data = array();
				while($rs=$q->fetch_assoc())
				{
					$day_array = array( (strtotime($rs["log_datetime"])) *1000, $rs["log_pm25"]);
					array_push($data,$day_array);
				}
				echo json_encode($data, JSON_NUMERIC_CHECK);
					
			echo ");";
	}
?>