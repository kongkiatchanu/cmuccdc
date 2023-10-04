<?php
	include 'config.php';

	$cid=mysqli_escape_string($mysqli,$_GET["cid"]);
	$sql="SELECT * FROM `content_category` WHERE `id_category` = {$cid}";
	$q=$mysqli->query($sql);
	$rs=$q->fetch_assoc();
	$cat_name = $rs['category_name'];
	
	
	if($cid!=null){
        $sql="SELECT *FROM `content` WHERE `id_category` = {$cid} AND `content_status`=1 ORDER BY `content`.`content_public` DESC LIMIT 10";
		$q=$mysqli->query($sql);
        $i=0;
        echo '<div class="content-relation">';
        echo '<div>';
        while($rs=$q->fetch_assoc()){?>
        
        <div class="row p-v-xxs">
			<div class="col-xs-12 col-sm-11 col-title">
				<i class="fa fa-circle"></i>
				<h5><a href="<?=BASE_URL?>content/<?php echo $rs['idcontent'];?>" target="_blank"><?php echo $rs['content_title'];?></a></h5>
			</div>
			<div class="hidden-xs col-sm-1 col-view">
				<i class="fa fa-eye"></i>
				<h5 class="text-right"><?php echo number_format($rs['content_viewcount']);?></h5>
			</div>
		</div>

    <?php } ?>
            </div>
            <div class="read-all">
                <p><a href="<?=BASE_URL?>category/<?=$cat_name?>_<?=$cid?>"><b>อ่านทั้งหมด..</b></a></p>
            </div>
        </div>
<?php } ?>