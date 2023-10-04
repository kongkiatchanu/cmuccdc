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



<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/research/" class="btn btn-info"><i class="fa fa-undo"></i> กลับ</a>
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
							<label class="col-md-2 control-label">Title</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="article_title" id="article_title" title="title" required value="<?=$article_title?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Author</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="article_author" id="article_author" title="title" required value="<?=$article_author?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Journal</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="article_journal" id="article_journal" title="Journal" required value="<?=$article_journal?>">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-2 control-label">Abstract</label>
							<div class="col-md-10">
								<textarea class="summernote" name="article_abstract" id="article_abstract" title="Abstract"><?=$article_abstract?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Referent</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="article_ref" id="article_ref" title="Referent" required value="<?=$article_ref?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Keyword</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="article_keyword" id="article_keyword" title="Keyword" required value="<?=$article_keyword?>" data-role="tagsinput">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Status</label>
							<div class="col-md-10">
								<div class="radio-list">
									<label class="radio-inline">
									<input type="radio" name="article_status" value="1" <?=$article_status==1?'checked':''?> <?=$article_status==''?'checked':''?>> Show </label>
									<label class="radio-inline">
									<input type="radio" name="article_status" value="0" <?=$article_status==0?'checked':''?> > Hide </label>	
								</div>
							</div>
						</div>
						
					</div>
					
					<div class="form-actions fluid">
						<div class="col-md-offset-2 col-md-10">
						
							<input type="hidden" name="article_timestamp" id="article_timestamp" value="<?=$article_timestamp?>">
							<input type="hidden" name="article_id" id="article_id" value="<?=$article_id?>">
							<button type="submit" id="btn_submit" class="btn btn-primary">บันทึก</button>
							<a href="javascript:history.back()" class="btn btn-default">ยกเลิก</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


