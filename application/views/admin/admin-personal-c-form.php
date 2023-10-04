<?php 
$personal_id="";
$personal_name="";
$personal_detail="";
$personal_img="";
$personal_position="";
$personal_qno="";
$personal_status="";
$personal_type_id="";
$personal_create=date('Y-m-d H:i:s');
if($rs!=null){
$personal_id=$rs[0]->personal_id;
$personal_name=$rs[0]->personal_name;
$personal_detail=$rs[0]->personal_detail;
$personal_img=$rs[0]->personal_img;
$personal_position=$rs[0]->personal_position;
$personal_qno=$rs[0]->personal_qno;
$personal_status=$rs[0]->personal_status;
$personal_type_id=$rs[0]->personal_type_id;
$personal_create=$rs[0]->personal_create;

}


?>



<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/personal_council/" class="btn btn-info"><i class="fa fa-undo"></i> กลับ</a>
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
				<form class="form-horizontal" method="post" role="form" id="frm_slide">
					<div class="form-body">
						<div class="form-group">
							<label class="col-md-2 control-label">ชื่อ - นามสกุล</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="personal_name" id="personal_name" title="ชื่อ - นามสกุล" required value="<?=$personal_name?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">รายละเอียดสั้นๆ</label>
							<div class="col-md-10">
								<textarea class="form-control" name="personal_detail" id="personal_detail" title="รายละเอียดสั้นๆ"><?=$personal_detail?></textarea>
							</div>
						</div>
					
						<div class="form-group">
							<label class="col-md-2 control-label">รูปภาพ</label>
							<div class="col-md-10">
								<?php if(!empty($personal_img)){ ?>
										<div id="image_cover_show">
											<img src="<?=base_url()?>uploads/images/<?=$personal_img?>" style="max-width:100%;max-height:250px;"><br/>
											<button type="button" id="remove_image_cover" class="btn btn-default btn-sm" style="margin-top:10px;">
											<i class="fa fa-trash-o"></i> Remove Image</button>
										</div>
								<?php	} ?>
								<div id="dropzone" name="personal_img" class="dropzone" <?php if(!empty($personal_img)){echo 'style="display:none;"';}?>></div>
								<br/>ภาพควรมีขนาด 309x396 pixel
							</div>
                        </div>
                        
                        <div class="form-group">
							<label class="col-md-2 control-label">ตำแหน่ง</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="personal_position" id="personal_position" title="ตำแหน่ง" required value="<?=$personal_position?>">
							</div>
                        </div>    
						
						<div class="form-group">
							<label class="col-md-2 control-label">ส่วนราชการ</label>
							<div class="col-md-6">
								<select class="form-control input-medium" name="personal_type_id" id="personal_type_id" title="ส่วนราชการ" required>
									<option value=""> - select Parent - </option>
									<?php  foreach ($rsPType as $key => $value) {?>  
										   <option value="<?=$value->type_id?>" <?=$personal_type_id==$value->type_id?'selected':''?> > <?=$value->type_name?> </option> 
									<?php } ?>
								</select>
							</div>
						</div>
                        
                        <div class="form-group">
							<label class="col-md-2 control-label">ลำดับการแสดงผล</label>
							<div class="col-md-10">
								<input type="number" class="form-control input-small" name="personal_qno" id="personal_qno" title="ลำดับการแสดงผล" required value="<?=$personal_qno?>">
							</div>
						</div>     
                       
						<div class="form-group">
							<label class="col-md-2 control-label">สถานะการแสดง</label>
							<div class="col-md-10">
								<div class="radio-list">
									<label class="radio-inline">
									<input type="radio" name="personal_status" value="1" <?=$personal_status==1?'checked':''?> <?=$personal_status==''?'checked':''?>> แสดง </label>
									<label class="radio-inline">
									<input type="radio" name="personal_status" value="0" <?=$personal_status==0?'checked':''?> > ซ่อน </label>	
								</div>
							</div>
						</div>
						
					</div>
					
					<div class="form-actions fluid">
						<div class="col-md-offset-2 col-md-10">
							<input type="hidden" name="personal_create" id="personal_create" value="<?=$personal_create?>">
							<input type="hidden" name="personal_id" id="personal_id" value="<?=$personal_id?>">
							<input type="hidden" name="h_image" id="h_image" value="<?=$personal_img?>">
							<button type="submit" id="btn_submit" class="btn btn-primary">บันทึก</button>
							<a href="javascript:history.back()" class="btn btn-default">ยกเลิก</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


