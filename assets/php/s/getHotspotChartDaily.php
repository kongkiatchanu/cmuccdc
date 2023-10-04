<?php
include "connect.php";
$rs = array();
$province = $_GET['provinces'];
$s_date = $_GET['s_date'];
$s_duration = $_GET['s_duration'];
if($_GET['key']==md5(sha1('signOutz'.date('YmdH')))){
	
	for($i=0; $i<sizeof($province); $i++){
		$sql="SELECT * FROM `od_province` where PROVINCE_ID = ".$province[$i];

		$q=$mysqli->query($sql);
		$row = $q->fetch_assoc();
		/*
		$timestamp =  strtotime($s_date)-(24*3600)*$s_duration;
		$rsSub = array();
		for ($i = 0 ; $i < $s_duration ; $i++) {
			$date_search =  date('Y-m-d', $timestamp);
			$sql2 = "SELECT pv_id, count(hotspot_id) as totals, DATE_FORMAT(`hotspot_datetime`,'%Y-%m-%d') as log_date  
				FROM `od_hotspot_pv` 
				WHERE `pv_id` = ".$province[$i]." and `hotspot_datetime` like '%".$date_search."%' 
				group by DATE_FORMAT(`hotspot_datetime`, '%Y%m%d')";
			$q2=$mysqli->query($sql2);
			$row2=$q2->fetch_assoc();
			
			array_push($rsSub,$row2);
			$timestamp += 24 * 3600;
		}
		*/
		array_push($rs,$row);
	}
}
?>
<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2",
	title:{
		text: ""
	},
	axisX:{
		valueFormatString: "DD MMM",
		crosshair: {
			enabled: true,
			snapToDataPoint: true
		}
	},
	axisY: {
		title: "จำนวนจุดความร้อน",
		crosshair: {
			enabled: true
		}
	},
	toolTip:{
		shared:true
	},
	data: [
	<?php
	$c=0;
	foreach($rs as $val){
		if($c>0){echo ',';}
		?>
		{
			type: "line",
			showInLegend: true,
			name: "<?=trim($val['PROVINCE_NAME'])?>",
			markerType: "square",
			xValueFormatString: "DD MMM, YYYY",
			dataPoints: [
				<?php
					$pv_id = $val['PROVINCE_ID'];
					$timestamp =  strtotime($s_date)-(24*3600)*$s_duration;
					for ($i = 0 ; $i < $s_duration ; $i++) {
						$date_search =  date('Y-m-d', $timestamp);
						$sql2 = "SELECT pv_id, count(hotspot_id) as totals, DATE_FORMAT(`hotspot_datetime`,'%Y,%m,%d') as log_date  
							FROM `od_hotspot_pv` 
							WHERE `pv_id` = ".$pv_id." and `hotspot_datetime` like '%".$date_search."%' 
							group by DATE_FORMAT(`hotspot_datetime`, '%Y%m%d')";
						
						$q2=$mysqli->query($sql2);
						$row2=$q2->fetch_assoc();
						if($i>0){echo ',';}?>
						{ x: new Date(<?=date('Y,m-1,d', $timestamp);?>), y: <?=$row2['totals']!=''? $row2['totals']:0?> }
					<?php
						$timestamp += 24 * 3600;
					}
				?>
			]
		}
		<?php
		$c++;
	}
	?>
	]
});
chart.render();

function toogleDataSeries(e){
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	} else{
		e.dataSeries.visible = true;
	}
	chart.render();
}

}
</script>
</head>
<body>
<div id="chartContainer" style="height: 450px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>