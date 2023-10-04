<?php echo smiley_js(); ?>
<style>
.az_avatar_box{
    background-color: #3c3d41;
    color: #fff;
    padding: 15px 25px;
    margin-right: 10px;
    font-size: 25px;
    text-shadow: 2px 2px #000000;
}
.need-help
{
    margin-top: 10px;
}
.new-account
{
    display: block;
    margin-top: 10px;
}

.card-header {
    padding: .75rem 1.25rem;
    margin-bottom: 0;
    background-color: rgba(0,0,0,.03);
    border-bottom: 1px solid rgba(0,0,0,.125);
}
.card-header:first-child {
    border-radius: calc(.25rem - 1px) calc(.25rem - 1px) 0 0;
	margin: 0;
}
.card-body {
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 1.25rem;
}
.media {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: start;
    align-items: flex-start;
}
.mb-4 {
    margin-bottom: 1.5rem!important;
}
.mr-3 {
    margin-right: 1rem!important;
}
.d-flex {
    display: -ms-flexbox!important;
    display: flex!important;
}
.media-body {
    -ms-flex: 1;
    flex: 1;
}
.mt-0 {
    margin-top: 0!important;
}
.my-4 {
    margin-top: 1.5rem!important;
    margin-bottom: 1.5rem!important;
}
.card {
    position: relative;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0,0,0,.125);
    border-radius: .25rem;
}
</style>
<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/forum_topic" class="btn btn-info"><i class="fa fa-undo"></i> กลับ</a>
			</div>
		</div>
		<hr/>
		<div class="row">
			<div class="col-md-12">
                <h3><i class="fa fa-fire"></i> <?php echo $rs[0]->topic_title;?>?</h3>
                <p><?php echo $rs[0]->topic_detail;?></p>
                <hr/>
                <h4>ความคิดเห็นทั้งหมด <i class="fa fa-comments"></i></h4>
                    <!-- comments -->
                    <?php foreach($rsComment as $comment){?>
                        <div class="media mb-4" id="comment_<?=$comment['post_id']?>">
                            <strong class="az_avatar_box"><?=substr($rs[0]->member_display,0,1)?></strong>
                            <div class="media-body">
                                <h4 class="mt-0"><?php echo $comment["member_display"];?><small>(ความเห็น <?=$comment['post_id']?>)</small></h4>
                                <?php $post_detail = parse_smileys($comment["post_detail"], 'http://www.nk.go.th/assets/img/smileys/');?>
                                <?php echo $post_detail;?>
                                <div style="margin-top:10px;">
                                    <div class="pull-left">
                                        <small><i>วันที่ <?php echo $comment['thaidate']?></i></small>
                                    </div>
                                    <div class="pull-right text-right">
                                        <button class="btn btn-default btn-xs report" comment="<?=$comment['post_id']?>"><i class="fa fa-times"></i> ลบความเห็น</button>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                
                                <!-- subComment -->
                                <?php 
                                    $numItems = count($comment['subComment']);
                                    $i = 0;
                                ?>
                                <?php if($comment['subComment']!=null){?>
                                    <?=$i==0?'<hr/>':''?>
                                    <?php foreach($comment['subComment'] as $subComment){?>
                                        <div class="media mb-4" id="comment_<?=$subComment['post_id']?>">
                                            <strong class="az_avatar_box"><?=substr($rs[0]->member_display,0,1)?></strong>
                                            <div class="media-body">
                                                <h4 class="mt-0"><?php echo $subComment["member_display"];?></h4>
                                                <?php $post_detail = parse_smileys($subComment["post_detail"], 'http://www.nk.go.th/assets/img/smileys/');?>
                                                <?php echo $post_detail;?>
                                                <div style="margin-top:10px;">
                                                    <div class="pull-left">
                                                        <small><i>วันที่ <?php echo $subComment['thaidate']?></i></small>
                                                    </div>
                                                    <div class="pull-right text-right">
                                                        <button class="btn btn-default btn-xs report" comment="<?=$subComment['post_id']?>"><i class="fa fa-times"></i> ลบความเห็น</button>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                        <?php if(++$i != $numItems) {echo "<hr/>";}?>
                                    <?php }?>
                                <?php }?>
                            </div>
                        </div>
                        <hr/>
                    <?php }?>
			</div>
		</div>
	</div>
</div>
