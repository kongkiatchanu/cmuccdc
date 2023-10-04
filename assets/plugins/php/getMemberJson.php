<?php 
	include 'config.php';
	
	$username = mysqli_real_escape_string($mysqli,$_GET['username']);
	$password = mysqli_real_escape_string($mysqli,md5(sha1($_GET['password'])));
	
	$sql="SELECT * FROM tbmember2 
	left join tbmajor on tbmember2.tbmajor_idtbmajor = tbmajor.idtbmajor
	where tbmember2.member_code = '{$username}' AND tbmember2.idcard = '{$password}'";	
	
	$q=$mysqli->query($sql);
	
	$rs=$q->fetch_assoc();
	
	echo json_encode($rs);
?>