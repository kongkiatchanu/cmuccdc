<?php
	include "connect.php";
	$data = array();
	$sql="SELECT * FROM `od_travel` WHERE `tra_year` = '".mysqli_real_escape_string($mysqli, $_GET['y'])."' order by tra_cat_id asc";
	$q=$mysqli->query($sql);
	while($rs = $q->fetch_assoc()){
		array_push($data,$rs);
	}
?>
<table class="table text-center">
		<thead>
			<tr class="table-info">
				<th rowspan="2" class="align-middle">ช่วงเวลา</th>
				<th colspan="3" class="align-middle">จำนวนนักท่องเที่ยว(คน)</th>
			</tr>
			<tr class="table-info">
				<th>ชาวไทย</th>
				<th>ชาวต่างชาติ</th>
				<th>รวม</th>
			</tr>
		</thead>
		<tbody>
		<?php for($i=0;$i<count($data);$i++){?>
			<tr>
				<td><?=$data[$i]['tra_cat_name']?> <?=($_GET['y'] + 543)?></td>
				<td><?=number_format($data[$i]['tra_amount_th'])?></td>
				<td><?=number_format($data[$i]['tra_amount_en'])?></td>
				<td><?=number_format($data[$i]['tra_amount_th']+$data[$i]['tra_amount_en'])?></td>
			</tr>
		<?php }?>
		</tbody>
	</table>