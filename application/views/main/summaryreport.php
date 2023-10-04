<?php
header('Content-Type: text/html; charset=utf-8');
$months = array(1 => 'Jan.', 2 => 'Feb.', 3 => 'Mar.', 4 => 'Apr.', 5 => 'May', 6 => 'Jun.', 7 => 'Jul.', 8 => 'Aug.', 9 => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.');
$startYear = 2019;
$col = 1+(date('Y')-$startYear);
$col = (12/$col);
?>

<?php
function getColor($date,$jsonData){
	$ar_color = array('255, 255, 255','0,191,243', '0,166,81', '253,192,78', '242,101,34', '205,0,0');
	$ar_date = explode("-",$date);
	
	$y = $ar_date[0];
	$m = $ar_date[1]<10?'0'.$ar_date[1]:$ar_date[1];
	$d = $ar_date[2]<10?'0'.$ar_date[2]:$ar_date[2];
	$rsList = $jsonData;
	$rsDate = $y.'-'.$m.'-'.$d;
	$x = $d;
	$point=0;
	foreach($rsList  as $item){
		
		if($item->daily_date==$rsDate){
			$val = ceil($item->pm25);
			if(round($val)<=15){
				$point = 1;
			}else if(round($val)>15 && round($val)<=25){
				$point = 2;
			}else if(round($val)>25 && round($val)<=37){
				$point = 3;
			}else if(round($val)>37 && round($val)<=75){
				$point = 4;
			}else if(round($val)>75){
				$point = 5;
			}
			//$th_value = standard_api(ceil($data2['log_pm25']), "th_aqi");
		}
	}
	return $ar_color[$point];
}

function getColorUS($date,$jsonData){
	$ar_color = array('255, 255, 255','0, 153, 107', '253,192,78', '235, 132, 63', '205,0,0', '129, 21, 185', '160, 7, 54', '160, 7, 54');
	$ar_date = explode("-",$date);
	
	$y = $ar_date[0];
	$m = $ar_date[1]<10?'0'.$ar_date[1]:$ar_date[1];
	$d = $ar_date[2]<10?'0'.$ar_date[2]:$ar_date[2];
	$rsList = $jsonData;
	$rsDate = $y.'-'.$m.'-'.$d;
	$x = $d;
	$point=0;
	foreach($rsList  as $item){
		
		if($item->daily_date==$rsDate){
			$val = ceil($item->pm25);
			if($val<=11.9){
					$point=1;
				}
				else if( ($val<=35.4) && ($val>11.9) ){
					$point=2;
				}
				else if( ($val<=55.4) && ($val>35.4) ){
					$point=3;
				}
				else if( ($val<=150.4) && ($val>55.4) ){
					$point=4;
				}
				else if( ($val<=250.4) && ($val>150.4) ){
					$point=5;
				}
				else if( ($val<=350.4) && ($val>250.4) ){
					$point=6;
				}
				else if( ($val>350.4) ){
					$point=6;
				}
			//$th_value = standard_api(ceil($data2['log_pm25']), "th_aqi");
		}
	}
	return $ar_color[$point];
}
?>	
	<style>
	th,td{width:20px;height: 20px; text-align:center;font-size:13px;}
	.dbtable td, .dbtable th{padding:2px;border: 1px solid #dee2e6;}
	.yearcol{width: 200px;float: left;padding:0 30px;}
	.fv {
    transform: rotate(-90deg);
    white-space: nowrap;
    display: inline-block;
    font-weight: 100;
    font-size: 10px;
}
 </style>
	<div class="container">
		<div class="row mt-3 mb-3">
			<div class="col-md-6 offset-md-3">
				<select class="form-control" id="dustboy" style="width: 100%;padding: 5px;border: none;">			
										<option value=""> เลือกจุดตรวจวัด </option>
										<?php foreach($rsRegion as $item){?>
										<optgroup label="<?=$item->zone_name_th?>">
											<?php if($item->provinces!=null){?>
												<?php foreach($item->provinces as $province){?>
												<optgroup label="&nbsp;&nbsp;&nbsp;&nbsp;<?=$province->province_name_th?>">
													<?php if($province->stations!=null){?>
														<?php foreach($province->stations as $station){?>
															<option value="<?=$station->source_id?>">&nbsp;&nbsp;&nbsp;&nbsp; <?=$station->location_name?></option>
														<?php }?>
													<?php }?>
												</optgroup>
												<?php }?>
											<?php }?>
										</optgroup>
										<?php }?>
				</select>
				
				<hr/>
			</div>
		</div>
		
		
		<div class="row">
			<div class="col-md-12">
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
						<div class="tab-pane fade show active pt-3" id="th_aqi" role="tabpanel">
						
						<div class="row mb-5">
			<div class="col-md-12">
			<div class="row">
			<?php for($year=2019; $year<=date('Y'); $year++){?>
			<?php 
				$startDay = $year."-01-01";
				
			?>
			<div class="col-md-3">
				<h4 class="text-center"><?=$year?></h4><hr/>
				<div class="row">
					<div class="col-md-12">
					<?php 
						echo '<table class="table dbtable">';
						echo '<tr>';
						echo '<th>Su</th>';
						echo '<th>Mo</th>';
						echo '<th>Tu</th>';
						echo '<th>We</th>';
						echo '<th>Th</th>';
						echo '<th>Fr</th>';
						echo '<th>Sa</th>';
						echo '<th>#</th>';
						echo '</tr>';
						for($ii=1;$ii<=12;$ii++){
							$startDay = $year."-".$ii."-01";

							$timeDate = strtotime($startDay);
							$lastDay = date("t", $timeDate);
							$endDay = $year.'-'.$ii.'-'. $lastDay;
							$startPoint = date('w', $timeDate);

							$col = $startPoint;
							
							$empty=0;
							
							if($startPoint < 7){  
							 $empty++;		
							 echo str_repeat("<td> </td>", $startPoint); //สร้างคอลัมน์เปล่า กรณี วันแรกของเดือนไม่ใช่วันอาทิตย์
							}
							for($i=1; $i <= $lastDay; $i++){ //วนลูป ตั้งแต่วันที่ 1 ถึงวันสุดท้ายของเดือน
							 $col++;       //นับจำนวนคอลัมน์ เพื่อนำไปเช็กว่าครบ 7 คอลัมน์รึยัง
							echo "<td style='background-color: rgb(".getColor($year.'-'.$ii.'-'.$i,$jsonData[0]->value).");'>", $i<10?'0'.$i:$i , "</td>";  //สร้างคอลัมน์ แสดงวันที่ 
							 if($col % 7 == false){   //ถ้าครบ 7 คอลัมน์ให้ขึ้นบรรทัดใหม่
							 if($i<=7){
							  echo "<td style='background: black;color: #fff;' rowspan='".ceil(($lastDay+$startPoint)/7)."'><span class='fv'>".$months[$ii]."</span></td>";   //ปิดแถวเดิม และขึ้นแถวใหม่
							 }
							  echo "</tr><tr>";   //ปิดแถวเดิม และขึ้นแถวใหม่
							  $col = 0;     //เริ่มตัวนับคอลัมน์ใหม่
							 }
							}
							if($col>0 && $col < 7){         // ถ้ายังไม่ครบ7 วัน
							 echo str_repeat("<td></td>", 7-$col); //สร้างคอลัมน์ให้ครบตามจำนวนที่ขาด
							}
							echo '</tr>';  //ปิดแถวสุดท้าย
						}
						echo '</table>';
					?>
					</div>
					
					
					
				</div>
			</div>
			<?php }?>
		</div>
		</div>
		</div>
						
						
						</div>
                        <div class="tab-pane fade pt-3" id="us_aqi" role="tabpanel">
						
						
						<div class="row mb-5">
			<div class="col-md-12">
			<div class="row">
			<?php for($year=2019; $year<=date('Y'); $year++){?>
			<?php 
				$startDay = $year."-01-01";
				
			?>
			<div class="col-md-3">
				<h4 class="text-center"><?=$year?></h4><hr/>
				<div class="row">
					<div class="col-md-12">
					<?php 
						echo '<table class="table dbtable">';
						echo '<tr>';
						echo '<th>Su</th>';
						echo '<th>Mo</th>';
						echo '<th>Tu</th>';
						echo '<th>We</th>';
						echo '<th>Th</th>';
						echo '<th>Fr</th>';
						echo '<th>Sa</th>';
						echo '<th>#</th>';
						echo '</tr>';
						for($ii=1;$ii<=12;$ii++){
							$startDay = $year."-".$ii."-01";

							$timeDate = strtotime($startDay);
							$lastDay = date("t", $timeDate);
							$endDay = $year.'-'.$ii.'-'. $lastDay;
							$startPoint = date('w', $timeDate);

							$col = $startPoint;
							
							$empty=0;
							
							if($startPoint < 7){  
							 $empty++;		
							 echo str_repeat("<td> </td>", $startPoint); //สร้างคอลัมน์เปล่า กรณี วันแรกของเดือนไม่ใช่วันอาทิตย์
							}
							for($i=1; $i <= $lastDay; $i++){ //วนลูป ตั้งแต่วันที่ 1 ถึงวันสุดท้ายของเดือน
							 $col++;       //นับจำนวนคอลัมน์ เพื่อนำไปเช็กว่าครบ 7 คอลัมน์รึยัง
							echo "<td style='background-color: rgb(".getColorUS($year.'-'.$ii.'-'.$i,$jsonData[0]->value).");'>", $i<10?'0'.$i:$i , "</td>";  //สร้างคอลัมน์ แสดงวันที่ 
							 if($col % 7 == false){   //ถ้าครบ 7 คอลัมน์ให้ขึ้นบรรทัดใหม่
							 if($i<=7){
							  echo "<td style='background: black;color: #fff;' rowspan='".ceil(($lastDay+$startPoint)/7)."'><span class='fv'>".$months[$ii]."</span></td>";   //ปิดแถวเดิม และขึ้นแถวใหม่
							 }
							  echo "</tr><tr>";   //ปิดแถวเดิม และขึ้นแถวใหม่
							  $col = 0;     //เริ่มตัวนับคอลัมน์ใหม่
							 }
							}
							if($col>0 && $col < 7){         // ถ้ายังไม่ครบ7 วัน
							 echo str_repeat("<td></td>", 7-$col); //สร้างคอลัมน์ให้ครบตามจำนวนที่ขาด
							}
							echo '</tr>';  //ปิดแถวสุดท้าย
						}
						echo '</table>';
					?>
					</div>
					
					
					
				</div>
			</div>
			<?php }?>
		</div>
		</div>
		</div>
						
						
						
						</div>
						
					</div>
				</div>
			</div>
		</div>
		
		
		
	</div>
 <script src="<?=base_url()?>template/js/jquery/jquery.min.js"></script>
 <script>
 $( document ).ready(function() {
	  $( "#dustboy" ).change(function() {
		  window.location.href = 'https://www.cmuccdc.org/summaryreport/'+$(this).val();
		 
		});
	});
</script>