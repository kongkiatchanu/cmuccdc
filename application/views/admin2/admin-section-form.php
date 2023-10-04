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

<div class="main-header row">
    <div class="col-12 col-md-6">
        <label class="title"><?=$pagename?></label>
    </div>
    <div class="col-12 col-md-6">
        <div class="controller">
            <a href="<?=base_url()?>admin2/section/1" class="btn btn-custom-sm btn-bg-color">
                <i class="fas fa-undo"></i> ย้อนกลับ
            </a>
        </div>
    </div>
</div>
<div class="main-body row">
    <div class="col-12 col-md-10 offset-md-1">
        <form class="custom-form" method="post" role="form" id="frm_content_validate">
            <div class="form-group">
                <label for="content_title">ชื่อเรื่อง</label>
                <input type="text" class="form-control" id="content_title" name="content_title" required value="<?=$content_title?>" title="ชื่อเรื่อง is required">
            </div>
            <div class="form-group">
                <label for="content_short_description">คำอธิบายสั้นๆ</label>
                <textarea class="form-control" name="content_short_description" id="content_short_description" rows="3"><?=htmlspecialchars($content_short_description)?></textarea>
            </div>
            <div class="form-group">
                <label for="content_full_description">เนื้อหา</label>
                <div id="summernote"></div>
                <textarea class="summernote" name="content_full_description" style="display: none;"><?=$content_full_description?></textarea>
            </div>
            <div class="form-group">
                <label for=>รูปภาพ</label>
                <div class="">
                    <?php if(!empty($content_thumbnail)){ ?>
                            <div id="image_cover_show">
                                <img src="<?=base_url()?>uploads/images/<?=$content_thumbnail?>" style="max-width:100%;max-height:250px;"><br/>
                                <button type="button" id="remove_image_cover" class="btn btn-default btn-sm" style="margin-top:10px;">
                                <i class="fa fa-trash-o"></i> Remove Image</button>
                            </div>
                    <?php	} ?>
                    <div id="dropzone" name="content_thumbnail" class="dropzone custom-dropzone" <?php if(!empty($content_thumbnail)){echo 'style="display:none;"';}?>></div>
                </div>
                <label class="d-block mt-2" for="">แนะนำขนาดรูปภาพไม่เกิน 800x600 pixel</label>
            </div>
       
            <div class="form-group">
                <label for="id_category">หมวดหมู่</label>
                <select class="custom-select" name="id_category" id="id_category" required title="หมวดหมู่ is required" >
                    <option value=""> - select category - </option>
                    <?php  foreach ($category as $key => $value) {?>  
                        <?php if($value->id_section==$idsection){?>
                            <option value="<?=$value->id_category?>" <?=$id_category==$value->id_category?'selected':''?>> <?=$value->category_name?> </option> 
                        <?php }?>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="content_hashtag">คำค้นหา</label>
                <input type="text" class="form-control" name="content_hashtag" id="content_hashtag" value="<?=$content_hashtag?>" title="URL">
            </div>
            <div class="form-group">
                <label class="d-block" for="">สถานะการแสดง</label>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="content_status1" name="content_status" value="1" <?=$content_status==1?'checked':''?> <?=$content_status==''?'checked':''?>>
                    <label class="custom-control-label" for="content_status1">แสดง</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="content_status2" name="content_status" value="0" <?=$content_status==0?'checked':''?>>
                    <label class="custom-control-label" for="content_status2">ซ่อน</label>
                </div>
            </div>
            <div class="form-group">
                <label for="">ตั้งเวลาแสดงเนื้อหา</label>
                <div class="input-group date form_datetime text-base-color" id="datetimepicker" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker" name="content_public" value="<?=$content_public?>"/>
                    <div class="input-group-append" data-target="#datetimepicker" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                    </div>
                </div>
            </div>
            <div id="fList">
                <div class="form-group">
                    <label for="">ไฟล์แนบอื่นๆ</label>
                    <div class="">
                        <button type="button" id="btnAddFile" class="btn btn-bg-color">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            <?php if($_rsFile!=null){?>
                <?php foreach($_rsFile as $k=>$v){?>
                    <div class="container-getQuotationDetail">
                        <div class="form-group">
                            <div class="">
                                <a href="<?=base_url()?>uploads/docs/<?=$v->file_path?>" target="_blank"><span class='label alert-base-color2' id="upload-file-info-<?=$v->file_id?>"><?=$v->file_name?></span></a> | 
                                <a href="<?=base_url()?>admin2/page/delfile/<?=$v->file_id?>/<?=$v->file_idpage?>" class="btn btn-danger btn-xs" onClick="return confirm('Delete Comfirm ?');"><i class="fa fa-trash-o"></i> Delete</a>
                            </div>
                        </div>	
                    </div>
                <?php }?>
            <?php }?>
            <hr>
            <div class="form-group text-right mt-3">
                <input type="hidden" name="h_image" id="h_image" value="<?=$content_thumbnail?>">
                <input type="hidden" name="idcontent" id="idcontent" value="<?=$idcontent?>">
                <button type="submit" id="btn_submit" class="btn btn-custom btn-bg-color">บันทึก</button>
                <a href="javascript:history.back()" class="btn btn-custom btn-base-color">ยกเลิก</a>
            </div>
        </form>
    </div>
</div>