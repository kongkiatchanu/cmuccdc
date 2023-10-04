	
	<?php $action = $this->session->userdata('noti_action');?>
	<style>.form-filler{border-top:5px solid #0c364c;padding:20px 15px;background-color:#f8f8f8}.display-hide{display:none;}</style>
	<script src='https://www.google.com/recaptcha/api.js?hl=th'></script>
	<div class="container mb-5">
		<div class="row mt-3">
			<div class="col-12">
				<nav aria-label="breadcrumb">
				  <ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?=base_url('maintain')?>">หน้าหลัก</a></li>
					<li class="breadcrumb-item active" aria-current="page">แจ้งย้ายจุดติดตั้ง</li>
				  </ol>
				</nav>
			</div>
		</div>
		<div class="row mt-3 mb-3">
			<div class="col-md-12">
			
				
				<div class="form-filler mb-3">
					<form class="login-form" method="get">
						<div class="form-group row">
							<label for="dustboy_id" class="col-sm-2 col-form-label">รหัสเครื่อง</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="dustboy_id" name="dustboy_id" value="<?=$this->input->get('dustboy_id')?>">
							</div>
							<div class="col-sm-2">
								<button type="submit" class="btn btn-info btn-block">ดึงข้อมูล</button>
							</div>
						</div>
					</form>
				</div>
				
				<?php if($action['dialog_view']=="dialog_success"){?>
					<div class="alert alert-success" style="font-size: 14px;">
						<strong>ส่งคำขอเรียบร้อย !!</strong><br/>ระบบส่งคำขอของท่านไปทีมงานเรียบร้อย
					</div>
				<?php }?>
				<?php if($action['dialog_view']=="dialog_spam"){?>
					<div class="alert alert-danger" style="font-size: 14px;">
						<strong>เกิดข้อผิดพลาด !!</strong><br/>กรุณาตรวจข้อมูลอีกครั้ง
					</div>
				<?php }?>
				<?php if($rs!=null){?>
					
					<div class="row">
						<div class="col-md-4 mt-3">
							<div class="form-filler">
								<h5 class="mb-3">ข้อมูลจุดติดตั้งปัจจุบัน</h5><hr/>
								<p><strong>โมเดล</strong><br/><?=$rs['db_model']?></p>
								<p><strong>ชื่อจุดตั้งติด</strong><br/><?=$rs['dustboy_name_th']?><br/><?=$rs['dustboy_name_en']?></p>
								<p><strong>จุดติดตั้ง</strong><br/><?=$rs['dustboy_lat']?>, <?=$rs['dustboy_lng']?></p>
								
								<p><strong>สถานที่</strong><br/><?=$rs['db_addr']!=null? $rs['db_addr']:'-'?></p>
								<p><strong>URL</strong><br/><?=$rs['dustboy_uri']!=null? base_url($rs['dustboy_uri']):'-'?></p>

							</div>
						</div>
						<div class="col-md-8 mt-3">
							<div class="form-filler">
								<h5 class="mb-3">แจ้งเครื่องเสีย</h5><hr/>
								<form class="login-form"  method="post" enctype="multipart/form-data">
									<div class="form-group">
										<label for="fixed_posture">อาการเบื้องต้น</label>
										<textarea class="form-control" rows="3" name="fixed_posture" required></textarea>
										<small id="emailHelp" class="form-text text-muted">ระบุสาเหตุ เช่น สายไฟขาด, เปิดไม่ติด, จอดับ ฯลฯ</small>
									</div>
									
									<div class="form-group">
										<label for="fixed_posture">แนบไฟล์รูป : </label>
										<input type="file" name="fixed_img">
									</div>
									
									<div class="form-group">
										<div class="g-recaptcha" data-sitekey="6LfegkgUAAAAAL-jtSQ3Bz8XR6M_usJU_-vZ6ozo"></div>
									</div>

									<div class="form-group row">
										<div class="col-sm-12 mb-2">
											<input type="hidden" name="dustboy_id" value="<?=$rs['dustboy_id']?>">
											<button type="submit" class="btn btn-info">ส่งคำขอ</button>
										</div>
									</div>
								
								</form>
							</div>
						</div>
					</div>
				<?php }?>
				
			</div>
		</div>
	</div>
	<?php $this->session->unset_userdata('noti_action');?>
	