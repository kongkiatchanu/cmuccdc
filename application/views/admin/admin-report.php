<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/poll/add" class="btn btn-info"><i class="fa fa-plus"></i> เพิ่ม</a>
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
								<th>ข้อความที่ระบุ</th>
								<th>ผู้แจ้งลบ</th>
                                <th>ความเห็น</th>
                                <th>เวลา</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php $i=0;foreach ($rsList as $key => $value) {$i++;?>  
						
							<tr>
								<td><?=number_format($i)?></td>
                                <td><?=$value->report_text?></td>
                                <td><?=$value->member_display?></td>
                                <td><?=$value->ref_id?></td>
                                <td><?=$value->report_date?></td>
								<td>	
                                    <a href="<?=base_url()?>admin/forum_topic/view/<?=$value->topic_id?>#comment_<?=$value->ref_id?>" class="btn btn-warning btn-xs"><i class="fa fa-cog"></i> จัดการความเห็น</a>
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


