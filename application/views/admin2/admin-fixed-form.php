<?php 
    $fixed_id=null;
    $fixed_source_id="";
    $fixed_type="";
	
    $fixed_come_date="";
    $fixed_come_file="";
    $fixed_come_comment=""; 
	
	$fixed_get_date="";
    $fixed_get_file="";
    $fixed_get_comment="";
	$fixed_send_date="";
    $fixed_send_file="";
    $fixed_send_comment="";
    $fixed_send_type="";
	$fixed_repair_date="";
    $fixed_repair_file="";
    $fixed_repair_comment="";
	$fixed_public_date="";
    $fixed_public_file="";
    $fixed_public_comment="";
    $fixed_public_post="";
    $createdate=date('Y-m-d H:i:s');
    $updatedate=date('Y-m-d H:i:s');

    if($rs!=null){
        $fixed_id=$rs[0]->fixed_id;
        $fixed_source_id=$rs[0]->fixed_source_id;
        $fixed_type=$rs[0]->fixed_type;
		
        $fixed_come_date=$rs[0]->fixed_come_date;
        $fixed_come_file=$rs[0]->fixed_come_file;
        $fixed_come_comment=$rs[0]->fixed_come_comment; 
		
		$fixed_get_date=$rs[0]->fixed_get_date;
        $fixed_get_file=$rs[0]->fixed_get_file;
        $fixed_get_comment=$rs[0]->fixed_get_comment;
		$fixed_send_date=$rs[0]->fixed_send_date;
        $fixed_send_file=$rs[0]->fixed_send_file;
        $fixed_send_comment=$rs[0]->fixed_send_comment;
        $fixed_send_type=$rs[0]->fixed_send_type;
		$fixed_repair_date=$rs[0]->fixed_repair_date;
        $fixed_repair_file=$rs[0]->fixed_repair_file;
        $fixed_repair_comment=$rs[0]->fixed_repair_comment;
		$fixed_public_date=$rs[0]->fixed_public_date;
        $fixed_public_file=$rs[0]->fixed_public_file;
        $fixed_public_comment=$rs[0]->fixed_public_comment;
        $fixed_public_post=$rs[0]->fixed_public_post;
        $createdate=$rs[0]->createdate;
        $updatedate=date('Y-m-d H:i:s');
    }
	$q=null;
	if($this->uri->segment(3)=="add" && $this->uri->segment(4)!=null){
		$q = $this->uri->segment(4);
	}
?>
<style>
	.btn-upload{
		position: absolute;
  z-index: 2;
  top: 0;
  left: 0;
  opacity: 0;
  background-color: transparent;
  color: transparent;
  width: inherit;
}
	}
</style>

<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<div class="main-header row">
    <div class="col-12 col-md-6">
        <label class="title"><?=$pagename?></label>
    </div>
    <div class="col-12 col-md-6">
        <div class="controller">
            <a href="<?=base_url()?>admin2/paper" class="btn btn-custom-sm btn-bg-color">
                <i class="fas fa-undo"></i> ย้อนกลับ
            </a>
        </div>
    </div>
</div>

<div class="main-body row">
    <div class="col-md-12 ">
        <form class="custom-form" method="post" role="form" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="content_title" class="col-sm-2 col-form-label">หมายเลขเครื่อง</label>
				<div class="col-sm-10">

					<select id="select_page" name="fixed_source_id" class="operator" required>
						<option value=""> เลือกเครื่อง </option>
						<?php foreach($rsDBList as $k=>$v){?>
							<option value="<?=$v->source_id?>" <?=$q==$v->source_id?'selected':''?> <?=$fixed_source_id==$v->source_id?'selected':''?>> <?=$v->source_id?> - <?=$v->location_name?></option>
						<?php }?>
					</select>
				</div>
            </div>
			<div class="form-group row">
                <label for="content_title" class="col-sm-2 col-form-label">ประเภท</label>
				<div class="col-sm-10">
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" class="custom-control-input" id="location_status1" name="fixed_type" value="repair" <?=$fixed_type=="repair"?'checked':''?> <?=$fixed_type==''?'checked':''?>>
						<label class="custom-control-label" for="location_status1">Repair</label>
					</div>
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" class="custom-control-input" id="location_status2" name="fixed_type" value="upgrade" <?=$fixed_type=='upgrade'?'checked':''?>>
						<label class="custom-control-label" for="location_status2">Upgrade</label>
					</div>
				</div>
            </div>
			
			<div class="form-group row">
                <label for="content_title" class="col-sm-2 col-form-label">วันที่ส่งเครื่องมาซ่อม</label>
				<div class="col-sm-3">
					<input type="text" class="form-control export_date" name="fixed_come_date" value="<?=$fixed_come_date?>"/>
				</div>
				<div class="col-sm-1">
					<div style="position:relative;margin-bottom:10px;">
						<a class='btn btn-primary btn-block' href='javascript:;'>
							<i class="fa fa-upload"></i>
							<input type="file" name="fixed_come_file" class="btn-upload" name="file_source" size="40"  onchange='$("#upload-file-info-0").html($(this).val());'>
						</a>
					</div>
				</div>
				<div class="col-sm-6">
					<?php if($fixed_come_file!=null){ echo '<a class="btn btn-secondary" target="_blank" href="/uploads/docs/'.$fixed_come_file.'">';}?>
					<span class='label label-info' id="upload-file-info-0"><?=$fixed_come_file?></span>
					<?php if($fixed_come_file!=null){ echo '</a>';}?>
				</div>
            </div>
			<div class="form-group row">
                <label for="content_title" class="col-sm-2 col-form-label"></label>
				<div class="col-sm-10">
					<textarea class="form-control" rows="3" name="fixed_come_comment" placeholder="หมายเหตุถ้ามี"><?=$fixed_come_comment?></textarea>
				</div>
            </div>
			
			<div class="form-group row">
                <label for="content_title" class="col-sm-2 col-form-label">วันที่รับเครื่อง</label>
				<div class="col-sm-3">
					<input type="text" class="form-control export_date" name="fixed_get_date" value="<?=$fixed_get_date?>"/>
					
				</div>
				<div class="col-sm-1">
					<div style="position:relative;margin-bottom:10px;">
						<a class='btn btn-primary btn-block' href='javascript:;'>
							<i class="fa fa-upload"></i>
							<input type="file" name="fixed_get_file" class="btn-upload" name="file_source" size="40"  onchange='$("#upload-file-info-1").html($(this).val());'>
						</a>
					</div>
				</div>
				<div class="col-sm-6">
					<?php if($fixed_get_file!=null){ echo '<a class="btn btn-secondary" target="_blank" href="/uploads/docs/'.$fixed_get_file.'">';}?>
					<span class='label label-info' id="upload-file-info-1"><?=$fixed_get_file?></span>
					<?php if($fixed_get_file!=null){ echo '</a>';}?>
				</div>
            </div>
			<div class="form-group row">
                <label for="content_title" class="col-sm-2 col-form-label"></label>
				<div class="col-sm-10">
					<textarea class="form-control" rows="3" name="fixed_get_comment" placeholder="หมายเหตุถ้ามี"><?=$fixed_get_comment?></textarea>
				</div>
            </div>
			<div class="form-group row">
                <label for="content_title" class="col-sm-2 col-form-label">วันที่ส่งซ่อม</label>
				<div class="col-sm-3">
					<input type="text" class="form-control export_date" name="fixed_send_date" value="<?=$fixed_send_date?>"/>
				</div>
				<div class="col-sm-1">
					<div style="position:relative;margin-bottom:10px;">
						<a class='btn btn-primary btn-block' href='javascript:;'>
							<i class="fa fa-upload"></i>
							<input type="file" name="fixed_send_file" class="btn-upload" name="file_source" size="40"  onchange='$("#upload-file-info-2").html($(this).val());'>
						</a>
					</div>
				</div>
				<div class="col-sm-6">
					<?php if($fixed_send_file!=null){ echo '<a class="btn btn-secondary" target="_blank" href="/uploads/docs/'.$fixed_send_file.'">';}?>
					<span class='label label-info' id="upload-file-info-2"><?=$fixed_send_file?></span>
					<?php if($fixed_send_file!=null){ echo '</a>';}?>
				</div>
            </div>
			<div class="form-group row">
                <label for="content_title" class="col-sm-2 col-form-label"></label>
				<div class="col-sm-10">
					<textarea class="form-control" rows="3" name="fixed_send_comment" placeholder="หมายเหตุถ้ามี"><?=$fixed_send_comment?></textarea>
				</div>
            </div>
			<div class="form-group row">
                <label for="content_title" class="col-sm-2 col-form-label"></label>
				<div class="col-sm-10">
					<?php 
					$type_list = array('TIC', 'CMMC', 'Aj.Panudat', 'other');
					foreach($type_list as $k=>$item){
					?>
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="radio" name="fixed_send_type" id="inlineRadio<?=$k?>" value="<?=$item?>" <?=$fixed_send_type==$item? 'checked':''?>>
					  <label class="form-check-label" for="inlineRadio<?=$k?>"><?=$item?></label>
					</div>
					<?php }?>
				</div>
            </div>
			<div class="form-group row">
                <label for="content_title" class="col-sm-2 col-form-label">วันที่รับเครื่องหลังจากซ่อม</label>
				<div class="col-sm-3">
					<input type="text" class="form-control export_date" name="fixed_repair_date" value="<?=$fixed_repair_date?>"/>
			
				</div>
				<div class="col-sm-1">
					<div style="position:relative;margin-bottom:10px;">
						<a class='btn btn-primary btn-block' href='javascript:;'>
							<i class="fa fa-upload"></i>
							<input type="file" name="fixed_repair_file" class="btn-upload" name="file_source" size="40"  onchange='$("#upload-file-info-3").html($(this).val());'>
						</a>
					</div>
				</div>
				<div class="col-sm-6">
					<?php if($fixed_repair_file!=null){ echo '<a class="btn btn-secondary" target="_blank" href="/uploads/docs/'.$fixed_repair_file.'">';}?>
					<span class='label label-info' id="upload-file-info-3"><?=$fixed_repair_file?></span>
					<?php if($fixed_repair_file!=null){ echo '</a>';}?>
				</div>
            </div>
			<div class="form-group row">
                <label for="content_title" class="col-sm-2 col-form-label"></label>
				<div class="col-sm-10">
					<textarea class="form-control" rows="3" name="fixed_repair_comment" placeholder="หมายเหตุถ้ามี"><?=$fixed_repair_comment?></textarea>
				</div>
            </div>
			<div class="form-group row">
                <label for="content_title" class="col-sm-2 col-form-label">วันที่ส่งคืน</label>
				<div class="col-sm-3">
					<input type="text" class="form-control export_date" name="fixed_public_date" value="<?=$fixed_public_date?>"/>
				</div>
				<div class="col-sm-1">
					<div style="position:relative;margin-bottom:10px;">
						<a class='btn btn-primary btn-block' href='javascript:;'>
							<i class="fa fa-upload"></i>
							<input type="file" name="fixed_public_file" class="btn-upload" name="file_source" size="40"  onchange='$("#upload-file-info-4").html($(this).val());'>
						</a>
					</div>
				</div>
				<div class="col-sm-6">
					<?php if($fixed_public_file!=null){ echo '<a class="btn btn-secondary" target="_blank" href="/uploads/docs/'.$fixed_public_file.'">';}?>
					<span class='label label-info' id="upload-file-info-4"><?=$fixed_public_file?></span>
					<?php if($fixed_public_file!=null){ echo '</a>';}?>
				</div>
            </div>
			<div class="form-group row">
                <label for="content_title" class="col-sm-2 col-form-label"></label>
				<div class="col-sm-10">
					<textarea class="form-control" rows="3" name="fixed_public_comment" placeholder="หมายเหตุถ้ามี"><?=$fixed_public_comment?></textarea>
				</div>
            </div>
			<div class="form-group row">
                <label for="content_title" class="col-sm-2 col-form-label">รหัสไปรษณ์ย์</label>
				<div class="col-sm-3">
					<input type="text" class="form-control" name="fixed_public_post" value="<?=$fixed_public_post?>">
				</div>
            </div>

			
			<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="">สถานะการส่งซ่อม</label>
					<div class="col-sm-10">
						<?php 
						$ar_fix = array(
							'0'=> 'ไม่กำหนด',
							'1'=> 'แจ้งซ่อม',
							'2'=> 'รับเครื่อง',
							'3'=> 'ซ่อมบำรุง',
							'4'=> 'ทดสอบ',
							'5'=> 'ขนส่ง/ส่งคืน',
						);
						foreach($ar_fix as $k=>$v){
						?>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="custom-control-input sel_setup" id="fixed_status<?=$k?>" name="fixed_status" value="<?=$k?>" <?=@$fixed_status==$k?'checked':''?>>
							<label class="custom-control-label" for="fixed_status<?=$k?>"><?=$v?></label>
						</div>
						<?php }?>
					</div>
				</div>
            <hr>
            <div class="form-group row">
				<div class="col-sm-10 offset-sm-2">
					<input type="hidden" name="fixed_id" id="fixed_id" value="<?=$fixed_id?>">
					<input type="hidden" name="createdate" id="createdate" value="<?=$createdate?>">
					<input type="hidden" name="updatedate" id="updatedate" value="<?=$updatedate?>">

					<button type="submit" id="btn_submit" class="btn btn-custom btn-bg-color">บันทึก</button>
					<a href="javascript:history.back()" class="btn btn-custom btn-base-color">ยกเลิก</a>
				</div>
            </div>
        </form>
    </div>
</div>
<script>
$(document).ready(function () {
//change selectboxes to selectize mode to be searchable
   $("select").select2();
});
</script>