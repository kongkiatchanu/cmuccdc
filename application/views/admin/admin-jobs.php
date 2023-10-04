<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/jobs/add" class="btn btn-info"><i class="fa fa-plus"></i> เพิ่มประกาศ</a>
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
								<th>ชื่อประกาศ</th>
								<th>บริษัท</th>
								<th>แนะนำ</th>
								<th>สถานะ</th>
								<th>วันที่ประกาศ</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php $i=0;foreach ($rsList as $key => $value) {$i++;?>  
						<tr>
							<td><?=number_format($i)?></td>
							<td><?=$value->job_name?></td>
							<td><?=$value->company_name?></td>
							<td><?=$value->job_rec==1?'<i class="fa fa-check"></i>':'<i class="fa fa-times"></i>'?></td>
							<td><?=$value->job_status==1?'<i class="fa fa-check"></i>':'<i class="fa fa-times"></i>'?></td>
							<td><?=$value->job_createdate?></td>
								
							<td>
								<a href="<?=base_url()?>admin/jobs/edit/<?=$value->job_id?>" class="btn btn-info btn-xs">
									<i class="fa fa-edit"></i>	
									แก้ไข
								</a>

								<a href="<?=base_url()?>admin/jobs/del/<?=$value->job_id?>" class="btn btn-danger btn-xs" onclick="return confirm('คุณต้องการลบใช่หรือไม่');">
									<i class="fa fa-trash"></i>	
									ลบ
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


