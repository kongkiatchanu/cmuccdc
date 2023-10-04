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
			<div class="col-md-4">
				<p>snapshot default : <?=$rsSnapshot[0]->value?></p>
				<img src="http://livebox.me/dustdetect/capture/engineer_building_<?=$rsSnapshot[0]->value?>_ok.jpg" width="100%">		
			</div>
		</div>
		<hr/>
		<div class="row">
			<div class="col-md-4">
				<div class="row">
					<form class="form-inline">
						<div class="col-md-6">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
								<input type="text" id="dateStart" class="form-control snapshot_datetime">
							</div>
						</div>
						<div class="col-md-1">
							<button id="btn_query2" type="button" class="btn btn-success mb-3"><i class="fa fa-refresh"></i></button>
						</div>
					</form>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="col-md-12">
				<div id="snap_display" style="margin-top:30px;"></div>
			</div>
		</div>
	</div>
</div>


