<?php
include 'config.php';

$sql = "UPDATE member SET member_od = '".mysqli_escape_string($mysqli,$_POST["is_show"])."'
			  WHERE member_id = '".mysqli_escape_string($mysqli,$_POST["id"])."'";

$q = $mysqli->query($sql);

if($_POST["is_show"]==0){
	$txt = 'รอการอนุมัติ';
	$theme = 'default';
}else if($_POST["is_show"]==1){
	$txt = 'อนุมัติการใช้งาน';
	$theme = 'green';
}else if($_POST["is_show"]==-1){
	$txt = 'ระงับการใช้งาน';
	$theme = 'red';
}
										
?>

	<div class="btn-group">
		<button type="button" class="btn <?=$theme?> btn-xs"><?=$txt?></button>
		<button type="button" class="btn <?=$theme?> btn-xs dropdown-toggle" data-toggle="dropdown"><i class="fa fa-angle-down"></i></button>
		<ul class="dropdown-menu" role="menu">
			<li>
				<a href="#<?=$_POST["id"]?>" class="member_status_od_on">อนุมัติการใช้งาน</a>
			</li>
			<li>
				<a href="#<?=$_POST["id"]?>" class="member_status_od_off">ระงับการใช้งาน</a>
			</li>

											
		</ul>
	</div>