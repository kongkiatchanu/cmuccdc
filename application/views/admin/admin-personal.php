<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/personal/add" class="btn btn-info"><i class="fa fa-plus"></i> เพิ่มบุคลากร</a>
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
								<th>ชื่อ - สกุล</th>
								<th>ส่วนราชการ</th>
                                <th>ตำแหน่ง</th>
                                <th>สถานะ</th>
								<th>ลำดับ</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php $i=0; foreach ($rsList as $key => $value) { $i++; ?>  
							<tr>
								<td><?=$i?></td>
                                <td><?=$value->personal_name?></td>
                                <td><?=$value->type_name?></td>
                                <td><?=$value->personal_position?></td>
                                <td><?=$value->personal_status==1?'<span class="btn btn-success btn-xs">แสดง</span>':'<span class="btn btn-default btn-xs">ซ่อน</span>'?></td>
								<td><?=$value->personal_qno?></td>
								<td>
									<a href="<?=base_url()?>admin/personal/edit/<?=$value->personal_id?>" class="btn btn-info btn-xs">
										<i class="fa fa-edit"></i>	
										แก้ไข
									</a>
									<?php if($value->personal_id>52){?>
									<a href="<?=base_url()?>admin/personal/del/<?=$value->personal_id?>" class="btn btn-danger btn-xs" onclick="return confirm('คุณต้องการลบใช่หรือไม่');">
										<i class="fa fa-trash"></i>	
										ลบ
									</a>	
									<?php }?>

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


