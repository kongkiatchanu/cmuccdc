<?php $rsProfile = (array) $rsProfile; ?>
<?php
function report_typePM25R($val)
{
	if ($val > 0) {
		if ($val <= 25) {
			$txt = '0-25';
		} else if ($val > 25 && $val <= 37) {
			$txt = '26-37';
		} else if ($val > 37 && $val <= 50) {
			$txt = '28-50';
		} else if ($val > 50 && $val <= 90) {
			$txt = '51-90';
		} else if ($val > 90 && $val <= 600) {
			$txt = '>90';
		} else {
			$txt = '>90';
		}
	} else {
		$txt = '';
	}
	return $txt;
}

function report_typePM25RUS($val)
{
	if ($val > 0) {
		if ($val <= 12) {
			$txt = '0-12';
		} else if ($val > 13 && $val <= 35) {
			$txt = '13-35';
		} else if ($val > 36 && $val <= 55) {
			$txt = '36-55';
		} else if ($val > 56 && $val <= 150) {
			$txt = '56-150';
		} else if ($val > 151 && $val <= 250) {
			$txt = '151-250';
		} else if ($val > 250) {
			$txt = '>250';
		}
	} else {
		$txt = '';
	}
	return $txt;
}

?>
<style>
	.db_profile {
		background-color: #f9f6f6;
	}

	.db_profile .nav-tabs {
		border: none;
	}

	.db_profile .nav-tabs .nav-link.active {
		border-color: #fff;
		border-radius: 0;
		color: #99bf3d
	}

	.db_profile .nav-tabs .nav-link {
		color: #333
	}

	#myTabContent {
		background-color: #fff;
	}

	#th_map {
		height: 300px;
		width: 100%
	}

	.sub-section {
		border-bottom: 2px solid #99bf3d;
		padding-bottom: 10px;
	}

	#airDetail .forus {
		color: rgb(
				<?= $rsProfile['value']->us_color ?>
			);
	}

	#airDetail .forth {
		margin: 30px 0 0 0;
		color: rgb(
				<?= $rsProfile['value']->th_color ?>
			);
	}

	#airDetail .number {
		margin: 30px 0 0 0;
	}

	#airDetail .number div#pm {
		font-size: 50px;
		border-radius: 50%;
		border: 3px solid;
		padding: 7px 7px;
		width: 110px;
		margin: 0 auto;
	}

	#airDetail .number div#pm span {
		display: block;
		font-size: x-small;
	}

	#airDetail .number div#detail p {
		margin: 0;
	}

	#airDetail .number div#detail p.des {
		margin: 0 0 10px 0;
		font-size: 20px;
	}

	#airDetail .number div#detail p.unit {
		color: #666;
		font-size: small
	}

	#airDetail .number div#detail span.timer {
		color: #666;
		font-size: small;
		display: block;
	}

	.table td,
	.table th {
		padding: 3px;
	}

	.chart-title {
		font-size: 16px;
	}

	h3.aqi-title {
		text-shadow: 2px 2px #C5C5C5;
	}

	@media (max-width: 575.98px) {
		#th_map {
			height: 250px;
			width: 100%
		}

		#airDetail .number {
			margin: 20px 0 0 0;
		}

		#airDetail .number div#detail {
			text-align: center;
		}

		#airDetail .number div#detail span.timer {
			display: unset;
		}

		h3.aqi-title {
			text-shadow: 2px 2px #C5C5C5;
			font-size: 20px;
		}
	}
</style>

<div class="db_profile">
	<input type="hidden" id="db_lat" value="<?= $rsProfile['dustboy_lat'] ?>">
	<input type="hidden" id="db_lng" value="<?= $rsProfile['dustboy_lng'] ?>">
	<input type="hidden" id="db_name" value="<?= $rsProfile['dustboy_name_th'] ?>">
	<div id="th_map"></div>
	<div class="container">

		<div class="row pt-3">
			<div class="col-md-12">
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="THAQI-tab" data-toggle="tab" href="#THAQI" role="tab"
							aria-controls="THAQI" aria-selected="false">TH</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="USAQI-tab" data-toggle="tab" href="#USAQI" role="tab"
							aria-controls="USAQI" aria-selected="true">US</a>
					</li>
				</ul>
				<div class="tab-content explain" id="myTabContent">
					<div class="p-3 tab-pane fade show active" id="THAQI" role="tabpanel" aria-labelledby="THAQI-tab">
						<div class="row" style="margin-bottom:50px;">
							<div class="col-sm-12">
								<h4 class="sub-section">Air Quality</h4>
								<div class="row mb-3" id="airDetail">
									<div class="col-md-6">
										<div class="row number forth">
											<div class="col-sm-5 text-center">
												<div id="pm">
													<?= $rsProfile['value'] != null ? $rsProfile['value']->pm25 : '-' ?><span>μg/m<sup>3</sup></span>
												</div>
											</div>
											<div class="col-sm-7 pt-3 pb-3">
												<div id="detail">
													<?php if ($_lang == 'thailand') { ?>
														<p class="des">
															<?= $rsProfile['value'] != null ? $rsProfile['value']->th_title : 'ไม่มีข้อมูล' ?>
														</p>
														<span class="timer"><i class="far fa-calendar-alt"></i>
															<?= $rsProfile['value'] != null ? getProfileDate($rsProfile['value']->log_datetime, 0) : '-' ?>
														</span>
														<span class="timer"><i class="far fa-clock"></i>
															<?= $rsProfile['value'] != null ? getProfilehour($rsProfile['value']->log_datetime) : '-' ?>
														</span>
													<?php } else { ?>
														<p class="des">
															<?= $rsProfile['value'] != null ? $rsProfile['value']->th_title_en : '-' ?>
														</p>
														<span class="timer"><i class="far fa-calendar-alt"></i>
															<?= $rsProfile['value'] != null ? date('D, d-M-y', strtotime($rsProfile['value']->log_datetime, 0)) : '-' ?>
														</span>
														<span class="timer"><i class="far fa-clock"></i>
															<?= $rsProfile['value'] != null ? date('H:i', strtotime($rsProfile['value']->log_datetime, 0)) : '-' ?>
														</span>

													<?php } ?>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<p class="text-center" id="CalculateAQI25GaugeContainer"></p>
									</div>

								</div>
								<div class="row mb-3">
									<div class="col-md-12">
										<h5 class="chart-title">PM<sub>2.5</sub> (μg/m<sup>3</sup>) Hourly</h5>
										<div class="chart_box">
											<iframe
												src="https://www.cmuccdc.org/assets/php/getDatabaseColumnChart2.php?reportType=h&dataType=pm25&source=<?= $rsProfile['dustboy_id'] ?>&key=<?= md5('s' . date('ymdh')) ?>"
												marginheight="0" marginwidth="0" scrolling="no" width="100%"
												height="250" frameborder="0"></iframe>
										</div>
									</div>
								</div>

								<div class="row mb-3">
									<div class="col-md-12">
										<h5 class="chart-title">PM<sub>2.5</sub> (μg/m<sup>3</sup>) Daily</h5>
										<div class="chart_box">
											<iframe
												src="https://www.cmuccdc.org/assets/php/getDatabaseColumnChart.php?reportType=d&dataType=pm25&source=<?= $rsProfile['dustboy_id'] ?>&key=<?= md5('s' . date('ymdh')) ?>"
												marginheight="0" marginwidth="0" scrolling="no" width="100%"
												height="250" frameborder="0"></iframe>
										</div>
									</div>

								</div>
							</div>
						</div>
						<style>
							.dforcast {
								color: #fff;
								margin: 0;
								font-size: 16px;
								text-align: center;
								padding: 5px 0;
								border-top-right-radius: 10px;
								border-top-left-radius: 10px;
							}

							.bforcast_content {
								padding: 10px;
								color: #333;
								border-bottom-right-radius: 10px;
								border-bottom-left-radius: 10px;
							}

							.bforcast_content span.detail {
								font-size: x-small;
								padding: 5px;
								background-color: #fff;
								border-radius: 5px;
							}

							.forcastchart {
								height: 250px;
								width: 100%
							}

							.bforcast {
								cursor: pointer;
							}

							.us_bforcast {
								cursor: pointer;
							}
						</style>

					
						<div class="row" style="margin-bottom:50px;">
							<div class="col-md-12">
								<div class="mb-3">
									<h3 class="text-center aqi-title">
										<?= $_lang == 'thailand' ? 'ดัชนีคุณภาพอากาศของประเทศไทย' : 'Thailand Air Quality Index' ?>
									</h3>
								</div>
								<div class="table-responsive">
									<table class="table table-hover">
										<thead class="thead-dark">
											<?php if ($_lang == "thailand") { ?>
												<tr>
													<th class="align-middle" width="10%" style="text-align:center;">
														สัญลักษณ์</th>
													<th class="align-middle" width="15%" style="text-align:center;">
														PM<sub>2.5</sub><br />เฉลี่ย 24 ชั่วโมงต่อเนื่อง :
														&#x03BC;g/m<sup>3</sup></th>
													<th class="align-middle" width="15%" style="text-align:center;">
														PM<sub>10</sub><br />เฉลี่ย 24 ชั่วโมงต่อเนื่อง :
														&#x03BC;g/m<sup>3</sup></th>
													<th class="align-middle" width="16%" style="text-align:center;">ความหมาย
													</th>
													<th class="align-middle" width="37%" style="text-align:center;">
														แนวทางการป้องกัน</th>
												</tr>
											<?php } else { ?>
												<tr>
													<th class="align-middle" width="10%" style="text-align:center;">Symbol
													</th>
													<th class="align-middle" width="15%" style="text-align:center;">
														PM<sub>2.5</sub><br />(daily average) : &#x03BC;g/m<sup>3</sup></th>
													<th class="align-middle" width="15%" style="text-align:center;">
														PM<sub>10</sub><br />(daily average) : &#x03BC;g/m<sup>3</sup></th>
													<th class="align-middle" width="16%" style="text-align:center;">AQI
														category</th>
													<th class="align-middle" width="37%" style="text-align:center;">
														Description of Air quality</th>
												</tr>
											<?php } ?>

										</thead>
										<tbody>
											<?php foreach ($rsAir as $val) { ?>
												<tr style="background-color:<?= $val->air_color ?>;height: 100px;">
													<td style="text-align:center;"><img
															src="/template/img/ccdc-0<?= $val->air_id ?>-en.png" height="100">
													</td>

													<td style="vertical-align: middle;text-align:center;">
														<?= $val->air_pm25 ?></td>
													<td style="vertical-align: middle;text-align:center;">
														<?= $val->air_pm10 ?></td>
													<td style="vertical-align: middle;text-align:center;">
														<?= $_lang == "thailand" ? $val->air_name : $val->air_name_en ?>
													</td>
													<td style="vertical-align: middle;">
														<?= $_lang == "thailand" ? $val->air_detail : $val->air_detail_en ?></td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="p-3 tab-pane fade" id="USAQI" role="tabpanel" aria-labelledby="USAQI-tab">
						<div class="row mb-3">

							<div class="col-sm-12">
								<h4 class="sub-section">Air Quality</h4>
								<div class="row mb-3" id="airDetail">
									<div class="col-md-6">
										<div class="row number forus">
											<div class="col-sm-5 text-center">
												<div id="pm">
													<?= $rsProfile['value'] != null ? $rsProfile['value']->pm25 : '-' ?><span>μg/m<sup>3</sup></span>
												</div>
											</div>
											<div class="col-sm-7 pt-3 pb-3">
												<div id="detail">
													<?php if ($_lang == 'thailand') { ?>
														<p class="des">
															<?= $rsProfile['value'] != null ? $rsProfile['value']->us_title : 'ไม่มีข้อมูล' ?>
														</p>
														<span class="timer"><i class="far fa-calendar-alt"></i>
															<?= $rsProfile['value'] != null ? getProfileDate($rsProfile['value']->log_datetime, 0) : '-' ?>
														</span>
														<span class="timer"><i class="far fa-clock"></i>
															<?= $rsProfile['value'] != null ? getProfilehour($rsProfile['value']->log_datetime) : '-' ?>
														</span>
													<?php } else { ?>
														<p class="des">
															<?= $rsProfile['value'] != null ? $rsProfile['value']->us_title_en : '-' ?>
														</p>
														<span class="timer"><i class="far fa-calendar-alt"></i>
															<?= $rsProfile['value'] != null ? date('D, d-M-y', strtotime($rsProfile['value']->log_datetime, 0)) : '-' ?>
														</span>
														<span class="timer"><i class="far fa-clock"></i>
															<?= $rsProfile['value'] != null ? date('H:i', strtotime($rsProfile['value']->log_datetime, 0)) : '-' ?>
														</span>
													<?php } ?>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<p class="text-center" id="CalculateUSAQI25GaugeContainer"></p>
									</div>

								</div>
								<div class="row mb-3">
									<div class="col-md-12">
										<h5 class="chart-title">PM<sub>2.5</sub> (μg/m<sup>3</sup>) Hourly</h5>
										<div class="chart_box">
											<iframe
												src="https://www.cmuccdc.org/assets/php/getDatabaseColumnChartUS.php?reportType=h&dataType=pm25&source=<?= $rsProfile['dustboy_id'] ?>&key=<?= md5('s' . date('ymdh')) ?>"
												marginheight="0" marginwidth="0" scrolling="no" width="100%"
												height="250" frameborder="0"></iframe>
										</div>
									</div>
								</div>

								<div class="row mb-3">
									<div class="col-md-6">
										<h5 class="chart-title">PM<sub>2.5</sub> (μg/m<sup>3</sup>) Daily</h5>
										<div class="chart_box">
											<iframe
												src="https://www.cmuccdc.org/assets/php/getDatabaseColumnChartUS.php?reportType=d&dataType=pm25&source=<?= $rsProfile['dustboy_id'] ?>&key=<?= md5('s' . date('ymdh')) ?>"
												marginheight="0" marginwidth="0" scrolling="no" width="100%"
												height="250" frameborder="0"></iframe>
										</div>
									</div>
									<div class="col-md-6">
										<h5 class="chart-title">PM<sub>2.5</sub> US AQI Daily</h5>
										<div class="chart_box">
											<iframe
												src="https://www.cmuccdc.org/assets/php/getDatabaseColumnChartUS.php?reportType=d&dataType=pm25thaqi&source=<?= $rsProfile['dustboy_id'] ?>&key=<?= md5('s' . date('ymdh')) ?>"
												marginheight="0" marginwidth="0" scrolling="no" width="100%"
												height="250" frameborder="0"></iframe>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="row mb-5">
							<div class="col-md-12">
								<div class="mb-3">
									<h3 class="text-center aqi-title">Air Quality Index scale as defined by<br /> the
										US-EPA 2016 standard</h3>
								</div>
								<?php if ($_lang == 'thailand') { ?>
									<p><img src="/template/img/us-01.jpg" style="width:100%"></p>
								<?php } else { ?>
									<p><img src="/template/img/us-02.jpg" style="width:100%"></p>
								<?php } ?>

							</div>
						</div>
					</div>
				</div>
			</div>

			
		</div>
		<div class="col-md-12 mb-5" style="background-color:#fff">
					<a target="_blank" href="<?=base_url()?>download_json/<?=$rsProfile['dustboy_id']?>" class="btn btn-secondary btn-sm"><i class="fa fa-globe "></i> JSON</a>
					<a target="_blank" href="<?=base_url()?>download_excel/<?=$rsProfile['dustboy_id']?>" class="btn btn-success btn-sm"><i class="fa fa-download"></i> Excel</a>
			</div>
		
	</div>


</div>

<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/leaflet/leaflet.css" />
<script src="<?= base_url() ?>assets/plugins/leaflet/leaflet.js?v=signoutz"></script>

<script>
	var db_lat = $('#db_lat').val();
	var db_lng = $('#db_lng').val();
	var db_name = $('#db_name').val();

	var map = L.map("th_map", {
		attributionControl: !1,
		minZoom: 12,
		maxZoom: 14
	});
	map.setView([db_lat, db_lng], 13);
	L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);


	L.marker([db_lat, db_lng]).addTo(map)
		.bindPopup(db_name)
		.openPopup();
</script>