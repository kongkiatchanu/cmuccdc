		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css"/>
		<style>
		  #map{
			bottom: 0;
			left: 0;
			position: absolute;
			right: 0;
			top: 0;
			
		  }
		  #floating-panel {
    position: absolute;
    bottom: 50px;
    right: 10px;
    z-index: 10000;
    background-color: #0d374d;
    padding: 2px;
    opacity: .9;
    color: #fff;
    font-weight: 100;
    font-size: x-small;
	font-family: kanit,sans-serif;
    padding: 5px;
}
		</style>
		
		<div id="floating-panel">ข้อมูลอัพเดทเมื่อ <?=ConvertToThaiDate(date('Y-m-d'),0)?> เวลา <?=date('H')?>:00 น.</div>
		<div id="map"></div>
		<script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>
    <script src="https://unpkg.com/georaster"></script>
    <script src="https://unpkg.com/proj4"></script>
    <script src="https://unpkg.com/georaster-layer-for-leaflet/georaster-layer-for-leaflet.browserify.min.js"></script>
    <script>
		// initalize leaflet map
		var map = L.map('map').setView([0, 0], 5);

		L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
			attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
		}).addTo(map);
	
		var url_to_geotiff_file = "/uploads/tiff/<?=$newfile?>";
		
		fetch(url_to_geotiff_file)
		.then((response) => response.arrayBuffer())
		.then((arrayBuffer) => {
			parseGeoraster(arrayBuffer).then((georaster) => {
				console.log("georaster:", georaster);

				/*
			  GeoRasterLayer is an extension of GridLayer,
			  which means can use GridLayer options like opacity.

			  Just make sure to include the georaster option!

			  Optionally set the pixelValuesToColorFn function option to customize
			  how values for a pixel are translated to a color.

			  http://leafletjs.com/reference-1.2.0.html#gridlayer
		  */
				var layer = new GeoRasterLayer({
					georaster: georaster,
					opacity: .9,
					resolution: 256,
				});
				layer.addTo(map);

				map.fitBounds(layer.getBounds());
			});
		});


    </script>
		
		
	
