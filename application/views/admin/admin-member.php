<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<!-- <a href="<?=base_url()?>admin/landingpage/add" class="btn btn-info"><i class="fa fa-plus"></i> เพิ่ม</a> -->
			</div>
		</div>
		<hr/>
		<div class="row">
			<div class="col-md-12">

				<div class="table-responsive">
					<table class="table" id="sample_3">
						<thead>
							<tr style="font-weight: 500;background-color: #333;color:#fff;">
								<th>ชื่อ - นามสกุล</th>
								<th>หน่วยงาน</th>
								<th>ยืนยันอีเมล์</th>
								<th>อนุมัติ</th>
								<th>OpenData</th>
								<th>วันที่สมัคร</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php $i=0;foreach ($rsList as $key => $value) {$i++;?>  
						
							<tr>
								<td><?=$value->member_name?></td>
								<td><?=$value->member_org?></td>
								<td id="member_status[<?php echo $value->member_id; ?>]">
									<?php 
										if($value->member_verify_status==0){
											$txt = 'รอการยืนยัน';
											$theme = 'default';
										}else if($value->member_verify_status==1){
											$txt = 'ยืนยันอีเมล์แล้ว';
											$theme = 'green';
										}
									
									?>
									<div class="btn-group">
										<button type="button" class="btn <?=$theme?> btn-xs"><?=$txt?></button>
										<button type="button" class="btn <?=$theme?> btn-xs dropdown-toggle" data-toggle="dropdown"><i class="fa fa-angle-down"></i></button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a href="#<?=$value->member_id?>" class="btn_update_member_status_on">ยืนยันอีเมล์แล้ว</a>
											</li>

										</ul>
									</div>
								</td>
								<td id="member_status2[<?php echo $value->member_id; ?>]">
									<?php 
										if($value->member_status==0){
											$txt = 'รอการอนุมัติ';
											$theme = 'default';
										}else if($value->member_status==1){
											$txt = 'อนุมัติการใช้งาน';
											$theme = 'green';
										}else if($value->member_status==-1){
											$txt = 'ระงับการใช้งาน';
											$theme = 'red';
										}
									
									?>
									<div class="btn-group">
										<button type="button" class="btn <?=$theme?> btn-xs"><?=$txt?></button>
										<button type="button" class="btn <?=$theme?> btn-xs dropdown-toggle" data-toggle="dropdown"><i class="fa fa-angle-down"></i></button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a href="#<?=$value->member_id?>" class="member_status_on">อนุมัติการใช้งาน</a>
											</li>
											<li>
												<a href="#<?=$value->member_id?>" class="member_status_off">ระงับการใช้งาน</a>
											</li>
											
										</ul>
									</div>
								</td>
								<td id="member_status3[<?php echo $value->member_id; ?>]">
									<?php 
										if($value->member_od==0){
											$txt = 'รอการอนุมัติ';
											$theme = 'default';
										}else if($value->member_od==1){
											$txt = 'อนุมัติการใช้งาน';
											$theme = 'green';
										}else if($value->member_od==-1){
											$txt = 'ระงับการใช้งาน';
											$theme = 'red';
										}
									
									?>
									<div class="btn-group">
										<button type="button" class="btn <?=$theme?> btn-xs"><?=$txt?></button>
										<button type="button" class="btn <?=$theme?> btn-xs dropdown-toggle" data-toggle="dropdown"><i class="fa fa-angle-down"></i></button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a href="#<?=$value->member_id?>" class="member_status_od_on">อนุมัติการใช้งาน</a>
											</li>
											<li>
												<a href="#<?=$value->member_id?>" class="member_status_od_off">ระงับการใช้งาน</a>
											</li>
											
										</ul>
									</div>
								</td>
								<td><?=ConvertToThaiDate($value->member_datetime,1)?></td>
								<td>
									<a href="<?=base_url()?>admin/member/del/<?=$value->member_id?>" class="btn btn-danger btn-xs" onclick="return confirm('คุณต้องการลบใช่หรือไม่');">
										<i class="fa fa-trash-o"></i>	
										ลบผู้ใช้
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


