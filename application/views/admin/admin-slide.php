<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/slide/add" class="btn btn-info"><i class="fa fa-plus"></i> เพิ่มสไลด์</a>
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
								<th></th>
								<th>ชื่อสไลด์</th>
								<th>สถานะการแสดง</th>
								<th>วันที่สร้าง</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php $i=0; foreach ($rsList as $key => $value) { $i++; ?>  
							<tr>
								<td><?=$i?></td>
								<td><img src="<?=base_url().'uploads/images/'.$value->slide_path?>" width="300"></td>
								<td><?=$value->slide_name?></td>
								<td><?=$value->slide_status==1?'<span class="btn btn-success btn-xs">แสดง</span>':'<span class="btn btn-default btn-xs">ซ่อน</span>'?></td>
								<td><?=$value->slide_create?></td>
								<td>
									<a href="<?=base_url()?>admin/slide/edit/<?=$value->slide_id?>" class="btn btn-info btn-xs">
										<i class="fa fa-edit"></i>	
										แก้ไข
									</a>

									<a href="<?=base_url()?>admin/slide/del/<?=$value->slide_id?>" class="btn btn-danger btn-xs" onclick="return confirm('คุณต้องการลบใช่หรือไม่');">
										<i class="fa fa-trash"></i>	
										ลบ
									</a>	

								</td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
			
			</div>
		</div>
	</div>
</div>


