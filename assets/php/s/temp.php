<style>
.sql{display:none;}
.b{font-size:15px;}
</style>
<?php
	include "connect.php";
	$sql="SELECT * FROM od_hospital order by hos_username asc";
	$q=$mysqli->query($sql);
	while($rs=$q->fetch_assoc()){
		$password = generateRandomString(6);
		echo '<span class="b">'.$rs['hos_username'].'|'.$password.'</span><br/>';
		$sql= "<span class='sql'>UPDATE `dev`.`od_hospital` SET `hos_password` = '".md5(sha1($password))."' WHERE `od_hospital`.`hos_username` = '".$rs['hos_username']."';</span>";
		echo $sql;
		echo '<hr/>';
	}
	
	function generateRandomString($length = 10) {
		$characters = '0123456789';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
?>
