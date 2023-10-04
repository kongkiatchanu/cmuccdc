<?php   defined('BASEPATH') OR exit('No direct script access allowed'); ?>
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
	<?php   $this->load->view('main/analytics');?>
</head>
<body>
    <!-- <div class="btn_contact">
        <div class="stick stick-1"></div>
        <div class="stick stick-2"></div>
        <div class="stick stick-3"></div>
    </div> -->
	<style>
	section#main .main_content .map .card{z-index:999;}
	section#main .main_content .map .card .card-body .detail .detail_time {
    color: #eee;
    font-size: small;
}

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
			<?php   $this->load->view('main/template_header');?>
            <div class="main_content">
                <div class="sub_menu col-12">
					<div class="lang text-left">
                        <a href="javascript:void(0)" lang="thailand" redirect='' class="switch_lang btn btn-secondary btn-sm <?=$_lang=="thailand"?'active':''?>">TH</a>
                        <a href="javascript:void(0)" lang="english" redirect='' class="switch_lang btn btn-secondary btn-sm <?=$_lang=="english"?'active':''?>">EN</a>
                    </div>
                    <div class="aqi">
                        <ul class="nav nav-tabs float-right" id="myTab" role="tablist">
						
							<li class="nav-item">
                                <a class="nav-link switch_type <?=$_pmType=="thAQI"?'active':''?>" sType="thAQI" redirect='' href="javascript:void(0)">TH Index</a>
                            </li>	
                            <li class="nav-item">
                                <a class="nav-link switch_type <?=$_pmType=="usAQI"?'active':''?>" sType="usAQI" redirect='' href="javascript:void(0)">US Index</a>
                            </li>
                        </ul>
                    </div>
                    
                </div>
                <div class="map col-12">
                    <div class="bg_map">
						<div id="us_map" class="fade_in_ture anime_delay05">
						<div id="floating-panel">
							<ul style="display:none;">
							  <li>
								<label>displayValues</label>
								<input id="displayValues" type="checkbox" value="displayValues" checked>
								<output id="displayValuesText" for="displayValues">true</output>
							  </li>
							</ul>
							<span id="data-timer"><img style="max-width:100%" src="<?=base_url()?>template/image/loader.gif"></span>
						</div>
						</div>
						<?php   if($_pmType=="thAQI" || $_pmType=="pm25"){?>
                         <div class="pm_aqi">
                                    <div class="pm fade_in_ture anime_delay1">
                                        <div class="col-2 col-md-7 title_pm_aqi ">PM<sub>2.5</sub><span class="d-none d-md-block">(μg/m<sup>3</sup>)</span></div>
                                        <div class="col-2 col-md-1 detail_pm_aqi" style="background-color: rgb(0, 191, 243);">0-25</div>
                                        <div class="col-2 col-md-1 detail_pm_aqi" style="background-color: rgb(0, 166, 81);">26-37</div>
                                        <div class="col-2 col-md-1 detail_pm_aqi" style="background-color: rgb(255, 242, 0);">38-50</div>
                                        <div class="col-2 col-md-1 detail_pm_aqi" style="background-color: rgb(242, 101, 34);">51-90</div>
                                        <div class="col-2 col-md-1 detail_pm_aqi" style="background-color: rgb(255, 0, 0);">>90</div>
                                    </div>
                                    <div class="aqi fade_in_ture anime_delay15">
                                        <div class="col-2 col-md-7 title_pm_aqi ">TH AQI</div>
                                        <div class="col-2 col-md-1 detail_pm_aqi" style="background-color: rgb(0, 191, 243);">0-25</div>
                                        <div class="col-2 col-md-1 detail_pm_aqi" style="background-color: rgb(0, 166, 81);">26-50</div>
                                        <div class="col-2 col-md-1 detail_pm_aqi" style="background-color: rgb(255, 242, 0);">51-100</div>
                                        <div class="col-2 col-md-1 detail_pm_aqi" style="background-color: rgb(242, 101, 34);">101-200</div>
                                        <div class="col-2 col-md-1 detail_pm_aqi" style="background-color: rgb(255, 0, 0);">>200</div>
                                    </div>
                                </div>
						<?php   }else{?>
						<div class="pm_aqi">
                                    <div class="pm fade_in_ture anime_delay1">
                                        <div class="col col-md-6 title_pm_aqi ">PM<sub>2.5</sub><span class="d-none d-md-block">(μg/m<sup>3</sup>)</span></div>
                                        <div class="col col-md-1 detail_pm_aqi" style="background-color: rgb(0, 153, 107);">0-11.9</div>
                                        <div class="col col-md-1 detail_pm_aqi" style="background-color: rgb(255, 220, 90);">12-35.4</div>
                                        <div class="col col-md-1 detail_pm_aqi" style="background-color: rgb(235, 132, 63);">35.5-55.4</div>
                                        <div class="col col-md-1 detail_pm_aqi" style="background-color: rgb(209, 1, 53);">55.5-150.4</div>
                                        <div class="col col-md-1 detail_pm_aqi" style="background-color: rgb(129, 21, 185);">150.5-250.4</div>
                                        <div class="col col-md-1 detail_pm_aqi" style="background-color: rgb(160, 7, 54);">250.5-500.4</div>
                                    </div>
                                    <div class="aqi fade_in_ture anime_delay15">
                                        <div class="col col-md-6 title_pm_aqi ">US AQI</div>
                                        <div class="col col-md-1 detail_pm_aqi" style="background-color: rgb(0, 153, 107);">0-50</div>
                                        <div class="col col-md-1 detail_pm_aqi" style="background-color: rgb(255, 220, 90);">51-100</div>
                                        <div class="col col-md-1 detail_pm_aqi" style="background-color: rgb(235, 132, 63);">101-150</div>
                                        <div class="col col-md-1 detail_pm_aqi" style="background-color: rgb(209, 1, 53);">151-200</div>
                                        <div class="col col-md-1 detail_pm_aqi" style="background-color: rgb(129, 21, 185);">201-300</div>
                                        <div class="col col-md-1 detail_pm_aqi" style="background-color: rgb(160, 7, 54);">301-500</div>
                                    </div>
                                </div>
						<?php   }?>
                    </div>
					<?php   $this->load->view('main/template_popup');?>
                </div>
            </div>
        </div>
    </section>
	<?php   $this->load->view('main/template_contact');?>

    <script src="<?=base_url()?>template/js/jquery/jquery.min.js"></script>
    <script src="<?=base_url()?>template/js/popper/popper.min.js"></script>
    <script src="<?=base_url()?>template/js/bootstrap-4.3.1/bootstrap.min.js"></script>
    <script src="<?=base_url()?>template/js/main.js?version=signOutzV2z"></script>
	<script src="<?=base_url()?>assets/plugins/leaflet/leaflet.js" ></script>
	<script src="<?=base_url()?>assets/plugins/esri-leaflet/esri-leaflet.js" ></script>
	<script src="<?=base_url()?>assets/plugins/leaflet-velocity_tkws/leaflet-velocity.js"></script>
	<script src="<?=base_url()?>assets/plugins/leaflet-velocity_tkws/IE_workarounds.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/plugins/leafletTimeDimension/iso8601.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/plugins/leafletTimeDimension/leaflet.timedimension.noLayers.src.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/plugins/weather/javascript_vars.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/plugins/weather/javascript_vars_rtofs.js"></script>
	<script src="<?=base_url()?>assets/plugins/leaflet/L.Control.Locate.min.js" charset="utf-8"></script>
	<script src="<?=base_url()?>template/js/apps_dev.js?v=signOutzs"></script>
	<script src="https://labs.easyblog.it/maps/leaflet-search/src/leaflet-search.js"></script>
    <script>$.getJSON("https://www.cmuccdc.org/assets/api/genDustboyGeo.php?token=<?=md5(date('YmdH'))?>",function(db){if(db){var i=0;geojsonOpts={pointToLayer:function(feature,latlng){if(i==0){$('#data-timer').html(convertAVGDateFormat(feature.properties.log_datetime))}
i++;<?php  if($_pmType=="thAQI"){?>return marker=L.marker(latlng,{icon:L.divIcon({className:"my-custom-pin",iconSize:[35,35],html:'<div class="signoutz-marker"style="background-color:rgba('+feature.properties.th_color+', 1)">'+parseInt(feature.properties.pm25).toFixed()+'</div>',})}).on('click',function(e){<?php  if($_lang=="thailand"){?>$('#popupDetail p').html(feature.properties.dustboy_name);<?php }else{?>$('#popupDetail p').html(feature.properties.dustboy_name_en);<?php }?>$('#popupDetail .card-header').css("background-color","rgba("+feature.properties.th_color+", 1)");$('#popupDetail .card-body').css("background-color","rgba("+feature.properties.th_color+", 1)");$('#popupDetail .card-footer').css("background-color","rgba("+feature.properties.th_color+", 1)");$('#popupDetail .number_title').html(parseInt(feature.properties.pm25).toFixed());$('#popupDetail .number_footer').html('μg/m<sup>3</sup>');<?php  if($_lang=="thailand"){?>$('#popupDetail .detail_title').html(feature.properties.th_title);<?php }else{?>$('#popupDetail .detail_title').html(feature.properties.th_title_en);<?php }?>$('#popupDetail .detail_time').html(convertDateFormat(feature.properties.log_datetime));$('#popupDetail .card-body .anime img').attr("src",'/template/image/'+feature.properties.th_dustboy_icon+'.svg');$('#popupDetail .card-footer span.temp').html(feature.properties.temp+' &#8451');$('#popupDetail .card-footer span.humid').html(feature.properties.humid+' %');$('#popupDetail .card-footer span.pm25').html('PM<sub>2.5</sub> '+feature.properties.pm25+' μg/m<sup>3</sup>');$('#popupDetail').show()});<?php }else if($_pmType=="usAQI"){?>return marker=L.marker(latlng,{icon:L.divIcon({className:"my-custom-pin",iconSize:[35,35],html:'<div class="signoutz-marker"style="background-color:rgba('+feature.properties.us_color+', 1)">'+parseInt(feature.properties.pm25).toFixed()+'</div>',})}).on('click',function(e){<?php  if($_lang=="thailand"){?>$('#popupDetail p').html(feature.properties.dustboy_name);<?php }else{?>$('#popupDetail p').html(feature.properties.dustboy_name_en);<?php }?>$('#popupDetail .card-header').css("background-color","rgba("+feature.properties.us_color+", 1)");$('#popupDetail .card-body').css("background-color","rgba("+feature.properties.us_color+", 1)");$('#popupDetail .card-footer').css("background-color","rgba("+feature.properties.us_color+", 1)");$('#popupDetail .number_title').html(parseInt(feature.properties.pm25).toFixed());$('#popupDetail .number_footer').html('μg/m<sup>3</sup>');<?php  if($_lang=="thailand"){?>$('#popupDetail .detail_title').html(feature.properties.us_title);<?php }else{?>$('#popupDetail .detail_title').html(feature.properties.us_title_en);<?php }?>$('#popupDetail .detail_time').html(convertDateFormat(feature.properties.log_datetime));$('#popupDetail .card-body .anime img').attr("src",'/template/image/'+feature.properties.us_dustboy_icon+'.svg');$('#popupDetail .card-footer span.temp').html(feature.properties.temp+' &#8451');$('#popupDetail .card-footer span.humid').html(feature.properties.humid+' %');$('#popupDetail .card-footer span.pm25').html('PM<sub>2.5</sub> '+feature.properties.pm25+' μg/m<sup>3</sup>');$('#popupDetail').show()});<?php }else{?>return marker=L.marker(latlng,{icon:L.divIcon({className:"my-custom-pin",iconSize:[35,35],html:'<div class="signoutz-marker"style="background-color:rgba('+feature.properties.th_color+', 1)">'+parseInt(feature.properties.pm25).toFixed()+'</div>',})}).on('click',function(e){<?php  if($_lang=="thailand"){?>$('#popupDetail p').html(feature.properties.dustboy_name);<?php }else{?>$('#popupDetail p').html(feature.properties.dustboy_name_en);<?php }?>$('#popupDetail .card-header').css("background-color","rgba("+feature.properties.th_color+", 1)");$('#popupDetail .card-body').css("background-color","rgba("+feature.properties.th_color+", 1)");$('#popupDetail .card-footer').css("background-color","rgba("+feature.properties.th_color+", 1)");$('#popupDetail .number_title').html(parseInt(feature.properties.pm25).toFixed());$('#popupDetail .number_footer').html('μg/m<sup>3</sup>');<?php  if($_lang=="thailand"){?>$('#popupDetail .detail_title').html(feature.properties.th_title);<?php }else{?>$('#popupDetail .detail_title').html(feature.properties.th_title_en);<?php }?>$('#popupDetail .detail_time').html(convertDateFormat(feature.properties.log_datetime));$('#popupDetail .card-body .anime img').attr("src",'/template/image/'+feature.properties.th_dustboy_icon+'.svg');$('#popupDetail .card-footer span.temp').html(feature.properties.temp+' &#8451');$('#popupDetail .card-footer span.humid').html(feature.properties.humid+' %');$('#popupDetail .card-footer span.pm25').html('PM<sub>2.5</sub> '+feature.properties.pm25+' μg/m<sup>3</sup>');$('#popupDetail').show()});<?php }?>}};var poiLayers=L.layerGroup([L.geoJson(db,geojsonOpts)]).addTo(map);var searchControl=L.control.search({position:'topright',layer:poiLayers,initial:!1,propertyName:'dustboy_name',zoom:13,buildTip:function(text,val){return'<a href="#">'+text+'</a>'}}).addTo(map)}})</script>
</body>

</html>