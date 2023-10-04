<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    include_once('assets/prophecy/pdf/Thaidate/Thaidate.php');
	include_once('assets/prophecy/pdf/Thaidate/thaidate-functions.php');
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
    <title>รายงานประจำวัน วช. | CCDC : Climate Change Data Center</title>    
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>template/image/icon_ccdc.ico">
    <link rel="stylesheet" href="<?=base_url('assets/prophecy/assets/css/bootstrap-4.3.1/bootstrap.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/prophecy/assets/fontawesome/css/all.min.css');?>">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/v1.4.1/mapbox-gl.css'>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.70.0/dist/L.Control.Locate.min.css" />
    <link rel="stylesheet" href="<?=base_url('assets/prophecy/assets/css/style2.min.css?v=').date('YmdHis');?>">
    <script src="<?=base_url()?>template/js/jquery/jquery.min.js"></script>
    <script src="<?=base_url('assets/prophecy/assets/js/all/compress.min.js?v=').date('YmdHis');?>"></script>
	<?php $this->load->view('main/analytics');?>
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
                                        <i class="fas fa-square mr-3" style="font-size:11px;"></i> รายงานประจำวัน วช.
                                    </h3> 
                                </div> 
                            </div> 
                        </div>
                    </div>
                    
                    <div class="main_detail">
                        <div style="padding: 15px;z-index: 1;">
                            <link rel="stylesheet" href="<?=base_url()?>assets/prophecy/assets/font/supermarket/stylesheet.css">
                            <style>

                                .table-column-custom:nth-of-type(2) {
                                    text-align: left !important;
                                    -ms-flex-preferred-size: 50%;
                                    flex-basis: 60%;
                                    font-size: 14px;
                                    -webkit-box-pack: start;
                                    -ms-flex-pack: start;
                                    justify-content: flex-start;
                                    white-space: nowrap;
                                    text-overflow: ellipsis;
                                    display: block;
                                    overflow: hidden;
                                }
                                .table-column:first-of-type {
                                    flex-basis: 10%;
                                }
                                .table-column:nth-of-type(3),
                                .table-column:nth-of-type(4) {
                                    flex-basis: 30%;
                                    text-align: center;
                                }

                                .ab{position: absolute;font-family: 'supermarket' !important;}
                                .db_name{font-size:17px;line-height: 17px;}
                                .ab.temp{left: 80px;top: 15px;font-size: 30px;}
                                .ab.d2 {
                                    top: 55px;
                                    font-size: 25px;
                                    left: 94px;
                                    width: 170px;
                                    text-align: right;
                                }
                                .ab.d {
                                    top: 55px;
                                    font-size: 25px;
                                    left: 272px;
                                    width: 44px;
                                    text-align: center;
                                }
                                .ab.m {
                                    top: 55px;
                                    font-size: 25px;
                                    left: 322px;
                                }
                                .ab.t {
                                    top: 55px;
                                    font-size: 25px;
                                    left: 487px;
                                    width: 95px;
                                    text-align: center;
                                }
                                .ab.hourly {
                                    font-size: 30px;
                                    width: 50px;
                                    text-align: center;
                                }
                                .ab.daily {
                                    font-size: 22px;
                                    width: 40px;
                                    text-align: center;
                                }

                                .ab.a1_h{
                                    top: 143px;
                                    left: 116px;
                                }
                                .ab.a1_d{
                                    top: 158px;
                                    left: 170px;
                                }
                                .ab.a1_name{
                                    top: 200px;
                                    left: 46px;
                                    width: 150px;
                                }

                                .ab.a2_h{
                                    top: 239px;
                                    left: 86px;
                                }
                                .ab.a2_d{
                                    top: 255px;
                                    left: 140px;
                                }
                                .ab.a2_name {
                                    top: 297px;
                                    left: 7px;
                                    width: 233px;
                                }

                                .ab.a3_h{
                                    top: 316px;
                                    left: 92px;
                                }
                                .ab.a3_d{
                                    top: 332px;
                                    left: 145px;
                                }
                                .ab.a3_name {
                                    top: 375px;
                                    left: 7px;
                                    width: 233px;
                                }

                                .ab.a4_h{
                                    top: 410px;
                                    left: 50px;
                                }
                                .ab.a4_d{
                                    top: 428px;
                                    left: 102px;
                                }
                                .ab.a4_name {
                                    top: 470px;
                                    left: 7px;
                                    width: 233px;
                                }

                                .ab.a5_h{
                                    top: 501px;
                                    left: 113px;
                                }
                                .ab.a5_d{
                                    top: 516px;
                                    left: 166px;
                                }
                                .ab.a5_name {
                                    top: 560px;
                                    left: 41px;
                                    width: 184px;
                                }

                                .ab.a6_h{
                                    top: 601px;
                                    left: 86px;
                                }
                                .ab.a6_d{
                                    top: 619px;
                                    left: 141px;
                                }
                                .ab.a6_name {
                                    top: 662px;
                                    left: 7px;
                                    width: 233px;
                                }

                                .ab.a7_h{
                                    top: 271px;
                                    left: 289px;
                                }
                                .ab.a7_d{
                                    top: 288px;
                                    left: 344px;
                                }
                                .ab.a7_name {
                                    top: 333px;
                                    left: 250px;
                                    width: 95px;
                                }

                                .ab.a8_h{
                                    top: 339px;
                                    left: 360px;
                                }
                                .ab.a8_d{
                                    top: 354px;
                                    left: 415px;
                                }
                                .ab.a8_name {
                                    top: 398px;
                                    left: 326px;
                                    width: 194px;
                                }

                                .ab.a9_h{
                                    top: 148px;
                                    left: 369px;
                                }
                                .ab.a9_d{
                                    top: 163px;
                                    left: 424px;
                                }
                                .ab.a9_name {
                                    top: 206px;
                                    left: 308px;
                                    width: 185px;
                                }

                                .ab.a10_h{
                                    top: 189px;
                                    left: 505px;
                                }
                                .ab.a10_d{
                                    top: 205px;
                                    left: 560px;
                                }
                                .ab.a10_name {
                                    top: 250px;
                                    left: 448px;
                                    width: 185px;
                                }


                                .ab.a11_h{
                                    top: 280px;
                                    left: 567px;
                                }
                                .ab.a11_d{
                                    top: 295px;
                                    left: 623px;
                                }
                                .ab.a11_name {
                                    top: 340px;
                                    left: 505px;
                                    width: 185px;
                                }

                                .ab.a12_h{
                                    top: 404px;
                                    left: 564px;
                                }
                                .ab.a12_d{
                                    top: 423px;
                                    left: 618px;
                                }
                                .ab.a12_name {
                                    top: 459px;
                                    left: 496px;
                                    width: 178px;
                                }

                                .ab.a13_h{
                                    top: 488px;
                                    left: 404px;
                                }
                                .ab.a13_d{
                                    top: 506px;
                                    left: 458px;
                                }
                                .ab.a13_name {
                                    top: 545px;
                                    left: 342px;
                                    width: 226px;
                                }

                                .ab.a14_h{
                                    top: 579px;
                                    left: 322px;
                                }
                                .ab.a14_d{
                                    top: 595px;
                                    left: 377px;
                                }
                                .ab.a14_name {
                                    top: 635px;
                                    left: 307px;
                                    width: 140px;
                                }
                            </style>
                            <h5 class="text-center">รายงานค่าฝุ่น</h5>
                            <h5 class="text-center">ประวันจำวันวันที่ <?=ConvertToThaiDate(date('Y-m-d'),0)?> เวลา <?=$ar_info['t']?></h5>

                            <?php 
                                $image_bg = $this->uri->segment(3)<13? base_url().'assets/image_pdf/bg7.jpg?v=11':base_url().'assets/image_pdf/bg4.jpg?v=11';
                            ?>
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <div class="mb-3">
                                            <button type="button" id="save_image_locally" class="btn btn-info btn-sm"><i class="far fa-file-image"></i> Download JPEG file</button>
                                            <!--<a href="<?=base_url()?>dailyreportpdf/<?=$this->uri->segment(3)?>" target="_blank" class="btn btn-danger btn-sm"><i class="far fa-file-pdf"></i> Download PDF file</a>-->
                                        </div>
                                        <div id="imagesave" style="width:700px;margin:0 auto;position: relative;">
                                            <img src="<?=$image_bg?>" style="width:700px;margin:0 auto;">
                                            <div class="ab temp"><?=$ar_info['temp']?></div>
                                            <div class="ab d2"><?=$ar_info['d2']?></div>
                                            <div class="ab d"><?=$ar_info['d']?></div>
                                            <div class="ab m"><?=$ar_info['m']?></div>
                                            <div class="ab t"><?=$ar_info['t']?></div>
                                            
                                            <?php 
                                            $res_ids = array(5281,5264,5263,5265,5266,5267);
                                            $res = getResult($ar_list, $res_ids);
                                            if($res!=null){
                                                $pm25 = $res->pm25;
                                                $daily_pm25 = $res->daily_pm25;
                                                $name = $res->dustboy_name;
                                            }else{
                                                $pm25 = 'N/A';
                                                $daily_pm25 = 'N/A';
                                                $name = 'N/A';
                                            }
                                            ?>
                                            <div class="ab a1_h hourly" style="color: rgb(<?=@$res->th_color?>);"><?=$pm25?></div>
                                            <div class="ab a1_d daily" style="color: rgb(<?=@$res->daily_th_color?>);"><?=$daily_pm25?></div>
                                            <div class="ab a1_name db_name"><?=$name?></div>
                                            
                                            
                                            <?php 
                                            $res_ids = array(5212,5614,5615,5616,5618,5278);
                                            $res = getResult($ar_list, $res_ids);
                                            if($res!=null){
                                                $pm25 = $res->pm25;
                                                $daily_pm25 = $res->daily_pm25;
                                                $name = $res->dustboy_name;
                                            }else{
                                                $pm25 = 'N/A';
                                                $daily_pm25 = 'N/A';
                                                $name = 'N/A';
                                            }
                                            ?>
                                            <div class="ab a2_h hourly" style="color: rgb(<?=@$res->th_color?>);"><?=$pm25?></div>
                                            <div class="ab a2_d daily" style="color: rgb(<?=@$res->daily_th_color?>);"><?=$daily_pm25?></div>
                                            <div class="ab a2_name db_name"><?=$name?></div>
                                            
                                            <?php 
                                            $res_ids = array(5047,5031,5032,5046,5399,5428);
                                            $res = getResult($ar_list, $res_ids);
                                            if($res!=null){
                                                $pm25 = $res->pm25;
                                                $daily_pm25 = $res->daily_pm25;
                                                $name = $res->dustboy_name;
                                            }else{
                                                $pm25 = 'N/A';
                                                $daily_pm25 = 'N/A';
                                                $name = 'N/A';
                                            }
                                            ?>
                                            <div class="ab a3_h hourly" style="color: rgb(<?=@$res->th_color?>);"><?=$pm25?></div>
                                            <div class="ab a3_d daily" style="color: rgb(<?=@$res->daily_th_color?>);"><?=$daily_pm25?></div>
                                            <div class="ab a3_name db_name"><?=$name?></div>
                                            
                                            
                                            <?php 
                                            $res_ids = array(5315,5361,5062,6008,110,5242);
                                            $res = getResult($ar_list, $res_ids);
                                            if($res!=null){
                                                $pm25 = $res->pm25;
                                                $daily_pm25 = $res->daily_pm25;
                                                $name = $res->dustboy_name;
                                            }else{
                                                $pm25 = 'N/A';
                                                $daily_pm25 = 'N/A';
                                                $name = 'N/A';
                                            }
                                            ?>
                                            <div class="ab a4_h hourly" style="color: rgb(<?=@$res->th_color?>);"><?=$pm25?></div>
                                            <div class="ab a4_d daily" style="color: rgb(<?=@$res->daily_th_color?>);"><?=$daily_pm25?></div>
                                            <div class="ab a4_name db_name"><?=$name?></div>
                                            
                                            <?php 
                                            $res_ids = array(5324,5291,5323,5338,5337,5638);
                                            $res = getResult($ar_list, $res_ids);
                                            if($res!=null){
                                                $pm25 = $res->pm25;
                                                $daily_pm25 = $res->daily_pm25;
                                                $name = $res->dustboy_name;
                                            }else{
                                                $pm25 = 'N/A';
                                                $daily_pm25 = 'N/A';
                                                $name = 'N/A';
                                            }
                                            ?>
                                            <div class="ab a5_h hourly" style="color: rgb(<?=@$res->th_color?>);"><?=$pm25?></div>
                                            <div class="ab a5_d daily" style="color: rgb(<?=@$res->daily_th_color?>);"><?=$daily_pm25?></div>
                                            <div class="ab a5_name db_name"><?=$name?></div>
                                            
                                            <?php 
                                            $res_ids = array(5152,5313);
                                            $res = getResult($ar_list, $res_ids);
                                            if($res!=null){
                                                $pm25 = $res->pm25;
                                                $daily_pm25 = $res->daily_pm25;
                                                $name = $res->dustboy_name;
                                            }else{
                                                $pm25 = 'N/A';
                                                $daily_pm25 = 'N/A';
                                                $name = 'N/A';
                                            }
                                            ?>
                                            <div class="ab a6_h hourly" style="color: rgb(<?=@$res->th_color?>);"><?=$pm25?></div>
                                            <div class="ab a6_d daily" style="color: rgb(<?=@$res->daily_th_color?>);"><?=$daily_pm25?></div>
                                            <div class="ab a6_name db_name"><?=$name?></div>
                                            
                                            <?php 
                                            //7
                                            $res_ids = array(5068,5635,5636,5067,5377,5378);
                                            $res = getResult($ar_list, $res_ids);
                                            if($res!=null){
                                                $pm25 = $res->pm25;
                                                $daily_pm25 = $res->daily_pm25;
                                                $name = $res->dustboy_name;
                                            }else{
                                                $pm25 = 'N/A';
                                                $daily_pm25 = 'N/A';
                                                $name = 'N/A';
                                            }
                                            ?>
                                            <div class="ab a7_h hourly" style="color: rgb(<?=@$res->th_color?>);"><?=$pm25?></div>
                                            <div class="ab a7_d daily" style="color: rgb(<?=@$res->daily_th_color?>);"><?=$daily_pm25?></div>
                                            <div class="ab a7_name db_name">ชุมชนหมู่ 5<br/>บ้านเขามะกอก<br/>จ. สระบุรี</div>
                                            <!-- <div class="ab a7_name db_name"><?=$name?></div> -->
                                            
                                            <?php 
                                            //8
                                            $res_ids = array(5356,6000,6019);
                                            $res = getResult($ar_list, $res_ids);
                                            if($res!=null){
                                                $pm25 = $res->pm25;
                                                $daily_pm25 = $res->daily_pm25;
                                                $name = $res->dustboy_name;
                                            }else{
                                                $pm25 = 'N/A';
                                                $daily_pm25 = 'N/A';
                                                $name = 'N/A';
                                            }
                                            ?>
                                            <div class="ab a8_h hourly" style="color: rgb(<?=@$res->th_color?>);"><?=$pm25?></div>
                                            <div class="ab a8_d daily" style="color: rgb(<?=@$res->daily_th_color?>);"><?=$daily_pm25?></div>
                                            <div class="ab a8_name db_name"><?=$name?></div>
                                            
                                            
                                            <?php 
                                            //9
                                            $res_ids = array(5049,5405,5688,5677,5676,5052);
                                            $res = getResult($ar_list, $res_ids);
                                            if($res!=null){
                                                $pm25 = $res->pm25;
                                                $daily_pm25 = $res->daily_pm25;
                                                $name = $res->dustboy_name;
                                            }else{
                                                $pm25 = 'N/A';
                                                $daily_pm25 = 'N/A';
                                                $name = 'N/A';
                                            }
                                            ?>
                                            <div class="ab a9_h hourly" style="color: rgb(<?=@$res->th_color?>);"><?=$pm25?></div>
                                            <div class="ab a9_d daily" style="color: rgb(<?=@$res->daily_th_color?>);"><?=$daily_pm25?></div>
                                            <div class="ab a9_name db_name"><?=$name?></div>
                                            
                                            <?php 
                                            //10
                                            $res_ids = array(5084,5078,5077,5076,5293,5295);
                                            $res = getResult($ar_list, $res_ids);
                                            if($res!=null){
                                                $pm25 = $res->pm25;
                                                $daily_pm25 = $res->daily_pm25;
                                                $name = $res->dustboy_name;
                                            }else{
                                                $pm25 = 'N/A';
                                                $daily_pm25 = 'N/A';
                                                $name = 'N/A';
                                            }
                                            ?>
                                            <div class="ab a10_h hourly" style="color: rgb(<?=@$res->th_color?>);"><?=$pm25?></div>
                                            <div class="ab a10_d daily" style="color: rgb(<?=@$res->daily_th_color?>);"><?=$daily_pm25?></div>
                                            <div class="ab a10_name db_name"><?=$name?></div>
                                            
                                            <?php 
                                            //11
                                            $res_ids = array(5388, 5205);
                                            $res = getResult($ar_list, $res_ids);
                                            if($res!=null){
                                                $pm25 = $res->pm25;
                                                $daily_pm25 = $res->daily_pm25;
                                                $name = $res->dustboy_name;
                                            }else{
                                                $pm25 = 'N/A';
                                                $daily_pm25 = 'N/A';
                                                $name = 'N/A';
                                            }
                                            ?>
                                            <div class="ab a11_h hourly" style="color: rgb(<?=@$res->th_color?>);"><?=$pm25?></div>
                                            <div class="ab a11_d daily" style="color: rgb(<?=@$res->daily_th_color?>);"><?=$daily_pm25?></div>
                                            <div class="ab a11_name db_name"><?=$name?></div>
                                            
                                            <?php 
                                            //12
                                            $res_ids = array(5344,5318,5580);
                                            $res = getResult($ar_list, $res_ids);
                                            if($res!=null){
                                                $pm25 = $res->pm25;
                                                $daily_pm25 = $res->daily_pm25;
                                                $name = $res->dustboy_name;
                                            }else{
                                                $pm25 = 'N/A';
                                                $daily_pm25 = 'N/A';
                                                $name = 'N/A';
                                            }
                                            ?>
                                            <div class="ab a12_h hourly" style="color: rgb(<?=@$res->th_color?>);"><?=$pm25?></div>
                                            <div class="ab a12_d daily" style="color: rgb(<?=@$res->daily_th_color?>);"><?=$daily_pm25?></div>
                                            <div class="ab a12_name db_name">สำนักงานทรัพยากรธรรมชาติ<br>และสิ่งแวดล้อม จ.ตราด</div>
                                            <!-- <div class="ab a12_name db_name"><?=$name?></div> -->
                                            
                                            
                                            <?php 
                                            //13
                                            $res_ids = array(5342, 5380);
                                            $res = getResult($ar_list, $res_ids);
                                            if($res!=null){
                                                $pm25 = $res->pm25;
                                                $daily_pm25 = $res->daily_pm25;
                                                $name = $res->dustboy_name;
                                            }else{
                                                $pm25 = 'N/A';
                                                $daily_pm25 = 'N/A';
                                                $name = 'N/A';
                                            }
                                            ?>
                                            <div class="ab a13_h hourly" style="color: rgb(<?=@$res->th_color?>);"><?=$pm25?></div>
                                            <div class="ab a13_d daily" style="color: rgb(<?=@$res->daily_th_color?>);"><?=$daily_pm25?></div>
                                            <div class="ab a13_name db_name"><?=$name?></div>
                                        
                                            <?php 
                                            //14
                                            $res_ids = array(5352,5417,5305,5070,5056,5055);
                                            $res = getResult($ar_list, $res_ids);
                                            if($res!=null){
                                                $pm25 = $res->pm25;
                                                $daily_pm25 = $res->daily_pm25;
                                                $name = $res->dustboy_name;
                                            }else{
                                                $pm25 = 'N/A';
                                                $daily_pm25 = 'N/A';
                                                $name = 'N/A';
                                            }
                                            ?>
                                            <div class="ab a14_h hourly" style="color: rgb(<?=@$res->th_color?>);"><?=$pm25?></div>
                                            <div class="ab a14_d daily" style="color: rgb(<?=@$res->daily_th_color?>);"><?=$daily_pm25?></div>
                                            <div class="ab a14_name db_name">สำนักงานเทศบาลนคร<br>หาดใหญ่ จ.สงขลา</div>
                                            <!-- <div class="ab a14_name db_name"><?=$name?></div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php 
                                function getResult($ar_list,$ar){
                                    foreach($ar as $id){
                                        if($ar_list[$id]!=null){
                                            return $ar_list[$id];
                                            exit;
                                        }
                                    }
                                }
                            ?>
                            <!-- <script src="https://www.jqueryscript.net/demo/Capture-HTML-Elements-Screenshot/html2canvas.min.js"></script> -->
                            <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-rc.7/dist/html2canvas.min.js"></script>
                            <script src="https://www.jqueryscript.net/demo/Capture-HTML-Elements-Screenshot/canvas2image.js"></script>
                            <script>
                                var test = $("#imagesave").get(0);
                                
                                $('#save_image_locally').click(function(){
                                    html2canvas(test,{
                                        allowTaint: true,
                                        useCORS: true
                                    }).then(function(canvas) {
                                        var canvasWidth = canvas.width;
                                        var canvasHeight = canvas.height;
                                        console.log(canvas.toDataURL());
                                        Canvas2Image.saveAsImage(canvas, canvasWidth, canvasHeight, 'jpeg', 'dailyreport');
                                    });
                                });

                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <?php $this->load->view('main/template_contact');?>
    
    <script src="<?=base_url('assets/prophecy/assets/js/all/compress.min.js?v=').date('YmdHis');?>"></script>
    <script src="<?=base_url('assets/prophecy/assets/js/main.js?v=').date('YmdHis');?>"></script>
</body>

</html>