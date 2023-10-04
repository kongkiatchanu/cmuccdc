<?php 
$gallery_id="";
$gallery_name="";
$gallery_thumbnail="";
$gallery_description="";
$gallery_status="";
$gallery_create=date('Y-m-d H:i:s');
if($rs!=null){
$gallery_id=$rs[0]->gallery_id;
$gallery_name=$rs[0]->gallery_name;
$gallery_thumbnail=$rs[0]->gallery_thumbnail;
$gallery_description=$rs[0]->gallery_description;
$gallery_status=$rs[0]->gallery_status;
$gallery_create=$rs[0]->gallery_create;
}
?>



<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/gallery/" class="btn btn-info"><i class="fa fa-undo"></i> กลับ</a>
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
						<ul class="nav nav-tabs">
							<li class="active"><a href="#tab1" data-toggle="tab">ข้อมูลทั่วไป</a></li>
							<li class=""><a href="#tab2" data-toggle="tab" style="pointer-events:none;cursor: default;">รูปภาพ</a> </li>
							
						</ul>
						<div class="tab-content">
							<div class="tab-pane fade active in" id="tab1">
								<div class="form-group">
									<label class="col-md-2 control-label">ชื่ออัลบั้ม</label>
									<div class="col-md-10">
										<input type="text" class="form-control" name="gallery_name" id="gallery_name" title="Gallery Name" required value="<?=$gallery_name?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">ภาพทัมเนล</label>
									<div class="col-md-10">
										<?php if(!empty($gallery_thumbnail)){ ?>
												<div id="image_cover_show">
													<img src="<?=base_url()?>uploads/images/<?=$gallery_thumbnail?>" style="max-width:100%;max-height:250px;"><br/>
													<button type="button" id="remove_image_cover" class="btn btn-default btn-sm" style="margin-top:10px;">
													<i class="fa fa-trash-o"></i> Remove Image</button>
												</div>
										<?php	} ?>

										<div id="dropzone" name="gallery_thumbnail" class="dropzone" <?php if(!empty($gallery_thumbnail)){echo 'style="display:none;"';}?>></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">คำอธิบาย</label>
									<div class="col-md-10">
										<div id="summernote"></div>
										<textarea class="summernote" name="gallery_description" style="display: none;"><?=$gallery_description?></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">สถานะการแสดง</label>
									<div class="col-md-10">
										<div class="radio-list">
											<label class="radio-inline">
											<input type="radio" name="gallery_status" value="1" <?=$gallery_status==1?'checked':''?> <?=$gallery_status==''?'checked':''?>> แสดง </label>
											<label class="radio-inline">
											<input type="radio" name="gallery_status" value="0" <?=$gallery_status==0?'checked':''?> > ซ่อน </label>	
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane fade " id="tab2">
							</div>
						</div>
						
						
						
					</div>
					
					<div class="form-actions fluid">
						<div class="col-md-offset-2 col-md-10">
							<input type="hidden" name="gallery_create" id="gallery_create" value="<?=$gallery_create?>">
							<input type="hidden" name="gallery_id" id="gallery_id" value="<?=$gallery_id?>">
							<input type="hidden" name="h_image" id="h_image" value="<?=$gallery_thumbnail?>">
							<button type="submit" id="btn_submit" class="btn btn-primary">บันทึก</button>
							<a href="javascript:history.back()" class="btn btn-default">ยกเลิก</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


