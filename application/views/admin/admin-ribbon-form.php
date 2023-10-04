<?php 
	$ribbon_id="";
	$ribbon_name="";
	$ribbon_img="";
    $ribbon_position="";
    $ribbon_link_status="";
	$ribbon_link_value="";
	$ribbon_status="";
	$ribbon_create=date('Y-m-d H:i:s');
	if($rs!=null){
	$ribbon_id=$rs[0]->ribbon_id;
	$ribbon_name=$rs[0]->ribbon_name;
	$ribbon_img=$rs[0]->ribbon_img;
    $ribbon_position=$rs[0]->ribbon_position;
    $ribbon_link_status=$rs[0]->ribbon_link_status;
	$ribbon_link_value=$rs[0]->ribbon_link_value;
	$ribbon_status=$rs[0]->ribbon_status;
	$ribbon_create=$rs[0]->ribbon_create;	
	}
?>

<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/ribbon" class="btn btn-info"><i class="fa fa-undo"></i> กลับ</a>
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
							<label class="col-md-2 control-label">ชื่อริบบิ้น</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="ribbon_name" id="ribbon_name" title="ชื่อริบบิ้น" required value="<?=$ribbon_name?>">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-2 control-label">รูปภาพ</label>
							<div class="col-md-10">
								<?php if(!empty($ribbon_img)){ ?>
										<div id="image_cover_show">
											<img src="<?=base_url()?>uploads/images/<?=$ribbon_img?>" style="max-width:100%;max-height:250px;"><br/>
											<button type="button" id="remove_image_cover" class="btn btn-default btn-sm" style="margin-top:10px;">
											<i class="fa fa-trash-o"></i> Remove Image</button>
										</div>
								<?php	} ?>

								<div id="dropzone" class="dropzone" <?php if(!empty($ribbon_img)){echo 'style="display:none;"';}?>></div>
							</div>
						</div>

                        <div class="form-group">
							<label class="control-label col-md-2">ตำแหน่งการแสดง</label>
							<div class="col-md-10">
								<select class="form-control" name="ribbon_position" id="ribbon_position" required title="ตำแหน่งการแสดง">
										<option value=""> Select type </option>
										<option value="TL" <?=$ribbon_position=="TL"?'selected':''?>> บน ซ้าย</option>
										<option value="TR" <?=$ribbon_position=="TR"?'selected':''?>> บน ขวา</option>
										<option value="BL" <?=$ribbon_position=="BL"?'selected':''?>> ล่าง ซ้าย</option>
										<option value="BR" <?=$ribbon_position=="BR"?'selected':''?>> ล่าง ขวา</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-2">เปิดใช้งานลิงค์</label>
							<div class="col-md-10" style="padding-top: 8px;">
								<input name="ribbon_link_status" value="0" type="hidden">
								<input id="ribbon_link_status" name="ribbon_link_status" type="checkbox" class="form-control tags" value="1" <?=$ribbon_link_status==1?'checked':''?>> 
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-2 control-label">ลิงค์ที่อยู่</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="ribbon_link_value" id="ribbon_link_value" title="ลิงค์ที่อยู่" value="<?=$ribbon_link_value?>">
							</div>
						</div>
						

                        <div class="form-group">
							<label class="control-label col-md-2">สถานะการแสดง</label>
							<div class="col-md-10" style="padding-top: 8px;">
								<input name="ribbon_status" value="0" type="hidden">
								<input id="ribbon_status" name="ribbon_status" type="checkbox" class="form-control tags" value="1" <?=$ribbon_status==1?'checked':''?>> 
							</div>
						</div>

						
					</div>
					
					<div class="form-actions fluid">
						<div class="col-md-offset-2 col-md-10">
                            <input type="hidden" name="ribbon_create" id="ribbon_create" value="<?=$ribbon_create?>">
                            <input type="hidden" name="ribbon_id" id="ribbon_id" value="<?=$ribbon_id?>">
                            <input type="hidden" name="h_image" id="h_image" value="<?=$ribbon_img?>">
							<button type="submit" id="btn_submit" class="btn btn-primary">บันทึก</button>
							<a href="javascript:history.back()" class="btn btn-default">ยกเลิก</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
