<?php 
    $idpage="";
    $page_title="";
    $page_rewrite="";
    $page_description="";
    $page_create=date('Y-m-d H:i:s');
    if($rs!=null){
        $idpage=$rs[0]->idpage;
        $page_title=$rs[0]->page_title;
        $page_rewrite=$rs[0]->page_rewrite;
        $page_description=$rs[0]->page_description;
        $page_create=$rs[0]->page_create;
    }
?>


<div class="main-header row">
    <div class="col-12 col-md-6">
        <label class="title"><?=$pagename?></label>
    </div>
    <div class="col-12 col-md-6">
        <div class="controller">
            <a href="<?=base_url()?>admin2/page/" class="btn btn-custom-sm btn-bg-color">
                <i class="fas fa-undo"></i> ย้อนกลับ
            </a>
        </div>
    </div>
</div>
<div class="main-body row">
    <div class="col-12 col-md-10 offset-md-1">
        <form class="custom-form" method="post" role="form" id="<?=$idpage!=null?'frm_content_validate':'frm_page_validate'?>">
            <div class="form-group">
                <label for="page_title">ชื่อเรื่อง</label>
                <input type="text" class="form-control" id="page_title" name="page_title" required value="<?=$page_title?>" title="ชื่อเรื่อง is required">
            </div>
            <div class="form-group">
                <label for="location_uri">เนื้อหา</label>
                <div id="summernote"></div>
                <textarea class="summernote" name="page_description" style="display: none;"><?=$page_description?></textarea>
            </div>
            <div class="form-group">
                <label for="page_rewrite">ยูอาร์เอล</label>
                <input type="text" class="form-control" id="page_rewrite" name="page_rewrite" required value="<?=$page_rewrite?>" title="ยูอาร์เอล is required">
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
                <input type="hidden" name="page_create" id="page_create" value="<?=$page_create?>">
                <input type="hidden" name="idpage" id="idpage" value="<?=$idpage?>">
                <button type="submit" id="btn_submit" class="btn btn-custom btn-bg-color">บันทึก</button>
                <a href="javascript:history.back()" class="btn btn-custom btn-base-color">ยกเลิก</a>
            </div>
        </form>
    </div>
</div>