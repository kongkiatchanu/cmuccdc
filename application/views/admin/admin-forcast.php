<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<!-- <a href="<?=base_url()?>admin/landingpage/add" class="btn btn-info"><i class="fa fa-plus"></i> เพิ่ม</a> -->
			</div>
		</div>
		<hr/>
		
		<div class="row">
			<div class="col-md-12">
				<form class="form-horizontal" method="post" role="form" id="frm_slide">
					<div class="form-body">
						<div class="form-group">
							<label class="col-md-2 control-label"></label>
							<div class="col-md-10">
								<span><?=date('d/m/Y')?></span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Date Text</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="cast_datetext" required value="<?=@$rsForcast[0]->cast_datetext?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">PM 2.5</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="cast_pm25" required value="<?=@$rsForcast[0]->cast_pm25?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">PM 10</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="cast_pm10" required value="<?=@$rsForcast[0]->cast_pm10?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Temperature</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="cast_temp" required value="<?=@$rsForcast[0]->cast_temp?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Humidity</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="cast_humid" required value="<?=@$rsForcast[0]->cast_humid?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Background</label>
							<div class="col-md-10">
										<?php if(!empty(@$rsForcast[0]->cast_bg)){ ?>
												<div id="image_cover_show">
													<img src="<?=base_url()?>uploads/images/<?=@$rsForcast[0]->cast_bg?>" style="max-width:100%;max-height:250px;"><br/>
													<button type="button" id="remove_image_cover" class="btn btn-default btn-sm" style="margin-top:10px;">
													<i class="fa fa-trash-o"></i> Remove Image</button>
												</div>
										<?php	} ?>
										<div id="dropzone" name="cast_bg" class="dropzone" <?php if(!empty(@$rsForcast[0]->cast_bg)){echo 'style="display:none;"';}?>></div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Detail</label>
							<div class="col-md-10">
								<textarea type="text" class="summernote" rows="3" name="cast_detail"><?=@$rsForcast[0]->cast_detail?></textarea>
							</div>
						</div>
					</div>
					
					<div class="form-actions fluid">
						<div class="col-md-offset-2 col-md-10">
							<input type="hidden" name="cast_date" id="cast_date" value="<?=date('Y-m-d')?>">
							<input type="hidden" name="h_image" id="h_image" value="<?=@$rsForcast[0]->cast_bg?>">
							<button type="submit" id="btn_submit" class="btn btn-primary">บันทึก</button>
							<a href="javascript:history.back()" class="btn btn-default">ยกเลิก</a>
						</div>
					</div>
				</form>
		
			</div>
		</div>
		
	</div>
</div>


