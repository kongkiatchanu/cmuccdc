<?php 
    $article_id="";
    $article_title="";
    $article_author="";
    $article_keyword="";
    $article_journal="";
    $article_abstract="";
    $article_ref="";
    $article_status="";
    $article_timestamp=date('Y-m-d H:i:s');
    if($rs!=null){
        $article_id=$rs[0]->article_id;
        $article_title=$rs[0]->article_title;
        $article_author=$rs[0]->article_author;
        $article_keyword=$rs[0]->article_keyword;
        $article_journal=$rs[0]->article_journal;
        $article_abstract=$rs[0]->article_abstract;
        $article_ref=$rs[0]->article_ref;
        $article_status=$rs[0]->article_status;
        $article_timestamp=$rs[0]->article_timestamp;
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
                <label for="article_title">Title</label>
                <input type="text" class="form-control" id="article_title" name="article_title" required value="<?=$article_title?>" title="Title is required">
            </div>
            <div class="form-group">
                <label for="article_author">Author</label>
                <input type="text" class="form-control" id="article_author" name="article_author" required value="<?=$article_author?>" title="Author is required">
            </div>
            <div class="form-group">
                <label for="article_journal">Journal</label>
                <input type="text" class="form-control" id="article_journal" name="article_journal" required value="<?=$yt_name?>" title="Journal is required">
            </div>
            <div class="form-group">
                <label for="article_abstract">Abstract</label>
                <div id="summernote"></div>
                <textarea class="summernote" name="article_abstract" id="article_abstract"><?=$article_abstract?></textarea>
            </div>
            <div class="form-group">
                <label for="article_ref">Referent</label>
                <input type="text" class="form-control" id="article_ref" name="article_ref" required value="<?=$article_author?>" title="Referent is required">
            </div>
            <div class="form-group">
                <label for="article_keyword">Keyword</label>
                <input type="text" class="form-control" id="article_keyword" name="article_keyword" required value="<?=$article_author?>" title="Keyword is required">
            </div>
            <div class="form-group">
                <label class="d-block" for="">Status</label>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="article_status1" name="article_status" value="1" <?=$article_status==1?'checked':''?> <?=$article_status==''?'checked':''?>>
                    <label class="custom-control-label" for="content_status1">แสดง</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="article_status2" name="article_status" value="0" <?=$article_status==0?'checked':''?>>
                    <label class="custom-control-label" for="content_status2">ซ่อน</label>
                </div>
            </div>
            <hr>
            <div class="form-group text-right mt-3">
                <input type="hidden" name="article_timestamp" id="article_timestamp" value="<?=$article_timestamp?>">
                <input type="hidden" name="article_id" id="article_id" value="<?=$article_id?>">
                <button type="submit" id="btn_submit" class="btn btn-custom btn-bg-color">บันทึก</button>
                <a href="javascript:history.back()" class="btn btn-custom btn-base-color">ยกเลิก</a>
            </div>
        </form>
    </div>
</div>