<?php
include 'config.php';

$sql = "UPDATE member SET member_verify_status = '".mysqli_escape_string($mysqli,$_POST["member_verify_status"])."'
			  WHERE member_id = '".mysqli_escape_string($mysqli,$_POST["id"])."'";

$q = $mysqli->query($sql);

if($_POST["member_verify_status"]==0){
	$txt = 'รอการยืนยัน';
	$theme = 'default';
}else if($_POST["member_verify_status"]==1){
	$txt = 'ยืนยันอีเมล์แล้ว';
	$theme = 'green';
}else if($_POST["member_verify_status"]==-1){
	$txt = 'ระงับการใช้งาน';
	$theme = 'red';
}
										
?>

	<div class="btn-group">
		<button type="button" class="btn <?=$theme?> btn-xs"><?=$txt?></button>
		<button type="button" class="btn <?=$theme?> btn-xs dropdown-toggle" data-toggle="dropdown"><i class="fa fa-angle-down"></i></button>
		<ul class="dropdown-menu" role="menu">
			<li>
				<a href="#<?=$_POST["id"]?>" class="btn_update_member_status_on">อนุมัติการใช้งาน</a>
			</li>

											
		</ul>
	</div>
