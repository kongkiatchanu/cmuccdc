	
	<?php $action = $this->session->userdata('noti_action');?>
	<style>.form-filler{border-top:5px solid #0c364c;padding:20px 15px;background-color:#f8f8f8}.display-hide{display:none;}</style>
	<script src='https://www.google.com/recaptcha/api.js?hl=th'></script>
	<div class="container mb-5">
		<div class="row mt-3">
			<div class="col-12">
				<nav aria-label="breadcrumb">
				  <ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?=base_url('maintain')?>">หน้าหลัก</a></li>
					<li class="breadcrumb-item active" aria-current="page">แจ้งติดตั้งเครื่อง</li>
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
			<div class="col-md-4">
				<div class="alert alert-info">
				<h5 class="mb-3">แนบรูปถ่าย</h5><hr/>
				<ul>
					<li>เครื่อง DustBoy ที่แสดงให้เห็นการติดตั้งที่ระดับความสูงอย่างน้อย 1.5 เมตร</li>
					<li>สภาพแวดล้อมด้านซ้ายเครื่อง DustBoy</li>
					<li>สภาพแวดล้อมด้านขวาเครื่อง DustBoy</li>
					<li>สภาพแวดล้อมด้านหน้าเครื่อง DustBoy</li>
					
				</ul>
				</div>
			</div>
			<div class="col-md-8">
			
				
				<div class="form-filler">
								<h5 class="mb-3">แจ้งติดตั้งเครื่อง</h5><hr/>
								<form class="login-form"  method="post" enctype="multipart/form-data">
									<div class="form-group">
										<label for="fixed_posture">ชื่อจุดติดตั้ง</label>
										<input type="text" class="form-control" id="dustboy_name" name="dustboy_name" required>
									</div>
									<div class="form-group">
										<label for="fixed_posture">รหัสเครื่อง</label>
										<input type="text" class="form-control" id="dustboy_code" name="dustboy_code" required>
									</div>
									<div class="form-group">
										<label for="fixed_posture">ชื่อผู้ประสาน</label>
										<input type="text" class="form-control" id="dustboy_co_name" name="dustboy_co_name" required>
									</div>
									<div class="form-group">
										<label for="fixed_posture">หมายเลขโทรศัพท์</label>
										<input type="text" class="form-control" id="dustboy_co_tel" name="dustboy_co_tel" required>
									</div>
									<div class="form-group">
										<label for="fixed_posture">รูปแบบการเชื่อมต่อ : </label>
										<div class="custom-control custom-radio custom-control-inline">
										  <input type="radio" id="customRadioInline1" name="dustboy_type" class="custom-control-input" value="NB-IoT" required>
										  <label class="custom-control-label" for="customRadioInline1">NB-IoT</label>
										</div>
										<div class="custom-control custom-radio custom-control-inline">
										  <input type="radio" id="customRadioInline2" name="dustboy_type" class="custom-control-input" value="WiFi">
										  <label class="custom-control-label" for="customRadioInline2">WiFi</label>
										</div>
									</div>
									
									<div class="form-group">
										<label for="fixed_posture">แนบไฟล์รูป (ความสูง 1.5 เมตร) : </label>
										<input type="file" class="form-control" name="dustboy_img_1" required>
									</div>
									<div class="form-group">
										<label for="fixed_posture">แนบไฟล์รูป (ด้านขวา): </label>
										<input type="file" class="form-control" name="dustboy_img_2" required>
									</div>
									<div class="form-group">
										<label for="fixed_posture">แนบไฟล์รูป (ด้านซ้าย): </label>
										<input type="file" class="form-control" name="dustboy_img_3" required>
									</div>
									<div class="form-group">
										<label for="fixed_posture">แนบไฟล์รูป (ด้านหน้า): </label>
										<input type="file" class="form-control" name="dustboy_img_4" required>
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
	