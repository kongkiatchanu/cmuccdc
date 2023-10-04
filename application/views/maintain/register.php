	
	
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
					<form class="login-form"  method="post" enctype="multipart/form-data">
						<p>อัพโหลดไฟล์</p>
						
						<div class="form-group row">
							<div class="col-sm-12 mb-2">
								<input type="file" name="request_file">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-12 mb-2">
                                 <div class="g-recaptcha" data-sitekey="6LfegkgUAAAAAL-jtSQ3Bz8XR6M_usJU_-vZ6ozo"></div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-12 mb-2">
								<button type="submit" class="btn btn-info btn-block">ส่งคำขอ</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	