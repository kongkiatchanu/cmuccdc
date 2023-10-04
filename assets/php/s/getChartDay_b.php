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
	
	function calAQIPM25($val){
		if($val<=25){
			$data = (((25-0)*($val-0))/(25-0))+0;
		}else if($val>25 && $val<=37){
			$data = (((50-25)*($val-25))/(37-25))+25;
		}else if($val>37 && $val<=50){
			$data = (((100-50)*($val-37))/(50-37))+50;
		}else if($val>50 && $val<=90){
			$data=(((200-100)*($val-50))/(90-50))+100;
		}else if($val>90 && $val<=600){
			$data=(((500-200)*($val-90))/(600-90))+300;
		}else{
			$data=500;
		}
		return number_format($data);
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
	
	function getValue($val){
		if($_GET['ch']=="pm25aqi"){
			return calAQIPM25($val);
		}else if($_GET['ch']=="pm10aqi"){
			return calAQIPM10($val);
		}else{
			return $val;
		}
	}
	function getValueAQI($val){
		if($_GET['ch']=="pm25aqi" || $_GET['ch']=="pm25"){
			return calAQIPM25($val);
		}else if($_GET['ch']=="pm10aqi" || $_GET['ch']=="pm10"){
			return calAQIPM10($val);
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
<script src="/template/js/hc/dark-unica-new.js"></script>
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
    var colors = ['#05a8de', '#04b04f', '#fccc0a', '#f89939', '#ed2224'];

	$('#chart_container').highcharts({
        chart: {type: 'column'},
        title: {text: ''},
        subtitle: {
            text: ''
        },
        xAxis: {
            type: 'category'
        },
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
				$sql="SELECT source_id, avg(log_pm10) as avg_pm10, avg(log_pm25) as avg_pm25, DATE_FORMAT(log_datetime,'%d/%m/%Y') as log_date  FROM `log_data_2561` 
					WHERE 
						`source_id` = ".mysqli_real_escape_string($mysqli, $_GET["val"])." AND
						log_datetime 
							BETWEEN ( DATE_SUB( NOW() , INTERVAL 7 day ) )
							AND ( NOW() )
					group by DATE_FORMAT(log_datetime, '%Y%m%d')
					ORDER BY log_datetime ASC LIMIT 7";
				$q=$mysqli->query($sql);
				$data = array();
				while($rs=$q->fetch_assoc())
				{
					$i++;
					if($i>1){echo ',';}
			?>
			
					{
						name: '<?=$rs['log_date']?>',
						y: <?=number_format(getValue($rs['avg_pm'.$ch]),2)?>,
						color: colors[<?=report_type(getValueAQI($rs['avg_pm'.$ch]))?>]

					}
			
				<?php }?>
				]
        }]
    });
});
</script>

</html>