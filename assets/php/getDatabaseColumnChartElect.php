<?php
	error_reporting(E_ALL);
	header('Access-Control-Allow-Origin: https://www.cmuccdc.org');
	include "connect.php";

	if($_GET['key']!=md5('s'.date('ymdh'))){
		exit;
	}
	
	$mm =array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
	$source_id = mysqli_real_escape_string($mysqli, $_GET['source']);
	$reporttype = mysqli_real_escape_string($mysqli, $_GET['reportType']);
	// $datatype = mysqli_real_escape_string($mysqli, $_GET['dataType']);
	$datatype = $_GET['dataType'];

	$dd = strtotime(date('Y-m-d'))-(60*60*24*7);
	$date_search =  date('Y-m-d', $dd);
	if($reporttype=="h"){
		$dd = strtotime(date('Y-m-d'))-(60*60*24*2);
		$date_search =  date('Y-m-d', $dd);
	}
	$dt = $date_search;
	$de = date('Y-m-d');
	// $h_time_start = mysqli_real_escape_string($mysqli, $_GET['h_time_start']).":00";
	
	$h= date('H');
	if($h!=0){
		$h_time_start= date('Y-m-').(date('d')-1).' '.($h-1);
		$h_time_end= date('Y-m-d').' '.($h-1);
	}else{
		$h_time_start= date('Y-m-').(date('d')-2).' '. 23;
		$h_time_end= date('Y-m-').(date('d')-1).' '. 23;
	}

	$param = '?reportType='.$reporttype.'&dataType='.$_GET['dataType'].'&dt='.$dt.'&de='.$de.'&source='.$_GET['source'].'&meter_id='.$_GET['meter_id'].'&h_time_start='.$_GET['h_time_start'].'&h_time_end='.$h_time_end;
	if($_GET['reportType']=='h'){
		$param = '?reportType='.$reporttype.'&dataType='.$_GET['dataType'].'&dt='.$dt.'&de='.$de.'&source='.$_GET['source'].'&meter_id='.$_GET['meter_id'].'&h_time_start='.$h_time_start.'&h_time_end='.$h_time_end;
	}

	if($datatype=="pm25" || $datatype=="pm10"){
		$unit = 'μg/m<sup>3</sup>';
	}else if($datatype=="temp"){
		$unit = '°C';
	}else{
		$unit = '%';
	}
	
	if($datatype=="pm25"){
		$sVal = 50;
		$sTxt = 'ค่ามาตรฐาน PM2.5 = 50 μg/m<sup>3</sup>';
		$sResult = 'จำนวนวันที่มีค่า PM2.5 เกินค่ามาตรฐาน = ';
	}else if($datatype=="pm10"){
		$sVal = 120;
		$sTxt = 'ค่ามาตรฐาน PM10 = 120 μg/m<sup>3</sup>';
		$sResult = 'จำนวนวันที่มีค่า PM10 เกินค่ามาตรฐาน = ';
	}
	function calAQIPM10($val){
	
		if($val<=50){
			$data = (((25-0)*($val-0))/(50-0))+0;
		}else if(($val<=80) && ($val>50)){
			$data = (((50-25)*($val-50))/(80-50))+25;
		}else if(($val<=120) && ($val>80)){
			$data = (((100-50)*($val-80))/(120-80))+50;
		}else if(($val<=180) && ($val>120)){
			$data = (((200-100)*($val-120))/(180-120))+100;
		}else if(($val<=600) && ($val>180)){
			$data = (((500-200)*($val-180))/(600-180))+300;
		}else{
			$data = 500;
		}
		return number_format($data,2);
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
.boxtool_h{background-color:#eee;}
.boxtool_goo{background-color:#05a8de;}
.boxtool_mod{background-color:#04b04f;}
.boxtool_sen{background-color:#fccc0a;}
.boxtool_unheal{background-color:#f89939;}
.boxtool_haz{background-color:#ed2224;}
.boxtool_kWh{background-color:#ffcc01;}
text{
	color: #000000;
}

#chart_container{height:250px !important;}
</style>
<body>
	<div id="chart_container" height="250"></div>
	<!-- <small>https://www.cmuccdc.org/assets/php/jsonDatabaseColumnElect.php<?=$param?>&key=<?=$_GET['key']?>&callback=?</small> -->
	<!--<p style="text-align:center"><?=$sResult?> <span id="vResult" style="background-color: #ed2224;padding: 5px;color: #fff;"></span></p>-->
</body>
<script>
$(function () {
    var seriesOptions = [],
        seriesCounter = 0,
        names = ["Accumulated electricity consumption"];

    $.each(names, function (i, name) {
		var url = 'https://www.cmuccdc.org/assets/php/jsonDatabaseColumnElect.php<?=$param?>&key=<?=$_GET['key']?>&callback=?';
        $.getJSON(url,    function (data) {
            seriesOptions[i] = {
                name: name,
                data: data,
				color: '#444444'		
            };
            seriesCounter += 1;

            if (seriesCounter === names.length) {
                createChart();
            }
			console.log(seriesOptions);
        });
    });
	
	function createChart() {
		
        $('#chart_container').highcharts('StockChart', {
			chart: {
				type: 'area'
			},
			rangeSelector: {
				buttons: [{
					type: 'hour',
					count: 1,
					text: '1h'
				}, {
					type: 'day',
					count: 1,
					text: '1D'
				}, {
					type: 'all',
					count: 1,
					text: 'All'
				}],
				selected: 1,
				// inputEnabled: false
			},
			credits: {enabled: false}, 
			//navigator: {enabled: false},
			//scrollbar: { enabled: false },
			exporting: { enabled: false },
			title : {text : ''},
			yAxis: {
				// title: {
                //     text: ''
                // },
                // lineWidth: 1,
                opposite:false,
                labels: {
                    align: 'right',
                    x: -10
                },
				type: 'logarithmic',
				minorTickInterval: 0.001,
				accessibility: {
					rangeDescription: 'Range: 0.001 to 1000'
				}
            },
            tooltip: {
				useHTML:true,
				backgroundColor: "rgba(255,255,255,0)",
				borderWidth: 0,
				borderRadius: 0,
			    shadow: false,
                formatter: function() {
					var  p1 = this.points[0].y;
					var  type = "";
					var  type = "boxtool_kWh";

					txtshow = '<div class="tooltop '+type+'">'+  
						<?php if($reporttype=="h"){?>		
							Highcharts.dateFormat('%e %b %Y %H:%M:%S', new Date(this.x)) +'<br />' +
								<?php if($datatype=="sensor_energy_kWh"){?>
									'Accumulated electricity consumption : <b>' + p1 +'</b> kWh<br />' +
								<?php }?>
						<?php }else if($reporttype=="d"){?>
							Highcharts.dateFormat('%e %b %Y %H:%M:%S', new Date(this.x)) +'<br />' +
								<?php if($datatype=="sensor_energy_kWh"){?>
									'Accumulated electricity consumption : <b>' + p1 +'</b> kWh<br />' +
								<?php }?>
						<?php }else if($reporttype=="m"){?>
							Highcharts.dateFormat('%e %b %Y %H:%M:%S', new Date(this.x)) +'<br />' +
								<?php if($datatype=="sensor_energy_kWh"){?>
									'Accumulated electricity consumption : <b>' + p1 +'</b> kWh<br />' +
								<?php }?>
						<?php }?>

							'</div>';

					return txtshow;
				}
				
            },
			plotOptions: {
				area: {
					marker: {
						enabled: false,
						symbol: 'circle',
						fillColor: '#000000',
						radius: 2,
						states: {
							hover: {
								enabled: true,
							}
						}
					}
				},
				series: {
					fillColor: '#ffcc0199',
				}
			},
            series: seriesOptions
        });
    }
});
</script>

</html>