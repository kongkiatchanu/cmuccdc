		<?php 
		
		$timestamp =  strtotime(date('Y-m-d'))-2505600;
		$fcol=0;
		$scol=0;
		for ($i = 0 ; $i < 30 ; $i++) {
			$date_search =  date('Y-m-d', $timestamp);
			if(substr($date_search,5,2)!=date('m')){
				$fcol++;
			}else{
				$scol++;
			}
			$timestamp += 24 * 3600;
		}
		
		function getMName($m){
			$MONTH = array(1=>"มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
			return $MONTH[$m+0];
		}
		
		
		?>

		<style>
			.good{background-color: rgb(0,191,243);}
			.moderate{background-color: rgb(0,166,81);}
			.unhealthy{background-color: rgb(255, 211, 49);}
			.very-unhealthy{background-color: rgb(242,101,34);}
			.hazardous{background-color: rgb(255,0,0);}
			
			.us_bg1{background-color: rgb(0, 153, 107);}
			.us_bg2{background-color: rgb(255, 211, 49);}
			.us_bg3{background-color: rgb(0235, 132, 63);}
			.us_bg4{background-color: rgb(255, 0, 0);}
			.us_bg5{background-color: rgb(129, 21, 185);}
			.us_bg6{background-color: rgb(160, 7, 54);}
			
			.db_profile{padding:30px 0;}
			.db_table thead tr th{padding:1px;}
			.db_table tbody tr td{padding:1px;font-size:small}
		</style>
		<div class="db_profile">
			<div class="container-fluid">
				<div class="row mb3">
					<div class="col-12">
						<button class="btn btn-sm btn-secondary sw_color">TH</button>
						<button class="btn btn-sm btn-secondary sw_color">US</button>
					</div>
				</div>
				<hr/>
				<?php foreach($rsRegion as $k=>$item){?>
				<div class="row mb-3">
					<div class="col-12">
						<h4><?=$item->zone_name_th?> <a href="<?=base_url('download_dailyavg/'.$item->zone_id)?>" target="_blank" class="btn btn-sm btn-secondary sw_color"><i class="fa fa-download"></i></a></h4>
						<div class="table-responsive">
						<table class="table table-bordered db_table">
							<thead class="thead-dark text-center">
							<tr>
								
								<th rowspan="2" class="align-middle">จังหวัด</th>
								<th rowspan="2" class="align-middle">ดาวน์โหลด</th>
								<th rowspan="2" class="align-middle">จุดตรวจวัด</th>
								<?php if($fcol>0){?>
								<th colspan="<?=$fcol?>"><?=getMName(date('m')-1)?></th>
								<?php }?>
								<th colspan="<?=$scol?>"><?=getMName(date('m'))?></th>
							</tr>
							<tr>
								<?php 
								$timestamp =  strtotime(date('Y-m-d'))-2505600;
								for ($i = 0 ; $i < 30 ; $i++) {
									$date_search =  date('d', $timestamp);
									echo '<th class="text-center"><span style="font-size:small">'.$date_search.'</span></th>';
									$timestamp += 24 * 3600;
								}
								?>
							</tr>
							</thead>
							<tbody>
							<?php foreach($item->provinces as $province){?>
								<?php if($province->stations!=null){?>
								<tr>
									<td rowspan="<?=count($province->stations)+1?>" class="align-middle text-center"><?=$province->province_name_th?></td>
									<td rowspan="<?=count($province->stations)+1?>" class="align-middle text-center"><a href="<?=base_url('download_dailyavg/'.$item->zone_id.'/'.$province->province_id)?>" ><i class="fa fa-download"></i></a></td>
								</tr>
								
									<?php foreach($province->stations as $station){?>
									<tr>
										<td><?=$station->location_name?></td>
										<?php 
										$timestamp =  strtotime(date('Y-m-d'))-2505600;
										for ($i = 0 ; $i < 30 ; $i++) {
											$date_search =  date('Y-m-d', $timestamp);
											
											$ck=0;
											foreach($station->value as $row){

												if($row->daily_date==$date_search){
													$ck=1;
													$result = '<td class="text-center '.report_typePM25($row->pm25).' db_value">'.$row->pm25.'</td>';
												}
												
											}
											if($ck==1){
												echo $result;
											}else{
												echo '<td class="text-center">N/A</td>';
											}
											
											
											$timestamp += 24 * 3600;
										}
										?>
									</tr>	
									<?php }?>
								<?php }?>
							<?php }?>
							</tbody>
						</table>
						</div>
					</div>
				</div>
				<?php }?>
			</div>
		</div>

		<script>
        $( document ).ready(function() {
			function reMoveClass(){
				$('.db_value').removeClass("us_bg1");
				$('.db_value').removeClass("us_bg2");
				$('.db_value').removeClass("us_bg3");
				$('.db_value').removeClass("us_bg4");
				$('.db_value').removeClass("us_bg5");
				$('.db_value').removeClass("us_bg6");

				$('.db_value').removeClass("good");
				$('.db_value').removeClass("moderate");
				$('.db_value').removeClass("unhealthy");
				$('.db_value').removeClass("very-unhealthy");
				$('.db_value').removeClass("hazardous");					
			}
			
			function getTHClass(val){
				var txt='';
				if(val){
					if(val<=25){
						txt = 'good';
					}else if(val>25 && val<=37){
						txt = 'moderate';
					}else if(val>37 && val<=50){
						txt = 'unhealthy';
					}else if(val>50 && val<=90){
						txt = 'very-unhealthy';
					}else if(val>90 && val<=600){
						txt = 'hazardous';
					}else{
						txt = 'hazardous';
					}
				}
				return txt;
			}
			
			function getUSClass(val){
				if(val){
					if(val<=11.9){
						txt='us_bg1';
					}
					else if( (val<=35.4) && (val>11.9) ){
						txt='us_bg2';
					}
					else if( (val<=55.4) && (val>35.4) ){
						txt='us_bg3';
					}
					else if( (val<=150.4) && (val>55.4) ){
						txt='us_bg4';
					}
					else if( (val<=250.4) && (val>150.4) ){
						txt='us_bg5';
					}
					else if( (val<=350.4) && (val>250.4) ){
						txt='us_bg6';
					}
					else if( (val>350.4) ){
						txt='us_bg6';
					}
				}
				return txt;
			}
			
			$(".sw_color").on('click', function () {
				$(".sw_color").removeClass('btn btn-primary');
				$(".sw_color").addClass('btn btn-secondary');
				$(this).addClass('btn btn-primary');
				$(this).removeClass('btn btn-secondary');
				
				var html = $(this).html();
				if(html=="TH"){
					reMoveClass();

					$('.db_value').each(function() {
						$(this).addClass(getTHClass($(this).html()));
					});
				}else{
					reMoveClass();
					$('.db_value').each(function() {
						$(this).addClass(getUSClass($(this).html()));
					});
				}
				
			});
		});
		</script>
		
