<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	
	public $s_lang = 'english';
	public $pmType = 'usAQI';
	public $rsSnapshot;
	public $rsNews;
	public $rsPartner;
	public $rsVideo;
	public $rsResearch;
	public $rsRegion;
	public $rsRegionReport;
	public $rsAllDustboy;
	public $rsHourly;
	public $rsDaily;
	public $rsStat;
	private $API_URI = 'https://www-old.cmuccdc.org/api2/ccdc/';
	
//	private $ga_token = 'ya29.A0ARrdaM9pZrFSshqu_qM-4_OJ4mJvb1DPeyxmevvgHpC9_5iAkvVgoqlQSo_ML6sgFHIkZ6P_Lu2RncSdI6M8bJYfstpMWc9KgTqNQSfs_cuP75MGwCF4AofHtflOEP60KLYEP-rZtirb55EGfG-PmvzRK24CnhA';
	private $ga_token = 'ya29.a0AX9GBdWSkIbc3XHVH-sBDLd9DTi3uamvgGAT6DhktsqtW26cQvdcMM3QKC53s46xm_IeYdel3cNoZZo5zio1e0pVXwupIjn8Q5gj3im75ZWCAFMvIQiwpfc2xkweHBZv7BSC2jpW4xoFclzY_T7xzhMRtu_c1Q4aCgYKARQSARMSFQHUCsbCYn2ShfD1M9VS5UBxfD3FWg016';
	
	public $siteinfo=array();

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('cookie');
		$this->load->model('main_model');
		$this->site_cache();
	}
	
	
	function site_cache(){
		$lang= $this->session->userdata('lang')==null?'thailand':$this->session->userdata('lang');
		$this->lang->load($lang,$lang);
		$this->s_lang = $lang;
		$this->pmType = $this->session->userdata('pmType')==null?'thAQI':$this->session->userdata('pmType');
		
		$cookie = array(
			'name'	=>'data_index',
			'value'	=>'th-hr',
			'expire' => '3600',
		);
		if(!($this->input->cookie("data_index",true))){
			$this->input->set_cookie($cookie);
		}
		
		$this->siteinfo['site_img'] 		='https://www.cmuccdc.org/uploads/timthumb.php?src=https://www.cmuccdc.org/template/image/slide1.jpg&w=476&h=249';
		$this->siteinfo['site_title']		='CCDC : Climate Change Data Center';
		$this->siteinfo['site_keyword'] 	='pm2.5, pm10, หมวกควัน, cmuccdc, ccdc';
		$this->siteinfo['site_des'] 		='ศูนย์ข้อมูลการเปลี่ยนแปลงสภาพภูมิอากาศ มหาวิทยาลัยเชียงใหม่';
		
		
		// $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));	
		// $time_limits = 6048000;
		// if ( ! $this->mapList = $this->cache->get('ga')){
		// 	$uri = 'https://www.googleapis.com/analytics/v3/data/ga?ids=ga%3A171340988&start-date=2017-01-01&end-date=today&metrics=ga%3Ausers%2Cga%3Asessions&access_token='.$this->ga_token;
		// 	$rs = json_decode(file_get_contents($uri));
		// 	if($rs!=null){
		// 		$this->cache->save('ga',json_decode(file_get_contents($uri)), $time_limits);
		// 	}
		// }
		// $this->rsStat = $this->cache->get('ga');
		
	}
	
	public function switch_lang(){
		if($this->input->post('lang')!=null){
			$this->session->set_userdata('lang',$this->input->post('lang'));
			echo $this->input->post('lang');
		}
	}
	public function switch_type(){
		if($this->input->post('sType')!=null){
			$this->session->set_userdata('pmType',$this->input->post('sType'));
			echo $this->input->post('sType');
		}
	}
	
	public function switch_pm(){
		
	}
	
	public function index()
	{
		$point = 'pm25_all_stn_'.date('YmdH').'-colored-mask.tiff';
		$point_us = 'pm25_all_stn_'.date('YmdH').'-colored-mask-us.tiff';
		$file = 'https://thaq.soc.cmu.ac.th/tmp/stn_obs/pm2.5/'.$point;
		$file_us = 'https://thaq.soc.cmu.ac.th/tmp/stn_obs/pm2.5/'.$point_us;

		//$file = 'https://www.google-analytics.com/collect';
		//$file_us = 'https://www.google-analytics.com/collect';

		$rs = array( 
			"rsStat" 			=> $this->rsStat,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			"vmap_file" 		=> $file,
			"vmap_file_us" 		=> $file_us,
			"_pageLink"			=> 'home'
		);
				
		$this->load->view("main/index_production",$rs);	
	}
	
	public function overview(){
		$rs = array( 
			"rsStat" 			=> $this->rsStat,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			
			"_pageLink"			=> 'home'
		);
				
		$this->load->view("main/index_overview",$rs);	
	}
	
	public function index_dev()
	{
		$point = 'pm25_all_stn_'.date('YmdH').'-colored-mask.tiff';
		$point_us = 'pm25_all_stn_'.date('YmdH').'-colored-mask-us.tiff';
		$file = 'https://thaq.soc.cmu.ac.th/tmp/stn_obs/pm2.5/'.$point;
		$file_us = 'https://thaq.soc.cmu.ac.th/tmp/stn_obs/pm2.5/'.$point_us;
		$rs = array( 
			"rsStat" 			=> $this->rsStat,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			"vmap_file" 		=> $file,
			"vmap_file_us" 		=> $file_us,
			"_pageLink"			=> 'home'
		);
				
		$this->load->view("main/index_min_dev",$rs);	
	}
	
	public function hotspot(){
		$rs = array( 
			"rsStat" 			=> $this->rsStat,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
	//		"vmap_file" 		=> $file,
	//		"vmap_file_us" 		=> $file_us,
			"_pageLink"			=> 'hotspot'
		);
				
		$this->load->view("main/hotspot",$rs);
	}
	
	public function hotspot_dev(){
		$rs = array( 
			"rsStat" 			=> $this->rsStat,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
		//	"vmap_file" 		=> $file,
		//	"vmap_file_us" 		=> $file_us,
			"_pageLink"			=> 'hotspot'
		);
				
		$this->load->view("main/hotspot_dev",$rs);
	}
	
	
	public function pm25(){
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'PM2.5 Nearby';
		}else{
			$this->siteinfo['pre_title'] = 'PM2.5 ตามพิกัด';
		}
	
		$rs = array( 
			"rsStat" 			=> $this->rsStat,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			'view'				=> 'main/pm25_min',
			"_pageLink"			=> 'pm25'
		);
		$this->load->view("main/template_main",$rs);	
	}
	
	public function pm25v2(){
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'PM2.5 Nearby';
		}else{
			$this->siteinfo['pre_title'] = 'PM2.5 ตามพิกัด';
		}
	
		$rs = array( 
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			'view'				=> 'main/pm25_min_dev',
			"_pageLink"			=> 'pm25'
		);
		$this->load->view("main/template_main",$rs);	
	}
	
	public function hourly(){
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));	
		$time_limits = 86400;
		if ( ! $this->mapList = $this->cache->get('region')){
			$this->cache->save('region',json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/region.json')), $time_limits);
		}
		if ( ! $this->mapList = $this->cache->get('hourly')){
			$this->cache->save('hourly',json_decode(file_get_contents($this->API_URI.'ranking/hourly')), 300);
		}
		$this->rsRegion = $this->cache->get('region');
		if($this->uri->segment(2)!=null){
			$this->rsHourly = json_decode(file_get_contents($this->API_URI.'ranking/hourly/'.$this->uri->segment(2)));
			$view= 'main/hourly_pv';
		}else{
			$this->rsHourly = $this->cache->get('hourly');
			$view= 'main/hourly';
		}
		
		
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'Hourly';
		}else{
			$this->siteinfo['pre_title'] = 'ค่าฝุ่นรายชั่วโมง';
		}
	
		$rs = array( 
			"rsStat" 			=> $this->rsStat,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			"rsRegion" 			=> $this->rsRegion,
			"rsHourly" 			=> $this->rsHourly,
			'view'				=> $view,
			"_pageLink"			=> 'hourly'
		);
		$this->load->view("main/template_main",$rs);	
	}
	
	
	public function daily(){
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));	
		$time_limits = 86400;
		if ( ! $this->mapList = $this->cache->get('region')){
			$this->cache->save('region',json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/region.json')), $time_limits);
		}
		if ( ! $this->mapList = $this->cache->get('daily')){
			$this->cache->save('daily',json_decode(file_get_contents($this->API_URI.'ranking/daily')), 300);
		}
		$this->rsRegion = $this->cache->get('region');
		if($this->uri->segment(2)!=null){
			$this->rsDaily = json_decode(file_get_contents($this->API_URI.'ranking/daily/'.$this->uri->segment(2)));
			$view= 'main/daily_pv';
		}else{
			$this->rsDaily = $this->cache->get('daily');
			$view= 'main/daily';
		}
		
		
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'Daily';
		}else{
			$this->siteinfo['pre_title'] = 'ค่าฝุ่นรายวัน';
		}
	
		$rs = array( 
			"rsStat" 			=> $this->rsStat,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			"rsRegion" 			=> $this->rsRegion,
			"rsDaily" 			=> $this->rsDaily,
			'view'				=> $view,
			"_pageLink"			=> 'daily'
		);
		$this->load->view("main/template_main",$rs);		
	}
	
	public function snapshot(){
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'snap shot';
		}else{
			$this->siteinfo['pre_title'] = 'ภาพถ่าย';
		}
	
		$rs = array( 
			"rsStat" 			=> $this->rsStat,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			'view'				=> 'main/snapshot',
			"_pageLink"			=> 'snapshot',
			"rsList"			=> $this->rsSnapshot
		);
		$this->load->view("main/template_main",$rs);	
	}
	
	public function mapvz(){
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'PM2.5 Map Visualization';
		}else{
			$this->siteinfo['pre_title'] = 'PM2.5 Map Visualization';
		}
	
		$rs = array( 
			"rsStat" 			=> $this->rsStat,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			'view'				=> 'main/mapvz',
			"_pageLink"			=> 'PM2.5 Map Visualization',
		);
		$this->load->view("main/template_main",$rs);	
	}
	
	public function mapvz2(){
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'PM2.5 Map Visualization';
		}else{
			$this->siteinfo['pre_title'] = 'PM2.5 Map Visualization';
		}
		$point = date('YmdH');
		$point = 'pm25_all_stn_'.$point.'-colored-mask.tiff';

		$file = 'https://thaq.soc.cmu.ac.th/tmp/stn_obs/pm2.5/'.$point;
		//$file = 'https://www.google-analytics.com/collect';
		$newfile = $_SERVER['DOCUMENT_ROOT'] . '/uploads/tiff/'.$point;
		if(file_exists($newfile)){
			
		}else{
			copy($file, $newfile);
		}

		$rs = array( 
			"rsStat" 			=> $this->rsStat,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			"newfile" 			=> $point,
			'view'				=> 'main/mapvz2',
			"_pageLink"			=> 'PM2.5 Map Visualization',
		);
		$this->load->view("main/template_main",$rs);	
	}
	
	public function news(){
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));	
		$time_limits = 60;
		if ( ! $this->mapList = $this->cache->get('news')){
			$this->cache->save('news',json_decode(file_get_contents($this->API_URI.'news')), $time_limits);
		}
		$this->rsNews = $this->cache->get('news');

		$cat = $this->uri->segment(3);
		if($this->s_lang=="english"){
			$ar_title =array(
				'effect'		=> 'Effect News',
				'activities'	=> 'Activities News',
				'message'		=> 'Message News',
				'information'	=> 'CCDC INFO',
				'video'			=> 'Video'
			);
			if($cat!=null){
				$this->siteinfo['pre_title'] = $ar_title[$cat];
			}else{
				$this->siteinfo['pre_title'] = 'News and Video';
			}
		}else{
			$ar_title =array(
				'effect'		=> 'ผลกระทบหมอกควันในภูมิภาค',
				'activities'	=> 'ข่าวกิจกรรม CCDC',
				'message'		=> 'ข่าวหมอกควัน',
				'information'	=> 'CCDC INFO',
				'video'			=> 'วีดีโอ'
			);
			if($cat!=null){
				$this->siteinfo['pre_title'] = $ar_title[$cat];
			}else{
				$this->siteinfo['pre_title'] = 'ข่าวสารและวีดีโอ';
			}
		}
		
		$rs = array( 
			"rsStat" 			=> $this->rsStat,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			'view'				=> 'main/news',
			"ar_title"			=> $ar_title,
			"_pageLink"			=> 'news',
			"rsNews"			=> $this->rsNews
		);
		$this->load->view("main/template_main",$rs);	
	}
	
	public function video(){
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));	
		$time_limits = 600;
		if ( ! $this->mapList = $this->cache->get('video')){
			$this->cache->save('video',json_decode(file_get_contents($this->API_URI.'video')), $time_limits);
		}
		$this->rsVideo = $this->cache->get('video');

		$cat = $this->uri->segment(3);
		if($this->s_lang=="english"){
			$ar_title =array(
				'effect'		=> 'Effect News',
				'activities'	=> 'Activities News',
				'message'		=> 'Message News',
				'information'	=> 'CCDC INFO',
				'video'			=> 'Video'
			);
			if($cat!=null){
				$this->siteinfo['pre_title'] = $ar_title[$cat];
			}else{
				$this->siteinfo['pre_title'] = 'News and Video';
			}
		}else{
			$ar_title =array(
				'effect'		=> 'ผลกระทบหมอกควันในภูมิภาค',
				'activities'	=> 'ข่าวกิจกรรม CCDC',
				'message'		=> 'ข่าวหมอกควัน',
				'information'	=> 'CCDC INFO',
				'video'			=> 'วีดีโอ'
			);
			if($cat!=null){
				$this->siteinfo['pre_title'] = $ar_title[$cat];
			}else{
				$this->siteinfo['pre_title'] = 'ข่าวสารและวีดีโอ';
			}
		}
		$rs = array( 
			"rsStat" 			=> $this->rsStat,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			'view'				=> 'main/video',
			"ar_title"			=> $ar_title,
			"_pageLink"			=> 'news',
			"rsVideo"			=> $this->rsVideo
		);
		$this->load->view("main/template_main",$rs);	
	}
	
	public function news_detail(){
		
		$id = $this->uri->segment(2);
		if($id!=null){
			$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));	
			$time_limits = 600;
			if ( ! $this->mapList = $this->cache->get('news')){
				$this->cache->save('news',json_decode(file_get_contents($this->API_URI.'news')), $time_limits);
			}
			$this->rsNews = $this->cache->get('news');
			$rs=array();
			foreach($this->rsNews as $item){
				if($id==$item->idcontent){
					$value = (array)$item;
					array_push($rs, $value);
				}
			}
			$this->siteinfo['pre_title'] = $rs[0]['content_title'];
			
			if($this->s_lang=="english"){
				$ar_title =array(
					'effect'		=> 'Effect News',
					'activities'	=> 'Activities News',
					'message'		=> 'Message News',
					'information'	=> 'CCDC INFO',
					'video'			=> 'Video'
				);
			}else{
				$ar_title =array(
					'effect'		=> 'ผลกระทบหมอกควันในภูมิภาค',
					'activities'	=> 'ข่าวกิจกรรม CCDC',
					'message'		=> 'ข่าวหมอกควัน',
					'information'	=> 'CCDC INFO',
					'video'			=> 'วีดีโอ'
				);
			}
		
			$rs = array( 
				"rsStat" 			=> $this->rsStat,
				"_lang" 			=> $this->s_lang,
				"_pmType" 			=> $this->pmType,
				"siteInfo" 			=> $this->siteinfo,
				'view'				=> 'main/newdetail',
				'ar_title'			=> $ar_title,
				"_pageLink"			=> 'news',
				"rs"				=> $rs
			);
			$this->load->view("main/template_main",$rs);
		}else{
			redirect(site_url());
		}
	}
	
	public function video_detail(){
		$id = $this->uri->segment(2);
		if($id!=null){
			$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));	
			$time_limits = 600;
			if ( ! $this->mapList = $this->cache->get('video')){
				$this->cache->save('video',json_decode(file_get_contents($this->API_URI.'video')), $time_limits);
			}
			$this->rsVideo = $this->cache->get('video');
			$rs=array();
			foreach($this->rsVideo as $item){
				if($id==$item->id){
					$value = (array)$item;
					array_push($rs, $value);
				}
			}
			$this->siteinfo['pre_title'] = $rs[0]['yt_name'];
			
			if($this->s_lang=="english"){
				$ar_title =array(
					'effect'		=> 'Effect News',
					'activities'	=> 'Activities News',
					'message'		=> 'Message News',
					'information'	=> 'CCDC INFO',
					'video'			=> 'Video'
				);
			}else{
				$ar_title =array(
					'effect'		=> 'ผลกระทบหมอกควันในภูมิภาค',
					'activities'	=> 'ข่าวกิจกรรม CCDC',
					'message'		=> 'ข่าวหมอกควัน',
					'information'	=> 'CCDC INFO',
					'video'			=> 'วีดีโอ'
				);
			}
		
			$rs = array( 
				"rsStat" 			=> $this->rsStat,
				"_lang" 			=> $this->s_lang,
				"_pmType" 			=> $this->pmType,
				"siteInfo" 			=> $this->siteinfo,
				'view'				=> 'main/videodetail',
				'ar_title'			=> $ar_title,
				"_pageLink"			=> 'news',
				"rs"				=> $rs
			);
			$this->load->view("main/template_main",$rs);
		}else{
			redirect(site_url());
		}
	}
	
	public function pmcompare(){
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'PM2.5 Cigarette Equivalence';
		}else{
			$this->siteinfo['pre_title'] = 'PM2.5 เทียบกับบุหรี่';
		}
	
		$rs = array( 
			"rsStat" 			=> $this->rsStat,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			'view'				=> 'main/pmcompare',
			"_pageLink"			=> 'pmcompare'
		);
		$this->load->view("main/template_main",$rs);	
	}
	
	public function calculate(){
		//redirect('/');
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'AQI Calculator';
		}else{
			$this->siteinfo['pre_title'] = 'คำนวณค่า AQI';
		}
	
		$rs = array( 
			"rsStat" 			=> $this->rsStat,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			'view'				=> 'main/calculate',
			"_pageLink"			=> 'calculate'
		);
		$this->load->view("main/template_main",$rs);
	}
	
	public function aboutus(){
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'WHAT is DustBoy';
		}else{
			$this->siteinfo['pre_title'] = 'DustBoy คืออะไร';
		}
	
		$rs = array( 
			"rsStat" 			=> $this->rsStat,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			'view'				=> 'main/aboutus',
			"_pageLink"			=> 'aboutus'
		);
		$this->load->view("main/template_main",$rs);
	}
	public function partner(){
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));	
		$time_limits = 86400;
		if ( ! $this->mapList = $this->cache->get('partner')){
			$this->cache->save('partner',json_decode(file_get_contents($this->API_URI.'partner')), $time_limits);
		}
		$this->rsPartner = $this->cache->get('partner');
		
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'Partners';
		}else{
			$this->siteinfo['pre_title'] = 'พันธมิตร';
		}
	
		$rs = array( 
			"rsStat" 			=> $this->rsStat,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			'rsPartner'			=> $this->rsPartner,
			'view'				=> 'main/partner',
			"_pageLink"			=> 'partner'
		);
		$this->load->view("main/template_main",$rs);
	}
	
	public function contactus(){
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'Contact Us';
		}else{
			$this->siteinfo['pre_title'] = 'ข้อมูลการติดต่อ';
		}
	
		$rs = array( 
			"rsStat" 			=> $this->rsStat,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			'view'				=> 'main/contactus',
			"_pageLink"			=> 'contactus'
		);
		$this->load->view("main/template_main",$rs);
	}
	
	public function research(){
		
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));	
		$time_limits = 86400;
		if ( ! $this->mapList = $this->cache->get('research')){
			$this->cache->save('research',json_decode(file_get_contents($this->API_URI.'research')), $time_limits);
		}
		$this->rsResearch = $this->cache->get('research');
		
		$id = $this->uri->segment(2);
		if($id!=null){
			$rs=array();
			foreach($this->rsResearch as $item){
				if($id==$item->article_id){
					$value = (array)$item;
					array_push($rs, $value);
				}
			}
			$this->siteinfo['pre_title'] = $rs[0]['article_title'];
			$this->siteinfo['site_keyword'] = $rs[0]['article_keyword'];
			$this->siteinfo['site_des'] = mb_substr(strip_tags($rs[0]['article_abstract']),0,250,'utf-8');
			
			$rs = array( 
				"rsStat" 			=> $this->rsStat,
				"_lang" 			=> $this->s_lang,
				"_pmType" 			=> $this->pmType,
				"siteInfo" 			=> $this->siteinfo,
				"rs" 				=> $rs[0],
				'view'				=> 'main/researchdetail',
				"_pageLink"			=> 'research'
			);
			$this->load->view("main/template_main",$rs);
		
		}else{
			if($this->s_lang=="english"){
				$this->siteinfo['pre_title'] = 'Article / Research';
			}else{
				$this->siteinfo['pre_title'] = 'บทความ / งานวิจัย';
			}
			
			$rs = array( 
				"rsStat" 			=> $this->rsStat,
				"_lang" 			=> $this->s_lang,
				"_pmType" 			=> $this->pmType,
				"siteInfo" 			=> $this->siteinfo,
				"rsResearch" 		=> $this->rsResearch,
				
				'view'				=> 'main/research',
				"_pageLink"			=> 'research'
			);
			$this->load->view("main/template_main",$rs);
		}
	}
	
	public function economic_damage(){
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'Economic Damage';
		}else{
			$this->siteinfo['pre_title'] = 'การคำนวณค่าความเสียหายทางเศรษฐศาสตร์';
		}
			
		$rs = array( 
			"rsStat" 			=> $this->rsStat,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			'view'				=> 'main/edamage',
			"_pageLink"			=> 'edamage'
		);
		$this->load->view("main/template_main",$rs);
	}
	
	public function health_damage(){
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'Health Damage';
		}else{
			$this->siteinfo['pre_title'] = 'การคำนวณค่าความเสียหายต่อสุขภาพอนามัยของมนุษย์';
		}
			
		$rs = array( 
			"rsStat" 			=> $this->rsStat,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			'view'				=> 'main/hdamage',
			"_pageLink"			=> 'hdamage'
		);
		$this->load->view("main/template_main",$rs);
	}
	
	public function air_quality_information(){
		
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));	
		$time_limits = 86400;
		if ( ! $this->mapList = $this->cache->get('region')){
			$this->cache->save('region',json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/region.json')), $time_limits);
		}
		$this->rsRegion = $this->cache->get('region');
		
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'Air Quality Information';
		}else{
			$this->siteinfo['pre_title'] = 'ข้อมูลคุณภาพอากาศ';
		}
			
		$rs = array( 
			"rsStat" 			=> $this->rsStat,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			"rsRegion" 			=> $this->rsRegion,
			'view'				=> 'main/aqi',
			"_pageLink"			=> 'aqi'
		);
		$this->load->view("main/template_main",$rs);
	}
	
	public function api(){
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'DustBoy Open API';
		}else{
			$this->siteinfo['pre_title'] = 'DustBoy Open API';
		}
			
		$rs = array( 
			"rsStat" 			=> $this->rsStat,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			'view'				=> 'main/api',
			"_pageLink"			=> 'api'
		);
		$this->load->view("main/template_main",$rs);
	}
	
	public function download(){
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));	
		$time_limits = 86400;
		if ( ! $this->mapList = $this->cache->get('region')){
			$this->cache->save('region',json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/region.json')), $time_limits);
		}
		$this->rsRegion = $this->cache->get('region');
		
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'Download';
		}else{
			$this->siteinfo['pre_title'] = 'ดาวน์โหลด';
		}
			
		$rs = array( 
			"rsStat" 			=> $this->rsStat,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			"rsRegion" 			=> $this->rsRegion,
			'view'				=> 'main/download',
			"_pageLink"			=> 'download'
		);
		$this->load->view("main/template_main",$rs);
	}
	
	public function dustboy_profile(){
		if($this->uri->segment(1)!=null){
			$rsProfile = json_decode(file_get_contents($this->API_URI.'profile/'.$this->uri->segment(1)));

			if($rsProfile->dustboy_id!=null){
				$rsAir = json_decode(file_get_contents($this->API_URI.'airinfo'));
				$rsForcast = json_decode(file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/forecast/'.$rsProfile->dustboy_id));

				if($this->s_lang=="english"){
					$this->siteinfo['pre_title'] = $rsProfile->dustboy_name_en;
				}else{
					$this->siteinfo['pre_title'] = $rsProfile->dustboy_name_th;
				}
				$rs = array( 
					"rsStat" 			=> $this->rsStat,
					"_lang" 			=> $this->s_lang,
					"_pmType" 			=> $this->pmType,
					"siteInfo" 			=> $this->siteinfo,
					"rsProfile" 		=> $rsProfile,
					"rsAir" 			=> $rsAir,
					"rsForcast" 		=> $rsForcast,
					'view'				=> 'main/profile_dev',
					"_pageLink"			=> 'profile'
				);
				$this->load->view("main/template_main",$rs);
			}else{redirect(site_url());}
		}else{redirect(site_url());}
	}
	
	public function dustboy_profile_dev(){
		if($this->uri->segment(2)!=null){
			$rsProfile = json_decode(file_get_contents($this->API_URI.'profile/'.$this->uri->segment(2)));

			if($rsProfile->dustboy_id!=null){
				$rsAir = json_decode(file_get_contents($this->API_URI.'airinfo'));
				$rsForcast = json_decode(file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/forecast/'.$rsProfile->dustboy_id));
				//print_r($rsForcast);

				$this->siteinfo['pre_title'] = $rsProfile->dustboy_name_th;

				$rs = array( 
					"rsStat" 			=> $this->rsStat,
					"_lang" 			=> $this->s_lang,
					"_pmType" 			=> $this->pmType,
					"siteInfo" 			=> $this->siteinfo,
					"rsProfile" 		=> $rsProfile,
					"rsAir" 			=> $rsAir,
					"rsForcast" 		=> $rsForcast,
					'view'				=> 'main/profile_dev_',
					"_pageLink"			=> 'profile'
				);
				$this->load->view("main/template_main",$rs);
			}else{redirect(site_url());}
		}else{redirect(site_url());}
	}
	
	public function station(){
		if($this->uri->segment(2)!=null){
			$url =  $this->uri->segment(2);
			$url = 'https://www-old.cmuccdc.org/assets/api/haze/pwa/genStations_admin.php?url='.$url;
			
			$rsProfile = json_decode(file_get_contents($url));

			$main = array(
				'dustboy_id'		=> $rsProfile[0]->id,
				'dustboy_uri'		=> $rsProfile[0]->dustboy_uri,
				'dustboy_name_th'	=> $rsProfile[0]->dustboy_name,
				'dustboy_name_en'	=> $rsProfile[0]->dustboy_name_en,
			//	'dustboy_lng'		=> $rsProfile[0]->dustboy_lng,
				'value'				=> $rsProfile[0]
			);

			if($rsProfile[0]->dustboy_id!=null){
				$rsAir = json_decode(file_get_contents($this->API_URI.'airinfo'));

				$this->siteinfo['pre_title'] = $rsProfile[0]->dustboy_name;
				$rs = array( 
					"rsStat" 			=> $this->rsStat,
					"_lang" 			=> $this->s_lang,
					"_pmType" 			=> $this->pmType,
					"siteInfo" 			=> $this->siteinfo,
					"rsProfile" 		=> $main,
					"rsAir" 			=> $rsAir,
					'view'				=> 'main/profile_admin',
					"_pageLink"			=> 'profile'
				);
				$this->load->view("main/template_main",$rs);
			}else{redirect(site_url());}
		}else{redirect(site_url());}
	}
	
	public function station_dev(){
		
		if($this->uri->segment(2)!=null){
			$rsProfile = json_decode(file_get_contents($this->API_URI.'profile/'.$this->uri->segment(2)));
			if($rsProfile->dustboy_id!=null){
				$rsAir = json_decode(file_get_contents($this->API_URI.'airinfo'));
				
				$this->siteinfo['pre_title'] = $rsProfile->dustboy_name_th;
				$rs = array( 
					"rsStat" 			=> $this->rsStat,
					"_lang" 			=> $this->s_lang,
					"_pmType" 			=> $this->pmType,
					"siteInfo" 			=> $this->siteinfo,
					"rsProfile" 		=> $rsProfile,
					"rsAir" 			=> $rsAir,
					'view'				=> 'main/profile_dev',
					"_pageLink"			=> 'profile'
				);
				$this->load->view("main/template_main",$rs);
			}else{redirect(site_url());}
		}else{redirect(site_url());}
	}
	
	public function station_ds(){
		if($this->uri->segment(2)!=null){
			$rsProfile = json_decode(file_get_contents($this->API_URI.'profile/'.$this->uri->segment(2)));
			if($rsProfile->dustboy_id!=null){
				$rsAir = json_decode(file_get_contents($this->API_URI.'airinfo'));
				
				$this->siteinfo['pre_title'] = $rsProfile->dustboy_name_th;
				$rs = array( 
					"rsStat" 			=> $this->rsStat,
					"_lang" 			=> $this->s_lang,
					"_pmType" 			=> $this->pmType,
					"siteInfo" 			=> $this->siteinfo,
					"rsProfile" 		=> $rsProfile,
					"rsAir" 			=> $rsAir,
					'view'				=> 'main/profile_ds',
					"_pageLink"			=> 'profile'
				);
				$this->load->view("main/profile_ds",$rs);
			}else{redirect(site_url());}
		}else{redirect(site_url());}
	}
	
	public function readexcel(){
		$data = array();
		$this->load->library('excel');
		$objPHPExcel = new PHPExcel(); 
		$tmpfname = $_SERVER['DOCUMENT_ROOT']. '/uploads/dump.xlsx';
	    $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
        $excelObj = $excelReader->load($tmpfname);//อ่านข้อมูลจากไฟล์ชื่อ test_excel.xlsx
        $worksheet = $excelObj->getSheet(0);//อ่านข้อมูลจาก sheet แรก
        $lastRow = $worksheet->getHighestRow(); 
		for ($row = 1; $row <= $lastRow; $row++){
			$name =  $worksheet->getCell('A'.$row)->getValue();
			$email =  trim($worksheet->getCell('B'.$row)->getValue());
			$tags =  $worksheet->getCell('C'.$row)->getValue();
			
			if($email!=null){
				if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
					// invalid emailaddress
					$ar_name = explode(" ",$name);
					$fname = '';
					$lname = '';
					if(count($ar_name)==2){
						$fname = $ar_name[0];
						$lname = $ar_name[1];
					}else{
						for($i=0; $i<count($ar_name); $i++){
							$fname .=$ar_name[$i];
						}
						$lname = $ar_name[(count($ar_name)-1)];
					}
					$ar = array(
						'firstname_th'	=> $fname,
						'surname_th'	=> $lname,
						'skill'			=> $tags,
						'email'			=> $email
					);
					array_push($data, $ar);
				}
			}

			
		}
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($data);
		
	}
	
	public function download_excel2(){
		$source_id=$this->uri->segment(2);
		if($source_id!=null){
			$rsDustboy=json_decode(file_get_contents($this->API_URI.'downloadexcel/'.$source_id));
			if($rsDustboy){
				echo '<pre>';
				print_r($rsDustboy);
				echo '</pre>';
			}
		}
	}
	public function download_excel(){
		set_time_limit(0);
		$source_id=$this->uri->segment(2);
		if($source_id!=null){
			$rsDustboy=json_decode(file_get_contents($this->API_URI.'downloadexcel/'.$source_id));
			if($rsDustboy){
			
			
			
			$title= $rsDustboy->dustboy_id;
			$this->load->library('excel');
			$objPHPExcel = new PHPExcel(); 
			$objPHPExcel->getActiveSheet()->setTitle($title);  
			
			$objPHPExcel->setActiveSheetIndex(0);
			
			$objPHPExcel->getDefaultStyle()  
                            ->getAlignment()  
                            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP)  
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
                            //HORIZONTAL_CENTER //VERTICAL_CENTER    
			
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);     
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);             			
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);             			
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);             			
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);             			
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);             			

			if($rsDustboy->version=="wplus"){
				$objPHPExcel->setActiveSheetIndex(0)  
                ->setCellValue('A1', 'PM10')    
                ->setCellValue('B1', 'PM2.5')  
                ->setCellValue('C1', 'Temp')  
                ->setCellValue('D1', 'Humid')
                ->setCellValue('E1', 'Wind Speed')
                ->setCellValue('F1', 'Wind Direction')
                ->setCellValue('G1', 'ATM Pressure')
                ->setCellValue('H1', 'Timestamp'); 
			}else{
				$objPHPExcel->setActiveSheetIndex(0)  
				->setCellValue('A1', 'PM10')    
                ->setCellValue('B1', 'PM2.5')  
                ->setCellValue('C1', 'Temp')  
                ->setCellValue('D1', 'Humid')
                ->setCellValue('E1', 'Timestamp'); 
			}
			$rsValue = json_decode(json_encode($rsDustboy->value), True);
			$objPHPExcel->getActiveSheet()->fromArray($rsValue,NULL,'A2');			
			//$start_row=2;
			
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  // Excel2007 (xlsx) หรือ Excel5 (xls)        
			
			$filename='report-'.date("dmYHi").'.xlsx'; 
			header('Content-Type: application/vnd.ms-excel'); 
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0');     

			$objWriter->save('php://output'); 
			}else{redirect(site_url());}
			
		}else{redirect(site_url());}
	}
	
	public function download_json(){
		$source_id=$this->uri->segment(2);
		if($source_id!=null){
			$rsDustboy=json_decode(file_get_contents($this->API_URI.'downloadexcel/'.$source_id));
			header('Access-Control-Allow-Origin: *');
			header('Access-Control-Allow-Methods: GET, POST');
			header("Access-Control-Allow-Headers: X-Requested-With");
			header('Content-Type: application/json');
			echo json_encode($rsDustboy);
		}else{redirect(site_url());}
	}
	
	public function download_json_query(){
		$source_id=$this->uri->segment(2);
		if($source_id!=null){
			/*SWAP ID*/
			$find 		= array(7051,7052,7053,7054,7055,7056,7057,7058,7059,7060,7061,7062,7063,7064,7065,7066,7067,7068,7069,7070,7071,7072,7073,7074,7075,7076,7077,7078,7079,7080,7081,7082,7083,7084,7085,7086,7087,7088,7089,7090,7091,7092,7093,7094,7095,7096,7097,7098,7099,7100,7101,7102,7103,7104,7105,7106,7107,7108,7109,7110,7111,7112,7113,7114,7115,7116,7117,7118,7119,7120,7121,7122,7123,7124,7125,7126,7127,7128,7129,7130,7131,7132,7133,7134,7135,7136,7137,7138,7139,7140,7141,7142,7143,7144,7145,7146,7147,7148,7149,7150,7151,7152,7153,7154,7155,7156,7157,7158,7159,7160);
			$replace 	= array(5612,5707,5708,5504,10,26,30,31,30,79,5054,18,26,31,84,5517,5518,5520,5522,5525,5527,5528,5529,5530,5533,22,23,33,84,124,2111,5514,5299,5298,5308,5299,38,31,59,81,124,5024,5009,5013,4042,5101,5621,5683,5697,6352,6356,5505,5514,5535,4,14,17,18,24,25,34,35,37,81,5731,5712,5732,5734,4032,4334,4041,4042,4038,4035,4039,6336,6337,6338,6335,6332,5682,5624,5622,5619,5514,6138,6354,4003,5299,5626,4,14,34,5517,5533,5726,6478,6356,22,23,33,84,124,5268,81,85,2100,4010,4003,4043);
			
			$keys = array_keys($find, $source_id);
			$replace_status = 0;
			if (count($keys) > 0) {
				$replace_status = 1;
				$rsValue=json_decode(file_get_contents($this->API_URI.'downloadexcel/'.$replace[$keys[0]]));
			}

			$rsDustboy=json_decode(file_get_contents($this->API_URI.'downloadexcel/'.$source_id));
			if($this->input->get('startDate')!=null && $this->input->get('endDate')!=null){
				if(strlen(trim($this->input->get('startDate')))==10 && strlen(trim($this->input->get('endDate')))==10){
					$startDate = trim($this->input->get('startDate')). '00:00';
					$endDate   = trim($this->input->get('endDate')). '23:59';
					
					$array_value = array();
					$rsLoop = $rsDustboy->value;
					if($replace_status==1){
						$rsLoop = $rsValue->value;	
					}
					foreach($rsLoop as $item){
						if(strtotime($item->log_datetime)>=strtotime($startDate) && strtotime($item->log_datetime)<=strtotime($endDate)){
							array_push($array_value, $item);
						}
						//if(strtotime($item->log_datetime)
					}
					$rsDustboy->value = $array_value;
					
					
					header('Access-Control-Allow-Origin: *');
					header('Access-Control-Allow-Methods: GET, POST');
					header("Access-Control-Allow-Headers: X-Requested-With");
					header('Content-Type: application/json');
					echo json_encode($rsDustboy);
				}else{
					echo "<script>alert('Invalid format!!');window.location.href='".site_url()."';</script>";
				}
			}else{
				echo "<script>alert('Invalid format!!');window.location.href='".site_url()."';</script>";
			}
		}else{redirect(site_url());}
	}
	
	public function download_temp(){
		$source_id=$this->uri->segment(2);
		$type=$this->uri->segment(3);
		if($source_id!=null){
			if($type=="json"){
				$rsDustboy=json_decode(file_get_contents($this->API_URI.'downloadexcel2/'.$source_id));
				header('Access-Control-Allow-Origin: *');
				header('Access-Control-Allow-Methods: GET, POST');
				header("Access-Control-Allow-Headers: X-Requested-With");
				header('Content-Type: application/json');
				echo json_encode($rsDustboy);
			}else if($type=="excel"){
				$rsDustboy=json_decode(file_get_contents($this->API_URI.'downloadexcel2/'.$source_id));
				
				$title= $rsDustboy->dustboy_id;
				$this->load->library('excel');
				$objPHPExcel = new PHPExcel(); 
				$objPHPExcel->getActiveSheet()->setTitle($title);  
				
				$objPHPExcel->setActiveSheetIndex(0);
				
				$objPHPExcel->getDefaultStyle()  
								->getAlignment()  
								->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP)  
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
								//HORIZONTAL_CENTER //VERTICAL_CENTER    
				
				$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);     
				$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);             			
				$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);             			
				$objPHPExcel->setActiveSheetIndex(0)  
					->setCellValue('A1', 'pm10')    
					->setCellValue('B1', 'pm2.5')  
					->setCellValue('C1', 'temp')  
					->setCellValue('D1', 'humid')	
					->setCellValue('E1', 'timestamp');  
				$rsValue = json_decode(json_encode($rsDustboy->value), True);
				$objPHPExcel->getActiveSheet()->fromArray($rsValue,NULL,'A2');			
				//$start_row=2;
				
				
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  // Excel2007 (xlsx) หรือ Excel5 (xls)        
				
				$filename='report-'.date("dmYHi").'.xlsx'; 
				header('Content-Type: application/vnd.ms-excel'); 
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); 
				ob_end_clean();     
				$objWriter->save('php://output'); 
			}
		}else{
			
			$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));	
			$time_limits = 86400;
			if ( ! $this->mapList = $this->cache->get('region')){
				$this->cache->save('region',json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/region.json')), $time_limits);
			}
			$this->rsRegion = $this->cache->get('region');
			
			$this->siteinfo['pre_title'] = 'Download';
				
			$rs = array( 
				"rsStat" 			=> $this->rsStat,
				"_lang" 			=> $this->s_lang,
				"_pmType" 			=> $this->pmType,
				"siteInfo" 			=> $this->siteinfo,
				"rsRegion" 			=> $this->rsRegion,
				'view'				=> 'main/downloadtemp',
				"_pageLink"			=> 'download'
			);
			$this->load->view("main/template_main",$rs);
		}
	}
	
	public function ga(){
		
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'CCDC Visitors';
		}else{
			$this->siteinfo['pre_title'] = 'สถิติการเข้าใช้งาน';
		}
			
		$rs = array( 
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			"rsStat" 			=> $this->rsStat,
			'view'				=> 'main/stat',
			"_pageLink"			=> 'stat'
		);
		$this->load->view("main/template_main",$rs);
	}
	
	public function dustboy_list(){
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));	
		$time_limits = 86400;
		if ( ! $this->mapList = $this->cache->get('region')){
			$this->cache->save('region',json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/region.json')), $time_limits);
		}	
		//if ( ! $this->mapList = $this->cache->get('all')){
		//	$this->cache->save('all',json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/allstations.json')), $time_limits);
		//}
		
		$this->rsRegion = $this->cache->get('region');
		//$this->rsAllDustboy = $this->cache->get('all');
		
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'Dustboy sitemap';
		}else{
			$this->siteinfo['pre_title'] = 'จุดติดตั้ง "DustBoy"';
		}
			
		$rs = array( 
			"rsStat" 			=> $this->rsStat,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			"rsRegion" 			=> $this->rsRegion,
			'view'				=> 'main/sitemap',
			"_pageLink"			=> 'sitemap'
		);
		$this->load->view("main/template_main",$rs);
	}
	
	public function dailyavg(){
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));	
		$time_limits = 600;
		if ( ! $this->mapList = $this->cache->get('region_report')){
			$this->cache->save('region_report',json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/region_report.json')), $time_limits);
		}	
		//if ( ! $this->mapList = $this->cache->get('all')){
		//	$this->cache->save('all',json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/allstations.json')), $time_limits);
		//}
		
		$this->rsRegionReport = $this->cache->get('region_report');
		
		//$this->rsAllDustboy = $this->cache->get('all');
		
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'รายงานค่าฝุ่น PM2.5 เฉลี่ยรายวัน  (ไมโครกรัมต่อลูกบาศก์เมตร)';
		}else{
			$this->siteinfo['pre_title'] = 'รายงานค่าฝุ่น PM2.5 เฉลี่ยรายวัน  (ไมโครกรัมต่อลูกบาศก์เมตร)';
		}
			
		$rs = array( 
			"rsStat" 			=> $this->rsStat,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			"rsRegion" 			=> $this->rsRegionReport,
			'view'				=> 'main/daily_avg',
			"_pageLink"			=> 'dailyavg'
		);
		$this->load->view("main/template_main",$rs);
	}
	
	public function download_dailyavg(){
		$zones_id=$this->uri->segment(2);
		$province_id=$this->uri->segment(3);
		if($zones_id!=null && $province_id!=null){
			$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));	
			$time_limits = 600;
			if ( ! $this->mapList = $this->cache->get('region_report')){
				$this->cache->save('region_report',json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/region_report.json')), $time_limits);
			}	
			$this->rsRegionReport = $this->cache->get('region_report');
			
			$rs = array( 
				"zones_id"			=> $zones_id,
				"province_id"		=> $province_id,
				"rsRegion" 			=> $this->rsRegionReport,
			);
			$this->load->view("main/daily_avg_download",$rs);
		}
		
		if($zones_id!=null && $province_id==null){
			$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));	
			$time_limits = 600;
			if ( ! $this->mapList = $this->cache->get('region_report')){
				$this->cache->save('region_report',json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/region_report.json')), $time_limits);
			}	
			$this->rsRegionReport = $this->cache->get('region_report');
			
			$rs = array( 
				"zones_id"			=> $zones_id,
				"province_id"		=> $province_id,
				"rsRegion" 			=> $this->rsRegionReport,
			);
			$this->load->view("main/daily_avg_download_zones",$rs);
		}
	}
	
	public function summaryreport(){
		$id = $this->uri->segment(2);
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));	
		$time_limits = 86400;
		if ( ! $this->mapList = $this->cache->get('region')){
			$this->cache->save('region',json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/region.json')), $time_limits);
		}
		$this->rsRegion = $this->cache->get('region');
		
		$url ='https://www-old.cmuccdc.org/assets/api/haze/pwa/getSummary.php?id='.$id;
		$jsonData = json_decode(file_get_contents($url));
		$this->siteinfo['pre_title'] = 'PM2.5 AQI';
		$this->siteinfo['pre_title'] .= $jsonData[0]->location_name!=null?': '.$jsonData[0]->location_name:'';
			
		$rs = array( 
			"id"=> $id,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			"jsonData" 			=> $jsonData,
			"rsRegion" 			=> $this->rsRegion,
			'view'				=> 'main/summaryreport',
			"_pageLink"			=> 'summaryreport'
		);
		$this->load->view("main/template_main",$rs);
		
	}
	
	public function pm25mylocation(){
		$id = $this->uri->segment(2);
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));	
		$time_limits = 86400;
		if ( ! $this->mapList = $this->cache->get('region')){
			$this->cache->save('region',json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/region.json')), $time_limits);
		}
		$this->rsRegion = $this->cache->get('region');
		
		$this->siteinfo['pre_title'] = 'PM2.5 By Location';		
		$rs = array( 
			"id"=> $id,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,

			"rsRegion" 			=> $this->rsRegion,
			'view'				=> 'main/pm25mylocation',
			"_pageLink"			=> 'summaryreport2'
		);
		$this->load->view("main/template_main",$rs);
		
	}
	
	public function track(){
		/*
		*	0	=> รอติดตั้ง
		*	1	=> ส่งซ่อม
		*	2	=> ติดตั้งแล้ว
		*/
		
		$id = trim(str_replace("%20"," ",$this->uri->segment(3)));
		
		if($id!=null){
			$html = '';
			$rs = $this->main_model->getStatusDB($id);
			if($rs){
				echo json_encode($rs);
			}
		}
	}

	public function disease_report(){
		$arValue = array();
		for($i=1; $i<=12; $i++){
			$type 	= 'pm_dx_day';
			$month 	= $i;
			$year 	= '2021';
			$param 	= '?service_type=pm_dx_day&month='.$month.'&year='.$year;
			$filename = $type.'_'.$year.'_'.$month.'.json';
			
			$uri 	= 'https://www.chiangmaihealth.go.th/cmpho_web/api/index.php'.$param;	
			
			echo $uri;
			
			if (file_exists('/home/dev2/public_html/uploads/disease/'.$filename)) {
				$rs=json_decode(file_get_contents('/home/dev2/public_html/uploads/disease/'.$filename));
			}else{
				
				$rs=json_decode(file_get_contents($uri));
				if($rs){
					$formattedData = json_encode($rs);
					$handle = fopen('/home/dev2/public_html/uploads/disease/'.$filename,'w+');
					fwrite($handle,$formattedData);
					fclose($handle);
				}
			}
			

			foreach($rs as $item){
				
				foreach(getHospital() as $k=>$v){
					if($k==$item->HCODE){
						echo '<pre>';
						print_r($item);
						echo '</pre>';
						exit;
						$arValue[$k][$year][$month]=$item->total;
					}
				}
				
			}
			
		}
		echo '<pre>';
		print_r($arValue);
		echo '</pre>';
		exit;
		$this->siteinfo['pre_title'] = 'รายงานผู้ป่วย';		
		$rss = array( 
			"id"=> $id,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,

			'rsStore'				=> $store,
			'view'				=> 'main/disease',
			"_pageLink"			=> 'disease'
		);
		$this->load->view("main/template_main",$rss);
		
	}

}
