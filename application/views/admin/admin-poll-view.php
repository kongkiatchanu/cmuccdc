<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/poll" class="btn btn-info"><i class="fa fa-undo"></i> กลับ</a>
			</div>
		</div>
		<hr/>
		<div class="row">
			<div class="col-md-12">
                <h3><?php echo $rs[0]->ques;?>?</h3>

                <!-- <div class="row">
                    <div class="col-md-8 col-md-offset-2"> -->
                        <div class="well">
                        <?php foreach($rs as $row){?>
                            <?php $percent=round(($row->votes*100)/$vote_total[0]->vote_total);?>
                            <div>
                                <h5><?php echo $row->value;?></h5>
                                <p><?php echo $percent;?>% (<?php echo $row->votes;?> votes)</p>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $percent;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percent;?>%">
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                        </div>
                    <!-- </div> 
                </div> -->
                
			</div>
		</div>
	</div>
</div>
