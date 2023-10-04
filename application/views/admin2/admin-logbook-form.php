<?php 
    $log_id=null;
    $log_webid="";
    $log_comment="";
    $log_status="";
    $log_date="";
    $log_note=""; 
    $createdate=date('Y-m-d H:i:s');


    if($rs!=null){
        $log_id=$rs[0]->log_id;
        $log_webid=$rs[0]->log_webid;
        $log_comment=$rs[0]->log_comment;
        $log_status=$rs[0]->log_status;
        $log_date=$rs[0]->log_date;
        $log_note=$rs[0]->log_note;
		
        $updatedate=date('Y-m-d H:i:s');
    }
	$q=null;
	if($this->uri->segment(3)=="add" && $this->uri->segment(4)!=null){
		$q = $this->uri->segment(4);
	}
?>

<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>


<div class="main-header row">
    <div class="col-12 col-md-6">
        <label class="title"><?=$pagename?></label>
    </div>
    <div class="col-12 col-md-6">
        <div class="controller">
            <a href="<?=base_url()?>admin2/logbook" class="btn btn-custom-sm btn-bg-color">
                <i class="fas fa-undo"></i> ย้อนกลับ
            </a>
        </div>
    </div>
</div>

<div class="main-body row">
    <div class="col-md-12 ">
		<?php if($log_webid!=null){?>
		<a class="btn btn-primary" href="<?=base_url('admin2/source/edit/'.$log_webid)?>">จุดตรวจวัด</a>
		<hr/>
		<?php }?>
        <form class="custom-form" method="post" role="form">
            <div class="form-group row">
                <label for="content_title" class="col-sm-2 col-form-label">หมายเลขเครื่อง</label>
				<div class="col-sm-10">
					<select id="select_page" name="log_webid" required>
				
						<option value=""> เลือกเครื่อง </option>
						<?php foreach($rsDBList as $k=>$v){?>
							<option value="<?=$v->source_id?>" <?=$q==$v->source_id?'selected':''?> <?=$log_webid==$v->source_id?'selected':''?>> <?=$v->source_id?> - <?=$v->location_name?></option>
						<?php }?>
					</select>
				</div>
            </div>
			<div class="form-group row">
                <label for="content_title" class="col-sm-2 col-form-label">ข้อความ</label>
				<div class="col-sm-10">
					<textarea class="form-control" rows="3" name="log_comment"><?=$log_comment?></textarea>
				</div>
            </div>
			
			<div class="form-group row">
                <label for="content_title" class="col-sm-2 col-form-label">วันที่</label>
				<div class="col-sm-3">
					<input type="text" class="form-control export_date" name="log_date" value="<?=$log_date?>"/>
				</div>
            </div>
			
			<div class="form-group row">
                <label for="content_title" class="col-sm-2 col-form-label">สถานะ</label>
				<div class="col-sm-3">
					<div class="form-check">
						<input type="hidden" name="log_status" value="0">
					  <input class="form-check-input" type="checkbox" value="1" name="log_status" id="flexCheckDefault" <?=$log_status==1?'checked':''?>>
					  <label class="form-check-label" for="flexCheckDefault">
						ดำเนินการแก้ไขแล้ว
					  </label>
					</div>
				</div>
            </div>
			
			<div class="form-group row">
                <label for="content_title" class="col-sm-2 col-form-label">ข้อความอธิบาย</label>
				<div class="col-sm-10">
					<textarea class="form-control" rows="3" name="log_note"><?=$log_note?></textarea>
				</div>
            </div>
			
			
			

            <hr>
            <div class="form-group row">
				<div class="col-sm-10 offset-sm-2">
					<input type="hidden" name="log_id" id="log_id" value="<?=$log_id?>">
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