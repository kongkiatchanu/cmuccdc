<?php
	header('Access-Control-Allow-Origin: https://www.cmuccdc.org');
	include "connect.php";

	if($_GET['key']!=md5('s'.date('ymdh'))){
		exit;
	}
	$mm =array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
	$source_id = mysqli_real_escape_string($mysqli, $_GET['source']);
	$datatype = mysqli_real_escape_string($mysqli, $_GET['dataType']);
	$reporttype = mysqli_real_escape_string($mysqli, $_GET['reportType']);
	$dt = mysqli_real_escape_string($mysqli, $_GET['dt']);
	$de = mysqli_real_escape_string($mysqli, $_GET['de']);
	$h_time_start = mysqli_real_escape_string($mysqli, $_GET['h_time_start']).":00";
	$h_time_end = mysqli_real_escape_string($mysqli, $_GET['h_time_end']).":59";
		
	$param = '?reportType='.$reporttype.'&dataType='.$_GET['dataType'].'&dt='.$dt.'&de='.$de.'&source='.$_GET['source'].'&h_time_start='.$_GET['h_time_start'].'&h_time_end='.$_GET['h_time_end'];
	if($datatype=="pm25" || $datatype=="pm10"){
		$unit = 'ug/m3';
	}else if($datatype=="temp"){
		$unit = '°C';
	}else{
		$unit = '%';
	}
	
	if($datatype=="pm25"){
		$sVal = 50;
		$sTxt = 'ค่ามาตรฐาน PM2.5 = 50 ug/m3';
		$sResult = 'จำนวนวันที่มีค่า PM2.5 เกินค่ามาตรฐาน = ';
	}else if($datatype=="pm10"){
		$sVal = 120;
		$sTxt = 'ค่ามาตรฐาน PM10 = 120 ug/m3';
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
		/*
		if($val<=25){
			$data = (((25-0)*($val-0))/(25-0))+0;
		}else if($val<=37 && $val>25){
			$data = (((50-26)*($val-26))/(37-26))+26;
		}else if($val<=50 && $val>37){
			$data = (((100-51)*($val-38))/(50-38))+51;
		}else if($val<=90 && $val>50){
			$data = (((200-101)*($val-51))/(90-51))+101;
		}else if($val<=600 && $val>90){
			$data = (((500-201)*($val-91))/(600-91))+201;
		}else{
			$data = 500;
		}
		return number_format($data,2);*/
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
.boxtool_goo{background-color:#05a8de;}
.boxtool_mod{background-color:#04b04f;}
.boxtool_sen{background-color:#fccc0a;}
.boxtool_unheal{background-color:#f89939;}
.boxtool_haz{background-color:#ed2224;}
#chart_container{height:500px !important;}
</style>
<body>
	<div id="chart_container" height="500"></div>
	<p style="text-align:center"><?=$sResult?> <span id="vResult" style="background-color: #ed2224;padding: 5px;color: #fff;"></span></p>
</body>
<script>
$(function () {
	var colors = ['#05a8de', '#04b04f', '#fccc0a', '#f89939', '#ed2224'];
	var mean = '<?=$sVal?>';
    var seriesOptions = [],
        seriesCounter = 0,
        names = ["PM2.5"];

    $.each(names, function (i, name) {
		var url = 'jsonDatabaseColumn.php<?=$param?>&key=<?=$_GET['key']?>&callback=?';
        $.getJSON(url,    function (data) {
			var count_point = 0
			$.each(data, function(i, item) {
				if(item[1]>mean){
					count_point++;
				}
				
		    });
			$('#vResult').html(count_point);
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
			rangeSelector : {
                buttons: [{
                    type: 'day',
                    count: 1,
                    text: 'day'
                },{
                    type: 'all',
                    text: 'All'
                }],
                inputEnabled: false, // it supports only days
                selected : 1 // all
            },credits: {enabled: false},
			title : {text : ''},
			yAxis: [{
				title: {
                    text: '<?=$unit?>'
                },
				plotLines: [{
					value: mean,
					dashStyle: 'dash',
					color: '#000',
					width: 2,
					zIndex: 9,
					label: {
						text: '<?=$sTxt?>',
						align: 'left',
						style: {
							color: '#000'
						}
					}
				}],
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
					if (p1 <=25){
						var  type = "boxtool_goo";
					}else if (p1 >25 && p1<=37){
						var  type = "boxtool_mod";
		  
					}else if (p1 >37 && p1<=50){
						var  type = "boxtool_sen";
						
					}else if (p1 >50 && p1<=90){
						var  type = "boxtool_unheal";	
						
					}else if (p1 >90){
						var  type = "boxtool_haz";
					}
					<?php }?>
					<?php if($datatype=="pm10"){?>							
					if (p1 <=50){
						var  type = "boxtool_goo";
					}else if (p1 >50 && p1<=80){
						var  type = "boxtool_mod";
		  
					}else if (p1 >80 && p1<=120){
						var  type = "boxtool_sen";
						
					}else if (p1 >120 && p1<=180){
						var  type = "boxtool_unheal";	
						
					}else if (p1 >180){
						var  type = "boxtool_haz";
					}
					<?php }?>
					
					txtshow = '<div class="tooltop '+type+'">'+  
						<?php if($reporttype=="h"){?>		
							Highcharts.dateFormat('%e %b %Y %H:%M:%S', new Date(this.x)) +'<br />' +
								<?php if($datatype=="pm25"){?>
									'PM2.5 : <b>' + Highcharts.numberFormat(p1,0) +'</b> ug/m3<br />' +
								<?php }else if($datatype=="pm10"){?>
									'PM10 : <b>' + Highcharts.numberFormat(p1,0) +'</b> ug/m3<br />' +
								<?php }else if($datatype=="temp"){?>
									'Temperature  : <b>' + Highcharts.numberFormat(p1,0) +'</b> C<br />' +
								<?php }else if($datatype=="humid"){?>
									'Humidity (RH)  : <b>' + Highcharts.numberFormat(p1,0) +'</b> %<br />' +
								<?php }?>
						<?php }else if($reporttype=="d"){?>
							Highcharts.dateFormat('%e %b %Y', new Date(this.x)) +'<br />' +
								<?php if($datatype=="pm25"){?>
									'PM2.5 : <b>' + Highcharts.numberFormat(p1, 2) +'</b> ug/m3<br />' +
								<?php }else if($datatype=="pm10"){?>
									'PM10 : <b>' + Highcharts.numberFormat(p1, 2) +'</b> ug/m3<br />' +
								<?php }else if($datatype=="temp"){?>
									'Temperature  : <b>' + Highcharts.numberFormat(p1, 2) +'</b> C<br />' +
								<?php }else if($datatype=="humid"){?>
									'Humidity (RH)  : <b>' + Highcharts.numberFormat(p1, 2) +'</b> %<br />' +
								<?php }?>
						<?php }else if($reporttype=="d"){?>
							Highcharts.dateFormat('%e %b %Y', new Date(this.x)) +'<br />' +
								<?php if($datatype=="pm25"){?>
									'PM2.5 : <b>' + Highcharts.numberFormat(p1, 2) +'</b> ug/m3<br />' +
								<?php }else if($datatype=="pm10"){?>
									'PM10 : <b>' + Highcharts.numberFormat(p1, 2) +'</b> ug/m3<br />' +
								<?php }else if($datatype=="temp"){?>
									'Temperature  : <b>' + Highcharts.numberFormat(p1, 2) +'</b> C<br />' +
								<?php }else if($datatype=="humid"){?>
									'Humidity (RH)  : <b>' + Highcharts.numberFormat(p1, 2) +'</b> %<br />' +
								<?php }?>
						<?php }else if($reporttype=="m"){?>
							Highcharts.dateFormat('%e %b %Y', new Date(this.x)) +'<br />' +
								<?php if($datatype=="pm25"){?>
									'PM2.5 : <b>' + Highcharts.numberFormat(p1, 2) +'</b> ug/m3<br />' +
								<?php }else if($datatype=="pm10"){?>
									'PM10 : <b>' + Highcharts.numberFormat(p1, 2) +'</b> ug/m3<br />' +
								<?php }else if($datatype=="temp"){?>
									'Temperature  : <b>' + Highcharts.numberFormat(p1, 2) +'</b> C<br />' +
								<?php }else if($datatype=="humid"){?>
									'Humidity (RH)  : <b>' + Highcharts.numberFormat(p1, 2) +'</b> %<br />' +
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
						value: 25, 
						color: colors[0]
					},{
						value: 37, 
						color: colors[1]
					},{
						value: 50, 
						color: colors[2]
					},{
						value: 90, 
						color: colors[3]
					},{
						color: colors[4]
					}]
				}
				<?php }?>
				<?php if($datatype=="pm10"){?>
				column: {
					zones: [{
						value: 50, 
						color: colors[0]
					},{
						value: 80, 
						color: colors[1]
					},{
						value: 120, 
						color: colors[2]
					},{
						value: 180, 
						color: colors[3]
					},{
						color: colors[4]
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