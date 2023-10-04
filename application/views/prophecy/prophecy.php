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
    <title>ค่าพยากรณ์ PM2.5 ล่วงหน้า | CCDC : Climate Change Data Center</title>    
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
                                        <i class="fas fa-square mr-3" style="font-size:11px;"></i> ค่าพยากรณ์ PM2.5 ล่วงหน้า
                                    </h3> 
                                </div> 
                            </div> 
                        </div>
                    </div>
                    
                    <div class="main_detail">
                        <div class="container">
                            <div id="accordion" class=".shadow-drop-bottom pt-3">
                                <?php for($i=1; $i <= 13; $i++) { ?>
                                    <div id="map<?=$i?>" class="map"></div>
                                    <div class="card">
                                        <div class="card-header" id="heading<?=$i;?>">
                                            <h5 class="mb-0">
                                                <button class="btn btn-sm btn-success" data-toggle="collapse" data-target="#collapse<?=$i;?>" aria-expanded="false" aria-controls="collapse<?=$i;?>">
                                                    <i class="fas fa-list-ul fa-sm"></i> เขตสุขภาพที่ <?=$i;?>
                                                </button>
                                                <a class="btn btn-sm btn-outline-info" href="<?= base_url('report/pm25/').$i; ?>" target="_blank">
                                                    <i class="fas fa-file-download"></i> ดาวน์โหลด
                                                </a>
                                            </h5>
                                        </div>

                                        <div id="collapse<?=$i;?>" class="collapse" aria-labelledby="heading<?=$i;?>" data-parent="#accordion">
                                            <div class="card-body">
                                                <div class="table-responsive fade_in_ture anime_delay1">
                                                    <table id="table_pm25_nearby<?=$i;?>" class="table table-hover w-100">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center" style="width: 60%;" rowspan="2"> จุดตรวจวัด PM<sub>2.5</sub> (μg/m<sup>3</sup>) </th>
                                                                <th class="text-center pr-4" style="width: 10%;"> วานนี้ </th>
                                                                <th class="text-center pr-4" colspan="3" style="width: 30%;"> คาดการณ์ </th>
                                                            </tr>
                                                            <tr>
                                                                <th class="text-center d-1" style="width: 10%;">
                                                                    <?php echo thaidate('j')-1 .' '.thaidate('M'); ?>
                                                                </th>
                                                                <th class="text-center d" style="width: 10%;">
                                                                    <?php echo thaidate('j') .' '.thaidate('M'); ?>
                                                                </th>
                                                                <th class="text-center d+1" style="width: 10%;">
                                                                    <?php echo thaidate('j')+1 .' '.thaidate('M'); ?>
                                                                </th>
                                                                <th class="text-center d+2" style="width: 10%;">
                                                                    <?php echo thaidate('j')+2 .' '.thaidate('M'); ?>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if($i==1){ foreach ($data1 as $key => $value) {?>
                                                                <?php if(!empty($value->stations)){ ?>
                                                                    <tr>
                                                                        <td class="province"><?=$value->province_name_th;?></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <?php foreach ($value->stations as $k => $v) { ?>
                                                                        <?php if(!empty($v->weather)){ ?>
                                                                            <tr>
                                                                                <td class=""> <b><?= $v->location_name; ?></b> </td>
                                                                                <?php if($v->pm25->PM25!=null){ ?>
                                                                                    <td class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->pm25->PM25);?>)";> <?=$v->pm25->PM25;?>  </a>
                                                                                    </td>
                                                                                <?php }else{ ?>
                                                                                    <th class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                    </th>
                                                                                <?php } ?>
                                                                                <?php for($j=0;$j<=2;$j++){ ?>
                                                                                    <?php if(!empty($v->weather[$j])){ ?>
                                                                                        <th class="text-center"> 
                                                                                            <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->weather[$j]->PM25);?>)";> <?=floor($v->weather[$j]->PM25);?>  </a>
                                                                                        </th>
                                                                                    <?php }else{ ?>
                                                                                        <th class="text-center"> 
                                                                                            <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                        </th>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            </tr>
                                                                        <?php }else{ ?>
                                                                            <tr>
                                                                                <td class=""> <b><?= $v->location_name; ?></b> </td>
                                                                                <?php if($v->pm25->PM25!=null){ ?>
                                                                                    <td class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->pm25->PM25);?>)";> <?=$v->pm25->PM25;?>  </a>
                                                                                    </td>
                                                                                <?php }else{ ?>
                                                                                    <th class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                    </th>
                                                                                <?php } ?>
                                                                                <td class="text-center"> 
                                                                                    ไม่มีข้อมูลพยากรณ์
                                                                                </td>
                                                                                <td></td>
                                                                                <td></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            <?php }} ?>
                                                            <?php if($i==2){ foreach ($data2 as $key => $value) {?>
                                                                <?php if(!empty($value->stations)){ ?>
                                                                    <tr>
                                                                        <td class="province"><?=$value->province_name_th;?></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <?php foreach ($value->stations as $k => $v) { ?>
                                                                        <?php if(!empty($v->weather)){ ?>
                                                                            <tr>
                                                                                <td class=""> <b><?= $v->location_name; ?></b> </td>
                                                                                <?php if($v->pm25->PM25!=null){ ?>
                                                                                    <td class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->pm25->PM25);?>)";> <?=$v->pm25->PM25;?>  </a>
                                                                                    </td>
                                                                                <?php }else{ ?>
                                                                                    <th class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                    </th>
                                                                                <?php } ?>
                                                                                <?php for($j=0;$j<=2;$j++){ ?>
                                                                                    <?php if(!empty($v->weather[$j])){ ?>
                                                                                        <th class="text-center"> 
                                                                                            <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->weather[$j]->PM25);?>)";> <?=floor($v->weather[$j]->PM25);?>  </a>
                                                                                        </th>
                                                                                    <?php }else{ ?>
                                                                                        <th class="text-center"> 
                                                                                            <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                        </th>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            </tr>
                                                                        <?php }else{ ?>
                                                                            <tr>
                                                                                <td class=""> <b><?= $v->location_name; ?></b> </td>
                                                                                <?php if($v->pm25->PM25!=null){ ?>
                                                                                    <td class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->pm25->PM25);?>)";> <?=$v->pm25->PM25;?>  </a>
                                                                                    </td>
                                                                                <?php }else{ ?>
                                                                                    <th class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                    </th>
                                                                                <?php } ?>
                                                                                <td class="text-center"> 
                                                                                    ไม่มีข้อมูลพยากรณ์
                                                                                </td>
                                                                                <td></td>
                                                                                <td></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            <?php }} ?>
                                                            <?php if($i==3){ foreach ($data3 as $key => $value) {?>
                                                                <?php if(!empty($value->stations)){ ?>
                                                                    <tr>
                                                                        <td class="province"><?=$value->province_name_th;?></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <?php foreach ($value->stations as $k => $v) { ?>
                                                                        <?php if(!empty($v->weather)){ ?>
                                                                            <tr>
                                                                                <td class=""> <b><?= $v->location_name; ?></b> </td>
                                                                                <?php if($v->pm25->PM25!=null){ ?>
                                                                                    <td class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->pm25->PM25);?>)";> <?=$v->pm25->PM25;?>  </a>
                                                                                    </td>
                                                                                <?php }else{ ?>
                                                                                    <th class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                    </th>
                                                                                <?php } ?>
                                                                                <?php for($j=0;$j<=2;$j++){ ?>
                                                                                    <?php if(!empty($v->weather[$j])){ ?>
                                                                                        <th class="text-center"> 
                                                                                            <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->weather[$j]->PM25);?>)";> <?=floor($v->weather[$j]->PM25);?>  </a>
                                                                                        </th>
                                                                                    <?php }else{ ?>
                                                                                        <th class="text-center"> 
                                                                                            <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                        </th>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            </tr>
                                                                        <?php }else{ ?>
                                                                            <tr>
                                                                                <td class=""> <b><?= $v->location_name; ?></b> </td>
                                                                                <?php if($v->pm25->PM25!=null){ ?>
                                                                                    <td class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->pm25->PM25);?>)";> <?=$v->pm25->PM25;?>  </a>
                                                                                    </td>
                                                                                <?php }else{ ?>
                                                                                    <th class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                    </th>
                                                                                <?php } ?>
                                                                                <td class="text-center"> 
                                                                                    ไม่มีข้อมูลพยากรณ์
                                                                                </td>
                                                                                <td></td>
                                                                                <td></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            <?php }} ?>
                                                            <?php if($i==4){ foreach ($data4 as $key => $value) {?>
                                                                <?php if(!empty($value->stations)){ ?>
                                                                    <tr>
                                                                        <td class="province"><?=$value->province_name_th;?></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <?php foreach ($value->stations as $k => $v) { ?>
                                                                        <?php if(!empty($v->weather)){ ?>
                                                                            <tr>
                                                                                <td class=""> <b><?= $v->location_name; ?></b> </td>
                                                                                <?php if($v->pm25->PM25!=null){ ?>
                                                                                    <td class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->pm25->PM25);?>)";> <?=$v->pm25->PM25;?>  </a>
                                                                                    </td>
                                                                                <?php }else{ ?>
                                                                                    <th class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                    </th>
                                                                                <?php } ?>
                                                                                <?php for($j=0;$j<=2;$j++){ ?>
                                                                                    <?php if(!empty($v->weather[$j])){ ?>
                                                                                        <th class="text-center"> 
                                                                                            <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->weather[$j]->PM25);?>)";> <?=floor($v->weather[$j]->PM25);?>  </a>
                                                                                        </th>
                                                                                    <?php }else{ ?>
                                                                                        <th class="text-center"> 
                                                                                            <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                        </th>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            </tr>
                                                                        <?php }else{ ?>
                                                                            <tr>
                                                                                <td class=""> <b><?= $v->location_name; ?></b> </td>
                                                                                <?php if($v->pm25->PM25!=null){ ?>
                                                                                    <td class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->pm25->PM25);?>)";> <?=$v->pm25->PM25;?>  </a>
                                                                                    </td>
                                                                                <?php }else{ ?>
                                                                                    <th class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                    </th>
                                                                                <?php } ?>
                                                                                <td class="text-center"> 
                                                                                    ไม่มีข้อมูลพยากรณ์
                                                                                </td>
                                                                                <td></td>
                                                                                <td></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            <?php }} ?>
                                                            <?php if($i==5){ foreach ($data5 as $key => $value) {?>
                                                                <?php if(!empty($value->stations)){ ?>
                                                                    <tr>
                                                                        <td class="province"><?=$value->province_name_th;?></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <?php foreach ($value->stations as $k => $v) { ?>
                                                                        <?php if(!empty($v->weather)){ ?>
                                                                            <tr>
                                                                                <td class=""> <b><?= $v->location_name; ?></b> </td>
                                                                                <?php if($v->pm25->PM25!=null){ ?>
                                                                                    <td class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->pm25->PM25);?>)";> <?=$v->pm25->PM25;?>  </a>
                                                                                    </td>
                                                                                <?php }else{ ?>
                                                                                    <th class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                    </th>
                                                                                <?php } ?>
                                                                                <?php for($j=0;$j<=2;$j++){ ?>
                                                                                    <?php if(!empty($v->weather[$j])){ ?>
                                                                                        <th class="text-center"> 
                                                                                            <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->weather[$j]->PM25);?>)";> <?=floor($v->weather[$j]->PM25);?>  </a>
                                                                                        </th>
                                                                                    <?php }else{ ?>
                                                                                        <th class="text-center"> 
                                                                                            <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                        </th>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            </tr>
                                                                        <?php }else{ ?>
                                                                            <tr>
                                                                                <td class=""> <b><?= $v->location_name; ?></b> </td>
                                                                                <?php if($v->pm25->PM25!=null){ ?>
                                                                                    <td class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->pm25->PM25);?>)";> <?=$v->pm25->PM25;?>  </a>
                                                                                    </td>
                                                                                <?php }else{ ?>
                                                                                    <th class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                    </th>
                                                                                <?php } ?>
                                                                                <td class="text-center"> 
                                                                                    ไม่มีข้อมูลพยากรณ์
                                                                                </td>
                                                                                <td></td>
                                                                                <td></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            <?php }} ?>
                                                            <?php if($i==6){ foreach ($data6 as $key => $value) {?>
                                                                <?php if(!empty($value->stations)){ ?>
                                                                    <tr>
                                                                        <td class="province"><?=$value->province_name_th;?></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <?php foreach ($value->stations as $k => $v) { ?>
                                                                        <?php if(!empty($v->weather)){ ?>
                                                                            <tr>
                                                                                <td class=""> <b><?= $v->location_name; ?></b> </td>
                                                                                <?php if($v->pm25->PM25!=null){ ?>
                                                                                    <td class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->pm25->PM25);?>)";> <?=$v->pm25->PM25;?>  </a>
                                                                                    </td>
                                                                                <?php }else{ ?>
                                                                                    <th class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                    </th>
                                                                                <?php } ?>
                                                                                <?php for($j=0;$j<=2;$j++){ ?>
                                                                                    <?php if(!empty($v->weather[$j])){ ?>
                                                                                        <th class="text-center"> 
                                                                                            <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->weather[$j]->PM25);?>)";> <?=floor($v->weather[$j]->PM25);?>  </a>
                                                                                        </th>
                                                                                    <?php }else{ ?>
                                                                                        <th class="text-center"> 
                                                                                            <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                        </th>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            </tr>
                                                                        <?php }else{ ?>
                                                                            <tr>
                                                                                <td class=""> <b><?= $v->location_name; ?></b> </td>
                                                                                <?php if($v->pm25->PM25!=null){ ?>
                                                                                    <td class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->pm25->PM25);?>)";> <?=$v->pm25->PM25;?>  </a>
                                                                                    </td>
                                                                                <?php }else{ ?>
                                                                                    <th class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                    </th>
                                                                                <?php } ?>
                                                                                <td class="text-center"> 
                                                                                    ไม่มีข้อมูลพยากรณ์
                                                                                </td>
                                                                                <td></td>
                                                                                <td></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            <?php }} ?>
                                                            <?php if($i==7){ foreach ($data7 as $key => $value) {?>
                                                                <?php if(!empty($value->stations)){ ?>
                                                                    <tr>
                                                                        <td class="province"><?=$value->province_name_th;?></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <?php foreach ($value->stations as $k => $v) { ?>
                                                                        <?php if(!empty($v->weather)){ ?>
                                                                            <tr>
                                                                                <td class=""> <b><?= $v->location_name; ?></b> </td>
                                                                                <?php if($v->pm25->PM25!=null){ ?>
                                                                                    <td class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->pm25->PM25);?>)";> <?=$v->pm25->PM25;?>  </a>
                                                                                    </td>
                                                                                <?php }else{ ?>
                                                                                    <th class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                    </th>
                                                                                <?php } ?>
                                                                                <?php for($j=0;$j<=2;$j++){ ?>
                                                                                    <?php if(!empty($v->weather[$j])){ ?>
                                                                                        <th class="text-center"> 
                                                                                            <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->weather[$j]->PM25);?>)";> <?=floor($v->weather[$j]->PM25);?>  </a>
                                                                                        </th>
                                                                                    <?php }else{ ?>
                                                                                        <th class="text-center"> 
                                                                                            <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                        </th>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            </tr>
                                                                        <?php }else{ ?>
                                                                            <tr>
                                                                                <td class=""> <b><?= $v->location_name; ?></b> </td>
                                                                                <?php if($v->pm25->PM25!=null){ ?>
                                                                                    <td class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->pm25->PM25);?>)";> <?=$v->pm25->PM25;?>  </a>
                                                                                    </td>
                                                                                <?php }else{ ?>
                                                                                    <th class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                    </th>
                                                                                <?php } ?>
                                                                                <td class="text-center"> 
                                                                                    ไม่มีข้อมูลพยากรณ์
                                                                                </td>
                                                                                <td></td>
                                                                                <td></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            <?php }} ?>
                                                            <?php if($i==8){ foreach ($data8 as $key => $value) {?>
                                                                <?php if(!empty($value->stations)){ ?>
                                                                    <tr>
                                                                        <td class="province"><?=$value->province_name_th;?></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <?php foreach ($value->stations as $k => $v) { ?>
                                                                        <?php if(!empty($v->weather)){ ?>
                                                                            <tr>
                                                                                <td class=""> <b><?= $v->location_name; ?></b> </td>
                                                                                <?php if($v->pm25->PM25!=null){ ?>
                                                                                    <td class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->pm25->PM25);?>)";> <?=$v->pm25->PM25;?>  </a>
                                                                                    </td>
                                                                                <?php }else{ ?>
                                                                                    <th class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                    </th>
                                                                                <?php } ?>
                                                                                <?php for($j=0;$j<=2;$j++){ ?>
                                                                                    <?php if(!empty($v->weather[$j])){ ?>
                                                                                        <th class="text-center"> 
                                                                                            <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->weather[$j]->PM25);?>)";> <?=floor($v->weather[$j]->PM25);?>  </a>
                                                                                        </th>
                                                                                    <?php }else{ ?>
                                                                                        <th class="text-center"> 
                                                                                            <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                        </th>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            </tr>
                                                                        <?php }else{ ?>
                                                                            <tr>
                                                                                <td class=""> <b><?= $v->location_name; ?></b> </td>
                                                                                <?php if($v->pm25->PM25!=null){ ?>
                                                                                    <td class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->pm25->PM25);?>)";> <?=$v->pm25->PM25;?>  </a>
                                                                                    </td>
                                                                                <?php }else{ ?>
                                                                                    <th class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                    </th>
                                                                                <?php } ?>
                                                                                <td class="text-center"> 
                                                                                    ไม่มีข้อมูลพยากรณ์
                                                                                </td>
                                                                                <td></td>
                                                                                <td></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            <?php }} ?>
                                                            <?php if($i==9){ foreach ($data9 as $key => $value) {?>
                                                                <?php if(!empty($value->stations)){ ?>
                                                                    <tr>
                                                                        <td class="province"><?=$value->province_name_th;?></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <?php foreach ($value->stations as $k => $v) { ?>
                                                                        <?php if(!empty($v->weather)){ ?>
                                                                            <tr>
                                                                                <td class=""> <b><?= $v->location_name; ?></b> </td>
                                                                                <?php if($v->pm25->PM25!=null){ ?>
                                                                                    <td class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->pm25->PM25);?>)";> <?=$v->pm25->PM25;?>  </a>
                                                                                    </td>
                                                                                <?php }else{ ?>
                                                                                    <th class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                    </th>
                                                                                <?php } ?>
                                                                                <?php for($j=0;$j<=2;$j++){ ?>
                                                                                    <?php if(!empty($v->weather[$j])){ ?>
                                                                                        <th class="text-center"> 
                                                                                            <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->weather[$j]->PM25);?>)";> <?=floor($v->weather[$j]->PM25);?>  </a>
                                                                                        </th>
                                                                                    <?php }else{ ?>
                                                                                        <th class="text-center"> 
                                                                                            <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                        </th>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            </tr>
                                                                        <?php }else{ ?>
                                                                            <tr>
                                                                                <td class=""> <b><?= $v->location_name; ?></b> </td>
                                                                                <?php if($v->pm25->PM25!=null){ ?>
                                                                                    <td class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->pm25->PM25);?>)";> <?=$v->pm25->PM25;?>  </a>
                                                                                    </td>
                                                                                <?php }else{ ?>
                                                                                    <th class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                    </th>
                                                                                <?php } ?>
                                                                                <td class="text-center"> 
                                                                                    ไม่มีข้อมูลพยากรณ์
                                                                                </td>
                                                                                <td></td>
                                                                                <td></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            <?php }} ?>
                                                            <?php if($i==10){ foreach ($data10 as $key => $value) {?>
                                                                <?php if(!empty($value->stations)){ ?>
                                                                    <tr>
                                                                        <td class="province"><?=$value->province_name_th;?></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <?php foreach ($value->stations as $k => $v) { ?>
                                                                        <?php if(!empty($v->weather)){ ?>
                                                                            <tr>
                                                                                <td class=""> <b><?= $v->location_name; ?></b> </td>
                                                                                <?php if($v->pm25->PM25!=null){ ?>
                                                                                    <td class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->pm25->PM25);?>)";> <?=$v->pm25->PM25;?>  </a>
                                                                                    </td>
                                                                                <?php }else{ ?>
                                                                                    <th class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                    </th>
                                                                                <?php } ?>
                                                                                <?php for($j=0;$j<=2;$j++){ ?>
                                                                                    <?php if(!empty($v->weather[$j])){ ?>
                                                                                        <th class="text-center"> 
                                                                                            <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->weather[$j]->PM25);?>)";> <?=floor($v->weather[$j]->PM25);?>  </a>
                                                                                        </th>
                                                                                    <?php }else{ ?>
                                                                                        <th class="text-center"> 
                                                                                            <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                        </th>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            </tr>
                                                                        <?php }else{ ?>
                                                                            <tr>
                                                                                <td class=""> <b><?= $v->location_name; ?></b> </td>
                                                                                <?php if($v->pm25->PM25!=null){ ?>
                                                                                    <td class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->pm25->PM25);?>)";> <?=$v->pm25->PM25;?>  </a>
                                                                                    </td>
                                                                                <?php }else{ ?>
                                                                                    <th class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                    </th>
                                                                                <?php } ?>
                                                                                <td class="text-center"> 
                                                                                    ไม่มีข้อมูลพยากรณ์
                                                                                </td>
                                                                                <td></td>
                                                                                <td></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            <?php }} ?>
                                                            <?php if($i==11){ foreach ($data11 as $key => $value) {?>
                                                                <?php if(!empty($value->stations)){ ?>
                                                                    <tr>
                                                                        <td class="province"><?=$value->province_name_th;?></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <?php foreach ($value->stations as $k => $v) { ?>
                                                                        <?php if(!empty($v->weather)){ ?>
                                                                            <tr>
                                                                                <td class=""> <b><?= $v->location_name; ?></b> </td>
                                                                                <?php if($v->pm25->PM25!=null){ ?>
                                                                                    <td class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->pm25->PM25);?>)";> <?=$v->pm25->PM25;?>  </a>
                                                                                    </td>
                                                                                <?php }else{ ?>
                                                                                    <th class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                    </th>
                                                                                <?php } ?>
                                                                                <?php for($j=0;$j<=2;$j++){ ?>
                                                                                    <?php if(!empty($v->weather[$j])){ ?>
                                                                                        <th class="text-center"> 
                                                                                            <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->weather[$j]->PM25);?>)";> <?=floor($v->weather[$j]->PM25);?>  </a>
                                                                                        </th>
                                                                                    <?php }else{ ?>
                                                                                        <th class="text-center"> 
                                                                                            <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                        </th>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            </tr>
                                                                        <?php }else{ ?>
                                                                            <tr>
                                                                                <td class=""> <b><?= $v->location_name; ?></b> </td>
                                                                                <?php if($v->pm25->PM25!=null){ ?>
                                                                                    <td class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->pm25->PM25);?>)";> <?=$v->pm25->PM25;?>  </a>
                                                                                    </td>
                                                                                <?php }else{ ?>
                                                                                    <th class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                    </th>
                                                                                <?php } ?>
                                                                                <td class="text-center"> 
                                                                                    ไม่มีข้อมูลพยากรณ์
                                                                                </td>
                                                                                <td></td>
                                                                                <td></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            <?php }} ?>
                                                            <?php if($i==12){ foreach ($data12 as $key => $value) {?>
                                                                <?php if(!empty($value->stations)){ ?>
                                                                    <tr>
                                                                        <td class="province"><?=$value->province_name_th;?></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <?php foreach ($value->stations as $k => $v) { ?>
                                                                        <?php if(!empty($v->weather)){ ?>
                                                                            <tr>
                                                                                <td class=""> <b><?= $v->location_name; ?></b> </td>
                                                                                <?php if($v->pm25->PM25!=null){ ?>
                                                                                    <td class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->pm25->PM25);?>)";> <?=$v->pm25->PM25;?>  </a>
                                                                                    </td>
                                                                                <?php }else{ ?>
                                                                                    <th class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                    </th>
                                                                                <?php } ?>
                                                                                <?php for($j=0;$j<=2;$j++){ ?>
                                                                                    <?php if(!empty($v->weather[$j])){ ?>
                                                                                        <th class="text-center"> 
                                                                                            <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->weather[$j]->PM25);?>)";> <?=floor($v->weather[$j]->PM25);?>  </a>
                                                                                        </th>
                                                                                    <?php }else{ ?>
                                                                                        <th class="text-center"> 
                                                                                            <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                        </th>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            </tr>
                                                                        <?php }else{ ?>
                                                                            <tr>
                                                                                <td class=""> <b><?= $v->location_name; ?></b> </td>
                                                                                <?php if($v->pm25->PM25!=null){ ?>
                                                                                    <td class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->pm25->PM25);?>)";> <?=$v->pm25->PM25;?>  </a>
                                                                                    </td>
                                                                                <?php }else{ ?>
                                                                                    <th class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                    </th>
                                                                                <?php } ?>
                                                                                <td class="text-center"> 
                                                                                    ไม่มีข้อมูลพยากรณ์
                                                                                </td>
                                                                                <td></td>
                                                                                <td></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            <?php }} ?>
                                                            <?php if($i==13){ foreach ($data13 as $key => $value) {?>
                                                                <?php if(!empty($value->stations)){ ?>
                                                                    <tr>
                                                                        <td class="province"><?=$value->province_name_th;?></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <?php foreach ($value->stations as $k => $v) { ?>
                                                                        <?php if(!empty($v->weather)){ ?>
                                                                            <tr>
                                                                                <td class=""> <b><?= $v->location_name; ?></b> </td>
                                                                                <?php if($v->pm25->PM25!=null){ ?>
                                                                                    <td class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->pm25->PM25);?>)";> <?=$v->pm25->PM25;?>  </a>
                                                                                    </td>
                                                                                <?php }else{ ?>
                                                                                    <th class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                    </th>
                                                                                <?php } ?>
                                                                                <?php for($j=0;$j<=2;$j++){ ?>
                                                                                    <?php if(!empty($v->weather[$j])){ ?>
                                                                                        <th class="text-center"> 
                                                                                            <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->weather[$j]->PM25);?>)";> <?=floor($v->weather[$j]->PM25);?>  </a>
                                                                                        </th>
                                                                                    <?php }else{ ?>
                                                                                        <th class="text-center"> 
                                                                                            <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                        </th>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            </tr>
                                                                        <?php }else{ ?>
                                                                            <tr>
                                                                                <td class=""> <b><?= $v->location_name; ?></b> </td>
                                                                                <?php if($v->pm25->PM25!=null){ ?>
                                                                                    <td class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:rgba(<?=color($v->pm25->PM25);?>)";> <?=$v->pm25->PM25;?>  </a>
                                                                                    </td>
                                                                                <?php }else{ ?>
                                                                                    <th class="text-center"> 
                                                                                        <a class="font-weight-bold badge badge-pill p-1 w-sm slit_in_vertical_table" style="background-color:#eee";> N/A </a>
                                                                                    </th>
                                                                                <?php } ?>
                                                                                <td class="text-center"> 
                                                                                    ไม่มีข้อมูลพยากรณ์
                                                                                </td>
                                                                                <td></td>
                                                                                <td></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            <?php }} ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="pm_aqi cate_us" style="display: none;">
                                    <div class="pm fade_in_ture anime_delay1">
                                        <div class="col col-md-6 title_pm_aqi ">PM<sub>2.5</sub> (μg/m<sup>3</sup>)</div>
                                        <div class="col col-md-1 detail_pm_aqi us1 num" ><span class="text-shadow-drop-bottom anime_delay1">0-11</span></div>
                                        <div class="col col-md-1 detail_pm_aqi us2 num" ><span class="text-shadow-drop-bottom anime_delay1">12-35</span></div>
                                        <div class="col col-md-1 detail_pm_aqi us3 num" ><span class="text-shadow-drop-bottom anime_delay1">36-55</span></div>
                                        <div class="col col-md-1 detail_pm_aqi us4 num" ><span class="text-shadow-drop-bottom anime_delay1">56-150</span></div>
                                        <div class="col col-md-1 detail_pm_aqi us5 num" ><span class="text-shadow-drop-bottom anime_delay1">151-250</span></div>
                                        <div class="col col-md-1 detail_pm_aqi us6 num" ><span class="text-shadow-drop-bottom anime_delay1">≥ 250</span></div>
                                    </div>
                                    <div class="aqi fade_in_ture anime_delay15">
                                        <div class="col col-md-6 title_pm_aqi quality"></div>
                                        <div class="col col-md-1 detail_pm_aqi us1" >
                                            <!-- <i class="fas fa-grin-beam fa-2x text-shadow-drop-bottom-icon anime_delay1"></i> -->
                                            <img class="shadow-drop-bottom-icon anime_delay1" src="<?=base_url('assets/prophecy/assets/image/pm25/us/nrct-06.png');?>">
                                        </div>
                                        <div class="col col-md-1 detail_pm_aqi us2" >
                                            <!-- <i class="fas fa-meh fa-2x text-shadow-drop-bottom-icon anime_delay1"></i> -->
                                            <img class="shadow-drop-bottom-icon anime_delay1" src="<?=base_url('assets/prophecy/assets/image/pm25/us/nrct-07.png');?>">
                                        </div>
                                        <div class="col col-md-1 detail_pm_aqi us3" >
                                            <!-- <i class="fas fa-frown-open fa-2x text-shadow-drop-bottom-icon anime_delay1"></i> -->
                                            <img class="shadow-drop-bottom-icon anime_delay1" src="<?=base_url('assets/prophecy/assets/image/pm25/us/nrct-08.png');?>">
                                        </div>
                                        <div class="col col-md-1 detail_pm_aqi us4" >
                                            <!-- <i class="fas fa-sad-tear fa-2x text-shadow-drop-bottom-icon anime_delay1"></i> -->
                                            <img class="shadow-drop-bottom-icon anime_delay1" src="<?=base_url('assets/prophecy/assets/image/pm25/us/nrct-09.png');?>">
                                        </div>
                                        <div class="col col-md-1 detail_pm_aqi us5" >
                                            <!-- <i class="fas fa-tired fa-2x text-shadow-drop-bottom-icon anime_delay1"></i> -->
                                            <img class="shadow-drop-bottom-icon anime_delay1" src="<?=base_url('assets/prophecy/assets/image/pm25/us/nrct-10.png');?>">
                                        </div>
                                        <div class="col col-md-1 detail_pm_aqi us6" >
                                            <!-- <i class="fas fa-dizzy fa-2x text-shadow-drop-bottom-icon anime_delay1"></i> -->
                                            <img class="shadow-drop-bottom-icon anime_delay1" src="<?=base_url('assets/prophecy/assets/image/pm25/us/nrct-11.png');?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="pm_aqi cate_th">
                                    <div class="pm fade_in_ture anime_delay1">
                                        <div class="col-2 col-md-7 title_pm_aqi ">PM<sub>2.5</sub> (μg/m<sup>3</sup>)</div>
                                        <div class="col-2 col-md-1 detail_pm_aqi th1 num" ><span class="text-shadow-drop-bottom anime_delay1"></span></div>
                                        <div class="col-2 col-md-1 detail_pm_aqi th2 num" ><span class="text-shadow-drop-bottom anime_delay1"></span></div>
                                        <div class="col-2 col-md-1 detail_pm_aqi th3 num" ><span class="text-shadow-drop-bottom anime_delay1"></span></div>
                                        <div class="col-2 col-md-1 detail_pm_aqi th4 num" ><span class="text-shadow-drop-bottom anime_delay1">51-90</span></div>
                                        <div class="col-2 col-md-1 detail_pm_aqi th5 num" ><span class="text-shadow-drop-bottom anime_delay1">≥ 91</span></div>
                                    </div>
                                    <div class="aqi fade_in_ture anime_delay15">
                                        <div class="col-2 col-md-7 title_pm_aqi quality"></div>
                                        <div class="col-2 col-md-1 detail_pm_aqi th1" >
                                            <!-- <i class="fas fa-grin-squint fa-2x text-shadow-drop-bottom-icon anime_delay1"></i> -->
                                            <img class="shadow-drop-bottom-icon anime_delay1" src="<?=base_url('assets/prophecy/assets/image/pm25/th/nrct-01.png');?>">
                                        </div>
                                        <div class="col-2 col-md-1 detail_pm_aqi th2" >
                                            <!-- <i class="fas fa-grin-beam fa-2x text-shadow-drop-bottom-icon anime_delay1"></i> -->
                                            <img class="shadow-drop-bottom-icon anime_delay1" src="<?=base_url('assets/prophecy/assets/image/pm25/th/nrct-02.png');?>">
                                        </div>
                                        <div class="col-2 col-md-1 detail_pm_aqi th3" >
                                            <!-- <i class="fas fa-meh fa-2x text-shadow-drop-bottom-icon anime_delay1"></i> -->
                                            <img class="shadow-drop-bottom-icon anime_delay1" src="<?=base_url('assets/prophecy/assets/image/pm25/th/nrct-03.png');?>">
                                        </div>
                                        <div class="col-2 col-md-1 detail_pm_aqi th4" >
                                            <!-- <i class="fas fa-sad-tear fa-2x text-shadow-drop-bottom-icon anime_delay1"></i> -->
                                            <img class="shadow-drop-bottom-icon anime_delay1" src="<?=base_url('assets/prophecy/assets/image/pm25/th/nrct-04.png');?>">
                                        </div>
                                        <div class="col-2 col-md-1 detail_pm_aqi th5" >
                                            <!-- <i class="fas fa-dizzy fa-2x text-shadow-drop-bottom-icon anime_delay1"></i> -->
                                            <img class="shadow-drop-bottom-icon anime_delay1" src="<?=base_url('assets/prophecy/assets/image/pm25/th/nrct-05.png');?>">
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