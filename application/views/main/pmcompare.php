		<style>
		#pmcompare{
			background-color: #000;
			color: #fff;	
		}
		#pmcompare .div{background-image: url(https://www.cmuccdc.org/template/img/bg-ccdc.png);}
		#pmcompare .nav-tabs a{color:#fff;}
		#pmcompare .nav-tabs {border-bottom: 1px solid #ef0000;}
		#pmcompare .nav-tabs {color:#f00;}
		#pmcompare .nav-tabs .nav-link.active {color: #ffffff;background-color: #f00;border-color: #f00;}
		</style>
		<div id="pmcompare">
		<div class="container">
			<div class="row pt-3 pb-3 div">
				<div class="col-md-8 ">
					<ul class="nav nav-tabs" id="myTab" role="tablist"> <li class="nav-item"> <a class="nav-link active show" id="pm25-tab" data-toggle="tab" href="#pm25" role="tab" aria-controls="pm25" aria-selected="true">PM 2.5</a> </li> <li class="nav-item"> <a class="nav-link" id="pm10-tab" data-toggle="tab" href="#pm10" role="tab" aria-controls="pm10" aria-selected="false">AQI</a> </li> </ul> <div class="tab-content" id="myTabContent"> <div class="tab-pane fade active show" id="pm25" role="tabpanel" aria-labelledby="pm25-tab"> <h3 class="mb-3 mt-3" style="color:red;">ปริมาณฝุ่นละอองขนาดเล็ก PM2.5 กับ จำนวนบุหรี่เทียบเท่า</h3> <div class="mt-5 mb-5"> <p class="text-left">ถ้าในอากาศที่เราหายใจเข้าไป มีปริมาณฝุ่นละออง PM2.5 เฉลี่ย 24 ชม. <input maxlength="5" type="text" class="DecimalOnly" id="ctxt" style="width:50px;text-align: center;"> ไมโครกรัม/ลูกบาศก์เมตร </p> <p class="text-left">เราจะได้รับผลกระทบต่อสุขภาพ* เทียบเท่ากับการสูบบุหรี่ จำนวน <span id="cresult" style="color:red;font-size:40px;">X</span> มวนต่อวัน</p> </div> </div> <div class="tab-pane fade" id="pm10" role="tabpanel" aria-labelledby="pm10-tab"> <h3 class="mb-3 mt-3" style="color:red;">ปริมาณ AQI กับ จำนวนบุหรี่เทียบเท่า</h3> <div class="mt-5 mb-5"> <p class="text-left">ถ้าในอากาศที่เราหายใจเข้าไป มีปริมาณ AQI เฉลี่ย 24 ชม. เท่ากับ <input maxlength="5" type="text" class="DecimalOnly" id="aqitxt" style="width:50px;text-align: center;"> </p> <p class="text-left">เราจะได้รับผลกระทบต่อสุขภาพ* เทียบเท่ากับการสูบบุหรี่ จำนวน <span id="aqiresult" style="color:red;font-size:40px;">X</span> มวนต่อวัน</p> </div> </div> </div> <div style="margin:125px 0;"> <p class="text-left">*ผลกระทบต่อสุขภาพมีค่าเท่ากันทุกเพศทุกวัย</p> <p class="text-left">**คำนวนจาก การสูบบุหรี่ 1 มวนต่อวัน คิดเป็นปริมาณ PM2.5 เทียบเท่า 22 ug/m3</p> <p class="text-left">ที่มา : http://berkeleyearth.org/air-pollution-and-cigarette-equivalence</p> </div>
				</div>
			</div>
		</div>
		</div>
		
		<script>
        $( document ).ready(function() {
			var count = 0;
			$('.DecimalOnly').keyup(function (event) {
				if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
					event.preventDefault();
					
				}
				var num = Number($(this).val());
				if(num){
					calresult(num);
				}else{
					if(count<2){
						alert('กรุณากรอกตัวเลขเท่านั้น');
						count++;
					}
				}
			});
			$('#aqitxt').keyup(function (event) {
				if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
					event.preventDefault();
				}
				var num = Number($(this).val());
				if(num){
					calAQIResult(num);
				}else{
					if(count<2){
						alert('กรุณากรอกตัวเลขเท่านั้น');
						count++;
					}
				}
			});
			
			function mapss(v,v1,v2,a1,a2){
				return Math.round(a1+ (a2-a1)*(v-v1)/(v2-v1));
			}
		
			function calAQIPM25(val) {
				var data;
				if(Math.round(val)<=25){
					data = mapss(Math.round(val),0,25,0,25);
				}else if(Math.round(val)>25 && Math.round(val)<=37){
					data = mapss(Math.round(val),26,37,26,50);
				}else if(Math.round(val)>37 && Math.round(val)<=50){
					data = mapss(Math.round(val),38,50,51,100);
				}else if(Math.round(val)>50 && Math.round(val)<=90){
					data = mapss(Math.round(val),51,90,101,200);
				}else if(Math.round(val)>90){
					data = Math.round(val)-90+200;
				}
				return data;
			}

			function calAQI2PM25(val){
				var data;
				if(val<=25){
					data = ((val)*(25/25))+0;
				}else if(val>25 && val<=50){
					data = ((val-25)*(25/25))+12;
				}else if(val>50 && val<=100){
					data = ((val-50)*(37/50))+13;
				}else if(val>100 && val<=200){
					data = ((val-100)*(50/100))+40;
				}else if(val>200 && val<=500){
					data = ((val-200)*(90/200))+410;
				}else{
					data = 600;
				}
				return data.toFixed(2);
			}

			function calresult(num){
				var result = num/22;
				$('#cresult').html(result.toFixed(2));
			}
			function calAQIResult(num){
				var aqi2pm = calAQI2PM25(num);
				console.log(aqi2pm);
				var result = aqi2pm/22;
				$('#aqiresult').html(result.toFixed(2));
			}
		});
	</script>
		
