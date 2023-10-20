<ul class="nav justify-content-center">
                            <li class="nav-item">
                                <a class="nav-link" href="<?=base_url()?>"><?=translate('nav_1')?></a>
                                <?=$_pageLink=="home"?'<div class="line_active"></div>':''?>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?=base_url('pm25')?>"><?=translate('nav_2')?></a>
								<?=$_pageLink=="pm25"?'<div class="line_active"></div>':''?>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?=base_url('hourly')?>"><?=translate('nav_3')?></a>
								<?=$_pageLink=="hourly"?'<div class="line_active"></div>':''?>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?=base_url('daily')?>"><?=translate('nav_4')?></a>
								<?=$_pageLink=="daily"?'<div class="line_active"></div>':''?>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?=base_url('snapshot')?>"><?=translate('nav_5')?></a>
								<?=$_pageLink=="snapshot"?'<div class="line_active"></div>':''?>
                            </li>
							<li class="nav-item">
                                <a class="nav-link" href="<?=base_url('hotspot')?>"><?=translate('nav_hotspot')?></a>
								<?=$_pageLink=="hotspot"?'<div class="line_active"></div>':''?>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?=base_url('news')?>"><?=translate('nav_6')?></a>
								<?=$_pageLink=="news"?'<div class="line_active"></div>':''?>
                            </li>
							<!--
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);" role="button"
                                    aria-haspopup="true" aria-expanded="false"><?=translate('nav_7')?></a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#"><?=translate('nav_7_1')?><a>
                                    <a class="dropdown-item" href="#"><?=translate('nav_7_2')?></a>
                                    <a class="dropdown-item" href="#"><?=translate('nav_7_3')?></a>
                                </div>
                            </li>-->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);" role="button"
                                    aria-haspopup="true" aria-expanded="false"><?=translate('nav_8')?></a>
                                <div class="dropdown-menu">
                                    <h6 class="dropdown-header"><?=translate('nav_8_1')?></h6>
                                    <a class="dropdown-item" href="<?=base_url('research')?>"><?=translate('nav_8_2')?></a>
                                    <a class="dropdown-item" href="<?=base_url('/uploads/reports/evaluation_report.pdf')?>" target="_blank"><?=translate('nav_8_1_2')?></a>
                                    <a class="dropdown-item" href="<?=base_url('/uploads/reports/calibration_report.pdf')?>" target="_blank"><?=translate('nav_8_1_3')?></a>
                                    <div class="dropdown-divider"></div>
                                    <h6 class="dropdown-header"><?=translate('nav_8_3')?></h6>
                                    <a class="dropdown-item" href="<?=base_url('air-quality-information')?>"><?=translate('nav_8_4')?></a>
                                    <a class="dropdown-item" href="<?=base_url('dailyavg')?>"><?=translate('nav_7_3')?></a>
                                    <a class="dropdown-item" href="<?=base_url('prophecy')?>"><?=translate('nav_7_4')?></a>
                                    <a class="dropdown-item" href="<?=base_url('summaryreport')?>">PM2.5 AQI</a>
                                    <a class="dropdown-item" href="<?=base_url('map-visualization')?>">PM2.5 Map Visualization</a>
                                    <a class="dropdown-item" href="https://cmu.cmuccdc.org/fullmap.php">โครงการติดตั้งเครื่อง DustBoy</a>
                                    <!-- <a class="dropdown-item" href="<?=base_url('daily_report')?>">รายงานประจำวัน วช.</a> -->
                                    <a class="dropdown-item" href="<?=base_url('report_hpc1')?>">สถานการณ์PM<sub>2.5</sub>แยกรายพื้นที่ เขตสุภาพที่ 1</a>
                                    <a class="dropdown-item" href="<?=base_url('hpc1')?>" target="_blank">ศูนย์ข้อมูลฝุ่นควัน เขตสุภาพที่ 1</a>
                                    <a class="dropdown-item" href="<?=base_url('cmu_report')?>" target="_blank">รายงานประจำวัน มช.</a>
                                    <a class="dropdown-item" href="<?=base_url('maintain/pm_standard')?>" target="_blank"><?=translate('nav_7777')?></a>
                                    <div class="dropdown-divider"></div>
                                    <h6 class="dropdown-header"><?=translate('nav_8_5')?></h6>
                                    <!-- <a class="dropdown-item" href="<?=base_url('calculate')?>"><?=translate('nav_8_5_1')?></a> -->
                                    <a class="dropdown-item" href="<?=base_url('economic-damage')?>"><?=translate('nav_8_6')?></a>
                                    <a class="dropdown-item" href="<?=base_url('health-damage')?>"><?=translate('nav_8_7')?></a>
                                    <h6 class="dropdown-header"><?=translate('nav_8_8')?></h6>
                                    <a class="dropdown-item" href="<?=base_url('maintain')?>">DustBoy อาสา</a>
                                    <a class="dropdown-item" href="<?=base_url('maintain/dustboy_status')?>">DustBoy status</a>
                                    <a class="dropdown-item" href="<?=base_url('open-api')?>"><?=translate('nav_8_9')?></a>
                                    <a class="dropdown-item" href="<?=base_url('guide')?>">คู่มือติดตั้ง DustBoy</a>
                                    <a class="dropdown-item" href="<?=base_url('download')?>"><?=translate('nav_8_10')?></a>
                                    <a class="dropdown-item" href="<?=base_url('sitemap')?>"><?=translate('nav_8_11')?></a>
                                </div>
                            </li>
                        </ul>
