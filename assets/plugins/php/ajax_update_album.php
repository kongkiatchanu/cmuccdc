<?php
	include 'config.php';

	$do 		= $_POST["do"];

	if ($do=="delete"){
		$gallery_id = mysqli_real_escape_string($mysqli,$_POST['abid']);
		$img_id = mysqli_real_escape_string($mysqli,$_POST['del_id']);
		
		$sql="SELECT * FROM gallery_img WHERE img_id = {$img_id} AND gallery_id = {$gallery_id}";
		$q=$mysqli->query($sql);
		if($q->num_rows){
			$rs=$q->fetch_assoc();
			$sql="DELETE FROM gallery_img WHERE img_id = {$img_id} AND gallery_id = {$gallery_id}";
			$q=$mysqli->query($sql);
			unlink('../../../uploads/gallery/'.$rs['gallery_filename']);
		}

	}
?>