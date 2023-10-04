<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
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
								<th>หัวข้อ</th>
								<th>ผู้ติดต่อ</th>
								<th>วันที่ เวลา</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php $i=0; foreach ($rsList as $key => $value) { $i++; ?>  
						<?php 
							$bg='';
							if($value->contact_view==0){
								$bg='style="font-weight: 500;background-color: #d8d8d8;"';
							}
						?>
							<tr <?=$bg?>>
								<td><?=$i?></td>
								<td><?=$value->contact_subject?></td>
								<td><?=$value->contact_name?></td>
								<td><?=$value->contact_datetime?></td>
								<td>
									<a href="<?=base_url()?>admin/contact/view/<?=$value->idcontact?>" class="btn btn-info btn-xs">
										<i class="fa fa-eye"></i>	
										ดูรายละเอียด
									</a>

									<a href="<?=base_url()?>admin/contact/del/<?=$value->idcontact?>" class="btn btn-danger btn-xs" onclick="return confirm('คุณต้องการลบใช่หรือไม่');">
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


