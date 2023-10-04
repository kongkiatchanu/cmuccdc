<?php
	include "connect.php";
	if($_GET['key']!=md5('s'.date('ymdh'))){
		exit;
	}
	$sql="SELECT * FROM source WHERE location_status =1 AND is_cnx = ".$_GET["g"];
	$q=$mysqli->query($sql);
	$data_id = array();
	$data_name = array();
	while($rs=$q->fetch_assoc()){
		array_push($data_id,$rs['source_id']);
		array_push($data_name,$rs['location_id']);
		//$data['s_name'] = array_push($data,$rs['location_name']);
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
#chart_container{height:450px !important;}
</style>
<body>
	<div id="chart_container" height="450"><p style="text-align:center"><img src="/template/img/loader_ccdc.gif"></p></div>
</body>
<script>
$(function () {
    var seriesOptions = [],
        seriesCounter = 0,
		ids = [<?php $i=0;foreach($data_id as $val){$i++;if($i!=1){echo ',';}echo "'".$val."'";}?>];
        names = [<?php $i=0;foreach($data_name as $val){$i++;if($i!=1){echo ',';}echo "'".$val."'";}?>];
	
    $.each(ids, function (i, id) {
		var url = 'jsonCMPM.php?filename=PM10&local='+id+'&key=<?=md5('s'.date('ymdh'))?>&g=<?=$_GET["g"]?>&callback=?';
        $.getJSON(url,    function (data) {
            seriesOptions[i] = {
                name: names[i],
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
			legend: {
				enabled: true,
				
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
                selected : 0 // all
            },credits: {enabled: false},
			title : {text : ''},
			yAxis: [{
				title: {
                    text: 'ug/m3'
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
				backgroundColor: "rgba(255,255,255,0)",
				borderWidth: 0,
				borderRadius: 0,
			    shadow: false,
                formatter: function() {
                   
					var txtshow_body ='';
					var txtshow_heaer = '<div class="tooltop boxtool_goo">'+Highcharts.dateFormat('%e %b %Y %H:%M', new Date(this.x)) +'<br />';
					for(var i=0; i<this.points.length; i++){
						txtshow_body += this.points[i].series.name+' : '+ Highcharts.numberFormat(this.points[i].y,2) +' ug/m3<br/>';						
					}
					var txtshow_footet =	'</div>';

					return txtshow_heaer+txtshow_body+txtshow_footet;
				}
				
            },
            series: seriesOptions
        });
    }
});
</script>

</html>