		<style>
		#dis_map{height:400px;width:100%}
		.db_name{height: 25px;overflow-y: hidden;}
		.c_value{color: #fff;border-radius: 5px;}
		</style>
		
		<div id="dis_map"></div>
			<div class="container">
			<div class="col-md-12">
				<div id="div_tools" class="mt-3">
					ค่า PM 2.5 รายชั่วโมง จากจุดตรวจวัดที่อยู่ในระยะ
					<button class="sw_distance btn btn-success btn-sm active" dvalue="10">10 km</button>
					<button class="sw_distance btn btn-secondary btn-sm" dvalue="20">20 km</button>
					<button class="sw_distance btn btn-secondary btn-sm" dvalue="">All</button>
				</div>
				<div class="loader">
					<p class="text-center"><img style="max-width:100%" src="<?=base_url()?>template/image/loader.gif"></p>
				</div>
				<div class="allowMessage" style="display:none;"></div>
				<div id="tblResult" class="mb-3 mt-3" style="display:none;"></div>
			</div>
		</div>
	
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" crossorigin=""></script>
<script>var map=L.map("dis_map",{attributionControl:!1,minZoom:6,maxZoom:12});map.createPane("labels"),map.getPane("labels").style.zIndex=650,map.getPane("labels").style.pointerEvents="none";var positron=L.tileLayer("https://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}.png").addTo(map),positronLabels=L.tileLayer("https://{s}.basemaps.cartocdn.com/light_only_labels/{z}/{x}/{y}.png").addTo(map);getLocation();var c=0,lat="",lon="",dis=10;function getLocation(){navigator.geolocation&&navigator.geolocation.getCurrentPosition(showPosition)}function showPosition(t){null!=t.coords.latitude&&(lat=t.coords.latitude,lon=t.coords.longitude,0==c&&(getStation(lat,lon,dis),getTblResult(lat,lon,dis),$(".allowMessage").hide(),$(".loader").hide()),c++)}function getTblResult(t,e,a){var l="<?=$this->config->item('base_api')?>api2/dustboy/near/"+t+"/"+e+"/"+a;console.log(l),$.getJSON(l,function(t){if(t){var e="";$.each(t,function(t,a){e+="<tr>",e+='<td><div class="db_name">'+a.dustboy_name+"</div></td>",e+='<td class="text-center">'+parseFloat(a.distance).toFixed(1)+"</td>",e+='<td class="text-center">'+a.pm25+"</td>",e+='<td class="text-center"><div class="c_value" style="background-color: rgb('+a.th_color+')">'+a.pm25_th_aqi+"</div></td>",e+='<td class="text-center"><div class="c_value" style="background-color: rgb('+a.us_color+')">'+a.pm25_us_aqi+"</div></td>",e+="</tr>"}),$("#tblResult").html('<div class="table-responsive"><table class="table table-hover"><thead><tr class="text-center"><th>สถานีเครื่องวัด</th><th width="150">ระยะห่าง(km)</th><th width="100">PM<sub>2.5</sub>(&#x03BC;g/m<sup>3</sup>)</th><th width="100">TH AQI</th><th width="100">US AQI</th></tr></thead><tbody>'+e+"</tbody></table></div>"),$("#tblResult").show()}})}function getStation(t,e,a){map.setView({lat:t,lng:e},10),marker=new L.Marker([t,e],{draggable:!0}),circle=new L.circle([t,e],{radius:1e3*a}),all=L.layerGroup([marker,circle]),map.addLayer(all),marker.on("dragend",function(l){circle&&map.removeLayer(circle),circle=new L.circle(l.target.getLatLng(),{radius:1e3*a}),all=L.layerGroup([marker,circle]),map.addLayer(all),t=l.target.getLatLng().lat,e=l.target.getLatLng().lng,getTblResult(l.target.getLatLng().lat,l.target.getLatLng().lng,a)}),$(".sw_distance").on("click",function(l){$(".sw_distance").removeClass("btn-success"),$(".sw_distance").removeClass("btn-secondary"),$(".sw_distance").addClass("btn-secondary"),$(this).removeClass("btn-secondary"),$(this).addClass("btn-success"),a=$(this).attr("dvalue"),circle&&map.removeLayer(circle),""!=$(this).attr("dvalue")?circle=new L.circle(marker.getLatLng(),{radius:1e3*$(this).attr("dvalue")}):circle=new L.circle(marker.getLatLng()),all=L.layerGroup([marker,circle]),map.addLayer(all),getTblResult(t,e,a)})}</script>