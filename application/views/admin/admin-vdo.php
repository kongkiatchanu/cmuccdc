<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/vdo/add" class="btn btn-info"><i class="fa fa-plus"></i> เพิ่มวีดีโอ</a>
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
								<th>ไอดี</th>
								<th>ชื่อวีดีโอ</th>
								<th>สถานะ</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php $i=0;foreach ($rsList as $key => $value) {$i++;?>  
						<tr>
							<td><?=number_format($i)?></td>
							<td><?=$value->yt_id?></td>
							<td><?=$value->yt_name?></td>
							<td><?=$value->yt_status==1?'<span class="btn btn-success btn-xs">แสดง</span>':'<span class="btn btn-default btn-xs">ซ่อน</span>'?></td>
								
							<td>
								<a href="<?=base_url()?>admin/vdo/edit/<?=$value->id?>" class="btn btn-info btn-xs">
									<i class="fa fa-edit"></i>	
									แก้ไข
								</a>

								<a href="<?=base_url()?>admin/vdo/del/<?=$value->id?>" class="btn btn-danger btn-xs" onclick="return confirm('คุณต้องการลบใช่หรือไม่');">
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


