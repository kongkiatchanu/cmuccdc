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
#chart_container{height:450px !important;}
</style>
<body>
	<div id="chart_container" height="450"></div>
</body>
<script>
$(function () {
    var seriesOptions = [],
        seriesCounter = 0,
        names = ["PM2.5"];

    $.each(names, function (i, name) {
		var url = 'jsonDatabaseColumn.php<?=$param?>&key=<?=$_GET['key']?>&callback=?';
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
                lineWidth: 1,
                opposite:false,
                labels: {
                    align: 'right',
                    x: -10
                }
				<?php if($datatype=="pm25"){?>
				,plotLines: [{
                    value: 37.5,
                    color: 'red',
                    dashStyle: 'shortdash',
                    width: 2,
                    label: {
                        text: 'ค่ามาตรฐาน PM2.5 = 37.5 ug/m3'
                    }
                }]
				<?php }?>
				<?php if($datatype=="pm10"){?>
				,plotLines: [{
                    value: 120,
                    color: 'red',
                    dashStyle: 'shortdash',
                    width: 2,
                    label: {
                        text: 'ค่ามาตรฐาน PM10 = 120 ug/m3'
                    }
                }]
				<?php }?>
            }],
            tooltip: {
				useHTML:true,
				backgroundColor: "rgba(255,255,255,0)",
				borderWidth: 0,
				borderRadius: 0,
			    shadow: false,
                formatter: function() {

					var  p1 = this.points[0].y;
					
					var  type = "";
					
										
					<?php if($datatype=="pm25"){?>							
					if (p1 <=15){
						var  type = "boxtool_goo";
					}else if (p1 >15 && p1<=25){
						var  type = "boxtool_mod";
		  
					}else if (p1 >25 && p1<=37.5){
						var  type = "boxtool_sen";
						
					}else if (p1 >37.5 && p1<=75){
						var  type = "boxtool_unheal";	
						
					}else if (p1 >75){
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
									'PM10 : <b>' + Highcharts.numberFormat(p1, 0) +'</b> ug/m3<br />' +
								<?php }else if($datatype=="temp"){?>
									'Temperature  : <b>' + Highcharts.numberFormat(p1, 0) +'</b> C<br />' +
								<?php }else if($datatype=="humid"){?>
									'Humidity (RH)  : <b>' + Highcharts.numberFormat(p1, 0) +'</b> %<br />' +
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
            series: seriesOptions
        });
    }
});
</script>

</html>
