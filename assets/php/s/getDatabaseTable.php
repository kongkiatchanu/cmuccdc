<?php
	header('Access-Control-Allow-Origin: https://www.cmuccdc.org');
	include "connect.php";
	$mm =array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
	$source_id = mysqli_real_escape_string($mysqli, $_GET['source']);
	$datatype = mysqli_real_escape_string($mysqli, $_GET['dataType']);
	$reporttype = mysqli_real_escape_string($mysqli, $_GET['reportType']);
	$dt = mysqli_real_escape_string($mysqli, $_GET['dt']);
	$de = mysqli_real_escape_string($mysqli, $_GET['de']);
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
		$h_time_start = mysqli_real_escape_string($mysqli, $_GET['h_time_start']).":00";
		$h_time_end = mysqli_real_escape_string($mysqli, $_GET['h_time_end']).":59";
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
				array_push($data,$rs);
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
				array_push($data,$rs);
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
				array_push($data,$rs);
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
				array_push($data,$rs);
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
				array_push($data,$rs);
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
				array_push($data,$rs);
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
				array_push($data,$rs);
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
				array_push($data,$rs);
			}
		}
	}else if($reporttype=="m"){
		$fm = mysqli_real_escape_string($mysqli, $_GET['fm']);
		$lm = mysqli_real_escape_string($mysqli, $_GET['lm']);
		if($datatype=="pm25"){	
			$table_head='PM2.5 (ug/m3)';
			$sql="SELECT source.location_id, source.location_name, source.source_id, round(avg(".$db.".log_pm25),2) as avg_value, DATE_FORMAT(log_datetime,'%Y-%m') as log_date 
				FROM ".$db." 
				left join source on ".$db.".source_id = source.source_id
				WHERE ".$db.".source_id =".$source_id." AND
				".$db.".log_datetime 
				BETWEEN '{$fm}-01 00:00:00' AND '{$lm}-01 23:59:59'
				group by DATE_FORMAT(".$db.".log_datetime, '%Y-%m') 
				ORDER BY ".$db.".log_datetime ASC ";
				//echo $sql;
			$q=$mysqli->query($sql);
			while($rs = $q->fetch_assoc()){
				$rs['log_date'] = $mm[(substr($rs['log_date'],5,2)*1)-1];
				array_push($data,$rs);
			}
		}else if($datatype=="pm10"){
			$table_head='PM10 (ug/m3)';
			$sql="SELECT source.location_id, source.location_name, source.source_id, round(avg(".$db.".log_pm10),2) as avg_value, DATE_FORMAT(log_datetime,'%Y-%m') as log_date 
				FROM ".$db." 
				left join source on ".$db.".source_id = source.source_id
				WHERE ".$db.".source_id =".$source_id." AND
				".$db.".log_datetime 
				BETWEEN '{$fm}-01 00:00:00' AND '{$lm}-01 23:59:59'
				group by DATE_FORMAT(".$db.".log_datetime, '%Y-%m') 
				ORDER BY ".$db.".log_datetime ASC ";
			$q=$mysqli->query($sql);
			while($rs = $q->fetch_assoc()){
				$rs['log_date'] = $mm[(substr($rs['log_date'],5,2)*1)-1];
				array_push($data,$rs);
			}
		}else if($datatype=="temp"){
			$table_head='Temperature (c)';
			$sql="SELECT source.location_id, source.location_name, source.source_id, round(avg(".$db.".temp),2) as avg_value, DATE_FORMAT(log_datetime,'%Y-%m') as log_date 
				FROM ".$db." 
				left join source on ".$db.".source_id = source.source_id
				WHERE ".$db.".source_id =".$source_id." AND
				".$db.".log_datetime 
				BETWEEN '{$fm}-01 00:00:00' AND '{$lm}-01 23:59:59'
				group by DATE_FORMAT(".$db.".log_datetime, '%Y-%m') 
				ORDER BY ".$db.".log_datetime ASC ";
			$q=$mysqli->query($sql);
			while($rs = $q->fetch_assoc()){
				$rs['log_date'] = $mm[(substr($rs['log_date'],5,2)*1)-1];
				array_push($data,$rs);
			}
		}else if($datatype=="humid"){
			$table_head='Humidity (RH)';
			$sql="SELECT source.location_id, source.location_name, source.source_id, avg(".$db.".humid) as avg_value, DATE_FORMAT(log_datetime,'%Y-%m') as log_date 
				FROM ".$db." 
				left join source on ".$db.".source_id = source.source_id
				WHERE ".$db.".source_id =".$source_id." AND
				".$db.".log_datetime 
				BETWEEN '{$fm}-01 00:00:00' AND '{$lm}-01 23:59:59'
				group by DATE_FORMAT(".$db.".log_datetime, '%Y-%m') 
				ORDER BY ".$db.".log_datetime ASC ";
			$q=$mysqli->query($sql);
			while($rs = $q->fetch_assoc()){
				$rs['log_date'] = $mm[(substr($rs['log_date'],5,2)*1)-1];
				array_push($data,$rs);
			}
		}
	}

?>
<h3>Table Result</h3><hr/>
<table class="table text-center">
		<thead>
			<tr class="table-info">
				<th class="align-middle">DustBoy</th>
				<th class="align-middle">Date time</th>
				<th class="align-middle"><?=$table_head?></th>
			</tr>
		</thead>
		<tbody>
		<?php 
			$count =0;
			$total_avg =0;
			$total_max =0;
			$total_min =1000;
		?>
		<?php for($i=0;$i<count($data);$i++){?>
		<?php 
			if($total_max <= $data[$i]['avg_value']){
				$total_max = $data[$i]['avg_value'];
			}
			if($total_min > $data[$i]['avg_value']){
				$total_min = $data[$i]['avg_value'];
			}
			$total_avg+=$data[$i]['avg_value'];
			$count++;
		?>
			<tr>
				<td class="text-left"><?=$data[$i]['location_name']?> </td>
				<td><?=$data[$i]['log_date']?></td>
				<td><?=$data[$i]['avg_value']?></td>
			</tr>
		<?php }?>
			<tr class="table-info">
				<th colspan="2">Min</th>
				<th><?=$total_min?></th>
			</tr>
			<tr class="table-info">
				<th colspan="2">Max</th>
				<th><?=$total_max?></th>
			</tr>
			<tr class="table-info">
				<th colspan="2">AVG</th>
				<th><?=number_format(($total_avg/$count),2)?></th>
			</tr>
		</tbody>
	</table>