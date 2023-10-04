<?php
	include "connect.php";
	$m = array("ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
	$data1=array();
	$data2=array();
	$data3=array();
	$data4=array();
	$sql="SELECT * FROM `od_patientz` WHERE `pat_amphur_id` = ".mysqli_real_escape_string($mysqli, $_GET['m'])." AND `pat_groupdate` LIKE '%".mysqli_real_escape_string($mysqli, $_GET['y'])."%' order by `pat_groupdate` ASC ";
	$q=$mysqli->query($sql);
	while($rs=$q->fetch_assoc()){
		if($rs['pat_dis_id']==1){
			array_push($data1,$rs);
		}
		if($rs['pat_dis_id']==2){
			array_push($data2,$rs);
		}
		if($rs['pat_dis_id']==3){
			array_push($data3,$rs);
		}
		if($rs['pat_dis_id']==4){
			array_push($data4,$rs);
		}
		
	}
?>
	<table class="table text-center">
		<thead>
			<tr class="table-info">
				<th class="align-middle">เดือน</th>
				<th>โรคตา (คน)</th>
				<th>โรคทางเดินหายใจทุกชนิด (คน)</th>
				<th>โรคผิวหนังอักเสบ (คน)</th>
				<th>โรคหัวใจและหลอดเลือดทุกชนิด (คน)</th>
				<th class="align-middle">จำนวนรวม</th>
			</tr>
		</thead>
		<tbody>
			
			<?php for($i=0;$i<12;$i++){?>
			<?php 
				$sum1 += $data1[$i]['pat_male'] + $data1[$i]['pat_female'];
				$sum2 += $data2[$i]['pat_male'] + $data2[$i]['pat_female'];
				$sum3 += $data3[$i]['pat_male'] + $data3[$i]['pat_female'];
				$sum4 += $data4[$i]['pat_male'] + $data4[$i]['pat_female'];
				$total += ($data1[$i]['pat_male'] + $data1[$i]['pat_female']) + ($data2[$i]['pat_male'] + $data2[$i]['pat_female']) + ($data3[$i]['pat_male'] + $data3[$i]['pat_female']) + ($data4[$i]['pat_male'] + $data4[$i]['pat_female']);
			?>
				<tr>
					<td><?=$m[$i]?></td>
					<td><?=number_format($data1[$i]['pat_male'] + $data1[$i]['pat_female'])?></td>
					<td><?=number_format($data2[$i]['pat_male'] + $data2[$i]['pat_female'])?></td>
					<td><?=number_format($data3[$i]['pat_male'] + $data3[$i]['pat_female'])?></td>
					<td><?=number_format($data4[$i]['pat_male'] + $data4[$i]['pat_female'])?></td>
					<td><?=number_format(($data1[$i]['pat_male'] + $data1[$i]['pat_female']) + ($data2[$i]['pat_male'] + $data2[$i]['pat_female']) + ($data3[$i]['pat_male'] + $data3[$i]['pat_female']) + ($data4[$i]['pat_male'] + $data4[$i]['pat_female']))?></td>
				</tr>				
			<?php }?>
			<tr class="table-info">
				<td>รวมทั้งหมด</td>
				<td><?=number_format($sum1)?></td>
				<td><?=number_format($sum2)?></td>
				<td><?=number_format($sum3)?></td>
				<td><?=number_format($sum4)?></td>
				<td><?=number_format($total)?></td>
			</tr>		
		</tbody>
	</table>