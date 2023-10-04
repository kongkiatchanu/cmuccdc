	
	<?php $action = $this->session->userdata('noti_action');?>
	<style>.form-filler{border-top:5px solid #0c364c;padding:20px 15px;background-color:#f8f8f8}.display-hide{display:none;}</style>
	<script src='https://www.google.com/recaptcha/api.js?hl=th'></script>
	<div class="container mb-5">
		<div class="row mt-3">
			<div class="col-12">
				<nav aria-label="breadcrumb">
				  <ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?=base_url('maintain')?>">หน้าหลัก</a></li>
					<li class="breadcrumb-item active" aria-current="page">แจ้งต่ออายุ</li>
				  </ol>
				</nav>
			</div>
		</div>

		<?php if($action['dialog_view']=="dialog_success"){?>
					<div class="alert alert-success" style="font-size: 14px;">
						<strong>ส่งคำขอเรียบร้อย !!</strong><br/>ระบบส่งข้อมูลของท่านไปทีมงานเรียบร้อย
					</div>
				<?php }?>
				<?php if($action['dialog_view']=="dialog_spam"){?>
					<div class="alert alert-danger" style="font-size: 14px;">
						<strong>เกิดข้อผิดพลาด !!</strong><br/>กรุณาตรวจข้อมูลอีกครั้ง
					</div>
				<?php }?>
		<div class="row mt-3 mb-3">
			
			<div class="col-md-12">
			
				
				<div class="form-filler">
					<h5 class="mb-3">แจ้งต่ออายุ NB</h5><hr/>
						<form class="login-form"  method="post" enctype="multipart/form-data">
									<div class="form-group row">
										<div class="col-md-6">
											<label for="fixed_posture">รหัสเครื่อง</label>
											<input type="text" class="form-control" id="dustboy_code" name="dustboy_code" required>
										</div>
										<div class="col-md-6">
											<label for="fixed_posture">ชื่อจุดติดตั้ง</label>
											<input type="text" class="form-control" id="dustboy_name" name="dustboy_name" required>
										</div>
									</div>
							
									<div class="form-group row">
										<div class="col-md-6">
											<label for="fixed_posture">ชื่อผู้ประสาน</label>
											<input type="text" class="form-control" id="dustboy_co" name="dustboy_co" required>
										</div>
										<div class="col-md-6">
											<label for="fixed_posture">โทรศัพท์</label>
											<input type="text" class="form-control" id="dustboy_mobile" name="dustboy_mobile" required>
										</div>
									</div>
									
									<div class="form-group row">
										<div class="col-md-12">
											<label for="fixed_posture">ประสงค์</label>
											<div class="form-check">
											  <input class="form-check-input" type="radio" name="dustboy_type" id="dustboy_type1" value="1" required>
											  <label class="form-check-label" for="dustboy_type1">
												ต่ออายุการเชื่อมสัญญาณออนไลน์ผ่านเครื่อข่ายมือถือ 1 ปี (ราคา 500) (1 มี.ค. 2565 - 28 ก.พ. 2566)
											  </label>
											</div>
											<div class="form-check">
											  <input class="form-check-input" type="radio" name="dustboy_type" id="dustboy_type2" value="2" required>
											  <label class="form-check-label" for="dustboy_type2">
												อัพเกรดเครื่องวัดฝุ่น Dustboy ให้เชื่อมออนไลน์แบบ WIFI กับจุดติดตั้ง (ราคา 1,000 บาท)
											  </label>
											</div>
											<div class="form-check">
											  <input class="form-check-input" type="radio" name="dustboy_type" id="dustboy_type3" value="3" required>
											  <label class="form-check-label" for="dustboy_type3">
												ไม่ประสงค์จะติดตั้งเครื่องต่อ
											  </label>
											</div>

										</div>

									</div>
									
									<div class="form-group row">
										<div class="col-md-12">
											<label for="fixed_posture">อัพโหลดหลักฐานการโอนเงิน</label>
											<br/><input type="file" id="dustboy_img" name="dustboy_img" accept="image/*" onchange="loadFile(event)"><br/>
											<br/><img id="output" style="max-width:300px;margin-bottom:10px;"/>
										</div>
									</div>
									
									<div class="form-group row">
										<div class="col-md-12">
											<label for="fixed_posture">รายละเอียดออกใบเสร็จรับเงิน</label>
											<textarea rows="3" class="form-control" name="dustboy_detail"></textarea>
										</div>
									</div>
									
									<div class="form-group row">
										<div class="col-md-12">
											<div class="alert alert-info">
											<h5 class="mb-3">หมายเหตุ</h5><hr/>
												<p>กรณีต้องการให้นำเครื่องมาตรวจเช็คสภาพ(ฟรี) หรือ ต้องการอัพเกรดเป็นแบบเชื่อม WIFI หรือไม่ประสงค์จะติดตั้งเครื่องวัดฝุ่นต่อ กรุณาส่งเครื่องมายัง</p>
												<p>หน่วยวิจัยเพื่อการจัดการพลังงานและเศรษฐนิเวศ ชั้น 7 อาคาร 30 ปี คณะวิศวกรรมศาสตร์ มหาวิทยาลัยเชียงใหม่<br/>239 ถนนห้วยแก้ว ตำบลสุเทพ อำเภอเมืองเชียงใหม่ เชียงใหม่ 50200<br/>โทรศัพท์ : 084-0458658</p>
											</div>
										</div>
									</div>
									
									<div class="form-group row">
										<div class="col-md-6">
											<label for="fixed_posture">tracking. No.</label>
											<input type="text" class="form-control" id="dustboy_send_code" name="dustboy_send_code" required>
										</div>
										<div class="col-md-6">
											<label for="fixed_posture">ขนส่งที่ใช้จัดส่ง</label>
											<input type="text" class="form-control" id="dustboy_send_name" name="dustboy_send_name" required>
										</div>
									</div>
									
									<div class="form-group">
										<div class="g-recaptcha" data-sitekey="6LfegkgUAAAAAL-jtSQ3Bz8XR6M_usJU_-vZ6ozo"></div>
									</div>
									
									<div class="form-group row">
										<div class="col-sm-12 mb-2">
											<button type="submit" class="btn btn-info">ส่งคำขอ</button>
										</div>
									</div>
									
								
								
						</form>
				</div>
				
				
			</div>
		</div>
	</div>
	<?php $this->session->unset_userdata('noti_action');?>
	<script>
	var loadFile = function(event) {
		var output = document.getElementById('output');
		output.src = URL.createObjectURL(event.target.files[0]);
		output.onload = function() {
			URL.revokeObjectURL(output.src) // free memory
		}	
	};
	</script>
	