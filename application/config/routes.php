<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
//jaydai
$route['prophecy'] 		= 'report/prophecy';
$route['daily_report'] 		= 'report/daily_report';
$route['hpc1'] 		= 'report2/dataCenter_podd';
$route['hpc1/cleanroom-dashboard'] 		= 'report2/dataCenter_podd/dashboard';
$route['hpc1/info'] 		= 'report2/dataCenter_podd/info';
$route['report_hpc1'] 	= 'report2/report_podd';
$route['guide'] 	= 'report2/guide';
$route['fire'] 	= 'fire/index';
$route['cmu_report'] 		= 'report/cmu_report';
// $route['prophecy/pm25/(:any)']		= "Report/pm25/$1";

$route['default_controller'] = 'main';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['admin']		 = "admin";
$route['admin/(:any)']		 = "admin/$1";
$route['admin/(:any)/(:any)'] = "admin/$1/$2";

$route['2ndDustBoyDay'] 		= 'main/dbday';

$route['pm25'] 		= 'main/pm25';
$route['overview'] 		= 'main/overview';
$route['hourly'] 	= 'main/hourly';
$route['hourly/(:any)']  = 'main/hourly';
$route['daily'] 	= 'main/daily';
$route['daily/(:any)']  = 'main/daily';
$route['snapshot'] 	= 'main/snapshot';
$route['news'] 		= 'main/news';
$route['visitors'] 	= 'main/ga';
$route['map-visualization'] 	= 'main/mapvz';
$route['pm25-map-visualization'] 	= 'main/mapvz2';

$route['2ndDustBoyDay'] = 'main/dustboyday';

$route['download_excel/(:any)'] = 'main/download_excel';
$route['download_excel2/(:any)'] = 'main/download_excel2';
$route['download_json/(:any)']  = 'main/download_json';
$route['query_station_json/(:any)']  = 'main/download_json_query';
$route['download_temp']  = 'main/download_temp';
$route['download_temp/(:any)/(:any)']  = 'main/download_temp/$1/$2';
$route['pmcompare'] = 'main/pmcompare';
$route['calculate'] = 'main/calculate';
$route['aboutus'] 	= 'main/aboutus';
$route['hotspot'] 	= 'main/hotspot_dev';
$route['hotspot_dev'] 	= 'main/hotspot_dev';
// $route['partner'] 	= 'main/partner';
$route['contactus'] = 'main/contactus';
$route['research']  = 'main/research';
$route['economic-damage']  = 'main/economic_damage';
$route['health-damage']    = 'main/health_damage';
$route['download']    	   = 'main/download';
$route['open-api']    	  		 = 'main/api';
$route['air-quality-information']    = 'main/air_quality_information';
$route['sitemap']    = 'main/dustboy_list';
$route['research/(:any)']  = 'main/research';


$route['news/category/effect'] 		= 'main/news';
$route['news/category/activities'] 	= 'main/news';
$route['news/category/message'] 	= 'main/news';
$route['news/category/information'] = 'main/news';
$route['news/category/video'] 		= 'main/video';

$route['newsdetail/(:any)'] 		= 'main/news_detail';
$route['videodetail/(:any)'] 		= 'main/video_detail';

$route['summaryreport']		 = "main/summaryreport";
$route['summaryreport/(:any)']		 = "main/summaryreport/$1";
$route['chart']		 = "chart";
$route['chart/(:any)']		 = "chart/$1";
$route['chart/(:any)/(:any)'] = "chart/$1/$2";


$route['dailyavg'] = "main/dailyavg";
$route['download_dailyavg/(:any)'] = "main/download_dailyavg/$1";
$route['download_dailyavg/(:any)/(:any)'] = "main/download_dailyavg/$1/$2";


$route['station/(:any)']		= "main/station/$1";
$route['station_dev/(:any)']		= "main/station_dev/$1";
$route['digital-signage/(:any)']		= "main/station_ds/$1";
$route['dustboy_profile_dev/(:any)']		= "main/dustboy_profile_dev/$1";

$route['maintain']				= "maintain/index";
$route['maintain/login']		= "maintain/login";
$route['maintain/add']			= "maintain/add";
$route['maintain/view']			= "maintain/view/$1";

$route['(:any)'] 				= 'main/dustboy_profile';
$route['profile/(:any)'] 		= 'report2/dustboy_profile/';
$route['profile/(:any)/(:any)'] = 'report2/dustboy_profile/$1';
$route['excel_download/(:any)']          = 'report2/excel_download/$1';



//haze


