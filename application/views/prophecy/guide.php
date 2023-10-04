<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    include_once('assets/prophecy/pdf/Thaidate/Thaidate.php');
    include_once('assets/prophecy/pdf/Thaidate/thaidate-functions.php');
    // echo '<pre>';
    // print_r($province);
    // echo '</pre>';
    // exit();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- <title><?=$siteInfo['pre_title']?> | <?=$siteInfo['site_title']?></title> -->
	<!-- <meta name="description" content="<?=$siteInfo['site_des']?>"> -->
	<!-- <meta name="keywords" content="<?=$siteInfo['site_keyword']?>"> -->
    <title>คู่มือการติดตั้ง ใช้งาน และบำรุงรักษาเครื่อง Dustboy | CCDC : Climate Change Data Center</title>    
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>template/image/icon_ccdc.ico">
    <link rel="stylesheet" href="<?=base_url('assets/prophecy/assets/css/bootstrap-4.3.1/bootstrap.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/prophecy/assets/fontawesome/css/all.min.css');?>">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/v1.4.1/mapbox-gl.css'>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.70.0/dist/L.Control.Locate.min.css" />
    <link rel="stylesheet" href="<?=base_url('assets/prophecy/assets/css/style2_guide.min.css?v=').date('YmdHis');?>">
    <script src="<?=base_url()?>template/js/jquery/jquery.min.js"></script>
	<?php $this->load->view('main/analytics');?>
    <style>
        .main_title{
            height: 13vh !important;
        }
        .main_detail{
            min-height: 50vh !important;
        }
    </style>
</head>

<body>
    <!-- ปุ่ม contact -->
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
    <!-- ปุ่ม contact -->
    <!-- เมนูเวลาเลื่อนลงมา -->
    <section id="menu_slide" class="frist">
        <div class="main_menu">
            <?php $this->load->view('main/template_nav');?>
        </div>
    </section>
    <!-- เมนูเวลาเลื่อนลงมา -->
    <section id="main">
        <div class="container-fluid">
            <?php $this->load->view('main/template_header');?>
            <div class="main_content">
                <div class="content">
                    <div class="main_title">
                        <!-- <h3 class="title_on_video"> <i class="fas fa-square mr-3" style="font-size:11px;"></i> รายงานค่ามลพิษทางอากาศ</h3> -->
                        <div class="container"> 
                            <div class="row"> 
                                <div class="col-md-12"> 
                                    <h3 class="page_title text-white d-flex align-items-center">
                                        <i class="fas fa-square mr-3" style="font-size:11px;"></i> <span style="font-size:20px;">คู่มือการติดตั้ง ใช้งาน และบำรุงรักษาเครื่อง Dustboy</span>
                                    </h3> 
                                </div> 
                            </div> 
                        </div>
                    </div>
                    
                    <div class="main_detail">
                        <div class="container py-3 mb-5 mb-md-4">
                            <div class="row w-100">
                                <div class="col-12 col-md-6 col-lg guide-box">
                                    <!-- <a href="<?=base_url('assets/prophecy/assets/pdf/guide/model Pro.pdf');?>" target="_blank"> -->
                                        <div class="img-box">
                                            <img src="<?=base_url('assets/prophecy/assets/image/guide/1ModelPro.jpg');?>" alt="">
                                        </div>
                                        <span class="title">Model Pro</span>
                                        <span class="description">คู่มือ Model Pro</span>
                                        <p class="pt-1">
                                            <a href="<?=base_url('assets/prophecy/assets/pdf/guide/model Pro.pdf');?>" target="_blank">
                                                <i class="far fa-file-alt mr-2"></i> | 
                                            </a>
                                            <a href="<?=base_url('assets/prophecy/assets/pdf/guide/model Pro.pdf');?>" target="_blank">
                                                <i class="fas fa-video text-muted ml-2"></i>
                                            </a>
                                        </p>
                                    <!-- </a> -->
                                </div>
                                <div class="col-12 col-md-6 col-lg guide-box">
                                    <a href="<?=base_url('assets/prophecy/assets/pdf/guide/model P.pdf');?>" target="_blank">
                                        <div class="img-box">
                                            <img src="<?=base_url('assets/prophecy/assets/image/guide/2ModelP.jpg');?>" alt="">
                                        </div>
                                        <span class="title">Model P</span>
                                        <span class="description">คู่มือ Model P</span>
                                        <p class="pt-1">
                                            <a href="<?=base_url('assets/prophecy/assets/pdf/guide/model P.pdf');?>" target="_blank">
                                                <i class="far fa-file-alt mr-2"></i> | 
                                            </a>
                                            <a href="<?=base_url('assets/prophecy/assets/pdf/guide/model P.pdf');?>" target="_blank">
                                                <i class="fas fa-video text-muted ml-2"></i>
                                            </a>
                                        </p>
                                    </a>
                                </div>
                                <div class="col-12 col-md-6 col-lg guide-box">
                                    <!-- <a href="<?=base_url('assets/prophecy/assets/pdf/guide/4. User manual model IN.pdf');?>" target="_blank"> -->
                                        <div class="img-box">
                                            <img src="<?=base_url('assets/prophecy/assets/image/guide/3ModelIN.jpg');?>" alt="">
                                        </div>
                                        <span class="title">Model IN</span>
                                        <span class="description">คู่มือ Model IN</span>
                                        <p class="pt-1">
                                            <a href="<?=base_url('assets/prophecy/assets/pdf/guide/4. User manual model IN.pdf');?>" target="_blank">
                                                <i class="far fa-file-alt mr-2"></i> | 
                                            </a>
                                            <a href="https://www.youtube.com/watch?app=desktop&v=T9bsckVlGKI" target="_blank">
                                                <i class="fas fa-video ml-2"></i>
                                            </a>
                                        </p>
                                    <!-- </a> -->
                                </div>
                                <div class="col-12 col-md-6 col-lg guide-box">
                                    <!-- <a href="<?=base_url('assets/prophecy/assets/pdf/guide/[update]Dust Boy mini Model N.pdf');?>" target="_blank"> -->
                                        <div class="img-box">
                                            <img src="<?=base_url('assets/prophecy/assets/image/guide/4ModelNblack.jpg');?>" alt="">
                                        </div>
                                        <span class="title">Model N (ดำ)</span>
                                        <span class="description">คู่มือ Model N (ดำ)</span>
                                        <p class="pt-1">
                                            <a href="<?=base_url('assets/prophecy/assets/pdf/guide/[update]Dust Boy mini Model N.pdf');?>" target="_blank">
                                                <i class="far fa-file-alt mr-2"></i> | 
                                            </a>
                                            <a href="<?=base_url('assets/prophecy/assets/pdf/guide/[update]Dust Boy mini Model N.pdf');?>" target="_blank">
                                                <i class="fas fa-video text-muted ml-2"></i>
                                            </a>
                                        </p>
                                    <!-- </a> -->
                                </div>
                                <div class="col-12 col-md-6 col-lg guide-box">
                                    <!-- <a href="<?=base_url('assets/prophecy/assets/pdf/guide/Dust Boy mini Model N (hard case).pdf');?>" target="_blank"> -->
                                        <div class="img-box">
                                            <img src="<?=base_url('assets/prophecy/assets/image/guide/5ModelNwh.jpg');?>" alt="">
                                        </div>
                                        <span class="title">Model N (ขาว)</span>
                                        <span class="description">คู่มือ Model N (ขาว)</span>
                                        <p class="pt-1">
                                            <a href="<?=base_url('assets/prophecy/assets/pdf/guide/Dust Boy mini Model N (hard case).pdf');?>" target="_blank">
                                                <i class="far fa-file-alt mr-2"></i> | 
                                            </a>
                                            <a href="https://www.youtube.com/watch?app=desktop&v=kEW4DkDyu1o" target="_blank">
                                                <i class="fas fa-video ml-2"></i>
                                            </a>
                                        </p>
                                    <!-- </a> -->
                                </div>
                            </div>
                            <div class="row w-100">
                                <div class="col-12 col-md-6 col-lg guide-box">
                                    <!-- <a href="#" target="_blank"> -->
                                        <div class="img-box">
                                            <img src="<?=base_url('assets/prophecy/assets/image/guide/6ModelNoffline.jpg');?>" alt="">
                                        </div>
                                        <span class="title">Model N offline</span>
                                        <span class="description">คู่มือ Model N offline</span>
                                        <p class="pt-1">
                                            <a href="#" target="_blank">
                                                <i class="far fa-file-alt mr-2"></i> | 
                                            </a>
                                            <a href="#" target="_blank">
                                                <i class="fas fa-video text-muted ml-2"></i>
                                            </a>
                                        </p>
                                    <!-- </a> -->
                                </div>
                                <div class="col-12 col-md-6 col-lg guide-box">
                                    <!-- <a href="<?=base_url('assets/prophecy/assets/pdf/guide/Dust Boy mini Model N NB.pdf');?>" target="_blank"> -->
                                        <div class="img-box">
                                            <img src="<?=base_url('assets/prophecy/assets/image/guide/7Model N-NB.jpg');?>" alt="">
                                        </div>
                                        <span class="title">Model N-NB</span>
                                        <span class="description">คู่มือ Model N-NB</span>
                                        <p class="pt-1">
                                            <a href="<?=base_url('assets/prophecy/assets/pdf/guide/Dust Boy mini Model N NB.pdf');?>" target="_blank">
                                                <i class="far fa-file-alt mr-2"></i> | 
                                            </a>
                                            <a href="<?=base_url('assets/prophecy/assets/pdf/guide/Dust Boy mini Model N NB.pdf');?>" target="_blank">
                                                <i class="fas fa-video text-muted ml-2"></i>
                                            </a>
                                        </p>
                                    <!-- </a> -->
                                </div>
                                <div class="col-12 col-md-6 col-lg guide-box">
                                    <!-- <a href="<?=base_url('assets/prophecy/assets/pdf/guide/Dust Boy mini Model T V.1.pdf');?>" target="_blank"> -->
                                        <div class="img-box">
                                            <img src="<?=base_url('assets/prophecy/assets/image/guide/8Model T.jpg');?>" alt="">
                                        </div>
                                        <span class="title">Model T</span>
                                        <span class="description">คู่มือ Model T</span>
                                        <p class="pt-1">
                                            <a href="<?=base_url('assets/prophecy/assets/pdf/guide/Dust Boy mini Model T V.1.pdf');?>" target="_blank">
                                                <i class="far fa-file-alt mr-2"></i> | 
                                            </a>
                                            <a href="<?=base_url('assets/prophecy/assets/pdf/guide/Dust Boy mini Model T V.1.pdf');?>" target="_blank">
                                                <i class="fas fa-video text-muted ml-2"></i>
                                            </a>
                                        </p>
                                    <!-- </a> -->
                                </div>
                                <div class="col-12 col-md-6 col-lg guide-box">
                                    <!-- <a href="<?=base_url('assets/prophecy/assets/pdf/guide/Dust Boy mini Model NH.pdf');?>" target="_blank"> -->
                                        <div class="img-box">
                                            <img src="<?=base_url('assets/prophecy/assets/image/guide/9Model NH.jpg');?>" alt="">
                                        </div>
                                        <span class="title">Model NH</span>
                                        <span class="description">คู่มือ Model NH</span>
                                        <p class="pt-1">
                                            <a href="<?=base_url('assets/prophecy/assets/pdf/guide/Dust Boy mini Model NH.pdf');?>" target="_blank">
                                                <i class="far fa-file-alt mr-2"></i> | 
                                            </a>
                                            <a href="https://www.youtube.com/watch?app=desktop&v=wsAGgU9bYok" target="_blank">
                                                <i class="fas fa-video ml-2"></i>
                                            </a>
                                        </p>
                                    <!-- </a> -->
                                </div>
                                <div class="col-12 col-md-6 col-lg guide-box">
                                    <!-- <a href="#" target="_blank"> -->
                                        <div class="img-box">
                                            <img src="<?=base_url('assets/prophecy/assets/image/guide/10Model T Plus.jpg?v=3');?>" alt="">
                                        </div>
                                        <span class="title">Model T Plus</span>
                                        <span class="description">คู่มือ Model T Plus</span>
                                        <p class="pt-1">
                                            <a href="<?=base_url('assets/prophecy/assets/pdf/guide/DustBoy model T Plus_Manual.pdf');?>" target="_blank">
                                                <i class="far fa-file-alt mr-2"></i> | 
                                            </a>
                                            <a href="#" target="_blank">
                                                <i class="fas fa-video text-muted ml-2"></i>
                                            </a>
                                        </p>
                                    <!-- </a> -->
                                </div>
                            </div>
                            <div class="row w-100">
                                <div class="col-12 col-md-6">
                                    <img class="w-100" src="<?=base_url('assets/prophecy/assets/image/guide/qa-01.jpg');?>" alt="">
                                </div>
                                <div class="col-12 col-md-6">
                                    <img class="w-100" src="<?=base_url('assets/prophecy/assets/image/guide/qa-02.jpg');?>" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php $this->load->view('main/template_contact');?>

    <script src="<?=base_url('assets/prophecy/assets/js/all/compress.min.js?v=').date('YmdHis');?>"></script>
    <script src="<?=base_url('assets/prophecy/assets/js/report_podd.js?v=').date('YmdHis');?>"></script>
</body>

</html>