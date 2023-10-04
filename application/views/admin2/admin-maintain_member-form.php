<?php 
	if($this->uri->segment(3)=="add"){
		if($rsAdd!=null){
			$user_request_id=$rsAdd[0]->request_id;
		}
		$username=$g_username;
		$password=$g_password;
	}else{
		
		if($rs!=null){
			$username=$rs[0]->username;
			$password=$rs[0]->password;
			$user_request_id=$rs[0]->user_request_id;
		}
	}
	
	$ar_status = array('อนุมัติติดตั้ง','กรอกรายละเอียด','การผลิตเครื่อง','การทดสอบคุณภาพเครื่อง','การจัดส่ง','ติดตั้ง','การนำเข้าข้อมูลขึ้นบนระบบคลาวด์','เสร็จสมบูรณ์');
	$ar_repair = array('ไม่มี','แจ้งข้อมูล','เจ้าหน้าที่ตรวจสอบ','ประสานงานแก้ไขเบื้องต้น','ส่งซ่อม','ส่งกลับไปยังสถานที่ติดตั้ง','เสร็จสมบูรณ์');

?>
<style>.bootstrap-tagsinput .tag{background-color: #333;padding:5px;}</style>
<div class="main-header row">
    <div class="col-12 col-md-6">
        <label class="title"><?=$pagename?></label>
    </div>
</div>
<hr/>
<div class="main-body row">
    <div class="col-md-4">
		<h5>รายละเอียดคำขอ</h5>
		<table class="table">
		<tbody>
			<tr>	
				<td>หน่วยงาน</td>
				<td><?=$rsAdd[0]->request_agency?></td>
			</tr>
			<tr>	
				<td>ชื่อผู้ประสานงาน</td>
				<td><?=$rsAdd[0]->request_name?></td>
			</tr>
			<tr>	
				<td>เบอร์โทรศัพท์</td>
				<td><?=$rsAdd[0]->request_tel?></td>
			</tr>
			<tr>	
				<td>อีเมล</td>
				<td><?=$rsAdd[0]->request_email?></td>
			</tr>
			<tr>	
				<td>ระบุรายละเอียด</td>
				<td><?=$rsAdd[0]->request_detail?></td>
			</tr>
			<tr>	
				<td>ไฟล์แนบ</td>
				<td><?=$rsAdd[0]->request_file!=null?'<a target="_blank" href="/uploads/requests/'.$rsAdd[0]->request_file.'">ไฟล์แนบ</a>':''?></td>
			</tr>
		</tbody>
		</table>
	</div>
	<div class="col-md-8">
		<h5>ชื่อผู้ใช้และรหัสผ่าน</h5>
        <form class="custom-form" method="post" role="form" id="frm_slide">
            <div class="form-group row">
                <label for="username" class="col-sm-2 col-form-label">username</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="username" name="username" required value="<?=$username?>" readonly>
				</div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-sm-2 col-form-label">password</label>
                <div class="col-sm-10">
					<input type="text" class="form-control" name="password" id="password" required value="<?=$password?>" readonly>
				</div>
            </div>
            <hr>
			<?php if($this->uri->segment(3)=="add"){?>
			
            <div class="form-group text-right mt-3">
				<input type="hidden" name="user_request_id" value="<?=$user_request_id?>">
                <button type="submit" id="btn_submit" class="btn btn-custom btn-bg-color">เพิ่มสมาชิกใหม่</button>
            </div>
			<?php }else{?>
			<div class="form-group row">
                <label for="user_engines" class="col-sm-2 col-form-label">เพิ่มเครื่อง</label>
                <div class="col-sm-10">
					<a href="<?=base_url()?>admin2/maintain_member/addengine/<?=$username?>" class="btn btn-bg-color btn-custom-sm" title="เพิ่ม">
                        <i class="fas fa-plus"></i>	
                    </a>
				</div>
            </div>
			<?php if($rsEngine){$i=0;?>
			<?php foreach($rsEngine as $engine){$i++?>
			<div class="form-group row">
                <label for="user_engines" class="col-sm-2 col-form-label">ref : <?=$engine->engine_id?></label>
                <div class="col-sm-8">
					<input type="text" class="form-control" id="username" name="engine_code[<?=$engine->engine_id?>][]"  value="<?=$engine->engine_code?>" placeholder="ระบุหมายเลขเครื่อง(ถ้ามี)">
				</div>
				<div class="col-sm-2">
					
					<button type="button" class="btn btn-base-color btn-custom-sm my-1" data-toggle="collapse" data-target="#collapseExample<?=$engine->engine_id?>" aria-expanded="false" aria-controls="collapseExample<?=$engine->engine_id?>">
                        <i class="fas fa-info"></i>	
                    </button>
					<a href="<?=base_url()?>admin2/maintain_member/delengine/<?=$engine->engine_id?>/<?=$username?>" class="btn btn-base-color btn-custom-sm my-1" onclick="return confirm('คุณต้องการลบใช่หรือไม่');">
                        <i class="fas fa-trash-alt"></i>	
                    </a>
				</div>

            </div>
			
			
			<div class="form-group row">
				<div class="col-12">
					<div class="collapse" id="collapseExample<?=$engine->engine_id?>">
						<div class="card card-body">
							<div class="form-group row">
								<label for="user_engines" class="col-sm-2 col-form-label">ข้อมูลเครื่อง</label>
								<div class="col-sm-10">
									<?php
										echo '<pre>';
										print_r(json_decode($engine->engine_obj));
										echo '</pre>';
									?>
								</div>
							</div>
							<div class="form-group row">
								<label for="user_engines" class="col-sm-2 col-form-label">สถานะเครื่อง</label>
								<div class="col-sm-4">
									<?php foreach($ar_status as $k=>$item){?>
									<div class="form-check">
										<input class="form-check-input" type="radio" name="engine_status[<?=$engine->engine_id?>][]" id="db_status<?=$i?><?=$k?>" value="<?=$k?>" <?=$engine->engine_status==$k?'checked':''?>>
										<label class="form-check-label" for="db_status<?=$i?><?=$k?>">
											<?=$item?>
										</label>
									</div>
									<?php }?>
								</div>
								<label for="user_engines" class="col-sm-2 col-form-label">กรณีซ่อม</label>
								<div class="col-sm-4">
								<?php foreach($ar_repair as $k=>$item){?>
									<div class="form-check">
										<input class="form-check-input" type="radio" name="engine_repair[<?=$engine->engine_id?>][]" id="db_repair<?=$i?><?=$k?>" value="<?=$k?>" <?=$engine->engine_repair==$k?'checked':''?>>
										<label class="form-check-label" for="db_repair<?=$i?><?=$k?>">
											<?=$item?>
										</label>
									</div>
									<?php }?>
								</div>
							</div>
							
							
							
						</div>
					</div>
				</div>
			</div>
			
			<?php }?>
			<?php }?>
			<div class="form-group text-right mt-3">
				<input type="hidden" name="user_request_id" value="<?=$user_request_id?>">
                <button type="submit" id="btn_submit" class="btn btn-custom btn-bg-color">บันทึกข้อมูล</button>
            </div>
			<?php }?>
        </form>
    </div>
</div>