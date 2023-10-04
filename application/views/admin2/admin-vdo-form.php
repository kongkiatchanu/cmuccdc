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


<div class="main-header row">
    <div class="col-12 col-md-6">
        <label class="title"><?=$pagename?></label>
    </div>
    <div class="col-12 col-md-6">
        <div class="controller">
            <a href="<?=base_url()?>admin2/vdo/" class="btn btn-custom-sm btn-bg-color">
                <i class="fas fa-undo"></i> ย้อนกลับ
            </a>
        </div>
    </div>
</div>
<div class="main-body row">
    <div class="col-12 col-md-10 offset-md-1">
        <form class="custom-form" method="post" role="form" id="frm_slide">
            <div class="form-group">
                <label for="yt_id">วีดีโอ ไอดี</label>
                <input type="text" class="form-control" id="yt_id" name="yt_id" required value="<?=$yt_id?>" title="วีดีโอ ไอดี is required">
            </div>
            <!-- <div class="form-group">
                <label for=""></label>
                <div id='imageloadstatus' style='display:none'><img src="<?=base_url()?>assets/img/loading.gif" alt="Uploading...."/></div>
            </div> -->
            <div class="form-group">
                <label for="yt_name">ชื่อวีดีโอ</label>
                <input type="text" class="form-control" id="yt_name" name="yt_name" required value="<?=$yt_name?>" title="ชื่อวีดีโอ is required">
            </div>
            <div class="form-group">
                <label for="location_uri">เนื้อหา</label>
                <div id="summernote"></div>
                <textarea class="summernote" name="page_description" id="yt_detail" <?=$yt_id==null?'readonly':''?>><?=$yt_detail?></textarea>
            </div>
            <div class="form-group">
                <label for=>รูปภาพ</label>
                <div id="img_preview">
                    <?=$yt_id!=null?'<img src="'.$yt_thumbnail.'" width="150"/><br/>':''?>
                </div>
            </div>
            <div class="form-group">
                <label class="d-block" for="">สถานะการแสดง</label>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="yt_status1" name="yt_status" value="1" <?=$yt_status==1?'checked':''?> <?=$yt_status==''?'checked':''?>>
                    <label class="custom-control-label" for="content_status1">แสดง</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="yt_status2" name="yt_status" value="0" <?=$yt_status==0?'checked':''?>>
                    <label class="custom-control-label" for="content_status2">ซ่อน</label>
                </div>
            </div>
            <hr>
            <div class="form-group text-right mt-3">
                <input type="hidden" name="yt_thumbnail" id="yt_thumbnail" value="<?php if(!empty($rs["video_id"])){ echo $rs["yt_thumbnail"];}?>">
                <input type="hidden" name="yt_datetime" id="yt_datetime" value="<?=$yt_datetime?>">
                <input type="hidden" name="id" id="id" value="<?=$id?>">
                <button type="submit" id="btn_submit" class="btn btn-custom btn-bg-color">บันทึก</button>
                <a href="javascript:history.back()" class="btn btn-custom btn-base-color">ยกเลิก</a>
            </div>
        </form>
    </div>
</div>