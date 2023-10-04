<?php
	include "connect.php";

	$sql="SELECT * FROM source WHERE source_id =".mysqli_real_escape_string($mysqli, $_GET['val']);
	$q=$mysqli->query($sql);
	if($q->num_rows)
	{
		$rs=$q->fetch_assoc();
	}else{
		header("Location: /");
		exit();
	}
	
	$ch = substr($_GET['ch'],2,2);
	
	if($rs['version']=="mini"){
		$db = 'log_mini_2561';
	}else{
		$db = 'log_data_2562';
	}
	
	function calAQIPM10($val){
	if($val<=50){
		$data = (((25-0)*($val-0))/(50-0))+0;
	}else if($val>50 && $val<=80){
		$data=(((50-25)*($val-50))/(80-50))+25;
	}else if($val>80 && $val<=120){
		$data=(((100-50)*($val-80))/(120-80))+50;
	}else if($val>120 && $val<=180){
		$data=(((200-100)*($val-120))/(180-120))+100;
	}else if($val>180 && $val<=600){
		$data=(((500-200)*($val-180))/(600-180))+300;
	}else{
		$data=500;
	}
	return number_format($data);
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
	
	function report_type($val){
		if($val<=50){
			$txt = 0;
		}else if($val>50 && $val<=100){
			$txt = 1;
		}else if($val>100 && $val<=200){
		$txt = 2;
		}else if($val>200 && $val<=300){
			$txt = 3;
		}else if($val>300 && $val<=600){
			$txt = 4;
		}else{
			$txt = 4;
		}
		return $txt;
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
			return number_format($data,2);
		}
	}
	function usPM10AQI($val){
		$data = 0;
		if($val>0){
			if($val<=54){
				$data=(((50-0)*($val-0))/(54-0))+0;
			}
			else if(($val<=154) && ($val>54)){
				$data=(((100-50)*($val-54))/(154-54))+50;
			}
			else if(($val<=254) && ($val>154)){
				$data=(((150-100)*($val-154))/(254-154))+100;
			}
			else if(($val<=354) && ($val>254)){
				$data=(((200-150)*($val-254))/(354-254))+150;
			}
			else if(($val<=424) && ($val>354)){
				$data=(((300-200)*($val-354))/(424-354))+200;
			}
			else if(($val<=504) && ($val>424)){
				$data=(((400-300)*($val-424))/(504-424))+300;
			}
			else if(($val>504)){
				$data=(((500-400)*($val-504))/(604-504))+400;
			}
			return number_format($data,2);
		}
	}
	
	function report_typeUSAQI($val){
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
	
	function getValue($val){
		if($_GET['ch']=="pm25aqi"){
			return usPM25AQI($val);
		}else if($_GET['ch']=="pm10aqi"){
			return usPM10AQI($val);
		}else{
			return $val;
		}
	}
	function getValueAQI($val){
		if($_GET['ch']=="pm25aqi" || $_GET['ch']=="pm25"){
			return usPM25AQI($val);
		}else if($_GET['ch']=="pm10aqi" || $_GET['ch']=="pm10"){
			return usPM10AQI($val);
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Particulate Matter</title>
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
				$timestamp =  strtotime(date('Y-m-d'))-604800;
				for ($i = 0 ; $i < 7 ; $i++) {
					$date_search =  date('Y-m-d', $timestamp);
					
					
					$sql="SELECT source_id, avg(log_pm10) as avg_pm10, avg(log_pm25) as avg_pm25, avg(temp) as temp, avg(humid) as humid, DATE_FORMAT(log_datetime,'%d/%m/%Y') as log_date  FROM ".$db." 
						WHERE 
							`source_id` = ".mysqli_real_escape_string($mysqli, $_GET["val"])." AND
							log_datetime BETWEEN '".$date_search." 00:00:00' AND '".$date_search." 23:59:59'
						group by DATE_FORMAT(log_datetime, '%Y%m%d')";

					$q=$mysqli->query($sql);
					$rs=$q->fetch_assoc();
					
					if($i>0){echo ',';}
					?>
					
					
					{
						name: '<?=date('d/m/Y', $timestamp)?>',
					<?php if($_GET['ch']=="temp"){?>
						y: <?=number_format($rs['temp'])?>,
						color: '#05a8de'
					<?php }else if($_GET['ch']=="humid"){?>
						y: <?=number_format($rs['humid'])?>,
						color: '#05a8de'
					<?php }else{?>
						y: <?=number_format(getValue($rs['avg_pm'.$ch]),2)?>,
						color: colors[<?=report_typeUSAQI(getValueAQI($rs['avg_pm'.$ch]))?>]
					<?php }?>
					}
	
					
					<?php
					$timestamp += 24 * 3600;
				}
			?>
				]
        }]
    });
});
</script>

</html>