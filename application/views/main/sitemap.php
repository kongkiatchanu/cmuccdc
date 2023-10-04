		<style>
		.db_profile{background-color: #fff;} /* f9f6f6 */
		.db_profile .box-content{background-color: #fff;}
		.db_profile .pv{padding-left:20px;}
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
p{margin-bottom:0px;}
.plist{margin-bottom:15px;}
		</style>
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/plugins/DataTables/datatables.min.css"/>
		<div class="db_profile">
			<div class="container">
				<div class="row box-content mb-3">
					<div class="col-lg-12 pt-3 pb-3">
						<div id="accordion">
						<?php foreach($rsRegion as $k=>$item){?>
								<div class="card card-item">
									<div class="card-header" id="heading<?=$k?>">
										<div class="mb-0 card-title">
											<button class="btn btn-api btn-get" data-toggle="collapse" data-target="#collapse<?=$k?>"  aria-controls="collapse<?=$k?>"><i class="fa fa-list"></i></button>
											<p class="name"><?=$item->zone_name_th?> (<?=count($item->provinces)?>)</p>
										</div>
									</div>

									<div id="collapse<?=$k?>" class="collapse" aria-labelledby="heading<?=$k?>" data-parent="#accordion">
										<div class="card-body">
											<?php if($item->provinces!=null){?>
												<ul>
												<?php foreach($item->provinces as $province){?>
													<li class="mb-3">
														<div class="mb-3">
															<strong>
																<?=$province->province_name_th?> 
																<?=$province->province_id==45?'<span style="color:red;font-weight: normal;">(https://chiangrai.cmuccdc.org)</span>':''?>
																<?=$province->province_id==46?'<span style="color:red;font-weight: normal;">(https://mhs.cmuccdc.org)</span>':''?>
																<?=$province->province_id==26?'<span style="color:red;font-weight: normal;">(https://acr.cmuccdc.org)</span>':''?>
																<?=$province->province_id==44?'<span style="color:red;font-weight: normal;">(https://phayao.cmuccdc.org)</span>':''?>
																<?=$province->province_id==24?'<span style="color:red;font-weight: normal;">(https://yasothon.cmuccdc.org)</span>':''?>
																<?=$province->province_id==37?'<span style="color:red;font-weight: normal;">(https://mukdahan.cmuccdc.org)</span>':''?>
																<?=$province->province_id==34?'<span style="color:red;font-weight: normal;">(https://kalasin.cmuccdc.org)</span>':''?>
																<?=$province->province_id==77?'<span style="color:red;font-weight: normal;">(https://buengkan.cmuccdc.org)</span>':''?>
															</strong>
														</div>
													<?php if($province->stations!=null){?>
														<ul>
														<?php foreach($province->stations as $station){?>
															<?php if($station->location_uri!=null  && $station->location_status==1){?>
															<li class="plist">
																<div class="station_list">
																<p><?=$station->location_name?></p>
																<p>
																	<div class="input-group">
																		<input type="text" class="form-control" id="url_<?=$station->source_id?>" value="<?=base_url($station->location_uri)?>" readonly>
																		<div class="input-group-append">
																			<button class="btn btn-outline-secondary btn-copy" data-clipboard-target="#url_<?=$station->source_id?>"type="button"><i class="far fa-copy"></i></button>
																		</div>
																	</div>
																</p>
																</div>
															</li>
															<?php }?>
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
						<?php $micro_site = json_decode(file_get_contents(base_url('assets/prophecy/micro_site.json'))); ?>
							<div class="card card-item">
								<div class="card-header" id="heading_microsite">
									<div class="mb-0 card-title">
										<button class="btn btn-api btn-get" data-toggle="collapse" data-target="#collapse_microsite"  aria-controls="collapse_microsite"><i class="fa fa-list"></i></button>
										<p class="name">เว็บย่อย (<?=count($micro_site)?>)</p>
									</div>
								</div>

								<div id="collapse_microsite" class="collapse" aria-labelledby="heading_microsite" data-parent="#accordion">
									<div class="card-body">
										<ul>
											<li class="mb-3">
												<div class="mb-3">
													<strong> เว็บย่อย </strong>
												</div>
											</li>
											<ul>
												<?php foreach($micro_site as $key=>$value){ ?>
													<li class="plist">
														<div class="station_list">
															<p><?=$value->location_name?></p>
															<p>
																<div class="input-group">
																	<input type="text" class="form-control" id="url_ms_<?=$key?>" value="<?=$value->location_uri?>" readonly>
																	<div class="input-group-append">
																		<button class="btn btn-outline-secondary btn-copy" data-clipboard-target="#url_ms_<?=$key?>"type="button"><i class="far fa-copy"></i></button>
																	</div>
																</div>
															</p>
														</div>
													</li>
												<?php } ?>
											</ul>

										</ul>
									</div>
								</div>

							</div>				
						</div>				
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="<?=base_url()?>assets/plugins/DataTables/datatables.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.4/clipboard.min.js"></script>
		<script>
        $( document ).ready(function() {
			$('.ccdc_table').DataTable({
				"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
				"pageLength": 50
			});
			
			var clipboard = new ClipboardJS('.btn-copy');
			clipboard.on('success', function(e) {
				console.info('Action:', e.action);
				console.info('Text:', e.text);
				console.info('Trigger:', e.trigger);
				alert(e.action+' : '+e.text)
				e.clearSelection();
			});
		});
		</script>
		
