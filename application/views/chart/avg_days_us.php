<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	$subch = substr($ch,2,2);

	function getValue($val, $ch){
		if($ch=="pm25aqi"){
			return calAQIPM25($val);
		}else if($ch=="pm10aqi"){
			return calAQIPM10($val);
		}else if($ch=="pm25"){
			return $val;
		}else{
			return $val;
		}
	}
	function getValueAQI($val, $ch){
		if($val>0){
		if($ch=="pm25aqi"){
			return calAQIPM25($val);
		}else if($ch=="pm25"){
			return number_format($val,2);
		}else if($ch=="pm10aqi" || $ch=="pm10"){
			return calAQIPM10($val);
		}else if($ch=="pm25usaqi"){
			return usPM25AQI($val);
		}
		}else{return 0;}
	}
	
	function report_typeUSAQI3($val){
		$data = 0;
		if($val>0){
			if($val<=50){
				$data=0;
			}
			else if(($val<=100) && ($val>50)){
				$data=1;
			}
			else if(($val<=150) && ($val>100)){
				$data=2;
			}
			else if(($val<=200) && ($val>150)){
				$data=3;
			}
			else if(($val<=300) && ($val>200)){
				$data=4;
			}
			else if(($val<=500) && ($val>300)){
				$data=5;
			}
			else if(($val>500)){
				$data=6;
			}
			
		}
		return $data;
	}
	
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>CCDC</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>

</head>
<style>
.tooltop{
	background-color:#1E90FF;
	color:#333;
	padding:10px;
	border: 1px solid;
    border-radius: 10px;
	padding-top:5%;		
}
.boxtool_mod{background-color:#00FF00;}
.boxtool_sen{background-color:yellow;}
.boxtool_unheal{background-color:orange;}
.boxtool_haz{background-color:red;}
#chart_container{height:350px !important;}
</style>
<body>
	<?php 
	$rsDAVG = (array)$rsDAVG;
	$rsList =array();
	$timestamp =  strtotime(date('Y-m-d'))-604800;
	for ($i = 0 ; $i < 7 ; $i++) {
		$date_search =  date('Y-m-d', $timestamp);
	
		$row=array();
		foreach($rsDAVG[0]->value as $item){
			
			if($item->log_date==$date_search){
				$row = (array)$item;
			}
			
		}
		if($row==null){
			$row = array(
				'avg_pm10'=>null,
				'avg_pm25'=>null,
				'temp'=>null,
				'humid'=>null,
				'log_date'=>$date_search
			);
		}
		array_push($rsList, $row);
		$timestamp += 24 * 3600;
	}
	?>
	<div id="chart_container" height="350"></div>
</body>
<script>
$(function () {
    var colors = ['#109618', '#ffdb20', '#ff7e20', '#DC3912', '#660099', '#7e0023', '#7e0023'];

	$('#chart_container').highcharts({
        chart: {type: 'column'},
        title: {text: ''},
        subtitle: {
            text: ''
        },
        xAxis: {
            type: 'category'
        },credits: {enabled: false},
        yAxis: {
            title: {
                text: ''
            }
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true                       
                }
            }
        },         
		tooltip: { enabled: false },
        series: [{
            name: '',
            colorByPoint: true,
            data: [
			<?php
				$i=0;
				foreach($rsList as $item){
					if($i>0){echo ',';}
					?>
					{
						name: '<?=$item["log_date"]?>',
						<?php if($ch=="temp"){?>
							y: <?=number_format($item['temp'])?>,
							color: '#05a8de'
						<?php }else if($ch=="humid"){?>
							y: <?=number_format($item['humid'])?>,
							color: '#05a8de'
						<?php }else{?>
							y: <?=getValueAQI($item['avg_pm'.$subch],$ch)?>,
							color: colors[<?=report_typeUSAQI3(getValueAQI($item['avg_pm'.$subch],'pm25usaqi'))?>]
						<?php }?>
					}
	
					
					<?php
					$i++;
				}
			?>
				]
        }]
    });
});
</script>

</html>
