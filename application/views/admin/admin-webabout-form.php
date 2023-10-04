<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/web_aboutus/" class="btn btn-info"><i class="fa fa-undo"></i> กลับ</a>
			</div>
		</div>
		<hr/>
		<div class="row">
			<div class="col-md-12">
				<form class="form-horizontal" method="post" role="form">
					<div class="form-body">
						<div class="form-group">
							<label class="col-md-2 control-label">ข้อมูลติดต่อ</label>
							<div class="col-md-10">
								<textarea class="summernote" name="site_aboutus"><?=$rs[0]->site_aboutus?></textarea>
							</div>
						</div>
					</div>	
					<div class="form-actions fluid">
						<div class="col-md-offset-2 col-md-10">
							<button type="submit" id="btn_submit" class="btn btn-primary">บันทึก</button>
							<a href="javascript:history.back()" class="btn btn-default">ยกเลิก</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


