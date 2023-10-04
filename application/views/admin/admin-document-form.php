<?php 
$doc_id="";
$doc_name="";
$doc_cat_id="";
$doc_file="";
$doc_status="";
$doc_size="";
$doc_member_code="admin";
$doc_datetime=date('Y-m-d H:i:s');
if($rs!=null){
$doc_id=$rs[0]->doc_id;
$doc_name=$rs[0]->doc_name;
$doc_cat_id=$rs[0]->doc_cat_id;
$doc_file=$rs[0]->doc_file;
$doc_status=$rs[0]->doc_status;
$doc_size=$rs[0]->doc_size;
$doc_member_code=$rs[0]->doc_member_code;
$doc_datetime=$rs[0]->doc_datetime;


}

if($this->uri->segment(3)=="add"){
	$action_lang = 'th';
}
if($this->uri->segment(3)=="edit"){
	$action_lang = $this->uri->segment(5);
}
?>



<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/personal/" class="btn btn-info"><i class="fa fa-undo"></i> กลับ</a>
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
				<form class="form-horizontal" method="post" role="form" id="form_document" enctype="multipart/form-data">
					<div class="form-body">
						<div class="form-group">
							<label class="col-md-2 control-label">หัวข้อเอกสาร</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="doc_name" id="doc_name" title="หัวข้อเอกสาร" required value="<?=$doc_name?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">หมวดหมู่</label>
							<div class="col-md-10">
								<select class="form-control" name="doc_cat_id" id="doc_cat_id" title="หมวดหมู่" required>
											<option value=""> - select category - </option>
											<?php  foreach ($rsCat as $key => $value) {?>  
												   <option value="<?=$value->cat_id?>" <?=$doc_cat_id==$value->cat_id?'selected':''?>> <?=$value->cat_name?> </option> 			
											<?php } ?>
										</select>
								
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">ไฟล์เอกสาร</label>
							<div class="col-md-10">
								<?php if($doc_file!=null){?>
								<div id="file_tools">
									<a href="<?=base_url()?>uploads/docs/<?=$doc_file?>" target="_blank"><?=$doc_file?></a> <span id="file_edit" class="btn btn-sm btn-default">edit</span>
								</div>
								<?php }?>
								
								<div id="file_open" style="<?=$doc_file!=null?'display:none;':''?>">
									<div style="position:relative;margin-bottom:10px;">
										<a class='btn btn-info' href='javascript:;'>
											select file...
											<input type="file" title="Full paper submission"  required id="doc_file" name="doc_file" style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;' name="file_source" size="40"  onchange='$("#upload-file-info").html($(this).val());'>
										</a>
										&nbsp;
										<span class='label label-info' id="upload-file-info"></span>
									</div>
								</div>
							</div>
						</div>
 

                       
						<div class="form-group">
							<label class="col-md-2 control-label">สถานะการแสดง</label>
							<div class="col-md-10">
								<div class="radio-list">
									<label class="radio-inline">
									<input type="radio" name="doc_status" value="1" <?=$doc_status==1?'checked':''?> <?=$doc_status==''?'checked':''?>> แสดง </label>
									<label class="radio-inline">
									<input type="radio" name="doc_status" value="0" <?=$doc_status==0?'checked':''?> > ซ่อน </label>	
								</div>
							</div>
						</div>
						
					</div>
					
					<div class="form-actions fluid">
						<div class="col-md-offset-2 col-md-10">
							<input type="hidden" name="doc_member_code" id="doc_member_code" value="<?=$doc_member_code?>">
							<input type="hidden" name="doc_datetime" id="doc_datetime" value="<?=date('Y-m-d H:i:s')?>">
							<input type="hidden" name="doc_id" id="doc_id" value="<?=$doc_id?>">
							<button type="submit" id="btn_submit" class="btn btn-primary">บันทึก</button>
							<a href="javascript:history.back()" class="btn btn-default">ยกเลิก</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


