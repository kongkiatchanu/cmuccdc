<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chart extends CI_Controller {
	
	private $API_URI = 'https://www-old.cmuccdc.org/api2/ccdc/';
	
	public $rsHAVG;
	public $rsDAVH;

	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		header('Content-Type: application/json');
		$ar = array(
			'functions'	=> 'chart',
			'messages'	=> 'chart controller',
			'status'	=> 200
		);
		
		echo json_encode($ar);
	}
	
	/*
	public function havg(){
		$source_id = $this->input->get('dustboy_id');
		$type = $this->input->get('type');
		$key = $this->input->get('key');
		
		if($key==md5('signoutz'.date('ymdh'))){
			$profiles = json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/allstations.json'));
			foreach($profiles as $profile){
				if($source_id==$profile->dustboy_id){
					$url = $this->API_URI.'havg/'.$source_id.'/'.$type.'/'.$profile->dustboy_version;
					$rs = file_get_contents($url);
					echo $rs;	
				}
			}
		}
	}*/
	
	public function davg(){
		$source_id = $this->input->get('dustboy_id');
		$key = $this->input->get('key');
		$ch = $this->input->get('ch');
		if($key==md5('signoutz'.date('ymdh'))){
			$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));	
			$time_limits = 600;
			if ( ! $this->rsDAVG = $this->cache->get('chart_davg_'.$source_id)){
				$this->cache->save('chart_davg_'.$source_id,json_decode(file_get_contents($this->API_URI.'dhavg/'.$source_id)), $time_limits);
			}
			
			$this->rsDAVG = $this->cache->get('chart_davg_'.$source_id);

			$rs = array( 
				"rsDAVG" => $this->rsDAVG,
				"ch" => $ch
			);
			$this->load->view("chart/avg_days",$rs);	
		}
	}
	
	public function davgus(){
		$source_id = $this->input->get('dustboy_id');
		$key = $this->input->get('key');
		$ch = $this->input->get('ch');
		if($key==md5('signoutz'.date('ymdh'))){
			$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));	
			$time_limits = 600;
			if ( ! $this->rsDAVG = $this->cache->get('chart_davg_'.$source_id)){
				$this->cache->save('chart_davg_'.$source_id,json_decode(file_get_contents($this->API_URI.'dhavg/'.$source_id)), $time_limits);
			}
			
			$this->rsDAVG = $this->cache->get('chart_davg_'.$source_id);

			$rs = array( 
				"rsDAVG" => $this->rsDAVG,
				"ch" => $ch
			);
			$this->load->view("chart/avg_days_us",$rs);	
		}
	}
	
}
