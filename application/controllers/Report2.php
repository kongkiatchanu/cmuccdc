<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report2 extends CI_Controller {
	
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
		$this->load->library('PDF2');
		$this->load->library('MergePdf');
		$this->load->helper('jaydai_helper');
		$this->load->model('report_model');
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
	public function dustboy_profile(){
		// ini_set('display_errors', 1);
		// ini_set('display_startup_errors', 1);
		// error_reporting(E_ALL);
		if($this->uri->segment(3)=='en'){
			$this->session->set_userdata('lang','english');
		}else{
			$this->session->set_userdata('lang','thailand');
		}
		if($this->uri->segment(2)!=null){
			$rsProfile = json_decode(file_get_contents($this->API_URI.'profile/'.$this->uri->segment(2)));

			if($rsProfile->dustboy_id!=null){
				if($this->uri->segment(3)=='en'){
					$rsAir = json_decode(file_get_contents('https://www.cmuccdc.org/assets/prophecy/assets/js/airinfo_thaqi_en.json'));
				}else{
					$rsAir = json_decode(file_get_contents($this->API_URI.'airinfo'));
				}
				$rsForcast = json_decode(file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/forecast/'.$rsProfile->dustboy_id));
				if($this->uri->segment(3)=='en'){
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
					'view'				=> 'prophecy/profile_dev',
					"_pageLink"			=> 'profile'
				);
				$this->load->view("main/template_main",$rs);
			}else{redirect(site_url());}
		}else{redirect(site_url());}
	}
	public function excel_download(){
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		$source_id=$this->uri->segment(2);
		if($source_id!=null){
			$rsDustboy=json_decode(file_get_contents('https://cmuccdc.org/api/ccdc_2/downloadexcel/'.$source_id));
			// echo '<pre>';
			// print_r($rsDustboy);
			// echo '</pre>';
			if($rsDustboy){
			
				$title = $rsDustboy->dustboy_id;
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
				$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue('A1', 'Voltage (V)')
								->setCellValue('B1', 'Current (A)')
								->setCellValue('C1', 'Power (W)')
								->setCellValue('D1', 'Energy (kWh)')
								->setCellValue('E1', 'Frequency (Hz)')
								->setCellValue('F1', 'Timestamp');  
				$rsValue = json_decode(json_encode($rsDustboy->value), True);
				$objPHPExcel->getActiveSheet()->fromArray($rsValue,NULL,'A2');			
				// $start_row=2;
				
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  // Excel2007 (xlsx) หรือ Excel5 (xls)        
				
				$filename='report-'.date("dmYHi").'.xlsx'; 
				header('Content-Type: application/vnd.ms-excel'); 
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); 
				ob_end_clean();     
				$objWriter->save('php://output'); 
			}else{
				redirect(site_url());
			}
		}else{
			redirect(site_url());
		}
	}
	public function dataCenter_podd()
	{
		$page = $this->uri->segment(2);
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'Data center For Health area 1 (HPC1)';
		}else{
			$this->siteinfo['pre_title'] = 'ศูนย์ข้อมูลฝุ่นควัน เขตสุขภาพที่ 1 (HPC1)';
		}

		$data = array( 
			"rsStat" 			=> $this->rsStat,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
		);
		if($page=='cleanroom-dashboard') $data["_pageLink"] = 'hpc1_home';
		else if($page=='info') $data["_pageLink"] = 'hpc1_info';
		else $data["_pageLink"] = 'dataCenter_podd';

		$this->load->view('prophecy/'.$data["_pageLink"],$data);
	}
	public function report_podd()
	{
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'Report for PODD';
		}else{
			$this->siteinfo['pre_title'] = 'สถานการณ์ฝุ่นละอองขนาดเล็ก PM2.5 และการคาดการณ์ล่วงหน้า (PODD)';
		}
		
		$data = array( 
			"rsStat" 			=> $this->rsStat,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			"_pageLink"			=> 'report_podd'
		);
		
		$data['province'] = $this->db->query("SELECT province_id,province_name,province_healthzones_id FROM `z_healthzone` WHERE is_show = 1 AND province_healthzones_id != '' ORDER BY province_healthzones_id ASC")->result();

		$this->load->view('prophecy/report_podd',$data);
	}
	public function guide()
	{
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'Guide for CMUCCDC';
		}else{
			$this->siteinfo['pre_title'] = 'คู่มือการติดตั้ง ใช้งาน และบำรุงรักษาเครื่อง Dustboy';
		}
		
		$data = array( 
			"rsStat" 			=> $this->rsStat,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			"_pageLink"			=> 'guide'
		);
		
		$this->load->view('prophecy/guide',$data);
	}
	public function pdf_pm25_2021_2p()
	{
		$data['chk'] = 0;
		$data['area'] = $this->uri->segment(3);
		$time = $this->uri->segment(4);
		$data['data'] = @json_decode(file_get_contents('https://www.cmuccdc.org/api/ccdc_2/healthzone_podd/'.$data['area'])); //.'?v='.date('YmdHis')
		$this->load->view('file_pdf/pdf_text_podd2',$data);
	}
	public function pdf_pm25_2021_3p()
	{
		$data['chk'] = 0;
		$data['area'] = $this->uri->segment(3);
		$time = $this->uri->segment(4);
		$data['data'] = @json_decode(file_get_contents('https://www.cmuccdc.org/api/ccdc_2/healthzone_podd/'.$data['area'])); //.'?v='.date('YmdHis')
		$this->load->view('file_pdf/pdf_text_podd2_test',$data);
	}
	public function pdf_pm25_2021_provinces()
	{
		$data['provinces'] = $this->uri->segment(3);
		$time = $this->uri->segment(4);
		$data['data'] = @json_decode(file_get_contents('https://www.cmuccdc.org/api/ccdc_2/provinces_podd/'.$data['provinces'])); //.'?v='.date('YmdHis')
		$data['chk'] = $this->db->query("SELECT province_name FROM z_healthzone WHERE province_id = ".$data['provinces'])->result();
		$this->load->view('file_pdf/pdf_text_podd2',$data);
	}
	public function pdf_2021()
	{
		set_time_limit(0);
		$data['area'] = $this->uri->segment(3);
        $data['provinces'] = $this->uri->segment(4);
		$pdf = new PDF2(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('CMUCCDC');
		$pdf->SetTitle('รายงานค่ามลพิษทางอากาศ ฝุ่นละอองขนาดเล็ก (PM2.5)');
		$pdf->SetSubject('ReportPM2.5');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetMargins(15, 30, 15);
		$pdf->SetAutoPageBreak(TRUE, 71);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$pdf->SetFont('thsarabunnew', '', 14, '', true);
		$pdf->AddPage();
		if($data['area']==1)		$pdf->Image(base_url('uploads/reportpm25/report1.png?v='.date('YmdHis')), 15, 39, 180, 180, 'PNG', '', '', false, 300, '', false, false, 0, true, false, false);
		else if($data['area']==2)	$pdf->Image(base_url('uploads/reportpm25/report1.png?v='.date('YmdHis')), 15, 39, 180, 180, 'PNG', '', '', false, 300, '', false, false, 0, true, false, false);
		else if($data['area']==3)	$pdf->Image(base_url('uploads/reportpm25/report3.png?v='.date('YmdHis')), 15, 39, 180, 180, 'PNG', '', '', false, 300, '', false, false, 0, true, false, false);
		else if($data['area']==4)	$pdf->Image(base_url('uploads/reportpm25/report4.png?v='.date('YmdHis')), 15, 39, 180, 180, 'PNG', '', '', false, 300, '', false, false, 0, true, false, false);
		else if($data['area']==5)	$pdf->Image(base_url('uploads/reportpm25/report5.png?v='.date('YmdHis')), 15, 39, 180, 180, 'PNG', '', '', false, 300, '', false, false, 0, true, false, false);
		else if($data['area']==6)	$pdf->Image(base_url('uploads/reportpm25/report6.png?v='.date('YmdHis')), 15, 39, 180, 180, 'PNG', '', '', false, 300, '', false, false, 0, true, false, false);
		else if($data['area']==7)	$pdf->Image(base_url('uploads/reportpm25/report7.png?v='.date('YmdHis')), 15, 39, 180, 180, 'PNG', '', '', false, 300, '', false, false, 0, true, false, false);
		else if($data['area']==8)	$pdf->Image(base_url('uploads/reportpm25/report8.png?v='.date('YmdHis')), 15, 39, 180, 180, 'PNG', '', '', false, 300, '', false, false, 0, true, false, false);
		else if($data['area']==9)	$pdf->Image(base_url('uploads/reportpm25/report9.png?v='.date('YmdHis')), 15, 39, 180, 180, 'PNG', '', '', false, 300, '', false, false, 0, true, false, false);
		else if($data['area']==10)	$pdf->Image(base_url('uploads/reportpm25/report10.png?v='.date('YmdHis')), 15, 39, 180, 180, 'PNG', '', '', false, 300, '', false, false, 0, true, false, false);
		else if($data['area']==11)	$pdf->Image(base_url('uploads/reportpm25/report11.png?v='.date('YmdHis')), 15, 39, 180, 180, 'PNG', '', '', false, 300, '', false, false, 0, true, false, false);
		else if($data['area']==12)	$pdf->Image(base_url('uploads/reportpm25/report12.png?v='.date('YmdHis')), 15, 39, 180, 180, 'PNG', '', '', false, 300, '', false, false, 0, true, false, false);
		else						$pdf->Image(base_url('uploads/reportpm25/report13.png?v='.date('YmdHis')), 15, 39, 180, 180, 'PNG', '', '', false, 300, '', false, false, 0, true, false, false);
		$pdf->Ln();
		$html = empty($data['provinces'])?file_get_contents(base_url('report2/pdf_pm25_2021_2p/'.$data['area'].'?v='.date('Ymd'))):file_get_contents(base_url('report2/pdf_pm25_2021_provinces/'.$data['provinces'].'?v='.date('Ymd')));
		$pdf->writeHTML($html, true, false, true, false, '');
		ob_start();
		ob_end_flush();
		ob_end_clean();
		empty($data['provinces'])?$pdf->Output('ReportPM25_HCP1_'.date('Ymd').'_'.$data['area'].'.pdf', 'I'):$pdf->Output('ReportPM25_HCP1_'.date('Ymd').'_'.$data['provinces'].'.pdf', 'I');
	}
	public function map_podd()
	{
		$data['area'] = $this->uri->segment(3);
		$this->load->view('prophecy/map_podd',$data);
	}
}
