<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Partner extends CI_Controller {

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
	private $ga_token = 'ya29.a0Ae4lvC3km3xiAFGeF-I5LmAO-2XaXDaI0raOhiljD3JUIKvd7JKjxcXrntha-Xz1LwYS6RrhtOJilwkg_d8qTlqA65eob9LrxMUs3fXY2Vr2oYIG5kgjr7quiLjSLmARWek0v3xjXbUNqvs9Eym7TTr2BFTo-TmEOAiEyQ';
	
	public $siteinfo=array();
	
	public function __construct() {
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
	public function index()
	{
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'Partner';
		}else{
			$this->siteinfo['pre_title'] = 'ผู้สนับสนุน';
		}

		$data = array( 
			"rsStat" 			=> $this->rsStat,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			"_pageLink"			=> 'partner'
		);

		$this->load->view('partner/partner',$data);
	}
	public function index_old()
	{
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'Partner';
		}else{
			$this->siteinfo['pre_title'] = 'ผู้สนับสนุน';
		}

		$data = array( 
			"rsStat" 			=> $this->rsStat,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			"_pageLink"			=> 'partner'
		);

		$this->load->view('partner/partner',$data);
	}

}
