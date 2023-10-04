<?php 
$slide_id="";
$slide_name="";
$slide_detail="";
$slide_path="";
$slide_link="";
$slide_status="";
$slide_create=date('Y-m-d H:i:s');
if($rs!=null){
$slide_id=$rs[0]->slide_id;
$slide_name=$rs[0]->slide_name;
$slide_detail=$rs[0]->slide_detail;
$slide_path=$rs[0]->slide_path;
$slide_link=$rs[0]->slide_link;
$slide_status=$rs[0]->slide_status;
$slide_create=$rs[0]->slide_create;
}


?>



<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/slide/" class="btn btn-info"><i class="fa fa-undo"></i> กลับ</a>
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
							<label class="col-md-2 control-label">ชื่อสไลด์</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="slide_name" id="slide_name" title="ชื่อสไลด์" required value="<?=$slide_name?>">
							</div>
						</div><!--
						<div class="form-group">
							<label class="col-md-2 control-label">รายละเอียดสั้นๆ</label>
							<div class="col-md-10">
								<textarea class="form-control" name="slide_detail" id="slide_detail" title="รายละเอียดสั้นๆ"><?=$slide_detail?></textarea>
							</div>
						</div>-->
					
						<div class="form-group">
							<label class="col-md-2 control-label">รูปภาพ</label>
							<div class="col-md-10">
								<?php if(!empty($slide_path)){ ?>
										<div id="image_cover_show">
											<img src="<?=base_url()?>uploads/images/<?=$slide_path?>" style="max-width:100%;max-height:250px;"><br/>
											<button type="button" id="remove_image_cover" class="btn btn-default btn-sm" style="margin-top:10px;">
											<i class="fa fa-trash-o"></i> Remove Image</button>
										</div>
								<?php	} ?>
								<div id="dropzone" name="slide_path" class="dropzone" <?php if(!empty($slide_path)){echo 'style="display:none;"';}?>></div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">ลิงค์เชื่อมโยง</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="slide_link" id="slide_link" title="ลิงค์เชื่อมโยง" required value="<?=$slide_link?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">สถานะการแสดง</label>
							<div class="col-md-10">
								<div class="radio-list">
									<label class="radio-inline">
									<input type="radio" name="slide_status" value="1" <?=$slide_status==1?'checked':''?> <?=$slide_status==''?'checked':''?>> แสดง </label>
									<label class="radio-inline">
									<input type="radio" name="slide_status" value="0" <?=$slide_status==0?'checked':''?> > ซ่อน </label>	
								</div>
							</div>
						</div>
						
					</div>
					
					<div class="form-actions fluid">
						<div class="col-md-offset-2 col-md-10">
							<input type="hidden" name="slide_create" id="slide_create" value="<?=$slide_create?>">
							<input type="hidden" name="slide_id" id="slide_id" value="<?=$slide_id?>">
							<input type="hidden" name="h_image" id="h_image" value="<?=$slide_path?>">
							<button type="submit" id="btn_submit" class="btn btn-primary">บันทึก</button>
							<a href="javascript:history.back()" class="btn btn-default">ยกเลิก</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


