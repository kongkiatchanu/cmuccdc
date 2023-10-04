<?php
	include "connect.php";
	if($_GET['key']!=md5('s'.date('ymdh'))){
		exit;
	}
	$sql="SELECT * FROM source WHERE source_id =".mysqli_real_escape_string($mysqli, $_GET['p']);
	$q=$mysqli->query($sql);
	if($q->num_rows)
	{
		$rs=$q->fetch_assoc();
		$out = array_values($rs);
		
		echo json_encode($out);
	}else{
		header("Location: /");
		exit();
	}
?>
