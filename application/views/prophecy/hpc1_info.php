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
    <title>ศูนย์ข้อมูลฝุ่นควัน เขตสุขภาพที่ 1 (HPC1). | CCDC : Climate Change Data Center</title>    
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>template/image/icon_ccdc.ico">
    <link rel="stylesheet" href="<?=base_url('assets/prophecy/assets/css/bootstrap-4.3.1/bootstrap.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/prophecy/assets/fontawesome/css/all.min.css');?>">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.css" />
    <link rel="stylesheet" href="<?=base_url('assets/prophecy/assets/css/style2_podd2.min.css?v=').date('YmdHis');?>">
    <script src="<?=base_url()?>template/js/jquery/jquery.min.js"></script>
	<?php $this->load->view('main/analytics');?>
</head>

<body class="fade-in anime_delay05">
    <!-- เมนูเวลาเลื่อนลงมา -->
    <section id="menu_slide" class="frist">
        <div class="main_menu">
            <?php $this->load->view('main/template_nav');?>
        </div>
    </section>
    <!-- เมนูเวลาเลื่อนลงมา -->
    <section id="main">
        <div class="container-fluid">
            <div class="container">
                <div class="header">
                    <div class="swiper-container-title fade_in anime_delay1">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide text-center">
                                <img src="<?=base_url()?>assets/prophecy/assets/image/podd2/update/logo_moph.jpg<?='?v='.date('YmdHis')?>" alt="Public health">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main_content">
                <div class="content">
                    <div class="main_title">
                        <div class="container"> 
                            <div class="row"> 
                                <div class="col-md-12"> 
                                    <h3 class="page_title text-white d-flex align-items-center">
                                        <span style="font-size:20px;">โครงการปลอดฝุ่นอุ่นใจสู้ภัยหมอกควัน<br><span style="font-size:15px;">ศูนย์อนามัยที่ 1 เชียงใหม่ กรมอนามัย</span></span>
                                    </h3> 
                                </div> 
                            </div> 
                        </div>
                    </div>
                    
                    <div class="main_detail">
                        <div class="container pt-3 mb-5">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="mt-2 mb-5"><b>ความรู้เกี่ยวกับห้องปลอดฝุ่น</b></h4>
                                </div>
                                <div class="col-7">
                                    <iframe class="mb-3" width="100%" height="550" src="https://www.youtube.com/embed/WvK3bEubVA4" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    <p style="font-size:16px;">การจัดทำห้องปลอดฝุ่น เพื่อลดผลกระทบต่อสุขภาพจาก PM2.5</p>
                                    <p style="font-size:14px;">Health Impact Assessment HIA</p>
                                </div>
                                <div class="col-5">
                                    <a href="http://hia.anamai.moph.go.th/download/hia/manual/book/2563/book93.pdf">
                                        <img class="mb-3" width="100%" height="550" src="<?=base_url()?>assets/prophecy/assets/image/podd2/info2.jpg<?='?v='.date('YmdHis')?>" alt="Public health">
                                    </a>
                                    <p style="font-size:16px;">แนวทางการทำห้องฝุ่นสำหรับบ้านเรือนและอาคารสาธารณะ</p>
                                    <!-- <p style="font-size:14px;">Health Impact Assessment HIA</p> -->
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
    <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.6/dist/clipboard.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/smooth-scrollbar/8.6.0/smooth-scrollbar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/smooth-scrollbar/8.6.0/plugins/overscroll.min.js"></script>
    <script src="<?=base_url('assets/prophecy/assets/js/main_podd2.js?v=').date('YmdHis');?>"></script>
</body>

</html>