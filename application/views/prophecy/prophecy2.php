<?php
    include_once('assets/pdf/Thaidate/Thaidate.php');
	include_once('assets/pdf/Thaidate/thaidate-functions.php');
    // echo '<pre>';
    // print_r($data2);
    // echo '</pre>';
    // exit();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CCDC : Climate Change Data Center</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url('assets/ccdc/assets/image/icon_ccdc.ico');?>">
    <link rel="stylesheet" href="<?=base_url('assets/ccdc/assets/css/bootstrap-4.3.1/bootstrap.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/ccdc/assets/fontawesome/css/all.min.css');?>">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/v1.4.1/mapbox-gl.css'>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.70.0/dist/L.Control.Locate.min.css" />
    <link rel="stylesheet" href="<?=base_url('assets/ccdc/assets/css/style2.min.css?v=').date('YmdHis');?>">
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
            <ul class="nav justify-content-center">
                <li class="nav-item">
                    <a class="nav-link" href="#">หน้าหลัก</a>
                    <div class="line_active"></div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">PM<sub>2.5</sub>รายชั่วโมง</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">ค่าฝุ่นรายชั่วโมง</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">ค่าฝุ่นรายวัน</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Snap Shot</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">แจ้งข่าว</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">News</a>
                </li>
            </ul>
        </div>
    </section>
    <!-- เมนูเวลาเลื่อนลงมา -->
    <section id="main">
        <div class="container-fluid">
            <div class="header">
                <div class="logo col-12">
                    <img src="<?=base_url('assets/ccdc/assets/image/logo_ccdc.png');?>" alt="CCDC : Climate Change Data Center">
                </div>
                <div class="line d-none d-lg-block"></div>
                <div class="menu col-12 d-none d-lg-flex">
                    <div class="main_menu">
                        <ul class="nav justify-content-center">
                            <li class="nav-item">
                                <a class="nav-link" href="index.html">หน้าหลัก</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0);">PM<sub>2.5</sub>ตามพิกัด</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="main.html">ค่าฝุ่นรายชั่วโมง</a>
                                <div class="line_active"></div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0);">ค่าฝุ่นรายวัน</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0);">ภาพถ่าย</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0);">ข่าวและวิดีโอ</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);" role="button"
                                    aria-haspopup="true" aria-expanded="false">สถานการณ์หมอกควัน</a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">สถานการณ์หมอกควันในช่วง 7 วันที่ผ่านมา<a>
                                    <a class="dropdown-item" href="#">รายงานประจำวัน</a>
                                    <a class="dropdown-item" href="#">ค่าเฉลี่ยรายวัน</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);" role="button"
                                    aria-haspopup="true" aria-expanded="false">แหล่งความรู้</a>
                                <div class="dropdown-menu">
                                    <h6 class="dropdown-header">บทความ</h6>
                                    <a class="dropdown-item" href="#">บทความ / งานวิจัย<a>
                                    <div class="dropdown-divider"></div>
                                    <h6 class="dropdown-header">ฐานข้อมูล</h6>
                                    <a class="dropdown-item" href="#">ข้อมูลหมอกควัน</a>
                                    <div class="dropdown-divider"></div>
                                    <h6 class="dropdown-header">คำนวณ</h6>
                                    <a class="dropdown-item" href="#">การคำนวณเชิงเศรษฐศาสตร์</a>
                                    <a class="dropdown-item" href="#">การคำนวณเชิงสุขภาพอนามัยของมนุษย์</a>
                                    <h6 class="dropdown-header">เพิ่มเติม</h6>
                                    <a class="dropdown-item" href="#">DustBoy API</a>
                                    <a class="dropdown-item" href="#">ดาวน์โหลด</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
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
                                            <img class="shadow-drop-bottom-icon anime_delay1" src="<?=base_url('assets/ccdc/assets/image/pm25/us/nrct-06.png');?>">
                                        </div>
                                        <div class="col col-md-1 detail_pm_aqi us2" >
                                            <!-- <i class="fas fa-meh fa-2x text-shadow-drop-bottom-icon anime_delay1"></i> -->
                                            <img class="shadow-drop-bottom-icon anime_delay1" src="<?=base_url('assets/ccdc/assets/image/pm25/us/nrct-07.png');?>">
                                        </div>
                                        <div class="col col-md-1 detail_pm_aqi us3" >
                                            <!-- <i class="fas fa-frown-open fa-2x text-shadow-drop-bottom-icon anime_delay1"></i> -->
                                            <img class="shadow-drop-bottom-icon anime_delay1" src="<?=base_url('assets/ccdc/assets/image/pm25/us/nrct-08.png');?>">
                                        </div>
                                        <div class="col col-md-1 detail_pm_aqi us4" >
                                            <!-- <i class="fas fa-sad-tear fa-2x text-shadow-drop-bottom-icon anime_delay1"></i> -->
                                            <img class="shadow-drop-bottom-icon anime_delay1" src="<?=base_url('assets/ccdc/assets/image/pm25/us/nrct-09.png');?>">
                                        </div>
                                        <div class="col col-md-1 detail_pm_aqi us5" >
                                            <!-- <i class="fas fa-tired fa-2x text-shadow-drop-bottom-icon anime_delay1"></i> -->
                                            <img class="shadow-drop-bottom-icon anime_delay1" src="<?=base_url('assets/ccdc/assets/image/pm25/us/nrct-10.png');?>">
                                        </div>
                                        <div class="col col-md-1 detail_pm_aqi us6" >
                                            <!-- <i class="fas fa-dizzy fa-2x text-shadow-drop-bottom-icon anime_delay1"></i> -->
                                            <img class="shadow-drop-bottom-icon anime_delay1" src="<?=base_url('assets/ccdc/assets/image/pm25/us/nrct-11.png');?>">
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
                                            <img class="shadow-drop-bottom-icon anime_delay1" src="<?=base_url('assets/ccdc/assets/image/pm25/th/nrct-01.png');?>">
                                        </div>
                                        <div class="col-2 col-md-1 detail_pm_aqi th2" >
                                            <!-- <i class="fas fa-grin-beam fa-2x text-shadow-drop-bottom-icon anime_delay1"></i> -->
                                            <img class="shadow-drop-bottom-icon anime_delay1" src="<?=base_url('assets/ccdc/assets/image/pm25/th/nrct-02.png');?>">
                                        </div>
                                        <div class="col-2 col-md-1 detail_pm_aqi th3" >
                                            <!-- <i class="fas fa-meh fa-2x text-shadow-drop-bottom-icon anime_delay1"></i> -->
                                            <img class="shadow-drop-bottom-icon anime_delay1" src="<?=base_url('assets/ccdc/assets/image/pm25/th/nrct-03.png');?>">
                                        </div>
                                        <div class="col-2 col-md-1 detail_pm_aqi th4" >
                                            <!-- <i class="fas fa-sad-tear fa-2x text-shadow-drop-bottom-icon anime_delay1"></i> -->
                                            <img class="shadow-drop-bottom-icon anime_delay1" src="<?=base_url('assets/ccdc/assets/image/pm25/th/nrct-04.png');?>">
                                        </div>
                                        <div class="col-2 col-md-1 detail_pm_aqi th5" >
                                            <!-- <i class="fas fa-dizzy fa-2x text-shadow-drop-bottom-icon anime_delay1"></i> -->
                                            <img class="shadow-drop-bottom-icon anime_delay1" src="<?=base_url('assets/ccdc/assets/image/pm25/th/nrct-05.png');?>">
                                        </div>
                                    </div>
                                </div>
                                <div id="images"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="fade_out">
        <div class="container">
            <div class="row align-items-center">
                <div class="logo_contact col-12 col-lg-6">
                    <img src="<?=base_url('assets/ccdc/assets/image/contact_ccdc.png');?>" alt="CCDC : Climate Change Data Center">
                </div>
                <div class="menu_contact col-12 col-lg-6 row">
                    <div class="menu_min col-12 d-sm-block d-md-block d-lg-none">
                        <ul class="nav justify-content-center text-center mb-3">
                            <div class="col-6 col-lg-12">
                                <li class="nav-item">
                                    <a class="nav-link" href="index.html">หน้าหลัก</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="javascript:void(0);">PM<sub>2.5</sub>ตามพิกัด</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="main.html">ค่าฝุ่นรายชั่วโมง</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="javascript:void(0);">ค่าฝุ่นรายวัน</a>
                                </li>
                            </div>
                            <div class="col-6 col-lg-12">
                                <li class="nav-item">
                                    <a class="nav-link" href="javascript:void(0);">ภาพถ่าย</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="javascript:void(0);">ข่าวและวิดีโอ</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);" role="button"
                                        aria-haspopup="true" aria-expanded="false">สถานการณ์หมอกควัน</a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#">สถานการณ์หมอกควันในช่วง 7 วันที่ผ่านมา<a>
                                        <a class="dropdown-item" href="#">รายงานประจำวัน</a>
                                        <a class="dropdown-item" href="#">ค่าเฉลี่ยรายวัน</a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);" role="button"
                                        aria-haspopup="true" aria-expanded="false">แหล่งความรู้</a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <h6 class="dropdown-header">บทความ</h6>
                                        <a class="dropdown-item" href="#">บทความ / งานวิจัย<a>
                                        <div class="dropdown-divider"></div>
                                        <h6 class="dropdown-header">ฐานข้อมูล</h6>
                                        <a class="dropdown-item" href="#">ข้อมูลหมอกควัน</a>
                                        <div class="dropdown-divider"></div>
                                        <h6 class="dropdown-header">คำนวณ</h6>
                                        <a class="dropdown-item" href="#">การคำนวณเชิงเศรษฐศาสตร์</a>
                                        <a class="dropdown-item" href="#">การคำนวณเชิงสุขภาพอนามัยของมนุษย์</a>
                                        <h6 class="dropdown-header">เพิ่มเติม</h6>
                                        <a class="dropdown-item" href="#">DustBoy API</a>
                                        <a class="dropdown-item" href="#">ดาวน์โหลด</a>
                                    </div>
                                </li>
                            </div>
                        </ul>
                    </div>
                    <div class="line d-block d-lg-none"></div>
                    <div class="contact col-12 offset-md-1 col-md-6 offset-lg-0 col-lg-6">
                        <div class="row">
                            <div class="col-6 col-lg-12">
                                <ul class="ul_contact ml-sm-5 ml-md-0">
                                    <li class="li_contact"><a href="#">HOME</a></li>
                                    <li class="li_contact"><a href="#">DUSTBOY LOCATION</a></li>
                                    <li class="li_contact"><a href="#">PM 2.5 CIGARETTE EQUIVALENCE</a></li>
                                    <li class="li_contact"><a href="#">STATISTICS</a></li>
                                    <li class="li_contact"><a href="#">CHART</a></li>
                                    <li class="li_contact"><a href="#">SNAPSHOT</a></li>
                                </ul>
                            </div>
                            <div class="col-6 col-lg-12">
                                <ul class="ul_contact">
                                    <li class="li_contact"><a href="#">WHAT is DustBoy</a></li>
                                    <li class="li_contact"><a href="#">INFO</a></li>
                                    <li class="li_contact"><a href="#">VIDEO</a></li>
                                    <li class="li_contact"><a href="#">NEWS and ARTICLES</a></li>
                                    <li class="li_contact"><a href="#">PARTNER</a></li>
                                    <li class="li_contact"><a href="#">CONTACT US</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="contact col-12 col-md-5 offset-lg-0 col-lg-6 pl-4">
                        <p class="text-white">CONTACT US</p>
                        <p class="group_icon text-white">
                            <a href="#" class="icon mr-3"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                    width="26" height="26" viewBox="0 0 172 172" style=" fill:#000000;">
                                    <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1"
                                        stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10"
                                        stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none"
                                        font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                                        <path d="M0,172v-172h172v172z" fill="none"></path>
                                        <g fill="#ffffff">
                                            <path
                                                d="M125.59583,64.5h-25.2625v-14.33333c0,-7.396 0.602,-12.05433 11.2015,-12.05433h13.38733v-22.79c-6.5145,-0.67367 -13.06483,-1.00333 -19.62233,-0.989c-19.44317,0 -33.63317,11.87517 -33.63317,33.67617v16.4905h-21.5v28.66667l21.5,-0.00717v64.50717h28.66667v-64.5215l21.973,-0.00717z">
                                            </path>
                                        </g>
                                    </g>
                                </svg>
                            </a>
                            <a href="#" class="icon mr-3"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                    width="26" height="26" viewBox="0 0 172 172" style=" fill:#000000;">
                                    <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1"
                                        stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10"
                                        stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none"
                                        font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                                        <path d="M0,172v-172h172v172z" fill="none"></path>
                                        <g fill="#ffffff">
                                            <path
                                                d="M41.75962,0.20673l11.78365,38.65865v25.22115h9.92308v-26.46154l11.37019,-37.41827h-9.92308l-6.20192,25.42788h-0.62019l-6.40865,-25.42788zM87.44712,15.71154c-3.97956,0 -7.15805,1.13702 -9.50962,3.30769c-2.35156,2.14483 -3.51442,5.03906 -3.51442,8.68269v24.39423c0,4.00541 1.21454,7.36478 3.51442,9.71635c2.32572,2.3774 5.24579,3.51442 9.09615,3.51442c3.97957,0 7.23558,-1.21454 9.50962,-3.51442c2.27404,-2.29988 3.30769,-5.47837 3.30769,-9.50962v-24.39423c0,-3.59195 -1.1887,-6.40865 -3.51442,-8.68269c-2.29988,-2.29988 -5.24579,-3.51442 -8.88942,-3.51442zM107.29327,16.95192v39.48558c0,2.81671 0.62019,4.80649 1.65385,6.20192c1.03365,1.39544 2.53246,2.06731 4.54808,2.06731c1.62801,0 3.23017,-0.46514 4.96154,-1.44712c1.75721,-1.00781 3.56611,-2.42908 5.16827,-4.34135v5.16827h8.68269v-47.13462h-8.68269v35.76442c-0.82692,1.00781 -1.70553,1.83474 -2.6875,2.48077c-0.98197,0.67188 -1.83474,1.03365 -2.48077,1.03365c-0.80108,0 -1.49879,-0.12921 -1.86058,-0.62019c-0.38762,-0.49099 -0.41346,-1.39543 -0.41346,-2.48077v-36.17788zM87.03365,23.98077c1.16286,0 2.19651,0.20673 2.89423,0.82692c0.72356,0.64603 1.03365,1.47296 1.03365,2.48077v25.84135c0,1.26622 -0.33594,2.19651 -1.03365,2.89423c-0.69772,0.72356 -1.70553,1.03365 -2.89423,1.03365c-1.16286,0 -2.06731,-0.33594 -2.6875,-1.03365c-0.64603,-0.69772 -0.82692,-1.60216 -0.82692,-2.89423v-25.84135c0,-1.00781 0.36178,-1.83474 1.03365,-2.48077c0.67188,-0.62019 1.42128,-0.82692 2.48077,-0.82692zM86,73.80288c-17.15865,-0.02584 -33.98137,0.12921 -50.44231,0.82692c-11.4994,0 -20.87981,9.27704 -20.87981,20.67308c-0.69772,9.01863 -1.05949,18.0631 -1.03365,27.08173c-0.02584,9.01863 0.33594,18.0631 1.03365,27.08173c0,11.39603 9.38041,20.67308 20.87981,20.67308c16.46094,0.67188 33.28365,0.85276 50.44231,0.82692c17.18449,0.05169 34.00721,-0.15504 50.44231,-0.82692c11.4994,0 20.87981,-9.27704 20.87981,-20.67308c0.69772,-9.01863 1.05949,-18.0631 1.03365,-27.08173c0.05169,-9.01863 -0.33594,-18.0631 -1.03365,-27.08173c0,-11.39603 -9.38041,-20.67308 -20.87981,-20.67308c-16.4351,-0.69772 -33.25781,-0.85276 -50.44231,-0.82692zM24.80769,88.48077h30.38942c0.54267,0 1.03365,0.49099 1.03365,1.03365v9.30288c0,0.54267 -0.49099,1.03365 -1.03365,1.03365h-9.30288v53.54327c0,0.54267 -0.28426,1.03365 -0.82692,1.03365h-9.92308c-0.54267,0 -1.03365,-0.49099 -1.03365,-1.03365v-53.54327h-9.30288c-0.54267,0 -0.82692,-0.49099 -0.82692,-1.03365v-9.30288c0,-0.54267 0.28426,-1.03365 0.82692,-1.03365zM88.6875,88.48077h8.88942c0.54267,0 1.03365,0.49099 1.03365,1.03365v17.98558c0.72356,-0.67187 1.4988,-1.21454 2.27404,-1.65385c1.4988,-0.82692 3.02344,-1.24038 4.54808,-1.24038c3.10096,0 5.375,1.24038 7.02885,3.51442c1.57632,2.19651 2.48077,5.27163 2.48077,9.30288v26.25481c0,3.56611 -0.7494,6.33113 -2.27404,8.26923c-1.57632,2.01563 -3.92788,3.10096 -6.82212,3.10096c-1.83474,0 -3.46274,-0.49099 -4.96154,-1.24038c-0.80108,-0.41346 -1.55048,-0.80108 -2.27404,-1.44712v1.03365c0,0.54267 -0.49099,1.03365 -1.03365,1.03365h-8.88942c-0.54267,0 -1.03365,-0.49099 -1.03365,-1.03365v-63.87981c0,-0.54267 0.49099,-1.03365 1.03365,-1.03365zM133.75481,103.98558c4.28967,0 7.80409,1.34375 10.12981,3.92788c2.32572,2.58413 3.51442,6.25361 3.51442,10.95673v12.19712c0,0.54267 -0.49099,0.82692 -1.03365,0.82692h-15.71154v8.0625c0,2.89423 0.3101,4.03125 0.62019,4.54808c0.25842,0.41346 0.69772,1.03365 2.06731,1.03365c1.11118,0 1.88642,-0.3101 2.27404,-0.82692c0.18089,-0.28426 0.62019,-1.31791 0.62019,-4.75481v-3.30769c0,-0.54267 0.49099,-1.03365 1.03365,-1.03365h9.09615c0.54267,0 1.03365,0.49099 1.03365,1.03365v3.51442c0,5.09074 -1.36959,8.96695 -3.72115,11.57692c-2.35156,2.63582 -5.89183,3.92788 -10.54327,3.92788c-4.21214,0 -7.49399,-1.31791 -9.92308,-4.13462c-2.40324,-2.76503 -3.72115,-6.58954 -3.72115,-11.37019v-21.29327c0,-4.34135 1.26622,-7.77824 3.92788,-10.54327c2.66166,-2.76503 6.15024,-4.34135 10.33654,-4.34135zM55.19712,105.22596h8.68269c0.54267,0 1.03365,0.49099 1.03365,1.03365v36.17788c0,1.18871 0.07753,1.67969 0.20673,1.86058c0.05169,0.07753 0.28426,0.41346 1.03365,0.41346c0.25842,0 0.82692,-0.10337 1.86058,-0.82692c0.85276,-0.56851 1.60217,-1.26622 2.27404,-2.06731v-35.55769c0,-0.54267 0.49099,-1.03365 1.03365,-1.03365h8.88942c0.54267,0 0.82692,0.49099 0.82692,1.03365v47.13462c0,0.54267 -0.28426,1.03365 -0.82692,1.03365h-8.88942c-0.54267,0 -1.03365,-0.49099 -1.03365,-1.03365v-2.6875c-1.16286,1.13702 -2.29988,1.98978 -3.51442,2.6875c-1.91226,1.08534 -3.72115,1.65385 -5.58173,1.65385c-2.35156,0 -4.16046,-0.80108 -5.375,-2.48077c-1.16286,-1.57632 -1.65385,-3.82452 -1.65385,-6.82212v-39.48558c0,-0.54267 0.49099,-1.03365 1.03365,-1.03365zM100.88462,114.11538c-0.33594,0.05169 -0.67187,0.23257 -1.03365,0.41346c-0.41346,0.20673 -0.82692,0.59435 -1.24038,1.03365v28.52885c0.51683,0.54267 0.95613,1.00781 1.44712,1.24038c0.54267,0.25842 1.05949,0.41346 1.65385,0.41346c1.11118,0 1.55048,-0.46514 1.65385,-0.62019c0.25842,-0.33594 0.41346,-1.11118 0.41346,-2.6875v-24.39423c0,-1.34375 -0.12921,-2.45493 -0.62019,-3.10096c-0.49099,-0.64603 -1.26622,-1.00781 -2.27404,-0.82692zM133.54808,114.32212c-1.05949,0 -1.83474,0.23257 -2.27404,0.82692c-0.3101,0.4393 -0.62019,1.52464 -0.62019,3.72115v3.72115h5.58173v-3.72115c0,-2.17067 -0.28426,-3.23017 -0.62019,-3.72115c-0.41346,-0.56851 -1.05949,-0.82692 -2.06731,-0.82692z">
                                            </path>
                                        </g>
                                    </g>
                                </svg>
                            </a>
                        </p>
                    </div>
                </div>
                <div class="footer col-12">
                    <div> &copy; 2019. All rights reserved by CCDC.</div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <p class="mb-0">Copyright &copy; 2019. All rights reserved by CCDC</p>
    </footer>

    <script src="<?=base_url('assets/ccdc/assets/js/all/compress.min.js?v=').date('YmdHis');?>"></script>
    <script type="text/javascript" src="https://unpkg.com/leaflet-image@latest/leaflet-image.js"></script>
    <script src="<?=base_url('assets/ccdc/assets/js/main.js?v=').date('YmdHis');?>"></script>
</body>

</html>