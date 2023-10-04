<?php 
	$intro_id="";
	$intro_name="";
	$intro_type="";
    $intro_txt="";
    $intro_img="";
	$intro_active="";
	$intro_create=date('Y-m-d H:i:s');
	if($rs!=null){
	$intro_id=$rs[0]->intro_id;
	$intro_name=$rs[0]->intro_name;
	$intro_type=$rs[0]->intro_type;
    $intro_txt=$rs[0]->intro_txt;
    $intro_img=$rs[0]->intro_img;
	$intro_active=$rs[0]->intro_active;
	$intro_create=$rs[0]->intro_create;	
	}
?>

<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/landingpage" class="btn btn-info"><i class="fa fa-undo"></i> กลับ</a>
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
				<form class="form-horizontal" method="post" role="form" id="frm_content" enctype="multipart/form-data">
					<div class="form-body">
						
						<div class="form-group">
							<label class="col-md-2 control-label">ชื่อเรื่อง</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="intro_name" id="intro_name" title="ชื่อเรื่อง" required value="<?=$intro_name?>">
							</div>
						</div>

                        <div class="form-group">
							<label class="control-label col-md-2">ประเภทการแสดง</label>
							<div class="col-md-10">
								<select class="form-control" name="intro_type" id="intro_type" required title="ประเภทการแสดง">
										<option value=""> Select type </option>
										<option value="1" <?=$intro_type=="1"?'selected':''?>> Popup</option>
										<option value="2" <?=$intro_type=="2"?'selected':''?>> Landing Page</option>
								</select>
							</div>
						</div>
   
                        <div id="tcontent" style="<?=$intro_type==2?'':'display:none;'?>">
						<div class="form-group">
							<label class="col-md-2 control-label">เนื้อหา</label>
							<div class="col-md-10">
								
								<textarea class="summernote" name="intro_txt" style="display: none;"><?=$intro_txt?></textarea>
							</div>
						</div>
                        </div>

                        <div id="timage" style="<?=$intro_type==1?'':'display:none;'?>">
                        <div class="form-group">
							<label class="col-md-2 control-label">รูปภาพ</label>
							<div class="col-md-10">
								<?php if(!empty($intro_img)){ ?>
										<div id="image_cover_show">
											<img src="<?=base_url()?>uploads/images/<?=$intro_img?>" style="max-width:100%;max-height:250px;"><br/>
											<button type="button" id="remove_image_cover" class="btn btn-default btn-sm" style="margin-top:10px;">
											<i class="fa fa-trash-o"></i> Remove Image</button>
										</div>
								<?php	} ?>

								<div id="dropzone" class="dropzone" <?php if(!empty($intro_img)){echo 'style="display:none;"';}?>></div>
							</div>
						</div>
                        </div>

                        <div class="form-group">
							<label class="control-label col-md-2">สถานะการแสดง</label>
							<div class="col-md-10" style="padding-top: 8px;">
								<input name="intro_active" value="0" type="hidden">
								<input id="intro_active" name="intro_active" type="checkbox" class="form-control tags" value="1" <?=$intro_active==1?'checked':''?>> 
							</div>
						</div>

						
					</div>
					
					<div class="form-actions fluid">
						<div class="col-md-offset-2 col-md-10">
                            <input type="hidden" name="intro_create" id="intro_create" value="<?=$intro_create?>">
                            <input type="hidden" name="intro_id" id="intro_id" value="<?=$intro_id?>">
                            <input type="hidden" name="h_image" id="h_image" value="<?=$intro_img?>">
							<button type="submit" id="btn_submit" class="btn btn-primary">บันทึก</button>
							<a href="javascript:history.back()" class="btn btn-default">ยกเลิก</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
