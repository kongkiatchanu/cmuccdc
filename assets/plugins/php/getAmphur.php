<?php
	date_default_timezone_set("Asia/Bangkok");
	define("DB_HOSTNAME","localhost");
	define("DB_DATABASE","hotspot");
	define("DB_USERNAME","root");
	define("DB_PASSWORD","lbcmsuccess");
	
	
	
	$mysqli=new mysqli(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD);
	$mysqli->select_db(DB_DATABASE);
	$mysqli->query("SET NAMES utf8;");

	echo '<option value="">กรุณาเลือกอำเภอ</option>';
	$province_id = mysqli_escape_string($mysqli,$_GET["pv_id"]);
	$sql= "SELECT * FROM `amphur` WHERE `PROVINCE_ID` = ".$province_id." ORDER BY `PROVINCE_ID` ASC ";
	$q = $mysqli->query($sql);
	while($rs = $q->fetch_assoc()){?>
		<option value="<?=$rs['AMPHUR_ID']?>"><?=$rs['AMPHUR_NAME']?></option>
	<?php	
	}
	
	