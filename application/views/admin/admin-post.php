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
					<table class="table" id="sample_2">
						<thead>
							<tr style="font-weight: 500;background-color: #333;color:#fff;">
								<th>หัวข้อ</th>
								<th>โดย</th>
								<th>สถานะ</th>
								<th>เขียนเมื่อ</th>
							</tr>
						</thead>
						<tbody>
						<?php $i=0;foreach ($rsList as $key => $value) {$i++;?>  
						
							<tr>
								<td><a href="<?=base_url()?>post/<?=$value->blog_id?>" target="_blank"><?=$value->blog_title?></a></td>
								<td><a href="<?=base_url()?>member/<?=$value->blog_member_code?>" target="_blank"><?=$value->blog_member_code?></a></td>
								<td id="blog_status[<?php echo $value->blog_id; ?>]">
									<?php 
										if($value->blog_status==0){
											$txt = 'ฉบับร่าง';
											$theme = 'default';
										}else if($value->blog_status==1){
											$txt = 'เผยแพร่';
											$theme = 'green';
										}else if($value->blog_status==-1){
											$txt = 'ถูกระงับ';
											$theme = 'red';
										}
									
									?>
									<div class="btn-group">
										<button type="button" class="btn <?=$theme?> btn-xs"><?=$txt?></button>
										<button type="button" class="btn <?=$theme?> btn-xs dropdown-toggle" data-toggle="dropdown"><i class="fa fa-angle-down"></i></button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a href="#<?=$value->blog_id?>" class="btn_update_blog_status_on">เผยแพร่</a>
											</li>
											<li>
												<a href="#<?=$value->blog_id?>" class="btn_update_blog_status_off">ระงับ</a>
											</li>
											
										</ul>
									</div>
								</td>
								<td><?=$value->blog_createdate?></td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
			
			</div>
		</div>
	</div>
</div>


