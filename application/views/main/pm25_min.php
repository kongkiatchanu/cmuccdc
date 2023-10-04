		<link rel="stylesheet" href="<?=base_url()?>template/css/popup.css">
		<style>
		#dis_map{height:400px;width:100%}
		.db_name{height: 25px;overflow-y: hidden;}
		.c_value{color: #fff;border-radius: 5px;}
		.dustboy_link{color: #333;}
		.dustboy_link:hover{color: #99bf3d;text-decoration: none;}
		#myTab .nav-link{color:#666;}#myTab .active{color:#99bf3d;}
		</style>
		
		<div id="dis_map"></div>
			<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div id="div_tools" class="mt-3">
						ค่า PM 2.5 รายชั่วโมง จากจุดตรวจวัดที่อยู่ในระยะ
						<button class="sw_distance btn btn-success btn-sm active" dvalue="10">10 km</button>
						<button class="sw_distance btn btn-secondary btn-sm" dvalue="20">20 km</button>
						<button class="sw_distance btn btn-secondary btn-sm" dvalue="">All</button>
					</div>
					<p>อัพเดทข้อมูลเมื่อ : <span id="update-time"></span></p>
					<div class="aqi">
                        <ul class="nav nav-tabs float-right" id="myTab" role="tablist">
							<li class="nav-item">
                                <a class="nav-link switch_type <?=$_pmType=="thAQI"?'active':''?>" sType="thAQI" redirect='' href="javascript:void(0)">TH</a>
                            </li>	
                            <li class="nav-item">
                                <a class="nav-link switch_type <?=$_pmType=="usAQI"?'active':''?>" sType="usAQI" redirect='' href="javascript:void(0)">US</a>
                            </li>
                        </ul>
                    </div>
					<div class="loader">
						<p class="text-center"><img style="max-width:100%" src="<?=base_url()?>template/image/loader.gif"></p>
					</div>
					<div class="allowMessage" style="display:none;"></div>
					<div id="tblResult" class="mb-3 mt-3" style="display:none;"></div>
				</div>
			</div>
		</div>
	
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" crossorigin=""></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.68.0/src/L.Control.Locate.min.js" charset="utf-8"></script>
<script>
var map = L.map("dis_map", {
    attributionControl: !1,
    minZoom: 6,
    maxZoom: 14
});
map.createPane("labels"), map.getPane("labels").style.zIndex = 650, map.getPane("labels").style.pointerEvents = "none";
var positron = L.tileLayer("https://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}.png").addTo(map),
    positronLabels = L.tileLayer("https://{s}.basemaps.cartocdn.com/light_only_labels/{z}/{x}/{y}.png").addTo(map),
    lc = L.control.locate({
        position: "topleft",
        strings: {
            title: "Show My Location"
        }
    }).addTo(map);
getLocation();
var c = 0,
    lat = "",
    lon = "",
    dis = 10;

function getLocation() {
    navigator.geolocation && navigator.geolocation.getCurrentPosition(showPosition)
}

function showPosition(t) {
    null != t.coords.latitude && (lat = t.coords.latitude, lon = t.coords.longitude, 0 == c && (getStation(lat, lon, dis), getTblResult(lat, lon, dis), $(".allowMessage").hide(), $(".loader").hide()), c++)
}
var markers = L.layerGroup();

function getTblResult(t, e, a) {
    markers.clearLayers();
    var l = "<?=$this->config->item('base_api')?>api2/dustboy/near/" + t + "/" + e + "/" + a;
    $.getJSON(l, function(t) {
        if (t) {
            t.length > 0 ? $("#update-time").html(t[0].log_datetime) : $("#update-time").html("-");
            var e = "";
            $.each(t, function(t, a) {
				<?php if($_pmType=="thAQI"){?>
                e += "<tr>", e += '<td><div class="db_name"><a href="<?=base_url()?>' + a.dustboy_uri + '" class="dustboy_link">' + a.dustboy_name + "</a></div></td>", e += '<td class="text-center">' + parseFloat(a.distance).toFixed(1) + "</td>", e += '<td class="text-center"><div class="c_value" style="background-color: rgb(' + a.th_color + ')">' + a.pm25 + "</div></td>", e += "</tr>";
                const l = L.marker([a.dustboy_lat, a.dustboy_lon], {
                    icon: L.divIcon({
                        className: "my-custom-pin",
                        iconSize: [35, 35],
                        iconAnchor: [0, 0],
                        labelAnchor: [-6, 0],
                        popupAnchor: [17, 0],
                        html: '<div class="signoutz-marker"style="background-color:rgba(' + a.th_color + ')">' + parseInt(a.pm25).toFixed() + "</div>"
                    })
                });
                l.on("click", function(t) {
                    l.bindTooltip(a.dustboy_name + "<br/>PM<sub>2.5</sub> = " + a.pm25 + " μg/m<sup>3</sup>").openTooltip()
                }), markers.addLayer(l), markers.addTo(map)
				<?php }else if($_pmType=="usAQI"){?>
				e += "<tr>", e += '<td><div class="db_name"><a href="<?=base_url()?>' + a.dustboy_uri + '" class="dustboy_link">' + a.dustboy_name + "</a></div></td>", e += '<td class="text-center">' + parseFloat(a.distance).toFixed(1) + "</td>", e += '<td class="text-center"><div class="c_value" style="background-color: rgb(' + a.us_color + ')">' + a.pm25 + "</div></td>", e += "</tr>";
                const l = L.marker([a.dustboy_lat, a.dustboy_lon], {
                    icon: L.divIcon({
                        className: "my-custom-pin",
                        iconSize: [35, 35],
                        iconAnchor: [0, 0],
                        labelAnchor: [-6, 0],
                        popupAnchor: [17, 0],
                        html: '<div class="signoutz-marker"style="background-color:rgba(' + a.us_color + ')">' + parseInt(a.pm25).toFixed() + "</div>"
                    })
                });
                l.on("click", function(t) {
                    l.bindTooltip(a.dustboy_name + "<br/>PM<sub>2.5</sub> = " + a.pm25 + " μg/m<sup>3</sup>").openTooltip()
                }), markers.addLayer(l), markers.addTo(map)
				<?php }?>
            }), $("#tblResult").html('<div class="table-responsive"><table id="dbList" class="table table-hover"><thead><tr class="text-center"><th>สถานีเครื่องวัด</th><th width="150">ระยะห่าง(km)</th><th width="100">PM<sub>2.5</sub>(&#x03BC;g/m<sup>3</sup>)</th></thead><tbody>' + e + "</tbody></table></div>"), $("#tblResult").show()
        }
    })
}

function getStation(t, e, a) {
    map.setView({
        lat: t,
        lng: e
    }, 10), marker = new L.Marker([t, e], {
        draggable: !0
    }), circle = new L.circle([t, e], {
        radius: 1e3 * a
    }), all = L.layerGroup([marker, circle]), map.addLayer(all), marker.on("dragend", function(l) {
        markers.clearLayers(), circle && map.removeLayer(circle), circle = new L.circle(l.target.getLatLng(), {
            radius: 1e3 * a
        }), all = L.layerGroup([marker, circle]), map.addLayer(all), t = l.target.getLatLng().lat, e = l.target.getLatLng().lng, getTblResult(l.target.getLatLng().lat, l.target.getLatLng().lng, a)
    }), $(".sw_distance").on("click", function(l) {
        $(".sw_distance").removeClass("btn-success"), $(".sw_distance").removeClass("btn-secondary"), $(".sw_distance").addClass("btn-secondary"), $(this).removeClass("btn-secondary"), $(this).addClass("btn-success"), a = $(this).attr("dvalue"), circle && map.removeLayer(circle), "" != $(this).attr("dvalue") ? circle = new L.circle(marker.getLatLng(), {
            radius: 1e3 * $(this).attr("dvalue")
        }) : circle = new L.circle(marker.getLatLng()), all = L.layerGroup([marker, circle]), map.addLayer(all), getTblResult(t, e, a)
    })
}
</script>