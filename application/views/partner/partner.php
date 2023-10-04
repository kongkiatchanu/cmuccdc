<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Partner | CCDC : Climate Change Data Center</title>    
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>template/image/icon_ccdc.ico">
    <link rel="stylesheet" href="<?=base_url('assets/prophecy/assets/css/bootstrap-4.3.1/bootstrap.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/prophecy/assets/fontawesome/css/all.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/prophecy/assets/css/style2.min.css?v=').date('YmdHis');?>">
    <script src="<?=base_url()?>template/js/jquery/jquery.min.js"></script>
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
                                        <i class="fas fa-square mr-3" style="font-size:11px;"></i> Partner
                                    </h3> 
                                </div> 
                            </div> 
                        </div>
                    </div>
                    
                    <div class="main_detail">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 col-lg-3 partner">
                                    <div class="title">
                                        <i class="fas fa-plus"></i> 
                                        <span class="">MHESI</span>
                                    </div>
                                    <div class="frame">
                                        <div class="shadow_frame"></div>
                                        <div class="banner px-2">
                                            <img class="d-block w-100 m-auto" src="<?= base_url('assets/prophecy/assets/image/logo_mhesi.png')?>" alt="MHESI">
                                        </div>
                                        <div class="line"></div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-3 partner">
                                    <div class="title">
                                        <i class="fas fa-plus "></i> 
                                        <span class="">NRCT</span> 
                                    </div>
                                    <div class="frame">
                                        <div class="shadow_frame"></div>
                                        <div class="banner border-0">
                                            <img class="nrct d-block w-100 m-auto" src="<?= base_url('assets/prophecy/assets/image/logo_nrct.jpg')?>" alt="NRCT">
                                        </div>
                                        <div class="line"></div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-3 partner">
                                    <div class="title">
                                        <i class="fas fa-plus "></i> 
                                        <span class="">CMU CCDC</span>
                                    </div>
                                    <div class="frame">
                                        <div class="shadow_frame"></div>
                                        <div class="banner px-2 border-ccdc">
                                            <img class="d-block w-100 m-auto" src="<?= base_url('assets/prophecy/assets/image/logo_ccdc_circle.png')?>" alt="CMU CCDC">
                                        </div>
                                        <div class="line"></div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-3 partner">
                                    <div class="title">
                                        <i class="fas fa-plus ">
                                        </i> <span class="">DUSTBOY</span>
                                    </div>
                                    <div class="frame">
                                        <div class="shadow_frame"></div>
                                        <div class="banner">
                                            <img class="d-block h-100 m-auto" src="<?= base_url('assets/prophecy/assets/image/logo_dustboy.png')?>" alt="DUSTBOY">
                                        </div>
                                        <div class="line"></div>
                                    </div>
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
    <script src="<?=base_url('assets/prophecy/assets/js/main.js?v=').date('YmdHis');?>"></script>
</body>

</html>