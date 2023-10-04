<?php 
$job_id="";
$job_name="";
$job_logo="";
$job_detail="";
$job_benefit="";
$job_salary="";
$job_property="";
$company_name="";
$company_detail="";
$company_address="";
$company_email="";
$company_tel="";
$company_website="";
$job_category_id="";
$job_province_id="";
$job_viewcount="";
$job_status="";
$job_rec="";
$job_createdate=date('Y-m-d H:i:s');

if($rs!=null){
$job_id=$rs[0]->job_id;
$job_name=$rs[0]->job_name;
$job_logo=$rs[0]->job_logo;
$job_detail=$rs[0]->job_detail;
$job_benefit=$rs[0]->job_benefit;
$job_salary=$rs[0]->job_salary;
$job_property=$rs[0]->job_property;
$company_name=$rs[0]->company_name;
$company_detail=$rs[0]->company_detail;
$company_address=$rs[0]->company_address;
$company_email=$rs[0]->company_email;
$company_tel=$rs[0]->company_tel;
$company_website=$rs[0]->company_website;
$job_category_id=$rs[0]->job_category_id;
$job_province_id=$rs[0]->job_province_id;
$job_viewcount=$rs[0]->job_viewcount;
$job_status=$rs[0]->job_status;
$job_rec=$rs[0]->job_rec;
$job_createdate=$rs[0]->job_createdate;
}
?>

<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/page" class="btn btn-info"><i class="fa fa-undo"></i> กลับ</a>
			</div>
		</div>
		<hr/>
		<div class="row">
			<div class="col-md-12">

				<div class="containerz col-md-6 col-md-offset-3 alert alert-danger" style="display: none;margin-top:20px;">
					<h4>กรุณาป้อนข้อมูลต่อไปนี้ให้ถูกต้องครบถ้วน</h4>
					<ol></ol>
				</div>
				<div class="clearfix"></div>
				<form class="form-horizontal" method="post" role="form" id="frm_content">
					<div class="form-body">
						<div style="margin-bottom:30px;">
								
								<div class="form-group">
									<label class="col-md-2 control-label">ชื่อตำแหน่ง</label>
									<div class="col-md-10">
										<input type="text" class="form-control" name="job_name" id="job_name" title="ชื่อตำแหน่ง" required value="<?=$job_name?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">ประเภทงาน</label>
									<div class="col-md-10">
										<select class="form-control" name="job_category_id" id="job_category_id" title="หมวดหมู่" required>
											<option value=""> - select category - </option>
											<?php  foreach ($rsCat as $key => $value) {?>  
												   <option value="<?=$value->cat_id?>" <?=$job_category_id==$value->cat_id?'selected':''?>> <?=$value->cat_name?> </option> 			
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">จังหวัด</label>
									<div class="col-md-10">
										<select class="form-control" name="job_province_id" id="job_province_id" title="จังหวัด" required>
											<option value=""> - select province - </option>
											<?php  foreach ($rsProvince as $key => $value) {?>  
												   <option value="<?=$value->PROVINCE_ID?>" <?=$job_province_id==$value->PROVINCE_ID?'selected':''?>> <?=$value->PROVINCE_NAME?> </option> 			
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">ภาพโปรโมท</label>
									<div class="col-md-10">
										<?php if(!empty($job_logo)){ ?>
												<div id="image_cover_show">
													<img src="<?=base_url()?>uploads/images/<?=$job_logo?>" style="max-width:100%;max-height:250px;"><br/>
													<button type="button" id="remove_image_cover" class="btn btn-default btn-sm" style="margin-top:10px;">
													<i class="fa fa-trash-o"></i> Remove Image</button>
												</div>
										<?php	} ?>
										<div id="dropzone" name="job_logo" class="dropzone" <?php if(!empty($job_logo)){echo 'style="display:none;"';}?>></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">รายละเอียดงาน</label>
									<div class="col-md-10">
										<textarea class="summernote" name="job_detail"><?=$job_detail?></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">สวัสดิการ</label>
									<div class="col-md-10">
										<input type="text" class="form-control" name="job_benefit" id="job_benefit" title="สวัสดิการ" value="<?=$job_benefit?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-2 control-label">เงินเดือน</label>
									<div class="col-md-10">
										<input type="text" class="form-control" name="job_salary" id="job_salary" title="เงินเดือน" value="<?=$job_salary?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-2 control-label">คุณสมบัติผู้สมัคร</label>
									<div class="col-md-10">
										<textarea class="summernote" name="job_property"><?=$job_property?></textarea>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label">แนะนำประกาศนี้</label>
									<div class="col-md-10">
										<div class="radio-list">
											<label class="radio-inline">
											<input type="radio" name="job_rec" value="1" <?=$job_rec==1?'checked':''?> <?=$job_rec==''?'checked':''?>> แนะนำ </label>
											<label class="radio-inline">
											<input type="radio" name="job_rec" value="0" <?=$job_rec==0?'checked':''?> > เพิกเฉย </label>	
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">สถานะการแสดง</label>
									<div class="col-md-10">
										<div class="radio-list">
											<label class="radio-inline">
											<input type="radio" name="job_status" value="1" <?=$job_status==1?'checked':''?> <?=$job_status==''?'checked':''?>> แสดง </label>
											<label class="radio-inline">
											<input type="radio" name="job_status" value="0" <?=$job_status==0?'checked':''?> > ซ่อน </label>	
										</div>
									</div>
								</div>
						</div>
						<hr/>

						<div style="margin-bottom:30px;">
								
								<div class="form-group">
									<label class="col-md-2 control-label">ชื่อบริษัท</label>
									<div class="col-md-10">
										<input type="text" class="form-control" name="company_name" id="company_name" title="ชื่อหน่วยงาน" required value="<?=$company_name?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">รายละเอียด</label>
									<div class="col-md-10">
										<textarea  class="form-control" rows="3" name="company_detail" id="company_detail"><?=$company_detail?></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">ที่อยู่</label>
									<div class="col-md-10">
										<textarea  class="form-control" rows="3" name="company_address" id="company_address"><?=$company_address?></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">โทรศัพท์</label>
									<div class="col-md-10">
										<input type="text" class="form-control" name="company_tel" id="company_tel" title="โทรศัพท์" value="<?=$company_tel?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">อีเมล์</label>
									<div class="col-md-10">
										<input type="rmail" class="form-control" name="company_email" id="company_email" title="อีเมล์" value="<?=$company_email?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">เว็บไซต์</label>
									<div class="col-md-10">
										<input type="text" class="form-control" name="company_website" id="company_website" title="เว็บไซต์"  value="<?=$company_website?>">
									</div>
								</div>
						</div>		
						<hr/>	

						
						
					</div>
					
					<div class="form-actions fluid">
						<div class="col-md-offset-2 col-md-10">
							<input type="hidden" name="h_image" id="h_image" value="<?=$job_logo?>">
							<input type="hidden" name="job_id" id="job_id" value="<?=$job_id?>">
							<input type="hidden" name="job_createdate" id="job_createdate" value="<?=$job_createdate?>">
							<button type="submit" id="btn_submit" class="btn btn-primary">บันทึก</button>
							<a href="javascript:history.back()" class="btn btn-default">ยกเลิก</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
