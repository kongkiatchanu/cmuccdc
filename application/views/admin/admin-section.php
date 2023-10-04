<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/section/1/add" class="btn btn-info"><i class="fa fa-plus"></i> เพิ่มข่าวสาร</a>
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
								<th>ชื่อเรื่อง</th>
								<th>หมวดหมู่</th>
								<th>วันที่</th>
								<th>สร้างโดย</th>
								<th>สถานะแสดง</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php $i=0;foreach ($clist as $key => $value) {$i++;?>  
						<tr>
							<td><?=number_format($i)?></td>
							<td><?=$value->content_title?></td>
							<td><?=$value->category_name?></td>
							<td><?=$value->content_created?></td>
							<td><?=$value->content_author?></td>
							<td><?=$value->content_status==1?'<span class="btn btn-success btn-xs">แสดง</span>':'<span class="btn btn-default btn-xs">ซ่อน</span>'?></td>
							<td>
								<a href="<?=base_url()?>admin/section/<?=$idsection?>/edit/<?=$value->idcontent?>" class="btn btn-info btn-xs">
									<i class="fa fa-edit"></i>	
									แก้ไข
								</a>

								<a href="<?=base_url()?>admin/section/<?=$idsection?>/del/<?=$value->idcontent?>" class="btn btn-danger btn-xs" onclick="return confirm('คุณต้องการลบใช่หรือไม่');">
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


