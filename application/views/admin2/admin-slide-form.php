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

<div class="main-header row">
    <div class="col-12 col-md-6">
        <label class="title"><?=$pagename?></label>
    </div>
    <div class="col-12 col-md-6">
        <div class="controller">
            <a href="<?=base_url()?>admin2/slide/" class="btn btn-custom-sm btn-bg-color">
                <i class="fas fa-undo"></i> ย้อนกลับ
            </a>
        </div>
    </div>
</div>
<div class="main-body row">
    <div class="col-12 col-md-10 offset-md-1">
        <form class="custom-form" method="post" role="form" id="frm_slide" enctype="multipart/form-data">
            <div class="form-group">
                <label for="slide_name">ชื่อสไลด์</label>
                <input type="text" class="form-control" id="slide_name" name="slide_name" required value="<?=$slide_name?>" title="ชื่อสไลด์ is required">
            </div>
            <div class="form-group">
                <label for=>รูปภาพ</label>
                <div class="">
                    <?php if(!empty($slide_path)){ ?>
                            <div id="image_cover_show">
                                <img src="<?=base_url()?>uploads/images/<?=$slide_path?>" style="max-width:100%;max-height:250px;"><br/>
                                <button type="button" id="remove_image_cover" class="btn btn-default btn-sm" style="margin-top:10px;">
                                <i class="fa fa-trash-o"></i> Remove Image</button>
                            </div>
                    <?php	} ?>
                    <div id="dropzone" name="slide_path" class="dropzone custom-dropzone" <?php if(!empty($slide_path)){echo 'style="display:none;"';}?>></div>
                </div>
            </div>
            <div class="form-group">
                <label for="slide_link">ลิงค์เชื่อมโยง</label>
                <input type="text" class="form-control" name="slide_link" id="slide_link" required value="<?=$slide_link?>" title="ลิงค์เชื่อมโยง is required">
            </div>
            <div class="form-group">
                <label class="d-block" for="">สถานะการแสดง</label>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="location_status1" name="slide_status" value="1" <?=$slide_status==1?'checked':''?> <?=$slide_status==''?'checked':''?>>
                    <label class="custom-control-label" for="location_status1">แสดง</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="location_status2" name="slide_status" value="0" <?=$slide_status==0?'checked':''?>>
                    <label class="custom-control-label" for="location_status2">ซ่อน</label>
                </div>
            </div>
            <hr>
            <div class="form-group text-right mt-3">
                <input type="hidden" name="slide_create" id="slide_create" value="<?=$slide_create?>">
                <input type="hidden" name="slide_id" id="slide_id" value="<?=$slide_id?>">
                <input type="hidden" name="h_image" id="h_image" value="<?=$slide_path?>">
                <button type="submit" id="btn_submit" class="btn btn-custom btn-bg-color">บันทึก</button>
                <a href="javascript:history.back()" class="btn btn-custom btn-base-color">ยกเลิก</a>
            </div>
        </form>
    </div>
</div>