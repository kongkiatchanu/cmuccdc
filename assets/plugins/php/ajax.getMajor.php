<?php 
	include 'config.php';
	

	$sql="SELECT * FROM tbmajor";	
	$q=$mysqli->query($sql);
	echo '<option value="">- เลือก -</option>';
	while($rs=$q->fetch_assoc()){?>
		<option value="<?=$rs["idtbmajor"]?>"><?=$rs["major_name"]?></option>
	<?php	}
?>