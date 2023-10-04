<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$this->config->item('title_name')?> | Login</title>
    <link rel="shortcut icon" type="image/png" href="http://www.nk.go.th/resource/img/logo.png">
    <link rel="stylesheet" href="<?=base_url()?>assets/admin2/assets/css/bootstrap/bootstrap.min.css?v=<?=date('YmdHis')?>"> 
    <link rel="stylesheet" href="<?=base_url()?>assets/admin2/assets/fontawesome/css/all.min.css?v=<?=date('YmdHis')?>">
    <link rel="stylesheet" href="<?=base_url()?>assets/admin2/assets/css/style.min.css?v=<?=date('YmdHis')?>">
</head>

<body>
    <section id="layout">
        <div id="layout-main" class="row">
            <div id="layout-left" class="col-12 col-lg-6">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="title">
                    TRACKING MODEL
                </div>
                <form id="frm-tracking" method="post" class="frm-tracking needs-validation" novalidate>
                    <div class="form-group row">
                        <div class="col-9 col-sm-10 col-md-10 col-xl-12 col-form-input">
                            <input id="tracking" class="form-control" type="text"
                                name="tracking" placeholder="enter your tracking model name" required>
                            <div class="valid-feedback text-right">
                                กรอกถูกต้องแล้ว!
                            </div>
                            <div class="invalid-feedback text-right">
                            </div>
                        </div>
                        <div class="col-3 col-sm-2 col-md-2 d-xl-none">
                            <button id="submit-tracking" class="btn btn-lg" type="submit" name="submit-tracking">
                                <i class="fas fa-search "></i>
                            </button>
                        </div>
                        <label class="col-sm-12 col-lg-12 col-form-label text-input-down" for="tracking">
                            ตัวอย่าง : DustBoy001, DBP20190002, CD4A11334FC4, N-004, N-005-NB, DustboyV1006
                        </label>
                    </div>
                </form>
            </div>
            <div id="layout-right" class="col-12 col-lg-6">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="title">
                    LOGIN
                </div>
                <form id="frm-login" action="<?=base_url()?>admin2/login/" method="post" class="frm-login needs-validation">
                    <div class="form-group row">
                        <label for="username" class="col-12 col-lg-4 col-form-label">Username</label>
                        <div class="col-12 col-lg-8 col-form-input">
                            <input id="username" class="form-control" type="text" name="username" placeholder="Name" required>
                            <div class="valid-feedback text-right">
                                กรอกถูกต้องแล้ว!
                            </div>
                            <div class="invalid-feedback text-right">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-12 col-lg-4 col-form-label">Password</label>
                        <div class="col-12 col-lg-8 col-form-input">
                            <input id="password" class="form-control" type="password" name="password" placeholder="******" required>
                            <div class="valid-feedback text-right">
                                กรอกถูกต้องแล้ว!
                            </div>
                            <div class="invalid-feedback text-right">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12 col-lg-8 offset-lg-4">
                            <button id="submit-login" class="form-control btn" type="submit"> 
                                LOGIN
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <section id="main-modal">
        <div id="tracking-modal" class="modal fade" tabindex="-1" role="dialog"
            aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-scrollable modal-dialog-centered" role="document">
                <div class="modal-content shadow-drop-bottom-tracking">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
						
                        <div class="title">
                            <h4>รายละเอียด</h4>
                            <p>รหัสเครื่อง : True-NB-IoT-003</p>
                            <p>สถานะ :
                                <span class="status-online text-success active">ออนไลน์</span>
                                <span class="status-offline text-danger">ออฟไลน์</span>
                                <span class="status-install text-base-color2">รอติดตั้ง</span>
                                <span class="status-fix text-base-color2">ส่งเครื่องซ่อม</span>
                            </p>
                        </div>
                        <ul>
							<!--ติดตั้งแล้ว-->
                            <li class="step active">
                                <div class="icon">
                                    <div id="anima-online" class="anima-icon"
                                        data-icon="<?=base_url()?>assets/admin2/assets/icon/custom-icon/online-offline.json"></div>
                                </div>
                                <span id="db_uri"></span>
                            </li>
							<!--รอติดตั้ง-->
                            <li class="step">
                                <div class="icon">
                                    <div id="anima-install" class="anima-icon"
                                        data-icon="<?=base_url()?>assets/admin2/assets/icon/custom-icon/hourglass.json"></div>
                                </div>
                            </li>
							<!--ซ่อม-->
                            <li class="step">
                                <div class="icon">
                                    <div id="anima-fix" class="anima-icon"
                                        data-icon="<?=base_url()?>assets/admin2/assets/icon/lordicon-icon/409-tool/409-tool-outline.json"></div>
                                </div>
                            </li>
                        </ul>
					
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="<?=base_url()?>assets/admin2/assets/js/jquery/jquery-3.5.1.min.js?v=<?=date('YmdHis')?>"></script>
    <script src="<?=base_url()?>assets/admin2/assets/js/bootstrap/bootstrap.min.js?v=<?=date('YmdHis')?>"></script>
    <script src="<?=base_url()?>assets/admin2/assets/js/popper/popper.min.js?v=<?=date('YmdHis')?>"></script>
    <script src="<?=base_url()?>assets/admin2/assets/js/lottie/lottie.min.js?v=<?=date('YmdHis')?>"></script>
    <script src="<?=base_url()?>assets/plugins/jquery-validation/dist/jquery.validate.min.js?v=<?=date('YmdHis')?>"></script>
    <script src="<?=base_url()?>assets/admin2/assets/js/script.js?v=<?=date('YmdHis')?>"></script>
    <!-- <script src="<?=base_url()?>assets/admin2/assets/js/test.js?v=1"></script> -->

</body>

</html>