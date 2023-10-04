<?php
	include 'config.php';
	
	$sql="SELECT * FROM  ribbon where ribbon_status=1";
	$q=$mysqli->query($sql);
	if($q->num_rows){
		$rs=$q->fetch_assoc();
?>
		<img src="<?=BASE_URL?>uploads/images/<?php echo $rs['ribbon_img']?>" class="rb <?=$rs['ribbon_position']?>" alt="<?=$rs['ribbon_name']?>">
<?php		
	}
?>