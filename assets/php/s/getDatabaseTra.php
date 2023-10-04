<?php
	include "connect.php";
	$data = array();
	$sql="SELECT * FROM `od_travel` WHERE `tra_year` = '".mysqli_real_escape_string($mysqli, $_GET['y'])."' order by tra_cat_id asc";
	$q=$mysqli->query($sql);
	while($rs = $q->fetch_assoc()){
		array_push($data,$rs);
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
#chart_container{height:350px !important;}
</style>
<body>
	<div id="chart_container" height="350"></div>
</body>
<script>
$(function () {
Highcharts.setOptions({
		lang: {
			thousandsSep: ','
		}
	});
Highcharts.chart('chart_container', {
    title: {
        text: 'จำนวนนักท่องเที่ยว'
    },
    subtitle: {
        text: 'จังหวัดเชียงใหม่ ปี <?=($_GET['y']+543)?>'
    },
    xAxis: [{
        categories: [
			<?php for($i=0;$i<count($data);$i++){if($i>0){echo ',';}?>
				'<?=$data[$i]['tra_cat_name']?>'
			<?php }?>
		],
        crosshair: true
    }],
    yAxis: [{ // Primary yAxis
        labels: {
            format: '',
            style: {
                color: Highcharts.getOptions().colors[2]
            }
        },
        title: {
            text: '',
            style: {
                color: Highcharts.getOptions().colors[2]
            }
        },
        opposite: true

    }, { // Secondary yAxis
        gridLineWidth: 0,
        title: {
            text: 'จำนวนคน',
            style: {
                color: Highcharts.getOptions().colors[0]
            }
        }

    }, { // Tertiary yAxis
        gridLineWidth: 0,
        title: {
            text: 'อัตรการเข้าพัก',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
        labels: {
            format: '{value} %',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
        opposite: true
    }],
    tooltip: {
        shared: true
    },
    legend: {
        layout: 'vertical',
        align: 'left',
        x: 80,
        verticalAlign: 'top',
        y: 55,
        floating: true,
        backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
    },
    series: [{
        name: 'ชาวไทย',
        type: 'column',
        yAxis: 1,
        data: [
			<?php for($i=0;$i<count($data);$i++){if($i>0){echo ',';}?>
			<?=$data[$i]['tra_amount_th']?>
			<?php }?>
		],
        tooltip: {
            valueSuffix: ' คน'
        }

    },{
        name: 'ชาวต่างชาติ',
        type: 'column',
        yAxis: 1,
        data: [
			<?php for($i=0;$i<count($data);$i++){if($i>0){echo ',';}?>
			<?=$data[$i]['tra_amount_en']?>
			<?php }?>
		],
        tooltip: {
            valueSuffix: ' คน'
        }

    }, {
        name: 'อัตรการเข้าพัก',
        type: 'spline',
        yAxis: 2,
        data: [
			<?php for($i=0;$i<=count($data);$i++){if($i>0){echo ',';}?>
			<?=$data[$i]['tra_stay']?>
			<?php }?>
		],
        marker: {
            enabled: false
        },
        dashStyle: 'shortdot',
        tooltip: {
            valueSuffix: ' %'
        }

    }]
});


});
</script>

</html>