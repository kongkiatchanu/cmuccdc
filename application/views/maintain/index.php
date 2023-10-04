	<style>.form-filler{border-top:5px solid #0c364c;padding:20px 15px;background-color:#f8f8f8}.display-hide{display:none;}</style>
	<?php 
	$ar_status = array('อนุมัติติดตั้ง','กรอกรายละเอียด','การผลิตเครื่อง','การทดสอบคุณภาพเครื่อง','การจัดส่ง','ติดตั้ง','การนำเข้าข้อมูลขึ้นบนระบบคลาวด์','เสร็จสมบูรณ์');
	$ar_repair = array('ไม่มี','แจ้งข้อมูล','เจ้าหน้าที่ตรวจสอบ','ประสานงานแก้ไขเบื้องต้น','ส่งซ่อม','ส่งกลับไปยังสถานที่ติดตั้ง','เสร็จสมบูรณ์');
	?>
	
	<div class="container mb-5">
		<div class="row mt-3">
			<div class="col-md-12">
				<p class="text-right"><a href="/maintain/logout" class="btn btn-secondary btn-sm"><i class="fas fa-sign-out-alt"></i> ออกจากระบบ</a></p>
			</div>
		</div>
	<?php if(@$rsEngine){?>
		<form class="custom-form" method="post" action="/maintain/updateMaintain" role="form" enctype="multipart/form-data">
		<?php $i=-0;foreach($rsEngine as $item){$i++;
			
			$decode = (array)json_decode($item->engine_obj);
					
		
		?>
		<div class="row mt-3 mb-3">
			<div class="col-md-12">
				
				<div class="form-filler">
					<h3>เครื่องที่ <?=$i?> <small style="color:#999;">(ไอดีเครื่อง = <?=$item->engine_code!=null? $item->engine_code:'-'?>)</small></h3>
					<hr/>
					
					<div class="row">
						<div class="col-md-7">
							<p><strong>ข้อมูลเครื่อง</strong></p>
							
								<div class="form-group row">
									<label for="username" class="col-sm-3 col-form-label">ชื่อสถานที่ติดตั้ง(ไทย)</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" id="username" name="engine_name_th[<?=$item->engine_id?>]" value="<?=@$decode['engine_name_th']?>" required>
										 <small id="emailHelp" class="form-text text-muted">การตั้งชื่อ ให้ใช้ตัวย่อหน่วยงาน ชื่อหน่วยงาน ตามด้วยจังหวัด<br/>ตัวอย่าง รพ.XXXX จ.XXXX</small>
									</div>
								</div>
								<div class="form-group row">
									<label for="username" class="col-sm-3 col-form-label">ชื่อสถานที่ติดตั้ง(อังกฤษ)</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" id="username" name="engine_name_en[<?=$item->engine_id?>]" value="<?=@$decode['engine_name_en']?>" required>
									</div>
								</div>
								<div class="form-group row">
									<label for="username" class="col-sm-3 col-form-label">ที่อยู่</label>
									<div class="col-sm-9">
										<textarea class="form-control" rows="3" name="engine_addr[<?=$item->engine_id?>]"><?=@$decode['engine_addr']?></textarea>
									</div>
								</div>
								<div class="form-group row">
									<label for="username" class="col-sm-3 col-form-label">ละติจูต</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" id="username" name="engine_lat[<?=$item->engine_id?>]" value="<?=@$decode['engine_lat']?>" required>
									</div>
									<label for="username" class="col-sm-3 col-form-label">ลองติจูต</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" id="username" name="engine_lnt[<?=$item->engine_id?>]" value="<?=@$decode['engine_lnt']?>" required>
									</div>
								</div>
								<div class="form-group row">
									<label for="username" class="col-sm-3 col-form-label">Shot URL</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" id="username" name="engine_url[<?=$item->engine_id?>]" value="<?=@$decode['engine_url']?>" required>
									</div>
								</div>
								<div class="form-group row">
									<label for="username" class="col-sm-3 col-form-label">รุปภาพ</label>
									<div class="col-sm-9">
									
										<input type="file" name="engine_file[<?=$item->engine_id?>]"><br/>
										<?=@$decode['engine_file']!=null?'<a target="_blank" href="/uploads/requests/'.$decode['engine_file'].'">คลิกเพื่อดูรูปภาพ</a>':''?>
									</div>
									<input type="hidden" name="engine_file[<?=$item->engine_id?>]" value="<?=@$decode['engine_file']?>">
								</div>
							
						</div>
						<div class="col-md-5">
							<p><strong>ชื่อผู้ดูแลรับผิดชอบ</strong></p>
							<div class="form-group row">
									<label for="username" class="col-sm-4 col-form-label">รุปภาพ</label>
									<div class="col-sm-8">
										
										<input type="file" name="engine_ct_file[<?=$item->engine_id?>]"><br/>
										<?=@$decode['engine_ct_file']!=null?'<a target="_blank" href="/uploads/requests/'.$decode['engine_ct_file'].'">คลิกเพื่อดูรูปภาพ</a>':''?>
									<input type="hidden" name="engine_ct_file[<?=$item->engine_id?>]" value="<?=@$decode['engine_ct_file']?>">
									</div>
								</div>
							<div class="form-group row">
								<label for="username" class="col-sm-4 col-form-label">ผู้ประสานงาน</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="username" name="engine_ct_name[<?=$item->engine_id?>]" value="<?=@$decode['engine_ct_name']?>" required>
								</div>
							</div>
							<div class="form-group row">
								<label for="username" class="col-sm-4 col-form-label">โทรศัพท์</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="username" name="engine_ct_tel[<?=$item->engine_id?>]" value="<?=@$decode['engine_ct_tel']?>" required>
								</div>
							</div>
							<div class="form-group row">
								<label for="username" class="col-sm-4 col-form-label">อีเมล์</label>
								<div class="col-sm-8">
									<input type="email" class="form-control" id="username" name="engine_ct_email[<?=$item->engine_id?>]" value="<?=@$decode['engine_ct_email']?>" required>
								</div>
							</div>
							<p><strong>สถานะเครื่อง DustBoy - <span style="<?=$item->engine_status==7?'color:green':''?>"><?=$ar_status[$item->engine_status]?></span></strong></p>
							<p><strong>กรณีที่เครื่องเสีย และมีการส่งซ่อม - <?=$ar_repair[$item->engine_repair]?></strong></p>
							<?php if($item->engine_status==7){?>
							<p><a href="/maintain/sendFixed/<?=$item->engine_id?>" class="btn btn-warning btn-bg-color" onclick="return confirm('แจ้งทีมงาน?');">เครื่องใช้งานไม่ได้ แจ้งทีมงาน</a></p>
							<?php }?>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		<?php }?>
		<div class="row mt-3 mb-3">
			<div class="col-12 text-center">
			
                <button type="submit" id="btn_submit" class="btn btn-primary btn-bg-color">บันทึกข้อมูล</button>
                <a href="/maintain/sendData" class="btn btn-info btn-bg-color" onclick="return confirm('กรุณาตรวจสอบข้อมูลเครื่อง DustBoy ให้ถูกต้อง ได้แก่\n- ขื่อสถานที่ติดตั้ง\n- ที่อยู่\n- พิกัด\n- short URL\n พร้อมกับระบุชื่อผู้ดูแลรับผิดชอบให้ถูกต้องหลังจากนั้นกดปุ่มยืนยัน ระบบจะแจ้งแจ้งทีมงานให้อัพเดทข้อมูลเครื่อง');">แจ้งอัพเดทข้อมูล</a>
			</div>
		</div>
		</form>
	<?php }else{ echo '<p class="text-center">ยังไม่มีข้อมูล</p>';}?>
	</div>
	