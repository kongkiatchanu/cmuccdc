
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
					<div id="accordion">
					<?php foreach($rsRegion as $k=>$item){?>
							<div class="card card-item">
								<div class="card-header" id="heading<?=$k?>">
									<div class="mb-0 card-title">
										<button class="btn btn-api btn-get" data-toggle="collapse" data-target="#collapse<?=$k?>"  aria-controls="collapse<?=$k?>"><i class="fa fa-download"></i></button>
										<p class="name"><?=$item->zone_name_th?> (<?=count($item->provinces)?>)</p>
									</div>
								</div>

								<div id="collapse<?=$k?>" class="collapse" aria-labelledby="heading<?=$k?>" data-parent="#accordion">
									<div class="card-body">
										<?php if($item->provinces!=null){?>
											<ul>
											<?php foreach($item->provinces as $province){?>
												<li class="mb-3"><strong><?=$province->province_name_th?></strong>
												<?php if($province->stations!=null){?>
													<ul>
													<?php foreach($province->stations as $station){?>
														<li>
														<div class="station_list">
														<p><?=$station->location_name?></p>
														<p>
														<a target="_blank" href="<?=base_url()?>download_json/<?=$station->source_id?>" class="btn btn-secondary btn-sm"><i class="fa fa-globe "></i> JSON</a>
														<a target="_blank" href="<?=base_url()?>download_excel/<?=$station->source_id?>" class="btn btn-success btn-sm"><i class="fa fa-download"></i> Excel</a>
														</p>
														</div>
														</li>
													<?php }?>
													</ul>
												<?php }?>
												</li>
											<?php }?>
											</ul>
										<?php }?>
									</div>
								</div>
							</div>
					<?php }?>
					</div>
				</div>
			</div>
		</div>


