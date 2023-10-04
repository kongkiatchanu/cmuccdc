<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?= $siteInfo['site_title'] ?></title>
	<meta name="description" content="<?= $siteInfo['site_des'] ?>">
	<meta name="keywords" content="<?= $siteInfo['site_keyword'] ?>">
	<link rel="shortcut icon" type="image/x-icon" href="<?= base_url() ?>template/image/icon_ccdc.ico">
	<link rel="stylesheet" href="<?= base_url() ?>template/css/bootstrap-4.3.1/bootstrap.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>template/fontawesome/css/all.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>template/css/style.min.css?v=<?= date('ymdhis') ?>">
	<link rel="stylesheet" href="<?= base_url() ?>template/css/popup.css">
	
	<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/leaflet/leaflet.css" />
	<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/leaflet-velocity_tkws/leaflet-velocity.css" />
	<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/leafletTimeDimension/leaflet.timedimension.control.min.css" />
	<?php $this->load->view('main/analytics'); ?>
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
		
		.signoutz-hotspot {
			width: 10px;
			height: 10px;
			border-radius: 50%;
		}
		.legend{font-size:10px!important;bottom:25px;position:absolute;right:0px;width:160px;background:rgba(0,0,0,.5)}.legend .legend-color{width:20%}.legend .legend-name{width:80%;text-align:left;color:#fff}
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
			<?php $this->load->view('main/template_header'); ?>
			<div class="main_content">
				<div class="sub_menu col-12">
					<div class="lang text-left">
						<a href="javascript:void(0)" lang="thailand" redirect='' class="switch_lang btn btn-secondary btn-sm <?= $_lang == "thailand" ? 'active' : '' ?>">TH</a>
						<a href="javascript:void(0)" lang="english" redirect='' class="switch_lang btn btn-secondary btn-sm <?= $_lang == "english" ? 'active' : '' ?>">EN</a>
					</div>
					<?php

					$ar = array(
						'th-hr' => 'Th (Hourly)',
						'us-hr' => 'Us (Hourly)',
						'th-dy' => 'Th (Daily)',
						'us-dy' => 'Us (Daily)',
					); ?>
					<div class="aqi">
						<div class="btn-group">
							<button id="sw_source" class="btn dropdown-toggle shadow-drop-bottom-sub_menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?= $this->input->cookie('data_index', true) != null ? $ar[$this->input->cookie('data_index', true)] : $ar['th-hr'] ?></button>
							<div class="dropdown-menu dropdown-menu-right shadow-drop-bottom-sub_menu">
								<a class="dropdown-item switch_type2 <?= $this->input->cookie('data_index', true) == "th-hr" ? 'active' : '' ?>" data_index="th-hr">Th (Hourly)</a>					
								<a class="dropdown-item switch_type2 <?= $this->input->cookie('data_index', true) == "th-dy" ? 'active' : '' ?>" data_index="th-dy">Th (Daily)</a>
								<a class="dropdown-item switch_type2 <?= $this->input->cookie('data_index', true) == "us-hr" ? 'active' : '' ?>" data_index="us-hr">Us (Hourly)</a>
								<a class="dropdown-item switch_type2 <?= $this->input->cookie('data_index', true) == "us-dy" ? 'active' : '' ?>" data_index="us-dy">Us (Daily)</a>
							</div>
						</div>
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
							<div class="legend" style="display:none"><div class="table"><div class="table-footer"><div class="table-row"><div class="m-1 p-1 legend-color" style="background-color: rgb(0, 255, 64);"></div><div class="p-1 legend-name">ป่าอนุรักษ์</div></div><div class="table-row"><div class="m-1 p-1 legend-color" style="background-color: rgb(70, 140, 0);"></div><div class="p-1 legend-name">ป่าสงวนแห่งชาติ</div></div><div class="table-row"><div class="m-1 p-1 legend-color" style="background-color: rgb(255, 0, 255);"></div><div class="p-1 legend-name">เขตสปก</div></div><div class="table-row"><div class="m-1 p-1 legend-color" style="background-color: rgb(128, 0, 0);"></div><div class="p-1 legend-name">พื้นที่เกษตร</div></div><div class="table-row"><div class="m-1 p-1 legend-color" style="background-color: rgb(192, 192, 192);"></div><div class="p-1 legend-name">พื้นที่ริมทางหลวง(50 เมตร)</div></div><div class="table-row"><div class="m-1 p-1 legend-color" style="background-color: rgb(194, 195, 190);"></div><div class="p-1 legend-name">ชุมชนและอื่นๆ</div></div><div class="table-row"><div class="m-1 p-1 legend-color" style="background-color: rgb(51, 51, 51);"></div><div class="p-1 legend-name">จุดความร้อนนอกประเทศ</div></div></div></div></div>
							<span id="data-timer">loading...</span>
						</div>
						</div>
						<?php if ($this->input->cookie('data_index', true) == null || $this->input->cookie('data_index', true) == "th-hr") { ?>
									<div id="th_index"></div>
						<?php } else if ($this->input->cookie('data_index', true) == "th-dy") { ?>
											<div id="th_index_daily"></div>
						<?php } else if ($this->input->cookie('data_index', true) == "us-hr") { ?>
													<div id="us_index"></div>
						<?php } else if ($this->input->cookie('data_index', true) == "us-dy") { ?>
															<div id="us_index_daily"></div>
						<?php } ?>
					</div>
					<?php $this->load->view('main/template_popup'); ?>
					<div id="popupHotspot" style="color:#fff;display:none;" class="card col-12 col-lg-3 offset-lg-4 fade_in_ture anime_delay025"><div class="card-header" style="background-color: rgb(0, 191, 243);"><h3 class="mb-0 text-center card-title" style="width:100%">สำนักงาน ทต.บ้านฉาง จ.ระยอง</h3><h5 class="text-center" style="width:100%"><small>ค่าความเชื่อมั่น</small></h5><button class="btn btn-sm btn-close"><i class="fas fa-times"></i></button> </div><div class="card-body" style="background-color: rgb(0, 191, 243);border-radius: 0 0 .75rem .75rem;"><div class="detail card-description col-lg-12"><p id="des">ตำบลวงฆ้อง อำเภอวงฆ้อง</p><p id="latlon">17.1326084137, 100.119041443</p><p><i class="far fa-calendar-alt"></i> <span id="datadate">2021-11-29<span> <i class="far fa-clock"></i> <span id="datatime">11:27</span></p></div></div></div>
				</div>
			</div>
		</div>
	</section>
	<input type="hidden" id="hotspot_s" value="<?= date('Y-m-d', strtotime($today . ' -1 day')) ?>"/>
	<input type="hidden" id="hotspot_e" value="<?= date('Y-m-d') ?>"/>
	<?php $this->load->view('main/template_contact'); ?>

	<script src="<?= base_url() ?>template/js/jquery/jquery.min.js"></script>
	<script src="<?= base_url() ?>template/js/popper/popper.min.js"></script>
	<script src="<?= base_url() ?>template/js/bootstrap-4.3.1/bootstrap.min.js"></script>
	
	<script src="<?= base_url() ?>assets/plugins/leaflet/leaflet.js" ></script>
	<script src="<?= base_url() ?>assets/plugins/esri-leaflet/esri-leaflet.js" ></script>
	<script src="<?= base_url() ?>assets/plugins/leaflet-velocity_tkws/leaflet-velocity.js"></script>
	
	<script src="https://unpkg.com/georaster"></script>
	<script src="https://unpkg.com/proj4"></script>
	<script src="https://unpkg.com/georaster-layer-for-leaflet/georaster-layer-for-leaflet.browserify.min.js"></script>
	<!--<script src="<?= base_url() ?>assets/plugins/leaflet.fullscreen-master/Control.FullScreen.js"></script>
	
	<script>
var data_lang = '<?= $_lang ?>';
var token = '<?= md5(date("YmdH")) ?>';
</script>
<script src="<?= base_url() ?>template/js/ccdc_app.js?=3"></script>-->
	<script>
	var vmap = '<?= $vmap_file ?>';
	var vmap_us = '<?= $vmap_file_us ?>';
	var data_lang = '<?= $_lang ?>';
	var token = '<?= md5(date("YmdH")) ?>';
	/*for IE*/
	Object.assign||Object.defineProperty(Object,"assign",{enumerable:!1,configurable:!0,writable:!0,value:function(t){"use strict";if(null==t)throw new TypeError("Cannot convert first argument to object");for(var e=Object(t),r=1;r<arguments.length;r++){var n=arguments[r];if(null!=n){n=Object(n);for(var i=Object.keys(Object(n)),o=0,s=i.length;o<s;o++){var c=i[o],b=Object.getOwnPropertyDescriptor(n,c);void 0!==b&&b.enumerable&&(e[c]=n[c])}}}return e}}),String.prototype.endsWith||(String.prototype.endsWith=function(t,e){return(void 0===e||e>this.length)&&(e=this.length),this.substring(e-t.length,e)===t});
	
	/*TimeDimesnsion*/
	(function(b){function f(a,j){var b=j?j:!1,c=[2,3,4,5,7,8,9],e=[0,0,0,0,0,0,0],f=[0,12,4,7,24,60,60],h;if(a=a.toUpperCase()){if("string"!==typeof a)throw Error("Invalid iso8601 period string '"+a+"'");}else return e;if(h=/^P((\d+Y)?(\d+M)?(\d+W)?(\d+D)?)?(T(\d+H)?(\d+M)?(\d+S)?)?$/.exec(a))for(var d=0;d<c.length;d++){var k=c[d];e[d]=h[k]?+h[k].replace(/[A-Za-z]+/g,""):0}else throw Error("String '"+a+"' is not a valid ISO8601 period.");if(b)for(d=e.length-1;0<d;d--)e[d]>=f[d]&&(e[d-1]+=Math.floor(e[d]/
f[d]),e[d]%=f[d]);return e}b.iso8601||(b.iso8601={});b.iso8601.Period||(b.iso8601.Period={});b.iso8601.version="0.2";b.iso8601.Period.parse=function(a,b){return f(a,b)};b.iso8601.Period.parseToTotalSeconds=function(a){var b=[31104E3,2592E3,604800,86400,3600,60,1];a=f(a);for(var g=0,c=0;c<a.length;c++)g+=a[c]*b[c];return g};b.iso8601.Period.isValid=function(a){try{return f(a),!0}catch(b){return!1}};b.iso8601.Period.parseToString=function(a,b,g,c){var e="      ".split(" ");a=f(a,c);b||(b="year month week day hour minute second".split(" "));
g||(g="years months weeks days hours minutes seconds".split(" "));for(c=0;c<a.length;c++)0<a[c]&&(e[c]=1==a[c]?a[c]+" "+b[c]:a[c]+" "+g[c]);return e.join(" ").trim().replace(/[ ]{2,}/g," ")}})(window.nezasa=window.nezasa||{});

	L.TimeDimension=(L.Layer||L.Class).extend({includes:L.Evented||L.Mixin.Events,initialize:function(i){L.setOptions(this,i),this._availableTimes=this._generateAvailableTimes(),this._currentTimeIndex=-1,this._loadingTimeIndex=-1,this._loadingTimeout=this.options.loadingTimeout||3e3,this._syncedLayers=[],this._availableTimes.length>0&&this.setCurrentTime(this.options.currentTime||this._getDefaultCurrentTime()),this.options.lowerLimitTime&&this.setLowerLimit(this.options.lowerLimitTime),this.options.upperLimitTime&&this.setUpperLimit(this.options.upperLimitTime)},getAvailableTimes:function(){return this._availableTimes},getCurrentTimeIndex:function(){return-1===this._currentTimeIndex?this._availableTimes.length-1:this._currentTimeIndex},getCurrentTime:function(){var i=-1;return(i=-1!==this._loadingTimeIndex?this._loadingTimeIndex:this.getCurrentTimeIndex())>=0?this._availableTimes[i]:null},isLoading:function(){return-1!==this._loadingTimeIndex},setCurrentTimeIndex:function(i){var t=this._upperLimit||this._availableTimes.length-1,e=this._lowerLimit||0;if(!((i=Math.min(Math.max(e,i),t))<0)){this._loadingTimeIndex=i;var s=this._availableTimes[i];this._checkSyncedLayersReady(this._availableTimes[this._loadingTimeIndex])?this._newTimeIndexLoaded():(this.fire("timeloading",{time:s}),setTimeout(function(i){i==this._loadingTimeIndex&&this._newTimeIndexLoaded()}.bind(this,i),this._loadingTimeout))}},_newTimeIndexLoaded:function(){if(-1!==this._loadingTimeIndex){var i=this._availableTimes[this._loadingTimeIndex];this._currentTimeIndex=this._loadingTimeIndex,this.fire("timeload",{time:i}),this._loadingTimeIndex=-1}},_checkSyncedLayersReady:function(i){for(var t=0,e=this._syncedLayers.length;t<e;t++)if(this._syncedLayers[t].isReady&&!this._syncedLayers[t].isReady(i))return!1;return!0},setCurrentTime:function(i){var t=this._seekNearestTimeIndex(i);this.setCurrentTimeIndex(t)},seekNearestTime:function(i){var t=this._seekNearestTimeIndex(i);return this._availableTimes[t]},nextTime:function(i,t){i||(i=1);var e=this._currentTimeIndex,s=this._upperLimit||this._availableTimes.length-1,n=this._lowerLimit||0;this._loadingTimeIndex>-1&&(e=this._loadingTimeIndex),(e+=i)>s&&(e=t?n:s),e<n&&(e=t?s:n),this.setCurrentTimeIndex(e)},prepareNextTimes:function(i,t,e){i||(i=1);var s=this._currentTimeIndex,n=s;this._loadingTimeIndex>-1&&(s=this._loadingTimeIndex);for(var a=0,o=this._syncedLayers.length;a<o;a++)this._syncedLayers[a].setMinimumForwardCache&&this._syncedLayers[a].setMinimumForwardCache(t);for(var r=t,h=this._upperLimit||this._availableTimes.length-1,l=this._lowerLimit||0;r>0;){if((s+=i)>h){if(!e)break;s=l}if(s<l){if(!e)break;s=h}if(n===s)break;this.fire("timeloading",{time:this._availableTimes[s]}),r--}},getNumberNextTimesReady:function(i,t,e){i||(i=1);var s=this._currentTimeIndex;this._loadingTimeIndex>-1&&(s=this._loadingTimeIndex);for(var n=t,a=0,o=this._upperLimit||this._availableTimes.length-1,r=this._lowerLimit||0;n>0;){if((s+=i)>o){if(!e){n=0,a=t;break}s=r}if(s<r){if(!e){n=0,a=t;break}s=o}var h=this._availableTimes[s];this._checkSyncedLayersReady(h)&&a++,n--}return a},previousTime:function(i,t){this.nextTime(-1*i,t)},registerSyncedLayer:function(i){this._syncedLayers.push(i),i.on("timeload",this._onSyncedLayerLoaded,this)},unregisterSyncedLayer:function(i){var t=this._syncedLayers.indexOf(i);-1!=t&&this._syncedLayers.splice(t,1),i.off("timeload",this._onSyncedLayerLoaded,this)},_onSyncedLayerLoaded:function(i){i.time==this._availableTimes[this._loadingTimeIndex]&&this._checkSyncedLayersReady(i.time)&&this._newTimeIndexLoaded()},_generateAvailableTimes:function(){if(this.options.times)return L.TimeDimension.Util.parseTimesExpression(this.options.times);if(this.options.timeInterval){var i=L.TimeDimension.Util.parseTimeInterval(this.options.timeInterval),t=this.options.period||"P1D",e=this.options.validTimeRange||void 0;return L.TimeDimension.Util.explodeTimeRange(i[0],i[1],t,e)}return[]},_getDefaultCurrentTime:function(){var i=this._seekNearestTimeIndex((new Date).getTime());return this._availableTimes[i]},_seekNearestTimeIndex:function(i){for(var t=0,e=this._availableTimes.length;t<e&&!(i<this._availableTimes[t]);t++);return t>0&&t--,t},setAvailableTimes:function(i,t){var e=this.getCurrentTime(),s=this.getLowerLimit(),n=this.getUpperLimit();if("extremes"==t){var a=this.options.period||"P1D";this._availableTimes=L.TimeDimension.Util.explodeTimeRange(new Date(i[0]),new Date(i[i.length-1]),a)}else{var o=L.TimeDimension.Util.parseTimesExpression(i);if(0===this._availableTimes.length)this._availableTimes=o;else if("intersect"==t)this._availableTimes=L.TimeDimension.Util.intersect_arrays(o,this._availableTimes);else if("union"==t)this._availableTimes=L.TimeDimension.Util.union_arrays(o,this._availableTimes);else{if("replace"!=t)throw"Merge available times mode not implemented: "+t;this._availableTimes=o}}s&&this.setLowerLimit(s),n&&this.setUpperLimit(n),this.setCurrentTime(e),this.fire("availabletimeschanged",{availableTimes:this._availableTimes,currentTime:e})},getLowerLimit:function(){return this._availableTimes[this.getLowerLimitIndex()]},getUpperLimit:function(){return this._availableTimes[this.getUpperLimitIndex()]},setLowerLimit:function(i){var t=this._seekNearestTimeIndex(i);this.setLowerLimitIndex(t)},setUpperLimit:function(i){var t=this._seekNearestTimeIndex(i);this.setUpperLimitIndex(t)},setLowerLimitIndex:function(i){this._lowerLimit=Math.min(Math.max(i||0,0),this._upperLimit||this._availableTimes.length-1),this.fire("limitschanged",{lowerLimit:this._lowerLimit,upperLimit:this._upperLimit})},setUpperLimitIndex:function(i){this._upperLimit=Math.max(Math.min(i,this._availableTimes.length-1),this._lowerLimit||0),this.fire("limitschanged",{lowerLimit:this._lowerLimit,upperLimit:this._upperLimit})},getLowerLimitIndex:function(){return this._lowerLimit},getUpperLimitIndex:function(){return this._upperLimit}}),L.Map.addInitHook(function(){this.options.timeDimension&&(this.timeDimension=L.timeDimension(this.options.timeDimensionOptions||{}))}),L.timeDimension=function(i){return new L.TimeDimension(i)},L.TimeDimension.Util={getTimeDuration:function(i){if("undefined"==typeof nezasa)throw"iso8601-js-period library is required for Leatlet.TimeDimension: https://github.com/nezasa/iso8601-js-period";return nezasa.iso8601.Period.parse(i,!0)},addTimeDuration:function(i,t,e){void 0===e&&(e=!0),("string"==typeof t||t instanceof String)&&(t=this.getTimeDuration(t));var s=t.length,n=e?"getUTC":"get",a=e?"setUTC":"set";s>0&&0!=t[0]&&i[a+"FullYear"](i[n+"FullYear"]()+t[0]),s>1&&0!=t[1]&&i[a+"Month"](i[n+"Month"]()+t[1]),s>2&&0!=t[2]&&i[a+"Date"](i[n+"Date"]()+7*t[2]),s>3&&0!=t[3]&&i[a+"Date"](i[n+"Date"]()+t[3]),s>4&&0!=t[4]&&i[a+"Hours"](i[n+"Hours"]()+t[4]),s>5&&0!=t[5]&&i[a+"Minutes"](i[n+"Minutes"]()+t[5]),s>6&&0!=t[6]&&i[a+"Seconds"](i[n+"Seconds"]()+t[6])},subtractTimeDuration:function(i,t,e){("string"==typeof t||t instanceof String)&&(t=this.getTimeDuration(t));for(var s=[],n=0,a=t.length;n<a;n++)s.push(-t[n]);this.addTimeDuration(i,s,e)},parseAndExplodeTimeRange:function(i){var t=i.split("/"),e=new Date(Date.parse(t[0])),s=new Date(Date.parse(t[1])),n=t.length>2?t[2]:"P1D";return this.explodeTimeRange(e,s,n)},explodeTimeRange:function(i,t,e,s){var n=this.getTimeDuration(e),a=[],o=new Date(i.getTime()),r=null,h=null,l=null,m=null;if(void 0!==s){var u=s.split("/");r=u[0].split(":")[0],h=u[0].split(":")[1],l=u[1].split(":")[0],m=u[1].split(":")[1]}for(;o<t;)(void 0===s||o.getUTCHours()>=r&&o.getUTCHours()<=l)&&(o.getUTCHours()!=r||o.getUTCMinutes()>=h)&&(o.getUTCHours()!=l||o.getUTCMinutes()<=m)&&a.push(o.getTime()),this.addTimeDuration(o,n);return o>=t&&a.push(t.getTime()),a},parseTimeInterval:function(i){var t=i.split("/");if(2!=t.length)throw"Incorrect ISO9601 TimeInterval: "+i;var e=Date.parse(t[0]),s=null,n=null;return isNaN(e)?(n=this.getTimeDuration(t[0]),s=Date.parse(t[1]),e=new Date(s),this.subtractTimeDuration(e,n,!0),s=new Date(s)):(s=Date.parse(t[1]),isNaN(s)?(n=this.getTimeDuration(t[1]),s=new Date(e),this.addTimeDuration(s,n,!0)):s=new Date(s),e=new Date(e)),[e,s]},parseTimesExpression:function(i){var t=[];if(!i)return t;if("string"==typeof i||i instanceof String)for(var e,s,n=i.split(","),a=0,o=n.length;a<o;a++)3==(e=n[a]).split("/").length?t=t.concat(this.parseAndExplodeTimeRange(e)):(s=Date.parse(e),isNaN(s)||t.push(s));else t=i;return t.sort(function(i,t){return i-t})},intersect_arrays:function(i,t){for(var e=i.slice(0),s=t.slice(0),n=[];e.length>0&&s.length>0;)e[0]<s[0]?e.shift():e[0]>s[0]?s.shift():(n.push(e.shift()),s.shift());return n},union_arrays:function(i,t){for(var e=i.slice(0),s=t.slice(0),n=[];e.length>0&&s.length>0;)e[0]<s[0]?n.push(e.shift()):e[0]>s[0]?n.push(s.shift()):(n.push(e.shift()),s.shift());return e.length>0?n=n.concat(e):s.length>0&&(n=n.concat(s)),n}},L.TimeDimension.Player=(L.Layer||L.Class).extend({includes:L.Evented||L.Mixin.Events,initialize:function(i,t){L.setOptions(this,i),this._timeDimension=t,this._paused=!1,this._buffer=this.options.buffer||5,this._minBufferReady=this.options.minBufferReady||1,this._waitingForBuffer=!1,this._loop=this.options.loop||!1,this._steps=1,this._timeDimension.on("timeload",function(i){this.release(),this._waitingForBuffer=!1}.bind(this)),this.setTransitionTime(this.options.transitionTime||1e3),this._timeDimension.on("limitschanged availabletimeschanged timeload",function(i){this._timeDimension.prepareNextTimes(this._steps,this._minBufferReady,this._loop)}.bind(this))},_tick:function(){var i=this._getMaxIndex(),t=this._timeDimension.getCurrentTimeIndex()>=i&&this._steps>0,e=0==this._timeDimension.getCurrentTimeIndex()&&this._steps<0;if((t||e)&&!this._loop)return this.pause(),this.stop(),void this.fire("animationfinished");if(!this._paused){var s=0,n=this._bufferSize;if(this._minBufferReady>0)if(s=this._timeDimension.getNumberNextTimesReady(this._steps,n,this._loop),this._waitingForBuffer){if(s<n)return void this.fire("waiting",{buffer:n,available:s});this.fire("running"),this._waitingForBuffer=!1}else if(s<this._minBufferReady)return this._waitingForBuffer=!0,this._timeDimension.prepareNextTimes(this._steps,n,this._loop),void this.fire("waiting",{buffer:n,available:s});this.pause(),this._timeDimension.nextTime(this._steps,this._loop),n>0&&this._timeDimension.prepareNextTimes(this._steps,n,this._loop)}},_getMaxIndex:function(){return Math.min(this._timeDimension.getAvailableTimes().length-1,this._timeDimension.getUpperLimitIndex()||1/0)},start:function(i){this._intervalID||(this._steps=i||1,this._waitingForBuffer=!1,this.options.startOver&&this._timeDimension.getCurrentTimeIndex()===this._getMaxIndex()&&this._timeDimension.setCurrentTimeIndex(this._timeDimension.getLowerLimitIndex()||0),this.release(),this._intervalID=window.setInterval(L.bind(this._tick,this),this._transitionTime),this._tick(),this.fire("play"),this.fire("running"))},stop:function(){this._intervalID&&(clearInterval(this._intervalID),this._intervalID=null,this._waitingForBuffer=!1,this.fire("stop"))},pause:function(){this._paused=!0},release:function(){this._paused=!1},getTransitionTime:function(){return this._transitionTime},isPlaying:function(){return!!this._intervalID},isWaiting:function(){return this._waitingForBuffer},isLooped:function(){return this._loop},setLooped:function(i){this._loop=i,this.fire("loopchange",{loop:i})},setTransitionTime:function(i){this._transitionTime=i,"function"==typeof this._buffer?this._bufferSize=this._buffer.call(this,this._transitionTime,this._minBufferReady,this._loop):this._bufferSize=this._buffer,this._intervalID&&(this.stop(),this.start(this._steps)),this.fire("speedchange",{transitionTime:i,buffer:this._bufferSize})},getSteps:function(){return this._steps}}),L.UI=L.ui=L.UI||{},L.UI.Knob=L.Draggable.extend({options:{className:"knob",step:1,rangeMin:0,rangeMax:10},initialize:function(i,t){L.setOptions(this,t),this._element=L.DomUtil.create("div",this.options.className||"knob",i),L.Draggable.prototype.initialize.call(this,this._element,this._element),this._container=i,this.on("predrag",function(){this._newPos.y=0,this._newPos.x=this._adjustX(this._newPos.x)},this),this.on("dragstart",function(){L.DomUtil.addClass(i,"dragging")}),this.on("dragend",function(){L.DomUtil.removeClass(i,"dragging")}),L.DomEvent.on(this._element,"dblclick",function(i){this.fire("dblclick",i)},this),L.DomEvent.disableClickPropagation(this._element),this.enable()},_getProjectionCoef:function(){return(this.options.rangeMax-this.options.rangeMin)/(this._container.offsetWidth||this._container.style.width)},_update:function(){this.setPosition(L.DomUtil.getPosition(this._element).x)},_adjustX:function(i){var t=this._toValue(i)||this.getMinValue();return this._toX(this._adjustValue(t))},_adjustValue:function(i){return i=Math.max(this.getMinValue(),Math.min(this.getMaxValue(),i)),i-=this.options.rangeMin,i=Math.round(i/this.options.step)*this.options.step,i+=this.options.rangeMin,i=Math.round(100*i)/100},_toX:function(i){return(i-this.options.rangeMin)/this._getProjectionCoef()},_toValue:function(i){return i*this._getProjectionCoef()+this.options.rangeMin},getMinValue:function(){return this.options.minValue||this.options.rangeMin},getMaxValue:function(){return this.options.maxValue||this.options.rangeMax},setStep:function(i){this.options.step=i,this._update()},setPosition:function(i){L.DomUtil.setPosition(this._element,L.point(this._adjustX(i),0)),this.fire("positionchanged")},getPosition:function(){return L.DomUtil.getPosition(this._element).x},setValue:function(i){this.setPosition(this._toX(i))},getValue:function(){return this._adjustValue(this._toValue(this.getPosition()))}}),L.Control.TimeDimension=L.Control.extend({options:{styleNS:"leaflet-control-timecontrol",position:"bottomleft",title:"Time Control",backwardButton:!0,forwardButton:!0,playButton:!0,playReverseButton:!1,loopButton:!1,displayDate:!0,timeSlider:!0,timeSliderDragUpdate:!1,limitSliders:!1,limitMinimumRange:5,speedSlider:!0,minSpeed:.1,maxSpeed:10,speedStep:.1,timeSteps:1,autoPlay:!1,playerOptions:{transitionTime:1e3}},initialize:function(i){L.Control.prototype.initialize.call(this,i),this._dateUTC=!0,this._timeDimension=this.options.timeDimension||null},onAdd:function(i){var t;return this._map=i,!this._timeDimension&&i.timeDimension&&(this._timeDimension=i.timeDimension),this._initPlayer(),t=L.DomUtil.create("div","leaflet-bar leaflet-bar-horizontal leaflet-bar-timecontrol"),this.options.backwardButton&&(this._buttonBackward=this._createButton("Backward",t)),this.options.playReverseButton&&(this._buttonPlayReversePause=this._createButton("Play Reverse",t)),this.options.playButton&&(this._buttonPlayPause=this._createButton("Play",t)),this.options.forwardButton&&(this._buttonForward=this._createButton("Forward",t)),this.options.loopButton&&(this._buttonLoop=this._createButton("Loop",t)),this.options.displayDate&&(this._displayDate=this._createButton("Date",t)),this.options.timeSlider&&(this._sliderTime=this._createSliderTime(this.options.styleNS+" timecontrol-slider timecontrol-dateslider",t)),this.options.speedSlider&&(this._sliderSpeed=this._createSliderSpeed(this.options.styleNS+" timecontrol-slider timecontrol-speed",t)),this._steps=this.options.timeSteps||1,this._timeDimension.on("timeload",this._update,this),this._timeDimension.on("timeload",this._onPlayerStateChange,this),this._timeDimension.on("timeloading",this._onTimeLoading,this),this._timeDimension.on("limitschanged availabletimeschanged",this._onTimeLimitsChanged,this),L.DomEvent.disableClickPropagation(t),t},addTo:function(){return L.Control.prototype.addTo.apply(this,arguments),this._onPlayerStateChange(),this._onTimeLimitsChanged(),this._update(),this},onRemove:function(){this._player.off("play stop running loopchange speedchange",this._onPlayerStateChange,this),this._player.off("waiting",this._onPlayerWaiting,this),this._timeDimension.off("timeload",this._update,this),this._timeDimension.off("timeload",this._onPlayerStateChange,this),this._timeDimension.off("timeloading",this._onTimeLoading,this),this._timeDimension.off("limitschanged availabletimeschanged",this._onTimeLimitsChanged,this)},_initPlayer:function(){this._player||(this.options.player?this._player=this.options.player:this._player=new L.TimeDimension.Player(this.options.playerOptions,this._timeDimension)),this.options.autoPlay&&this._player.start(this._steps),this._player.on("play stop running loopchange speedchange",this._onPlayerStateChange,this),this._player.on("waiting",this._onPlayerWaiting,this),this._onPlayerStateChange()},_onTimeLoading:function(i){i.time==this._timeDimension.getCurrentTime()&&this._displayDate&&L.DomUtil.addClass(this._displayDate,"loading")},_onTimeLimitsChanged:function(){var i=this._timeDimension.getLowerLimitIndex(),t=this._timeDimension.getUpperLimitIndex(),e=this._timeDimension.getAvailableTimes().length-1;this._limitKnobs&&(this._limitKnobs[0].options.rangeMax=e,this._limitKnobs[1].options.rangeMax=e,this._limitKnobs[0].setValue(i||0),this._limitKnobs[1].setValue(t||e)),this._sliderTime&&(this._sliderTime.options.rangeMax=e,this._sliderTime._update())},_onPlayerWaiting:function(i){this._buttonPlayPause&&this._player.getSteps()>0&&(L.DomUtil.addClass(this._buttonPlayPause,"loading"),this._buttonPlayPause.innerHTML=this._getDisplayLoadingText(i.available,i.buffer)),this._buttonPlayReversePause&&this._player.getSteps()<0&&(L.DomUtil.addClass(this._buttonPlayReversePause,"loading"),this._buttonPlayReversePause.innerHTML=this._getDisplayLoadingText(i.available,i.buffer))},_onPlayerStateChange:function(){if(this._buttonPlayPause&&(this._player.isPlaying()&&this._player.getSteps()>0?(L.DomUtil.addClass(this._buttonPlayPause,"pause"),L.DomUtil.removeClass(this._buttonPlayPause,"play")):(L.DomUtil.removeClass(this._buttonPlayPause,"pause"),L.DomUtil.addClass(this._buttonPlayPause,"play")),this._player.isWaiting()&&this._player.getSteps()>0?L.DomUtil.addClass(this._buttonPlayPause,"loading"):(this._buttonPlayPause.innerHTML="",L.DomUtil.removeClass(this._buttonPlayPause,"loading"))),this._buttonPlayReversePause&&(this._player.isPlaying()&&this._player.getSteps()<0?L.DomUtil.addClass(this._buttonPlayReversePause,"pause"):L.DomUtil.removeClass(this._buttonPlayReversePause,"pause"),this._player.isWaiting()&&this._player.getSteps()<0?L.DomUtil.addClass(this._buttonPlayReversePause,"loading"):(this._buttonPlayReversePause.innerHTML="",L.DomUtil.removeClass(this._buttonPlayReversePause,"loading"))),this._buttonLoop&&(this._player.isLooped()?L.DomUtil.addClass(this._buttonLoop,"looped"):L.DomUtil.removeClass(this._buttonLoop,"looped")),this._sliderSpeed&&!this._draggingSpeed){var i=this._player.getTransitionTime()||1e3;i=Math.round(1e4/i)/10,this._sliderSpeed.setValue(i)}},_update:function(){if(this._timeDimension)if(this._timeDimension.getCurrentTimeIndex()>=0){var i=new Date(this._timeDimension.getCurrentTime());this._displayDate&&(L.DomUtil.removeClass(this._displayDate,"loading"),this._displayDate.innerHTML=this._getDisplayDateFormat(i)),this._sliderTime&&!this._slidingTimeSlider&&this._sliderTime.setValue(this._timeDimension.getCurrentTimeIndex())}else this._displayDate&&(this._displayDate.innerHTML=this._getDisplayNoTimeError())},_createButton:function(i,t){var e=L.DomUtil.create("a",this.options.styleNS+" timecontrol-"+i.toLowerCase(),t);return e.href="#",e.title=i,L.DomEvent.addListener(e,"click",L.DomEvent.stopPropagation).addListener(e,"click",L.DomEvent.preventDefault).addListener(e,"click",this["_button"+i.replace(/ /i,"")+"Clicked"],this),e},_createSliderTime:function(i,t){var e,s,n,a,o;return e=L.DomUtil.create("div",i,t),s=L.DomUtil.create("div","slider",e),n=this._timeDimension.getAvailableTimes().length-1,this.options.limitSliders&&(o=this._limitKnobs=this._createLimitKnobs(s)),(a=new L.UI.Knob(s,{className:"knob main",rangeMin:0,rangeMax:n})).on("dragend",function(i){var t=i.target.getValue();this._sliderTimeValueChanged(t),this._slidingTimeSlider=!1},this),a.on("drag",function(i){this._slidingTimeSlider=!0;var t=this._timeDimension.getAvailableTimes()[i.target.getValue()];if(t){var e=new Date(t);this._displayDate&&(this._displayDate.innerHTML=this._getDisplayDateFormat(e)),this.options.timeSliderDragUpdate&&this._sliderTimeValueChanged(i.target.getValue())}},this),a.on("predrag",function(){var i,t;o&&(i=o[0].getPosition(),t=o[1].getPosition(),this._newPos.x<i&&(this._newPos.x=i),this._newPos.x>t&&(this._newPos.x=t))},a),L.DomEvent.on(s,"click",function(i){if(!L.DomUtil.hasClass(i.target,"knob")){var t=i.touches&&1===i.touches.length?i.touches[0]:i,e=L.DomEvent.getMousePosition(t,s).x;o?o[0].getPosition()<=e&&e<=o[1].getPosition()&&(a.setPosition(e),this._sliderTimeValueChanged(a.getValue())):(a.setPosition(e),this._sliderTimeValueChanged(a.getValue()))}},this),a.setPosition(0),a},_createLimitKnobs:function(i){L.DomUtil.addClass(i,"has-limits");var t=this._timeDimension.getAvailableTimes().length-1,e=L.DomUtil.create("div","range",i),s=new L.UI.Knob(i,{className:"knob lower",rangeMin:0,rangeMax:t}),n=new L.UI.Knob(i,{className:"knob upper",rangeMin:0,rangeMax:t});return L.DomUtil.setPosition(e,0),s.setPosition(0),n.setPosition(t),s.on("dragend",function(i){var t=i.target.getValue();this._sliderLimitsValueChanged(t,n.getValue())},this),n.on("dragend",function(i){var t=i.target.getValue();this._sliderLimitsValueChanged(s.getValue(),t)},this),s.on("drag positionchanged",function(){L.DomUtil.setPosition(e,L.point(s.getPosition(),0)),e.style.width=n.getPosition()-s.getPosition()+"px"},this),n.on("drag positionchanged",function(){e.style.width=n.getPosition()-s.getPosition()+"px"},this),n.on("predrag",function(){var i=s._toX(s.getValue()+this.options.limitMinimumRange);n._newPos.x<=i&&(n._newPos.x=i)},this),s.on("predrag",function(){var i=n._toX(n.getValue()-this.options.limitMinimumRange);s._newPos.x>=i&&(s._newPos.x=i)},this),s.on("dblclick",function(){this._timeDimension.setLowerLimitIndex(0)},this),n.on("dblclick",function(){this._timeDimension.setUpperLimitIndex(this._timeDimension.getAvailableTimes().length-1)},this),[s,n]},_createSliderSpeed:function(i,t){var e=L.DomUtil.create("div",i,t),s=L.DomUtil.create("span","speed",e),n=L.DomUtil.create("div","slider",e),a=Math.round(1e4/(this._player.getTransitionTime()||1e3))/10;s.innerHTML=this._getDisplaySpeed(a);var o=new L.UI.Knob(n,{step:this.options.speedStep,rangeMin:this.options.minSpeed,rangeMax:this.options.maxSpeed});return o.on("dragend",function(i){var t=i.target.getValue();this._draggingSpeed=!1,s.innerHTML=this._getDisplaySpeed(t),this._sliderSpeedValueChanged(t)},this),o.on("drag",function(i){this._draggingSpeed=!0,s.innerHTML=this._getDisplaySpeed(i.target.getValue())},this),o.on("positionchanged",function(i){s.innerHTML=this._getDisplaySpeed(i.target.getValue())},this),L.DomEvent.on(n,"click",function(i){if(i.target!==o._element){var t=i.touches&&1===i.touches.length?i.touches[0]:i,e=L.DomEvent.getMousePosition(t,n).x;o.setPosition(e),s.innerHTML=this._getDisplaySpeed(o.getValue()),this._sliderSpeedValueChanged(o.getValue())}},this),o},_buttonBackwardClicked:function(){this._timeDimension.previousTime(this._steps)},_buttonForwardClicked:function(){this._timeDimension.nextTime(this._steps)},_buttonLoopClicked:function(){this._player.setLooped(!this._player.isLooped())},_buttonPlayClicked:function(){this._player.isPlaying()?this._player.stop():this._player.start(this._steps)},_buttonPlayReverseClicked:function(){this._player.isPlaying()?this._player.stop():this._player.start(-1*this._steps)},_buttonDateClicked:function(){this._toggleDateUTC()},_sliderTimeValueChanged:function(i){this._timeDimension.setCurrentTimeIndex(i)},_sliderLimitsValueChanged:function(i,t){this._timeDimension.setLowerLimitIndex(i),this._timeDimension.setUpperLimitIndex(t)},_sliderSpeedValueChanged:function(i){this._player.setTransitionTime(1e3/i)},_toggleDateUTC:function(){this._dateUTC?(L.DomUtil.removeClass(this._displayDate,"utc"),this._displayDate.title="Local Time"):(L.DomUtil.addClass(this._displayDate,"utc"),this._displayDate.title="UTC Time"),this._dateUTC=!this._dateUTC,this._update()},_getDisplayDateFormat:function(i){return this._dateUTC?i.toISOString():i.toLocaleString()},_getDisplaySpeed:function(i){return i+"fps"},_getDisplayLoadingText:function(i,t){return"<span>"+Math.floor(i/t*100)+"%</span>"},_getDisplayNoTimeError:function(){return"Time not available"}}),L.Map.addInitHook(function(){this.options.timeDimensionControl&&(this.timeDimensionControl=L.control.timeDimension(this.options.timeDimensionControlOptions||{}),this.addControl(this.timeDimensionControl))}),L.control.timeDimension=function(i){return new L.Control.TimeDimension(i)};
	/*weather vars*/
	var GFS_server_year=2019,GFS_server_month=12,GFS_server_day=23,GFS_server_hour=18,GFS_timesteps=81,GFS_interval=3,WAVE_timesteps=61,WAVE_interval=3,RTOFS_server_year=2019,RTOFS_server_month=12,RTOFS_server_day=23,RTOFS_server_hour=0,RTOFS_timesteps=65,RTOFS_interval=3;
	/**
	 * Minified by jsDelivr using Terser v3.14.1.
	 * Original file: /npm/leaflet.locatecontrol@0.68.0/src/L.Control.Locate.js
	 * 
	 * Do NOT use SRI with dynamically generated files! More information: https://www.jsdelivr.com/using-sri-with-dynamic-files
	 */
	!function(t,i){"function"==typeof define&&define.amd?define(["leaflet"],t):"object"==typeof exports&&(void 0!==i&&i.L?module.exports=t(L):module.exports=t(require("leaflet"))),void 0!==i&&i.L&&(i.L.Control.Locate=t(L))}(function(t){var i=function(i,o,s){(s=s.split(" ")).forEach(function(s){t.DomUtil[i].call(this,o,s)})},o=function(t,o){i("addClass",t,o)},s=function(t,o){i("removeClass",t,o)},e=t.Marker.extend({initialize:function(i,o){t.Util.setOptions(this,o),this._latlng=i,this.createIcon()},createIcon:function(){var i=this.options,o="";void 0!==i.color&&(o+="stroke:"+i.color+";"),void 0!==i.weight&&(o+="stroke-width:"+i.weight+";"),void 0!==i.fillColor&&(o+="fill:"+i.fillColor+";"),void 0!==i.fillOpacity&&(o+="fill-opacity:"+i.fillOpacity+";"),void 0!==i.opacity&&(o+="opacity:"+i.opacity+";");var s=this._getIconSVG(i,o);this._locationIcon=t.divIcon({className:s.className,html:s.svg,iconSize:[s.w,s.h]}),this.setIcon(this._locationIcon)},_getIconSVG:function(t,i){var o=t.radius,s=o+t.weight,e=2*s;return{className:"leaflet-control-locate-location",svg:'<svg xmlns="http://www.w3.org/2000/svg" width="'+e+'" height="'+e+'" version="1.1" viewBox="-'+s+" -"+s+" "+e+" "+e+'"><circle r="'+o+'" style="'+i+'" /></svg>',w:e,h:e}},setStyle:function(i){t.Util.setOptions(this,i),this.createIcon()}}),n=e.extend({initialize:function(i,o,s){t.Util.setOptions(this,s),this._latlng=i,this._heading=o,this.createIcon()},setHeading:function(t){this._heading=t},_getIconSVG:function(t,i){var o=t.radius,s=t.width+t.weight,e=2*(o+t.depth+t.weight),n="M0,0 l"+t.width/2+","+t.depth+" l-"+s+",0 z";return{className:"leaflet-control-locate-heading",svg:'<svg xmlns="http://www.w3.org/2000/svg" width="'+s+'" height="'+e+'" version="1.1" viewBox="-'+s/2+" 0 "+s+" "+e+'" style="'+("transform: rotate("+this._heading+"deg)")+'"><path d="'+n+'" style="'+i+'" /></svg>',w:s,h:e}}}),a=t.Control.extend({options:{position:"topleft",layer:void 0,setView:"untilPanOrZoom",keepCurrentZoomLevel:!1,getLocationBounds:function(t){return t.bounds},flyTo:!1,clickBehavior:{inView:"stop",outOfView:"setView",inViewNotFollowing:"inView"},returnToPrevBounds:!1,cacheLocation:!0,drawCircle:!0,drawMarker:!0,showCompass:!0,markerClass:e,compassClass:n,circleStyle:{className:"leaflet-control-locate-circle",color:"#136AEC",fillColor:"#136AEC",fillOpacity:.15,weight:0},markerStyle:{className:"leaflet-control-locate-marker",color:"#fff",fillColor:"#2A93EE",fillOpacity:1,weight:3,opacity:1,radius:9},compassStyle:{fillColor:"#2A93EE",fillOpacity:1,weight:0,color:"#fff",opacity:1,radius:9,width:9,depth:6},followCircleStyle:{},followMarkerStyle:{},followCompassStyle:{},icon:"fa fa-map-marker",iconLoading:"fa fa-spinner fa-spin",iconElementTag:"span",circlePadding:[0,0],metric:!0,createButtonCallback:function(i,o){var s=t.DomUtil.create("a","leaflet-bar-part leaflet-bar-part-single",i);return s.title=o.strings.title,{link:s,icon:t.DomUtil.create(o.iconElementTag,o.icon,s)}},onLocationError:function(t,i){alert(t.message)},onLocationOutsideMapBounds:function(t){t.stop(),alert(t.options.strings.outsideMapBoundsMsg)},showPopup:!0,strings:{title:"Show me where I am",metersUnit:"meters",feetUnit:"feet",popup:"You are within {distance} {unit} from this point",outsideMapBoundsMsg:"You seem located outside the boundaries of the map"},locateOptions:{maxZoom:1/0,watch:!0,setView:!1}},initialize:function(i){for(var o in i)"object"==typeof this.options[o]?t.extend(this.options[o],i[o]):this.options[o]=i[o];this.options.followMarkerStyle=t.extend({},this.options.markerStyle,this.options.followMarkerStyle),this.options.followCircleStyle=t.extend({},this.options.circleStyle,this.options.followCircleStyle),this.options.followCompassStyle=t.extend({},this.options.compassStyle,this.options.followCompassStyle)},onAdd:function(i){var o=t.DomUtil.create("div","leaflet-control-locate leaflet-bar leaflet-control");this._layer=this.options.layer||new t.LayerGroup,this._layer.addTo(i),this._event=void 0,this._compassHeading=null,this._prevBounds=null;var s=this.options.createButtonCallback(o,this.options);return this._link=s.link,this._icon=s.icon,t.DomEvent.on(this._link,"click",t.DomEvent.stopPropagation).on(this._link,"click",t.DomEvent.preventDefault).on(this._link,"click",this._onClick,this).on(this._link,"dblclick",t.DomEvent.stopPropagation),this._resetVariables(),this._map.on("unload",this._unload,this),o},_onClick:function(){this._justClicked=!0;var t=this._isFollowing();if(this._userPanned=!1,this._userZoomed=!1,this._active&&!this._event)this.stop();else if(this._active&&void 0!==this._event){var i=this.options.clickBehavior,o=i.outOfView;switch(this._map.getBounds().contains(this._event.latlng)&&(o=t?i.inView:i.inViewNotFollowing),i[o]&&(o=i[o]),o){case"setView":this.setView();break;case"stop":if(this.stop(),this.options.returnToPrevBounds)(this.options.flyTo?this._map.flyToBounds:this._map.fitBounds).bind(this._map)(this._prevBounds)}}else this.options.returnToPrevBounds&&(this._prevBounds=this._map.getBounds()),this.start();this._updateContainerStyle()},start:function(){this._activate(),this._event&&(this._drawMarker(this._map),this.options.setView&&this.setView()),this._updateContainerStyle()},stop:function(){this._deactivate(),this._cleanClasses(),this._resetVariables(),this._removeMarker()},stopFollowing:function(){this._userPanned=!0,this._updateContainerStyle(),this._drawMarker()},_activate:function(){if(!this._active&&(this._map.locate(this.options.locateOptions),this._active=!0,this._map.on("locationfound",this._onLocationFound,this),this._map.on("locationerror",this._onLocationError,this),this._map.on("dragstart",this._onDrag,this),this._map.on("zoomstart",this._onZoom,this),this._map.on("zoomend",this._onZoomEnd,this),this.options.showCompass)){var i="ondeviceorientationabsolute"in window;if(i||"ondeviceorientation"in window){var o=this,s=function(){t.DomEvent.on(window,i?"deviceorientationabsolute":"deviceorientation",o._onDeviceOrientation,o)};DeviceOrientationEvent&&"function"==typeof DeviceOrientationEvent.requestPermission?DeviceOrientationEvent.requestPermission().then(function(t){"granted"===t&&s()}):s()}}},_deactivate:function(){this._map.stopLocate(),this._active=!1,this.options.cacheLocation||(this._event=void 0),this._map.off("locationfound",this._onLocationFound,this),this._map.off("locationerror",this._onLocationError,this),this._map.off("dragstart",this._onDrag,this),this._map.off("zoomstart",this._onZoom,this),this._map.off("zoomend",this._onZoomEnd,this),this.options.showCompass&&(this._compassHeading=null,"ondeviceorientationabsolute"in window?t.DomEvent.off(window,"deviceorientationabsolute",this._onDeviceOrientation,this):"ondeviceorientation"in window&&t.DomEvent.off(window,"deviceorientation",this._onDeviceOrientation,this))},setView:function(){if(this._drawMarker(),this._isOutsideMapBounds())this._event=void 0,this.options.onLocationOutsideMapBounds(this);else if(this.options.keepCurrentZoomLevel){(i=this.options.flyTo?this._map.flyTo:this._map.panTo).bind(this._map)([this._event.latitude,this._event.longitude])}else{var i=this.options.flyTo?this._map.flyToBounds:this._map.fitBounds;this._ignoreEvent=!0,i.bind(this._map)(this.options.getLocationBounds(this._event),{padding:this.options.circlePadding,maxZoom:this.options.locateOptions.maxZoom}),t.Util.requestAnimFrame(function(){this._ignoreEvent=!1},this)}},_drawCompass:function(){if(this._event){var t=this._event.latlng;if(this.options.showCompass&&t&&null!==this._compassHeading){var i=this._isFollowing()?this.options.followCompassStyle:this.options.compassStyle;this._compass?(this._compass.setLatLng(t),this._compass.setHeading(this._compassHeading),this._compass.setStyle&&this._compass.setStyle(i)):this._compass=new this.options.compassClass(t,this._compassHeading,i).addTo(this._layer)}!this._compass||this.options.showCompass&&null!==this._compassHeading||(this._compass.removeFrom(this._layer),this._compass=null)}},_drawMarker:function(){void 0===this._event.accuracy&&(this._event.accuracy=0);var i,o,s=this._event.accuracy,e=this._event.latlng;if(this.options.drawCircle){var n=this._isFollowing()?this.options.followCircleStyle:this.options.circleStyle;this._circle?this._circle.setLatLng(e).setRadius(s).setStyle(n):this._circle=t.circle(e,s,n).addTo(this._layer)}if(this.options.metric?(i=s.toFixed(0),o=this.options.strings.metersUnit):(i=(3.2808399*s).toFixed(0),o=this.options.strings.feetUnit),this.options.drawMarker){var a=this._isFollowing()?this.options.followMarkerStyle:this.options.markerStyle;this._marker?(this._marker.setLatLng(e),this._marker.setStyle&&this._marker.setStyle(a)):this._marker=new this.options.markerClass(e,a).addTo(this._layer)}this._drawCompass();var h=this.options.strings.popup;this.options.showPopup&&h&&this._marker&&this._marker.bindPopup(t.Util.template(h,{distance:i,unit:o}))._popup.setLatLng(e),this.options.showPopup&&h&&this._compass&&this._compass.bindPopup(t.Util.template(h,{distance:i,unit:o}))._popup.setLatLng(e)},_removeMarker:function(){this._layer.clearLayers(),this._marker=void 0,this._circle=void 0},_unload:function(){this.stop(),this._map.off("unload",this._unload,this)},_setCompassHeading:function(i){!isNaN(parseFloat(i))&&isFinite(i)?(i=Math.round(i),this._compassHeading=i,t.Util.requestAnimFrame(this._drawCompass,this)):this._compassHeading=null},_onCompassNeedsCalibration:function(){this._setCompassHeading()},_onDeviceOrientation:function(t){this._active&&(t.webkitCompassHeading?this._setCompassHeading(t.webkitCompassHeading):t.absolute&&t.alpha&&this._setCompassHeading(360-t.alpha))},_onLocationError:function(t){3==t.code&&this.options.locateOptions.watch||(this.stop(),this.options.onLocationError(t,this))},_onLocationFound:function(t){if((!this._event||this._event.latlng.lat!==t.latlng.lat||this._event.latlng.lng!==t.latlng.lng||this._event.accuracy!==t.accuracy)&&this._active){switch(this._event=t,this._drawMarker(),this._updateContainerStyle(),this.options.setView){case"once":this._justClicked&&this.setView();break;case"untilPan":this._userPanned||this.setView();break;case"untilPanOrZoom":this._userPanned||this._userZoomed||this.setView();break;case"always":this.setView()}this._justClicked=!1}},_onDrag:function(){this._event&&!this._ignoreEvent&&(this._userPanned=!0,this._updateContainerStyle(),this._drawMarker())},_onZoom:function(){this._event&&!this._ignoreEvent&&(this._userZoomed=!0,this._updateContainerStyle(),this._drawMarker())},_onZoomEnd:function(){this._event&&this._drawCompass(),this._event&&!this._ignoreEvent&&this._marker&&!this._map.getBounds().pad(-.3).contains(this._marker.getLatLng())&&(this._userPanned=!0,this._updateContainerStyle(),this._drawMarker())},_isFollowing:function(){return!!this._active&&("always"===this.options.setView||("untilPan"===this.options.setView?!this._userPanned:"untilPanOrZoom"===this.options.setView?!this._userPanned&&!this._userZoomed:void 0))},_isOutsideMapBounds:function(){return void 0!==this._event&&(this._map.options.maxBounds&&!this._map.options.maxBounds.contains(this._event.latlng))},_updateContainerStyle:function(){this._container&&(this._active&&!this._event?this._setClasses("requesting"):this._isFollowing()?this._setClasses("following"):this._active?this._setClasses("active"):this._cleanClasses())},_setClasses:function(t){"requesting"==t?(s(this._container,"active following"),o(this._container,"requesting"),s(this._icon,this.options.icon),o(this._icon,this.options.iconLoading)):"active"==t?(s(this._container,"requesting following"),o(this._container,"active"),s(this._icon,this.options.iconLoading),o(this._icon,this.options.icon)):"following"==t&&(s(this._container,"requesting"),o(this._container,"active following"),s(this._icon,this.options.iconLoading),o(this._icon,this.options.icon))},_cleanClasses:function(){t.DomUtil.removeClass(this._container,"requesting"),t.DomUtil.removeClass(this._container,"active"),t.DomUtil.removeClass(this._container,"following"),s(this._icon,this.options.iconLoading),o(this._icon,this.options.icon)},_resetVariables:function(){this._active=!1,this._justClicked=!1,this._userPanned=!1,this._userZoomed=!1}});return t.control.locate=function(i){return new t.Control.Locate(i)},a},window);
	//# sourceMappingURL=/sm/769f402b2504f378e492868b050b86609a8c378aeefa0efe7a4920be1bdebd39.map
	/*leaflet-search.js*/
	!function(t){if("function"==typeof define&&define.amd)define(["leaflet"],t);else if("undefined"!=typeof module)module.exports=t(require("leaflet"));else{if(void 0===window.L)throw"Leaflet must be loaded first";t(window.L)}}(function(t){return t.Control.Search=t.Control.extend({includes:"1"===t.version[0]?t.Evented.prototype:t.Mixin.Events,options:{url:"",layer:null,sourceData:null,jsonpParam:null,propertyLoc:"loc",propertyName:"title",formatData:null,filterData:null,moveToLocation:null,buildTip:null,container:"",zoom:null,minLength:1,initial:!0,casesensitive:!1,autoType:!0,delayType:400,tooltipLimit:-1,tipAutoSubmit:!0,firstTipSubmit:!1,autoResize:!0,collapsed:!0,autoCollapse:!1,autoCollapseTime:1200,textErr:"Location not found",textCancel:"Cancel",textPlaceholder:"Search...",hideMarkerOnCollapse:!1,position:"topleft",marker:{icon:!1,animate:!0,circle:{radius:10,weight:3,color:"#e03",stroke:!0,fill:!1}}},_getPath:function(t,e){var i=e.split("."),o=i.pop(),s=i.length,n=i[0],r=1;if(s>0)for(;(t=t[n])&&r<s;)n=i[r++];if(t)return t[o]},_isObject:function(t){return"[object Object]"===Object.prototype.toString.call(t)},initialize:function(e){t.Util.setOptions(this,e||{}),this._inputMinSize=this.options.textPlaceholder?this.options.textPlaceholder.length:10,this._layer=this.options.layer||new t.LayerGroup,this._filterData=this.options.filterData||this._defaultFilterData,this._formatData=this.options.formatData||this._defaultFormatData,this._moveToLocation=this.options.moveToLocation||this._defaultMoveToLocation,this._autoTypeTmp=this.options.autoType,this._countertips=0,this._recordsCache={},this._curReq=null},onAdd:function(e){return this._map=e,this._container=t.DomUtil.create("div","leaflet-control-search"),this._input=this._createInput(this.options.textPlaceholder,"search-input"),this._tooltip=this._createTooltip("search-tooltip"),this._cancel=this._createCancel(this.options.textCancel,"search-cancel"),this._button=this._createButton(this.options.textPlaceholder,"search-button"),this._alert=this._createAlert("search-alert"),!1===this.options.collapsed&&this.expand(this.options.collapsed),this.options.marker&&(this.options.marker instanceof t.Marker||this.options.marker instanceof t.CircleMarker?this._markerSearch=this.options.marker:this._isObject(this.options.marker)&&(this._markerSearch=new t.Control.Search.Marker([0,0],this.options.marker)),this._markerSearch._isMarkerSearch=!0),this.setLayer(this._layer),e.on({resize:this._handleAutoresize},this),this._container},addTo:function(e){return this.options.container?(this._container=this.onAdd(e),this._wrapper=t.DomUtil.get(this.options.container),this._wrapper.style.position="relative",this._wrapper.appendChild(this._container)):t.Control.prototype.addTo.call(this,e),this},onRemove:function(t){this._recordsCache={},t.off({resize:this._handleAutoresize},this)},setLayer:function(t){return this._layer=t,this._layer.addTo(this._map),this},showAlert:function(t){var e=this;return t=t||this.options.textErr,this._alert.style.display="block",this._alert.innerHTML=t,clearTimeout(this.timerAlert),this.timerAlert=setTimeout(function(){e.hideAlert()},this.options.autoCollapseTime),this},hideAlert:function(){return this._alert.style.display="none",this},cancel:function(){return this._input.value="",this._handleKeypress({keyCode:8}),this._input.size=this._inputMinSize,this._input.focus(),this._cancel.style.display="none",this._hideTooltip(),this.fire("search:cancel"),this},expand:function(e){return e="boolean"!=typeof e||e,this._input.style.display="block",t.DomUtil.addClass(this._container,"search-exp"),!1!==e&&(this._input.focus(),this._map.on("dragstart click",this.collapse,this)),this.fire("search:expanded"),this},collapse:function(){return this._hideTooltip(),this.cancel(),this._alert.style.display="none",this._input.blur(),this.options.collapsed&&(this._input.style.display="none",this._cancel.style.display="none",t.DomUtil.removeClass(this._container,"search-exp"),this.options.hideMarkerOnCollapse&&this._map.removeLayer(this._markerSearch),this._map.off("dragstart click",this.collapse,this)),this.fire("search:collapsed"),this},collapseDelayed:function(){var t=this;return this.options.autoCollapse?(clearTimeout(this.timerCollapse),this.timerCollapse=setTimeout(function(){t.collapse()},this.options.autoCollapseTime),this):this},collapseDelayedStop:function(){return clearTimeout(this.timerCollapse),this},_createAlert:function(e){var i=t.DomUtil.create("div",e,this._container);return i.style.display="none",t.DomEvent.on(i,"click",t.DomEvent.stop,this).on(i,"click",this.hideAlert,this),i},_createInput:function(e,i){var o=this,s=t.DomUtil.create("label",i,this._container),n=t.DomUtil.create("input",i,this._container);return n.type="text",n.size=this._inputMinSize,n.value="",n.autocomplete="off",n.autocorrect="off",n.autocapitalize="off",n.placeholder=e,n.style.display="none",n.role="search",n.id=n.role+n.type+n.size,s.htmlFor=n.id,s.style.display="none",s.value=e,t.DomEvent.disableClickPropagation(n).on(n,"keyup",this._handleKeypress,this).on(n,"paste",function(t){setTimeout(function(t){o._handleKeypress(t)},10,t)},this).on(n,"blur",this.collapseDelayed,this).on(n,"focus",this.collapseDelayedStop,this),n},_createCancel:function(e,i){var o=t.DomUtil.create("a",i,this._container);return o.href="#",o.title=e,o.style.display="none",o.innerHTML="<span>&otimes;</span>",t.DomEvent.on(o,"click",t.DomEvent.stop,this).on(o,"click",this.cancel,this),o},_createButton:function(e,i){var o=t.DomUtil.create("a",i,this._container);return o.href="#",o.title=e,t.DomEvent.on(o,"click",t.DomEvent.stop,this).on(o,"click",this._handleSubmit,this).on(o,"focus",this.collapseDelayedStop,this).on(o,"blur",this.collapseDelayed,this),o},_createTooltip:function(e){var i=this,o=t.DomUtil.create("ul",e,this._container);return o.style.display="none",t.DomEvent.disableClickPropagation(o).on(o,"blur",this.collapseDelayed,this).on(o,"mousewheel",function(e){i.collapseDelayedStop(),t.DomEvent.stopPropagation(e)},this).on(o,"mouseover",function(t){i.collapseDelayedStop()},this),o},_createTip:function(e,i){var o;if(this.options.buildTip){if("string"==typeof(o=this.options.buildTip.call(this,e,i))){var s=t.DomUtil.create("div");s.innerHTML=o,o=s.firstChild}}else(o=t.DomUtil.create("li","")).innerHTML=e;return t.DomUtil.addClass(o,"search-tip"),o._text=e,this.options.tipAutoSubmit&&t.DomEvent.disableClickPropagation(o).on(o,"click",t.DomEvent.stop,this).on(o,"click",function(t){this._input.value=e,this._handleAutoresize(),this._input.focus(),this._hideTooltip(),this._handleSubmit()},this),o},_getUrl:function(t){return"function"==typeof this.options.url?this.options.url(t):this.options.url},_defaultFilterData:function(t,e){var i,o,s,n={};if(""===(t=t.replace(/[.*+?^${}()|[\]\\]/g,"")))return[];for(var r in i=this.options.initial?"^":"",o=this.options.casesensitive?void 0:"i",s=new RegExp(i+t,o),e)s.test(r)&&(n[r]=e[r]);return n},showTooltip:function(t){if(this._countertips=0,this._tooltip.innerHTML="",this._tooltip.currentSelection=-1,this.options.tooltipLimit)for(var e in t){if(this._countertips===this.options.tooltipLimit)break;this._countertips++,this._tooltip.appendChild(this._createTip(e,t[e]))}return this._countertips>0?(this._tooltip.style.display="block",this._autoTypeTmp&&this._autoType(),this._autoTypeTmp=this.options.autoType):this._hideTooltip(),this._tooltip.scrollTop=0,this._countertips},_hideTooltip:function(){return this._tooltip.style.display="none",this._tooltip.innerHTML="",0},_defaultFormatData:function(e){var i,o=this.options.propertyName,s=this.options.propertyLoc,n={};if(t.Util.isArray(s))for(i in e)n[this._getPath(e[i],o)]=t.latLng(e[i][s[0]],e[i][s[1]]);else for(i in e)n[this._getPath(e[i],o)]=t.latLng(this._getPath(e[i],s));return n},_recordsFromJsonp:function(e,i){t.Control.Search.callJsonp=i;var o=t.DomUtil.create("script","leaflet-search-jsonp",document.getElementsByTagName("body")[0]),s=t.Util.template(this._getUrl(e)+"&"+this.options.jsonpParam+"=L.Control.Search.callJsonp",{s:e});return o.type="text/javascript",o.src=s,{abort:function(){o.parentNode.removeChild(o)}}},_recordsFromAjax:function(e,i){void 0===window.XMLHttpRequest&&(window.XMLHttpRequest=function(){try{return new ActiveXObject("Microsoft.XMLHTTP.6.0")}catch(t){try{return new ActiveXObject("Microsoft.XMLHTTP.3.0")}catch(t){throw new Error("XMLHttpRequest is not supported")}}});var o=t.Browser.ie&&!window.atob&&document.querySelector?new XDomainRequest:new XMLHttpRequest,s=t.Util.template(this._getUrl(e),{s:e});return o.open("GET",s),o.onload=function(){i(JSON.parse(o.responseText))},o.onreadystatechange=function(){4===o.readyState&&200===o.status&&this.onload()},o.send(),o},_searchInLayer:function(e,i,o){var s,n=this;e instanceof t.Control.Search.Marker||(e instanceof t.Marker||e instanceof t.CircleMarker?n._getPath(e.options,o)?((s=e.getLatLng()).layer=e,i[n._getPath(e.options,o)]=s):n._getPath(e.feature.properties,o)?((s=e.getLatLng()).layer=e,i[n._getPath(e.feature.properties,o)]=s):console.warn("propertyName '"+o+"' not found in marker"):e instanceof t.Path||e instanceof t.Polyline||e instanceof t.Polygon?n._getPath(e.options,o)?((s=e.getBounds().getCenter()).layer=e,i[n._getPath(e.options,o)]=s):n._getPath(e.feature.properties,o)?((s=e.getBounds().getCenter()).layer=e,i[n._getPath(e.feature.properties,o)]=s):console.warn("propertyName '"+o+"' not found in shape"):e.hasOwnProperty("feature")?e.feature.properties.hasOwnProperty(o)?e.getLatLng&&"function"==typeof e.getLatLng?((s=e.getLatLng()).layer=e,i[e.feature.properties[o]]=s):e.getBounds&&"function"==typeof e.getBounds?((s=e.getBounds().getCenter()).layer=e,i[e.feature.properties[o]]=s):console.warn("Unknown type of Layer"):console.warn("propertyName '"+o+"' not found in feature"):e instanceof t.LayerGroup&&e.eachLayer(function(t){n._searchInLayer(t,i,o)}))},_recordsFromLayer:function(){var t=this,e={},i=this.options.propertyName;return this._layer.eachLayer(function(o){t._searchInLayer(o,e,i)}),e},_autoType:function(){var t=this._input.value.length,e=this._tooltip.firstChild?this._tooltip.firstChild._text:"",i=e.length;if(0===e.indexOf(this._input.value))if(this._input.value=e,this._handleAutoresize(),this._input.createTextRange){var o=this._input.createTextRange();o.collapse(!0),o.moveStart("character",t),o.moveEnd("character",i),o.select()}else this._input.setSelectionRange?this._input.setSelectionRange(t,i):this._input.selectionStart&&(this._input.selectionStart=t,this._input.selectionEnd=i)},_hideAutoType:function(){var t;if((t=this._input.selection)&&t.empty)t.empty();else if(this._input.createTextRange){(t=this._input.createTextRange()).collapse(!0);var e=this._input.value.length;t.moveStart("character",e),t.moveEnd("character",e),t.select()}else this._input.getSelection&&this._input.getSelection().removeAllRanges(),this._input.selectionStart=this._input.selectionEnd},_handleKeypress:function(t){var e=this;switch(t.keyCode){case 27:this.collapse();break;case 13:(1==this._countertips||this.options.firstTipSubmit&&this._countertips>0)&&-1==this._tooltip.currentSelection&&this._handleArrowSelect(1),this._handleSubmit();break;case 38:this._handleArrowSelect(-1);break;case 40:this._handleArrowSelect(1);break;case 8:case 45:case 46:this._autoTypeTmp=!1;break;case 37:case 39:case 16:case 17:case 35:case 36:break;default:this._input.value.length?this._cancel.style.display="block":this._cancel.style.display="none",this._input.value.length>=this.options.minLength?(clearTimeout(this.timerKeypress),this.timerKeypress=setTimeout(function(){e._fillRecordsCache()},this.options.delayType)):this._hideTooltip()}this._handleAutoresize()},searchText:function(e){var i=e.charCodeAt(e.length);this._input.value=e,this._input.style.display="block",t.DomUtil.addClass(this._container,"search-exp"),this._autoTypeTmp=!1,this._handleKeypress({keyCode:i})},_fillRecordsCache:function(){var e,i=this,o=this._input.value;this._curReq&&this._curReq.abort&&this._curReq.abort(),t.DomUtil.addClass(this._container,"search-load"),this.options.layer?(this._recordsCache=this._recordsFromLayer(),e=this._filterData(this._input.value,this._recordsCache),this.showTooltip(e),t.DomUtil.removeClass(this._container,"search-load")):(this.options.sourceData?this._retrieveData=this.options.sourceData:this.options.url&&(this._retrieveData=this.options.jsonpParam?this._recordsFromJsonp:this._recordsFromAjax),this._curReq=this._retrieveData.call(this,o,function(o){i._recordsCache=i._formatData.call(i,o),e=i.options.sourceData?i._filterData(i._input.value,i._recordsCache):i._recordsCache,i.showTooltip(e),t.DomUtil.removeClass(i._container,"search-load")}))},_handleAutoresize:function(){var t;this._input.style.maxWidth!==this._map._container.offsetWidth&&(t=this._map._container.clientWidth,t-=83,this._input.style.maxWidth=t.toString()+"px"),this.options.autoResize&&this._container.offsetWidth+20<this._map._container.offsetWidth&&(this._input.size=this._input.value.length<this._inputMinSize?this._inputMinSize:this._input.value.length)},_handleArrowSelect:function(e){var o=this._tooltip.hasChildNodes()?this._tooltip.childNodes:[];for(i=0;i<o.length;i++)t.DomUtil.removeClass(o[i],"search-tip-select");if(1==e&&this._tooltip.currentSelection>=o.length-1)t.DomUtil.addClass(o[this._tooltip.currentSelection],"search-tip-select");else if(-1==e&&this._tooltip.currentSelection<=0)this._tooltip.currentSelection=-1;else if("none"!=this._tooltip.style.display){this._tooltip.currentSelection+=e,t.DomUtil.addClass(o[this._tooltip.currentSelection],"search-tip-select"),this._input.value=o[this._tooltip.currentSelection]._text;var s=o[this._tooltip.currentSelection].offsetTop;s+o[this._tooltip.currentSelection].clientHeight>=this._tooltip.scrollTop+this._tooltip.clientHeight?this._tooltip.scrollTop=s-this._tooltip.clientHeight+o[this._tooltip.currentSelection].clientHeight:s<=this._tooltip.scrollTop&&(this._tooltip.scrollTop=s)}},_handleSubmit:function(){if(this._hideAutoType(),this.hideAlert(),this._hideTooltip(),"none"==this._input.style.display)this.expand();else if(""===this._input.value)this.collapse();else{var t=this._getLocation(this._input.value);!1===t?this.showAlert():(this.showLocation(t,this._input.value),this.fire("search:locationfound",{latlng:t,text:this._input.value,layer:t.layer?t.layer:null}))}},_getLocation:function(t){return!!this._recordsCache.hasOwnProperty(t)&&this._recordsCache[t]},_defaultMoveToLocation:function(t,e,i){this.options.zoom?this._map.setView(t,this.options.zoom):this._map.panTo(t)},showLocation:function(t,e){var i=this;return i._map.once("moveend zoomend",function(e){i._markerSearch&&i._markerSearch.addTo(i._map).setLatLng(t)}),i._moveToLocation(t,e,i._map),i.options.autoCollapse&&i.collapse(),i}}),t.Control.Search.Marker=t.Marker.extend({includes:"1"===t.version[0]?t.Evented.prototype:t.Mixin.Events,options:{icon:new t.Icon.Default,animate:!0,circle:{radius:10,weight:3,color:"#e03",stroke:!0,fill:!1}},initialize:function(e,i){t.setOptions(this,i),!0===i.icon&&(i.icon=new t.Icon.Default),t.Marker.prototype.initialize.call(this,e,i),t.Control.Search.prototype._isObject(this.options.circle)&&(this._circleLoc=new t.CircleMarker(e,this.options.circle))},onAdd:function(e){t.Marker.prototype.onAdd.call(this,e),this._circleLoc&&(e.addLayer(this._circleLoc),this.options.animate&&this.animate())},onRemove:function(e){t.Marker.prototype.onRemove.call(this,e),this._circleLoc&&e.removeLayer(this._circleLoc)},setLatLng:function(e){return t.Marker.prototype.setLatLng.call(this,e),this._circleLoc&&this._circleLoc.setLatLng(e),this},_initIcon:function(){this.options.icon&&t.Marker.prototype._initIcon.call(this)},_removeIcon:function(){this.options.icon&&t.Marker.prototype._removeIcon.call(this)},animate:function(){if(this._circleLoc){var t=this._circleLoc,e=parseInt(t._radius/5),i=this.options.circle.radius,o=2*t._radius,s=0;t._timerAnimLoc=setInterval(function(){o-=e+=s+=.5,t.setRadius(o),o<i&&(clearInterval(t._timerAnimLoc),t.setRadius(i))},200)}return this}}),t.Map.addInitHook(function(){this.options.searchControl&&(this.searchControl=t.control.search(this.options.searchControl),this.addControl(this.searchControl))}),t.control.search=function(e){return new t.Control.Search(e)},t.Control.Search});
	/*! js-cookie v3.0.0-beta.3 | MIT */
	!function(e,t){"object"==typeof exports&&"undefined"!=typeof module?module.exports=t():"function"==typeof define&&define.amd?define(t):(e=e||self,function(){var n=e.Cookies,r=e.Cookies=t();r.noConflict=function(){return e.Cookies=n,r}}())}(this,function(){"use strict";var e={read:function(e){return e.replace(/(%[\dA-F]{2})+/gi,decodeURIComponent)},write:function(e){return encodeURIComponent(e).replace(/%(2[346BF]|3[AC-F]|40|5[BDE]|60|7[BCD])/g,decodeURIComponent)}};function t(e){for(var t=1;t<arguments.length;t++){var n=arguments[t];for(var r in n)e[r]=n[r]}return e}return function n(r,o){function i(e,n,i){if("undefined"!=typeof document){"number"==typeof(i=t({},o,i)).expires&&(i.expires=new Date(Date.now()+864e5*i.expires)),i.expires&&(i.expires=i.expires.toUTCString()),n=r.write(n,e),e=encodeURIComponent(e).replace(/%(2[346B]|5E|60|7C)/g,decodeURIComponent).replace(/[()]/g,escape);var c="";for(var u in i)i[u]&&(c+="; "+u,!0!==i[u]&&(c+="="+i[u].split(";")[0]));return document.cookie=e+"="+n+c}}return Object.create({set:i,get:function(t){if("undefined"!=typeof document&&(!arguments.length||t)){for(var n=document.cookie?document.cookie.split("; "):[],o={},i=0;i<n.length;i++){var c=n[i].split("="),u=c.slice(1).join("=");'"'===u[0]&&(u=u.slice(1,-1));try{var f=e.read(c[0]);if(o[f]=r.read(u,f),t===f)break}catch(e){}}return t?o[t]:o}},remove:function(e,n){i(e,"",t({},n,{expires:-1}))},withAttributes:function(e){return n(this.converter,t({},this.attributes,e))},withConverter:function(e){return n(t({},this.converter,e),this.attributes)}},{attributes:{value:Object.freeze(o)},converter:{value:Object.freeze(r)}})}(e,{path:"/"})});
	
	
	function convertDateFormat(dlog){
		var f_date = dlog.split(' ');
		var a_date = f_date[0].split('-');
		var d =a_date[2]+'/'+a_date[1]+'/'+a_date[0];
		var t =f_date[1].substring(0,5);
		return '<span class="px-1"><i class="far fa-calendar-alt"></i> '+d+' | <i class="far fa-clock"></i> '+t+'</span>';
	}
	
	function convertDateFormatDay(dlog){
		var f_date = dlog.split(' ');
		var a_date = f_date[0].split('-');
		var d =a_date[2]+'/'+a_date[1]+'/'+a_date[0];
		var t =f_date[1].substring(0,5);
		return '<span class="px-1"><i class="far fa-calendar-alt"></i> '+d+'</span>';
	}
	
	function convertDateFormatHour(dlog){
		var f_date = dlog.split(' ');
		var a_date = f_date[0].split('-');
		var d =a_date[2]+'/'+a_date[1]+'/'+a_date[0];
		var t =f_date[1].substring(0,5);
		return '<span class="px-1"><i class="far fa-clock"></i> '+t+'</span>';
	}

	function convertAVGDateFormat(dlog){
		var f_date = dlog.split(' ');
		var a_date = f_date[0].split('-');
		var d =a_date[2]+'/'+a_date[1]+'/'+a_date[0];
		var t =f_date[1].substring(0,5);
		return 'อัพเดทข้อมูลเมื่อ : '+d+' เวลา '+t+' น.';
	}

	$(function () {
		var BASE_URL = 'https://test.cmuccdc.org/';
		$(".switch_lang").on('click', function () {
			$.post(BASE_URL+"main/switch_lang",{lang:$(this).attr('lang'), url:$(this).attr('redirect')}, function(data) {
				location.reload();
			});
		});
		$(".switch_type").on('click', function () {
			$.post(BASE_URL+"main/switch_type",{sType:$(this).attr('sType'),url:$(this).attr('redirect')}, function(data) {
				location.reload();
			});
		});
		
		$("#btn-hourly-filter").on('click', function () {
			var s_value = $("#select-hourly-filter").val();
			if(s_value){
				document.location.href = '/hourly/'+s_value;
			}else{alert('กรุณาเลือกจังหวัดเพื่อดูข้อมูล ค่าฝุ่นรายชั่วโมง');}
		});
				
		$("#btn-daily-filter").on('click', function () {
			var s_value = $("#select-daily-filter").val();
			if(s_value){
				document.location.href = '/daily/'+s_value;
			}else{alert('กรุณาเลือกจังหวัดเพื่อดูข้อมูล ค่าฝุ่นรายวัน');}
		});		
		

		$("#news-page-news-feed .news-slice").slice(0, 6).show();
		$(".news-see-more-btn").on('click', function (e) {
			e.preventDefault();
			$("#news-page-news-feed .news-slice:hidden").slice(0, 6).slideDown();
			if ($("#news-page-news-feed .news-slice:hidden").length === 0) {
				$(".news-see-more-btn").addClass('disabled btn');
			}
		}); // News Page Load End
		
		$("#research_feed .research_list").slice(0, 6).show();
		$(".research_more").on('click', function (e) {
			e.preventDefault();
			$("#research_feed .research_list:hidden").slice(0, 6).slideDown();
			if ($("#research_feed .research_list:hidden").length === 0) {
				$(".research_more").addClass('disabled btn');
			}
		}); // News Page Load End
		
		
		$( ".ccdc_content" ).find( "iframe" ).wrap('<div class="embed-responsive embed-responsive-16by9"/>');
		$( ".ccdc_content" ).find( "iframe" ).addClass('embed-responsive-item');
				
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
	Imagery = new L.esri.basemapLayer("Imagery"),
	ShadedRelief = new L.esri.basemapLayer("ShadedRelief", {
		opacity: opacity
	});

	var map = new L.map("us_map", {
		center: [13.912, 100.5270061],
		zoom: 5,
		attributionControl: !1,
		maxZoom: 17,
		minZoom: 5,
		fullscreenControl: true,
		fullscreenControlOptions: {
			position: 'topleft'
		},
		layers: [OpenStreetMap]
		
	}),


	lc = L.control.locate({
		position: "topleft",
		strings: {
			title: "Show My Location"
		}
	}).addTo(map),
	baseMaps = {
		OpenStreetMap: OpenStreetMap,
	   // Topographic: Topographic,
		Streets: Streets,
	   // NationalGeographic: NationalGeographic,
	   // "<span style='color: gray'>Gray</span>": Gray,
	   // DarkGray: DarkGray,
		Imagery: Imagery,
	   // ShadedRelief: ShadedRelief,
	   // Oceans: Oceans
	},
	
	
	layerControl = new L.control.layers(baseMaps);
	layerControl.addTo(map);

	var actualLayerGroup = new L.layerGroup([], {});
	var actualLayerGroup2 = new L.layerGroup([], {});
	//actualLayerArray.length = map.timeDimension._availableTimes.length;
	//var actualTimeIndex = map.timeDimension._currentTimeIndex;

	function createVmap(url_to_geotiff_file){
		actualLayerGroup2.clearLayers();
		var base_uri = "/uploads/tiff/";
		fetch(url_to_geotiff_file)
			.then((response) => response.arrayBuffer())
			.then((arrayBuffer) => {
				parseGeoraster(arrayBuffer).then((georaster) => {
					var layer = new GeoRasterLayer({
						georaster: georaster,
						opacity: .9,
						resolution: 256,
					});
					layer.addTo(map);
					map.fitBounds(layer.getBounds());
					actualLayerGroup2.addLayer(layer);
					actualLayerGroup2.addTo(map);
			});
		});
	}
	/*
	function switchParameter(e) {
		switch (e) {
			case "Wind":
				actualModel = "GFS", actualLayerBaseURL = wind10mBaseURL, actualLayerBaseName = wind10mBaseName, initDisplayValues = !0, initVelocityType = "Wind", initEmptyString = "No wind data", initAngleConvention = "bearingCW", initSpeedUnit = "Bft", initMinVelocity = 0, initMaxVelocity = 30, initVelocityScale = .001, initParticleAge = 90, initLineWidth = 1, initParticleMultiplier = .0033, initFrameRate = 15, initColorScale = ["#2468b4", "#3c9dc2", "#80cdc1", "#97daa8", "#c6e7b5", "#eef7d9", "#ffee9f", "#fcd97d", "#ffb664", "#fc964b", "#fa7034", "#f54020", "#ed2d1c", "#dc1820", "#b40023"]
		}
	}*/

	var type = Cookies.get("data_index");
	if ("th-hr" == type || "th-dy" == type) var usevmap = vmap;
	else usevmap = vmap_us;

	//layerControl.addOverlay(actualLayerGroup, actualLayer);
	layerControl.addOverlay(actualLayerGroup2, 'VMap');
	createVmap(usevmap);
	//initializeLayer(actualLayerArray[actualTimeIndex]);
	//window.setInterval(function() {
	//   actualTimeIndex != map.timeDimension._currentTimeIndex && (actualTimeIndex = map.timeDimension._currentTimeIndex, updateLayer(actualLayerArray[actualTimeIndex]))
	//}, 100);

	$(".switch_type2").on('click', function () {
		$('#sw_source').html($(this).html());
		$('.switch_type2').removeClass( "active" );
		$(this).addClass( "active" );
		Cookies.set('data_index', $(this).attr('data_index'));
		location.reload();
	});

	var data_type = Cookies.get('data_index');
	$.getJSON("https://test.cmuccdc.org/assets/api/standard_aqi.json?v=1", function(aqi) {
		var us = aqi[0].us_aqi;
		var th = aqi[0].th_aqi;
		
		
		var us_pm = '';                           
		var th_pm = '';                           
		var th_aqi = '';                           
		var th_aqi_daily = '';                           
		var us_aqi = '';                           
		var us_aqi_daily = '';                           
		for (var i = 0; i < us['pm25'].length; ++i) {
			
			us_aqi +='<div class="col col-md-1 detail_pm_aqi" style="background-color: rgb('+us['aqi'][i].color+');"><img width="20" src="/template/image/'+us['aqi'][i].dustboy_icon+'"></div>'
			
			if(i==(us['pm25'].length-1)){
				us_pm +='<div class="col col-md-1 detail_pm_aqi" style="background-color: rgb('+us['pm25'][i].color+');">>'+us['pm25'][i-1].max+'</div>'
				us_aqi_daily +='<div class="col col-md-1 detail_pm_aqi" style="background-color: rgb('+us['aqi'][i].color+');">>'+us['aqi'][i-1].max+'</div>'
			}else{
				us_aqi_daily +='<div class="col col-md-1 detail_pm_aqi" style="background-color: rgb('+us['aqi'][i].color+');">'+us['aqi'][i].min+'-'+us['aqi'][i].max+'</div>'
				us_pm +='<div class="col col-md-1 detail_pm_aqi" style="background-color: rgb('+us['pm25'][i].color+');">'+us['pm25'][i].min+'-'+us['pm25'][i].max+'</div>'
			}
		}
		
		for (var i = 0; i < th['pm25'].length; ++i) {

			th_aqi +='<div class="col col-md-1 detail_pm_aqi" style="background-color: rgb('+th['aqi'][i].color+');"><img width="20" src="/template/image/'+th['aqi'][i].dustboy_icon+'"></div>'
			
			if(i==(th['pm25'].length-1)){
				th_pm +='<div class="col col-md-1 detail_pm_aqi" style="background-color: rgb('+th['pm25'][i].color+');">>'+th['pm25'][i-1].max+'</div>'
				th_aqi_daily +='<div class="col col-md-1 detail_pm_aqi" style="background-color: rgb('+th['aqi'][i].color+');">>'+th['aqi'][i-1].max+'</div>'
			}else{
				th_aqi_daily +='<div class="col col-md-1 detail_pm_aqi" style="background-color: rgb('+th['aqi'][i].color+');">'+th['aqi'][i].min+'-'+th['aqi'][i].max+'</div>'
				th_pm +='<div class="col col-md-1 detail_pm_aqi" style="background-color: rgb('+th['pm25'][i].color+');">'+th['pm25'][i].min+'-'+th['pm25'][i].max+'</div>'
			}
		}
		var us_data = '<div class="pm_aqi">';
		us_data 	+='<div class="pm fade_in_ture anime_delay1">';
		us_data 	+='<div class="col col-md-6 title_pm_aqi ">PM<sub>2.5</sub><span class="d-none d-md-block">(μg/m<sup>3</sup>)</span></div>';
		us_data 	+=us_pm;
		us_data 	+='</div>';
		us_data 	+='<div class="aqi fade_in_ture anime_delay15">';
		us_data 	+='<div class="col col-md-6 title_pm_aqi "></div>';
		us_data 	+=us_aqi;
		us_data 	+='</div>';
		us_data 	+='</div>';
		
		var us_data_daily = '<div class="pm_aqi">';
		us_data_daily 	+='<div class="pm fade_in_ture anime_delay1">';
		us_data_daily 	+='<div class="col col-md-6 title_pm_aqi ">PM<sub>2.5</sub><span class="d-none d-md-block">(μg/m<sup>3</sup>)</span></div>';
		us_data_daily 	+=us_pm;
		us_data_daily 	+='</div>';
		us_data_daily 	+='<div class="aqi fade_in_ture anime_delay15">';
		us_data_daily 	+='<div class="col col-md-6 title_pm_aqi ">US AQI</div>';
		us_data_daily 	+=us_aqi_daily;
		us_data_daily 	+='</div>';
		us_data_daily 	+='</div>';
		
		var th_data = '<div class="pm_aqi">';
		th_data 	+='<div class="pm fade_in_ture anime_delay1">';
		th_data 	+='<div class="col col-md-7 title_pm_aqi ">PM<sub>2.5</sub><span class="d-none d-md-block">(μg/m<sup>3</sup>)</span></div>';
		th_data 	+=th_pm;
		th_data 	+='</div>';
		th_data 	+='<div class="aqi fade_in_ture anime_delay15">';
		th_data 	+='<div class="col col-md-7 title_pm_aqi "></div>';
		th_data 	+=th_aqi;
		th_data 	+='</div>';
		th_data 	+='</div>';
		
		var th_data_daily = '<div class="pm_aqi">';
		th_data_daily 	+='<div class="pm fade_in_ture anime_delay1">';
		th_data_daily 	+='<div class="col col-md-7 title_pm_aqi ">PM<sub>2.5</sub><span class="d-none d-md-block">(μg/m<sup>3</sup>)</span></div>';
		th_data_daily 	+=th_pm;
		th_data_daily 	+='</div>';
		th_data_daily 	+='<div class="aqi fade_in_ture anime_delay15">';
		th_data_daily 	+='<div class="col col-md-7 title_pm_aqi ">TH AQI</div>';
		th_data_daily 	+=th_aqi_daily;
		th_data_daily 	+='</div>';
		th_data_daily 	+='</div>';
		
		
		$('#th_index').html(th_data);
		$('#th_index_daily').html(th_data_daily);
		$('#us_index').html(us_data);
		$('#us_index_daily').html(us_data_daily);
	});
	
	
	$.getJSON("https://test.cmuccdc.org/assets/api/genDustboyGeo.php?token="+token+"&dataType="+data_type, function(db) {
		if (db) {
		
			var i=0;
			geojsonOpts = {
				pointToLayer: function(feature, latlng) {
					if(i==0){
						$('#data-timer').html(convertAVGDateFormat(feature.properties.log_datetime));
					}
					i++;
					if(data_type=="th-hr"){
						return marker = L.marker(latlng, {
							icon: L.divIcon({
								className: "my-custom-pin",
								iconSize: [35, 35],
								html: '<div class="signoutz-marker"style="background-color:rgba(' + feature.properties.th_color+', 1)">' + parseInt(feature.properties.pm25).toFixed() + '</div>',
							})
						}).on('click', function(e) {
							if(data_lang=="thailand"){
								$('#popupDetail p').html(feature.properties.dustboy_name);
							}else{
								$('#popupDetail p').html(feature.properties.dustboy_name_en);
							}
							$('#popupDetail .card-header').css("background-color", "rgba(" + feature.properties.th_color + ", 1)");
							$('#popupDetail .card-body').css("background-color", "rgba(" + feature.properties.th_color + ", 1)");
							$('#popupDetail .card-footer').css("background-color", "rgba(" + feature.properties.th_color + ", 1)");
							$('#popupDetail .number_title').html(parseInt(feature.properties.pm25).toFixed());
							$('#popupDetail .number_footer').html('PM<sub>2.5</sub> (μg/m<sup>3</sup>)');
							if(data_lang=="thailand"){
								$('#popupDetail .detail_title').html(feature.properties.th_title);
							}else{
								$('#popupDetail .detail_title').html(feature.properties.th_title_en);
							}
							$('#popupDetail .card-body .anime img').attr("src", '/template/image/' + feature.properties.th_dustboy_icon + '.svg');
							$('#popupDetail .card-footer .weahter').html(convertDateFormatDay(feature.properties.log_datetime)+' | '+convertDateFormatHour(feature.properties.log_datetime));
							if(data_lang=="thailand"){
								$('#popupDetail .card-footer .favorite').html('<a href="/'+feature.properties.dustboy_uri+'" style="color:#fff;background: #7d7d7d63;padding:1px 5px;border-radius: 5px;"><i class="fa fa-info-circle"></i> ข้อมูลเพิ่มเติม</a>');
							}else{
								$('#popupDetail .card-footer .favorite').html('<a href="/'+feature.properties.dustboy_uri+'" style="color:#fff;background: #7d7d7d63;padding:1px 5px;border-radius: 5px;"><i class="fa fa-info-circle"></i> More Info</a>');
							}
							$('#popupHotspot').hide();
							$('#popupDetail').show()
						});
					}else if(data_type=="us-hr"){
						return marker = L.marker(latlng, {
							icon: L.divIcon({
								className: "my-custom-pin",
								iconSize: [35, 35],
								html: '<div class="signoutz-marker"style="background-color:rgba(' + feature.properties.us_color+', 1)">' + parseInt(feature.properties.pm25).toFixed() + '</div>',
							})
						}).on('click', function(e) {
							if(data_lang=="thailand"){
								$('#popupDetail p').html(feature.properties.dustboy_name);
							}else{
								$('#popupDetail p').html(feature.properties.dustboy_name_en);
							}
							$('#popupDetail .card-header').css("background-color", "rgba(" + feature.properties.us_color + ", 1)");
							$('#popupDetail .card-body').css("background-color", "rgba(" + feature.properties.us_color + ", 1)");
							$('#popupDetail .card-footer').css("background-color", "rgba(" + feature.properties.us_color + ", 1)");
							$('#popupDetail .number_title').html(parseInt(feature.properties.pm25).toFixed());
							$('#popupDetail .number_footer').html('μg/m<sup>3</sup>');
							if(data_lang=="thailand"){
								$('#popupDetail .detail_title').html(feature.properties.us_title);
							}else{
								$('#popupDetail .detail_title').html(feature.properties.us_title_en);
							}
							//$('#popupDetail .detail_time').html(convertDateFormat(feature.properties.log_datetime));
							$('#popupDetail .card-body .anime img').attr("src", '/template/image/' + feature.properties.us_dustboy_icon + '.svg');
							$('#popupDetail .card-footer .weahter').html(convertDateFormatDay(feature.properties.log_datetime)+' | '+convertDateFormatHour(feature.properties.log_datetime));
							if(data_lang=="thailand"){
								$('#popupDetail .card-footer .favorite').html('<a href="/'+feature.properties.dustboy_uri+'" style="color:#fff;background: #7d7d7d63;padding:1px 5px;border-radius: 5px;"><i class="fa fa-info-circle"></i> ข้อมูลเพิ่มเติม</a>');
							}else{
								$('#popupDetail .card-footer .favorite').html('<a href="/'+feature.properties.dustboy_uri+'" style="color:#fff;background: #7d7d7d63;padding:1px 5px;border-radius: 5px;"><i class="fa fa-info-circle"></i> More Info</a>');
							}
							$('#popupHotspot').hide();
							$('#popupDetail').show()
						});
					}else if(data_type=="th-dy"){
						return marker = L.marker(latlng, {
							icon: L.divIcon({
								className: "my-custom-pin",
								iconSize: [35, 35],
								html: '<div class="signoutz-marker"style="background-color:rgba(' + feature.properties.daily_th_color+', 1)">' + parseInt(feature.properties.daily_pm25).toFixed() + '</div>',
							})
						}).on('click', function(e) {
							if(data_lang=="thailand"){
								$('#popupDetail p').html(feature.properties.dustboy_name);
							}else{
								$('#popupDetail p').html(feature.properties.dustboy_name_en);
							}
							$('#popupDetail .card-header').css("background-color", "rgba(" + feature.properties.daily_th_color + ", 1)");
							$('#popupDetail .card-body').css("background-color", "rgba(" + feature.properties.daily_th_color + ", 1)");
							$('#popupDetail .card-footer').css("background-color", "rgba(" + feature.properties.daily_th_color + ", 1)");
							$('#popupDetail .number_title').html(parseInt(feature.properties.daily_pm25).toFixed());
							$('#popupDetail .number_footer').html('PM<sub>2.5</sub> (μg/m<sup>3</sup>)');
							if(data_lang=="thailand"){
								$('#popupDetail .detail_title').html(feature.properties.daily_th_title);
							}else{
								$('#popupDetail .detail_title').html(feature.properties.daily_th_title_en);
							}
							//$('#popupDetail .detail_time').html(convertDateFormatDay(feature.properties.log_datetime));
							$('#popupDetail .card-body .anime img').attr("src", '/template/image/' + feature.properties.daily_th_dustboy_icon + '.svg');
							$('#popupDetail .card-footer .weahter').html(convertDateFormat(feature.properties.log_datetime)+ ' | PM<sub>2.5</sub> AQI '+feature.properties.daily_pm25_th_aqi);
							if(data_lang=="thailand"){
								$('#popupDetail .card-footer .favorite').html('<a href="/'+feature.properties.dustboy_uri+'" style="color:#fff;background: #7d7d7d63;padding:1px 5px;border-radius: 5px;"><i class="fa fa-info-circle"></i> ข้อมูลเพิ่มเติม</a>');
							}else{
								$('#popupDetail .card-footer .favorite').html('<a href="/'+feature.properties.dustboy_uri+'" style="color:#fff;background: #7d7d7d63;padding:1px 5px;border-radius: 5px;"><i class="fa fa-info-circle"></i> More Info</a>');
							}
							$('#popupHotspot').hide();
							$('#popupDetail').show()
						});
					}else if(data_type=="us-dy"){
						return marker = L.marker(latlng, {
							icon: L.divIcon({
								className: "my-custom-pin",
								iconSize: [35, 35],
								html: '<div class="signoutz-marker"style="background-color:rgba(' + feature.properties.daily_us_color+', 1)">' + parseInt(feature.properties.daily_pm25).toFixed() + '</div>',
							})
						}).on('click', function(e) {
							if(data_lang=="thailand"){
								$('#popupDetail p').html(feature.properties.dustboy_name);
							}else{
								$('#popupDetail p').html(feature.properties.dustboy_name_en);
							}
							$('#popupDetail .card-header').css("background-color", "rgba(" + feature.properties.daily_us_color + ", 1)");
							$('#popupDetail .card-body').css("background-color", "rgba(" + feature.properties.daily_us_color + ", 1)");
							$('#popupDetail .card-footer').css("background-color", "rgba(" + feature.properties.daily_us_color + ", 1)");
							$('#popupDetail .number_title').html(parseInt(feature.properties.daily_pm25).toFixed());
							$('#popupDetail .number_footer').html('μg/m<sup>3</sup>');
							if(data_lang=="thailand"){
								$('#popupDetail .detail_title').html(feature.properties.daily_us_title);
							}else{
								$('#popupDetail .detail_title').html(feature.properties.daily_us_title_en);
							}
							//$('#popupDetail .detail_time').html(convertDateFormatDay(feature.properties.log_datetime));
							$('#popupDetail .card-body .anime img').attr("src", '/template/image/' + feature.properties.daily_us_dustboy_icon + '.svg');
							$('#popupDetail .card-footer .weahter').html(convertDateFormat(feature.properties.log_datetime)+ ' | PM<sub>2.5</sub> AQI '+feature.properties.daily_pm25_us_aqi);
							if(data_lang=="thailand"){
								$('#popupDetail .card-footer .favorite').html('<a href="/'+feature.properties.dustboy_uri+'" style="color:#fff;background: #7d7d7d63;padding:1px 5px;border-radius: 5px;"><i class="fa fa-info-circle"></i> ข้อมูลเพิ่มเติม</a>');
							}else{
								$('#popupDetail .card-footer .favorite').html('<a href="/'+feature.properties.dustboy_uri+'" style="color:#fff;background: #7d7d7d63;padding:1px 5px;border-radius: 5px;"><i class="fa fa-info-circle"></i> More Info</a>');
							}
							$('#popupHotspot').hide();		
							$('#popupDetail').show()
						});
					}
				}
				
			};
			
			
			var poiLayers = L.layerGroup([
				L.geoJson(db, geojsonOpts)
			])
			.addTo(map);

			var searchControl = L.control.search({
				position:'topright',
				layer: poiLayers,
				initial: false,
				propertyName: 'dustboy_name',
				zoom: 13,
				buildTip: function(text, val) {
					return '<a href="#">'+text+'</a>';
				}
			})
			.addTo(map);
			
			layerControl.addOverlay(poiLayers, 'DustBoy');
			
		}
		
		var db_indoor = {};
		
		$.getJSON("https://test.cmuccdc.org/assets/api/genDustboyGeo.php?token="+token+"&dataType="+data_type+"&sensors=indoor", function(db) {
			if (db) {
				db_indoor = db;
				geojsonOpts_indoor = {
					pointToLayer: function(feature, latlng) {
					if(i==0){
						$('#data-timer').html(convertAVGDateFormat(feature.properties.log_datetime));
					}
					i++;
					if(data_type=="th-hr"){
						return marker = L.marker(latlng, {
							icon: L.divIcon({
								className: "my-custom-pin",
								iconSize: [35, 35],
								html: '<div class="signoutz-marker"style="background-color:rgba(' + feature.properties.th_color+', 1)">' + parseInt(feature.properties.pm25).toFixed() + '</div>',
							})
						}).on('click', function(e) {
							if(data_lang=="thailand"){
								$('#popupDetail p').html(feature.properties.dustboy_name);
							}else{
								$('#popupDetail p').html(feature.properties.dustboy_name_en);
							}
							$('#popupDetail .card-header').css("background-color", "rgba(" + feature.properties.th_color + ", 1)");
							$('#popupDetail .card-body').css("background-color", "rgba(" + feature.properties.th_color + ", 1)");
							$('#popupDetail .card-footer').css("background-color", "rgba(" + feature.properties.th_color + ", 1)");
							$('#popupDetail .number_title').html(parseInt(feature.properties.pm25).toFixed());
							$('#popupDetail .number_footer').html('PM<sub>2.5</sub> (μg/m<sup>3</sup>)');
							if(data_lang=="thailand"){
								$('#popupDetail .detail_title').html(feature.properties.th_title);
							}else{
								$('#popupDetail .detail_title').html(feature.properties.th_title_en);
							}
							$('#popupDetail .card-body .anime img').attr("src", '/template/image/' + feature.properties.th_dustboy_icon + '.svg');
							$('#popupDetail .card-footer .weahter').html(convertDateFormatDay(feature.properties.log_datetime)+' | '+convertDateFormatHour(feature.properties.log_datetime));
							$('#popupDetail .card-footer .favorite').html('<a href="/'+feature.properties.dustboy_uri+'" style="color:#fff;"><i class="fa fa-info-circle"></i></a>');
							$('#popupHotspot').hide();
							$('#popupDetail').show()
						});
					}else if(data_type=="us-hr"){
						return marker = L.marker(latlng, {
							icon: L.divIcon({
								className: "my-custom-pin",
								iconSize: [35, 35],
								html: '<div class="signoutz-marker"style="background-color:rgba(' + feature.properties.us_color+', 1)">' + parseInt(feature.properties.pm25).toFixed() + '</div>',
							})
						}).on('click', function(e) {
							if(data_lang=="thailand"){
								$('#popupDetail p').html(feature.properties.dustboy_name);
							}else{
								$('#popupDetail p').html(feature.properties.dustboy_name_en);
							}
							$('#popupDetail .card-header').css("background-color", "rgba(" + feature.properties.us_color + ", 1)");
							$('#popupDetail .card-body').css("background-color", "rgba(" + feature.properties.us_color + ", 1)");
							$('#popupDetail .card-footer').css("background-color", "rgba(" + feature.properties.us_color + ", 1)");
							$('#popupDetail .number_title').html(parseInt(feature.properties.pm25).toFixed());
							$('#popupDetail .number_footer').html('μg/m<sup>3</sup>');
							if(data_lang=="thailand"){
								$('#popupDetail .detail_title').html(feature.properties.us_title);
							}else{
								$('#popupDetail .detail_title').html(feature.properties.us_title_en);
							}
							//$('#popupDetail .detail_time').html(convertDateFormat(feature.properties.log_datetime));
							$('#popupDetail .card-body .anime img').attr("src", '/template/image/' + feature.properties.us_dustboy_icon + '.svg');
							$('#popupDetail .card-footer .weahter').html(convertDateFormatDay(feature.properties.log_datetime)+' | '+convertDateFormatHour(feature.properties.log_datetime));
							$('#popupDetail .card-footer .favorite').html('<a href="/'+feature.properties.dustboy_uri+'" style="color:#fff;"><i class="fa fa-info-circle"></i></a>');
							$('#popupHotspot').hide();
							$('#popupDetail').show()
						});
					}else if(data_type=="th-dy"){
						return marker = L.marker(latlng, {
							icon: L.divIcon({
								className: "my-custom-pin",
								iconSize: [35, 35],
								html: '<div class="signoutz-marker"style="background-color:rgba(' + feature.properties.daily_th_color+', 1)">' + parseInt(feature.properties.daily_pm25).toFixed() + '</div>',
							})
						}).on('click', function(e) {
							if(data_lang=="thailand"){
								$('#popupDetail p').html(feature.properties.dustboy_name);
							}else{
								$('#popupDetail p').html(feature.properties.dustboy_name_en);
							}
							$('#popupDetail .card-header').css("background-color", "rgba(" + feature.properties.daily_th_color + ", 1)");
							$('#popupDetail .card-body').css("background-color", "rgba(" + feature.properties.daily_th_color + ", 1)");
							$('#popupDetail .card-footer').css("background-color", "rgba(" + feature.properties.daily_th_color + ", 1)");
							$('#popupDetail .number_title').html(parseInt(feature.properties.daily_pm25).toFixed());
							$('#popupDetail .number_footer').html('PM<sub>2.5</sub> (μg/m<sup>3</sup>)');
							if(data_lang=="thailand"){
								$('#popupDetail .detail_title').html(feature.properties.daily_th_title);
							}else{
								$('#popupDetail .detail_title').html(feature.properties.daily_th_title_en);
							}
							//$('#popupDetail .detail_time').html(convertDateFormatDay(feature.properties.log_datetime));
							$('#popupDetail .card-body .anime img').attr("src", '/template/image/' + feature.properties.daily_th_dustboy_icon + '.svg');
							$('#popupDetail .card-footer .weahter').html(convertDateFormat(feature.properties.log_datetime)+ ' | PM<sub>2.5</sub> AQI '+feature.properties.daily_pm25_th_aqi);
							$('#popupDetail .card-footer .favorite').html('<a href="/'+feature.properties.dustboy_uri+'" style="color:#fff;"><i class="fa fa-info-circle"></i></a>');
							$('#popupHotspot').hide();
							$('#popupDetail').show()
						});
					}else if(data_type=="us-dy"){
						return marker = L.marker(latlng, {
							icon: L.divIcon({
								className: "my-custom-pin",
								iconSize: [35, 35],
								html: '<div class="signoutz-marker"style="background-color:rgba(' + feature.properties.daily_us_color+', 1)">' + parseInt(feature.properties.daily_pm25).toFixed() + '</div>',
							})
						}).on('click', function(e) {
							if(data_lang=="thailand"){
								$('#popupDetail p').html(feature.properties.dustboy_name);
							}else{
								$('#popupDetail p').html(feature.properties.dustboy_name_en);
							}
							$('#popupDetail .card-header').css("background-color", "rgba(" + feature.properties.daily_us_color + ", 1)");
							$('#popupDetail .card-body').css("background-color", "rgba(" + feature.properties.daily_us_color + ", 1)");
							$('#popupDetail .card-footer').css("background-color", "rgba(" + feature.properties.daily_us_color + ", 1)");
							$('#popupDetail .number_title').html(parseInt(feature.properties.daily_pm25).toFixed());
							$('#popupDetail .number_footer').html('μg/m<sup>3</sup>');
							if(data_lang=="thailand"){
								$('#popupDetail .detail_title').html(feature.properties.daily_us_title);
							}else{
								$('#popupDetail .detail_title').html(feature.properties.daily_us_title_en);
							}
							//$('#popupDetail .detail_time').html(convertDateFormatDay(feature.properties.log_datetime));
							$('#popupDetail .card-body .anime img').attr("src", '/template/image/' + feature.properties.daily_us_dustboy_icon + '.svg');
							$('#popupDetail .card-footer .weahter').html(convertDateFormat(feature.properties.log_datetime)+ ' | PM<sub>2.5</sub> AQI '+feature.properties.daily_pm25_us_aqi);
							$('#popupDetail .card-footer .favorite').html('<a href="/'+feature.properties.dustboy_uri+'" style="color:#fff;"><i class="fa fa-info-circle"></i></a>');
							$('#popupHotspot').hide();		
							$('#popupDetail').show()
						});
					}
				}
				};
				
				var poiLayers_indoor = L.layerGroup([
					L.geoJson(db, geojsonOpts_indoor)
				]);
				
				layerControl.addOverlay(poiLayers_indoor, 'DustBoy Indoor');
			}
		});

		
		
		var uri_hotspot = "/assets/api/getHotspot.php?key=<?= md5(date('ymd')) ?>&type=all&times=1&query=<?= md5(date('his')) ?>";
		var ar_terra=[];
		var ar_virrs=[];
		var ar_noaa=[];
		
		var hotspot_t	= [];
		var hotspot_v	= [];
		var hotspot_n	= [];

		
		var currentHeatMap	= null;
		$.getJSON(uri_hotspot, function(db) {
			
			$.each(db.features, function(index, value) {
				
				if(value.properties.source=="TERAA/AQUA"){
					ar_terra.push(value.properties);
				}
				if(value.properties.source=="S-NPP"){
					ar_virrs.push(value.properties);
				}
				if(value.properties.source=="NOAA-20"){
					ar_noaa.push(value.properties);
				}
				
			});
			
			createHotspot()
		});
		
		function createHotspot(){
			var hotspots_terra = ar_terra;
			var hotspots_virrs = ar_virrs;
			var hotspots_noaa = ar_noaa;

			for (var index = 0; index < hotspot_t.length; index++) {
				var marker_t = hotspot_t[index];
				map.removeLayer(marker_t);
			}
			hotspot_t = [];
			for (let index = 0; index < ar_terra.length; index++) {
		
				let marker_t = L.marker(
					[hotspots_terra[index].latitude, hotspots_terra[index].longitude],
					{
					  icon: L.divIcon({
						className: "my-custom-icon",
						iconSize: [10, 10],
						html: '<div class="signoutz-hotspot" style="background-color:rgba(255, 39, 39, 1)"></div>',
					  }),
					}
				);
				marker_t.on("click", () => {
					currentHeatMap = hotspots_terra[index];
					createHeatMapPopup()
				});
				hotspot_t.push(marker_t);
			}
			var hotspotTerra = L.layerGroup(hotspot_t);
			layerControl.addOverlay(hotspotTerra, 'TERAA/AQUA');

			//viirs
			for (var index = 0; index < hotspot_v.length; index++) {
				var marker_v = hotspot_v[index];
				map.removeLayer(marker_v);
			}
			hotspot_v = [];
			for (let index = 0; index < ar_virrs.length; index++) {
		
				let marker_v = L.marker(
					[hotspots_virrs[index].latitude, hotspots_virrs[index].longitude],
					{
					  icon: L.divIcon({
						className: "my-custom-icon",
						iconSize: [10, 10],
						html: '<div class="signoutz-hotspot" style="background-color:rgba(255, 39, 39, 1)"></div>',
					  }),
					}
				);
				marker_v.on("click", () => {
					currentHeatMap = hotspots_virrs[index];
					createHeatMapPopup()
				});
				hotspot_v.push(marker_v);
			}
			var hotspotViirs = L.layerGroup(hotspot_v);
			layerControl.addOverlay(hotspotViirs, 'S-NNP');
			
			//NOAA20
			for (var index = 0; index < hotspot_n.length; index++) {
				var marker_n = hotspot_n[index];
				map.removeLayer(marker_n);
			}
			hotspot_n = [];
			for (let index = 0; index < ar_noaa.length; index++) {
		
				let marker_n = L.marker(
					[hotspots_noaa[index].latitude, hotspots_noaa[index].longitude],
					{
					  icon: L.divIcon({
						className: "my-custom-icon",
						iconSize: [10, 10],
						html: '<div class="signoutz-hotspot" style="background-color:rgba(255, 39, 39, 1)"></div>',
					  }),
					}
				);
				marker_n.on("click", () => {
					currentHeatMap = hotspots_noaa[index];
					createHeatMapPopup()
				});
				hotspot_n.push(marker_n);
			}
			var hotspotNOAA = L.layerGroup(hotspot_n);
			layerControl.addOverlay(hotspotNOAA, 'NOAA20');

		}
		/*
		
		map.on('overlayadd', onOverlayAdd);
		map.on('overlayremove', onOverlayRemove);
		var hotLayer = [];
		function onOverlayAdd(e){
			//do whatever
			if(e.name=="MODIS" || e.name=="VIIRS"){
				hotLayer.push(e.name);
				chkLeg()
			}
		}
		
		function onOverlayRemove(e){
			//do whatever
			if(e.name=="MODIS" || e.name=="VIIRS"){
				hotLayer.splice( $.inArray(e.name,hotLayer) ,1 );
				chkLeg()
			}
		}
		
		function chkLeg(){
			if(hotLayer.length){
				$('.legend').show();
			}else{
				$('.legend').hide();
			}
		}
		*/
		function createHeatMapPopup(){
			var feature= currentHeatMap;
			console.log(feature);
			$('#popupDetail').hide();		
			$('#popupHotspot .card-header').css("background-color", "rgba(255, 39, 39, 1)");				
			$('#popupHotspot .card-body').css("background-color", "rgba(255, 39, 39, 1)");				
			$('#popupHotspot .btn-close').css("background-color", "rgba(255, 39, 39, 1)");				
			$('#popupHotspot .card-title').html(feature.source);				
			$('#popupHotspot h5').html('ความเชื่อมั่น '+feature.confidence+'%');				
			$('#popupHotspot .card-description #des').html('ตำบล'+feature.tb_tn+' อำเภอ'+feature.ap_tn+' จังหวัด'+feature.pv_tn);				
			$('#popupHotspot .card-description #latlon').html(feature.latitude+', '+feature.longitude);				
			$('#popupHotspot .card-date #datadate').html(' '+getUpdateTime(feature.acq_time_lmt,'date_format'));				
			$('#popupHotspot .card-date #datatime').html(' '+getUpdateTime(feature.acq_time_lmt,'time_format'));
			$('#popupHotspot').show();
		}
		
		function getUpdateTime(text, format){
			var _text = text.split(" ");
			if(format=="date_format"){
				return _text[0];
			}else{
				return _text[1].substring(0,5);
			}
		}
	
		
	});
	
	</script>
</body>

</html>