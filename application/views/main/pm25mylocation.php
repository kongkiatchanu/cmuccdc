		<link rel="stylesheet" href="<?=base_url()?>template/css/popup.css">
		<style>
		#dis_map{height:400px;width:100%}
		.db_name{height: 25px;overflow-y: hidden;}
		.c_value{color: #fff;border-radius: 5px;}
		.dustboy_link{color: #333;}
		.dustboy_link:hover{color: #99bf3d;text-decoration: none;}
		#myTab .nav-link{color:#666;}#myTab .active{color:#99bf3d;}
		
		</style>
		<style>
			.form-filler {
				border-top: 5px solid #0c364c;
				padding: 20px 15px;
				background-color: #f8f8f8;
			}
		</style>
		
		<div class="container mb-5" style="background: white url(<?=$this->config->item("base_api")?>template_hazedata/img/header-pic2.png) no-repeat top;">
			<div class="row pt-5 pb-2">
				<div class="col-lg-9">

					<div class="form-filler">
						<h3>Parameter</h3><hr/>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">DustBoy :</label>
							<div class="col-sm-10">
								<select class="form-control" id="dustboy">			
									<option value=""> เลือกจุดตรวจวัด </option>
									<?php foreach($rsRegion as $item){?>
									<optgroup label="<?=$item->zone_name_th?>">
										<?php if($item->provinces!=null){?>
											<?php foreach($item->provinces as $province){?>
											<optgroup label="&nbsp;&nbsp;&nbsp;&nbsp;<?=$province->province_name_th?>">
												<?php if($province->stations!=null){?>
													<?php foreach($province->stations as $station){?>
														<option value="<?=$station->location_lat?>,<?=$station->location_lon?>">&nbsp;&nbsp;&nbsp;&nbsp; <?=$station->location_name?></option>
													<?php }?>
												<?php }?>
											</optgroup>
											<?php }?>
										<?php }?>
									</optgroup>
									<?php }?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Data Type :</label>
							<div class="col-sm-10" style="padding-top: 10px;">
								<div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="datatype" id="inlineRadio1" value="10" checked>
                                    <label class="form-check-label" for="inlineRadio1">10 km</label>
                                </div>
								<div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="datatype" id="inlineRadio2" value="20">
                                    <label class="form-check-label" for="inlineRadio2">20 km</label>
                                </div>
								<div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="datatype" id="inlineRadio3" value="all">
                                    <label class="form-check-label" for="inlineRadio3">All</label>
                                </div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-10 offset-md-2">
								<button type="button" class="btn btn-info mb-1" id="btnTable"><i class="fa fa-table"></i> Query </button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--<div id="dis_map"></div>-->
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="form-filler">
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
						<div class="loader" style="display:none;">
							<p class="text-center"><img style="max-width:100%" src="<?=base_url()?>template/image/loader.gif"></p>
						</div>
						<div class="allowMessage" style="display:none;"></div>
						<div id="tblResult" class="mb-3 mt-3" style="display:none;"></div>
					</div>
				</div>
			</div>
		</div>
	
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" crossorigin=""></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.68.0/src/L.Control.Locate.min.js" charset="utf-8"></script>
<script>
/*
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
*/
function getTblResult(t, e, a) {
    //markers.clearLayers();
    var l = "<?=$this->config->item('base_api')?>api2/dustboy/near/" + t + "/" + e + "/" + a;
    $.getJSON(l, function(t) {
        if (t) {
            t.length > 0 ? $("#update-time").html(t[0].log_datetime) : $("#update-time").html("-");
            var e = "";
            $.each(t, function(t, a) {
				<?php if($_pmType=="thAQI"){?>
                e += "<tr>", e += '<td><div class="db_name"><a href="<?=base_url()?>' + a.dustboy_uri + '" class="dustboy_link">' + a.dustboy_name + "</a></div></td>", e += '<td class="text-center">' + parseFloat(a.distance).toFixed(1) + "</td>", e += '<td class="text-center"><div class="c_value" style="background-color: rgb(' + a.th_color + ')">' + a.pm25 + "</div></td>", e += "</tr>";
				<?php }else if($_pmType=="usAQI"){?>
				e += "<tr>", e += '<td><div class="db_name"><a href="<?=base_url()?>' + a.dustboy_uri + '" class="dustboy_link">' + a.dustboy_name + "</a></div></td>", e += '<td class="text-center">' + parseFloat(a.distance).toFixed(1) + "</td>", e += '<td class="text-center"><div class="c_value" style="background-color: rgb(' + a.us_color + ')">' + a.pm25 + "</div></td>", e += "</tr>";
				<?php }?>
            }), $(".loader").hide();$("#tblResult").html('<div class="table-responsive"><table id="dbList" class="table table-hover"><thead><tr class="text-center"><th>สถานีเครื่องวัด</th><th width="150">ระยะห่าง(km)</th><th width="100">PM<sub>2.5</sub>(&#x03BC;g/m<sup>3</sup>)</th></thead><tbody>' + e + "</tbody></table></div>"), $("#tblResult").show()
        }
    })
}

$("#btnTable").on("click", function(l) {
	$(".loader").show();
	var array = $('#dustboy').val().split(",");
	getTblResult(array[0],array[1],$('input[name=datatype]:checked').val());
});

/*
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
}*/
</script>