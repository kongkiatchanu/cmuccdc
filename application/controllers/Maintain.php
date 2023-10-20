<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maintain extends CI_Controller {
	
	private $line_token = 'KJS9Oy4cW5blTwFVAcaA5BeJDSIujdP4RHuXNar9mUJ';
	private $line_token_sun = 'pn0LazdF4NrNqmcmTeGZEj9NAOFJunt8bf63Rtpeig8';
	private $line_token_sony = 'z0uHsUmjDWFSlwpDt7MPiNpiQhuJZCkTvGUY2mqxdfG';
	private $line_token_sony2 = 'sIx6OHNFlR9h0UH5kuHKcdQ7PGQiY7rW0p0vLz87buc';
	//private $line_token = 'PYysnrOXgEMexOuKcN9VrRiqi9cAim9FAKknzp3WD7Q';

	private $line_token_sony3 = 'mTix2cKwri1orMElXO5pyT5tUCZCbj9wqnanVeFHTFt';
	private $reCAPTCHA  = '6LfegkgUAAAAADdlRA0kxIwZvqSz3l-vqR5rAZwY';
	
	public $s_lang = 'english';
	public $pmType = 'usAQI';
	public $rsStat;
	public $siteinfo=array();
	
	function __construct() {
        parent::__construct();
		
		$this->load->model('maintain_model');
		 $this->load->library('form_validation');
        $this->load->helper('security');
        /*check session*/
        if($this->uri->segment(2)!="login" && $this->uri->segment(2)!="register" && $this->uri->segment(2)!="cm" && $this->uri->segment(2)!="search" && $this->uri->segment(2)!="profile" && $this->uri->segment(2)!="ckalert" && $this->uri->segment(2)!="sonyalert") {
        	if($this->session->userdata('staff_logged_in')==""){
         		//redirect('maintain/login');
      	  	}
        }
		
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
		$this->rsStat = $this->cache->get('ga');
	}
	
	function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	
	public function ck_model(){
		$station = json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/stations_temp.json'));
		$data = array();
		foreach($station as $item){
			if($item->id <= 6102 && $item->id <=6646){
				array_push($data, $item);
			}
		}
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($data);
	}

	function line_notify($message_data){
		$headers = array('Method: POST', 'Content-type: multipart/form-data', 'Authorization: Bearer '.$this->line_token );
		$line_api="https://notify-api.line.me/api/notify";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $line_api);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $message_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);
	}
	
	function line_notify_sun($message_data){
		$headers = array('Method: POST', 'Content-type: multipart/form-data', 'Authorization: Bearer '.$this->line_token_sun );
		$line_api="https://notify-api.line.me/api/notify";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $line_api);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $message_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);
	}
	
	function line_notify_sony($message_data){
		$headers = array('Method: POST', 'Content-type: multipart/form-data', 'Authorization: Bearer '.$this->line_token_sony );
		$line_api="https://notify-api.line.me/api/notify";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $line_api);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $message_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);
	}
	
	function line_notify_sony2($message_data){
		$headers = array('Method: POST', 'Content-type: multipart/form-data', 'Authorization: Bearer '.$this->line_token_sony2 );
		$line_api="https://notify-api.line.me/api/notify";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $line_api);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $message_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);
	}

	function line_notify_sony3($message_data){
		$headers = array('Method: POST', 'Content-type: multipart/form-data', 'Authorization: Bearer '.$this->line_token_sony3 );
		$line_api="https://notify-api.line.me/api/notify";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $line_api);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $message_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);
	}
	
	private function upload_filesvb($k, $files){
		$config['upload_path'] = './uploads/requests/';
		$config['allowed_types'] = 'png|jpg';
		$config['max_size'] = 1000000;
		$config['encrypt_name'] = TRUE;
		$dir = './uploads/';
		$this->load->library('upload', $config);

		$document_file = array();
		$ar = array();
		
		//foreach ($files['name'][$k] as $key => $file) {
			$_FILES['document_file[]']['name']= $files['name'][$k];
			$_FILES['document_file[]']['type']= $files['type'][$k];
			$_FILES['document_file[]']['tmp_name']= $files['tmp_name'][$k];
			$_FILES['document_file[]']['error']= $files['error'][$k];
			$_FILES['document_file[]']['size']= $files['size'][$k];

			$file_name =$files['name'][$k];
			$fileName =date('YmdHis').md5(rand(100, 200));
			$config['file_name'] = $fileName;

			$this->upload->initialize($config);
		
			if ($this->upload->do_upload('document_file[]')) {
				return $this->upload->data('file_name');
			} else {
				return false;
				exit;
			}
			
		//}
		
		return $ar;
    }
	
	public function sendData(){
		$member = $this->session->userdata('staff_logged_in');
		if($member){
			$ck = $this->maintain_model->ckMemberNontiData($member['username']);
			if($ck){
				$message_data = array(
					'message' => 'ผู้ใช้ '.$member['username'].' ส่งคำขออัพเดทข้อมูลเครื่อง DustBoy คุณสามารถอัพเดทข้อมูลล่าสุดได้ที่แอดมิน CCDC'
				);
				$this->line_notify($message_data);
				redirect('/maintain');
			}else{
				echo '<script>alert("ระบบส่งคำขออัพเดทข้อมูลแล้ว กรุณารอทีมงานแก้ไขข้อมูล");window.location="'.base_url('maintain').'";</script>';
			}
		}
	}
	
	public function maemohalert(){
		$station = json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/stations.json'));
		$ar_list = array(7039,7041,7051, 7052, 7053, 7054, 7055, 7056, 7057, 7058, 7059, 7060, 7061, 7062,7063,7064,7065,7066,7067,7068,7069,7070,7071,7072,7073,7074,7075,7076,7077,7080,7081,7082,7083,7085,7086,7087,7088,7089,7090,7091,7092,7093,7094,7095,7096,7097,7098,7099,7100,7101,7102,7103,7104,7105,7106,7107,7108,7109,7110,7111,7112,7113,7114,7115,7116,7117,7118,7119,7120,7121,7122,7123,7124,7125,7126,7127,7128,7129,7130,7131,7132,7133,7134,7135,7136,7137,7138,7139,7140,7141,7142,7143,7145,7146,7147,7148,7149,7150,7151,7153,7154,7155,7156,7157,7158,7159,7160,7162,7163,7164,7165);
		$data = array();
		$data2 = array();
		foreach($station as $item){
            $id = (int)$item->id;
			if($id > 7000 && $id <= 7044 ){
                if($id!=7039 && $id!=7041){
                    array_push($data,$station);
                }
			}
			if (in_array($item->id, $ar_list)){
				array_push($data2,$station);
			}
		}

		$txt = "รายงานจำนวนจุดออนไลน์";
		$txt .="\n";
		$txt .= "โครงการแม่เมาะ";
		$txt .= "จำนวน (".count($data)."จุด)";
		$txt .="\n";
		$txt .= "โครงการศรีลานนา";
		$txt .= "จำนวน (".count($data2)."จุด)";
		
		$message_data = array(
			'message' => $txt
		);
        echo '<pre>';
        print_r($message_data);
        echo '</pre>';

		$this->line_notify($message_data);
	}
	
	
	
	public function sonyalert(){
		$rsList = $this->maintain_model->getDataSony();
		
		$data = array();
		$c = 0;
		foreach($rsList as $item){
			if($item->log_pm25>150){
				$c++;
				array_push($data, $item); 
			}
		}

		
		if(count($data)>0){
			$txt ='';
			foreach($data as $item){
				$txt .= 'warning!!';
				$txt .="\n";
				$txt .= count($data).' point';
				$txt .="\n";
				$txt .="\n";
				$txt .= 'from :'.dechex($item->nickname);
				$txt .="\n";
				$txt .= 'ID :'.$item->source_id;
				$txt .="\n";
				$txt .= 'Name :'.$item->location_name_en;
				$txt .="\n";
				$txt .= 'PM2.5 :'.$item->log_pm25.' mcg/m3';
				$txt .="\n";
				$txt .= '----------';
				$txt .="\n";
			}
			
			$message_data = array(
				'message' => $txt
			);
			//$this->line_notify($message_data);
			$this->line_notify_sony($message_data);
			$this->line_notify_sony2($message_data);
			$this->line_notify_sony3($message_data);
		}
	
		
		/*
		if(count($data)>0){
			$txt ='';
			foreach($data as $item){
				$txt .='[ID: '.$item->id.', Name: '.$item->dustboy_name.', PM25: '.$item->pm25.']';
				$txt .='------------------------';
			}

			$message = 'พบค่า pm2.5 เกิน 500 (μg/m3) จำนวน ('.count($data).' จุด)  ได้แก่'.$txt;
			$message_data = array(
					'message' => $message
			);
			$this->line_notify_sun($message_data);
		}*/
	}
	
	public function ckalert(){
		$station = json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/stations.json'));
		$data = array();
		foreach($station as $item){
			if($item->pm25>500){
				array_push($data, $item); 
			}
		}
		
		if(count($data)>0){
			$txt ='';
			foreach($data as $item){
				$txt .='[ID: '.$item->id.', Name: '.$item->dustboy_name.', PM25: '.$item->pm25.']';
				$txt .='------------------------';
			}

			$message = 'พบค่า pm2.5 เกิน 500 (μg/m3) จำนวน ('.count($data).' จุด)  ได้แก่'.$txt;
			$message_data = array(
					'message' => $message
			);
			$this->line_notify_sun($message_data);
		}
		
		$rsStatus = $this->maintain_model->getDustBoyStatus();
		
		$json = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/uploads/json/station_alert.json");
		$json_setting = json_decode($json);
		$json_setting = (array)$json_setting->station;
		$data = array();
		foreach($json_setting as $k=>$item){
			if($item==1){
				$data[$k] = $item;
			}
		}
		
		$offline_list = array();
		foreach($rsStatus as $k=>$v){
			if (array_key_exists($v->status_source_id, $data)) {
				if($this->DatediffCount($v->status_date)>0 && $v->status_date!='0000-00-00 00:00:00'){
					array_push($offline_list, $v->status_source_id);
				}
				
			}
		}
		
		$message = 'พบจุดติดตั้งที่ออฟไลน์ของโครงการ CHARM เกิน 1 วัน จำนวน '.count($offline_list).' เครื่อง ได้แก่ '.json_encode($offline_list);
		$message_data = array(
			'message' => $message
		);
		if(count($offline_list)){
			$this->line_notify($message_data);
		}
	}
	
	function DatediffCount($datetime){
		$earlier = new DateTime($datetime);
		$later = new DateTime(date('Y-m-d'));

		$diff = $later->diff($earlier)->format("%a");
		return $diff;
	}
	
	public function sendFixed(){
		$member = $this->session->userdata('staff_logged_in');
		if($member){
			
			$ck = $this->maintain_model->ckMemberFixed($member['username'],$this->uri->segment(3));
			if($ck){
				$message_data = array(
					'message' => 'ผู้ใช้ '.$member['username'].' ไม่สามารถใช้งาน DustBoy ได้ [refid:'.$this->uri->segment(3).']'
				);
				$this->line_notify($message_data);
				redirect('/maintain');
			}else{
				echo '<script>alert("ระบบส่งคำขออัพเดทข้อมูลแล้ว กรุณารอทีมงานแก้ไขข้อมูล");window.location="'.base_url('maintain').'";</script>';
			}
		}
	}
	
	public function updateMaintain(){
		$member = $this->session->userdata('staff_logged_in');
		if($member){
			if($this->input->post()!=null){
				$ar = $this->input->post();

				foreach($ar['engine_name_th'] as $k=>$v){
					$file[$k] = $ar['engine_file'][$k];
					$file2[$k] = $ar['engine_file'][$k];
					if($_FILES['engine_file']['name'][$k]!=null){
					
						$file[$k] = $this->upload_filesvb($k, $_FILES['engine_file']);
					}
					if($_FILES['engine_ct_file']['name'][$k]!=null){
					
						$file2[$k] = $this->upload_filesvb($k, $_FILES['engine_ct_file']);
					}

					$ar_post = array(
						'engine_name_th'		=> $ar['engine_name_th'][$k],
						'engine_name_en'		=> $ar['engine_name_en'][$k],
						'engine_addr'			=> $ar['engine_addr'][$k],
						'engine_lat'			=> $ar['engine_lat'][$k],
						'engine_lnt'			=> $ar['engine_lnt'][$k],
						'engine_url'			=> $ar['engine_url'][$k],
						'engine_ct_name'		=> $ar['engine_ct_name'][$k],
						'engine_ct_tel'			=> $ar['engine_ct_tel'][$k],
						'engine_ct_email'		=> $ar['engine_ct_email'][$k],
						'engine_file'			=> $file[$k],
						'engine_ct_file'		=> $file2[$k],
						'engine_id'				=> [$k][0],
						'engine_username'		=> $member['username'],
					);
					
					
					
					$ar_update = array(
						'engine_id'	=> [$k][0],
						'engine_username'	=>  $member['username'],
						'engine_obj' => json_encode($ar_post)
					);
					$update = $this->maintain_model->updateEngineMember($ar_update);
					
				}
				redirect('/maintain/index');
				
			}
		}else{redirect('/');}
	}
	
	public function search(){
		$rs = $this->maintain_model->getAllEngineLists();
		$data = array();
	
		if( trim($this->input->get('text-search')) ){
			$query = $this->input->get('text-search');
			foreach($rs as $item){

				$a = strpos(' '.$item->source_id, $query);
				$b = strpos(' '.$item->location_id, $query);
				$c = strpos(' '.$item->location_name, $query);
				$d = strpos(' '.$item->location_name_en, $query);

				if(!empty($a) || !empty($b) || !empty($c) || !empty($d)){
					array_push($data, $item);
				}
				
			}
		}
		
		
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'DustBoy Maintain';
		}else{
			$this->siteinfo['pre_title'] = 'อาสา DustBoy';
		}
			
		$rs = array( 
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			"rsStat" 			=> $this->rsStat ,
			"rsEngine"			=> $data,
			'view'				=> 'maintain/search',
			"_pageLink"			=> 'maintain'
		);
		$this->load->view("main/template_main",$rs);
		
		
	
	}
	
	public function tracking(){
		if($this->uri->segment(3)){
			$data = $this->maintain_model->getDustBoyID($this->uri->segment(3));
		}
		
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'DustBoy Maintain';
		}else{
			$this->siteinfo['pre_title'] = 'อาสา DustBoy';
		}
		
		$rs = array( 
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			"rsStat" 			=> $this->rsStat ,
			"rsEngine"			=> $data,
			'view'				=> 'maintain/tracking',
			"_pageLink"			=> 'maintain'
		);
		$this->load->view("main/template_main",$rs);
	}
	
	public function profile(){
		if($this->uri->segment(3)){
			$data = $this->maintain_model->getEngineID($this->uri->segment(3));
		}
		
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'DustBoy Maintain';
		}else{
			$this->siteinfo['pre_title'] = 'อาสา DustBoy';
		}
		
		$rs = array( 
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			"rsStat" 			=> $this->rsStat ,
			"rsEngine"			=> $data,
			'view'				=> 'maintain/profile',
			"_pageLink"			=> 'maintain'
		);
		$this->load->view("main/template_main",$rs);
	}
	
	public function index()
	{
		$member = $this->session->userdata('staff_logged_in');
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'DustBoy Maintain';
		}else{
			$this->siteinfo['pre_title'] = 'อาสา DustBoy';
		}

		$rs = array( 
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			"rsStat" 			=> $this->rsStat ,
			"rsEngine"			=> $this->maintain_model->getEngineLists($member['username']),
			'view'				=> 'maintain/index_new',
			"_pageLink"			=> 'maintain'
		);
		$this->load->view("main/template_main",$rs);
	}
	
	public function login(){
		$this->form_validation->set_rules('username', 'username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'password', 'trim|required|xss_clean|callback_check_database');

		if($this->form_validation->run() == FALSE)
		{
			if($this->s_lang=="english"){
				$this->siteinfo['pre_title'] = 'DustBoy Maintain';
			}else{
				$this->siteinfo['pre_title'] = 'อาสา DustBoy';
			}
		
			$rs = array( 
				"_lang" 			=> $this->s_lang,
				"_pmType" 			=> $this->pmType,
				"siteInfo" 			=> $this->siteinfo,
				"rsStat" 			=> $this->rsStat ,
				'view'				=> 'maintain/login',
				"_pageLink"			=> 'maintain'
			);
			$this->load->view("main/template_main",$rs);	
			
		}else{
			redirect('maintain/index');
		}
	}
	
	public function check_database($password){
		$username = $this->input->post('username');
		$result = $this->maintain_model->login($username, $password);
		if($result)
		{
			$sess_array = array();
			foreach($result as $row)
			{
				$sess_array = array(
					'username' => $row->username,
					'display' => $row->user_display
				);
				$this->session->set_userdata('staff_logged_in', $sess_array);
			}
			return TRUE;
		}else{
			$message='<div class="alert alert-danger"><strong>คำเตือน !</strong> ชื่อผู้ใช้และรหัสผ่านไม่ถูกต้อง</div>';
			$this->form_validation->set_message('check_database', $message);
			return false;
		}
	}
	
	public function register(){
		if($this->input->post()!=null){
			$ar = $this->input->post();
			
			
			if($this->input->post('g-recaptcha-response')!=null)
       		{
				$url = "https://www.google.com/recaptcha/api/siteverify?secret=".$this->reCAPTCHA."&response=".$this->input->post('g-recaptcha-response')."&remoteip=".$_SERVER['REMOTE_ADDR'] ;
				$response=json_decode(file_get_contents($url), true);
       			
				if($response['success'] == false)
       			{
       				$dialog_view = 'dialog_spam';
					$action = array(
						'dialog_view' => 'dialog_spam'
					);
					$this->session->set_userdata('noti_action', $action);
					redirect('maintain/register');
       			}else{
       				unset($ar['g-recaptcha-response']);
       				$dialog_view= 'dialog_success';
					$ar['request_key'] = $this->generateRandomString(100);
					
					if($_FILES['request_file']){

						$config['upload_path'] = './uploads/requests/';
						$config['allowed_types'] = 'pdf|xlsx';
						$config['max_size'] = 1000000;
						$config['encrypt_name'] = TRUE;

						$this->load->library('upload', $config);

						$fileName =date('YmdHis').md5(rand(100, 200));
						//$config['file_name'] = 'vb_'.$fileName;
						$this->upload->initialize($config);	
						if ($this->upload->do_upload('request_file')) {
							$ar['request_file'] = $this->upload->data('file_name');
						}else{
							echo '<script>alert("อนุญาตให้อัพโหลดได้เฉพาะไฟล์นามสกุล .pdf, .xlsx");window.location="'.base_url('maintain/register').'";</script>';
						}
					}
					
					$rs = $this->maintain_model->addRequest($ar);
					if($rs){
						redirect('maintain/cm/'.$ar['request_key']);
					}

					$action = array(
						'dialog_view' => 'dialog_success'
					);
					$this->session->set_userdata('noti_action', $action);
					redirect('maintain/register');
       			}
       		}else{
       			$action = array(
					'dialog_view' => 'dialog_spam'
				);
				$this->session->set_userdata('noti_action', $action);
				redirect('maintain/register');
       		}
			
		}
		
		
			if($this->s_lang=="english"){
				$this->siteinfo['pre_title'] = 'DustBoy Maintain';
			}else{
				$this->siteinfo['pre_title'] = 'ขอความอนุเคราะห์เครื่อง';
			}
			
			$rs = array( 
				"_lang" 			=> $this->s_lang,
				"_pmType" 			=> $this->pmType,
				"siteInfo" 			=> $this->siteinfo,
				"rsStat" 			=> $this->rsStat ,
				'view'				=> 'maintain/register',
				"_pageLink"			=> 'maintain'
			);
			$this->load->view("main/template_main",$rs);	
		
	}
	
	public function cm(){
		$key = $this->uri->segment(3);
		$rss = $this->maintain_model->getRequestDetail($key);
		
		if($this->input->post()!=null){
			$ar = $this->input->post();
			$obj = $this->maintain_model->cmRequest($ar);
			if($obj){
				$message_data = array(
					'message' => 'คำขอติดตั้งเครื่องใหม่ ดูข้อมูลได้ที่ https://www.cmuccdc.org/maintain/cm/'.$ar['request_key']
				);
				$this->line_notify($message_data);
			}
			redirect('maintain/cm/'.$key);
		}
		if($this->s_lang=="english"){
				$this->siteinfo['pre_title'] = 'DustBoy Maintain';
			}else{
				$this->siteinfo['pre_title'] = 'อาสา DustBoy';
			}
			
			$rs = array( 
				"_lang" 			=> $this->s_lang,
				"_pmType" 			=> $this->pmType,
				"siteInfo" 			=> $this->siteinfo,
				"rsStat" 			=> $this->rsStat ,
				"rss" 				=> $rss ,
				'view'				=> 'maintain/register_cm',
				"_pageLink"			=> 'maintain'
			);
			$this->load->view("main/template_main",$rs);	
	}
	
	public function logout() {
		$this->session->unset_userdata('staff_logged_in');
		redirect('maintain');
		exit();
    }
	
	public function region_pwa(){
		$rsRegion = json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/region_pwa.json'), true);
		
		header('Content-Type: application/json');
		echo json_encode($rsRegion);
	}
	
	public function station_json(){
		$rsRegion = json_decode(file_get_contents('https://www.cmuccdc.org/api/ccdc/stations'), true);
		
		header('Content-Type: application/json');
		echo json_encode($rsRegion);
	}
	
	
	public function lists(){
		$data = array();
		//$rsRegion = json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/region_pwa.json'), true);
		//$rsList = json_decode(file_get_contents('https://www.cmuccdc.org/api/ccdc/stations'), true);
		$data = $rsList;
		
		if($this->input->post()!=null){
			$ar= $this->input->post();
			if($ar['maintain_password']=="123457"){
				$sess_array = array(
					'name' => 'staff'
				);
				$this->session->set_userdata('staff_logged_in', $sess_array);
			}else{
				echo '<script>alert("รหัสผ่านไม่ถูกต้อง");window.location="'.base_url('maintain/lists').'";</script>';
			}
			
		}
		
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'DustBoy Maintain';
		}else{
			$this->siteinfo['pre_title'] = 'เครือข่ายอาสา DustBoy';
		}
		
		if($this->session->userdata('staff_logged_in')==""){
			$view = 'maintain/login';
		}else{
			$view = 'maintain/list';
		}
			
		$rs = array( 
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			//"rsRegion" 			=> $rsRegion,
			//"rsList" 			=> $data,
			"rsStat" 			=> $this->rsStat ,
			'view'				=> $view,
			"_pageLink"			=> 'maintain'
		);
		$this->load->view("main/template_main",$rs);	
	}
	
	
	public function coordinator(){
		$rs = array();
		$dbid = $this->input->get('dustboy_id');
		if($dbid!=null){
			$url = 'https://www.cmuccdc.org/api/ccdc/station/'.$dbid;
			$rs = json_decode(file_get_contents($url), true);
		}
		
		if($this->input->post()!=null){
			$ar = $this->input->post();
			
			if($this->input->post('g-recaptcha-response')!=null)
       		{
				$url = "https://www.google.com/recaptcha/api/siteverify?secret=".$this->reCAPTCHA."&response=".$this->input->post('g-recaptcha-response')."&remoteip=".$_SERVER['REMOTE_ADDR'] ;
				$response=json_decode(file_get_contents($url), true);
       			
				if($response['success'] == false)
       			{
       				$dialog_view = 'dialog_spam';
					$action = array(
						'dialog_view' => 'dialog_spam'
					);
					$this->session->set_userdata('noti_action', $action);
					redirect('maintain/register');
       			}else{
       				unset($ar['g-recaptcha-response']);
       				$dialog_view= 'dialog_success';
					
					$url = 'https://www.cmuccdc.org/api/ccdc/station/'.$ar["dustboy_id"];
					$rss = json_decode(file_get_contents($url), true);
					
					$ar_post = array(
						'loc_obj'	=> json_encode($ar),
						'loc_db_id'	=> $ar["dustboy_id"],
						'loc_db_name'	=> $rss['dustboy_name_th'],
						'loc_obj'	=> json_encode($ar),
						'loc_view'	=> 0,
						'loc_type'	=> 'coordinator',
						'createdate'	=> date('Y-m-d H:i:s'),
					);
					
					$rs = $this->maintain_model->addRequestLocation($ar_post);
					if($rs){

						$message_data = array(
							'message' => 'แจ้งแก้ไขข้อมูลผู้ประสานงาน '.$rss['dustboy_name_th']
						);
						$this->line_notify($message_data);
					}

					$action = array(
						'dialog_view' => 'dialog_success'
					);
					$this->session->set_userdata('noti_action', $action);
					redirect('maintain/coordinator');
       			}
       		}else{
       			$action = array(
					'dialog_view' => 'dialog_spam'
				);
				$this->session->set_userdata('noti_action', $action);
				redirect('maintain/coordinator');
       		}
			
		}else{
			if($this->s_lang=="english"){
				$this->siteinfo['pre_title'] = 'DustBoy Maintain';
			}else{
				$this->siteinfo['pre_title'] = 'แก้ไขข้อมูลผู้ประสานงาน';
			}
			
			$rs = array( 
				"_lang" 			=> $this->s_lang,
				"_pmType" 			=> $this->pmType,
				"siteInfo" 			=> $this->siteinfo,
				"rs" 				=> $rs,
				"rsStat" 			=> $this->rsStat ,
				'view'				=> 'maintain/coordinator',
				"_pageLink"			=> 'maintain'
			);
			$this->load->view("main/template_main",$rs);	
		}
	}
	
	public function fixed(){
		$rs = array();
		$dbid = $this->input->get('dustboy_id');
		if($dbid!=null){
			$url = 'https://www.cmuccdc.org/api/ccdc/station/'.$dbid;
			$rs = json_decode(file_get_contents($url), true);
		}
		
		if($this->input->post()!=null){
			$ar = $this->input->post();
			
			if($this->input->post('g-recaptcha-response')!=null)
       		{
				$url = "https://www.google.com/recaptcha/api/siteverify?secret=".$this->reCAPTCHA."&response=".$this->input->post('g-recaptcha-response')."&remoteip=".$_SERVER['REMOTE_ADDR'] ;
				$response=json_decode(file_get_contents($url), true);
       			
				if($response['success'] == false)
       			{
       				$dialog_view = 'dialog_spam';
					$action = array(
						'dialog_view' => 'dialog_spam'
					);
					$this->session->set_userdata('noti_action', $action);
					redirect('maintain/register');
       			}else{
       				unset($ar['g-recaptcha-response']);
       				$dialog_view= 'dialog_success';
					
					
					if($_FILES['fixed_img']){

						$config['upload_path'] = './uploads/requests/';
						$config['allowed_types'] = 'png|jpg|jpeg';
						$config['max_size'] = 1000000;
						$config['encrypt_name'] = TRUE;

						$this->load->library('upload', $config);

						$fileName =date('YmdHis').md5(rand(100, 200));
						//$config['file_name'] = 'vb_'.$fileName;
						$this->upload->initialize($config);	
						if ($this->upload->do_upload('fixed_img')) {
							$ar['fixed_img'] = $this->upload->data('file_name');
						}else{
							echo '<script>alert("อนุญาตให้อัพโหลดได้เฉพาะไฟล์นามสกุล .png, .jpg", .jpeg);window.location="'.base_url('maintain/fixed').'";</script>';
						}
					}
					
					$url = 'https://www.cmuccdc.org/api/ccdc/station/'.$ar["dustboy_id"];
					$rss = json_decode(file_get_contents($url), true);
					
					$ar_post = array(
						'loc_obj'	=> json_encode($ar),
						'loc_db_id'	=> $ar["dustboy_id"],
						'loc_db_name'	=> $rss['dustboy_name_th'],
						'loc_view'	=> 0,
						'loc_type'	=> 'fixed',
						'createdate'	=> date('Y-m-d H:i:s'),
					);
					
					$rs = $this->maintain_model->addRequestLocation($ar_post);
					if($rs){
						
			
						$message_data = array(
							'message' => 'แจ้งเครื่องเสีย '.$rss['dustboy_name_th']
						);
						$this->line_notify($message_data);
					}

					$action = array(
						'dialog_view' => 'dialog_success'
					);
					$this->session->set_userdata('noti_action', $action);
					redirect('maintain/fixed');
       			}
       		}else{
       			$action = array(
					'dialog_view' => 'dialog_spam'
				);
				$this->session->set_userdata('noti_action', $action);
				redirect('maintain/fixed');
       		}
			
		}else{
			if($this->s_lang=="english"){
				$this->siteinfo['pre_title'] = 'DustBoy Maintain';
			}else{
				$this->siteinfo['pre_title'] = 'แจ้งเครื่องเสีย';
			}
			
			$rs = array( 
				"_lang" 			=> $this->s_lang,
				"_pmType" 			=> $this->pmType,
				"siteInfo" 			=> $this->siteinfo,
				"rs" 				=> $rs,
				"rsStat" 			=> $this->rsStat ,
				'view'				=> 'maintain/fixed',
				"_pageLink"			=> 'maintain'
			);
			$this->load->view("main/template_main",$rs);	
		}
	}
	
	function uploadimg($file){
		if($file){
			$img_file='';
			$config['upload_path'] = './uploads/requests/';
			$config['allowed_types'] = 'png|jpg|jpeg';
			$config['max_size'] = 100000000;
			$config['encrypt_name'] = TRUE;

			$this->load->library('upload', $config);

			$fileName =date('YmdHis').md5(rand(100, 200));
			//$config['file_name'] = 'vb_'.$fileName;
			$this->upload->initialize($config);	
			if ($this->upload->do_upload('dustboy_img_1')) {
				$img_file = $this->upload->data('file_name');
			}else{
				echo '<script>alert("อนุญาตให้อัพโหลดได้เฉพาะไฟล์นามสกุล .png, .jpg", .jpeg);window.location="'.base_url('maintain/setup').'";</script>';
			}
			
			return $img_file;
		}
	}
	
	function uploadimg2($file){
		if($file){
			$img_file='';
			$config['upload_path'] = './uploads/requests/';
			$config['allowed_types'] = 'png|jpg|jpeg';
			$config['max_size'] = 100000000;
			$config['encrypt_name'] = TRUE;

			$this->load->library('upload', $config);

			$fileName =date('YmdHis').md5(rand(100, 200));
			//$config['file_name'] = 'vb_'.$fileName;
			$this->upload->initialize($config);	
			if ($this->upload->do_upload('dustboy_img_2')) {
				$img_file = $this->upload->data('file_name');
			}else{
				echo '<script>alert("อนุญาตให้อัพโหลดได้เฉพาะไฟล์นามสกุล .png, .jpg", .jpeg);window.location="'.base_url('maintain/setup').'";</script>';
			}
			
			return $img_file;
		}
	}
	
	function uploadimg3($file){
		if($file){
			$img_file='';
			$config['upload_path'] = './uploads/requests/';
			$config['allowed_types'] = 'png|jpg|jpeg';
			$config['max_size'] = 100000000;
			$config['encrypt_name'] = TRUE;

			$this->load->library('upload', $config);

			$fileName =date('YmdHis').md5(rand(100, 200));
			//$config['file_name'] = 'vb_'.$fileName;
			$this->upload->initialize($config);	
			if ($this->upload->do_upload('dustboy_img_3')) {
				$img_file = $this->upload->data('file_name');
			}else{
				echo '<script>alert("อนุญาตให้อัพโหลดได้เฉพาะไฟล์นามสกุล .png, .jpg", .jpeg);window.location="'.base_url('maintain/setup').'";</script>';
			}
			
			return $img_file;
		}
	}
	
	function uploadimg4($file){
		if($file){
			$img_file='';
			$config['upload_path'] = './uploads/requests/';
			$config['allowed_types'] = 'png|jpg|jpeg';
			$config['max_size'] = 100000000;
			$config['encrypt_name'] = TRUE;

			$this->load->library('upload', $config);

			$fileName =date('YmdHis').md5(rand(100, 200));
			//$config['file_name'] = 'vb_'.$fileName;
			$this->upload->initialize($config);	
			if ($this->upload->do_upload('dustboy_img_4')) {
				$img_file = $this->upload->data('file_name');
			}else{
				echo '<script>alert("อนุญาตให้อัพโหลดได้เฉพาะไฟล์นามสกุล .png, .jpg", .jpeg);window.location="'.base_url('maintain/setup').'";</script>';
			}
			
			return $img_file;
		}
	}
	
	public function setup(){
		
		if($this->input->post()!=null){
			$ar = $this->input->post();
			if($this->input->post('g-recaptcha-response')!=null)
       		{
				$url = "https://www.google.com/recaptcha/api/siteverify?secret=".$this->reCAPTCHA."&response=".$this->input->post('g-recaptcha-response')."&remoteip=".$_SERVER['REMOTE_ADDR'] ;
				$response=json_decode(file_get_contents($url), true);
       			
				if($response['success'] == false)
       			{
       				$dialog_view = 'dialog_spam';
					$action = array(
						'dialog_view' => 'dialog_spam'
					);
					$this->session->set_userdata('noti_action', $action);
					redirect('maintain/register');
       			}else{
       				unset($ar['g-recaptcha-response']);
       				$dialog_view= 'dialog_success';
					
					if($_FILES['dustboy_img_1']!=null){$ar['dustboy_img_1'] = $this->uploadimg($_FILES['dustboy_img_1']);}
					if($_FILES['dustboy_img_2']!=null){$ar['dustboy_img_2'] = $this->uploadimg2($_FILES['dustboy_img_2']);}
					if($_FILES['dustboy_img_3']!=null){$ar['dustboy_img_3'] = $this->uploadimg3($_FILES['dustboy_img_3']);}
					if($_FILES['dustboy_img_4']!=null){$ar['dustboy_img_4'] = $this->uploadimg4($_FILES['dustboy_img_4']);}
					

					$rs = $this->maintain_model->addSetupLists($ar);
					if($rs){
						$message_data = array(
							'message' => 'แจ้งติดตั้งเครื่อง '.$ar['dustboy_name']
						);
						$this->line_notify($message_data);
					}

					$action = array(
						'dialog_view' => 'dialog_success'
					);
					$this->session->set_userdata('noti_action', $action);
					redirect('maintain/fixed');
					
					
				}
			}else{
       			$action = array(
					'dialog_view' => 'dialog_spam'
				);
				$this->session->set_userdata('noti_action', $action);
				redirect('maintain/setup');
       		}
			
			
		}else{
			if($this->s_lang=="english"){
				$this->siteinfo['pre_title'] = 'DustBoy Maintain';
			}else{
				$this->siteinfo['pre_title'] = 'แจ้งติดตั้งเครื่อง';
			}
			
			$rs = array( 
				"_lang" 			=> $this->s_lang,
				"_pmType" 			=> $this->pmType,
				"siteInfo" 			=> $this->siteinfo,
				"rs" 				=> $rs,
				"rsStat" 			=> $this->rsStat ,
				'view'				=> 'maintain/setup',
				"_pageLink"			=> 'maintain'
			);
			$this->load->view("main/template_main",$rs);	
		}
	}
	
	public function renew(){
		if($this->input->post()!=null){
			$ar = $this->input->post();
			if($this->input->post('g-recaptcha-response')!=null)
       		{
				$url = "https://www.google.com/recaptcha/api/siteverify?secret=".$this->reCAPTCHA."&response=".$this->input->post('g-recaptcha-response')."&remoteip=".$_SERVER['REMOTE_ADDR'] ;
				$response=json_decode(file_get_contents($url), true);
       			
				if($response['success'] == false)
       			{
       				$dialog_view = 'dialog_spam';
					$action = array(
						'dialog_view' => 'dialog_spam'
					);
					$this->session->set_userdata('noti_action', $action);
					redirect('maintain/renew');
       			}else{
					
					unset($ar['g-recaptcha-response']);
       				$dialog_view= 'dialog_success';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['max_size'] = 10000000;
					$config['max_width'] = 50000;
					$config['max_height'] = 50000;
					$config['encrypt_name'] = TRUE;
					$config['upload_path'] = './uploads/requests/';
					$this->load->library('upload', $config);
					if (!$this->upload->do_upload('dustboy_img')){
						$error = array('error' => $this->upload->display_errors());
						print_r($error);
					}else{
						$ar['dustboy_img'] = $this->upload->data('file_name');
					}
					$ar['createdate'] = date('Y-m-d H:i:s');
					
					$rs = $this->maintain_model->insertRenew($ar);
					if($rs){
						$message_data = array(
							'message' => 'แจ้งต่ออายุ NB '.$ar['dustboy_name']
						);
						//$this->line_notify($message_data);
					}

					$action = array(
						'dialog_view' => 'dialog_success'
					);
					$this->session->set_userdata('noti_action', $action);
					redirect('maintain/renew');
					
				}
			}else{
       			$action = array(
					'dialog_view' => 'dialog_spam'
				);
				$this->session->set_userdata('noti_action', $action);
				redirect('maintain/setup');
       		}
		}else{
			if($this->s_lang=="english"){
				$this->siteinfo['pre_title'] = 'DustBoy Maintain';
			}else{
				$this->siteinfo['pre_title'] = 'แจ้งต่ออายุ NB';
			}
			
			$rs = array( 
				"_lang" 			=> $this->s_lang,
				"_pmType" 			=> $this->pmType,
				"siteInfo" 			=> $this->siteinfo,
				"rs" 				=> $rs,
				"rsStat" 			=> $this->rsStat ,
				'view'				=> 'maintain/renew',
				"_pageLink"			=> 'maintain'
			);
			$this->load->view("main/template_main",$rs);
		}
	}
	
	public function location(){
		$rs = array();
		$dbid = $this->input->get('dustboy_id');
		if($dbid!=null){
			$url = 'https://www.cmuccdc.org/api/ccdc/station/'.$dbid;
			$rs = json_decode(file_get_contents($url), true);
		}
		
		if($this->input->post()!=null){
			$ar = $this->input->post();
			
			if($this->input->post('g-recaptcha-response')!=null)
       		{
				$url = "https://www.google.com/recaptcha/api/siteverify?secret=".$this->reCAPTCHA."&response=".$this->input->post('g-recaptcha-response')."&remoteip=".$_SERVER['REMOTE_ADDR'] ;
				$response=json_decode(file_get_contents($url), true);
       			
				if($response['success'] == false)
       			{
       				$dialog_view = 'dialog_spam';
					$action = array(
						'dialog_view' => 'dialog_spam'
					);
					$this->session->set_userdata('noti_action', $action);
					redirect('maintain/register');
       			}else{
       				unset($ar['g-recaptcha-response']);
       				$dialog_view= 'dialog_success';
					
					$url = 'https://www.cmuccdc.org/api/ccdc/station/'.$ar["dustboy_id"];
					$rss = json_decode(file_get_contents($url), true);
					
					$ar_post = array(
						'loc_obj'	=> json_encode($ar),
						'loc_db_id'	=> $ar["dustboy_id"],
						'loc_db_name'	=> $rss['dustboy_name_th'],
						'loc_view'	=> 0,
						'loc_type'	=> 'location',
						'createdate'	=> date('Y-m-d H:i:s'),
					);
					
					$rs = $this->maintain_model->addRequestLocation($ar_post);
					if($rs){
						$url = 'https://www.cmuccdc.org/api/ccdc/station/'.$ar["dustboy_id"];
						$rs = json_decode(file_get_contents($url), true);
			
						$message_data = array(
							'message' => 'แจ้งย้ายจุดติดตั้ง '.$rss['dustboy_name_th']
						);
						$this->line_notify($message_data);
					}
					$action = array(
						'dialog_view' => 'dialog_success'
					);
					$this->session->set_userdata('noti_action', $action);
					redirect('maintain/location');
       			}
       		}else{
       			$action = array(
					'dialog_view' => 'dialog_spam'
				);
				$this->session->set_userdata('noti_action', $action);
				redirect('maintain/location');
       		}
			
			
		}else{
			
			if($this->s_lang=="english"){
				$this->siteinfo['pre_title'] = 'DustBoy Maintain';
			}else{
				$this->siteinfo['pre_title'] = 'แจ้งย้ายจุดติดตั้ง';
			}
			
			$rs = array( 
				"_lang" 			=> $this->s_lang,
				"_pmType" 			=> $this->pmType,
				"siteInfo" 			=> $this->siteinfo,
				"rs" 				=> $rs,
				"rsStat" 			=> $this->rsStat ,
				'view'				=> 'maintain/location',
				"_pageLink"			=> 'maintain'
			);
			$this->load->view("main/template_main",$rs);	
		}
	}
	
	
	public function offline_report(){
		$rsAll = $this->maintain_model->getStationList();
		$rsList = json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/stations.json'), true);
		
		$data = array();
		foreach($rsList as $item){
			array_push($data, $item["id"]);
		}
		
		$offline = array();
		foreach($rsAll as $all){
			if (!in_array($all->source_id, $data)){
				array_push($offline, $all);
			}
		}
		
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'DustBoy Maintain';
		}else{
			$this->siteinfo['pre_title'] = 'จุดติดตั้งที่ไม่มีข้อมูล';
		}
			
		$rs = array( 
				"_lang" 			=> $this->s_lang,
				"_pmType" 			=> $this->pmType,
				"siteInfo" 			=> $this->siteinfo,
				"offline" 			=> $offline,
				'view'				=> 'maintain/offline',
				"_pageLink"			=> 'maintain'
		);
		$this->load->view("main/template_main",$rs);	
		
	}
	
	
	public function dustboy_status_export(){
		set_time_limit(0);
		$rsStatus = $this->maintain_model->getDustBoyStatus($this->input->get('province_id'));

		$rs = array( 
				"_lang" 			=> $this->s_lang,
				"_pmType" 			=> $this->pmType,
				"siteInfo" 			=> $this->siteinfo,
				"rsProvince" 		=> $this->maintain_model->getProvinceList(),
				"rsStatus" 			=> $rsStatus,
				'view'				=> 'maintain/status_export',
				"_pageLink"			=> 'maintain'
		);
		$this->load->view("maintain/status_export",$rs);	
	}
	
	public function getSource(){
		if($this->input->get('id')!=null){
			$id = $this->input->get('id');
			$rsList = $this->maintain_model->getsourcebyprovince($id);
			echo json_encode($rsList);
		}
	}
	
	public function getData(){
		if($this->input->get('id')!=null){
			$id = $this->input->get('id');
			$rsList = $this->maintain_model->getDataDaily($id);
			echo json_encode($rsList);
		}
	}
	
	public function getDataAll(){
		if($this->input->get('id')!=null){
			$id = $this->input->get('id');
			$rsList = $this->maintain_model->getDataDailyPV($id);
			echo json_encode($rsList);
		}
	}
	public function pm_standard(){
		$this->siteinfo['pre_title'] = 'PM2.5 > 37.5';
		
		$rs = array( 
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			"rsProvince" 		=> $this->maintain_model->getProvinceList(),
			//"rsStatus" 			=> $rsStatus,
			'view'				=> 'maintain/pm_standard',
			"_pageLink"			=> 'maintain'
		);
		$this->load->view("main/template_main",$rs);	
	}
	
	
	public function dustboy_status(){
		set_time_limit(0);
		if($this->input->post()!=null){
			$ar= $this->input->post();
			if($ar['maintain_password']=="123457"){
				$sess_array = array(
					'name' => 'staff'
				);
				$this->session->set_userdata('staff_logged_in', $sess_array);
			}else{
				echo '<script>alert("รหัสผ่านไม่ถูกต้อง");window.location="'.base_url('maintain/dustboy_status').'";</script>';
			}
		
		}
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'DustBoy Maintain';
		}else{
			$this->siteinfo['pre_title'] = 'สถานะจุดติดตั้ง DustBoy';
		}
		
		$rsStatus = $this->maintain_model->getDustBoyStatus($this->input->get('province_id'));
		if($this->session->userdata('staff_logged_in')==""){
			$view = 'maintain/login';
		}else{
			$view = 'maintain/status';
		}
		$rs = array( 
				"_lang" 			=> $this->s_lang,
				"_pmType" 			=> $this->pmType,
				"siteInfo" 			=> $this->siteinfo,
				"rsProvince" 		=> $this->maintain_model->getProvinceList(),
				"rsStatus" 			=> $rsStatus,
				'view'				=> $view,
				"_pageLink"			=> 'maintain'
		);
		$this->load->view("main/template_main",$rs);	
		
	}
	
	public function map_status(){
		
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'DustBoy Maintain';
		}else{
			$this->siteinfo['pre_title'] = 'แผนที่พร้อมจุดที่ไม่มีสัญญาณ';
		}
		
		$rsStatus = $this->maintain_model->getDustBoyStatus();
			
		$rs = array( 
				"_lang" 			=> $this->s_lang,
				"_pmType" 			=> $this->pmType,
				"siteInfo" 			=> $this->siteinfo,
				"rsProvince" 		=> $this->maintain_model->getProvinceList(),
				"rsStatus" 			=> $rsStatus,
				'view'				=> 'maintain/status_map',
				"_pageLink"			=> 'maintain'
		);
		$this->load->view("main/template_main",$rs);	
		
	}
	
	
	public function updatestatus(){
		$rsAll = $this->maintain_model->getStationList();
		$rsDB = $this->maintain_model->getStationStatus();
		
		$_station = array();
		$_status = array();
		foreach($rsDB as $item){
			array_push($_status, $item->status_source_id);
		}

		foreach($rsAll as $item){
			if (!in_array($item->source_id, $_status)){
				$ar_insert = array(
					'status_source_id'	=> $item->source_id,
					'status_pm25'		=> null,
					'status_update'		=> '0000-00-00 00:00:00',
				);
				$rs = $this->maintain_model->insertDBStatus($ar_insert);
			}
		}
		
		
		$i=0;
		foreach($rsDB as $item){$i++;
			if($i<=30){
				$rs = $this->maintain_model->updateStatusValue($item->status_source_id);
				echo 'update =>'.$item->status_source_id.'<br/>';
			}
		}
		
	}

}
