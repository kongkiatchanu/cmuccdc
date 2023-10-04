		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<style>
			.form-filler {
				border-top: 5px solid #0c364c;
				padding: 20px 15px;
				background-color: #f8f8f8;
			}
		</style>
		<?php $mm =array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");?>
		<div class="container mb-5" style="background: white url(<?=$this->config->item("base_api")?>template_hazedata/img/header-pic2.png) no-repeat top;">
			<div class="row pt-5 pb-2">
				<div class="col-lg-9">

					<div class="form-filler">
						<h3>Parameter</h3><hr/>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">DustBoy :</label>
							<div class="col-sm-10">
								<select class="form-control" id="dustboy">			
									<option value=""> เลือกจุดตรวจวัด </option>
									<?php foreach($rsRegion as $item){?>
									<optgroup label="<?=$item->zone_name_th?>">
										<?php if($item->provinces!=null){?>
											<?php foreach($item->provinces as $province){?>
											<optgroup label="&nbsp;&nbsp;&nbsp;&nbsp;<?=$province->province_name_th?>">
												<?php if($province->stations!=null){?>
													<?php foreach($province->stations as $station){?>
														<option value="<?=$station->source_id?>">&nbsp;&nbsp;&nbsp;&nbsp; <?=$station->location_name?></option>
													<?php }?>
												<?php }?>
											</optgroup>
											<?php }?>
										<?php }?>
									</optgroup>
									<?php }?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Report Type :</label>
							<div class="col-sm-10">
								<select class="form-control" id="report_type">			
									<option value="h">เฉลี่ยรายชั่วโมง (Hourly)</option>
									<option value="d">เฉลี่ยรายวัน (Daily)</option>
									<option value="m">เฉลี่ยรายเดือน (Monthly)</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Type Detail:</label>
							<div class="col-sm-10">
								<div id="distance_h">
									<div class="row">
										<div class="col-sm-3 col-6">
											<input type="text" class="form-control datepicker_h mb-2" id="h_start" value="<?=date('Y-m-d', strtotime('-6 days'))?>">
										</div>
										<div class="col-sm-3 col-6">
											<input type="text" class="form-control datepicker_h mb-2" id="h_end" value="<?=date('Y-m-d')?>">
											<input type="hidden" class="form-control mb-2" id="h_time_start" value="00:00">
										</div>
										<div class="col-sm-3 col-6">
											
										</div>
										<div class="col-sm-3 col-6">
											<input type="hidden" class="form-control mb-2" id="h_time_end" value="23:59">
										</div>
									</div>
								</div>
								<div id="distance_d" style="display:none;">
									<div class="row">
										<div class="col-sm-4 col-6">
											<input type="text" class="form-control datepicker_d mb-2" id="d_start" value="<?=date('Y-m-d', strtotime('-29 days'))?>">
										</div>
										<div class="col-sm-4 col-6">
											<input type="text" class="form-control datepicker_d mb-2" id="d_end" value="<?=date('Y-m-d')?>">
										</div>
									</div>
								</div>
								<div id="distance_m" style="display:none;">
									<div class="row">
										<div class="col-sm-4 col-6">
											<select id="fm" class="form-control mb-2">
												<?php for($i=0; $i<date('m'); $i++){?>
												<?php $year = date('Y').'-';?>
												<?php $m = ($i+1)>9? $i+1:'0'.($i+1);?>
												<?php $yearm = $year.$m;?>
												<option value="<?=$yearm?>"><?=$mm[$i]?></option>
												<?php }?>
											</select>
										</div>
										<div class="col-sm-4 col-6">
											<select id="lm" class="form-control mb-2">
												<?php for($i=0; $i<date('m'); $i++){?>
												<?php $year = date('Y').'-';?>
												<?php $m = ($i+1)>9? $i+1:'0'.($i+1);?>
												<?php $yearm = $year.$m;?>
												<option value="<?=$yearm?>"><?=$mm[$i]?></option>
												<?php }?>
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Data Type :</label>
							<div class="col-sm-10" style="padding-top: 10px;">
								<div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="datatype" id="inlineRadio1" value="pm25" checked>
                                    <label class="form-check-label" for="inlineRadio1">PM 2.5</label>
                                </div>
								<div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="datatype" id="inlineRadio2" value="pm10">
                                    <label class="form-check-label" for="inlineRadio2">PM 10</label>
                                </div>
								<div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="datatype" id="inlineRadio3" value="temp">
                                    <label class="form-check-label" for="inlineRadio3">Temperature</label>
                                </div>
								<div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="datatype" id="inlineRadio4" value="humid">
                                    <label class="form-check-label" for="inlineRadio4">Humidity</label>
                                </div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-10 offset-md-2">
								<button type="button" class="btn btn-info mb-1" id="btnTable"><i class="fa fa-table"></i> Table Data </button>
								<button type="button" class="btn btn-info mb-1" id="btnColumn"><i class="fas fa-chart-bar"></i> Column Chart</button>
								<button type="button" class="btn btn-info mb-1" id="btnLine"><i class="fas fa-chart-line"></i> Line Chart</button>
							</div>
						</div>
					</div>
				
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-filler">
						<div id="loader" style="display:none;">
							<p class="text-center"><img style="max-width:100%" src="<?=base_url()?>template/image/loader.gif"></p>
						</div>
						<div id="displayResult"></div>
						<!--<div class="clear"></div>
						<p class="text-center" id="txtResult"></p>-->
					</div>
				</div>
			</div>
		</div>
		
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script>
        $( document ).ready(function() {
			var timeStamp = function(str) {
			  return new Date(str.replace(/^(\d{2}\-)(\d{2}\-)(\d{4})$/,
				'$2$1$3')).getTime();
			};

			$('#report_type').change(function(){
				var d_type =  $(this).val();
				if(d_type=="h"){
					$('#distance_h').show();
					$('#distance_d').hide();
					$('#distance_m').hide();
				}else if(d_type=="d"){
					$('#distance_h').hide();
					$('#distance_d').show();
					$('#distance_m').hide();
				}else if(d_type=="m"){
					$('#distance_h').hide();
					$('#distance_d').hide();
					$('#distance_m').show();
				}
			});
		
			$('.datepicker_h').datepicker({ 
				dateFormat: 'yy-mm-dd',
				minDate: '<?=date('Y-m-d', strtotime('-6 days'))?>' 
			});
			$('.datepicker_d').datepicker({ 
				dateFormat: 'yy-mm-dd',
				minDate: '<?=date('Y-m-d', strtotime('-29 days'))?>' 
			});
			
			function getTextResult(){
				if($('input[name=datatype]:checked').val()=="pm25"){
					$('#txtResult').html('ค่ามาตรฐาน PM2.5 = 50 ug/m3');
				}else if($('input[name=datatype]:checked').val()=="pm10"){
					$('#txtResult').html('ค่ามาตรฐาน PM10 = 120 ug/m3');
				}else{
					$('#txtResult').html('');
				}
			}
			
			$('#btnTable').click(function(){
				$('#loader').show();
				if($('#dustboy').val()){
					if( $('#report_type').val()=="h"){
						if($('#h_time_start').val()!="" && $('#h_time_end').val()!=""){
						//if( timeStamp($('#h_start').val()+' '+$('#h_time_start').val()) <= timeStamp($('#h_end').val()+' '+$('#h_time_end').val())){
							var dataType=$('input[name=datatype]:checked').val();
							$.get( "<?=base_url()?>assets/php/s/getDatabaseTable.php", {key:'<?=md5('s'.date('ymdj'))?>', reportType:$('#report_type').val(), dataType:dataType, dt:$('#h_start').val(), de:$('#h_end').val(), source: $('#dustboy').val(), h_time_start:$('#h_time_start').val(), h_time_end:$('#h_time_end').val()} ) .done(function( data ) {
								$('#displayResult').html(data);
								$('#loader').hide();
							});
							getTextResult();
						//}else{alert('วันที่ หรือ เวลาไม่ถูกต้อง1');}
						}else{alert('วันที่ หรือ เวลาไม่ถูกต้อง');}
					}else if($('#report_type').val()=="d"){
						if( timeStamp($('#d_start').val()) <= timeStamp($('#d_end').val())){
							var dataType=$('input[name=datatype]:checked').val();
							$.get( "<?=base_url()?>assets/php/s/getDatabaseTable.php", {key:'<?=md5('s'.date('ymdj'))?>',reportType:$('#report_type').val(), dataType:dataType, dt:$('#d_start').val(), de:$('#d_end').val(), source: $('#dustboy').val()} ) .done(function( data ) {
								$('#displayResult').html(data);
								$('#loader').hide();
							});
							getTextResult();
						}else{alert('วันที่ไม่ถูกต้อง');}
					}else if($('#report_type').val()=="m"){
						var dataType=$('input[name=datatype]:checked').val();
						if( timeStamp($('#fm').val()) <= timeStamp($('#lm').val())){
							$.get( "<?=base_url()?>assets/php/s/getDatabaseTable.php", {key:'<?=md5('s'.date('ymdj'))?>',reportType:$('#report_type').val(), dataType:dataType, fm:$('#fm').val(), lm:$('#lm').val(), source: $('#dustboy').val()} ) .done(function( data ) {
								$('#displayResult').html(data);
								$('#loader').hide();
							});
						}else{alert('วันที่ไม่ถูกต้อง');}
						
					}
				}else{alert('กรุณาเลือกจุดตรวจวัด');}
			});
			$('#btnColumn').click(function(){
				$('#loader').show();
				console.log('loader');
				if($('#dustboy').val()){
					if( $('#report_type').val()=="h"){
						if($('#h_time_start').val()!="" && $('#h_time_end').val()!=""){
						//if( timeStamp($('#h_start').val()+' '+$('#h_time_start').val()) <= timeStamp($('#h_end').val()+' '+$('#h_time_end').val())){
							var dataType=$('input[name=datatype]:checked').val();
							var URL  ='<?=base_url()?>assets/php/s/getDatabaseColumnChart.php?reportType='+$('#report_type').val()+'&dataType='+dataType+'&dt='+$('#h_start').val()+'&de='+$('#h_end').val()+'&source='+$('#dustboy').val()+'&h_time_start='+$('#h_time_start').val()+'&h_time_end='+$('#h_time_end').val()+'&key=<?=md5('s'.date('ymdh'))?>';
							var data ='<iframe width="100%" height="550" src="'+URL+'" frameborder="0" marginheight="0" marginwidth="0" scrolling="no"></iframe>';
							$('#displayResult').html(data);
							$('#loader').hide();
							getTextResult();
						//}else{alert('วันที่ หรือ เวลาไม่ถูกต้อง1');}
						}else{alert('วันที่ หรือ เวลาไม่ถูกต้อง');}
					}else if($('#report_type').val()=="d"){
						if( timeStamp($('#d_start').val()) <= timeStamp($('#d_end').val())){
							var dataType=$('input[name=datatype]:checked').val();
							var URL  ='<?=base_url()?>assets/php/s/getDatabaseColumnChart.php?reportType='+$('#report_type').val()+'&dataType='+dataType+'&dt='+$('#d_start').val()+'&de='+$('#d_end').val()+'&source='+$('#dustboy').val()+'&key=<?=md5('s'.date('ymdh'))?>';
							var data ='<iframe width="100%" height="550" src="'+URL+'" frameborder="0" marginheight="0" marginwidth="0" scrolling="no"></iframe>';
							$('#displayResult').html(data);
							$('#loader').hide();
							getTextResult();
						}else{alert('วันที่ไม่ถูกต้อง');}
					}else if($('#report_type').val()=="m"){
						console.log($('#fm').val());
						console.log($('#lm').val());
						if( timeStamp($('#fm').val()) <= timeStamp($('#lm').val())){
							var dataType=$('input[name=datatype]:checked').val();
							var URL  ='<?=base_url()?>assets/php/s/getDatabaseColumnChart.php?reportType='+$('#report_type').val()+'&dataType='+dataType+'&dt='+$('#fm').val()+'&de='+$('#lm').val()+'&source='+$('#dustboy').val()+'&key=<?=md5('s'.date('ymdh'))?>';
							var data ='<iframe width="100%" height="550" src="'+URL+'" frameborder="0" marginheight="0" marginwidth="0" scrolling="no"></iframe>';
							$('#displayResult').html(data);
							$('#loader').hide();
						}else{alert('วันที่ไม่ถูกต้อง');}
					}
				}else{alert('กรุณาเลือกจุดตรวจวัด');}
			});
			$('#btnLine').click(function(){
				$('#loader').show();
				if($('#dustboy').val()){
					if( $('#report_type').val()=="h"){
						if($('#h_time_start').val()!="" && $('#h_time_end').val()!=""){
						//if( timeStamp($('#h_start').val()+' '+$('#h_time_start').val()) <= timeStamp($('#h_end').val()+' '+$('#h_time_end').val())){
							var dataType=$('input[name=datatype]:checked').val();
							var URL  ='<?=base_url()?>assets/php/s/getDatabaseLineChart.php?reportType='+$('#report_type').val()+'&dataType='+dataType+'&dt='+$('#h_start').val()+'&de='+$('#h_end').val()+'&source='+$('#dustboy').val()+'&h_time_start='+$('#h_time_start').val()+'&h_time_end='+$('#h_time_end').val()+'&key=<?=md5('s'.date('ymdh'))?>';
							var data ='<iframe width="100%" height="450" src="'+URL+'" frameborder="0" marginheight="0" marginwidth="0" scrolling="no"></iframe>';
							$('#displayResult').html(data);
							$('#loader').hide();
							getTextResult();
						//}else{alert('วันที่ หรือ เวลาไม่ถูกต้อง1');}
						}else{alert('วันที่ หรือ เวลาไม่ถูกต้อง');}
					}else if($('#report_type').val()=="d"){
						if( timeStamp($('#d_start').val()) <= timeStamp($('#d_end').val())){
							var dataType=$('input[name=datatype]:checked').val();
							var URL  ='<?=base_url()?>assets/php/s/getDatabaseLineChart.php?reportType='+$('#report_type').val()+'&dataType='+dataType+'&dt='+$('#d_start').val()+'&de='+$('#d_end').val()+'&source='+$('#dustboy').val()+'&key=<?=md5('s'.date('ymdh'))?>';
							var data ='<iframe width="100%" height="450" src="'+URL+'" frameborder="0" marginheight="0" marginwidth="0" scrolling="no"></iframe>';
							$('#displayResult').html(data);
							$('#loader').hide();
							getTextResult();
						}else{alert('วันที่ไม่ถูกต้อง');}
					}else if($('#report_type').val()=="m"){
						if( timeStamp($('#fm').val()) <= timeStamp($('#lm').val())){
							var dataType=$('input[name=datatype]:checked').val();
							var URL  ='<?=base_url()?>assets/php/s/getDatabaseLineChart.php?reportType='+$('#report_type').val()+'&dataType='+dataType+'&dt='+$('#fm').val()+'&de='+$('#lm').val()+'&source='+$('#dustboy').val()+'&key=<?=md5('s'.date('ymdh'))?>';
							var data ='<iframe width="100%" height="450" src="'+URL+'" frameborder="0" marginheight="0" marginwidth="0" scrolling="no"></iframe>';
							$('#displayResult').html(data);
							$('#loader').hide();
						}else{alert('วันที่ไม่ถูกต้อง');}
					}
				}else{alert('กรุณาเลือกจุดตรวจวัด');}
			});
		});
		</script>
		
