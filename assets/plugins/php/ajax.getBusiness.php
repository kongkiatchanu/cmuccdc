<?php 
	include 'config.php';
	
	if($_GET["type"]=="business"){
		if(isset($_GET["id"])){
			$id = mysqli_real_escape_string($mysqli,$_GET["id"]);
			$sql="SELECT * FROM tbbusiness_detail WHERE idbusiness = ".$id;	
			$q=$mysqli->query($sql);
			echo '<option value="">- เลือก -</option>';
			while($rs=$q->fetch_assoc()){?>
				<option value="<?=$rs["idbusiness_detail"]?>"><?=$rs["detail_name"]?></option>
		<?php	}
		}
	}

	
	
	
?>