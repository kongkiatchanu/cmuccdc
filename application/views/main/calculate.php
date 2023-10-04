		<style>
		.explain{ 
			border-left: 1px solid #e7e7e7;
			padding: 20px;
			background-color: #fff;
			border-right: 1px solid #e7e7e7;
			border-bottom: 1px solid #e7e7e7;
		}
		</style>
		
		<div class="container">
			<div class="row mt-3 mb-3">
				<div class="col-md-12">
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="THAQI-tab" data-toggle="tab" href="#THAQI" role="tab" aria-controls="THAQI" aria-selected="false">TH AQI</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="USAQI-tab" data-toggle="tab" href="#USAQI" role="tab" aria-controls="USAQI" aria-selected="true">US AQI</a>
						</li>
					</ul>
					
					<div class="tab-content explain" id="myTabContent">
						<div class="tab-pane fade show active" id="THAQI" role="tabpanel" aria-labelledby="THAQI-tab">
							<div class="row mb-5">
								<div class="col-md-6">
									<form class="text-center">
										<div class="form-group">
											<label>กรอกค่า PM2.5 ug/m<sup>3</sup></label>
											<input type="text" class="form-control text-center" id="cal25" placeholder="กรอกค่า pm2.5 แล้วกด Enter"/>
										</div>
										<p class="text-center" id="CalculateAQI25GaugeContainer"></p>
										<div class="form-group">
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
											<label>กรอกค่า PM10 ug/m<sup>3</sup></label>
											<input type="text" class="form-control text-center" id="cal10" placeholder="กรอกค่า pm10 แล้วกด Enter"/>
										</div>
										<p class="text-center" id="CalculateAQI10GaugeContainer"></p>
										<div class="form-group">
											<label>PM10 AQI เท่ากับ</label>
											<div style="width:150px; margin:0 auto;">
											<input type="text" class="form-control text-center" id="recal10" style="width:150px;" readonly/>
											</div>
										</div>
									</form>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-12">
									<div class="mb-4">
										<h2 class="text-center" style="text-shadow: 2px 2px #C5C5C5;">ดัชนีคุณภาพอากาศของประเทศไทย</h2>
									</div>
									<div class="table-responsive"> <table class="table table-hover"> <thead class="thead-dark"> <tr> <th class="align-middle" width="10%" style="text-align:center;">สัญลักษณ์</th> <th class="align-middle" width="10%" style="text-align:center;">AQI</th> <th class="align-middle" width="15%" style="text-align:center;">PM<sub>2.5</sub><br>เฉลี่ย 24 ชั่วโมงต่อเนื่อง : ug/m<sup>3</sup></th> <th class="align-middle" width="15%" style="text-align:center;">PM<sub>10</sub><br>เฉลี่ย 24 ชั่วโมงต่อเนื่อง : ug/m<sup>3</sup></th> <th class="align-middle" width="15%" style="text-align:center;">ความหมาย</th> <th class="align-middle" width="35%" style="text-align:center;">แนวทางการป้องกัน</th> </tr> </thead> <tbody> <tr style="background-color:#d4f9ff;height: 100px;"> <td style="text-align:center;"><img src="/template/img/ccdc-01-en.png" height="100"></td> <td style="vertical-align: middle;text-align:center;">0-25</td> <td style="vertical-align: middle;text-align:center;">0-25</td> <td style="vertical-align: middle;text-align:center;">0-50</td> <td style="vertical-align: middle;text-align:center;">คุณภาพอากาศดีมาก</td> <td style="vertical-align: middle;">คุณภาพอากาศดีมาก เหมาะสำหรับกิจกรรมกลางแจ้งและการท่องเที่ยว</td> </tr> <tr style="background-color:#d4ffdb;height: 100px;"> <td style="text-align:center;"><img src="/template/img/ccdc-02-en.png" height="100"></td> <td style="vertical-align: middle;text-align:center;">26-50</td> <td style="vertical-align: middle;text-align:center;">26-37</td> <td style="vertical-align: middle;text-align:center;">51-80</td> <td style="vertical-align: middle;text-align:center;">คุณภาพอากาศดี</td> <td style="vertical-align: middle;">คุณภาพอากาศดี สามารถทำกิจกรรมกลางแจ้งและท่องเที่ยวได้ตามปกติ</td> </tr> <tr style="background-color:#fcffd4;height: 100px;"> <td style="text-align:center;"><img src="/template/img/ccdc-03-en.png" height="100"></td> <td style="vertical-align: middle;text-align:center;">51-100</td> <td style="vertical-align: middle;text-align:center;">38-50</td> <td style="vertical-align: middle;text-align:center;">81-120</td> <td style="vertical-align: middle;text-align:center;">คุณภาพอากาศปานกลาง</td> <td style="vertical-align: middle;">[ประชาชนทั่วไป] สามารถทำกิจกรรมกลางแจ้งได้ตามปกติ [ผู้ที่ต้องดูแลสุขภาพเป็นพิเศษ] หากมีอาการเบื้องต้น เช่น ไอ หายใจลำบาก ระคายเคือง ตา ควรลดระยะเวลาการทำกิจกรรมกลางแจ้ง</td> </tr> <tr style="background-color:#ffe6d4;height: 100px;"> <td style="text-align:center;"><img src="/template/img/ccdc-04-en.png" height="100"></td> <td style="vertical-align: middle;text-align:center;">101-200</td> <td style="vertical-align: middle;text-align:center;">51-90</td> <td style="vertical-align: middle;text-align:center;">121-180</td> <td style="vertical-align: middle;text-align:center;">คุณภาพอากาศมีผลกระทบต่อสุขภาพ</td> <td style="vertical-align: middle;">[ประชาชนทั่วไป] ควรเฝ้าระวังสุขภาพ ถ้ามีอาการเบื้องต้น เช่น ไอ หายใจลาบาก ระคาย เคืองตา ควรลดระยะเวลาการทำกิจกรรมกลางแจ้ง หรือใช้อุปกรณ์ป้องกันตนเองหากมีความจำเป็น [ผู้ที่ต้องดูแลสุขภาพเป็นพิเศษ] ควรลดระยะเวลาการทากิจกรรมกลางแจ้ง หรือใช้อุปกรณ์ ป้องกันตนเองหากมีความจำเป็น ถ้ามีอาการทางสุขภาพ เช่น ไอ หายใจลำบาก ตา อักเสบ แน่นหน้าอก ปวดศีรษะ หัวใจเต้นไม่เป็นปกติ คลื่นไส้ อ่อนเพลีย ควรพบแพทย์</td> </tr> <tr style="background-color:#ffd4d4;height: 100px;"> <td style="text-align:center;"><img src="/template/img/ccdc-05-en.png" height="100"></td> <td style="vertical-align: middle;text-align:center;">&gt;201</td> <td style="vertical-align: middle;text-align:center;">&gt;91</td> <td style="vertical-align: middle;text-align:center;">&gt;181</td> <td style="vertical-align: middle;text-align:center;">คุณภาพอากาศมีผลกระทบต่อสุขภาพมาก</td> <td style="vertical-align: middle;">ประชาชนทุกคนควรหลีกเลี่ยงกิจกรรมกลางแจ้ง หลีกเลี่ยงพื้นที่ที่มีมลพิษทางอากาศสูง หรือใช้อุปกรณ์ป้องกันตนเองหากมีความจำเป็น หากมีอาการทางสุขภาพควรพบแพทย์</td> </tr> </tbody> </table> </div>
								</div>
							</div>
						</div>
						<div class="tab-pane fade " id="USAQI" role="tabpanel" aria-labelledby="USAQI-tab">
							<div class="row mb-5">
								<div class="col-md-6">
									<form class="text-center">
										<div class="form-group">
											<label>กรอกค่า PM2.5 ug/m<sup>3</sup></label>
											<input type="text" class="form-control text-center" id="uscal25" placeholder="กรอกค่า pm2.5 แล้วกด Enter"/>
										</div>
										<p class="text-center" id="CalculateUSAQI25GaugeContainer"></p>
										<div class="form-group">
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
											<label>กรอกค่า PM10 ug/m<sup>3</sup></label>
											<input type="text" class="form-control text-center" id="uscal10" placeholder="กรอกค่า pm10 แล้วกด Enter"/>
										</div>
										<p class="text-center" id="CalculateUSAQI10GaugeContainer"></p>
										<div class="form-group">
											<label>PM10 AQI เท่ากับ</label>
											<div style="width:150px; margin:0 auto;">
											<input type="text" class="form-control text-center" id="usrecal10" style="width:150px;" readonly/>
											</div>
										</div>
									</form>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-12">
									<div class="mb-4">
										<h2 class="text-center" style="text-shadow: 2px 2px #C5C5C5;">Air Quality Index scale as defined by<br/> the US-EPA 2016 standard</h2>
									</div>
									<p><img src="<?=base_url('template/img/us-01.jpg?v=1')?>" style="width:100%"></p>
								</div>
							</div>
						
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<script src="<?=base_url()?>assets/plugins/3Dchart/d3.v2.js"></script>
		<script src="<?=base_url()?>assets/plugins/3Dchart/gauge.js?v=9"></script>
		<script src="<?=base_url()?>assets/plugins/3Dchart/init.js?v=9"></script>
		<script>
        $( document ).ready(function() {
			$('#cal25').keydown(function (e){
				if(e.keyCode == 13){
					var dd= parseFloat($('#cal25').val());
					if(dd>0){
						calAQI25(dd);
					}
				}
			})
			$('#cal10').keydown(function (e){
				if(e.keyCode == 13){
					var dd= parseFloat($('#cal10').val());
					if(dd>0){
						calAQI10(dd);
					}
				}
			})
			
			$('#uscal25').keydown(function (e){
				if(e.keyCode == 13){
					var dd= parseFloat($('#uscal25').val());
					if(dd>0){
						calUSAQI25(dd);
					}
				}
			})
			$('#uscal10').keydown(function (e){
				if(e.keyCode == 13){
					var dd= parseFloat($('#uscal10').val());
					if(dd>0){
						calUSAQI10(dd);
					}
				}
			})
			
			function calAQI25(dd){
				$.get( "<?=base_url()?>assets/api/getCalAQIValue.php?v="+dd+"&t=25&cal=th", function( data ) {
					gauges['CalculateAQI25'].redraw(parseFloat(data));
					$('#recal25').val(data);		
				});
			}
			
			function calAQI10(dd){
				$.get( "<?=base_url()?>assets/api/getCalAQIValue.php?v="+dd+"&t=10&cal=th", function( data ) {
					gauges['CalculateAQI10'].redraw(parseFloat(data));
					$('#recal10').val(data);		
				});
			}
			
			function calUSAQI25(dd){
				$.get( "<?=base_url()?>assets/api/getCalAQIValue.php?v="+dd+"&t=25&cal=us", function( data ) {
					gauges['CalculateUSAQI25'].redraw(parseFloat(data));
					$('#usrecal25').val(data);		
				});
			}
			
			function calUSAQI10(dd){
				$.get( "<?=base_url()?>assets/api/getCalAQIValue.php?v="+dd+"&t=10&cal=us", function( data ) {
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
		
