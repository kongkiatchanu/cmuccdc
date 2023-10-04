<?php
	error_reporting(E_ALL);
	header('Access-Control-Allow-Origin: https://www.cmuccdc.org');
	include "connect.php";

	if($_GET['key']!=md5('s'.date('ymdh'))){
		exit;
	}
	
	

	$mm =array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
	$source_id = mysqli_real_escape_string($mysqli, $_GET['source']);
	$datatype = mysqli_real_escape_string($mysqli, $_GET['dataType']);
	$reporttype = mysqli_real_escape_string($mysqli, $_GET['reportType']);
	

	$dd = strtotime(date('Y-m-d'))-(60*60*24*7);
	$date_search =  date('Y-m-d', $dd);
	if($reporttype=="h"){
		$dd = strtotime(date('Y-m-d'))-(60*60*24*2);
		$date_search =  date('Y-m-d', $dd);
	}
	$dt = $date_search;
	$de = date('Y-m-d');
	$h_time_start = mysqli_real_escape_string($mysqli, $_GET['h_time_start']).":00";
	
	$h= date('H');
	if($h!=0){
		$h_time_end= date('Y-m-d').' '.($h-1);
	}else{
		$h_time_end= date('Y-m-').(date('d')-1).' '. 23;
	}

	$param = '?reportType='.$reporttype.'&dataType='.$_GET['dataType'].'&dt='.$dt.'&de='.$de.'&source='.$_GET['source'].'&h_time_start='.$_GET['h_time_start'].'&h_time_end='.$h_time_end;
	
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

.boxtool_1{background-color:#01996c;}
.boxtool_2{background-color:#ffdc5b;}
.boxtool_3{background-color:#eb8440;}
.boxtool_4{background-color:#d10236;}
.boxtool_5{background-color:#8116b9;}
.boxtool_6{background-color:#a00837;}
#chart_container{height:250px !important;}
</style>
<body>
	
	<div id="chart_container" height="250"></div>

	<!--<p style="text-align:center"><?=$sResult?> <span id="vResult" style="background-color: #ed2224;padding: 5px;color: #fff;"></span></p>-->
</body>
<script>
$(function () {
	var colors = ['#01996c', '#ffdc5b', '#eb8440', '#d10236', '#8116b9', '#a00837'];
    var seriesOptions = [],
        seriesCounter = 0,
        names = ["PM2.5"];

    $.each(names, function (i, name) {
		var url = 'jsonDatabaseColumnUS.php<?=$param?>&key=<?=$_GET['key']?>&callback=?';
        $.getJSON(url,    function (data) {
            seriesOptions[i] = {
                name: name,
                data: data		
            };
            seriesCounter += 1;

            if (seriesCounter === names.length) {
                createChart();
            }
        });
    });
	
	function createChart() {
	
        $('#chart_container').highcharts('StockChart', {
			chart: {
				type: 'column'
			},
			rangeSelector : {enabled: false},
			credits: {enabled: false}, 
			exporting: { enabled: false },
			title : {text : ''},
			yAxis: [{
				title: {
                    text: ''
                },
                lineWidth: 1,
                opposite:false,
                labels: {
                    align: 'right',
                    x: -10
                }
            }],
            tooltip: {
				useHTML:true,
				backgroundColor: "rgba(255,255,200,0)",
				borderWidth: 0,
				borderRadius: 0,
			    shadow: false,
                formatter: function() {

					var  p1 = this.points[0].y;
					
					var  type = "";
					
										
					<?php if($datatype=="pm25"){?>							
					if (p1 <=12){
						var  type = "boxtool_1";
					}else if (p1 >12 && p1<=35){
						var  type = "boxtool_2";
		  
					}else if (p1 >35 && p1<=55){
						var  type = "boxtool_3";
						
					}else if (p1 >55 && p1<=150){
						var  type = "boxtool_4";	
						
					}else if (p1 >150 && p1<=250){
						var  type = "boxtool_5";	
						
					}else if (p1 >250){
						var  type = "boxtool_6";
					}
					<?php }?>
					<?php if($datatype=="pm25thaqi"){?>							
					if (p1 <=50){
						var  type = "boxtool_1";
					}else if (p1 >50 && p1<=100){
						var  type = "boxtool_2";
		  
					}else if (p1 >100 && p1<=150){
						var  type = "boxtool_3";
						
					}else if (p1 >150 && p1<=200){
						var  type = "boxtool_4";	
						
					}else if (p1 >200 && p1<=300){
						var  type = "boxtool_5";	
						
					}else if (p1 >300){
						var  type = "boxtool_6";
					}
					<?php }?>
					<?php if($datatype=="pm10"){?>							
					if (p1 <=54){
						var  type = "boxtool_1";
					}else if (p1 >55 && p1<=154){
						var  type = "boxtool_2";
		  
					}else if (p1 >155 && p1<=254){
						var  type = "boxtool_3";
						
					}else if (p1 >255 && p1<=354){
						var  type = "boxtool_4";	
						
					}else if (p1 >355 && p1<=424){
						var  type = "boxtool_5";	
						
					}else if (p1 >425){
						var  type = "boxtool_6";
					}
					<?php }?>
					txtshow = '<div class="tooltop '+type+'">'+  
						<?php if($reporttype=="h"){?>		
							Highcharts.dateFormat('%e %b %Y %H:%M:%S', new Date(this.x)) +'<br />' +
								<?php if($datatype=="pm25"){?>
									'PM2.5 : <b>' + p1 +'</b> μg/m<sup>3</sup><br />' +
								<?php }else if($datatype=="pm10"){?>
									'PM10 : <b>' + p1 +'</b> μg/m<sup>3</sup><br />' +
								<?php }else if($datatype=="temp"){?>
									'Temperature  : <b>' + p1 +'</b> C<br />' +
								<?php }else if($datatype=="humid"){?>
									'Humidity (RH)  : <b>' + p1 +'</b> %<br />' +
								<?php }?>
						<?php }else if($reporttype=="d"){?>
							Highcharts.dateFormat('%e %b %Y', new Date(this.x)) +'<br />' +
								<?php if($datatype=="pm25"){?>
									'PM2.5 : <b>' + p1 +'</b> μg/m<sup>3</sup><br />' +
								<?php }else if($datatype=="pm10"){?>
									'PM10 : <b>' + p1 +'</b> μg/m<sup>3</sup><br />' +
								<?php }else if($datatype=="temp"){?>
									'Temperature  : <b>' + p1 +'</b> C<br />' +
								<?php }else if($datatype=="humid"){?>
									'Humidity (RH)  : <b>' + p1 +'</b> %<br />' +
								<?php }else{?>
									'PM2.5 US AQI : <b>' + p1 +'</b> <br />' +
								<?php }?>
						<?php }else if($reporttype=="d"){?>
							Highcharts.dateFormat('%e %b %Y', new Date(this.x)) +'<br />' +
								<?php if($datatype=="pm25"){?>
									'PM2.5 : <b>' + p1 +'</b> μg/m<sup>3</sup><br />' +
								<?php }else if($datatype=="pm10"){?>
									'PM10 : <b>' + p1 +'</b> μg/m<sup>3</sup><br />' +
								<?php }else if($datatype=="temp"){?>
									'Temperature  : <b>' + p1 +'</b> C<br />' +
								<?php }else if($datatype=="humid"){?>
									'Humidity (RH)  : <b>' + p1 +'</b> %<br />' +
								<?php }?>
						<?php }else if($reporttype=="m"){?>
							Highcharts.dateFormat('%e %b %Y', new Date(this.x)) +'<br />' +
								<?php if($datatype=="pm25"){?>
									'PM2.5 : <b>' + p1 +'</b> μg/m<sup>3</sup><br />' +
								<?php }else if($datatype=="pm10"){?>
									'PM10 : <b>' + p1 +'</b> μg/m<sup>3</sup><br />' +
								<?php }else if($datatype=="temp"){?>
									'Temperature  : <b>' + p1 +'</b> C<br />' +
								<?php }else if($datatype=="humid"){?>
									'Humidity (RH)  : <b>' + p1 +'</b> %<br />' +
								<?php }?>
						<?php }?>

							'</div>';

					return txtshow;
				}
				
            },
			plotOptions: {
				
				
				<?php if($datatype=="pm25"){?>
				column: {
					zones: [{
						value: 12, 
						color: colors[0]
					},{
						value: 36, 
						color: colors[1]
					},{
						value: 56, 
						color: colors[2]
					},{
						value: 151, 
						color: colors[3]
					},{
						value: 251, 
						color: colors[4]
					},{
						color: colors[5]
					}]
				}
				<?php }?>
				<?php if($datatype=="pm25thaqi"){?>
				column: {
					zones: [{
						value: 50, 
						color: colors[0]
					},{
						value: 101, 
						color: colors[1]
					},{
						value: 151, 
						color: colors[2]
					},{
						value: 201, 
						color: colors[3]
					},{
						value: 301, 
						color: colors[4]
					},{
						color: colors[5]
					}]
				}
				<?php }?>
				<?php if($datatype=="pm10"){?>
				column: {
					zones: [{
						value: 54, 
						color: colors[0]
					},{
						value: 154, 
						color: colors[1]
					},{
						value: 254, 
						color: colors[2]
					},{
						value: 354, 
						color: colors[3]
					},{
						value: 424, 
						color: colors[4]
					},{
						color: colors[5]
					}]
				}
				<?php }?>
			},
            series: seriesOptions
        });
    }
});
</script>

</html>