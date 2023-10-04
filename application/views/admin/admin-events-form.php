<?php 
$event_id="";
$event_name="";
$event_description="";
$event_thumbnail="";
$event_status="";
$venue_name="";
$venue_address="";
$event_startdate="";
$event_enddate="";
$event_createdate=date('Y-m-d H:i:s');
$org_name="";
$org_phone="";
$org_email="";
$org_website="";

if($rs!=null){
$event_id=$rs[0]->event_id;
$event_name=$rs[0]->event_name;
$event_description=$rs[0]->event_description;
$event_thumbnail=$rs[0]->event_thumbnail;
$event_status=$rs[0]->event_status;
$venue_name=$rs[0]->venue_name;
$venue_address=$rs[0]->venue_address;
$event_startdate=$rs[0]->event_startdate;
$event_enddate=$rs[0]->event_enddate;
$event_createdate=$rs[0]->event_createdate;
$org_name=$rs[0]->org_name;
$org_phone=$rs[0]->org_phone;
$org_email=$rs[0]->org_email;
$org_website=$rs[0]->org_website;

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
									<label class="col-md-2 control-label">ชื่อกิจกรรม</label>
									<div class="col-md-10">
										<input type="text" class="form-control" name="event_name" id="event_name" title="ชื่อกิจกรรม" required value="<?=$event_name?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">ภาพโปรโมท</label>
									<div class="col-md-10">
										<?php if(!empty($event_thumbnail)){ ?>
												<div id="image_cover_show">
													<img src="<?=base_url()?>uploads/images/<?=$event_thumbnail?>" style="max-width:100%;max-height:250px;"><br/>
													<button type="button" id="remove_image_cover" class="btn btn-default btn-sm" style="margin-top:10px;">
													<i class="fa fa-trash-o"></i> Remove Image</button>
												</div>
										<?php	} ?>
										<div id="dropzone" name="event_thumbnail" class="dropzone" <?php if(!empty($event_thumbnail)){echo 'style="display:none;"';}?>></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">รายละเอียดกิจกรรม</label>
									<div class="col-md-10">
										<textarea class="summernote" name="event_description"><?=$event_description?></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">วันที่เริ่มกิจกรรม</label>
									<div class="col-md-4">
										<input type="text" class="form-control form_datetime" name="event_startdate" id="event_startdate" required title="วันที่เริ่มกิจกรรม" value="<?=$event_startdate?>">
									</div>
									<label class="col-md-2 control-label">วันที่สิ้นสุดกิจกรรม</label>
									<div class="col-md-4">
										<input type="text" class="form-control form_datetime" name="event_enddate" id="event_enddate" required title="วันที่สิ้นสุดกิจกรรม" value="<?=$event_enddate?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">สถานะการแสดง</label>
									<div class="col-md-10">
										<div class="radio-list">
											<label class="radio-inline">
											<input type="radio" name="event_status" value="1" <?=$event_status==1?'checked':''?> <?=$event_status==''?'checked':''?>> แสดง </label>
											<label class="radio-inline">
											<input type="radio" name="event_status" value="0" <?=$event_status==0?'checked':''?> > ซ่อน </label>	
										</div>
									</div>
								</div>
						</div>
						<hr/>
						<div style="margin-bottom:30px;">
								
								<div class="form-group">
									<label class="col-md-2 control-label">สถานะที่จัดกิจกรรม</label>
									<div class="col-md-10">
										<input type="text" class="form-control" name="venue_name" id="venue_name" title="สถานะที่จัดกิจกรรม" required value="<?=$venue_name?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">ที่อยู่</label>
									<div class="col-md-10">
										<input type="text" class="form-control" name="venue_address" id="venue_address" title="ที่อยู่" value="<?=$venue_address?>">
									</div>
								</div>
						</div>		
						<hr/>	
						<div style="margin-bottom:30px;">
								
								<div class="form-group">
									<label class="col-md-2 control-label">ชื่อหน่วยงาน</label>
									<div class="col-md-10">
										<input type="text" class="form-control" name="org_name" id="org_name" title="ชื่อหน่วยงาน" required value="<?=$org_name?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">โทรศัพท์</label>
									<div class="col-md-10">
										<input type="text" class="form-control" name="org_phone" id="org_phone" title="โทรศัพท์" value="<?=$org_phone?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">อีเมล์</label>
									<div class="col-md-10">
										<input type="rmail" class="form-control" name="org_email" id="org_email" title="อีเมล์" value="<?=$org_email?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">เว็บไซต์</label>
									<div class="col-md-10">
										<input type="text" class="form-control" name="org_website" id="org_website" title="เว็บไซต์"  value="<?=$org_website?>">
									</div>
								</div>
						</div>		
						<hr/>	

						
						
					</div>
					
					<div class="form-actions fluid">
						<div class="col-md-offset-2 col-md-10">
							<input type="hidden" name="h_image" id="h_image" value="<?=$event_thumbnail?>">
							<input type="hidden" name="event_id" id="event_id" value="<?=$event_id?>">
							<input type="hidden" name="event_createdate" id="event_createdate" value="<?=$event_createdate?>">
							<button type="submit" id="btn_submit" class="btn btn-primary">บันทึก</button>
							<a href="javascript:history.back()" class="btn btn-default">ยกเลิก</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
