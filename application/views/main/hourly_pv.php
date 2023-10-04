<style>#myTab .nav-link{color:#666;}#myTab .active{color:#99bf3d;}.ccdc_table thead{background-color: #0c364c;color:#fff}.dustboy_link{color: #333;}.dustboy_link:hover{color: #99bf3d;text-decoration: none;}.table thead th{vertical-align:middle;border:none}.c_value{color:#fff;border-radius:5px}.db_name{height:25px;overflow-y:hidden}.form-filler{border-top:5px solid #0c364c;padding:20px 15px;background-color:#f8f8f8}</style>
		
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/plugins/DataTables/datatables.min.css?v=signoutz2"/>
		<div class="container mb-5">
			<div class="row mt-3 mb-3">
				<div class="col-12">
				<div class="form-filler">
					<div class="form-group row">
							<label class="col-sm-2 col-form-label">เลือกตามจังหวัด :</label>
							<div class="col-sm-4 mb-2">
								<select class="form-control" id="select-hourly-filter">			
									<option value=""> เลือกจุดตรวจวัด </option>
									<?php foreach($rsRegion as $item){?>
									<optgroup label="<?=$item->zone_name_th?>">
										<?php if($item->provinces!=null){?>
											<?php foreach($item->provinces as $province){?>
											<option value="<?=$province->province_id?>"><?=$province->province_name_th?></option>
											<?php }?>
										<?php }?>
									</optgroup>
									<?php }?>
								</select>
							</div>
							<div class="col-sm-2 mb-2"><button class="btn btn-info" id="btn-hourly-filter"><i class="fa fa-filter" aria-hidden="true"></i> กรองข้อมูล</button></div>
						</div>
					</div>
				</div>
			</div>

			<div class="row mt-3 mb-3">
				<div class="col-md-12">
					<h3><?=$rsHourly->province_name?></h3>
					<p style="color:#99bf3d">อัพเดทข้อมูลเมื่อ : <?=@$rsHourly->stations[0]->log_datetime!=null ? getAVGHour($rsHourly->stations[0]->log_datetime,0):'ไม่มีข้อมูล'?></p>
					
					<div class="aqi">
                       <ul class="nav nav-tabs" id="myTab" role="tablist">
							<li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#th_aqi">TH</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#us_aqi">US</a>
                            </li>
                            
                        </ul>
						<div class="tab-content">
                            <div class="tab-pane fade pt-3" id="us_aqi" role="tabpanel">
								<div class="table-responsive">
									<table class="table table-hover ccdc_table">
										<thead class="text-center">
											<tr>
												<th width="10" class="d-none d-sm-block" style="border:none !important;">#</th>
												<th>จุดตรวจวัด</th>
												<th width="50">PM<sub>2.5</sub><br/>(μg/m<sup>3</sup>)</th>
											<!--	<th width="50">TH AQI</th>
												<th width="50">US AQI</th>-->
											</tr>
										</thead>
										<tbody>
									<?php $i=0;foreach($rsHourly->stations as $item){
										
										if($item->pm25<1000){
										
										$i++;?>
										
										<tr class="text-center">
											<td class="d-none d-sm-block"><?=$i?>.</td>
											<td class="text-left"><div class="db_namez"><a class="dustboy_link" href="<?=base_url($item->dustboy_uri)?>" target="_blank"><?=$item->dustboy_name?></a></div></td>
											<td><div class="c_value" style="background-color: rgb(<?=$item->us_color?>)"><?=$item->pm25?></div></td>
										</tr>
										<?php }}?>
										</tbody>
									</table>
								</div>
							</div>
                            <div class="tab-pane fade show active pt-3" id="th_aqi" role="tabpanel">
								<div class="table-responsive">
									<table class="table table-hover ccdc_table">
										<thead class="text-center">
											<tr>
												<th width="10" class="d-none d-sm-block" style="border:none !important;">#</th>
												<th>จุดตรวจวัด</th>
												<th width="50">PM<sub>2.5</sub><br/>(μg/m<sup>3</sup>)</th>
											<!--	<th width="50">TH AQI</th>
												<th width="50">US AQI</th>-->
											</tr>
										</thead>
										<tbody>
									<?php $i=0;foreach($rsHourly->stations as $item){
										if($item->pm25<1000){
										
										$i++;?>
										<tr class="text-center">
											<td class="d-none d-sm-block"><?=$i?>.</td>
											<td class="text-left"><div class="db_namez"><a class="dustboy_link" href="<?=base_url($item->dustboy_uri)?>" target="_blank"><?=$item->dustboy_name?></a></div></td>
											<td><div class="c_value" style="background-color: rgb(<?=$item->th_color?>)"><?=$item->pm25?></div></td>
										</tr>
										<?php }}?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
                   </div>
				   
				   
					
				</div>
				
			</div>
		</div>
		<script type="text/javascript" src="<?=base_url()?>assets/plugins/DataTables/datatables.min.js?v=signoutz2"></script>
		<script>
		$(document).ready(function() {
			$('.ccdc_table').DataTable({
				"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
				"pageLength": 50
			});
		} );
		</script>
		
