<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
			</div>
		</div>
		<hr/>
		<div class="row">
			<div class="col-md-12">
				<form class="form-horizontal" method="post" role="form" id="form_profile">
					<div class="containerz col-md-9 col-md-offset-3 alert alert-danger">
						<h4>กรุณาป้อนข้อมูลต่อไปนี้ให้ถูกต้องครบถ้วน</h4>
						<ol></ol>
					</div>
					<?php if($this->uri->segment(3)=='fail'){?>
					<div class="msgalert alert alert-danger">
						<h4>คำเตือน! รหัสผ่านไม่ถูกต้อง</h4>
					</div>
					<?php }?>
					<?php if($this->uri->segment(3)=='success'){?>
					<div class="msgalert alert alert-success">
						<h4>เรียบร้อย! ระบบดำเนินการเปลี่ยนข้อมูลเรียบร้อย</h4>
					</div>
					<?php }?>
					<div class="form-body">
						<div class="form-group">
							<label class="col-md-3 control-label">ชื่อผู้ใช้</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="username" id="username" title="Username or Email" required readonly value="<?=$_user['username']?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">ชื่อที่แสดง</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="displayname" id="displayname" title="Display Name" required value="<?=$_user['display']?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">รหัสผ่านเดิม</label>
							<div class="col-md-9">
								<input type="password" class="form-control" name="o_password" id="o_password" title="รหัสผ่านเดิม" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">รหัสผ่านใหม่</label>
							<div class="col-md-9">
								<input type="password" class="form-control" name="n_password" id="n_password" title="รหัสผ่านใหม่" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">ยืนยันรหัสผ่านใหม่</label>
							<div class="col-md-9">
								<input type="password" class="form-control" name="c_password" id="c_password" title="ยืนยันรหัสผ่านใหม่" required>
							</div>
						</div>
						
					</div>	
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
							<button type="submit" id="btn_submit" class="btn btn-primary">บันทึก</button>
							<a href="<?=base_url()?>admin" class="btn btn-default">ยกเลิก</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


