
		<style>
			.sec{margin-bottom:50px;}
	.card-item{
		border: 1px solid #9dc03b;
		box-shadow: 0 0 2px rgba(0,0,0,.1);
		margin-bottom: 12px;
	}	
	.card-header{background-color: #9dc03b26;
		border-bottom: 0;
		border-radius: 3px;
		height: 48px;
		padding: 8px 20px;
		cursor: pointer;
	}
	.card-title {
		display: inline-flex;
	}
	.btn-get {
    color: #fff;
    background-color: #9dc03b;
    border-color: #9dc03b;
    width: 80px;
}
.btn-api {
    border-radius: 4px;
    cursor: pointer;
    height: 32px;
    line-height: 0;
    min-width: 80px;
    padding: 6px 16px;
    font-weight: 700;
}
.card-title .name {
    color: #383b39;
    margin-left: 16px;
    margin-bottom: 0;
    padding-top: 6px;
    padding-bottom: 6px;
        font-weight: bold;
}

strong{font-size: 18px;}
.close{ 
	float: unset;
	font-size: unset;
	font-weight:unset;
	line-height:unset;
	color: #000;unset;
	text-shadow:unset;
	opacity: unset;
}
		</style>

		<div class="container mt-5 mb-5" style="background-color: #fff;border: 1px solid #d6d6d6;">
			<div class="row pt-3 pb-3">
				<div class="col-lg-12">
					<table class="table table-striped">	
						<thead>
							<tr>
								<th>Webid</th>
								<th>Stations</th>
								<th style="width:165px;">Download</th>
							</th>
						</thead>
						<tbody>
					<?php foreach($rsRegion as $k=>$item){?>
							<?php if($item->provinces!=null){?>
							<?php foreach($item->provinces as $province){?>
													<?php foreach($province->stations as $station){?>
														<tr>
														<td><?=$station->source_id?></td>
														<td><?=$station->location_name?></td>
														<td>
														<a target="_blank" href="<?=base_url()?>download_temp/<?=$station->source_id?>/excel" class="btn btn-success btn-sm"><i class="fa fa-globe "></i> Excel</a>
														<a target="_blank" href="<?=base_url()?>download_temp/<?=$station->source_id?>/json" class="btn btn-secondary btn-sm"><i class="fa fa-globe "></i> JSON</a>
														
														</td>
														
														</tr>
													<?php }?>
													<?php }?>
													<?php }?>
													
					<?php }?>
					</tbody>
					</table>
				</div>
			</div>
		</div>


