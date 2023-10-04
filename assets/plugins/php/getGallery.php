<?php include 'config.php';?>
<div class="row equal">
    <?php
    $sql="SELECT * FROM `gallery` WHERE `gallery_status`=1 ORDER BY `gallery`.`gallery_create` DESC LIMIT 8";
	$q=$mysqli->query($sql);

    while($rs=$q->fetch_assoc()){?>
        
        <div class="col-md-3 col-sm-4 news-box">
            <a href="<?=BASE_URL?>gallery/<?php echo $rs['gallery_id']?>" title="<?php echo $rs['gallery_name']?>" target="_blank">
                <div class="img"><img src="<?=BASE_URL?>/uploads/timthumb.php?src=<?=BASE_URL?>uploads/images/<?php echo $rs['gallery_thumbnail']?>&w=600&h=400" class="img-responsive" alt="<?php echo $rs['gallery_name']?>"></div>
                <div class="text">
                    <h5 class="gallery_title"><?php echo $rs['gallery_name']?></h5>
                    
                    <p class="date"><?php echo ConvertToThaiDate($rs['gallery_create'],1)?></p>
                </div>
            </a>
            <!-- <a class="btn btn-success" href="#" role="button">อ่านเพิ่มเติม</a> -->
        </div>

<?php } ?>
         
</div>
