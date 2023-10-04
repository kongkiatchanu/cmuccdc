
<?php 
echo '<pre>';
print_r($rsDustboy);
echo '</pre>';

?>

					<table class="table table-striped">	
						<thead>
							<tr>
								<th>pm10</th>
								<th>pm2.5</th>
								<th>temp</th>
								<th>humid</th>
								<th>timestamp</th>
							</th>
						</thead>
						<tbody>
						<?php foreach($rsDustboy[0]->value as $k=>$item){?>
						
							<tr>
								<td><?=$item->pm10?></td>
								<td><?=$item->pm25?></td>
								<td><?=$item->temp?></td>
								<td><?=$item->humid?></td>
								<td><?=$item->log_datetime?></td>						
							</tr>
													
						<?php }?>
					</tbody>
					</table>
				
