<?php 
$id="";
$yt_id="";
$yt_name="";
$yt_detail="";
$yt_status="";
$yt_thumbnail="";
$yt_datetime=date('Y-m-d H:i:s');
if($rs!=null){
$id=$rs[0]->id;
$yt_id=$rs[0]->yt_id;
$yt_name=$rs[0]->yt_name;
$yt_detail=$rs[0]->yt_detail;
$yt_status=$rs[0]->yt_status;
$yt_thumbnail=$rs[0]->yt_thumbnail;
$yt_datetime=$rs[0]->yt_datetime;
}
?>



<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/vdo/" class="btn btn-info"><i class="fa fa-undo"></i> กลับ</a>
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
							<label class="col-md-2 control-label">วีดีโอ ไอดี</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="yt_id" id="yt_id" title="วีดีโอ ไอดี" required <?=$yt_id!=null?'readonly':''?> value="<?=$yt_id?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label"></label>
							<div class="col-md-10">
								<div id='imageloadstatus' style='display:none'><img src="<?=base_url()?>assets/img/loading.gif" alt="Uploading...."/></div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">ชื่อวีดีโอ</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="yt_name" id="yt_name" title="ชื่อวีดีโอ" required value="<?=$yt_name?>" <?=$yt_id==null?'readonly':''?>>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">เนื้อหา</label>
							<div class="col-md-10">
								<textarea class="summernote" name="yt_detail" id="yt_detail" <?=$yt_id==null?'readonly':''?>><?=$yt_detail?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">รูปภาพ</label>
							<div class="col-md-10">
								<div id="img_preview">
									<?=$yt_id!=null?'<img src="'.$yt_thumbnail.'" width="150"/><br/>':''?>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">สถานะการแสดง</label>
							<div class="col-md-10">
								<div class="radio-list">
									<label class="radio-inline">
									<input type="radio" name="yt_status" value="1" <?=$yt_status==1?'checked':''?> <?=$yt_status==''?'checked':''?>> แสดง </label>
									<label class="radio-inline">
									<input type="radio" name="yt_status" value="0" <?=$yt_status==0?'checked':''?> > ซ่อน </label>	
								</div>
							</div>
						</div>
						
					</div>
					
					<div class="form-actions fluid">
						<div class="col-md-offset-2 col-md-10">
							<input type="hidden" name="yt_thumbnail" id="yt_thumbnail" value="<?php if(!empty($rs["video_id"])){ echo $rs["yt_thumbnail"];}?>">
							<input type="hidden" name="yt_datetime" id="yt_datetime" value="<?=$yt_datetime?>">
							<input type="hidden" name="id" id="id" value="<?=$id?>">
							<button type="submit" id="btn_submit" class="btn btn-primary" <?php if(empty($rs["yt_id"])){ echo 'disabled';}?>>บันทึก</button>
							<a href="javascript:history.back()" class="btn btn-default">ยกเลิก</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


