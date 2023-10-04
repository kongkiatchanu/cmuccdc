		<style>
		.form-calculate {
			padding: 20px;
		}
		.form-calculate .card-border-green {
			border-top: 10px solid #9dc02d;
			background-color: #f7f7f7;
		}
		.form-calculate .card-border-blue {
			border-top: 10px solid #0c364c;
			background-color: #f7f7f7;
		}
		.nav-tabs .nav-link{color:#333;}
		.nav-tabs .nav-link.active {
			background-color: #9dc03b;
			color: #fff;
			border-radius: 0px;
		}
		</style>
		<div class="c_bg" style="background-color: #c4e8f2;">
		<div class="container">
		
			<div class="row pt-3 pb-3">
				<div class="form-calculate"><ul class="nav nav-tabs" id="myTab" role="tablist"><li class="nav-item"><a class="nav-link active" id="pm25-tab" data-toggle="tab" href="#pm25" role="tab" aria-controls="pm25" aria-selected="true">PM 2.5</a></li><li class="nav-item"><a class="nav-link" id="pm10-tab" data-toggle="tab" href="#pm10" role="tab" aria-controls="pm10" aria-selected="false">PM 10</a></li></ul><div class="tab-content" id="myTabContent"><div class="tab-pane fade show active" id="pm25" role="tabpanel" aria-labelledby="pm25-tab"><div class="text-center mt-5"><div class="row justify-content-center mb-5"><div class="col-lg-4"><div class="card card-border-green pt-3 pb-3"><div class="card-body text-center"><p>ค่า PM2.5 เฉลี่ยตลอดปีมีค่า(ug/m3)</p><input type="text" class="form-control form-control-lg text-center" id="pm25value" value="34"></div></div></div><div class="col-lg-4"><div class="card card-border-blue pt-3 pb-3"><div class="card-body text-center"><p>เมื่อเทียบค่า PM2.5 กับค่ามาตรฐานของ WHO (10 μg/m3) จะทำให้มีอายุสั้นลงเฉลี่ยต่อคน</p><span id="time1" style="margin: 0;padding: 5px 7px;background-color: #f00;color: #fff;border: 2px dashed #fff;">ss</span></div></div></div><div class="col-lg-4"><div class="card card-border-blue pt-3 pb-3"><div class="card-body text-center"><p>เมื่อเทียบค่า PM2.5 กับค่ามาตรฐานของไทย (25 μg/m3) จะทำให้มีอายุสั้นลงเฉลี่ยต่อคน</p><span id="time2" style="margin: 0;padding: 5px 7px;background-color: #f00;color: #fff;border: 2px dashed #fff;">ss</span></div></div></div></div><button type="button" class="btn btn-primary btn-lg btncalpm25 mb-3">คำนวณอายุที่สั้นลง</button><div class="filler-box text-center mb-5"><h5>เลือกจังหวัด</h5><div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="s_pvPM25" value="1" checked> เชียงใหม่</label></div><div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="s_pvPM25" value="2"> พะเยา</label></div><div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="s_pvPM25" value="3"> เชียงราย</label></div><div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="s_pvPM25" value="4"> แพร่</label></div><div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="s_pvPM25" value="5"> น่าน</label></div><div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="s_pvPM25" value="6"> ลำปาง</label></div><div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="s_pvPM25" value="7"> ลำพูน</label></div><div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="s_pvPM25" value="8"> แม่ฮ่องสอน</label></div></div><button type="button" class="btn btn-primary btn-lg btncalpm25">คำนวณอายุขัยเฉลี่ยที่เหลือ</button></div><div class="row"><div class="col-md-12 form-calculate"><div class="card card-border-blue pt-3 pb-3"><div class="card-body"><table class="table"><tbody><tr><td>อายุขัยเฉลี่ยของประชากรในจังหวัด (ข้อมูล ณ ปี2557)</td><td class="text-right"><span id="pm25v1"></span></td><td>ปี</td></tr><tr><td>เมื่อเทียบค่า PM2.5 กับค่ามาตรฐานของ WHO (10 μg/m3) จะทำให้มีอายุขัยเฉลี่ยเหลือเท่ากับ</td><td class="text-right"><span id="pm25v2"></span></td><td>ปี</td></tr><tr><td>เมื่อเทียบค่า PM2.5 กับค่ามาตรฐานของไทย (25 μg/m3) จะทำให้มีอายุขัยเฉลี่ยเหลือเท่ากับ</td><td class="text-right"><span id="pm25v3"></span></td><td>ปี</td></tr></tbody></table><p style="text-decoration: underline;">หมายเหตุ</p><p>คำนวนจาก ทุกๆ ​10 μg/m3 ของ PM2.5 ที่เพิ่มขึ้น จะทำให้อายุสั้นลง 1.03 ปี (https://aqli.epic.uchicago.edu)</p></div></div></div></div></div><div class="tab-pane fade" id="pm10" role="tabpanel" aria-labelledby="pm10-tab"><div class="text-center mt-5"><div class="row justify-content-center mb-5"><div class="col-lg-4"><div class="card card-border-green pt-3 pb-3"><div class="card-body text-center"><p>ค่า PM 10 เฉลี่ยตลอดปีมีค่า (ug/m3)</p><input type="text" class="form-control form-control-lg text-center" id="pm10value" value="60"></div></div></div><div class="col-lg-4"><div class="card card-border-blue pt-3 pb-3"><div class="card-body text-center"><p>เมื่อเทียบค่า PM10 กับค่ามาตรฐานของWHO ( 20 μg/m3) จะทำให้มีอายุสั้นลงเฉลี่ยต่อคน</p><p id="pm10time1" style="color: #9dc02d;margin:0;">ss</p></div></div></div><div class="col-lg-4"><div class="card card-border-blue pt-3 pb-3"><div class="card-body text-center"><p>เมื่อเทียบค่า PM10 กับค่ามาตรฐานของไทย ( 50 μg/m3) จะทำให้มีอายุสั้นลงเฉลี่ยต่อคน</p><p id="pm10time2" style="color: #9dc02d;margin:0;">ss</p></div></div></div></div><button type="button" class="btn btn-primary btn-lg mb-3 btncalpm10">คำนวณอายุที่สั้นลง</button><div class="filler-box text-center mb-5"><h5>เลือกจังหวัด</h5><div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="s_pvPM10" value="1" checked> เชียงใหม่</label></div><div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="s_pvPM10" value="2"> พะเยา</label></div><div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="s_pvPM10" value="3"> เชียงราย</label></div><div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="s_pvPM10" value="4"> แพร่</label></div><div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="s_pvPM10" value="5"> น่าน</label></div><div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="s_pvPM10" value="6"> ลำปาง</label></div><div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="s_pvPM10" value="7"> ลำพูน</label></div><div class="form-check form-check-inline"><label class="form-check-label"><input class="form-check-input" type="radio" name="s_pvPM10" value="8"> แม่ฮ่องสอน</label></div></div><button type="button" class="btn btn-primary btn-lg btncalpm10">คำนวณอายุขัยเฉลี่ยที่เหลือ</button></div><div class="row"><div class="col-md-12 form-calculate"><div class="card card-border-blue pt-3 pb-3"><div class="card-body"><table class="table"><tbody><tr><td>อายุขัยเฉลี่ยของประชากรในจังหวัด (ข้อมูล ณ ปี2557)</td><td class="text-right"><span id="pm10v1"></span></td><td>ปี</td></tr><tr><td>เมื่อเทียบค่า PM10 กับค่ามาตรฐานของWHO (20 μg/m3) จะทำให้มีอายุขัยเฉลี่ยเหลือเท่ากับ</td><td class="text-right"><span id="pm10v2"></span></td><td>ปี</td></tr><tr><td>เมื่อเทียบค่าPM10 กับค่ามาตรฐานของไทย (50 μg/m3) จะทำให้มีอายุขัยเฉลี่ยเหลือเท่ากับ</td><td class="text-right"><span id="pm10v3"></span></td><td>ปี</td></tr></tbody></table><p style="text-decoration: underline;">หมายเหตุ</p><p>คำนวนจาก ทุกๆ​ 10 μg/m3 ของ PM10 ที่เพิ่มขึ้น จะทำให้อายุสั้นลง 0.64 ปี (Ebenstein et al., 2017)</p></div></div></div></div></div></div></div>
			</div>	
		</div>
		</div>
		<script>$(document).ready(function(){var l=[0,66.88,73.52,74.04,73.39,74.97,75.26,74.41,75.92];function m(l){for(var m="",a=[[" ปี",365],[" เดือน",30],[" วัน",1]],t=0;t<a.length;t++){var v=Math.floor(l/a[t][1]);v>=1&&(m+=v+a[t][0]+(v>1?"":"")+" ",l-=v*a[t][1])}return m}function a(){var a,t,v,e,p=$("input[name=s_pvPM25]:checked").val();$("#pm25v1").html(l[p]),$("#pm25v2").html((a=l[p],t=$("#pm25value").val(),a-1.03*(t-10)/10).toFixed(2)),$("#pm25v3").html((v=l[p],e=$("#pm25value").val(),v-1.03*(e-25)/10).toFixed(2)),$("#time1").html(m(1.03*($("#pm25value").val()-10)/10*365)),$("#time2").html(m(1.03*($("#pm25value").val()-25)/10*365))}function t(){var a,t,v,e,p=$("input[name=s_pvPM10]:checked").val();$("#pm10v1").html(l[p]),$("#pm10v2").html((a=l[p],t=$("#pm10value").val(),a-.64*(t-20)/10).toFixed(2)),$("#pm10v3").html((v=l[p],e=$("#pm10value").val(),v-.64*(e-50)/10).toFixed(2)),$("#pm10time1").html(m(.64*($("#pm10value").val()-20)/10*365)),$("#pm10time2").html(m(.64*($("#pm10value").val()-50)/10*365))}$(".btncalpm25").click(function(){$.isNumeric($("#pm25value").val())?a():alert("กรุณาระบบค่า PM 2.5")}),a(),$(".btncalpm10").click(function(){$.isNumeric($("#pm10value").val())?t():alert("กรุณาระบบค่า PM 2.5")}),t()});</script>
	