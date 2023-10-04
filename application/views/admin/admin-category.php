<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/category/add" class="btn btn-info"><i class="fa fa-plus"></i> เพิ่มหมวดหมู่</a>
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
								<th>หมวดหมู่</th>
								<th>หมวดย่อย</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php $i=0;foreach ($category as $key => $value) {$i++;?>  
						
							<tr>
								<td><?=number_format($i)?></td>
								<?php if($value->parent!=null){?>
									<td>-</td>
									<td><?=$value->category_name?></td>
								<?php }else{?>
									<td><?=$value->category_name?></td>
									<td><?=$value->parent?></td>
								<?php }?>
								
								<td>
									<a href="<?=base_url()?>admin/category/edit/<?=$value->id_category?>" class="btn btn-info btn-xs">
										<i class="fa fa-edit"></i>	
										แก้ไข
									</a>

									<a href="<?=base_url()?>admin/category/del/<?=$value->id_category?>" class="btn btn-danger btn-xs" onclick="return confirm('คุณต้องการลบใช่หรือไม่');">
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


