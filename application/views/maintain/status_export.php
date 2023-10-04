<?php 
function DatediffCount($datetime){
	$earlier = new DateTime($datetime);
	$later = new DateTime(date('Y-m-d'));

	$diff = $later->diff($earlier)->format("%a");
	return $diff;
}
header("Content-type: application/vnd.ms-excel");
// header('Content-type: application/csv'); //*** CSV ***//
header("Content-Disposition: attachment; filename=dustboy_status.xls");

?>

							<table id="tblDB">
								<thead>
									<tr>
										<th>Webid</th>
										<th>Alias</th>
										<th>DustBoyName</th>
										<th>PM25</th>
										<th>Latitude </th>
										<th>Longitude</th>
										<th>Check</th>
										<th>CoName</th>
										<th>CoMobile</th>
									</tr>
								</thead>
								<tbody>
								<?php foreach($rsStatus as $item){?>
									<tr>
										<td class="text-center"><?=$item->status_source_id?></td>
										<td class="text-center"><?=$item->status_source_ids?></td>
										<td><?=$item->status_source_name?></td>
										<td class="text-center"><?=$item->status_pm25?></td>
										<td class="text-center"><?=$item->status_lat?></td>
										<td class="text-center"><?=$item->status_lnt?></td>
										<td class="text-center"><?=$item->status_date=='0000-00-00 00:00:00'? '999':DatediffCount($item->status_date)?></td>
										<td class="text-center"><?=$item->status_update?></td>
										<td class="text-center"><?=$item->status_co_name?></td>
										<td class="text-center"><?=$item->status_co_mobile?></td>
									</tr>
								<?php }?>
								</tbody>
							</table>
							
							