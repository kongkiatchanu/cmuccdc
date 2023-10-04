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
                                <th>เข้าชม / ความเห็น</th>
                                <th>วันที่</th>
                                <th>สร้างโดย</th>
								<th>สถานะการแสดง</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php $i=0;foreach ($rsList as $key => $post) {$i++;?>  
						
							<tr>
                                <td><?=number_format($i)?></td>
                                <td><a href="<?php echo base_url();?>forum/topic/<?php echo $post->topic_id?>" title="<?php echo $post->topic_title;?>"><?php echo $post->topic_title;?></a></td>
                                <td class="text-center"><?php echo $post->topic_view;?> / <?php echo $post->total_comment;?></td>
                                <td class="text-center"><?php echo $post->thaidate;?></td>
                                <td class="text-center"><?php echo $post->member_display;?></td>
								<td id="topic_status[<?php echo $post->topic_id; ?>]">
                                <?php if($post->is_show) : ?>
                                        <a href="#<?php echo $post->topic_id; ?>" class="topic_status_off btn btn-success btn-xs">แสดง</a>
                                        <?php else : ?>
                                        <a href="#<?php echo $post->topic_id; ?>" class="topic_status_on btn btn-default btn-xs">ซ่อน</a>
                                <?php endif; ?>
                                </td>
                                <td>
									<a href="<?=base_url()?>admin/forum_topic/view/<?=$post->topic_id?>" class="btn btn-success btn-xs">
										<i class="fa fa-eye"></i>	
										ดูรายละเอียด
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


