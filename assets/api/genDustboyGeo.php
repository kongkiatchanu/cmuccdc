<?php 
	header('Access-Control-Allow-Origin: https://www.cmuccdc.org');
	
	$type = explode("-",$_GET['dataType']);
	if($type[1]=="hr"){
		$url = 'https://www-old.cmuccdc.org/assets/api/haze/pwa/json/stations_temp.json';
	}else{
		$url = 'https://www-old.cmuccdc.org/assets/api/haze/pwa/json/stations_daily.json';
	}

	//$url = 'https://www-old.cmuccdc.org/assets/api/haze/pwa/json/stations.json';

	$rs = json_decode(file_get_contents($url));
	//$rs = json_decode(file_get_contents('json/stations.json'));
	# Build GeoJSON feature collection array
	$geojson = array(
	   'type'      => 'FeatureCollection',
	   'features'  => array()
	);

	//indoor
	$ar_station = array(6411, 4425, 5471, 5472,5468, 5469, 5473, 5475, 5268, 5270, 6614, 6615, 6616, 6617, 6618, 6619, 6620, 6621, 6622, 6623, 6624, 6625, 6626, 6627, 6629, 6630, 6613);
	
		
	foreach($rs as $item){
		if(@$_GET['sensors']=="indoor"){
			if (in_array((int)$item->id, $ar_station)){
				$properties = $item;
				$feature = array(
					'type' => 'Feature',
					'geometry' => array(
						'type' => 'Point',
						'coordinates' => array(
							$item->dustboy_lon,
							$item->dustboy_lat,
						)
					),
					'properties' => $properties
				);
				array_push($geojson['features'], $feature);
			}
		}else{
			if (!in_array((int)$item->id, $ar_station)){
				$properties = $item;
				$feature = array(
					'type' => 'Feature',
					'geometry' => array(
						'type' => 'Point',
						'coordinates' => array(
							$item->dustboy_lon,
							$item->dustboy_lat,
						)
					),
					'properties' => $properties
				);
				array_push($geojson['features'], $feature);
			}
		}
		
		# Add feature arrays to feature collection array
		
	}
	header('Content-type: application/json');
	echo json_encode($geojson, JSON_NUMERIC_CHECK);
?>
