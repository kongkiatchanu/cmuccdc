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
    <title>รายงานสถานการณ์ฝุ่นละอองขนาดเล็ก PM2.5 และการคาดการณ์ล่วงหน้า (PODD). | CCDC : Climate Change Data Center</title>    
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>template/image/icon_ccdc.ico">
    <link rel="stylesheet" href="<?=base_url('assets/prophecy/assets/css/bootstrap-4.3.1/bootstrap.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/prophecy/assets/fontawesome/css/all.min.css');?>">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/v1.4.1/mapbox-gl.css'>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.70.0/dist/L.Control.Locate.min.css" />
    <link rel="stylesheet" href="<?=base_url('assets/prophecy/assets/css/style2.min.css?v=').date('YmdHis');?>">
    <script src="<?=base_url()?>template/js/jquery/jquery.min.js"></script>
	<?php $this->load->view('main/analytics');?>
    <style>
        .main_title{
            height: 13vh !important;
        }
        .main_detail{
            min-height: 50vh !important;
        }
        .dropdown-menu{
            height: auto;
            max-height: 250px;
            overflow-x: hidden;
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
                                        <i class="fas fa-square mr-3" style="font-size:11px;"></i> <span style="font-size:20px;">รายงานสถานการณ์ฝุ่นละอองขนาดเล็ก PM2.5 และการคาดการณ์ล่วงหน้า</span>
                                    </h3> 
                                </div> 
                            </div> 
                        </div>
                    </div>
                    
                    <div class="main_detail">
                        <div class="container py-3">
                            <div class="row">
                                <div class="col-12 text-left">
                                    <p class="">วันที่รายงาน : <b class="report-time text-danger"><?=date('d-m-').(date('Y')+543)?>.</b></p>
                                </div>
                                <div class="col-12 col-xl-4">
                                    <label> เลือกเขตสุขภาพที่ต้องการรายงานผล </label>
                                    <div class="dropdown">
                                        <a class="btn btn-info btn-lg dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-medkit fa-xs mr-2"></i> เลือกเขตสุขภาพ
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                            <?php for($i = 1;$i <= 13;$i++){ ?>
                                                <a class="dropdown-item" style="font-size: 14px" href="<?=base_url('report2/pdf_2021/'.$i);?>" target='_blank'> เขตสุขภาพที่ <?=$i?>.</a>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-xl-4">
                                    <label> เลือกเขตจังหวัดที่ต้องการรายงานผล </label>
                                    <div class="dropdown">
                                        <a class="btn btn-info btn-lg dropdown-toggle" href="#" role="button" id="dropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-city fa-xs mr-2"></i> เลือกจังหวัด
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink2">
                                            <?php foreach($province as $value){ ?>
                                                <a class="dropdown-item" style="font-size: 14px" href="<?=base_url('report2/pdf_2021/'.$value->province_healthzones_id.'/'.$value->province_id);?>" target='_blank'> <?=$value->province_name?>.</a>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-12 col-xl-4">
                                </div> -->
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