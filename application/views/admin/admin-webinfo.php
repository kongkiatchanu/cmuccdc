<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/web_info/edit" class="btn btn-info"><i class="fa fa-edit"></i> แก้ไขข้อมูล</a>
			</div>
		</div>
		<hr/>
		<div class="row">
			<div class="col-md-12">
				<form class="form-horizontal" method="post" role="form" id="web_info">
					<div class="form-body">
						<div class="form-group">
							<label class="col-md-4 control-label">meta title</label>
							<div class="col-md-8">
								<div style="padding: 7px 0;"><?=$rs[0]->site_title?></div>
							</div>
						</div>
					
						<div class="form-group">
							<label class="col-md-4 control-label">meta keyword</label>
							<div class="col-md-8">
								<div style="padding: 7px 0;"><?=$rs[0]->site_keyword?></div>
							</div>
						</div>
					
						<div class="form-group">
							<label class="col-md-4 control-label">meta description</label>
							<div class="col-md-8">
								<div style="padding: 7px 0;"><?=$rs[0]->site_description?></div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-4 control-label">og:image</label>
							<div class="col-md-8">
								<div style="padding: 7px 0;"><img src="<?=base_url()?>uploads/images/<?=$rs[0]->site_picture?>" style="max-width:100%;max-height:250px;"></div>
							</div>
						</div>
					</div>
				</form>

			
			</div>
		</div>
	</div>
</div>


