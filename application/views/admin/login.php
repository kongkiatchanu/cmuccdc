<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title><?=$this->config->item('title_name')?> | Login</title>
<link rel="shortcut icon" type="image/png" href="http://www.nk.go.th/resource/img/logo.png">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta content="" name="description"/>
<meta content="" name="author"/>
<meta name="MobileOptimized" content="320">
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="<?=base_url()?>assets/plugins/font-awesome/css/font-awesome.min.css?v=1" rel="stylesheet" type="text/css"/>
<link href="<?=base_url()?>assets/plugins/bootstrap/css/bootstrap.min.css?v=1" rel="stylesheet" type="text/css"/>
<link href="<?=base_url()?>assets/plugins/uniform/css/uniform.default.css?v=1" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/plugins/select2/select2_metro.css?v=1"/>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME STYLES -->
<link href="<?=base_url()?>assets/css/style-metronic.css?v=1" rel="stylesheet" type="text/css"/>
<link href="<?=base_url()?>assets/css/style.css?v=1" rel="stylesheet" type="text/css"/>
<link href="<?=base_url()?>assets/css/style-responsive.css?v=1" rel="stylesheet" type="text/css"/>
<link href="<?=base_url()?>assets/css/plugins.css?v=1" rel="stylesheet" type="text/css"/>
<link href="<?=base_url()?>assets/css/themes/default.css?v=1" rel="stylesheet" type="text/css" id="style_color"/>
<link href="<?=base_url()?>assets/css/pages/login-soft.css?v=1" rel="stylesheet" type="text/css"/>
<link href="<?=base_url()?>assets/css/custom.css?v=1" rel="stylesheet" type="text/css"/>

</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
<!-- BEGIN LOGO -->
<div class="logo">
	<img src="<?=base_url()?>template/image/logo_ccdc.png" alt="" width="300"/>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
	<!-- BEGIN LOGIN FORM -->
	<form class="login-form" action="<?=base_url()?>admin/login/" method="post">
		<h3 class="form-title">กรุณาเข้าสู่ระบบ</h3>
		<?php echo validation_errors(); ?>
		<div class="alert alert-danger display-hide">
			<button class="close" data-close="alert"></button>
			<span>
				 กรุณากรอก ชื่อผู้ใช้ และ รหัสผ่าน
			</span>
		</div>
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label visible-ie8 visible-ie9">ขื่อผู้ใช้</label>
			<div class="input-icon">
				<i class="fa fa-user"></i>
				<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="ขื่อผู้ใช้" name="username"/>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">รหัสผ่าน</label>
			<div class="input-icon">
				<i class="fa fa-lock"></i>
				<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="รหัสผ่าน" name="password"/>
			</div>
		</div>
		<div class="form-actions">
			<label class="checkbox">
			<input type="checkbox" name="remember" value="1"/> จดจำฉันไว้ในระบบ </label>
			<button type="submit" class="btn blue pull-right">
			ยืนยัน <i class="m-icon-swapright m-icon-white"></i>
			</button>
		</div>
	</form>
	<!-- END LOGIN FORM -->
</div>
<!-- END LOGIN -->
<!-- BEGIN COPYRIGHT -->
<div class="copyright">
	 2017 &copy; <?=$this->config->item('title_name')?>
</div>
<!-- END COPYRIGHT -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
	<script src="<?=base_url()?>assets/plugins/respond.min.js?v=1"></script>
	<script src="<?=base_url()?>assets/plugins/excanvas.min.js?v=1"></script> 
	<![endif]-->
<script src="<?=base_url()?>assets/plugins/jquery-1.10.2.min.js?v=1" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/jquery-migrate-1.2.1.min.js?v=1" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/bootstrap/js/bootstrap.min.js?v=1" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js?v=1" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js?v=1" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/jquery.blockui.min.js?v=1" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/jquery.cokie.min.js?v=1" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/uniform/jquery.uniform.min.js?v=1" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?=base_url()?>assets/plugins/jquery-validation/dist/jquery.validate.min.js?v=1" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/backstretch/jquery.backstretch.min.js?v=1" type="text/javascript"></script>
<script type="text/javascript" src="<?=base_url()?>assets/plugins/select2/select2.min.js?v=1"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?=base_url()?>assets/scripts/app.js?v=1" type="text/javascript"></script>
<script src="<?=base_url()?>assets/scripts/login-soft.js?v=1" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
		jQuery(document).ready(function() {     
		  App.init();
		  Login.init();
		});
	</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>