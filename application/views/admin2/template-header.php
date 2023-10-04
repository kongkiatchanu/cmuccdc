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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$this->config->item('title_name')?></title>
    <link rel="shortcut icon" type="image/png" href="<?=base_url()?>resource/img/logo.png">
    <link rel="stylesheet" href="<?=base_url('assets/admin2/')?>assets/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="<?=base_url('assets/admin2/')?>assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="<?=base_url('assets/admin2/')?>assets/css/DataTables-1.10.21/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="<?=base_url('assets/admin2/')?>assets/css/dropzone5.7/dropzone.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/tagsinput/bootstrap-tagsinput.css"/>
	<!-- <link rel="stylesheet" href="<?=base_url('assets/admin2/')?>assets/css/summernote0.8.18/summernote.min.css"> -->
	<link rel="stylesheet" href="<?=base_url('assets/admin2/')?>assets/summernote-0.8.18/summernote-bs4.min.css">
	<link rel="stylesheet" href="<?=base_url('assets/admin2/')?>assets/css/datetimepicker/tempusdominus-bootstrap-4.min.css"/>
    <link rel="stylesheet" href="<?=base_url('assets/admin2/')?>assets/css/style.min.css?v=<?=date('YmdHis')?>">
	
	 <script src="<?=base_url('assets/admin2/')?>assets/js/jquery/jquery-3.5.1.min.js?v=<?=date('ymdHis')?>"></script>
	<script src="<?=base_url()?>assets/plugins/jquery-migrate-1.2.1.min.js?v=<?=date('ymdHis')?>" type="text/javascript"></script>
</head>

<body>
    <div class="header">
        <nav class="navbar navbar-expand-lg">
            <button class="navbar-toggler" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <div class="search">
                            <svg x="0px" y="0px" viewBox="0 0 24 24" width="20px" height="20px">
                                <g stroke-linecap="square" stroke-linejoin="miter" stroke="currentColor">
                                    <line fill="none" stroke-miterlimit="10" x1="22" y1="22" x2="16.4"
                                        y2="16.4" />
                                    <circle fill="none" stroke="currentColor" stroke-miterlimit="10" cx="10"
                                        cy="10" r="9" />
                                </g>
                            </svg>
                            <div>
                                <input id="search" type="text" placeholder="Search for something...">
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle nav-link-profile" href="#" id="navbarDropdown"
                            role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="img-profile" src="<?=base_url('assets/admin2/')?>assets/image/user.png" alt="" srcset="">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-profile"
                            aria-labelledby="navbarDropdown">
                            <a class="dropdown-item dropdown-item-profile" href="<?=base_url()?>admin2/profile"><i
                                    class="fas fa-user-circle"></i> <span>Profile</span></a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item dropdown-item-profile" href="<?=base_url()?>admin2/logout"><i
                                    class="fas fa-sign-out-alt"></i> <span>Logout</span></a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    