<?php 
header('Content-Type: text/html; charset=UTF-8');
include "connect.php";
if($_GET["source"] && $_GET["dateStart"] && $_GET["dateEnd"] ){
	
	if($_GET["type"]==1){
		$db = 'log_data';
	}else if($_GET["type"]==2){
		$db = 'log_data_hour';
	}else if($_GET["type"]==3){
		$db = 'log_data_day';
	}else{
		$db = 'log_data_2562';
	}
	
	$tmp = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
	$tmp .= '<table border="1">';
	$tmp .= "<tr>";
	$tmp .= "<th>no.</th>";
	$tmp .= "<th>location</th>";
	$tmp .= "<th>date</th>";
	$tmp .= "<th>time</th>";
	$tmp .= "<th>pm 10</th>";
	$tmp .= "<th>pm 2.5</th>";
	$tmp .= "</tr>";

	$date1 = explode("/", $_GET["dateStart"]);
	$date2 = explode("/", $_GET["dateEnd"]);
		
	$SOURCE_ID = (int)$_GET["source"];
	$DATE_START = $date1[2]."-".$date1[1]."-".$date1[0]." 00:00:00";
	$DATE_END = $date2[2]."-".$date2[1]."-".$date2[0]. " 23:59:59";
	
	if($_GET["datatype"]=="s"){
		$sql = "SELECT source.location_name, ".$db.".* FROM source 
				LEFT JOIN ".$db." ON 
					".$db.".source_id = source.source_id
				WHERE 
					source.source_id =".$SOURCE_ID." AND
					".$db.".log_datetime BETWEEN '".$DATE_START."' AND '".$DATE_END."'
				ORDER BY ".$db.".log_datetime ASC";
		$result = $mysqli->query($sql);
	}else if($_GET["datatype"]=="h"){
		$sql="SELECT source.location_name,round(avg(log_data_2562.log_pm10),2) as log_pm10, round(avg(log_data_2562.log_pm25),2) as log_pm25, log_data_2562.log_datetime, DATE_FORMAT(log_datetime,'%d/%m/%Y %H') as g_date FROM `log_data_2562` 
			left join source ON source.source_id =log_data_2562.source_id
			WHERE source.source_id=".$SOURCE_ID." and log_datetime >= '".$DATE_START."' and log_datetime <= '".$DATE_END."'
			group by DATE_FORMAT(log_data_2562.log_datetime, '%Y-%m-%d %H') ";
		$result = $mysqli->query($sql);
	}else if($_GET["datatype"]=="d"){
		$sql="SELECT source.location_name,round(avg(log_data_2561.log_pm10),2) as log_pm10, round(avg(log_data_2561.log_pm25),2) as log_pm25, log_data_2561.log_datetime, DATE_FORMAT(log_datetime,'%d/%m/%Y') as g_date FROM `log_data_2561` 
			left join source ON source.source_id =log_data_2561.source_id
			WHERE source.source_id=".$SOURCE_ID." and log_datetime >= '".$DATE_START."' and log_datetime <= '".$DATE_END."'
			group by DATE_FORMAT(log_datetime, '%Y%m%d')";
		$result = $mysqli->query($sql);
	}
		
	
	$i = 0;
	while($row = $result->fetch_assoc()) {
		$t = '-';
		if($_GET["datatype"]=="s"){
			$t=substr($row["log_datetime"],11,8);
		}
		$tmp .= "<tr>";
		$tmp .= "<td nowrap>".++$i."</td>";
		$tmp .= "<td nowrap>".$row["location_name"]."</td>";
		$tmp .= "<td nowrap>".substr($row["log_datetime"],8,2)."/".substr($row["log_datetime"],5,2)."/".substr($row["log_datetime"],0,4)."</td>";
		$tmp .= "<td nowrap>".$t."</td>";
		$tmp .= "<td nowrap>".number_format($row["log_pm10"], 6, '.', '')."</td>";
		$tmp .= "<td nowrap>".number_format($row["log_pm25"], 6, '.', '')."</td>";
		$tmp .= "</tr>";

	}
	
	$tmp .= "</table>";

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"".basename("export_stat.xls")."\"");
header("Pragma: no-cache");
header("Expires: 0");

echo $tmp;
}
?>