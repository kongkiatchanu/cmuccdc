<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/product/add" class="btn btn-info"><i class="fa fa-plus"></i> Add product</a>
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
								<th>ชื่อสินค้า</th>
								<th>สถานะ</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php $i=0;foreach ($rsList as $key => $value) {$i++;?>  
						<tr>
							<td><?=number_format($i)?></td>
							<td><?=$value->product_name?></td>
							<td><?=$value->product_status==1?'<span class="btn btn-success btn-xs">show</span>':'<span class="btn btn-default btn-xs">hide</span>'?></td>
							<td>
								<a href="<?=base_url()?>admin/product/edit/<?=$value->product_id?>" class="btn btn-info btn-xs">
									<i class="fa fa-edit"></i>	
									แก้ไข
								</a>

								<a href="<?=base_url()?>admin/product/del/<?=$value->product_id?>" class="btn btn-danger btn-xs" onclick="return confirm('คุณต้องการลบใช่หรือไม่');">
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


