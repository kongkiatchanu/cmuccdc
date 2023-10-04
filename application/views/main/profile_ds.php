<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $rsProfile = (array)$rsProfile;?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$siteInfo['pre_title']?> | <?=$siteInfo['site_title']?></title>
	<meta name="description" content="<?=$siteInfo['site_des']?>">
	<meta name="keywords" content="<?=$siteInfo['site_keyword']?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>template/image/icon_ccdc.ico">
    <link rel="stylesheet" href="<?=base_url()?>template/css/bootstrap-4.3.1/bootstrap.min.css">
    <link rel="stylesheet" href="<?=base_url()?>template/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="<?=base_url()?>template/css/style2.min.css">
    <script src="<?=base_url()?>template/js/jquery/jquery.min.js"></script>
	<?php $this->load->view('main/analytics');?>
	<style>
		.page_title{color:#fff;}
		@media (max-width: 575.98px) {.container{max-width:100%!important;}.page_title{font-size:20px;}}
		@media (min-width: 576px) and (max-width: 767.98px) { .container{max-width:100%!important;}.page_title{font-size:22px;}}
		@media (min-width: 768px) and (max-width: 991.98px) { .container{max-width:100%!important;}.page_title{font-size:30px;}}
		.sub-section{border-bottom: 2px solid #99bf3d;padding-bottom: 10px;}
		#airDetail .forus{color:rgb(<?=$rsProfile['value']->us_color?>);}
			#airDetail .forth{margin: 30px 0 0 0;color:rgb(<?=$rsProfile['value']->th_color?>);}
			#airDetail .number{margin: 30px 0 0 0;}
			#airDetail .number div#pm{font-size: 50px;border-radius: 50%;border: 3px solid;padding: 7px 7px;width:110px; margin:0 auto;}
			#airDetail .number div#pm span{display: block;font-size: x-small;}
			#airDetail .number div#detail p{margin:0;}
			#airDetail .number div#detail p.des{margin:0 0 10px 0;font-size:20px;}
			#airDetail .number div#detail p.unit{color:#666;font-size:small}
			#airDetail .number div#detail span.timer{color:#666;font-size:small;display: block;}
			.table td, .table th {padding:3px;}
			.chart-title{font-size:16px;}
			h3.aqi-title{text-shadow: 2px 2px #C5C5C5;}
			@media (max-width: 575.98px) {
				#th_map{height:250px;width:100%}
				#airDetail .number {margin: 20px 0 0 0;}
				#airDetail .number div#detail{text-align: center;}
				#airDetail .number div#detail span.timer{display: unset;}
				h3.aqi-title{text-shadow: 2px 2px #C5C5C5;font-size:20px;}
			}
	</style>
</head>
<body>
	<input type="hidden" id="db_lat" value="<?=$rsProfile['dustboy_lat']?>">
	<input type="hidden" id="db_lng" value="<?=$rsProfile['dustboy_lng']?>">
	<input type="hidden" id="db_name" value="<?=$rsProfile['dustboy_name_th']?>">
	<section id="main">
        <div class="container-fluid">
			<div class="row mb-3">
					<div class="col-sm-12 pt-3 pb-3">
						<h4 class="sub-section"><?=$rsProfile['dustboy_name_th']?></h4>
						<div class="row mb-3" id="airDetail">
							<div style="width:50%;padding:0 15px;float:left;">
								<div class="row number forth">
									<div style="width:40%;padding:0 15px;" class="text-center"><div id="pm"><?=$rsProfile['value']!=null? $rsProfile['value']->pm25 : '-'?><span>μg/m<sup>3</sup></span></div></div>
									<div style="width:60%;padding:0 15px;" class="pt-3 pb-3">
										<div id="detail">
											<p class="des"><?=$rsProfile['value']!=null? $rsProfile['value']->th_title: 'ไม่มีข้อมูล'?></p>
											<span class="timer"><i class="far fa-calendar-alt"></i> <?=$rsProfile['value']!=null? getProfileDate($rsProfile['value']->log_datetime,0) : '-'?></span>
											<span class="timer"><i class="far fa-clock"></i> <?=$rsProfile['value']!=null? getProfilehour($rsProfile['value']->log_datetime) : '-'?></span>
										</div>
									</div>
								</div>
							</div>
							<div style="width:50%;padding:0 15px;float:right;">
								<p class="text-center" id="CalculateAQI25GaugeContainer"></p>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
			</div>
			<!--
			<div class="row mb-3">
				<div class="col-md-12">
					<h5 class="chart-title">PM<sub>2.5</sub> (μg/m<sup>3</sup>) Hourly</h5>
					<div class="chart_box">
						<iframe src="https://www.cmuccdc.org/assets/php/getDatabaseColumnChart.php?reportType=h&dataType=pm25&source=<?=$rsProfile['dustboy_id']?>&key=<?=md5('s'.date('ymdh'))?>" marginheight="0" marginwidth="0" scrolling="no" width="100%" height="150" frameborder="0"></iframe>
					</div>
				</div>
			</div>
									
			<div class="row mb-3">
				<div class="col-md-6">
					<h5 class="chart-title">PM<sub>2.5</sub> (μg/m<sup>3</sup>) Daily</h5>
					<div class="chart_box">
						<iframe src="https://www.cmuccdc.org/assets/php/getDatabaseColumnChart.php?reportType=d&dataType=pm25&source=<?=$rsProfile['dustboy_id']?>&key=<?=md5('s'.date('ymdh'))?>" marginheight="0" marginwidth="0" scrolling="no" width="100%" height="150" frameborder="0"></iframe>
					</div>
				</div>
				<div class="col-md-6">
					<h5 class="chart-title">PM<sub>2.5</sub> TH AQI Daily</h5>
						<div class="chart_box">
							<iframe src="https://www.cmuccdc.org/assets/php/getDatabaseColumnChart.php?reportType=d&dataType=pm25thaqi&source=<?=$rsProfile['dustboy_id']?>&key=<?=md5('s'.date('ymdh'))?>" marginheight="0" marginwidth="0" scrolling="no" width="100%" height="150" frameborder="0"></iframe>
						</div>
					</div>
			</div>-->
		</div>
	</section>
	<script src="<?=base_url()?>template/js/popper/popper.min.js"></script>
    <script src="<?=base_url()?>template/js/bootstrap-4.3.1/bootstrap.min.js"></script>
	<script src="<?=base_url()?>assets/plugins/3Dchart/d3.v2.js"></script>
	<script src="<?=base_url()?>assets/plugins/3Dchart/gauge.profile.js?v=111"></script>
	<script src="<?=base_url()?>assets/plugins/3Dchart/init.profile.js?v=3"></script>
	<script>
		var db_lat = $('#db_lat').val();
		var db_lng = $('#db_lng').val();

		$(document).ready(function(){
			var pm25 = <?=@$rsProfile['value']->pm25!=null ? $rsProfile['value']->pm25:0?>;
			if(pm25>0){
				calAQI25(pm25);
			}
			function calAQI25(dd){
				$.get( "<?=base_url()?>assets/php/getCalAQIValue.php?v="+dd+"&t=25&cal=th", function( data ) {
					gauges['CalculateAQI25'].redraw(parseFloat(dd));
				});
			}
			calculateGauges25();
		});			
	</script>
</body>
</html>

		
	
