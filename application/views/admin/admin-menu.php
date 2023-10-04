<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/menu/add" class="btn btn-info"><i class="fa fa-plus"></i> เพิ่มเมนู</a>
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
								<th>ชื่อเมนู</th>
								<th>ซับเมนู</th>
								<th>ลิงค์เชื่อมโมง</th>
								<th>หน้าแสดงผล</th>
								<th>เรียงลำดับ</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php $i=0; foreach ($rs_menuf as $key => $value) { $i++; ?>  
							<tr>
								<td><?=number_format($i)?></td>
								<td><?=$value["menu_label"]?></td>
								<td>-</td>
								<td><?=$value["menu_link"]!=""? $value["menu_link"] :'-'?></td>
								<td><?=$value["idpage"]!=""? "[".$value["idpage"]."]".$value["page_title"]:'-'?></td>
								<td><?=$value["menu_order"]?></td>
								<td>
									<a href="<?=base_url()?>admin/menu/edit/<?=$value["idmenu"]?>" class="btn btn-info btn-xs">
										<i class="fa fa-edit"></i>	
										แก้ไข
									</a>

									<a href="<?=base_url()?>admin/menu/del/<?=$value["idmenu"]?>" class="btn btn-danger btn-xs" onclick="return confirm('คุณต้องการลบใช่หรือไม่');">
										<i class="fa fa-trash"></i>	
										ลบ
									</a>	
								</td>
							</tr>
							<?php foreach ($value["subMenu"] as $key => $subValue) { ?>
								<tr>
									<td><?=number_format($i)?></td>
									<td>-</td>
									<td><?=$subValue["menu_label"]?></td>
									<td><?=$subValue["menu_link"]!=""? $subValue["menu_link"] :'-'?></td>
									<td><?=$subValue["idpage"]!=""? "[".$subValue["idpage"]."]".$subValue["page_title"]:'-'?></td>
									<td><?=$subValue["menu_order"]?></td>
									<td>
										<a href="<?=base_url()?>admin/menu/edit/<?=$subValue["idmenu"]?>" class="btn btn-info btn-xs">
											<i class="fa fa-edit"></i>	
											แก้ไข
										</a>

										<a href="<?=base_url()?>admin/menu/del/<?=$subValue["idmenu"]?>" class="btn btn-danger btn-xs" onclick="return confirm('คุณต้องการลบใช่หรือไม่');">
											<i class="fa fa-trash"></i>	
											ลบ
										</a>	
									</td>
								</tr>			
							<?php }?>
						<?php }?>
						</tbody>
					</table>
				</div>
			
			</div>
		</div>
	</div>
</div>

