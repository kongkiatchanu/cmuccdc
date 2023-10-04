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
    <link rel="stylesheet" href="<?=base_url()?>template/css/style.min.css?v=1">
    <link rel="stylesheet" href="<?=base_url()?>template/css/popup.css">
</head>
<body>
    <!-- <div class="btn_contact">
        <div class="stick stick-1"></div>
        <div class="stick stick-2"></div>
        <div class="stick stick-3"></div>
    </div> -->
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
                    <div class="aqi">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link switch_type <?=$_pmType=="usAQI"?'active':''?>" sType="usAQI" redirect='' href="javascript:void(0)">US AQI</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link switch_type <?=$_pmType=="thAQI"?'active':''?>" sType="thAQI" redirect='' href="javascript:void(0)">TH AQI</a>
                            </li>
                        </ul>
                    </div>
                    <div class="lang">
                        <a href="javascript:void(0)" lang="thailand" redirect='' class="switch_lang btn btn-secondary btn-sm <?=$_lang=="thailand"?'active':''?>">TH</a>
                        <a href="javascript:void(0)" lang="english" redirect='' class="switch_lang btn btn-secondary btn-sm <?=$_lang=="english"?'active':''?>">EN</a>
                    </div>
                </div>
                <div class="map col-12">
                    <div class="bg_map">
						<div id="us_map" class="fade_in_ture anime_delay05"></div>
						<?php if($_pmType=="thAQI"){?>
                         <div class="pm_aqi">
                                    <div class="pm fade_in_ture anime_delay1">
                                        <div class="col-2 col-md-7 title_pm_aqi ">PM<sub>2.5</sub><span class="d-none d-md-block">(μg/m<sup>3</sup>)</span></div>
                                        <div class="col-2 col-md-1 detail_pm_aqi" style="background-color: rgb(0, 191, 243);">0-25</div>
                                        <div class="col-2 col-md-1 detail_pm_aqi" style="background-color: rgb(0, 166, 81);">26-37</div>
                                        <div class="col-2 col-md-1 detail_pm_aqi" style="background-color: rgb(255, 242, 0);">38-50</div>
                                        <div class="col-2 col-md-1 detail_pm_aqi" style="background-color: rgb(242, 101, 34);">51-180</div>
                                        <div class="col-2 col-md-1 detail_pm_aqi" style="background-color: rgb(255, 0, 0);">>180</div>
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
						<?php }else{?>
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
						<?php }?>
                    </div>
                    <?php $this->load->view('main/template_popup');?>
				</div>
            </div>
        </div>
    </section>
	<?php $this->load->view('main/template_contact');?>

    <script src="<?=base_url()?>template/js/jquery/jquery.min.js"></script>
    <script src="<?=base_url()?>template/js/popper/popper.min.js"></script>
    <script src="<?=base_url()?>template/js/bootstrap-4.3.1/bootstrap.min.js"></script>
    <script src="<?=base_url()?>template/js/main.js?version=<?=date('YmdHis')?>"></script>
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" crossorigin=""></script>
	
	<link rel="stylesheet" href="/wind-js-leaflet/dist/wind-js-leaflet.css" />
	<script src="/wind-js-leaflet/dist/wind-js-leaflet.js"></script>
	<script src="<?=base_url()?>template/js/apps.js"></script>
    <script>
		$.getJSON("https://www.cmuccdc.org/api2/dustboy/stations", function(db) {
			if (db) {
				<?php if($_pmType=="thAQI"){ ?>
				$.each(db, function(index, value) {
					var marker = L.marker([value.dustboy_lat, value.dustboy_lon], {
						icon: L.divIcon({
							className: "my-custom-pin",
							iconSize: [35, 35],
							iconAnchor: [0, 0],
							labelAnchor: [-6, 0],
							popupAnchor: [17, 0],
							html: '<div class="signoutz-marker"style="background-color:rgba(' + value.th_color + ')">' + value.th_aqi + '</div>'
						})
					}).addTo(map);
					marker.on('click', function(e) {
						<?php if($_lang=="thailand"){ ?>
						$('#popupDetail p').html(value.dustboy_name);
						<?php }else{ ?>
						$('#popupDetail p').html(value.dustboy_name_en);
						<?php } ?>
						$('#popupDetail .card-header').css("background-color", "rgba(" + value.th_color + ", 0.74)");
						$('#popupDetail .card-body').css("background-color", "rgba(" + value.th_color + ", 0.74)");
						$('#popupDetail .card-footer').css("background-color", "rgba(" + value.th_color + ", 0.74)");
						$('#popupDetail .number_title').html(value.th_aqi);
						$('#popupDetail .number_footer').html('PM<sub>2.5</sub><?=$_pmType=="thAQI"?" TH AQI":" US AQI"?>');
						<?php if($_lang=="thailand"){ ?>
						$('#popupDetail .detail_title').html(value.th_title);
						<?php }else{ ?>
						$('#popupDetail .detail_title').html(value.th_title_en);
						<?php } ?>
						$('#popupDetail .card-body .anime img').attr("src", '/template/image/' + value.th_dustboy_icon + '.svg');
						$('#popupDetail .card-footer span.temp').html(value.temp + ' &#8451');
						$('#popupDetail .card-footer span.humid').html(value.humid + ' %');
						$('#popupDetail .card-footer span.pm25').html(value.pm25 + ' μg/m<sup>3</sup>');
						$('#popupDetail .card-footer span.pm10').html(value.pm10 + ' μg/m<sup>3</sup>');
						$('#popupDetail').show();
					});
				});
				<?php }else{ ?>
				$.each(db, function(index, value) {
					var marker = L.marker([value.dustboy_lat, value.dustboy_lon], {
						icon: L.divIcon({
							className: "my-custom-pin",
							iconSize: [35, 35],
							iconAnchor: [0, 0],
							labelAnchor: [-6, 0],
							popupAnchor: [17, 0],
							html: '<div class="signoutz-marker"style="background-color:rgba(' + value.us_color + ')">' + value.us_aqi + '</div>'
						})
					}).addTo(map);
					marker.on('click', function(e) {
						<?php if($_lang=="thailand"){ ?>
						$('#popupDetail p').html(value.dustboy_name);
						<?php }else{ ?>
						$('#popupDetail p').html(value.dustboy_name_en);
						<?php } ?>
						$('#popupDetail .card-header').css("background-color", "rgba(" + value.us_color + ", 0.74)");
						$('#popupDetail .card-body').css("background-color", "rgba(" + value.us_color + ", 0.74)");
						$('#popupDetail .card-footer').css("background-color", "rgba(" + value.us_color + ", 0.74)");
						$('#popupDetail .number_title').html(value.us_aqi);
						$('#popupDetail .number_footer').html('PM<sub>2.5</sub><?=$_pmType=="thAQI"?" TH AQI":" US AQI"?>');
						<?php if($_lang=="thailand"){ ?>
						$('#popupDetail .detail_title').html(value.us_title);
						<?php }else{ ?>
						$('#popupDetail .detail_title').html(value.us_title_en);
						<?php } ?>
						$('#popupDetail .card-body .anime img').attr("src", '/template/image/' + value.us_dustboy_icon + '.svg');
						$('#popupDetail .card-footer span.temp').html(value.temp + ' &#8451');
						$('#popupDetail .card-footer span.humid').html(value.humid + ' %');
						$('#popupDetail .card-footer span.pm25').html(value.pm25 + ' μg/m<sup>3</sup>');
						$('#popupDetail .card-footer span.pm10').html(value.pm10 + ' μg/m<sup>3</sup>');
						$('#popupDetail').show();
					});
				});
				<?php } ?>
			}
		});
	</script>
</body>

</html>