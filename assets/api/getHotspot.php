<?php 
	$key = $_GET["key"];
	if($key!=md5(date('ymd'))){
		//die('Could not connect: ' . mysql_error());
	}
	
	$api_baseurl = 'https://maemoh.3e.world/api/hotspot/';
	
	if($_GET["type"]=="all"){
		$times	= $_GET['times'];
		$url 	= 'https://maemoh.3e.world/api/hotspot/list/'.$_GET['times'];
	}else{
		$times	= $_GET['times'];
		$pv		= $_GET['pv'];
		$url 	= 'https://maemoh.3e.world/api/hotspot/listz/'.$_GET['times'].'/'.$_GET['pv'];
	}
	
	
	$rs = json_decode(file_get_contents($url));
	

	$geojson = array(
		'type'      => 'FeatureCollection',
		'features'  => array()
	);
	
	if($_GET['s']!=null){	
		foreach($rs->features as $item){
			
			if($_GET['s']==$item->properties->source){
			//	if($item->properties->confidence>!=0){
				array_push($geojson['features'], $item);
			//	}
			}
		}
	}else{
		foreach($rs->features as $item){

			//if($item->properties->confidence>!=0){
				array_push($geojson['features'], $item);
			//}
		}
	}

		header('Content-type: application/json');
	echo json_encode($geojson, JSON_NUMERIC_CHECK);
	
	
?>
