<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $version = md5('signoutzz');?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$siteInfo['pre_title']?> | <?=$siteInfo['site_title']?></title>
	<meta name="description" content="<?=$siteInfo['site_des']?>">
	<meta name="keywords" content="<?=$siteInfo['site_keyword']?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>template/image/icon_ccdc.ico">
    <link rel="stylesheet" href="<?=base_url()?>template/css/bootstrap-4.3.1/bootstrap.min.css?v=<?=$version?>">
    <link rel="stylesheet" href="<?=base_url()?>template/fontawesome/css/all.min.css?v=<?=$version?>">
    <link rel="stylesheet" href="<?=base_url()?>template/css/style2.min.css?v=<?=$version?>">
    <script src="<?=base_url()?>template/js/jquery/jquery.min.js?v=<?=$version?>"></script>
	<?php $this->load->view('main/analytics');?>
	<style>
		.page_title{color:#fff;}
		@media (max-width: 575.98px) {.f_stat {display:none;}.container{max-width:100%!important;}.page_title{font-size:20px;}}
		@media (min-width: 576px) and (max-width: 767.98px) {.f_stat {display:none;} .container{max-width:100%!important;}.page_title{font-size:22px;}}
		@media (min-width: 768px) and (max-width: 991.98px) { .container{max-width:100%!important;}.page_title{font-size:30px;}}
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
				
                <div class="content" <?=$_pageLink=="download" || $_pageLink=="api"?'style="background-image: url(/template/image/bg-01.svg);"':''?>>
					<div class="main_title">
						<div class="container">
							<div class="row">
							<div class="col-md-12">
								<h3 class="page_title"><i class="fas fa-square mr-3" style="font-size:11px;"></i> <?=$siteInfo['pre_title']?></h3>
							</div>
							</div>
						</div>     
                    </div>
                    <div class="main_detail2" style="min-height: 65vh">
						<?php $this->load->view($view);?>	
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php $this->load->view('main/template_contact');?>

    
    <script src="<?=base_url()?>template/js/popper/popper.min.js?v=<?=$version?>"></script>
    <script src="<?=base_url()?>template/js/bootstrap-4.3.1/bootstrap.min.js?v=<?=$version?>"></script>
    <script src="<?=base_url()?>template/js/main.js?v=<?=$version?>"></script>
</body>

</html>