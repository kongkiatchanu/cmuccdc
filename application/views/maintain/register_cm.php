	<style>.form-filler{border-top:5px solid #0c364c;padding:20px 15px;background-color:#f8f8f8}.display-hide{display:none;}</style>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<div class="container mb-5">
		<div class="row mt-3">
			<div class="col-12">
				<nav aria-label="breadcrumb">
				  <ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?=base_url('maintain')?>">หน้าหลัก</a></li>
					<li class="breadcrumb-item active" aria-current="page">ขอติดตั้งเครื่อง</li>
				  </ol>
				</nav>
			</div>
		</div>
		<div class="row mt-3 mb-3">
			<div class="col-md-8">
				<div class="form-filler">
					<h3>ขั้นตอนการขอติดตั้งเครื่อง</h3>
					<ol>
						<li>ดาวน์โหลดแบบฟอร์มสำรวจความต้องการเครื่อง DustBoy (กรอกรายละเอียดตามแบบฟอร์มให้ครบถ้วน)</li>
						<li>กรอกข้อมูลรายละเอียดผู้แจ้งขอความอนุเคราะห์ติดตั้งเครื่อง DustBoy ได้แก่
							<ul>
								<li>หน่วยงานที่ขอติดตั้ง</li>
								<li>ชื่อผู้ประสานงาน</li>
								<li>เบอร์โทรศัพท์</li>
								<li>อีเมล</li>
							</ul>
						</li>
						<li>ระบบจะส่งคำร้องขอติดตั้งเครื่อง DustBoy ไปยังเจ้าหน้าที่เพื่อพิจารณาอนุมัติการติดตั้ง</li>
						<li>เจ้าหน้าที่ส่งผลการพิจารณาอนุมัติติดตั้งเครื่อง DustBoy ตามที่อยู่อีเมลที่ท่านกรอกก่อนหน้า</li>
					</ol>
					
					<p><a href="/uploads/docs/แบบฟอร์มสำรวจความต้องการเครื่อง DustBoy.xlsx" class="btn btn-success btn-sm" download><i class="far fa-file-excel"></i> ดาวน์โหลดแบบฟอร์ม</a></p>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-filler">
					<form class="login-form"  method="post">
					
						<?php if($rss[0]->request_status==0){?>
						<p class="text-center mb-3">กรุณาตรวจสอบข้อมูลให้ครบถ้วน</p>
						<?php }else{?>
						<div class="form-group">
							<div class="col-sm-12 mb-2 text-center alert alert-info">
								ระบบส่งคำขอไปที่ทีมงานแล้ว<br/>หลังจากพิจารณนาแล้วทีมงานจะติดต่อกลับไปยังอีเมล์ที่ลงทะเบียนไว้
							</div>
						</div>
						<?php }?>
						<div class="form-group row">
							<div class="col-sm-12 mb-2">
								<table class="table">
									<tbody>

										<tr>
											<td>ไฟล์แนบ </td>
											<td>
											<?php if($rss[0]->request_file){?>
											<a class="btn btn-sm btn-secondary" target="_blank" href="/uploads/requests/<?=$rss[0]->request_file?>">ไฟล์แนบ</a>
											<?php }else{echo '-';}?>
											</td>
										<tr>
									</tbody>
								</table>
							</div>
						</div>
						<?php if($rss[0]->request_status==0){?>
						<div class="form-group row">
							<div class="col-sm-12 mb-2 text-center">
								<input type="hidden" name="request_status" value="1">
								<input type="hidden" name="request_key" value="<?=$rss[0]->request_key?>">
								<button type="submit" class="btn btn-info btn-block">ยืนยันสมัครร่วมทีมอาสา</button>
							</div>
						</div>
	
						<?php }?>
						
					</div>
				</form>
			</div>
		</div>
	</div>
	