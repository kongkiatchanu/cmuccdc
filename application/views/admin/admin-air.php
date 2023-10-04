<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<!--<a href="<?=base_url()?>admin/vdo/add" class="btn btn-info"><i class="fa fa-plus"></i> เพิ่มวีดีโอ</a>-->
			</div>
		</div>
		<hr/>
		<div class="row">
			<div class="col-md-12">
			
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr style="font-weight: 500;background-color: #333;color:#fff;">
								<th>#</th>
								<th>Name</th>
								<th>Detail</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php $i=0;foreach ($rsList as $key => $value) {$i++;?>  
						<tr>
							<td><?=number_format($i)?></td>
							<td><?=$value->air_name?></td>
							<td><?=$value->air_detail?></td>	
							<td>
								<a href="<?=base_url()?>admin/airdetail/edit/<?=$value->air_id?>" class="btn btn-info btn-xs">
									<i class="fa fa-edit"></i>	
									แก้ไข
								</a>
							</td>
						</tr>
						<?php }?>
						</tbody>
					</table>
				</div>
			
			</div>
		</div>
	</div>
</div>


