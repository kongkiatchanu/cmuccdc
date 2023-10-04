<?php $users = $this->session->userdata('admin_logged_in');?>
<?php 
	function get_time_ago($time_stamp)
	{
		$time_difference = strtotime('now') - $time_stamp;
		
		if ($time_difference >= 60 * 60 * 24 * 365.242199)
		{
			/*
			 * 60 seconds/minute * 60 minutes/hour * 24 hours/day * 365.242199 days/year
			 * This means that the time difference is 1 year or more
			 */
			return get_time_ago_string($time_stamp, 60 * 60 * 24 * 365.242199, 'year');
		}
		elseif ($time_difference >= 60 * 60 * 24 * 30.4368499)
		{
			/*
			 * 60 seconds/minute * 60 minutes/hour * 24 hours/day * 30.4368499 days/month
			 * This means that the time difference is 1 month or more
			 */
			return get_time_ago_string($time_stamp, 60 * 60 * 24 * 30.4368499, 'month');
		}
		elseif ($time_difference >= 60 * 60 * 24 * 7)
		{
			/*
			 * 60 seconds/minute * 60 minutes/hour * 24 hours/day * 7 days/week
			 * This means that the time difference is 1 week or more
			 */
			return get_time_ago_string($time_stamp, 60 * 60 * 24 * 7, 'week');
		}
		elseif ($time_difference >= 60 * 60 * 24)
		{
			/*
			 * 60 seconds/minute * 60 minutes/hour * 24 hours/day
			 * This means that the time difference is 1 day or more
			 */
			return get_time_ago_string($time_stamp, 60 * 60 * 24, 'day');
		}
		elseif ($time_difference >= 60 * 60)
		{
			/*
			 * 60 seconds/minute * 60 minutes/hour
			 * This means that the time difference is 1 hour or more
			 */
			return get_time_ago_string($time_stamp, 60 * 60, 'hour');
		}
		else
		{
			/*
			 * 60 seconds/minute
			 * This means that the time difference is a matter of minutes
			 */
			return get_time_ago_string($time_stamp, 60, 'min');
		}
	}

	function get_time_ago_string($time_stamp, $divisor, $time_unit)
	{
		$time_difference = strtotime("now") - $time_stamp;
		$time_units      = floor($time_difference / $divisor);

		settype($time_units, 'string');

		if ($time_units === '0')
		{
			return 'just now';
		}
		elseif ($time_units === '1')
		{
			return '1 ' . $time_unit . ' ago';
		}
		else
		{
			/*
			 * More than "1" $time_unit. This is the "plural" message.
			 */
			// TODO: This pluralizes the time unit, which is done by adding "s" at the end; this will not work for i18n!
			return $time_units . ' ' . $time_unit . 's ago';
		}
	}

?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title><?=$this->config->item('title_name')?></title>
<link rel="shortcut icon" type="image/png" href="<?=base_url()?>resource/img/logo.png">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta content="" name="description"/>
<meta content="" name="author"/>
<meta name="MobileOptimized" content="320">
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="<?=base_url()?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="<?=base_url()?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?=base_url()?>assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="<?=base_url()?>assets/css/style-metronic.css" rel="stylesheet" type="text/css"/>
<link href="<?=base_url()?>assets/css/style.css" rel="stylesheet" type="text/css"/>
<link href="<?=base_url()?>assets/css/style-responsive.css" rel="stylesheet" type="text/css"/>
<link href="<?=base_url()?>assets/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="<?=base_url()?>assets/css/themes/light.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="<?=base_url()?>assets/css/custom.css" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/bootstrap-datetimepicker/css/datetimepicker.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/tagsinput/bootstrap-tagsinput.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/select2/select2_metro.css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/data-tables/DT_bootstrap.css"/>

<link href="<?=base_url()?>assets/plugins/summernote/dist/summernote.css" rel="stylesheet"/>
<link href="<?=base_url()?>assets/plugins/dropzone/dropzone.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/plugins/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />

<script src="<?=base_url()?>assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Mitr:200,300,400,500,600,700&amp;subset=thai">
<style>body{font-family: 'Mitr'!important;} .containerz{display:none;margin-top:20px;}</style>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed">
<!-- BEGIN HEADER -->
<div class="header navbar navbar-inverse navbar-fixed-top">
	<!-- BEGIN TOP NAVIGATION BAR -->
	<div class="header-inner">
		<!-- BEGIN LOGO -->
		<a class="navbar-brand" href="<?=base_url()?>admin">
		<img src="<?=base_url()?>assets/img/logo_admin.png" alt="logo" class="img-responsive"/>
		</a>
		<!-- END LOGO -->
		<!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		<img src="<?=base_url()?>assets/img/menu-toggler.png" alt=""/>
		</a>
		<!-- END RESPONSIVE MENU TOGGLER -->
		<!-- BEGIN TOP NAVIGATION MENU -->
		<ul class="nav navbar-nav pull-right">

			<!-- BEGIN INBOX DROPDOWN -->
			<li class="dropdown" id="header_inbox_bar">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
				<i class="fa fa-envelope"></i>
				<?php if($rsInbox[0]->total_row>0){?>
				<span class="badge alertInbox">
					<?=$rsInbox[0]->total_row?>
				</span>
				<?php }?>
				
				</a>
				<ul class="dropdown-menu extended inbox">
					<li>
						<p>
							คุณมี <span class="alertInbox"><?=$rsInbox[0]->total_row?></span> ข้อความใหม่
						</p>
					</li>
					<li>
						<ul id="inboxList" class="dropdown-menu-list scroller" style="height: 250px;">
							<?php foreach($rsInboxAll as $val){?>
							<li>
								<a href="<?=base_url()?>admin/contact/view/<?=$val->idcontact?>">
									<span class="subject">
										<span class="from"><?=$val->contact_name?></span>
										<span class="time"><?=get_time_ago(strtotime($val->contact_datetime))?></span>
									</span>
									<span class="message">
										<?=mb_substr($val->contact_message,0,100,'utf-8')?>
									</span>
								</a>
							</li>
							<?php }?>
						</ul>
					</li>
					<li class="external">
						<a href="<?=base_url()?>admin/contact">See all messages <i class="m-icon-swapright"></i></a>
					</li>
				</ul>
			</li>
			<!-- BEGIN USER LOGIN DROPDOWN -->
			<li class="dropdown user">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
				<img alt="" src="<?=base_url()?>assets/img/avatar1_small.jpg"/>
				<span class="username">
					<?=$users["display"]?>
				</span>
				<i class="fa fa-angle-down"></i>
				</a>
				<ul class="dropdown-menu">
					<li>
						<a href="<?=base_url()?>admin/profile"><i class="fa fa-user"></i> My Profile</a>
					</li>
					<li class="divider">
					</li>
					<li>
						<a href="javascript:;" id="trigger_fullscreen"><i class="fa fa-move"></i> Full Screen</a>
					</li>
					<li>
						<a href="<?=base_url()?>admin/logout"><i class="fa fa-key"></i> Log Out</a>
					</li>
				</ul>
			</li>
			<!-- END USER LOGIN DROPDOWN -->
		</ul>
		<!-- END TOP NAVIGATION MENU -->
	</div>
	<!-- END TOP NAVIGATION BAR -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>