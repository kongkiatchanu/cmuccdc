		<style>
		h5.sub-title{color:#99bf3d}
		</style>
		<div class="container">
			<div class="row pt-5">
				<div class="col-md-12">
				<?php 
				$rsProfile = (array)$rsProfile;

				?>
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="THAQI-tab" data-toggle="tab" href="#THAQI" role="tab" aria-controls="THAQI" aria-selected="false">TH (Hourly)</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="USAQI-tab" data-toggle="tab" href="#USAQI" role="tab" aria-controls="USAQI" aria-selected="true">US (Hourly)</a>
						</li>
					</ul>
					<div class="tab-content explain" id="myTabContent">
						<div class="tab-pane fade show active" id="THAQI" role="tabpanel" aria-labelledby="THAQI-tab">
							<div class="row pt-3 mb-5">
								<div class="col-md-6">
									<form class="text-center">
										<div class="form-group">
											<label>ค่า PM2.5 &#x03BC;g/m<sup>3</sup></label> = <?=@$rsProfile['value']->pm25!=null ? $rsProfile['value']->pm25:0?>
										</div>
										<p class="text-center" id="CalculateAQI25GaugeContainer"></p>
										<div class="form-group" style="display:none;">
											<label>PM2.5 AQI เท่ากับ</label>
											<div style="width:150px; margin:0 auto;">
											<input type="text" class="form-control text-center" id="recal25" style="width:150px;" readonly/>
											</div>
										</div>
									</form>
								</div>
								<div class="col-md-6">
									<form class="text-center">
										<div class="form-group">
											<label>ค่า PM10 &#x03BC;g/m<sup>3</sup></label> = <?=@$rsProfile['value']->pm10!=null ? $rsProfile['value']->pm10:0?>
										</div>
										<p class="text-center" id="CalculateAQI10GaugeContainer"></p>
										<div class="form-group" style="display:none;">
											<label>PM10 AQI เท่ากับ</label>
											<div style="width:150px; margin:0 auto;">
											<input type="text" class="form-control text-center" id="recal10" style="width:150px;" readonly/>
											</div>
										</div>
									</form>
								</div>
							</div>
							
							<div class="row pt-3 mb-3" style="display:none;">
								<div class="col-12 mb-3">
									<h5 class="sub-title">PM2.5 & PM10 (&#x03BC;g/m<sup>3</sup>) เฉลี่ยรายชั่วโมง</h5>
									<div class="graph-box">
										<iframe id="sel_chart" width="100%" height="450" src="<?=$this->config->item('base_api')?>assets/api/chart/s/getChartz.php?local=<?=$rsProfile['dustboy_id']?>&key=<?=md5('s'.date('ymdh'))?>" frameborder="0" marginheight="0" marginwidth="0" scrolling="no"></iframe>
									</div>
								</div>
							</div>
							<div class="row pt-3 mb-3">
								<div class="col-6 mb-3">
									<h5 class="sub-title">PM2.5 เฉลี่ยรายวัน (μg/m<sup>3</sup>)</h5>
									<div class="graph-box">
									<iframe src="<?=base_url('chart')?>/davg/?dustboy_id=<?=$rsProfile['dustboy_id']?>&key=<?=md5('signoutz'.date('ymdh'))?>&ch=pm25" marginheight="0" marginwidth="0" scrolling="no" width="100%" height="350" frameborder="0"></iframe>
									</div>
								</div>
								<div class="col-6 mb-3">
									<h5 class="sub-title">PM2.5 TH AQI เฉลี่ยรายวัน</h5>
									<div class="graph-box">
									<iframe src="<?=base_url('chart')?>/davg/?dustboy_id=<?=$rsProfile['dustboy_id']?>&key=<?=md5('signoutz'.date('ymdh'))?>&ch=pm25aqi" marginheight="0" marginwidth="0" scrolling="no" width="100%" height="350" frameborder="0"></iframe>
									</div>
								</div>
							</div>
							<div class="row mb-5">
								<div class="col-md-12">
									<div class="mb-3">
										<h2 class="text-center" style="text-shadow: 2px 2px #C5C5C5;">ดัชนีคุณภาพอากาศของประเทศไทย</h2>
									</div>
									<div class="table-responsive">
										<table class="table table-hover">
											<thead class="thead-dark">
												<tr>
												  <th class="align-middle" width="10%" style="text-align:center;">สัญลักษณ์</th>
												  <th class="align-middle" width="10%" style="text-align:center;">AQI</th>
												  <th class="align-middle" width="15%" style="text-align:center;">PM<sub>2.5</sub><br/>เฉลี่ย 24 ชั่วโมงต่อเนื่อง : &#x03BC;g/m<sup>3</sup></th>
												  <th class="align-middle" width="15%" style="text-align:center;">PM<sub>10</sub><br/>เฉลี่ย 24 ชั่วโมงต่อเนื่อง : &#x03BC;g/m<sup>3</sup></th>
												  <th class="align-middle" width="15%" style="text-align:center;">ความหมาย</th>
												  <th class="align-middle" width="35%" style="text-align:center;">แนวทางการป้องกัน</th>
												</tr>
											</thead>
											<tbody>
											<?php foreach($rsAir as $val){?>
												<tr style="background-color:<?=$val->air_color?>;height: 100px;">
													<td style="text-align:center;"><img src="/template/img/ccdc-0<?=$val->air_id?>-en.png" height="100"></td>
													<td style="vertical-align: middle;text-align:center;"><?=$val->air_range?></td>
													<td style="vertical-align: middle;text-align:center;"><?=$val->air_pm25?></td>
													<td style="vertical-align: middle;text-align:center;"><?=$val->air_pm10?></td>
													<td style="vertical-align: middle;text-align:center;"><?=$val->air_name?></td>
													<td style="vertical-align: middle;"><?=$val->air_detail?></td>
												</tr>
											<?php }?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane fade " id="USAQI" role="tabpanel" aria-labelledby="USAQI-tab">
							<div class="row pt-3 mb-5">
								<div class="col-md-6">
									<form class="text-center">
										<div class="form-group">
											<label>ค่า PM2.5 &#x03BC;g/m<sup>3</sup></label> = <?=@$rsProfile['value']->pm25!=null ? $rsProfile['value']->pm25:0?>
										</div>
										<p class="text-center" id="CalculateUSAQI25GaugeContainer"></p>
										<div class="form-group" style="display:none;">
											<label>PM2.5 AQI เท่ากับ</label>
											<div style="width:150px; margin:0 auto;">
											<input type="text" class="form-control text-center" id="usrecal25" style="width:150px;" readonly/>
											</div>
										</div>
									</form>
								</div>
								<div class="col-md-6">
									<form class="text-center">
										<div class="form-group">
											<label>ค่า PM10 &#x03BC;g/m<sup>3</sup></label> = <?=@$rsProfile['value']->pm10!=null ? $rsProfile['value']->pm10:0?>
										</div>
										<p class="text-center" id="CalculateUSAQI10GaugeContainer"></p>
										<div class="form-group" style="display:none;">
											<label>PM10 AQI เท่ากับ</label>
											<div style="width:150px; margin:0 auto;">
											<input type="text" class="form-control text-center" id="usrecal10" style="width:150px;" readonly/>
											</div>
										</div>
									</form>
								</div>
							</div>
							<!--
							<div class="row">
								<div class="col-12 mb-3">
									<h5 class="sub-title">PM2.5 & PM10 (&#x03BC;g/m<sup>3</sup>) เฉลี่ยรายชั่วโมง</h5>
									<div class="graph-box">
										<iframe id="sel_chart" width="100%" height="450" src="<?=$this->config->item('base_api')?>assets/api/chart/s/getChartz.php?local=<?=$rsProfile['dustboy_id']?>&key=<?=md5('s'.date('ymdh'))?>" frameborder="0" marginheight="0" marginwidth="0" scrolling="no"></iframe>
									</div>
								</div>
							</div>-->
							<div class="row pt-3 mb-3">
								<div class="col-6 mb-3">
									<h5 class="sub-title">PM2.5 เฉลี่ยรายวัน  (μg/m<sup>3</sup>)</h5>
									<div class="graph-box">
									<iframe src="<?=base_url('chart')?>/davgus/?dustboy_id=<?=$rsProfile['dustboy_id']?>&key=<?=md5('signoutz'.date('ymdh'))?>&ch=pm25" marginheight="0" marginwidth="0" scrolling="no" width="100%" height="350" frameborder="0"></iframe>
									</div>
								</div>
								<div class="col-6 mb-3">
									<h5 class="sub-title">PM2.5 US AQI เฉลี่ยรายวัน</h5>
									<div class="graph-box">
									<iframe src="<?=base_url('chart')?>/davgus/?dustboy_id=<?=$rsProfile['dustboy_id']?>&key=<?=md5('signoutz'.date('ymdh'))?>&ch=pm25usaqi" marginheight="0" marginwidth="0" scrolling="no" width="100%" height="350" frameborder="0"></iframe>
									</div>
								</div>
							</div>
							
							<div class="row mb-5">
								<div class="col-md-12">
									<div class="mb-3">
										<h2 class="text-center" style="text-shadow: 2px 2px #C5C5C5;">Air Quality Index scale as defined by<br/> the US-EPA 2016 standard</h2>
									</div>
									<p><img src="/template/img/db-01.jpg" style="width:100%"></p>
								</div>
							</div>
						</div>
					</div>
					
					
				</div>
			</div>
		</div>
		
		<script src="<?=base_url()?>assets/plugins/3Dchart/d3.v2.js"></script>
		<script src="<?=base_url()?>assets/plugins/3Dchart/gauge.js?v=456"></script>
		<script src="<?=base_url()?>assets/plugins/3Dchart/init.js?v=4"></script>
		<script>
		$(document).ready(function(){
			var pm25 = <?=@$rsProfile['value']->pm25!=null ? $rsProfile['value']->pm25:0?>;
			var pm10 = <?=@$rsProfile['value']->pm10!=null ? $rsProfile['value']->pm10:0?>;
			
			if(pm25>0){
				calAQI25(pm25);
				calAQI10(pm10);
				calUSAQI25(pm25);
				calUSAQI10(pm10);
			}
			
			function calAQI25(dd){
				$.get( "<?=base_url()?>assets/php/getCalAQIValue.php?v="+dd+"&t=25&cal=th", function( data ) {
					gauges['CalculateAQI25'].redraw(parseFloat(data));
					$('#recal25').val(data);		
				});
			}
			
			function calAQI10(dd){
				$.get( "<?=base_url()?>assets/php/getCalAQIValue.php?v="+dd+"&t=10&cal=th", function( data ) {
					gauges['CalculateAQI10'].redraw(parseFloat(data));
					$('#recal10').val(data);		
				});
			}
			
			function calUSAQI25(dd){
				$.get( "<?=base_url()?>assets/php/getCalAQIValue.php?v="+dd+"&t=25&cal=us", function( data ) {
					gauges['CalculateUSAQI25'].redraw(parseFloat(data));
					$('#usrecal25').val(data);		
				});
			}
			
			function calUSAQI10(dd){
				$.get( "<?=base_url()?>assets/php/getCalAQIValue.php?v="+dd+"&t=10&cal=us", function( data ) {
					gauges['CalculateUSAQI10'].redraw(parseFloat(data));
					$('#usrecal10').val(data);		
				});
			}
			
			calculateGauges25();
			calculateGauges10();
			calculateUSGauges25();
			calculateUSGauges10();
		});
		</script>
		
		
	
