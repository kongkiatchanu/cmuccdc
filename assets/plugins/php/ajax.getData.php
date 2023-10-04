<?php 
	include 'config.php';
	
	if($_GET["type"]=="amphur"){
		if(isset($_GET["id"])){
			$id = mysqli_real_escape_string($mysqli,$_GET["id"]);
			$sql="SELECT * FROM amphur WHERE PROVINCE_ID = ".$id;	
			$q=$mysqli->query($sql);
			echo '<option value="">- เลือก -</option>';
			while($rs=$q->fetch_assoc()){?>
				<option value="<?=$rs["AMPHUR_ID"]?>"><?=$rs["AMPHUR_NAME"]?></option>
		<?php	}
		}
	}
	
	if($_GET["type"]=="district"){
		if(isset($_GET["id"])){
			$id = mysqli_real_escape_string($mysqli,$_GET["id"]);
			$sql="SELECT * FROM district WHERE AMPHUR_ID = ".$id;	
			$q=$mysqli->query($sql);
			echo '<option value="">- เลือก -</option>';
			while($rs=$q->fetch_assoc()){?>
				<option value="<?=$rs["DISTRICT_ID"]?>"><?=$rs["DISTRICT_NAME"]?></option>
		<?php	}
		}
	}
	
	if($_GET["type"]=="province"){
			$sql="SELECT * FROM province ORDER BY province.PROVINCE_NAME ASC ";	
			$q=$mysqli->query($sql);
			echo '<option value="">- เลือก -</option>';
			while($rs=$q->fetch_assoc()){?>
				<option value="<?=$rs["PROVINCE_ID"]?>"><?=$rs["PROVINCE_NAME"]?></option>
		<?php	}
		
	}
	
	if($_GET["type"]=="zipcode"){
		if(isset($_GET["id"])){
			$id = mysqli_real_escape_string($mysqli,$_GET["id"]);
			$sql="SELECT * FROM district WHERE DISTRICT_ID = ".$id;	
			$q=$mysqli->query($sql);
			$rs=$q->fetch_assoc();
			//echo $rs["DISTRICT_CODE"];
		}
	}
	
	if($_GET["type"]=="major"){
		$sql="SELECT * FROM tbmajor";	
		$q=$mysqli->query($sql);
		echo '<option value="">- เลือก -</option>';
		while($rs=$q->fetch_assoc()){?>
			<option value="<?=$rs["idtbmajor"]?>"><?=$rs["major_name"]?></option>
		<?php	}
	}
	
	if($_GET["type"]=="career"){
		$sql="SELECT * FROM tbcareer";	
		$q=$mysqli->query($sql);
		echo '<option value="">- เลือก -</option>';
		while($rs=$q->fetch_assoc()){?>
			<option value="<?=$rs["idtbcareer"]?>"><?=$rs["career_name"]?></option>
		<?php	}
	}
	
	if($_GET["type"]=="ministry"){
		if(isset($_GET["id"])){
			$id = mysqli_real_escape_string($mysqli,$_GET["id"]);
			$sql="SELECT * FROM tbministry_department WHERE idministry = ".$id;	
			$q=$mysqli->query($sql);
			echo '<option value="">- เลือก -</option>';
			while($rs=$q->fetch_assoc()){?>
				<option value="<?=$rs["iddepartment"]?>"><?=$rs["department_name"]?></option>
		<?php	}
		}
	}
	
?>