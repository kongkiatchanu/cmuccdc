<section id="contact"
<?=$_pageLink=="pm25"?'class="fade_out"':''?>
<?=$_pageLink=="snapshot"?'class="fade_out"':''?>
<?=$_pageLink=="news"?'class="fade_out"':''?>
<?=$_pageLink=="video"?'class="fade_out"':''?>
<?=$_pageLink=="pmcompare"?'class="fade_out"':''?>
<?=$_pageLink=="calculate"?'class="fade_out"':''?>
<?=$_pageLink=="aboutus"?'class="fade_out"':''?>
<?=$_pageLink=="partner"?'class="fade_out"':''?>
<?=$_pageLink=="contactus"?'class="fade_out"':''?>
<?=$_pageLink=="research"?'class="fade_out"':''?>
<?=$_pageLink=="economic_damage"?'class="fade_out"':''?>
<?=$_pageLink=="health_damage"?'class="fade_out"':''?>
<?=$_pageLink=="aqi"?'class="fade_out"':''?>
<?=$_pageLink=="open-api"?'class="fade_out"':''?>
<?=$_pageLink=="download"?'class="fade_out"':''?>
<?=$_pageLink=="hourly"?'class="fade_out"':''?>
<?=$_pageLink=="sitemap"?'class="fade_out"':''?>
<?=$_pageLink=="dailyavg"?'class="fade_out"':''?>
<?=$_pageLink=="economic-damage"?'class="fade_out"':''?>
>
        <div class="container">
            <div class="row align-items-center">
                <div class="logo_contact col-12 col-lg-6">
                    <img src="<?=base_url()?>template/image/contact_ccdc.png" alt="CCDC : Climate Change Data Center">
                </div>
                <div class="menu_contact col-12 col-lg-6 row">
                    <div class="menu_min col-12 d-sm-block d-md-block d-lg-none">
                        <ul class="nav justify-content-center text-center mb-3">
                            <div class="col-6 col-lg-12">
                                <li class="nav-item">
                                    <a class="nav-link active" href="<?=base_url()?>"><?=translate('nav_1')?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?=base_url('pm25')?>"><?=translate('nav_2')?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?=base_url('hourly')?>"><?=translate('nav_3')?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?=base_url('daily')?>"><?=translate('nav_4')?></a>
                                </li>
                            </div>
                            <div class="col-6 col-lg-12">
                                <li class="nav-item">
                                    <a class="nav-link" href="<?=base_url('snapshot')?>"><?=translate('nav_5')?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?=base_url('news')?>"><?=translate('nav_6')?></a>
                                </li>
								<!--
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);" role="button"
                                        aria-haspopup="true" aria-expanded="false"><?=translate('nav_7')?></a>
                                    <div class="dropdown-menu dropdown-menu-right">
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
                            </div>
                        </ul>
                    </div>
                    <div class="line d-block d-lg-none"></div>
                    <div class="contact col-12 offset-md-1 col-md-6 offset-lg-0 col-lg-6">
                        <div class="row">
                            <div class="col-6 col-lg-12">
                                <ul class="ul_contact ml-sm-5 ml-md-0">
                                    <li class="li_contact"><a href="<?=base_url()?>">HOME</a></li>
                                    <li class="li_contact"><a href="<?=base_url('pmcompare')?>">PM 2.5 CIGARETTE EQUIVALENCE</a></li>
                                    <li class="li_contact"><a href="<?=base_url('calculate')?>">AQI Calculator</a></li>
                                    <!--<li class="li_contact"><a href="#">CHART</a></li>-->
                                    <li class="li_contact"><a href="<?=base_url('snapshot')?>">SNAP SHOT</a></li>
                                </ul>
                            </div>
                            <div class="col-6 col-lg-12">
                                <ul class="ul_contact">
                                    <li class="li_contact"><a href="<?=base_url('aboutus')?>">WHAT is DustBoy</a></li>
                                    <li class="li_contact"><a href="<?=base_url('news/category/information')?>">INFO</a></li>
                                    <li class="li_contact"><a href="<?=base_url('news/category/video')?>">VIDEO</a></li>
                                    <li class="li_contact"><a href="<?=base_url('news')?>">NEWS and ARTICLES</a></li>
                                    <li class="li_contact"><a href="<?=base_url('partner')?>">PARTNERS</a></li>
                                    <li class="li_contact"><a href="<?=base_url('sitemap')?>">SITEMAP</a></li>
                                    <li class="li_contact"><a href="<?=base_url('contactus')?>">CONTACT US</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="contact col-12 col-md-5 offset-lg-0 col-lg-6 pl-4">
                        <p class="text-white">SOCIAL MEDIA</p>
                        <p class="group_icon text-white">
                            <a target="_blank" href="https://www.facebook.com/cmu.ccdc" class="icon mr-3"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
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
                            <a target="_blank" href="https://www.youtube.com/playlist?list=PLWu8FwGKTfL9lY2Qo6SBpDUw-8CadQcw2" class="icon mr-3"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
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
                    <div> &copy; 2017. All rights reserved by CCDC.</div>
                </div>
            </div>
        </div>
    </section>
    <footer class="footer" 
	<?=$_pageLink=="pm25"?'style="position: unset;"':''?>
	<?=$_pageLink=="snapshot"?'style="position: unset;"':''?>
	<?=$_pageLink=="news"?'style="position: unset;"':''?>
	<?=$_pageLink=="video"?'style="position: unset;"':''?>
	<?=$_pageLink=="pmcompare"?'style="position: unset;"':''?>
	<?=$_pageLink=="calculate"?'style="position: unset;"':''?>
	<?=$_pageLink=="aboutus"?'style="position: unset;"':''?>
	<?=$_pageLink=="partner"?'style="position: unset;"':''?>
	<?=$_pageLink=="contactus"?'style="position: unset;"':''?>
	<?=$_pageLink=="research"?'style="position: unset;"':''?>
	<?=$_pageLink=="economic_damage"?'style="position: unset;"':''?>
	<?=$_pageLink=="health_damage"?'style="position: unset;"':''?>
	<?=$_pageLink=="aqi"?'style="position: unset;"':''?>
	<?=$_pageLink=="open-api"?'style="position: unset;"':''?>
	<?=$_pageLink=="download"?'style="position: unset;"':''?>
	<?=$_pageLink=="hourly"?'style="position: unset;"':''?>
	<?=$_pageLink=="sitemap"?'style="position: unset;"':''?>
	<?=$_pageLink=="dailyavg"?'style="position: unset;"':''?>
	<?=$_pageLink=="economic-damage"?'style="position: unset;"':''?>
	>

		<div class="text-center mb-0">Copyright &copy; 2017. All rights reserved by CCDC</div>
		<!-- <div class="f_stat float-sm-right mb-0"><i class="fas fa-users"></i> Users <?=@number_format($rsStat->rows[0][0])?> | <i class="far fa-eye"></i>  Sessions <?=@number_format($rsStat->rows[0][1])?></div> -->

		<div class="clearfix"></div>
	</footer>
