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
	private $ga_token = 'ya29.A0AVA9y1s0tZ4ZNV6UPppBx_y8ghaU_T2ooJh2Kbz7VpZITnzCFaNViyXzY6fXw5bhFwXXfLwEsjrp72p6iRlwUCqkFPrXy3sQKcdEcLN8JC-PYJeL10U2OQCsEZk_bTYZ5p8aelqN-A87Vb54PKHWyrV8DNNR3coYUNnWUtBVEFTQVRBU0ZRRl91NjFWWGI5UmJNRGtNMDRVWDd0b1oxQ2FHQQ0166';
	
	public $siteinfo=array();

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('cookie');
		$this->load->model('main_model');
		//$this->site_cache();
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
		
		
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));	
		$time_limits = 6048000;
		if ( ! $this->mapList = $this->cache->get('ga')){
			$uri = 'https://www.googleapis.com/analytics/v3/data/ga?ids=ga%3A171340988&start-date=2017-01-01&end-date=today&metrics=ga%3Ausers%2Cga%3Asessions&access_token='.$this->ga_token;
			$rs = json_decode(file_get_contents($uri));
			if($rs!=null){
				$this->cache->save('ga',json_decode(file_get_contents($uri)), $time_limits);
			}
		}
		$this->rsStat = $this->cache->get('ga');
		
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
			"vmap_file" 		=> $file,
			"vmap_file_us" 		=> $file_us,
			"_pageLink"			=> 'hotspot'
		);
				
		$this->load->view("main/hotspot",$rs);
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
		redirect('/');
		exit;
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
				$this->siteinfo['pre_title'] = $rsProfile->dustboy_name_th;
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
	
	public function download_excel(){
		$source_id=$this->uri->segment(2);
		if($source_id!=null){
			$rsDustboy=json_decode(file_get_contents($this->API_URI.'downloadexcel/'.$source_id));
			if($rsDustboy){
			
			$title= $rsDustboy[0]->dustboy_id;
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
			$rsValue = json_decode(json_encode($rsDustboy[0]->value), True);
			$objPHPExcel->getActiveSheet()->fromArray($rsValue,NULL,'A2');			
			//$start_row=2;
			
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  // Excel2007 (xlsx) หรือ Excel5 (xls)        
			
			$filename='report-'.date("dmYHi").'.xlsx'; 
			header('Content-Type: application/vnd.ms-excel'); 
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); 
			ob_end_clean();     
			$objWriter->save('php://output'); 
			/*
			$this->excel->setActiveSheetIndex(0);
		
			$filename= $rsDustboy[0]->dustboy_id;
			
			$rsValue = json_decode(json_encode($rsDustboy[0]->value), True);
			$this->excel->getActiveSheet()->setTitle($filename);

			$this->excel->getActiveSheet()->setCellValue('A1', 'pm10');
			$this->excel->getActiveSheet()->setCellValue('B1', 'pm2.5');
			$this->excel->getActiveSheet()->setCellValue('C1', 'temp');
			$this->excel->getActiveSheet()->setCellValue('D1', 'humid');
			$this->excel->getActiveSheet()->setCellValue('E1', 'timestamp');
			
			$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
			$this->excel->getActiveSheet()->fromArray($rsValue,NULL,'A2');
	 
			$filename=$filename.'.xls'; 
	 
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$filename.'"'); 
			header('Cache-Control: max-age=0'); 

			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
			$objWriter->save('php://output');*/
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
