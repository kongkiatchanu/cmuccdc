<?php 
	function DatediffCount($datetime){
		$earlier = new DateTime($datetime);
		$later = new DateTime(date('Y-m-d'));

		$diff = $later->diff($earlier)->format("%a");
		return $diff;
	}
	
	$days=array();
	$week=array();
	$month=array();
	$twmonth=array();
	$thmonth=array();
	foreach($rsStatus as $item){
		$offline_day = DatediffCount($item->status_date);
		if($offline_day>0 && $offline_day<=7){
			array_push($days , $item);
		}else if($offline_day>7 && $offline_day<=30){
			array_push($week , $item);
		}else if($offline_day>30 && $offline_day<=60){
			array_push($month , $item);
		}else if($offline_day>60 && $offline_day<=90){
			array_push($twmonth , $item);
		}else if($offline_day>90){
			array_push($thmonth , $item);
		}
	}			
?>

	<style>
		#dis_map{height:400px;width:100%}
		.offline-marker {
			border-radius: 50%;
			width: 10px;
			height: 10px;
			border: 1px solid #fff;
		}
	</style>
	
	<div class="container mb-5">

		<div class="row mt-3 mb-3">
			<div class="col-md-12">
				
				<div id="dis_map" class="mb-3"></div>
				<h4>ตารางสรุปจำนวนเครื่องที่ออฟไลน์</h4>
				<table class="table">
					<thead class="text-center">
						<tr>
							<th>days</th>
							<th>week</th>
							<th>month</th>
							<th>2 month</th>
							<th>3 month</th>
						</tr>
					</thead>
					<body class="text-center">
						<tr>
							<td><?=count($days)?></td>
							<td><?=count($week)?></td>
							<td><?=count($month)?></td>
							<td><?=count($twmonth)?></td>
							<td><?=count($thmonth)?></td>
						</tr>
					</body>
				</table>
			</div>
		</div>
	</div>
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" crossorigin=""/>
	<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" crossorigin=""></script>
	<script>
		var map = new L.map("dis_map", {
			center: [13.912, 100.5270061],
			zoom: 5,
			attributionControl: !1,
			maxZoom: 17,
			minZoom: 5,
			fullscreenControl: true,
			});
		L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
		}).addTo(map);
		
		<?php foreach($days as $item){?>
				L.marker([<?=$item->status_lat?>, <?=$item->status_lnt?>], {
						icon: L.divIcon({
						className: "my-custom-pin",
						iconSize: [10, 10],
						html: '<div class="offline-marker" style="background-color:rgba(0,191,243, 1)"></div>',
					})
				}).addTo(map)
				.bindPopup('<b><?=$item->status_source_name?></b><br/><?=$item->status_date=="0000-00-00 00:00:00"?"-": "ออฟไลน์ ".DatediffCount($item->status_date)?> วัน');
		<?php }?>
		
		<?php foreach($$week as $item){?>
				L.marker([<?=$item->status_lat?>, <?=$item->status_lnt?>], {
						icon: L.divIcon({
						className: "my-custom-pin",
						iconSize: [10, 10],
						html: '<div class="offline-marker" style="background-color:rgba(0,166,81, 1)"></div>',
					})
				}).addTo(map)
				.bindPopup('<b><?=$item->status_source_name?></b><br/><?=$item->status_date=="0000-00-00 00:00:00"?"-": "ออฟไลน์ ".DatediffCount($item->status_date)?> วัน');
		<?php }?>
		
		<?php foreach($month as $item){?>
				L.marker([<?=$item->status_lat?>, <?=$item->status_lnt?>], {
						icon: L.divIcon({
						className: "my-custom-pin",
						iconSize: [10, 10],
						html: '<div class="offline-marker" style="background-color:rgba(253,192,78, 1)"></div>',
					})
				}).addTo(map)
				.bindPopup('<b><?=$item->status_source_name?></b><br/><?=$item->status_date=="0000-00-00 00:00:00"?"-": "ออฟไลน์ ".DatediffCount($item->status_date)?> วัน');
		<?php }?>
		
		<?php foreach($twmonth as $item){?>
				L.marker([<?=$item->status_lat?>, <?=$item->status_lnt?>], {
						icon: L.divIcon({
						className: "my-custom-pin",
						iconSize: [10, 10],
						html: '<div class="offline-marker" style="background-color:rgba(242,101,34, 1)"></div>',
					})
				}).addTo(map)
				.bindPopup('<b><?=$item->status_source_name?></b><br/><?=$item->status_date=="0000-00-00 00:00:00"?"-": "ออฟไลน์ ".DatediffCount($item->status_date)?> วัน');
		<?php }?>
		
		<?php foreach($thmonth as $item){?>
				L.marker([<?=$item->status_lat?>, <?=$item->status_lnt?>], {
						icon: L.divIcon({
						className: "my-custom-pin",
						iconSize: [10, 10],
						html: '<div class="offline-marker" style="background-color:rgba(205,0,0, 1)"></div>',
					})
				}).addTo(map)
				.bindPopup('<b><?=$item->status_source_name?></b><br/><?=$item->status_date=="0000-00-00 00:00:00"?"-": "ออฟไลน์ ".DatediffCount($item->status_date)?> วัน');
		<?php }?>
		
	</script>
	