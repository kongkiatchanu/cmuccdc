<?php
	include "connect.php";
	
	$sql="SELECT * FROM od_amphur 
	LEFT JOIN od_province on od_amphur.PROVINCE_ID = od_province.PROVINCE_ID
	WHERE od_amphur.AMPHUR_ID = ".mysqli_real_escape_string($mysqli, $_GET['am'])."";
	$q=$mysqli->query($sql);
	$rs_am = $q->fetch_assoc();
	if($rs_am==null){
		header("Location: /");
		exit();
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
        text: 'ข้อมูลผู้ป่วย'
    },

    subtitle: {
        text: 'อำเภอ<?=$rs_am['AMPHUR_NAME']?> จังหวัด<?=$rs_am['PROVINCE_NAME']?> ปี <?=($_GET['y']+543)?>'
    },

	xAxis: {
        categories: ["ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค."]
    },
    yAxis: {
        title: {
            text: 'จำนวนประชากร'
        }
    },

    plotOptions: {

    },

    series: [
		<?php
			$sql="SELECT * FROM od_disease";
			$q=$mysqli->query($sql);
			$i=0;
			while($rs=$q->fetch_assoc()){$i++;
		?>
		<?php if($i>1){echo ',';}?>
			{
				name: '<?=$rs['dis_name']?>',
				data: [
				<?php
					$sql2="SELECT * FROM `od_patientz` WHERE `pat_dis_id` = ".$rs['dis_id']." AND `pat_amphur_id` = ".mysqli_real_escape_string($mysqli, $_GET['am'])." AND `pat_groupdate` LIKE '%".mysqli_real_escape_string($mysqli, $_GET['y'])."%' order by `pat_groupdate` ASC ";
					$q2=$mysqli->query($sql2);
					$j=0;
					while($rs2=$q2->fetch_assoc()){$j++;?>
					<?php if($j>1){echo ',';}?>
					<?=($rs2['pat_male']+$rs2['pat_female'])?>
				<?php
					}
				?>
				]
			}
		<?php
			}
		?>
	],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }

});
});
</script>

</html>