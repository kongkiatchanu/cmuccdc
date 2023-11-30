<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>DustBoy Day</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;400;700&display=swap" rel="stylesheet">
    <link href="/dustboy_template/css/bootstrap.min.css" rel="stylesheet">
    <link href="/dustboy_template/css/bootstrap-icons.css" rel="stylesheet">
    <link href="/dustboy_template/css/templatemo-festava-live.css?v=<?=date('his')?>" rel="stylesheet">
           
<style>
    .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active, .nav-tabs .nav-link:focus, .nav-tabs .nav-link:hover {
    background: #e77424;
    box-shadow: 0 1rem 3rem rgba(0,0,0,.175);
    color: #fff;
    font-weight: bold;
    }
    .nav-tabs .nav-link{color:#fff;font-weight: bold;}
    .nav-tabs{background: transparent;margin-bottom: 15px;padding:0;}
    .tab-content{padding: 0;filter: drop-shadow(2px 2px 4px #606060);background-color: unset !important;}
    .accordion-item:first-of-type{border-radius: 30px;}
    .accordion-item:last-of-type{border-radius: 30px;}
    .accordion-item{color: #fff;padding:20px;background-color: #212529;border: 0;opacity: .8;border-radius: 30px;}
    .s_title{color:#e77424;font-size:25px}
    @media (max-width: 991px) {
        .tab-content>.tab-pane {
            display: block;
            opacity: 1;
            padding: 0;
        }
        .accordion-item{border-radius: 0px;}
        .accordion-item:first-of-type{border-radius: 0px;}
        .accordion-item:last-of-type{border-radius: 0px;}
    }
</style>
</head>

<body>

    <main>
        <header class="site-header">
            <div class="container">
                <div class="row">

                    <div class="col-lg-12 col-12 d-flex flex-wrap">
                        <p class="d-flex me-4 mb-0">
                            <i class="bi-person custom-icon me-2"></i>
                            <strong class="text-dark">Welcome to DustBoy Day 2023</strong>
                        </p>
                    </div>

                </div>
            </div>
        </header>


        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="https://www.cmuccdc.org/2ndDustBoyDay">
                    DustBoy Day
                </a>

                <a href="https://www.cmuccdc.org/" target="_blank" class="btn custom-btn d-lg-none ms-auto me-4">Website</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav align-items-lg-center ms-auto me-lg-5">
                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="#section_1">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="#section_2">Schedule</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="#section_3">Speakers</a>
                        </li>
                    </ul>

                    <a href="https://www.cmuccdc.org/" target="_blank" class="btn custom-btn d-lg-block d-none">Website</a>
                </div>
            </div>
        </nav>


        <section class="hero-section" id="section_1">
            <div class="section-overlay"></div>

            <div class="container d-flex justify-content-center align-items-center">
                <div class="row">

                    <div class="col-12 mt-auto mb-5 text-center">
                        <small>CMUCCDC Presents</small>

                        <h1 class="text-white mb-5">2<sup>nd</sup> DustBoy Day 2023</h1>

                        <a class="btn custom-btn smoothscroll" href="#section_2">Let's begin</a>
                    </div>
                </div>
            </div>

            <div class="video-wrap">
                <video autoplay="" loop="" muted="" class="custom-video" poster="">
                    <source src="https://www-old.cmuccdc.org/assets/api/haze/dustboy_video.mp4" type="video/mp4">

                    Your browser does not support the video tag.
                </video>
            </div>
        </section>


        


 

        <section class="schedule-section section-padding" id="section_2">
            <div class="container">
                <div class="row">

                    <div class="col-12">
                        <h2 class="text-white text-center mb-4">Event Schedule</h1>

                        <ul class="nav nav-tabs d-none d-lg-flex" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">#Welcome</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#session1-tab-pane" type="button" role="tab" aria-controls="session1-tab-pane" aria-selected="false">#Session 1</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#session2-tab-pane" type="button" role="tab" aria-controls="session2-tab-pane" aria-selected="false">#Session 2</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#session3-tab-pane" type="button" role="tab" aria-controls="session3-tab-pane" aria-selected="false">#Session 3</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#session4-tab-pane" type="button" role="tab" aria-controls="session4-tab-pane" aria-selected="false">#Session 4</button>
                            </li>
                        </ul>
                        <div class="tab-content accordion" id="myTabContent">
                            <div class="tab-pane fade show active accordion-item" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">

                                <h2 class="accordion-header d-lg-none" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                       #Welcome
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show  d-lg-block" aria-labelledby="headingOne" data-bs-parent="#myTabContent">
                                <div class="accordion-body">
                                    <div class="row mb-3">
                                        <div class="col-sm-3 mb-2"><p class="m-0 text-white">08.30 - 08.40 น.</p></div>
                                        <div class="col-sm-9 mb-2">
                                            <h4 class="s_title">Openning Remark</h4>
                                            <p class="m-0 text-white">โดย ดร.วิภารัตน์ ดีอ่อง (ผู้อำนวยการสำนักงานการวิจัยแห่งชาติ)</p>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3 mb-2"><p class="m-0 text-white">08.40 – 08.45 น.</p></div>
                                        <div class="col-sm-9 mb-2">
                                            <h4 class="s_title">"DustBoy Next"</h4>
                                            <p class="m-0 text-white">โดย รศ. ดร.เศรษฐ์ สัมภัตตะกุล (ผู้อำนวยการสำนักบริการวิชาการ มหาวิทยาลัยเชียงใหม่)</p>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3 mb-2"><p class="m-0 text-white">08.45 – 09.15 น.</p></div>
                                        <div class="col-sm-9 mb-2">
                                            <p class="m-0 text-white">พิธีลงนามความร่วมมือระหว่างมหาวิทยาลัยเชียงใหม่และ SuperMap</p>
                                        </div>
                                    </div>
    
                                </div>
                                </div>

                            </div>
                            <div class="tab-pane fade accordion-item" id="session1-tab-pane" role="tabpanel" aria-labelledby="session1-tab" tabindex="0">
                                <h2 class="accordion-header d-lg-none" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    #Session 1
                                </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse d-lg-block" aria-labelledby="headingTwo" data-bs-parent="#myTabContent">
                                <div class="accordion-body">
                                    <h3 class="text-white mb-3">DustBoy Data Manipulation</h3>
                                    <div class="row mb-3">
                                        <div class="col-sm-3 mb-2"><p class="m-0 text-white">09.15 – 09.25 น.</p></div>
                                        <div class="col-sm-9 mb-2">
                                            <h4 class="s_title">บรรยาย “ปัจจัยทางอุตุนิยมวิทยากับค่าฝุ่น PM2.5”</h4>
                                            <p class="m-0 text-white">โดย ดร.สุกฤษฎ์ เกิดแสง (ผู้เชี่ยวชาญเฉพาะด้านวิจัยและพัฒนาอุตุนิยมวิทยา)</p>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3 mb-2"><p class="m-0 text-white">09.25 – 09.35 น.</p></div>
                                        <div class="col-sm-9 mb-2">
                                            <h4 class="s_title">บรรยาย “การสร้างมาตรฐาน Low-cost PM sensor”</h4>
                                            <p class="m-0 text-white">โดย ดร.พัชรพล กอกิตรัตนกุล (นักวิจัย สถาบันมาตรวิทยาแห่งชาติ)</p>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3 mb-2"><p class="m-0 text-white">09.35 – 09.45 น.</p></div>
                                        <div class="col-sm-9 mb-2">
                                            <h4 class="s_title">บรรยาย “การบูรณาการระบบการส่งข้อมูลผ่านดาวเทียม”</h4>
                                            <p class="m-0 text-white">โดย อ.ดร.ภูดินันท์ สิงห์คำฟู (อาจารย์ประจำวิทยาลัยศิลปะ สื่อ และเทคโนโลยี มหาวิทยาลัยเชียงใหม่)</p>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3 mb-2"><p class="m-0 text-white">09.45 – 09.55 น.</p></div>
                                        <div class="col-sm-9 mb-2">
                                            <h4 class="s_title">บรรยาย “DustBoy Open Source”</h4>
                                            <p class="m-0 text-white">โดย คุณณัฐ วีระวรรณ์ (นักพัฒนาซอฟท์แวร์ หน่วยวิจัยเพื่อการจัดการพลังงานและเศรษฐนิเวศ สถาบันวิจัยพหุศาสตร์ มหาวิทยาลัยเชียงใหม่)</p>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="tab-pane fade accordion-item" id="session2-tab-pane" role="tabpanel" aria-labelledby="session2-tab" tabindex="0">
                                <h2 class="accordion-header d-lg-none" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    #Session 2
                                </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse d-lg-block" aria-labelledby="headingThree" data-bs-parent="#myTabContent">
                                <div class="accordion-body">
                                    <h3 class="text-white mb-3">DustBoy Data to Platform</h3>
                                    <div class="row mb-3">
                                        <div class="col-sm-3 mb-2"><p class="m-0 text-white">09.55 – 10.05 น.</p></div>
                                        <div class="col-sm-9 mb-2">
                                            <h4 class="s_title">บรรยาย “โครงการไม่เผาเราซื้อ”</h4>
                                            <p class="m-0 text-white">โดย คุณเกษศิรินทร์ แปงเสน (หัวหน้าโครงการแม่เมาะเมืองน่าอยู่ การไฟฟ้าฝ่ายผลิตแห่งประเทศไทย)</p>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3 mb-2"><p class="m-0 text-white">10.05 – 10.15 น.</p></div>
                                        <div class="col-sm-9 mb-2">
                                            <h4 class="s_title">บรรยาย “DustBoy ในโมเดลพยากรณ์และแพลตฟอร์ม”</h4>
                                            <p class="m-0 text-white">โดย ผศ.ดร.ชาคริต โชติอมรศักดิ์ (อาจารย์ประจำคณะสังคมศาสตร์ มหาวิทยาลัยเชียงใหม่)</p>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3 mb-2"><p class="m-0 text-white">10.15 – 10.25 น.</p></div>
                                        <div class="col-sm-9 mb-2">
                                            <h4 class="s_title">บรรยาย “การบูรณาการข้อมูล DustBoy เพื่อแสดงผล”</h4>
                                            <p class="m-0 text-white">โดย ผศ.ดร.อริศรา เจริญปัญญาเนตร (หัวหน้าศูนย์ GISTNORTH คณะสังคมศาสตร์ มหาวิทยาลัยเชียงใหม่)</p>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3 mb-2"><p class="m-0 text-white">10.25 – 10.35 น.</p></div>
                                        <div class="col-sm-9 mb-2">
                                            <h4 class="s_title">บรรยาย “DustBoy กับการพัฒนาคู่แฝดพลวัตดิจิทัลเพื่อการจัดการมหาวิทยาลัยอัจฉริยะอย่างยั่งยืน”</h4>
                                            <p class="m-0 text-white">โดย คุณสัตยา มะโนแก้ว (นักวิจัยเชิงรุก สำนักบริหารการวิจัย มหาวิทยาลัยเชียงใหม่)</p>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3 mb-2"><p class="m-0 text-white">10.35 – 10.45 น.</p></div>
                                        <div class="col-sm-9 mb-2">
                                            <h4 class="s_title">บรรยาย “DustBoy & SuperMap”</h4>
                                            <p class="m-0 text-white">โดย ดร. สรศักดิ์ คุ้มบุญ (Technical Support บริษัท SuperMap)</p>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="tab-pane fade accordion-item" id="session3-tab-pane" role="tabpanel" aria-labelledby="session3-tab" tabindex="0">
                                <h2 class="accordion-header d-lg-none" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree3" aria-expanded="false" aria-controls="collapseThree">
                                    #Session 3
                                </button>
                                </h2>
                                <div id="collapseThree3" class="accordion-collapse collapse d-lg-block" aria-labelledby="headingThree" data-bs-parent="#myTabContent">
                                <div class="accordion-body">
                                    <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                </div>
                                </div>
                            </div>
                            <div class="tab-pane fade accordion-item" id="session4-tab-pane" role="tabpanel" aria-labelledby="session4-tab" tabindex="0">
                                <h2 class="accordion-header d-lg-none" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree4" aria-expanded="false" aria-controls="collapseThree">
                                    #Session 4
                                </button>
                                </h2>
                                <div id="collapseThree4" class="accordion-collapse collapse d-lg-block" aria-labelledby="headingThree" data-bs-parent="#myTabContent">
                                <div class="accordion-body">
                                    <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="artists-section section-padding p-0" id="section_3">
            <div class="container-fluid">
                <div class="row justify-content-center">

                   
                    <div class="col-12 p-0">
                        <img src="https://www.cmuccdc.org/dustboy_template/images/speakers.jpg" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </section>

       

       
    </main>


    <footer class="site-footer">
        

        <div class="container">
            <div class="row py-4">

                <div class="col-lg-6 col-12 mb-4 pb-2">
                    <h5 class="site-footer-title mb-3">Address</h5>

                    <p class="text-white d-flex mt-3 mb-2">
                    Chiang Mai University, Su Thep, Mueang Chiang Mai District, Chiang Mai, Mueang Chiang Mai District, Chiang Mai 50200</p>
                </div>

                <div class="col-lg-3 col-md-6 col-12 mb-4 mb-lg-0">
                    <h5 class="site-footer-title mb-3">Have a question?</h5>

                    <p class="text-white d-flex mb-1">
                        <a href="tel: 053-942086" class="site-footer-link">
                        053-942086
                        </a>
                    </p>

                    <p class="text-white d-flex">
                        <a href="mailto:hello@company.com" class="site-footer-link">
                        dustboy.3e@gmail.com
                        </a>
                    </p>
                </div>

                
            </div>
        </div>

        <div class="site-footer-bottom">
            <div class="container">
                <div class="row">

                    <div class="col-12 text-center">
                        <p class="copyright-text m-0 py-2">Copyright © 2023 cmuccdc.org</p>

                    </div>

                </div>
            </div>
        </div>
    </footer>

    <!--

T e m p l a t e M o

-->

    <!-- JAVASCRIPT FILES -->
    <script src="/dustboy_template/js/jquery.min.js"></script>
    <script src="/dustboy_template/js/bootstrap.min.js"></script>
    <script src="/dustboy_template/js/jquery.sticky.js"></script>
    <script src="/dustboy_template/js/click-scroll.js"></script>
    <script src="/dustboy_template/js/custom.js"></script>

</body>

</html>