
<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/mkup/add" class="btn btn-info"><i class="fa fa-plus"></i> เพิ่ม</a>
			</div>
		</div>
		<hr/>
		<div class="row">
			<div class="col-md-12">
			
				<div class="table-responsive">
					<table class="table" id="sample_2">
						<thead>
							<tr style="font-weight: 500;background-color: #333;color:#fff;">
								<th>#</th>
								<th>NAME</th>
								<th>PROVINCE</th>
								<th>Status</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php $i=0;foreach ($rsList as $key => $value) {$i++;?>  
						<tr>
							<td><?=number_format($i)?></td>
							<td><?=$value->name?></td>
							<td><?=$value->pv?></td>
							<td><?=$value->is_show==1?'<span class="btn btn-success btn-xs">Show</span>':'<span class="btn btn-default btn-xs">Hide</span>'?></td>
								
							<td>
								<a href="<?=base_url()?>admin/mkup/edit/<?=$value->id?>" class="btn btn-info btn-xs">
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


