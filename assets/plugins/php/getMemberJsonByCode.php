<?php 
	include 'config.php';
	
	$code = mysqli_real_escape_string($mysqli,$_GET['code']);
	
	$sql="SELECT tbmember2.* , tbmajor.major_name , t3.PROVINCE_NAME , t4.AMPHUR_NAME , t5.DISTRICT_NAME
						FROM tbmember2 
						left join tbmajor on tbmember2.tbmajor_idtbmajor = tbmajor.idtbmajor
						left join province t3 on tbmember2.contact_province = t3.PROVINCE_ID
						left join amphur t4 on tbmember2.contact_amphur = t4.AMPHUR_ID
						left join district t5 on tbmember2.contact_district = t5.DISTRICT_ID
						where tbmember2.member_code = '{$code}' limit 1 ";	
	
	$q=$mysqli->query($sql);
	
	$rs=$q->fetch_assoc();
	
	echo json_encode($rs);
?>