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

<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/page" class="btn btn-info"><i class="fa fa-undo"></i> กลับ</a>
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
				<form class="form-horizontal" method="post" role="form" id="<?=$idpage!=null?'frm_content_validate':'frm_page_validate'?>" enctype="multipart/form-data">
					<div class="form-body">
						
						<div class="form-group">
							<label class="col-md-2 control-label">ชื่อเรื่อง</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="page_title" id="page_title" title="ชื่อเรื่อง" required value="<?=$page_title?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">เนื้อหา</label>
							<div class="col-md-10">
								<div id="summernote"></div>
								<textarea class="summernote" name="page_description" style="display: none;"><?=$page_description?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">ยูอาร์เอล</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="page_rewrite" id="page_rewrite" title="ยูอาร์เอล" required value="<?=$page_rewrite?>">
							</div>
						</div>
						
						
						<div id="fList">
							<div class="form-group">
								<label class="control-label col-md-2">ไฟล์แนบอื่นๆ</label>
								<div class="col-md-10">
									<button type="button" id="btnAddFile" class="btn btn-primary btn-success">
										<i class="fa fa-plus"></i>
									</button>
								</div>
							</div>
						</div>
						<?php if($_rsFile!=null){?>
						<?php foreach($_rsFile as $k=>$v){?>
						<div class="container-getQuotationDetail">
							<div class="form-group">
								<div class="col-md-2"></div>
								<div class="col-md-10">
									<a href="<?=base_url()?>uploads/docs/<?=$v->file_path?>" target="_blank"><span class='label label-info' id="upload-file-info-<?=$v->file_id?>"><?=$v->file_name?></span></a> | 
									<a href="<?=base_url()?>admin/page/delfile/<?=$v->file_id?>/<?=$v->file_idpage?>" class="btn btn-danger btn-xs" onClick="return confirm('Delete Comfirm ?');"><i class="fa fa-trash-o"></i> Delete</a>
								</div>
							</div>	
						</div>
						<?php }?>
						<?php }?>

					</div>
					
					<div class="form-actions fluid">
						<div class="col-md-offset-2 col-md-10">
							<input type="hidden" name="page_create" id="page_create" value="<?=$page_create?>">
							<input type="hidden" name="idpage" id="idpage" value="<?=$idpage?>">
							<button type="submit" id="btn_submit" class="btn btn-primary">บันทึก</button>
							<a href="javascript:history.back()" class="btn btn-default">ยกเลิก</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
