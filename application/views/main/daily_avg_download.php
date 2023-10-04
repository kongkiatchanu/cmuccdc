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
		
		function getBGColor($txt){
			$result='';
			if($txt=="good"){
				$result='background-color: rgb(0,191,243);';
			}else if($txt=="moderate"){
				$result='background-color: rgb(0,166,81);';
			}else if($txt=="unhealthy"){
				$result='background-color: rgb(255, 211, 49);';
			}else if($txt=="very-unhealthy"){
				$result='background-color: rgb(242,101,34);';
			}else if($txt=="hazardous"){
				$result='background-color: rgb(255,0,0);';
			}
			return $result;
		}
		
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=\"".basename("dailyavg-".date('Y-m-d').".xls")."\"");
		header("Pragma: no-cache");
		header("Expires: 0");
		?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
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
			.db_table tbody tr td{padding:1px;font-size:small;}
		</style>

		<?php foreach($rsRegion as $k=>$item){?>
			<?php if($item->zone_id==$zones_id){?>
				<?php foreach($item->provinces as $province){?>
					<?php if($province->province_id==$province_id){?>
						<h4>รายงานค่าฝุ่น PM2.5 เฉลี่ยรายวัน (ไมโครกรัมต่อลูกบาศก์เมตร) จังหวัด<?=$province->province_name_th?></h4>
						<table class="table table-bordered db_table">
							<thead class="thead-dark text-center">
							<tr style="background-color:#333;color:#fff;">
								<th rowspan="2" class="align-middle" width="400">จุดตรวจวัด</th>
								<?php if($fcol>0){?>
								<th colspan="<?=$fcol?>"><?=getMName(date('m')-1)?></th>
								<?php }?>
								<th colspan="<?=$scol?>"><?=getMName(date('m'))?></th>
							</tr>
							<tr style="background-color:#333;color:#fff;">
								<?php 
								$timestamp =  strtotime(date('Y-m-d'))-2505600;
								for ($i = 0 ; $i < 30 ; $i++) {
									$date_search =  date('d', $timestamp);
									echo '<th tyle="background-color:#333;color:#fff;" class="text-center"><span style="font-size:small">'.$date_search.'</span></th>';
									$timestamp += 24 * 3600;
								}
								?>
							</tr>
							</thead>
							<tbody>
				
							<?php foreach($item->provinces as $province){?>
								<?php if($province->stations!=null){?>
								<?php if($province->province_id==$province_id){?>

								
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
													$result = '<td style="text-align:center;'.getBGColor(report_typePM25($row->pm25)).'" class="text-center db_value">'.$row->pm25.'</td>';
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
							<?php }?>
							
							
							
							
							</tbody>
						</table>
					<?php }?>
				<?php }?>
			<?php }?>
		<?php }?>
	</body>
</html>

