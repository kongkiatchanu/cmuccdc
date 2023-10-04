<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $version = md5('signoutz');?>
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
    <link rel="stylesheet" href="<?=base_url()?>template/css/bootstrap-4.3.1/bootstrap.min.css?v=<?=$version?>">
    <link rel="stylesheet" href="<?=base_url()?>template/fontawesome/css/all.min.css?v=<?=$version?>">
    <link rel="stylesheet" href="<?=base_url()?>template/css/style.min.css?v=<?=$version?>">
    <link rel="stylesheet" href="<?=base_url()?>template/css/popup.css?v=<?=$version?>">
	
	<link rel="stylesheet" href="<?=base_url()?>assets/plugins/leaflet/leaflet.css?v=<?=$version?>" />
	<link rel="stylesheet" href="<?=base_url()?>assets/plugins/leaflet-velocity_tkws/leaflet-velocity.css?v=<?=$version?>" />
	<link rel="stylesheet" href="<?=base_url()?>assets/plugins/leafletTimeDimension/leaflet.timedimension.control.min.css?v=<?=$version?>" />
	<?php $this->load->view('main/analytics');?>
</head>
<body>
<style>section#main .main_content .map .card .card-body .detail .detail_time{color:#eee;font-size:small}section#main .main_content .map .card{z-index:9999!important}#floating-panel{position:absolute;bottom:10px;right:10px;z-index:10000;background-color:#0d374d;padding:2px;opacity:.9;color:#fff;font-family:sans-serif;font-weight:100;font-size:x-small}#floating-panel #data-timer{font-family:kanit,sans-serif;padding:5px}#floating-panel ul{list-style-type:none;padding-left:10px;padding-right:10px}#floating-panel ul li>label{display:block;margin:2px}#floating-panel ul li{margin-bottom:10px}.leaflet-container .leaflet-control-search{position:relative;float:left;background:#fff;color:#1978cf;border:2px solid rgba(0,0,0,.2);background-clip:padding-box;-moz-border-radius:4px;-webkit-border-radius:4px;border-radius:4px;background-color:rgba(255,255,255,.8);z-index:1000;margin-left:9px;margin-top:9px}.leaflet-control-search.search-exp{background:#fff;border:2px solid rgba(0,0,0,.2);background-clip:padding-box}.leaflet-control-search .search-input{display:block;float:left;background:#fff;border:1px solid #666;border-radius:2px;height:30px;padding:0 20px 0 2px;margin:4px 0 4px 4px}.leaflet-control-search.search-load .search-input{background:url(/template/image/loader.gif) no-repeat center right #fff}.leaflet-control-search.search-load .search-cancel{visibility:hidden}.leaflet-control-search .search-cancel{display:block;width:22px;height:22px;position:absolute;right:28px;margin:4px 0;background:url(/template/img/btn-cancel.png?v3) no-repeat center;text-decoration:none;opacity:.8}.leaflet-control-search .search-cancel:hover{opacity:1}.leaflet-control-search .search-cancel span{display:none;font-size:18px;line-height:20px;color:#ccc;font-weight:700}.leaflet-control-search .search-cancel:hover span{color:#aaa}.leaflet-control-search .search-button{display:block;float:left;width:33px;height:33px;background:url(/template/img/btn-search.png?v3) no-repeat 9px 9px #fff;border-radius:4px;margin:0}.leaflet-control-search .search-tooltip{position:absolute;top:100%;left:0;float:left;list-style:none;padding-left:0;min-width:120px;max-height:122px;box-shadow:1px 1px 6px rgba(0,0,0,.4);background-color:rgba(0,0,0,.25);z-index:1010;overflow-y:auto;overflow-x:hidden;cursor:pointer}.leaflet-control-search .search-tip{margin:2px;padding:2px 4px;display:block;color:#000;background:#eee;border-radius:.25em;text-decoration:none;white-space:nowrap;vertical-align:center}.leaflet-control-search .search-button:hover{background-color:#f4f4f4}.leaflet-control-search .search-tip-select,.leaflet-control-search .search-tip:hover{background-color:#fff}.leaflet-control-search .search-alert{cursor:pointer;clear:both;font-size:.75em;margin-bottom:5px;padding:0 .25em;color:#e00;font-weight:700;border-radius:.25em}#sw_source{vertical-align:middle;margin:.25rem .1rem;padding:0 .75rem .1rem .75rem;border-radius:15px;font-size:.75rem;color:#fff;background-color:#0c364c}section#main .main_content .sub_menu .aqi{width:70%;font-family:Kanit,sans-serif;font-size:.9rem;text-align:right}section#main .main_content .sub_menu .aqi .btn-group{width:auto}section#main .main_content .sub_menu .aqi .btn-group .btn{color:#fff;background-color:#0c364c;border:none;font-size:.75rem;font-weight:600;line-height:1.5;text-transform:uppercase;border-radius:50rem!important;padding:.25em .65rem .25em 1rem}section#main .main_content .sub_menu .aqi .btn-group .dropdown-menu{background-color:#0c364c;border:none;font-size:.75rem;color:#fff}section#main .main_content .sub_menu .aqi .btn-group .dropdown-menu .dropdown-item{cursor:pointer;text-transform:uppercase}section#main .main_content .sub_menu .aqi .btn-group .dropdown-menu .dropdown-item:hover{color:#76b7b4;background-color:#0c364c}section#main .main_content .sub_menu .aqi .btn-group .dropdown-menu .dropdown-item.active,section#main .main_content .sub_menu .aqi .btn-group .dropdown-menu .dropdown-item:active{color:#76b7b4;background-color:#0c364c}.fullscreen-icon{background-image:url(/assets/plugins/leaflet.fullscreen-master/icon-fullscreen.png)}.leaflet-retina .fullscreen-icon{background-image:url(/assets/plugins/leaflet.fullscreen-master/icon-fullscreen-2x.png);background-size:26px 26px}.leaflet-container:-webkit-full-screen{width:100%!important;height:100%!important;z-index:0}.leaflet-container:-ms-fullscreen{width:100%!important;height:100%!important;z-index:0}.leaflet-container:full-screen{width:100%!important;height:100%!important;z-index:0}.leaflet-container:fullscreen{width:100%!important;height:100%!important;z-index:0}.leaflet-pseudo-fullscreen{position:fixed!important;width:100%!important;height:100%!important;top:0!important;left:0!important;z-index:0}</style>
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
                        <a href="javascript:void(0)" lang="thailand" redirect='' class="switch_lang btn btn-secondary btn-sm <?=$_lang=="thailand"?'active':''?>">TH</a>
                        <a href="javascript:void(0)" lang="english" redirect='' class="switch_lang btn btn-secondary btn-sm <?=$_lang=="english"?'active':''?>">EN</a>
                    </div>
					<?php 

					$ar = array(
						'th-hr'=>'Th (Hourly)',
						'us-hr'=>'Us (Hourly)',
						'th-dy'=>'Th (Daily)',
						'us-dy'=>'Us (Daily)',
					);?>
                    <div class="aqi">
						<div class="btn-group">
							<button id="sw_source" class="btn dropdown-toggle shadow-drop-bottom-sub_menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?=$this->input->cookie('data_index',true)!=null? $ar[$this->input->cookie('data_index',true)]:$ar['th-hr']?></button>
							<div class="dropdown-menu dropdown-menu-right shadow-drop-bottom-sub_menu">
								<a class="dropdown-item switch_type2 <?=$this->input->cookie('data_index',true)=="th-hr"?'active':''?>" data_index="th-hr">Th (Hourly)</a>					
								<a class="dropdown-item switch_type2 <?=$this->input->cookie('data_index',true)=="th-dy"?'active':''?>" data_index="th-dy">Th (Daily)</a>
								<a class="dropdown-item switch_type2 <?=$this->input->cookie('data_index',true)=="us-hr"?'active':''?>" data_index="us-hr">Us (Hourly)</a>
								<a class="dropdown-item switch_type2 <?=$this->input->cookie('data_index',true)=="us-dy"?'active':''?>" data_index="us-dy">Us (Daily)</a>
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
							<span id="data-timer">Loading...</span>
						</div>
						</div>
						<?php if($this->input->cookie('data_index',true)==null || $this->input->cookie('data_index',true)=="th-hr"){?>
							<div id="th_index"></div>
						<?php }else if($this->input->cookie('data_index',true)=="th-dy"){?>
							<div id="th_index_daily"></div>
						<?php }else if($this->input->cookie('data_index',true)=="us-hr"){?>
							<div id="us_index"></div>
						<?php }else if($this->input->cookie('data_index',true)=="us-dy"){?>
							<div id="us_index_daily"></div>
						<?php }?>
                    </div>
					<?php $this->load->view('main/template_popup');?>
                </div>
            </div>
        </div>
    </section>
	<?php $this->load->view('main/template_contact');?>

    <script src="<?=base_url()?>template/js/jquery/jquery.min.js?v=<?=$version?>"></script>
    <script src="<?=base_url()?>template/js/popper/popper.min.js?v=<?=$version?>"></script>
    <script src="<?=base_url()?>template/js/bootstrap-4.3.1/bootstrap.min.js?v=<?=$version?>"></script>
    
	<script src="<?=base_url()?>assets/plugins/leaflet/leaflet.js?v=<?=$version?>" ></script>
	<script src="<?=base_url()?>assets/plugins/esri-leaflet/esri-leaflet.js?v=<?=$version?>" ></script>
	<script src="<?=base_url()?>assets/plugins/leaflet-velocity_tkws/leaflet-velocity.js?v=<?=$version?>"></script>
	
	<script src="https://unpkg.com/georaster"></script>
    <script src="https://unpkg.com/proj4"></script>
    <script src="https://unpkg.com/georaster-layer-for-leaflet/georaster-layer-for-leaflet.browserify.min.js"></script>
	<!--<script src="<?=base_url()?>assets/plugins/leaflet.fullscreen-master/Control.FullScreen.js"></script>-->
	<script>
	var vmap = '<?=$vmap_file?>';
	var vmap_us = '<?=$vmap_file_us?>';
	var data_lang = '<?=$_lang?>';
	var token = '<?=md5(date("YmdH"))?>';
	</script>
	<script src="<?=base_url()?>template/js/ccdc_app_dev_min.js?v=<?=$version?>"></script>
</body>

</html>