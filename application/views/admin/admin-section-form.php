<?php 
$idsection=1;
$idcontent="";
$content_title="";
$content_short_description="";
$category_parent="";
$content_full_description="";
$content_thumbnail="";
$id_category="";
$content_hashtag="";
$content_status="";
$content_public=date('Y-m-d H:i:s');
if($rs!=null){
$idcontent=$rs[0]->idcontent;
$content_title=$rs[0]->content_title;
$content_short_description=$rs[0]->content_short_description;
$content_full_description=$rs[0]->content_full_description;
$content_thumbnail=$rs[0]->content_thumbnail;
$id_category=$rs[0]->id_category;
$content_hashtag=$rs[0]->content_hashtag;
$content_status=$rs[0]->content_status;
$content_public=$rs[0]->content_public;
}
	
?>

<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/section/<?=$idsection?>" class="btn btn-info"><i class="fa fa-undo"></i> กลับ</a>
			</div>
		</div>
		<hr/>
		<div class="row">
			<div class="col-md-12">
				<div class="containerz col-md-6 col-md-offset-3 alert alert-danger" style="display: none;margin-top:20px;" >
					<h4>กรุณาป้อนข้อมูลต่อไปนี้ให้ถูกต้องครบถ้วน</h4>
					<ol></ol>
				</div>
				<div class="clearfix"></div>
				<form class="form-horizontal" method="post" role="form" id="frm_content_validate" enctype="multipart/form-data">
					<div class="form-body">
						
						<div class="form-group">
							<label class="col-md-2 control-label">ชื่อเรื่อง</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="content_title" id="content_title" title="ชื่อเรื่อง" required value="<?=$content_title?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">คำอธิบายสั้นๆ</label>
							<div class="col-md-10">
								<textarea class="form-control" name="content_short_description" id="content_short_description"><?=htmlspecialchars($content_short_description)?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">เนื้อหา</label>
							<div class="col-md-10">
								<div id="summernote"></div>
								<textarea class="summernote" name="content_full_description" style="display: none;"><?=$content_full_description?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">รูปภาพ</label>
							<div class="col-md-10">
								<?php if(!empty($content_thumbnail)){ ?>
										<div id="image_cover_show">
											<img src="<?=base_url()?>uploads/images/<?=$content_thumbnail?>" style="max-width:100%;max-height:250px;"><br/>
											<button type="button" id="remove_image_cover" class="btn btn-default btn-sm" style="margin-top:10px;">
											<i class="fa fa-trash-o"></i> Remove Image</button>
										</div>
								<?php	} ?>
								<div id="dropzone" name="content_thumbnail" class="dropzone" <?php if(!empty($content_thumbnail)){echo 'style="display:none;"';}?>></div>
								<br/><i class="text-warning">แนะนำขนาดรูปภาพไม่เกิน 800x600 pixel</i>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">หมวดหมู่</label>
							<div class="col-md-10">
								<select class="form-control" name="id_category" id="id_category" title="หมวดหมู่" required>
									<option value=""> - select category - </option>
									<?php  foreach ($category as $key => $value) {?>  
										<?php if($value->id_section==$idsection){?>
										   <option value="<?=$value->id_category?>" <?=$id_category==$value->id_category?'selected':''?>> <?=$value->category_name?> </option> 
										<?php }?>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">คำค้นหา</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="content_hashtag" id="content_hashtag" required title="content_hashtag" value="<?=$content_hashtag?>" data-role="tagsinput">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">สถานะ</label>
							<div class="col-md-10">
								<div class="radio-list">
									<label class="radio-inline">
									<input type="radio" name="content_status" value="1" <?=$content_status==1?'checked':''?> <?=$content_status==''?'checked':''?>> แสดง </label>
									<label class="radio-inline">
									<input type="radio" name="content_status" value="0" <?=$content_status==0?'checked':''?> > ซ่อน </label>	
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">ตั้งเวลาแสดงเนื้อหา</label>
							<div class="col-md-4" style="padding-top: 7px;">
								<div class="input-group date form_datetime">
									<input type="text" name="content_public" size="16" readonly class="form-control" value="<?=$content_public?>">
									<span class="input-group-btn">
										<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
									</span>
								</div>
							</div>
						</div>
						<hr/>
						<div id="fList">
							<div class="form-group">
								<label class="control-label col-md-2">ไฟล์แนบอื่นๆ</label>
								<div class="col-md-10">
									<button type="button" id="btnAddFile" class="btn btn-primary btn-success">
										<i class="fa fa-plus"></i>
									</button>
								</div>
							</div>
						</div>
						<?php if($_rsFile!=null){?>
						<?php foreach($_rsFile as $k=>$v){?>
						<div class="container-getQuotationDetail">
							<div class="form-group">
								<div class="col-md-2"></div>
								<div class="col-md-10">
									<a href="<?=base_url()?>uploads/docs/<?=$v->file_path?>" target="_blank"><span class='label label-info' id="upload-file-info-<?=$v->file_id?>"><?=$v->file_name?></span></a> | 
									<a href="<?=base_url()?>admin/section/1/delfile/<?=$v->file_id?>/<?=$v->file_idcontent?>" class="btn btn-danger btn-xs" onClick="return confirm('Delete Comfirm ?');"><i class="fa fa-trash-o"></i> Delete</a>
								</div>
							</div>	
						</div>
						<?php }?>
						<?php }?>
						
						
					</div>
					
					<div class="form-actions fluid">
						<div class="col-md-offset-2 col-md-10">
							<input type="hidden" name="h_image" id="h_image" value="<?=$content_thumbnail?>">
							<input type="hidden" name="idcontent" id="idcontent" value="<?=$idcontent?>">
							<button type="submit" id="btn_submit" class="btn btn-primary">บันทึก</button>
							<a href="javascript:history.back()" class="btn btn-default">ยกเลิก</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
