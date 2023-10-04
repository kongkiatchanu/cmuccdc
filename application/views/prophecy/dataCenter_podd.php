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
    <link rel="stylesheet" href="<?=base_url('assets/prophecy/assets/css/style2_podd.min.css?v=').date('YmdHis');?>">
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
                                <img src="<?=base_url()?>assets/prophecy/assets/image/podd2/update/logo_nrct.png<?='?v='.date('YmdHis')?><?='?v='.date('YmdHis')?>" alt="NRCT">
                            </div>
                            <div class="swiper-slide text-center">
                                <img src="<?=base_url()?>assets/prophecy/assets/image/podd2/update/logo_podd2.png<?='?v='.date('YmdHis')?>" alt="podd">
                            </div>
                            <div class="swiper-slide text-center">
                                <img src="<?=base_url()?>assets/prophecy/assets/image/podd2/update/logo_ccdc.png<?='?v='.date('YmdHis')?>" alt="CCDC : Climate Change Data Center">
                            </div>
                            <div class="swiper-slide text-center">
                                <img src="<?=base_url()?>assets/prophecy/assets/image/podd2/update/logo_public_health_1.jpg<?='?v='.date('YmdHis')?>" alt="Public health 1">
                            </div>
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
                                        <i class="fas fa-square mr-3" style="font-size:10px;"></i> <span style="font-size:18px;">ศูนย์ข้อมูล สถานการณ์ การเฝ้าระวัง และผลกระทบต่อสุขภาพ ปัจจัยด้านสิ่งแวดล้อม กรณีฝุ่นละอองขนาดเล็ก PM2.5 เขตสุขภาพที่ 1</span>
                                    </h3> 
                                </div> 
                            </div> 
                        </div>
                    </div>
                    
                    <div class="main_detail">
                        <div class="container pt-3">
                            <div class="row">
                                <div class="col-12">
                                    <div class="swiper-container fade_in anime_delay1">
                                        <div class="swiper-wrapper">
                                            <?php $swiper_title = array('สถานการณ์ PM<sub>2.5</sub>','ระบบเฝ้าระวัง','โครงการห้องปลอดฝุ่นอุ่นใจ','ผลกระทบต่อสุขภาพ','ข้อมูลสถานี Dustboy')?>
                                            <?php for($i=1;$i<=5;$i++){?>
                                                <div class="swiper-slide text-center mb-3">
                                                    <img class="<?= $i==1?'active img_grayscale_in':'';?>" src="<?=base_url('assets/prophecy/assets/image/podd2/update/bn-0'.$i.'.png?v='.date('YmdHis'))?>" data-swiper-tab="#swiper-tab<?=$i?>">
                                                    <label class="swiper-title mt-1"><?=$swiper_title[$i-1]?></label>
                                                </div>
                                            <?php }?>
                                            <!-- <div class="swiper-slide text-center mb-3">
                                                <img class="" src="<?=base_url('assets/prophecy/assets/image/podd/bn3-04.jpg')?>" data-swiper-tab="#swiper-tab4">
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                                <div id="swiper" class="col-12">
                                    <div class="table-responsive table-swiper fade_in anime_delay15">
                                        <table id="swiper-tab1" class="swiper-tab table fade_in">
                                            <thead class="bg-color">
                                                <tr>
                                                    <th scope="col">สถานการณ์ PM2.5 และค่าการพยากรณ์</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td> <a class="text-decoration-none text-color mb-2" href="https://www.cmuccdc.org/pm25">สถานการณ์ PM2.5 ตามพิกัด</a>
                                                    <br><button class="w-100 btn btn-light btn-sm font-weight-light text-left text-color" data-placement="bottom" title="คัดลอกแล้ว!" data-clipboard-text="https://www.cmuccdc.org/pm25"><i class="fas fa-copy mr-2"></i>https://www.cmuccdc.org/pm25</button></td>
                                                </tr>
                                                <tr>
                                                    <td> <a class="text-decoration-none text-color mb-2" href="https://www.cmuccdc.org/report_hpc1">ดาวน์โหลดรายงานสถานการณ์ PM2.5 และค่าการพยากรณ์</a>
                                                    <br><button class="w-100 btn btn-light btn-sm font-weight-light text-left text-color" data-placement="bottom" title="คัดลอกแล้ว!" data-clipboard-text="https://www.cmuccdc.org/report_hpc1"><i class="fas fa-copy mr-2"></i>https://www.cmuccdc.org/report_hpc1</button></td>
                                                </tr>
                                                <tr>
                                                    <td> <a class="text-decoration-none text-color mb-2" href="https://www.cmuccdc.org/dailyavg">สถานการณ์ PM2.5 รายวัน</a>
                                                    <br><button class="w-100 btn btn-light btn-sm font-weight-light text-left text-color" data-placement="bottom" title="คัดลอกแล้ว!" data-clipboard-text="https://www.cmuccdc.org/dailyavg"><i class="fas fa-copy mr-2"></i>https://www.cmuccdc.org/dailyavg</button></td>
                                                </tr>
                                                <tr>
                                                    <td><a class="text-decoration-none text-color mb-2" href="https://pm2_5.nrct.go.th">สถานการณ์ PM2.5 ของประเทศไทย</a>
                                                    <br><button class="w-100 btn btn-light btn-sm font-weight-light text-left text-color" data-placement="bottom" title="คัดลอกแล้ว!" data-clipboard-text="https://pm2_5.nrct.go.th"><i class="fas fa-copy mr-2"></i>https://pm2_5.nrct.go.th</button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="table-responsive table-swiper">
                                        <table id="swiper-tab2" class="swiper-tab table  fade_in d-none">
                                            <thead class="bg-color">
                                                <tr>
                                                    <th scope="col">ระบบเฝ้าระวังฝุ่นและปฏิบัติการด้านการแพทย์และสาธารณสุข</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="bg-color2">
                                                    <td scope="col">ระบบเฝ้าระวัง สื่อสารความเสี่ยง เพื่อป้องกันและลดผลกระทบฝุ่นควัน</td>
                                                </tr>
												<tr>
                                                    <td> <a class="text-decoration-none text-color mb-2" href="http://www.cmonehealth.org">PODD</a>
                                                    <br><button class="w-100 btn btn-light btn-sm font-weight-light text-left text-color"data-placement="bottom" title="คัดลอกแล้ว!" data-clipboard-text="http://www.cmonehealth.org"><i class="fas fa-copy mr-2"></i>http://www.cmonehealth.org</button></td>
                                                </tr>
                                                <tr>
                                                    <td> <a class="text-decoration-none text-color mb-2" href="http://www.cmonehealth.org/dashboard/#/login?destination=:">Dashboard  PODD</a>
                                                    <br><button class="w-100 btn btn-light btn-sm font-weight-light text-left text-color"data-placement="bottom" title="คัดลอกแล้ว!" data-clipboard-text="http://www.cmonehealth.org/dashboard/#/login?destination=:"><i class="fas fa-copy mr-2"></i>http://www.cmonehealth.org/dashboard/#/login?destination=:</button></td>
                                                </tr>
                                                <tr>
                                                    <td> <a class="text-decoration-none text-color mb-2" href="javascript:void(0)">รายงานปฏิบัติการด้านการแพทย์และสาธารณสุข</a></td>
                                                </tr>
                                                <tr>
                                                    <td>  <a class="text-decoration-none text-color mb-2" href="https://cloud.hpc1.go.th/owncloud/index.php/s/udYu0AdjAxhqT2I#pdfviewer">คู่มือการดำเนินงานด้านการแพทย์และสาธารณสุข กรณีฝุ่นละออง PM2.5 ปี 2564</a>
                                                    <br><button class="w-100 btn btn-light btn-sm font-weight-light text-left text-color"data-placement="bottom" title="คัดลอกแล้ว!" data-clipboard-text="https://cloud.hpc1.go.th/owncloud/index.php/s/udYu0AdjAxhqT2I#pdfviewer"><i class="fas fa-copy mr-2"></i>https://cloud.hpc1.go.th/owncloud/index.php/s/udYu0AdjAxhqT2I#pdfviewer</button></td>
                                                </tr>
                                                <tr>
                                                    <td>  <a class="text-decoration-none text-color mb-2" href="https://cloud.hpc1.go.th/owncloud/index.php/s/Zn0avJymVFRiu8c">สื่อ แผ่นพับ คลิปฝุ่นควัน</a>
                                                    <br><button class="w-100 btn btn-light btn-sm font-weight-light text-left text-color"data-placement="bottom" title="คัดลอกแล้ว!" data-clipboard-text="https://cloud.hpc1.go.th/owncloud/index.php/s/Zn0avJymVFRiu8c"><i class="fas fa-copy mr-2"></i>https://cloud.hpc1.go.th/owncloud/index.php/s/Zn0avJymVFRiu8c</button></td>
                                                </tr>
                                                <tr class="bg-color2">
                                                    <td>  <a class="text-decoration-none text-white" href="https://cloud.hpc1.go.th/s/kOfWM0bUWomLNhr">ตัวอย่างโครงการขอสนับสนุนกองทุนสุขภาพตำบล จากงบ สปสช.</a>
                                                    <br><button class="w-100 btn btn-color btn-sm font-weight-light text-left"data-placement="bottom" title="คัดลอกแล้ว!" data-clipboard-text="https://cloud.hpc1.go.th/s/kOfWM0bUWomLNhr"><i class="fas fa-copy mr-2"></i>https://cloud.hpc1.go.th/s/kOfWM0bUWomLNhr</button></td>
                                                </tr>
                                                <tr class="bg-color2">
                                                    <td>  <a class="text-decoration-none text-white" href="https://cloud.hpc1.go.th/owncloud/index.php/s/XXZzruqNsjfpAj6">เรียนรู้ระบบระบบเฝ้าระวัง สื่อสารความเสี่ยง และลดผลกระทบต่อสุขภาพจากฝุ่นควัน</a> 
                                                    <br><button class="w-100 btn btn-color btn-sm font-weight-light text-left"data-placement="bottom" title="คัดลอกแล้ว!" data-clipboard-text="https://cloud.hpc1.go.th/owncloud/index.php/s/XXZzruqNsjfpAj6"><i class="fas fa-copy mr-2"></i>https://cloud.hpc1.go.th/owncloud/index.php/s/XXZzruqNsjfpAj6</button></td>
                                                </tr>
                                                <tr class="bg-color2">
                                                    <td>  <a class="text-decoration-none text-white" href="http://www.cmonehealth.org/home">เรียนรู้ระบบเฝ้าระวังสุขภาพหนึ่งเดียว (PODD)</a>
                                                    <br><button class="w-100 btn btn-color btn-sm font-weight-light text-left"data-placement="bottom" title="คัดลอกแล้ว!" data-clipboard-text="http://www.cmonehealth.org/home"><i class="fas fa-copy mr-2"></i>http://www.cmonehealth.org/home</button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="table-responsive table-swiper">
                                        <table id="swiper-tab4" class="swiper-tab table  fade_in d-none">
                                            <thead class="bg-color">
                                                <tr>
                                                    <th scope="col">ผลกระทบต่อสุขภาพ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td> <a class="text-decoration-none text-color mb-2" href="https://hdcservice.moph.go.th/hdc/reports/page.php?cat_id=9c647c1f31ac73f4396c2cf987e7448a">รายงานการป่วยด้วยโรคจากมลพิษทางอากาศ</a>
                                                    <br><button class="w-100 btn btn-light btn-sm font-weight-light text-left text-color"data-placement="bottom" title="คัดลอกแล้ว!" data-clipboard-text="https://hdcservice.moph.go.th/hdc/reports/page.php?cat_id=9c647c1f31ac73f4396c2cf987e7448a"><i class="fas fa-copy mr-2"></i>https://hdcservice.moph.go.th/hdc/reports/page.php?cat_id=9c647c1f31ac73f4396c2cf987e7448a</button></td>
                                                </tr>
                                                <tr>
                                                    <td> <a class="text-decoration-none text-color mb-2" href="https://sites.google.com/view/hia-surveillance/anamai-poll-pm-2-5">Anamai Poll PM2.5</a>
                                                    <br><button class="w-100 btn btn-light btn-sm font-weight-light text-left text-color"data-placement="bottom" title="คัดลอกแล้ว!" data-clipboard-text="https://sites.google.com/view/hia-surveillance/anamai-poll-pm-2-5"><i class="fas fa-copy mr-2"></i>https://sites.google.com/view/hia-surveillance/anamai-poll-pm-2-5</button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="table-responsive table-swiper">
                                        <table id="swiper-tab5" class="swiper-tab table  fade_in d-none">
                                            <thead class="bg-color">
                                                <tr>
                                                    <th scope="col">ข้อมูลสถานี DustBoy</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td> <a class="text-decoration-none text-color mb-2" href="https://www.cmuccdc.org/maintain/login">ระบบลงทะเบียน /ติดตาม /แจ้งซ่อม</a>
                                                    <br><button class="w-100 btn btn-light btn-sm font-weight-light text-left text-color"data-placement="bottom" title="คัดลอกแล้ว!" data-clipboard-text="https://www.cmuccdc.org/maintain/login"><i class="fas fa-copy mr-2"></i>https://www.cmuccdc.org/maintain/login</button></td>
                                                </tr>
                                                <tr>
                                                    <td> <a class="text-decoration-none text-color mb-2" href="https://www.cmuccdc.org/guide">การติดตั้งและดูแลรักษา</a>
                                                    <br><button class="w-100 btn btn-light btn-sm font-weight-light text-left text-color"data-placement="bottom" title="คัดลอกแล้ว!" data-clipboard-text="https://www.cmuccdc.org/guide"><i class="fas fa-copy mr-2"></i>https://www.cmuccdc.org/guide</button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="table-responsive table-swiper">
                                        <table id="swiper-tab3" class="swiper-tab table  fade_in d-none">
                                            <thead class="bg-color">
                                                <tr>
                                                    <th scope="col">โครงการปลอดฝุ่นอุ่นใจ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>  <a class="text-decoration-none text-color mb-2" href="https://hpc1.cmuccdc.org/">หน้า Dashboard ห้องปลอดฝุ่น</a>
                                                    <br><button class="w-100 btn btn-light btn-sm font-weight-light text-left text-color"data-placement="bottom" title="คัดลอกแล้ว!" data-clipboard-text="https://hpc1.cmuccdc.org/"><i class="fas fa-copy mr-2"></i>https://hpc1.cmuccdc.org/</button></td>
                                                </tr>
                                                <tr>
                                                    <td>  <a class="text-decoration-none text-color mb-2" href="https://hpc1.cmuccdc.org/auth/login">สมัคร /ลงทะเบียนห้องปลอดฝุ่น</a>
                                                    <br><button class="w-100 btn btn-light btn-sm font-weight-light text-left text-color"data-placement="bottom" title="คัดลอกแล้ว!" data-clipboard-text="https://hpc1.cmuccdc.org/auth/login"><i class="fas fa-copy mr-2"></i>https://hpc1.cmuccdc.org/auth/login</button></td>
                                                
                                                </tr>
                                                <tr>
                                                    <td>  <a class="text-decoration-none text-color mb-2" href="https://hpc1.cmuccdc.org/knowledge">ความรู้เกี่ยวกับห้องปลอดฝุ่น</a>
                                                    <br><button class="w-100 btn btn-light btn-sm font-weight-light text-left text-color"data-placement="bottom" title="คัดลอกแล้ว!" data-clipboard-text="https://hpc1.cmuccdc.org/knowledge"><i class="fas fa-copy mr-2"></i>https://hpc1.cmuccdc.org/knowledge</button></td>
                                                </tr>
                                                <tr>
                                                    <td>  <a class="text-decoration-none text-color mb-2" href="https://cloud.hpc1.go.th/owncloud/index.php/s/54qU668hb9jyJWW">แนวทางการจัดทำห้องปลอดฝุ่น</a>
                                                    <br><button class="w-100 btn btn-light btn-sm font-weight-light text-left text-color"data-placement="bottom" title="คัดลอกแล้ว!" data-clipboard-text="https://cloud.hpc1.go.th/owncloud/index.php/s/54qU668hb9jyJWW"><i class="fas fa-copy mr-2"></i>https://cloud.hpc1.go.th/owncloud/index.php/s/54qU668hb9jyJWW</button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container py-1">
                            <div class="hpc1 row p-0">
                                <div class="col-12">
                                    <div class="hpc1-footer">
                                        <div class="swiper-container-footer fade_in anime_delay1">
                                            <div class="swiper-wrapper">
                                                <div class="swiper-slide text-center mb-3">
                                                    <img src="<?=base_url()?>assets/prophecy/assets/image/podd2/update/logo_gistda.png<?='?v='.date('YmdHis')?>" alt="gistda">
                                                </div>
                                                <div class="swiper-slide text-center mb-3">
                                                    <img src="<?=base_url()?>assets/prophecy/assets/image/podd2/update/logo_ddc_moph.jpg<?='?v='.date('YmdHis')?>" alt="ddc_moph">
                                                </div>
                                                <div class="swiper-slide text-center mb-3">
                                                    <img src="<?=base_url()?>assets/prophecy/assets/image/podd2/update/log_mnre.png<?='?v='.date('YmdHis')?>" alt="mnre">
                                                </div>
                                                <!-- <div class="swiper-slide text-center mb-3">
                                                    <img src="<?=base_url()?>assets/prophecy/assets/image/podd/podd.png<?='?v='.date('YmdHis')?>" alt="podd">
                                                </div> -->
                                                <div class="swiper-slide text-center mb-3">
                                                    <img src="<?=base_url()?>assets/prophecy/assets/image/podd2/update/logo_narit.png<?='?v='.date('YmdHis')?>" alt="narit">
                                                </div>
                                                <div class="swiper-slide text-center mb-3">
                                                    <img src="<?=base_url()?>assets/prophecy/assets/image/podd2/update/logo_itsc.png<?='?v='.date('YmdHis')?>" alt="itsc">
                                                </div>
                                            </div>
                                        </div>
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
    <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.6/dist/clipboard.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/smooth-scrollbar/8.6.0/smooth-scrollbar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/smooth-scrollbar/8.6.0/plugins/overscroll.min.js"></script>
    <script src="<?=base_url('assets/prophecy/assets/js/main_podd.js?v=').date('YmdHis');?>"></script>
</body>

</html>