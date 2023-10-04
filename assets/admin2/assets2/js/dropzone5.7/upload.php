<?php 
	date_default_timezone_set("Asia/Bangkok");
	$storeFolder = $_SERVER["DOCUMENT_ROOT"]."/uploads/images/";
	
	if (!empty($_FILES)) {
	 
		$tempFile = $_FILES['file']['tmp_name'];
		 
		$tmp	= explode(".",$_FILES['file']['name']);
		$tmp	= end($tmp);
		$tmpName = "thumbnail_".date("Ymdhis").".".$tmp;
		$targetFile =  $storeFolder. $tmpName;  //5
	 
		move_uploaded_file($tempFile,$targetFile); //6
		
		echo $tmpName;
	}
?>     