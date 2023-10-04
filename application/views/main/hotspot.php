<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$siteInfo['site_title']?></title>
	<meta name="description" content="<?=$siteInfo['site_des']?>">
	<meta name="keywords" content="<?=$siteInfo['site_keyword']?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>template/image/icon_ccdc.ico">
    <link rel="stylesheet" href="<?=base_url()?>template/css/bootstrap-4.3.1/bootstrap.min.css">
    <link rel="stylesheet" href="<?=base_url()?>template/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="<?=base_url()?>template/css/style.min.css?v=<?=date('ymdhis')?>">
    <link rel="stylesheet" href="<?=base_url()?>template/css/popup.css">
	
	<link rel="stylesheet" href="<?=base_url()?>assets/plugins/leaflet/leaflet.css" />
	<link rel="stylesheet" href="<?=base_url()?>assets/plugins/leaflet-velocity_tkws/leaflet-velocity.css" />
	<link rel="stylesheet" href="<?=base_url()?>assets/plugins/leafletTimeDimension/leaflet.timedimension.control.min.css" />
	<?php $this->load->view('main/analytics');?>
</head>
<body>
<style>
	section#main .main_content .map .card .card-body .detail .detail_time {
    color: #eee;
    font-size: small;
}
section#main .main_content .map .card {z-index:9999 !important;}
#floating-panel {
    position: absolute;
    bottom: 10px;
    right: 10px;
    z-index: 10000;
    background-color: #0d374d;
    padding: 2px;
    opacity: .9;
    color: #fff;
    font-family: sans-serif;
    font-weight: 100;
    font-size: x-small
}

#floating-panel #data-timer{
	font-family: 'kanit', sans-serif;
	padding:5px;
}

#floating-panel ul {
    list-style-type: none;
    padding-left: 10px;
    padding-right: 10px
}

#floating-panel ul li>label {
    display: block;
    margin: 2px
}

#floating-panel ul li {
    margin-bottom: 10px
}



.leaflet-container .leaflet-control-search {
	position:relative;
	float:left;
	background:#fff;
	color:#1978cf;
	border: 2px solid rgba(0,0,0,0.2);
	background-clip: padding-box;
	-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
	border-radius: 4px;
	background-color: rgba(255, 255, 255, 0.8);
	z-index:1000;	
	margin-left: 9px;
	margin-top: 9px;
}
.leaflet-control-search.search-exp {/*expanded*/
	background: #fff;
	border: 2px solid rgba(0,0,0,0.2);
	background-clip: padding-box;	
}
.leaflet-control-search .search-input {
	display:block;
	float:left;
	background: #fff;
	border:1px solid #666;
	border-radius:2px;
	height:22px;
	padding:0 20px 0 2px;
	margin:4px 0 4px 4px;
}
.leaflet-control-search.search-load .search-input {
	background: url('/template/image/loader.gif') no-repeat center right #fff;
}
.leaflet-control-search.search-load .search-cancel {
	visibility:hidden;
}
.leaflet-control-search .search-cancel {
	display:block;
	width:22px;
	height:22px;
	position:absolute;
	right:28px;
	margin:4px 0;
	background: url('/template/img/btn-cancel.png?v3') no-repeat center;
	text-decoration:none;
	filter: alpha(opacity=80);
	opacity: 0.8;		
}
.leaflet-control-search .search-cancel:hover {
	filter: alpha(opacity=100);
	opacity: 1;
}
.leaflet-control-search .search-cancel span {
	display:none;/* comment for cancel button imageless */
	font-size:18px;
	line-height:20px;
	color:#ccc;
	font-weight:bold;
}
.leaflet-control-search .search-cancel:hover span {
	color:#aaa;
}
.leaflet-control-search .search-button {
	display:block;
	float:left;
	width:25px;
	height:25px;	
	background: url('/template/img/btn-search.png?v3') no-repeat 4px 4px #fff;
	border-radius:4px;
	margin: 2px 0;
}

.leaflet-control-search .search-tooltip {
	position:absolute;
	top:100%;
	left:0;
	float:left;
	list-style: none;
	padding-left: 0;
	min-width:120px;
	max-height:122px;
	box-shadow: 1px 1px 6px rgba(0,0,0,0.4);
	background-color: rgba(0, 0, 0, 0.25);
	z-index:1010;
	overflow-y:auto;
	overflow-x:hidden;
	cursor: pointer;
}
.leaflet-control-search .search-tip {
	margin:2px;
	padding:2px 4px;
	display:block;
	color:black;
	background: #eee;
	border-radius:.25em;
	text-decoration:none;	
	white-space:nowrap;
	vertical-align:center;
}
.leaflet-control-search .search-button:hover {
	background-color: #f4f4f4;
}
.leaflet-control-search .search-tip-select,
.leaflet-control-search .search-tip:hover {
	background-color: #fff;
}
.leaflet-control-search .search-alert {
	cursor:pointer;
	clear:both;
	font-size:.75em;
	margin-bottom:5px;
	padding:0 .25em;
	color:#e00;
	font-weight:bold;
	border-radius:.25em;
}
#sw_source{
	vertical-align: middle;
    margin: .25rem .1rem;
    padding: 0 .75rem .1rem .75rem;
    border-radius: 15px;
    font-size: .75rem;
    color: #fff;
    background-color: #0c364c;
}
section#main .main_content .sub_menu .aqi {
  width: 70%;
  font-family: 'Kanit', sans-serif;
  font-size: .9rem;
  text-align: right;
}

section#main .main_content .sub_menu .aqi .btn-group {
  width: auto;
}

section#main .main_content .sub_menu .aqi .btn-group .btn {
  color: #ffffff;
  background-color: #0c364c;
  border: none;
  font-size: .75rem;
  font-weight: 600;
  line-height: 1.5;
  text-transform: uppercase;
  border-radius: 50rem !important;
  padding: .25em .65rem .25em 1rem;
}

section#main .main_content .sub_menu .aqi .btn-group .dropdown-menu {
  background-color: #0c364c;
  border: none;
  font-size: .75rem;
  color: #ffffff;
}

section#main .main_content .sub_menu .aqi .btn-group .dropdown-menu .dropdown-item {
  cursor: pointer;
  text-transform: uppercase;
}

section#main .main_content .sub_menu .aqi .btn-group .dropdown-menu .dropdown-item:hover {
  color: #76b7b4;
  background-color: #0c364c;
}

section#main .main_content .sub_menu .aqi .btn-group .dropdown-menu .dropdown-item:active, section#main .main_content .sub_menu .aqi .btn-group .dropdown-menu .dropdown-item.active {
  color: #76b7b4;
  background-color: #0c364c;
}
.fullscreen-icon { background-image: url(/assets/plugins/leaflet.fullscreen-master/icon-fullscreen.png); }
.leaflet-retina .fullscreen-icon { background-image: url(/assets/plugins/leaflet.fullscreen-master/icon-fullscreen-2x.png); background-size: 26px 26px; }
.leaflet-container:-webkit-full-screen { width: 100% !important; height: 100% !important; z-index: 0; }
		.leaflet-container:-ms-fullscreen { width: 100% !important; height: 100% !important; z-index: 0; }
		.leaflet-container:full-screen { width: 100% !important; height: 100% !important; z-index: 0; }
		.leaflet-container:fullscreen { width: 100% !important; height: 100% !important; z-index: 0; }
		.leaflet-pseudo-fullscreen { position: fixed !important; width: 100% !important; height: 100% !important; top: 0px !important; left: 0px !important; z-index: 0; }
		
		.legend {
  font-size: 10px !important;
  bottom: 5%;
  position: absolute;
  right: 16px;
  width: 160px;
  background: rgba(0, 0, 0, 0.5);
  z-index: 999;
}

.legend .legend-color {
  width: 20%;
}

.legend .legend-name {
  width: 80%;
  text-align: left;
  color: #ffffff;
}

.table {
  z-index: 1;
  position: relative;
  margin-bottom: 0;
}
.table.hourly {
  background-color: #fff;
}
.table-head {
  border-top: 1px solid #f4f4f6;
  border-bottom: 2px solid #f4f4f6;
  font-family: RSUBold, sans-serif;
  font-size: 14px;
  margin-bottom: 5px;
}
.table-head .table-column {
  line-height: 1;
}
.table-head .table-column:first-of-type {
  align-items: center;
  display: flex;
  text-align: left;
}
.table-row {
  display: flex;
  justify-content: space-between;
}
.table-row:first-of-type {
  text-align: left;
}
.table-column {
  min-height: 30px;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 5px;
}
.table-column:first-of-type {
  text-align: left;
  flex-basis: 50%;
  font-size: 14px;
  justify-content: flex-start;
  white-space: nowrap;
  text-overflow: ellipsis;
  display: block;
  overflow: hidden;
}
.table-column:nth-of-type(2) {
  flex-basis: 70%;
}
.table-column:nth-of-type(3),
.table-column:nth-of-type(4) {
  flex-basis: 10%;
  text-align: center;
}

	#boxpage{position: absolute;
z-index: 98999;
background: rgba(0, 0, 0, 0.5);
font-size: 18px;
font-family: 'Kanit', sans-serif;
color: #fff;
padding: 10px;
left: 16px;
bottom: 5%;}

.signoutz-hotspot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
}
	</style>
    <div id="btn_contact">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
    <section id="main">
        <div class="container-fluid">
			<?php $this->load->view('main/template_header');?>
            <div class="main_content">
                <div class="sub_menu col-12">
					<div class="lang text-left">
                        <a href="javascript:void(0)" class="btn btn-locations btn-secondary btn-sm active">24Hr</a>
                        <a href="javascript:void(0)" class="btn btn-locations btn-secondary btn-sm">48Hr</a>
                        <!--<a href="javascript:void(0)" class="btn btn-locations btn-secondary btn-sm">7D</a>-->
						<button type="button" class="btn btn-sm btn-search" style="margin-right: 10px;" data-toggle="modal" data-target="#searchModel"><i class="fa fa-filter"></i></button>
						
                    </div>
                    <div class="aqi">
						<div class="btn-group">
							<button id="sw_source" class="btn dropdown-toggle shadow-drop-bottom-sub_menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> TERAA/AQUA</button>
							<div class="dropdown-menu dropdown-menu-right shadow-drop-bottom-sub_menu">
								<a class="dropdown-item btn-type" data_index="TERAA/AQUA">TERAA/AQUA</a>					
								<a class="dropdown-item btn-type" data_index="S-NPP">VIIRS S-NPP</a>
								<a class="dropdown-item btn-type" data_index="NOAA-20">VIIRS NOAA20</a>
							</div>
						</div>
					</div>
                </div>
				<?php $today = date('Y-m-d');?>
				<input type="hidden" id="date24" value="1">
				<input type="hidden" id="date48" value="2">
				<input type="hidden" id="date7D" value="7">
				<input type="hidden" id="dateEnd" value="<?=$today?>">
                <div class="map col-12">
                     <div class="bg_map">
						<div id="us_map" class="fade_in_ture anime_delay05" style="height: 70vh;">
							
						<div id="boxpage"> 
							<span id="pagename">แสดงจุดความร้อนทั้งหมดในประเทศ </span><span id="hotspot_count"><img src="/template/img/loader.gif"></span>	
						</div>
						
						<div id="popupDetail" style="color:#fff;display:none;" class="card col-12 col-lg-3 offset-lg-4 fade_in_ture anime_delay025">
							<div class="card-header" style="background-color: rgb(0, 191, 243);">
								<h3 class="mt-3 mb-0 text-center card-title" style="width:100%"></h3><button class="btn btn-sm btn-close"><i class="fas fa-times"></i></button> 
							</div>
							<div class="card-body" style="background-color: rgb(0, 191, 243);border-radius: 0 0 .75rem .75rem;">
								
								<div class="detail card-description">
									<div class="row mb-1">	
										<div class="col-3 text-right">ที่อยู่</div>
										<div class="col-9 text-left"><span id="des"></span></div>
									</div>
									<div class="row mb-1">	
										<div class="col-3 text-right">พิกัด</div>
										<div class="col-9 text-left"><span id="latlon"></span></div>
									</div>
									<div class="row mb-1">	
										<div class="col-3 text-right">ความสว่าง</div>
										<div class="col-9 text-left"><span id="s_brightness"></span></div>
									</div>
									<div class="row mb-1">	
										<div class="col-3 text-right">ความเชื่อมั่น</div>
										<div class="col-9 text-left"><span id="s_confidence"></span></div>
									</div>
									<div class="row mb-1">	
										<div class="col-3 text-right">เวอร์ชั่น</div>
										<div class="col-9 text-left"><span id="s_version"></span></div>
									</div>
									<div class="row mb-1">	
										<div class="col-3 text-right">เวลา</div>
										<div class="col-9 text-left"><span id="s_time"></span></div>
									</div>
								</div>
							</div>
						</div>

						<!--<div class="legend"><div class="table"><div class="table-footer"><div class="table-row"><div class="m-1 p-1 legend-color" style="background-color: rgb(0, 255, 64);"></div><div class="p-1 legend-name">ป่าอนุรักษ์</div></div><div class="table-row"><div class="m-1 p-1 legend-color" style="background-color: rgb(70, 140, 0);"></div><div class="p-1 legend-name">ป่าสงวนแห่งชาติ</div></div><div class="table-row"><div class="m-1 p-1 legend-color" style="background-color: rgb(255, 0, 255);"></div><div class="p-1 legend-name">เขตสปก</div></div><div class="table-row"><div class="m-1 p-1 legend-color" style="background-color: rgb(128, 0, 0);"></div><div class="p-1 legend-name">พื้นที่เกษตร</div></div><div class="table-row"><div class="m-1 p-1 legend-color" style="background-color: rgb(192, 192, 192);"></div><div class="p-1 legend-name">พื้นที่ริมทางหลวง(50 เมตร)</div></div><div class="table-row"><div class="m-1 p-1 legend-color" style="background-color: rgb(194, 195, 190);"></div><div class="p-1 legend-name">ชุมชนและอื่นๆ</div></div><div class="table-row"><div class="m-1 p-1 legend-color" style="background-color: rgb(51, 51, 51);"></div><div class="p-1 legend-name">จุดความร้อนนอกประเทศ</div></div></div></div></div>-->
						</div>
                    </div>
                </div>
				
            </div>
        </div>
    </section>
	<div class="modal fade" id="searchModel" tabindex="-1" role="dialog"  aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="searchModelLabel">เลือกจังหวัด</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<select class="form-control mb-3" id="select-search" size="10">
				<option value=""> - เลือกจังหวัดทั้งหมด - </option>
			</select>
			<p class="text-center">
				<button type="button" class="btn btn-sm btn-search btn-success"> เลือก </button>
			</p>
		  </div>
		</div>
	  </div>
	</div>
	<?php $this->load->view('main/template_contact');?>

    <script src="<?=base_url()?>template/js/jquery/jquery.min.js"></script>
    <script src="<?=base_url()?>template/js/popper/popper.min.js"></script>
    <script src="<?=base_url()?>template/js/bootstrap-4.3.1/bootstrap.min.js"></script>
    
	<script src="<?=base_url()?>assets/plugins/leaflet/leaflet.js" ></script>
	<script src="<?=base_url()?>assets/plugins/esri-leaflet/esri-leaflet.js" ></script>

	
    <script>
		var osmUrl = "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
		osmAttrib = 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
		opacity = 1,
		OpenStreetMap = new L.tileLayer(osmUrl, {
			maxZoom: 18,
			attribution: osmAttrib,
			opacity: opacity
		}),
		Topographic = new L.esri.basemapLayer("Topographic", {
			opacity: opacity
		}),
		Streets = new L.esri.basemapLayer("Streets", {
			opacity: opacity
		}),
		NationalGeographic = new L.esri.basemapLayer("NationalGeographic", {
			opacity: opacity
		}),
		Oceans = new L.esri.basemapLayer("Oceans", {
			opacity: opacity
		}),
		Gray = new L.esri.basemapLayer("Gray", {
			opacity: opacity
		}),
		DarkGray = new L.esri.basemapLayer("DarkGray"),
		Imagery = new L.esri.basemapLayer("Imagery");
		
		var map = new L.map("us_map", {
			center: [13.912, 100.5270061],
			zoom: 5,
			attributionControl: !1,
			maxZoom: 17,
			minZoom: 5,
			fullscreenControl: true,
			layers: [OpenStreetMap],
		}),
		baseMaps = {
			OpenStreetMap: OpenStreetMap,
			DarkGray: DarkGray,
		},
		
		
		layerControl = new L.control.layers(baseMaps);
		layerControl.addTo(map);
		
		var config = {
			hotspot_type : 'TERAA/AQUA',
			province_sel : null,
			province_all : [],
			currentHeatMap : [],
			hotspot_all : {},
			Hotspot_province : {},
			date_start : null,
			date_end : null,
			markers: [],
		}
		
		config.date_start = $('#date24').val();
		config.date_end = $('#dateEnd').val()

		$( document ).ready(function() {
			
			function loadSelectData(){
				$.getJSON("/assets/php/region_pwa.json", function(db) {
					config.province_all = db;
					if(db){
						var html = '<option value=""> - เลือกจังหวัดทั้งหมด - </option>';
						for (let index = 0; index < db.length; index++) {
							html+='<optgroup label="'+db[index].zone_name_th+'">';
							if(db[index].provinces.length>0){
								for (let index2 = 0; index2 < db[index].provinces.length; index2++) {
									html+='<option value="'+db[index].provinces[index2].province_code+'">'+db[index].provinces[index2].province_name_th+'</option>';
								}
							}
							html+='</optgroup>';
						}
						$('#select-search').html(html);
					}
				});
			}
			
			loadData();
			loadSelectData();
			
	
			$('.btn-search').on('click',function(){
				var id = $('#select-search').val();
				if(id){
					config.province_sel=id;
				}else{
					config.province_sel=null;
				}
				loadData();
				$("#searchModel").modal('hide');
			});
	
			$('.btn-type').on('click',function(){
				var type = $(this).attr("data_index");
				$('#sw_source').html(type);
				config.hotspot_type =type;
				loadData();
			});
			$('.btn-locations').on('click',function(){
		
				$('.btn-locations').removeClass("active");
				$(this).addClass("active");
				if($(this).html().trim()=="48Hr"){
					config.date_start = $('#date48').val();
				}else if($(this).html().trim()=="48Hr"){
					config.date_start = $('#date24').val();
				}else{
					config.date_start = $('#date7D').val();
				}
				loadData();
			})
			
			function loadData(){
				$('#popupDetail').hide();
				config.hotspot_all = '';
				var uri = "/assets/api/getHotspot.php?key=<?=md5(date('ymd'))?>&type=all&times="+config.date_start+"&query=<?=md5(date('his'))?>&s="+config.hotspot_type;
				if(config.province_sel){	
					uri = "/assets/api/getHotspot.php?key=<?=md5(date('ymd'))?>&type=allz&times="+config.date_start+"&pv="+config.province_sel+"&query=<?=md5(date('his'))?>&s="+config.hotspot_type;
					$('#pagename').html('แสดงจุดความร้อน จังหวัด'+getProvinceName(config.province_sel));
				}
				$.getJSON(uri, function(db) {
					
					if(db){
						if(config.hotspot_type == 'MODIS'){
							config.hotspot_all = db;
						}else{
							config.hotspot_all = db;
						}
						createHotspot();
					}
				});
				
			}
			
			function getProvinceName(id){
				for (let index = 0; index < config.province_all.length; index++) {
					for (let index2 = 0; index2 < config.province_all[index].provinces.length; index2++) {
						if(config.province_all[index].provinces[index2].province_code==id){
							return config.province_all[index].provinces[index2].province_name_th
						}
					}
				}
			}
	
			
			function createHotspot(){
				$('#hotspot_count').html('<img src="/template/img/loader.gif">');
				var hotspots = config.hotspot_all.features;
				
				for (var index = 0; index < config.markers.length; index++) {
					var marker = config.markers[index];
					map.removeLayer(marker);
				}
				config.markers = [];
				
				$('#hotspot_count').html(' ทั้งหมด '+hotspots.length+' จุด' );
				for (let index = 0; index < config.hotspot_all.features.length; index++) {
					console.log(hotspots[index].properties.source);
					let marker = L.marker(
						[hotspots[index].properties.latitude, hotspots[index].properties.longitude],
						{
						  icon: L.divIcon({
							className: "my-custom-icon",
							iconSize: [10, 10],
							html: '<div class="signoutz-hotspot" style="background-color:rgba(255,80,0, 1)"></div>',
						  }),
						}
					  );
					  marker.on("click", () => {
						config.currentHeatMap = hotspots[index].properties;
						createPopup()
					  });
					  marker.addTo(map);
					  config.markers.push(marker);
				}
			}
			
			function createPopup(){
				const satellitez = [];
				satellitez['T'] = 'TERAA';
				satellitez['A'] = 'AQUA';
				satellitez['N'] = 'S-NPP';
				satellitez['1'] = 'NOAA-20';
				
				var feature= config.currentHeatMap;
				console.log(feature);
				
				/*
				brightness
				scan
				track
				confidence
				version
				frp*/
				
				$('#popupDetail .card-header').css("background-color", "rgba(255, 39, 39, 1)");				
				$('#popupDetail .card-body').css("background-color", "rgba(255, 39, 39,  1)");				
				$('#popupDetail .btn-close').css("background-color", "rgba(255, 39, 39,  1)");				
				$('#popupDetail .card-title').html(satellitez[feature.satellite]);		
				$('#popupDetail .card-description #des').html('ตำบล'+feature.tb_tn+' อำเภอ'+feature.ap_tn+' จังหวัด'+feature.pv_tn);				
				$('#popupDetail .card-description #latlon').html(feature.latitude+', '+feature.longitude);				
				$('#popupDetail #s_brightness').html(feature.brightness);				
				$('#popupDetail #s_confidence').html(feature.confidence+'%');				
				$('#popupDetail #s_version').html(feature.version);				
				$('#popupDetail #s_time').html(feature.acq_time_lmt);				

				$('#popupDetail').show();
					
			}
			
			function getUpdateTime(text, format){
				var _text = text.split("T");
				if(format=="date_format"){
					return _text[0];
				}else{
					return _text[1].substring(0,5);
				}
			}
	
	
			$('.btn-close').on('click', function () {
				$('.card').hide();
			});
			$('#btn_contact').on('click', function () {
				$(this).toggleClass('open');
				if ($(this).is('.open')) {
					$('#main').addClass('fade_out');
					$('#main').removeClass('fade_in');
					$('#contact').removeClass('fade_out');
					$('#contact').addClass('fade_in');
					$('footer').addClass('fade_out');
					$('footer').removeClass('fade_in');
					if ($('#menu_slide').length <= 0) {
						$('#menu_slide').removeClass('out_slide');
						$('#menu_slide').hide();
					}
					if($('.content').length > 0){
						$('#main').hide();$('#contact').show();
					}
					if ($(window).width() <= 575.98 && $('.content').length <= 0) {
						$('body').css('overflow', 'auto');
					}
					if ($(window).scrollTop() >= 115) {
						$('#menu_slide').addClass('out_slide');
						$('#menu_slide').removeClass('in_slide');
						$('#btn_contact').addClass('out_slide_btn');
						$('#btn_contact').removeClass('in_slide_btn');
					}
				} else if (!$(this).is('.open')) {
					$('#contact').addClass('fade_out');
					$('#contact').removeClass('fade_in');
					$('#main').removeClass('fade_out');
					$('#main').addClass('fade_in');
					$('footer').removeClass('fade_out');
					$('footer').addClass('fade_in');
					if ($('#menu_slide').length <= 0) {
						$('#menu_slide').addClass('frist');
						$('#menu_slide').show();
					}
					if($('.content').length > 0){
						$('#main').show();$('#contact').hide();
					}
					if ($(window).width() <= 575.98 && $('.content').length <= 0) {
						$('body').css('overflow', 'hidden');
					}
					if ($(window).scrollTop() >= 115) {
						$('#menu_slide').addClass('in_slide');
						$('#menu_slide').removeClass('out_slide');
						$('#btn_contact').addClass('in_slide_btn');
						$('#btn_contact').removeClass('out_slide_btn');
					}
				}
			});
			var window_top = $(window).scrollTop();
			if (window_top >= 115) {
				if ($('#menu_slide').is('.frist')) $('#menu_slide').removeClass('frist');
				if (!$('#btn_contact').is('.open')) {
					$('#menu_slide').addClass('in_slide');
					$('#menu_slide').removeClass('out_slide');
					$('#btn_contact').addClass('in_slide_btn');
					$('#btn_contact').removeClass('out_slide_btn');
				}
			} else {
				if ($('#btn_contact').is('.open')) {
					$('#menu_slide').removeClass('in_slide');
					$('#btn_contact').removeClass('in_slide_btn');
				}
				if (!$('#menu_slide').is('.frist') && !$('#btn_contact').is('.open')) {
					$('#menu_slide').addClass('out_slide');
					$('#menu_slide').removeClass('in_slide');
					$('#btn_contact').addClass('out_slide_btn');
					$('#btn_contact').removeClass('in_slide_btn');
				}
			}
			$(window).scroll(function () {
				var check_scroll = $(window).scrollTop();
				if ($(window).width() > 992) {
					if (check_scroll >= 115) {
						if ($('#menu_slide').is('.frist')) $('#menu_slide').removeClass('frist');
						if (!$('#btn_contact').is('.open')) {
							$('#menu_slide').addClass('in_slide');
							$('#menu_slide').removeClass('out_slide');
							$('#btn_contact').addClass('in_slide_btn');
							$('#btn_contact').removeClass('out_slide_btn');
						}
					} else {
						if ($('#btn_contact').is('.open')) {
							$('#menu_slide').removeClass('in_slide');
							$('#btn_contact').removeClass('in_slide_btn');
						}
						if (!$('#menu_slide').is('.frist') && !$('#btn_contact').is('.open')) {
							$('#menu_slide').addClass('out_slide');
							$('#menu_slide').removeClass('in_slide');
							$('#btn_contact').addClass('out_slide_btn');
							$('#btn_contact').removeClass('in_slide_btn');
						}
					}
				}
			});
		});
	
	
	</script>
</body>

</html>