<?php
include "connect.php";
$rs = array();
$province = $_GET['provinces'];
$s_year = $_GET['s_year'];
$s_type = $_GET['s_type'];
if($_GET['key']==md5(sha1('signOutz'.date('YmdH')))){
	
	for($i=0; $i<sizeof($province); $i++){
		$sql="SELECT * FROM `od_province` where PROVINCE_ID = ".$province[$i];
		$q=$mysqli->query($sql);
		$row = $q->fetch_assoc();
		array_push($rs,$row);
	}

}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
</head>
<body>
	<div id="chart_container" height="550"></div>
</body>
<script>
Highcharts.chart('chart_container', {
	lang: {
        thousandsSep: ','
    },
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    xAxis: {
        categories: [
		<?php $i=0;for ($x = $s_year; $x <= 2018 ; $x++) {if($i>0){echo ',';}?>
			'<?=$x?>'
		<?php $i++;}?>
		],
        crosshair: true
    },
	credits: { enabled: false},
    yAxis: {
        min: 0,
        title: {
            text: 'จำนวนจุดความร้อน'
        }
    },
    tooltip: {
		<?php if($s_type=='bar'){?>
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.0f} จุด</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
		<?php }else{?>
		headerFormat: '<b>{point.x}</b><br/>',
        pointFormat: 'จังหวัด{series.name}: {point.y:.0f} จุด<br/>จุดความร้อนรวมทั้งหมด : {point.stackTotal} จุด',
		<?php }?>
    },
	
    plotOptions: {
        column: {
            <?php if($s_type=='bar'){?>
			pointPadding: 0.2,borderWidth: 0
			<?php }else{?>
			stacking: 'normal',dataLabels: {enabled: true,color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'}
			<?php }?>
		}
    },
    series: [
		<?php
		$c=0;
		foreach($rs as $val){
			if($c>0){echo ',';}
			?>	
			{
				name: '<?=trim($val['PROVINCE_NAME'])?>',
				data: [
			<?php
				$pv_id = $val['PROVINCE_ID'];
				$j=0;
				for ($x = $s_year; $x <= 2018 ; $x++) {
					$sql2 = "SELECT pv_id, count(hotspot_id) as totals, DATE_FORMAT(`hotspot_datetime`,'%Y') as log_date  
						FROM `od_hotspot_pv` 
						WHERE `pv_id` = ".$pv_id." and `hotspot_datetime` like '%".$x."%' 
						group by DATE_FORMAT(`hotspot_datetime`, '%Y')";
					$q2=$mysqli->query($sql2);
					$row2=$q2->fetch_assoc();
					if($j>0){echo ',';}?>
					<?=$row2['totals']!=''? $row2['totals']:0?>
					<?php
					$j++;
				}
			?>			
				]
			}
		<?php $c++; }?>
	]
});
</script>


</html>