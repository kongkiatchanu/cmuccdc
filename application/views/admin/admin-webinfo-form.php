<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/web_info/" class="btn btn-info"><i class="fa fa-undo"></i> กลับ</a>
			</div>
		</div>
		<hr/>
		<div class="row">
			<div class="col-md-12">
				<form class="form-horizontal" method="post" role="form" id="web_info">
					<div class="form-body">
						<div class="form-group">
							<label class="col-md-2 control-label">meta title</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="site_title" value="<?=$rs[0]->site_title?>">
							</div>
						</div>
					
						<div class="form-group">
							<label class="col-md-2 control-label">meta keyword</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="site_keyword" value="<?=$rs[0]->site_keyword?>" data-role="tagsinput">
							</div>
						</div>
					
						<div class="form-group">
							<label class="col-md-2 control-label">meta description</label>
							<div class="col-md-10">
								<textarea class="form-control" rows="3" name="site_description"><?=$rs[0]->site_description?></textarea>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-2 control-label">og:image</label>
							<div class="col-md-10">
								<?php if(!empty($rs[0]->site_picture)){ ?>
										<div id="image_cover_show">
											<img src="<?=base_url()?>uploads/images/<?=$rs[0]->site_picture?>" style="max-width:100%;max-height:250px;"><br/>
											<button type="button" id="remove_image_cover" class="btn btn-default btn-sm" style="margin-top:10px;">
											<i class="fa fa-trash-o"></i> Remove Image</button>
										</div>
								<?php	} ?>

								<div id="dropzone" name="site_picture" class="dropzone" <?php if(!empty($rs[0]->site_picture)){echo 'style="display:none;"';}?>></div>
							</div>
						</div>
					</div>
					
					<div class="form-actions fluid">
						<div class="col-md-offset-2 col-md-10">
							<input type="hidden" name="h_image" id="h_image" value="<?=$rs[0]->site_picture?>">
							<button type="submit" id="btn_submit" class="btn btn-primary">บันทึก</button>
							<a href="javascript:history.back()" class="btn btn-default">ยกเลิก</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


