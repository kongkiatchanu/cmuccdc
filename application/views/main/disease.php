		
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/plugins/DataTables/datatables.min.css"/>
		
		<div class="container mb-5">
			
			
			<div class="row mt-3 mb-3">
				<div class="col-md-12">
					<h3>ตารางแสดงสถานบริการที่ส่งข้อมูลเข้า API Center จำแนกตามเดือน ปี 2020</h3>
					<hr/>

					<?php 
						echo '<pre>';
						print_r($rsStore);
						echo '<pre>';
					?>
			<!--
					<table id="" class="table table-bordered ccdc_table">
						<thead class="text-center">
							<tr>
								<th rowspan="2">Hcode</th>
								<th rowspan="2">สถานบริการ</th>
								<th colspan="12">เดือน</th>
							</tr>
							<tr>
								<?php for($i=1; $i<=12; $i++){?>
									<th><?php echo $i;?></th>
								<?php }?>
							</tr>
						</thead>
						<tbody>
						<?php foreach(getHospital() as $k=>$item){?>
						<tr>
							<td class="text-center"><?php echo $k;?></td>
							<td><?php echo $item;?></td>
							<?php for($i=1; $i<=12; $i++){?>
									<td class="text-center"><?php echo $i;?></td>
							<?php }?>
						</tr>
						<?php }?>
						</tbody>
					</table>
					-->
				</div>
				
			</div>
		</div>
		<script type="text/javascript" src="<?=base_url()?>assets/plugins/DataTables/datatables.min.js?v=signoutz"></script>
		<script>
		$(document).ready(function() {
			$('.ccdc_table').DataTable({
				"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
				"pageLength": 10
			});
		});
		</script>
		
