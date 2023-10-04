<?php
include 'config.php';

$sql = "UPDATE blog SET blog_status = '".mysqli_escape_string($mysqli,$_POST["blog_status"])."'
			  WHERE blog_id = '".mysqli_escape_string($mysqli,$_POST["id"])."'";

$q = $mysqli->query($sql);

if($_POST["blog_status"]==0){
	$txt = 'ฉบับร่าง';
	$theme = 'default';
}else if($_POST["blog_status"]==1){
	$txt = 'เผยแพร่';
	$theme = 'green';
}else if($_POST["blog_status"]==-1){
	$txt = 'ถูกระงับ';
	$theme = 'red';
}
										
?>

	<div class="btn-group">
		<button type="button" class="btn <?=$theme?> btn-xs"><?=$txt?></button>
		<button type="button" class="btn <?=$theme?> btn-xs dropdown-toggle" data-toggle="dropdown"><i class="fa fa-angle-down"></i></button>
		<ul class="dropdown-menu" role="menu">
			<li>
				<a href="#<?=$_POST["id"]?>" class="btn_update_blog_status_on">อนุมัติการใช้งาน</a>
			</li>
			<li>
				<a href="#<?=$_POST["id"]?>" class="btn_update_blog_status_off">ระงับการใช้งาน</a>
			</li>
											
		</ul>
	</div>
