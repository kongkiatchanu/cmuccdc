<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
	
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
		$this->load->library('PDF');
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

	public function pm25()
	{
		$data['area'] = $this->uri->segment(3);
		$time = $this->uri->segment(4);
		$json_data = file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/regionreport');
		$json_data = json_decode($json_data);
		$data['data']=array();
		if($data['area']==1){
			// [0] => เชียงราย
			// [1] => เชียงใหม่
			// [2] => น่าน
			// [3] => พะเยา
			// [4] => แพร่
			// [5] => แม่ฮ่องสอน
			// [6] => ลำปาง
			// [7] => ลำพูน
			foreach ($json_data[0]->provinces as $k => $v) {
				if($v->province_id==38)	$data1=$v;
				if($v->province_id==46)	$data2=$v;
				if($v->province_id==40)	$data3=$v;
				if($v->province_id==39)	$data4=$v;
				if($v->province_id==45)	$data5=$v;
				if($v->province_id==43)	$data6=$v;
				if($v->province_id==44)	$data7=$v;
				if($v->province_id==42)	$data8=$v;
			}
			array_push($data['data'],$data5,$data1,$data6,$data7,$data8,$data2,$data3,$data4);
		}else if($data['area']==2){
			// [0] => ตาก
			// [1] => พิษณุโลก
			// [2] => เพชรบูรณ์
			// [3] => สุโขทัย
			// [4] => อุตรดิตถ์
			foreach ($json_data[3]->provinces as $k => $v) {
				if($v->province_id==50)	$data1=$v;
			}
			foreach ($json_data[1]->provinces as $k => $v) {
				if($v->province_id==52)	$data2=$v;
				if($v->province_id==54)	$data3=$v;
				if($v->province_id==51)	$data4=$v;
			}
			foreach ($json_data[0]->provinces as $k => $v) {
				if($v->province_id==41)	$data5=$v;
			}
			array_push($data['data'],$data1,$data2,$data3,$data4,$data5);
		}else if($data['area']==3){
			// [0] => กำแพงเพชร
			// [1] => ชัยนาท
			// [2] => นครสวรรค์
			// [3] => พิจิตร
			// [4] => อุทัยธานี
			foreach ($json_data[1]->provinces as $k => $v) {
				if($v->province_id==49)	$data1=$v;
				if($v->province_id==47)	$data2=$v;
				if($v->province_id==53)	$data3=$v;
				if($v->province_id==48)	$data4=$v;
				if($v->province_id==9)	$data5=$v;
			}
			array_push($data['data'],$data1,$data5,$data2,$data3,$data4);
		}else if($data['area']==4){
			// [0] => นครนายก
			// [1] => นนทบุรี
			// [2] => ปทุมธานี
			// [3] => พระนครศรีอยุธยา
			// [4] => ลพบุรี
			// [5] => สระบุรี
			// [6] => สิงห์บุรี
			// [7] => อ่างทอง
			foreach ($json_data[1]->provinces as $k => $v) {
				if($v->province_id==3)	$data1=$v;
				if($v->province_id==4)	$data2=$v;
				if($v->province_id==5)	$data3=$v;
				if($v->province_id==10)	$data4=$v;
				if($v->province_id==7)	$data5=$v;
				if($v->province_id==8)	$data6=$v;
				if($v->province_id==6)	$data7=$v;
				if($v->province_id==17)	$data8=$v;
			}
			array_push($data['data'],$data8,$data1,$data2,$data3,$data5,$data4,$data6,$data7);
		}else if($data['area']==5){
			// [0] => กาญจนบุรี
			// [1] => นครปฐม
			// [2] => ประจวบคีรีขันธ์
			// [3] => เพชรบุรี
			// [4] => เพชรบูรณ์
			// [5] => สมุทรสงคราม
			// [6] => สมุทรสาคร
			// [7] => สุพรรณบุรี
			foreach ($json_data[3]->provinces as $k => $v) {
				if($v->province_id==56)	$data1=$v;
				if($v->province_id==62)	$data2=$v;
				if($v->province_id==61)	$data3=$v;
			}
			foreach ($json_data[1]->provinces as $k => $v) {
				if($v->province_id==54)	$data4=$v;
				if($v->province_id==58)	$data5=$v;
				if($v->province_id==57)	$data6=$v;
				if($v->province_id==60)	$data7=$v;
				if($v->province_id==59)	$data8=$v;
			}
			array_push($data['data'],$data1,$data5,$data2,$data3,$data4,$data7,$data8,$data6);
		}else if($data['area']==6){
			// [0] => ฉะเชิงเทรา
			// [1] => ตราด
			// [2] => ปราจีนบุรี
			// [3] => ระยอง
			// [4] => สมุทรปราการ
			// [5] => สระแก้ว
			foreach ($json_data[4]->provinces as $k => $v) {
				if($v->province_id==16)	$data1=$v;
				if($v->province_id==18)	$data2=$v;
				if($v->province_id==14)	$data3=$v;
				if($v->province_id==12)	$data4=$v;
				if($v->province_id==15)	$data5=$v;
			}
			foreach ($json_data[1]->provinces as $k => $v) {
				if($v->province_id==2)	$data6=$v;
			}
			array_push($data['data'],$data5,$data3,$data1,$data4,$data6,$data2);
		}else if($data['area']==7){
			// [0] => กาฬสินธุ์
			// [1] => ขอนแก่น
			// [2] => มหาสารคาม
			// [3] => ร้อยเอ็ด
			foreach ($json_data[2]->provinces as $k => $v) {
				if($v->province_id==34)	$data1=$v;
				if($v->province_id==28)	$data2=$v;
				if($v->province_id==32)	$data3=$v;
				if($v->province_id==33)	$data4=$v;
			}
			array_push($data['data'],$data1,$data2,$data3,$data4);
		}else if($data['area']==8){
			// [0] => นครพนม
			// [1] => บึงกาฬ
			// [2] => มุกดาหาร
			// [3] => เลย
			// [4] => สกลนคร
			// [5] => หนองคาย
			// [6] => หนองบัวลำภู
			// [7] => อุดรธานี
			foreach ($json_data[2]->provinces as $k => $v) {
				if($v->province_id==30)	$data1=$v;
				if($v->province_id==31)	$data2=$v;
				if($v->province_id==27)	$data3=$v;
				if($v->province_id==29)	$data4=$v;
				if($v->province_id==77)	$data5=$v;
				if($v->province_id==36)	$data6=$v;
				if($v->province_id==37)	$data7=$v;
				if($v->province_id==35)	$data8=$v;
			}
			array_push($data['data'],$data6,$data5,$data7,$data1,$data8,$data2,$data3,$data4);
		}else if($data['area']==9){
			// [0] => ชัยภูมิ
			// [1] => นครราชสีมา
			// [2] => บุรีรัมย์
			// [3] => สุรินทร์
			foreach ($json_data[2]->provinces as $k => $v) {
				if($v->province_id==25)	$data1=$v;
				if($v->province_id==19)	$data2=$v;
				if($v->province_id==20)	$data3=$v;
				if($v->province_id==21)	$data4=$v;
			}
			array_push($data['data'],$data1,$data2,$data3,$data4);
		}else if($data['area']==10){
			// [0] => ยโสธร
			// [1] => ศรีสะเกษ
			// [2] => อำนาจเจริญ
			// [3] => อุบลราชธานี
			foreach ($json_data[2]->provinces as $k => $v) {
				if($v->province_id==24)	$data1=$v;
				if($v->province_id==22)	$data2=$v;
				if($v->province_id==26)	$data3=$v;
				if($v->province_id==23)	$data4=$v;
			}
			array_push($data['data'],$data1,$data2,$data3,$data4);
		}else if($data['area']==11){
			// [0] => กระบี่
			// [1] => ชุมพร
			// [2] => นครศรีธรรมราช
			// [3] => พังงา
			// [4] => ภูเก็ต
			// [5] => ระนอง
			// [6] => สุราษฎร์ธานี
			foreach ($json_data[5]->provinces as $k => $v) {
				if($v->province_id==69)	$data1=$v;
				if($v->province_id==63)	$data2=$v;
				if($v->province_id==67)	$data3=$v;
				if($v->province_id==64)	$data4=$v;
				if($v->province_id==65)	$data5=$v;
				if($v->province_id==66)	$data6=$v;
				if($v->province_id==68)	$data7=$v;
			}
			array_push($data['data'],$data4,$data1,$data2,$data5,$data6,$data7,$data3);
		}else if($data['area']==12){
			// [0] => ตรัง
			// [1] => นราธิวาส
			// [2] => ปัตตานี
			// [3] => พัทลุง
			// [4] => ยะลา
			// [5] => สงขลา
			// [6] => สตูล
			foreach ($json_data[5]->provinces as $k => $v) {
				if($v->province_id==73)	$data1=$v;
				if($v->province_id==72)	$data2=$v;
				if($v->province_id==76)	$data3=$v;
				if($v->province_id==74)	$data4=$v;
				if($v->province_id==75)	$data5=$v;
				if($v->province_id==70)	$data6=$v;
				if($v->province_id==71)	$data7=$v;
			}
			array_push($data['data'],$data2,$data3,$data4,$data1,$data5,$data6,$data7);
		}else if($data['area']==13){
			foreach ($json_data[1]->provinces as $k => $v) {
				if($v->province_id==1)	$data1=$v;
			}
			array_push($data['data'],$data1);
		}
		// echo '<pre>';
		// print_r($json_data);
		// echo '</pre>';
		$index=0;
		foreach ($data['data'] as $key => $value) { 
			if(!empty($value->stations)){
				$index++;
				foreach ($value->stations as $k => $v) {
					if(!empty($v->weather)){
						$index++;
					}else{
						$index++;
					}
				}
			}
		}
		// echo $index;
		// exit();
	
		// สร้าง object สำหรับใช้สร้าง pdf 
		$pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// กำหนดรายละเอียดของ pdf
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('CMUCCDC');
		$pdf->SetTitle('รายงานค่ามลพิษทางอากาศ ฝุ่นละอองขนาดเล็ก (PM2.5)');
		$pdf->SetSubject('ReportPM2.5');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
		
		// กำหนดข้อมูลที่จะแสดงในส่วนของ header และ footer
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
		// $pdf->setFooterData(array(0,64,0), array(0,64,128));
		

		// กำหนดรูปแบบของฟอนท์และขนาดฟอนท์ที่ใช้ใน header และ footer
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		
		// กำหนดค่าเริ่มต้นของฟอนท์แบบ monospaced 
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		// กำหนด margins
		$pdf->SetMargins(15, PDF_MARGIN_TOP, 15);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		
		// กำหนดการแบ่งหน้าอัตโนมัติ
		// $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		
		// กำหนดรูปแบบการปรับขนาดของรูปภาพ 
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		
		// ---------------------------------------------------------
		

		// กำหนดฟอนท์ 
		// ฟอนท์ freeserif รองรับภาษาไทย
		$pdf->SetFont('thsarabunpskb', '', 14, '', true);
		
		// เพิ่มหน้า pdf
		// การกำหนดในส่วนนี้ สามารถปรับรูปแบบต่างๆ ได้ ดูวิธีใช้งานที่คู่มือของ tcpdf เพิ่มเติม
		$pdf->AddPage();
		// สารบัญ
		// กำหนดเนื้อหาข้อมูลที่จะสร้าง pdf ในที่นี้เราจะกำหนดเป็นแบบ html โปรดระวัง EOD; โค้ดสุดท้ายต้องชิดซ้ายไม่เว้นวรรค
		if($data['area']==1){
			$pdf->Image(base_url('uploads/reportpm25/report1.jpg?v='.date('YmdHis')), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else if($data['area']==2){
			$pdf->Image(base_url('uploads/reportpm25/report2.jpg?v='.date('YmdHis')), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else if($data['area']==3){
			$pdf->Image(base_url('uploads/reportpm25/report3.jpg?v='.date('YmdHis')), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else if($data['area']==4){
			$pdf->Image(base_url('uploads/reportpm25/report4.jpg?v='.date('YmdHis')), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else if($data['area']==5){
			$pdf->Image(base_url('uploads/reportpm25/report5.jpg?v='.date('YmdHis')), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else if($data['area']==6){
			$pdf->Image(base_url('uploads/reportpm25/report6.jpg?v='.date('YmdHis')), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else if($data['area']==7){
			$pdf->Image(base_url('uploads/reportpm25/report7.jpg?v='.date('YmdHis')), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else if($data['area']==8){
			$pdf->Image(base_url('uploads/reportpm25/report8.jpg?v='.date('YmdHis')), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else if($data['area']==9){
			$pdf->Image(base_url('uploads/reportpm25/report9.jpg?v='.date('YmdHis')), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else if($data['area']==10){
			$pdf->Image(base_url('uploads/reportpm25/report10.jpg?v='.date('YmdHis')), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else if($data['area']==11){
			$pdf->Image(base_url('uploads/reportpm25/report11.jpg?v='.date('YmdHis')), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else if($data['area']==12){
			$pdf->Image(base_url('uploads/reportpm25/report12.jpg?v='.date('YmdHis')), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else{
			$pdf->Image(base_url('uploads/reportpm25/report13.jpg?v='.date('YmdHis')), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}
		$pdf->Ln();
		// $pdf->Cell(180, 151,'ที่มา: https://www.cmuccdc.org/prophecy', 0, 0, 'R', 0, '', 0, false, 'T', 'B');
		$html = file_get_contents(base_url('report/pdf_pm25/'.$data['area']));
		$pdf->writeHTML($html, true, false, true, false, '');

		if($index>=12){
			// กำหนดการแบ่งหน้าอัตโนมัติ
			$pdf->SetAutoPageBreak(TRUE, 29);
			$pdf->AddPage();
			$html = file_get_contents(base_url('report/pdf_pm25_2/'.$data['area']));
			$pdf->writeHTML($html, true, false, true, false, '');
		}
		// ---------------------------------------------------------
		// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
		// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
		// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
		// จบการทำงานและแสดงไฟล์ pdf
		// การกำหนดในส่วนนี้ สามารถปรับรูปแบบต่างๆ ได้ เช่นให้บันทึกเป้นไฟล์ หรือให้แสดง pdf เลย ดูวิธีใช้งานที่คู่มือของ tcpdf เพิ่มเติม
		// $pdf->Output('ReportPM25_'.date('YmdH').'.pdf', 'I');
		ob_start();
		ob_end_flush();
		ob_end_clean();
		$pdf->Output('ReportPM25_'.date('YmdH').'_'.$data['area'].'.pdf', 'I');
	}
	public function pm25_test()
	{
		$data['area'] = $this->uri->segment(3);
		$time = $this->uri->segment(4);
		$json_data = file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/regionreport');
		$json_data = json_decode($json_data);
		$data['data']=array();
		if($data['area']==1){
			// [0] => เชียงราย
			// [1] => เชียงใหม่
			// [2] => น่าน
			// [3] => พะเยา
			// [4] => แพร่
			// [5] => แม่ฮ่องสอน
			// [6] => ลำปาง
			// [7] => ลำพูน
			foreach ($json_data[0]->provinces as $k => $v) {
				if($v->province_id==38)	$data1=$v;
				if($v->province_id==46)	$data2=$v;
				if($v->province_id==40)	$data3=$v;
				if($v->province_id==39)	$data4=$v;
				if($v->province_id==45)	$data5=$v;
				if($v->province_id==43)	$data6=$v;
				if($v->province_id==44)	$data7=$v;
				if($v->province_id==42)	$data8=$v;
			}
			array_push($data['data'],$data5,$data1,$data6,$data7,$data8,$data2,$data3,$data4);
		}else if($data['area']==2){
			// [0] => ตาก
			// [1] => พิษณุโลก
			// [2] => เพชรบูรณ์
			// [3] => สุโขทัย
			// [4] => อุตรดิตถ์
			foreach ($json_data[3]->provinces as $k => $v) {
				if($v->province_id==50)	$data1=$v;
			}
			foreach ($json_data[1]->provinces as $k => $v) {
				if($v->province_id==52)	$data2=$v;
				if($v->province_id==54)	$data3=$v;
				if($v->province_id==51)	$data4=$v;
			}
			foreach ($json_data[0]->provinces as $k => $v) {
				if($v->province_id==41)	$data5=$v;
			}
			array_push($data['data'],$data1,$data2,$data3,$data4,$data5);
		}else if($data['area']==3){
			// [0] => กำแพงเพชร
			// [1] => ชัยนาท
			// [2] => นครสวรรค์
			// [3] => พิจิตร
			// [4] => อุทัยธานี
			foreach ($json_data[1]->provinces as $k => $v) {
				if($v->province_id==49)	$data1=$v;
				if($v->province_id==47)	$data2=$v;
				if($v->province_id==53)	$data3=$v;
				if($v->province_id==48)	$data4=$v;
				if($v->province_id==9)	$data5=$v;
			}
			array_push($data['data'],$data1,$data5,$data2,$data3,$data4);
		}else if($data['area']==4){
			// [0] => นครนายก
			// [1] => นนทบุรี
			// [2] => ปทุมธานี
			// [3] => พระนครศรีอยุธยา
			// [4] => ลพบุรี
			// [5] => สระบุรี
			// [6] => สิงห์บุรี
			// [7] => อ่างทอง
			foreach ($json_data[1]->provinces as $k => $v) {
				if($v->province_id==3)	$data1=$v;
				if($v->province_id==4)	$data2=$v;
				if($v->province_id==5)	$data3=$v;
				if($v->province_id==10)	$data4=$v;
				if($v->province_id==7)	$data5=$v;
				if($v->province_id==8)	$data6=$v;
				if($v->province_id==6)	$data7=$v;
				if($v->province_id==17)	$data8=$v;
			}
			array_push($data['data'],$data8,$data1,$data2,$data3,$data5,$data4,$data6,$data7);
		}else if($data['area']==5){
			// [0] => กาญจนบุรี
			// [1] => นครปฐม
			// [2] => ประจวบคีรีขันธ์
			// [3] => เพชรบุรี
			// [4] => เพชรบูรณ์
			// [5] => สมุทรสงคราม
			// [6] => สมุทรสาคร
			// [7] => สุพรรณบุรี
			foreach ($json_data[3]->provinces as $k => $v) {
				if($v->province_id==56)	$data1=$v;
				if($v->province_id==62)	$data2=$v;
				if($v->province_id==61)	$data3=$v;
			}
			foreach ($json_data[1]->provinces as $k => $v) {
				if($v->province_id==54)	$data4=$v;
				if($v->province_id==58)	$data5=$v;
				if($v->province_id==57)	$data6=$v;
				if($v->province_id==60)	$data7=$v;
				if($v->province_id==59)	$data8=$v;
			}
			array_push($data['data'],$data1,$data5,$data2,$data3,$data4,$data7,$data8,$data6);
		}else if($data['area']==6){
			// [0] => ฉะเชิงเทรา
			// [1] => ตราด
			// [2] => ปราจีนบุรี
			// [3] => ระยอง
			// [4] => สมุทรปราการ
			// [5] => สระแก้ว
			foreach ($json_data[4]->provinces as $k => $v) {
				if($v->province_id==16)	$data1=$v;
				if($v->province_id==18)	$data2=$v;
				if($v->province_id==14)	$data3=$v;
				if($v->province_id==12)	$data4=$v;
				if($v->province_id==15)	$data5=$v;
			}
			foreach ($json_data[1]->provinces as $k => $v) {
				if($v->province_id==2)	$data6=$v;
			}
			array_push($data['data'],$data5,$data3,$data1,$data4,$data6,$data2);
		}else if($data['area']==7){
			// [0] => กาฬสินธุ์
			// [1] => ขอนแก่น
			// [2] => มหาสารคาม
			// [3] => ร้อยเอ็ด
			foreach ($json_data[2]->provinces as $k => $v) {
				if($v->province_id==34)	$data1=$v;
				if($v->province_id==28)	$data2=$v;
				if($v->province_id==32)	$data3=$v;
				if($v->province_id==33)	$data4=$v;
			}
			array_push($data['data'],$data1,$data2,$data3,$data4);
		}else if($data['area']==8){
			// [0] => นครพนม
			// [1] => บึงกาฬ
			// [2] => มุกดาหาร
			// [3] => เลย
			// [4] => สกลนคร
			// [5] => หนองคาย
			// [6] => หนองบัวลำภู
			// [7] => อุดรธานี
			foreach ($json_data[2]->provinces as $k => $v) {
				if($v->province_id==30)	$data1=$v;
				if($v->province_id==31)	$data2=$v;
				if($v->province_id==27)	$data3=$v;
				if($v->province_id==29)	$data4=$v;
				if($v->province_id==77)	$data5=$v;
				if($v->province_id==36)	$data6=$v;
				if($v->province_id==37)	$data7=$v;
				if($v->province_id==35)	$data8=$v;
			}
			array_push($data['data'],$data6,$data5,$data7,$data1,$data8,$data2,$data3,$data4);
		}else if($data['area']==9){
			// [0] => ชัยภูมิ
			// [1] => นครราชสีมา
			// [2] => บุรีรัมย์
			// [3] => สุรินทร์
			foreach ($json_data[2]->provinces as $k => $v) {
				if($v->province_id==25)	$data1=$v;
				if($v->province_id==19)	$data2=$v;
				if($v->province_id==20)	$data3=$v;
				if($v->province_id==21)	$data4=$v;
			}
			array_push($data['data'],$data1,$data2,$data3,$data4);
		}else if($data['area']==10){
			// [0] => ยโสธร
			// [1] => ศรีสะเกษ
			// [2] => อำนาจเจริญ
			// [3] => อุบลราชธานี
			foreach ($json_data[2]->provinces as $k => $v) {
				if($v->province_id==24)	$data1=$v;
				if($v->province_id==22)	$data2=$v;
				if($v->province_id==26)	$data3=$v;
				if($v->province_id==23)	$data4=$v;
			}
			array_push($data['data'],$data1,$data2,$data3,$data4);
		}else if($data['area']==11){
			// [0] => กระบี่
			// [1] => ชุมพร
			// [2] => นครศรีธรรมราช
			// [3] => พังงา
			// [4] => ภูเก็ต
			// [5] => ระนอง
			// [6] => สุราษฎร์ธานี
			foreach ($json_data[5]->provinces as $k => $v) {
				if($v->province_id==69)	$data1=$v;
				if($v->province_id==63)	$data2=$v;
				if($v->province_id==67)	$data3=$v;
				if($v->province_id==64)	$data4=$v;
				if($v->province_id==65)	$data5=$v;
				if($v->province_id==66)	$data6=$v;
				if($v->province_id==68)	$data7=$v;
			}
			array_push($data['data'],$data4,$data1,$data2,$data5,$data6,$data7,$data3);
		}else if($data['area']==12){
			// [0] => ตรัง
			// [1] => นราธิวาส
			// [2] => ปัตตานี
			// [3] => พัทลุง
			// [4] => ยะลา
			// [5] => สงขลา
			// [6] => สตูล
			foreach ($json_data[5]->provinces as $k => $v) {
				if($v->province_id==73)	$data1=$v;
				if($v->province_id==72)	$data2=$v;
				if($v->province_id==76)	$data3=$v;
				if($v->province_id==74)	$data4=$v;
				if($v->province_id==75)	$data5=$v;
				if($v->province_id==70)	$data6=$v;
				if($v->province_id==71)	$data7=$v;
			}
			array_push($data['data'],$data2,$data3,$data4,$data1,$data5,$data6,$data7);
		}else if($data['area']==13){
			foreach ($json_data[1]->provinces as $k => $v) {
				if($v->province_id==1)	$data1=$v;
			}
			array_push($data['data'],$data1);
		}
		// echo '<pre>';
		// print_r($json_data);
		// echo '</pre>';
		$index=0;
		foreach ($data['data'] as $key => $value) { 
			if(!empty($value->stations)){
				$index++;
				foreach ($value->stations as $k => $v) {
					if(!empty($v->weather)){
						$index++;
					}
				}
			}
		}
		// echo $index;
		// exit();
	
		// สร้าง object สำหรับใช้สร้าง pdf 
		$pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// กำหนดรายละเอียดของ pdf
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('CMUCCDC');
		$pdf->SetTitle('รายงานค่ามลพิษทางอากาศ ฝุ่นละอองขนาดเล็ก (PM2.5)');
		$pdf->SetSubject('ReportPM2.5');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
		
		// กำหนดข้อมูลที่จะแสดงในส่วนของ header และ footer
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
		// $pdf->setFooterData(array(0,64,0), array(0,64,128));
		

		// กำหนดรูปแบบของฟอนท์และขนาดฟอนท์ที่ใช้ใน header และ footer
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		
		// กำหนดค่าเริ่มต้นของฟอนท์แบบ monospaced 
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		// กำหนด margins
		$pdf->SetMargins(15, PDF_MARGIN_TOP, 15);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		
		// กำหนดการแบ่งหน้าอัตโนมัติ
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		
		// กำหนดรูปแบบการปรับขนาดของรูปภาพ 
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		
		// ---------------------------------------------------------
		

		// กำหนดฟอนท์ 
		// ฟอนท์ freeserif รองรับภาษาไทย
		$pdf->SetFont('thsarabunpskb', '', 14, '', true);
		
		// เพิ่มหน้า pdf
		// การกำหนดในส่วนนี้ สามารถปรับรูปแบบต่างๆ ได้ ดูวิธีใช้งานที่คู่มือของ tcpdf เพิ่มเติม
		$pdf->AddPage();
		// สารบัญ
		// กำหนดเนื้อหาข้อมูลที่จะสร้าง pdf ในที่นี้เราจะกำหนดเป็นแบบ html โปรดระวัง EOD; โค้ดสุดท้ายต้องชิดซ้ายไม่เว้นวรรค
		if($data['area']==1){
			$pdf->Image(base_url('assets/image_pdf/pm251.jpg'), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
			// $pdf->Image(base_url('assets/image_pdf/icon1.png'), 100, 100, 5, 5, 'PNG', '', '', false, 300, '', false, false, 0, true, false, false);
			// $pdf->Image(base_url('assets/image_pdf/icon2.png'), 80, 100, 5, 5, 'PNG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else if($data['area']==2){
			$pdf->Image(base_url('assets/image_pdf/pm252.jpg'), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else if($data['area']==3){
			$pdf->Image(base_url('assets/image_pdf/pm253.jpg'), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else if($data['area']==4){
			$pdf->Image(base_url('assets/image_pdf/pm254.jpg'), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else if($data['area']==5){
			$pdf->Image(base_url('assets/image_pdf/pm255.jpg'), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else if($data['area']==6){
			$pdf->Image(base_url('assets/image_pdf/pm256.jpg'), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else if($data['area']==7){
			$pdf->Image(base_url('assets/image_pdf/pm257.jpg'), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else if($data['area']==8){
			$pdf->Image(base_url('assets/image_pdf/pm258.jpg'), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else if($data['area']==9){
			$pdf->Image(base_url('assets/image_pdf/pm259.jpg'), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else if($data['area']==10){
			$pdf->Image(base_url('assets/image_pdf/pm2510.jpg'), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else if($data['area']==11){
			$pdf->Image(base_url('assets/image_pdf/pm2511.jpg'), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else if($data['area']==12){
			$pdf->Image(base_url('assets/image_pdf/pm2512.jpg'), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else{
			$pdf->Image(base_url('assets/image_pdf/pm2513.jpg'), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}
		$html = file_get_contents(base_url('report/pdf_pm25/'.$data['area']));
		$pdf->writeHTML($html, true, false, true, false, '');

		if($index>=22){
			$pdf->SetMargins(15, 30, 15);
			$pdf->AddPage();
			$html = file_get_contents(base_url('report/pdf_pm25_2/'.$data['area']));
			$pdf->writeHTML($html, true, false, true, false, '');
		}
		// ---------------------------------------------------------
		// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
		// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
		// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
		// จบการทำงานและแสดงไฟล์ pdf
		// การกำหนดในส่วนนี้ สามารถปรับรูปแบบต่างๆ ได้ เช่นให้บันทึกเป้นไฟล์ หรือให้แสดง pdf เลย ดูวิธีใช้งานที่คู่มือของ tcpdf เพิ่มเติม
		$pdf->Output('ReportPM25_TEST_'.date('YmdH').'.pdf', 'I');
	}
	public function pdf_pm25()
	{
		$data['area'] = $this->uri->segment(3);
		$time = $this->uri->segment(4);
		$json_data = file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/regionreport');
		$json_data = json_decode($json_data);
		$data['data']=array();
		if($data['area']==1){
			// [0] => เชียงราย
			// [1] => เชียงใหม่
			// [2] => น่าน
			// [3] => พะเยา
			// [4] => แพร่
			// [5] => แม่ฮ่องสอน
			// [6] => ลำปาง
			// [7] => ลำพูน
			foreach ($json_data[0]->provinces as $k => $v) {
				if($v->province_id==38)	$data1=$v;
				if($v->province_id==46)	$data2=$v;
				if($v->province_id==40)	$data3=$v;
				if($v->province_id==39)	$data4=$v;
				if($v->province_id==45)	$data5=$v;
				if($v->province_id==43)	$data6=$v;
				if($v->province_id==44)	$data7=$v;
				if($v->province_id==42)	$data8=$v;
			}
			array_push($data['data'],$data5,$data1,$data6,$data7,$data8,$data2,$data3,$data4);
		}else if($data['area']==2){
			// [0] => ตาก
			// [1] => พิษณุโลก
			// [2] => เพชรบูรณ์
			// [3] => สุโขทัย
			// [4] => อุตรดิตถ์
			foreach ($json_data[3]->provinces as $k => $v) {
				if($v->province_id==50)	$data1=$v;
			}
			foreach ($json_data[1]->provinces as $k => $v) {
				if($v->province_id==52)	$data2=$v;
				if($v->province_id==54)	$data3=$v;
				if($v->province_id==51)	$data4=$v;
			}
			foreach ($json_data[0]->provinces as $k => $v) {
				if($v->province_id==41)	$data5=$v;
			}
			array_push($data['data'],$data1,$data2,$data3,$data4,$data5);
		}else if($data['area']==3){
			// [0] => กำแพงเพชร
			// [1] => ชัยนาท
			// [2] => นครสวรรค์
			// [3] => พิจิตร
			// [4] => อุทัยธานี
			foreach ($json_data[1]->provinces as $k => $v) {
				if($v->province_id==49)	$data1=$v;
				if($v->province_id==47)	$data2=$v;
				if($v->province_id==53)	$data3=$v;
				if($v->province_id==48)	$data4=$v;
				if($v->province_id==9)	$data5=$v;
			}
			array_push($data['data'],$data1,$data5,$data2,$data3,$data4);
		}else if($data['area']==4){
			// [0] => นครนายก
			// [1] => นนทบุรี
			// [2] => ปทุมธานี
			// [3] => พระนครศรีอยุธยา
			// [4] => ลพบุรี
			// [5] => สระบุรี
			// [6] => สิงห์บุรี
			// [7] => อ่างทอง
			foreach ($json_data[1]->provinces as $k => $v) {
				if($v->province_id==3)	$data1=$v;
				if($v->province_id==4)	$data2=$v;
				if($v->province_id==5)	$data3=$v;
				if($v->province_id==10)	$data4=$v;
				if($v->province_id==7)	$data5=$v;
				if($v->province_id==8)	$data6=$v;
				if($v->province_id==6)	$data7=$v;
				if($v->province_id==17)	$data8=$v;
			}
			array_push($data['data'],$data8,$data1,$data2,$data3,$data5,$data4,$data6,$data7);
		}else if($data['area']==5){
			// [0] => กาญจนบุรี
			// [1] => นครปฐม
			// [2] => ประจวบคีรีขันธ์
			// [3] => เพชรบุรี
			// [4] => เพชรบูรณ์
			// [5] => สมุทรสงคราม
			// [6] => สมุทรสาคร
			// [7] => สุพรรณบุรี
			foreach ($json_data[3]->provinces as $k => $v) {
				if($v->province_id==56)	$data1=$v;
				if($v->province_id==62)	$data2=$v;
				if($v->province_id==61)	$data3=$v;
			}
			foreach ($json_data[1]->provinces as $k => $v) {
				if($v->province_id==54)	$data4=$v;
				if($v->province_id==58)	$data5=$v;
				if($v->province_id==57)	$data6=$v;
				if($v->province_id==60)	$data7=$v;
				if($v->province_id==59)	$data8=$v;
			}
			array_push($data['data'],$data1,$data5,$data2,$data3,$data4,$data7,$data8,$data6);
		}else if($data['area']==6){
			// [0] => ฉะเชิงเทรา
			// [1] => ตราด
			// [2] => ปราจีนบุรี
			// [3] => ระยอง
			// [4] => สมุทรปราการ
			// [5] => สระแก้ว
			foreach ($json_data[4]->provinces as $k => $v) {
				if($v->province_id==16)	$data1=$v;
				if($v->province_id==18)	$data2=$v;
				if($v->province_id==14)	$data3=$v;
				if($v->province_id==12)	$data4=$v;
				if($v->province_id==15)	$data5=$v;
			}
			foreach ($json_data[1]->provinces as $k => $v) {
				if($v->province_id==2)	$data6=$v;
			}
			array_push($data['data'],$data5,$data3,$data1,$data4,$data6,$data2);
		}else if($data['area']==7){
			// [0] => กาฬสินธุ์
			// [1] => ขอนแก่น
			// [2] => มหาสารคาม
			// [3] => ร้อยเอ็ด
			foreach ($json_data[2]->provinces as $k => $v) {
				if($v->province_id==34)	$data1=$v;
				if($v->province_id==28)	$data2=$v;
				if($v->province_id==32)	$data3=$v;
				if($v->province_id==33)	$data4=$v;
			}
			array_push($data['data'],$data1,$data2,$data3,$data4);
		}else if($data['area']==8){
			// [0] => นครพนม
			// [1] => บึงกาฬ
			// [2] => มุกดาหาร
			// [3] => เลย
			// [4] => สกลนคร
			// [5] => หนองคาย
			// [6] => หนองบัวลำภู
			// [7] => อุดรธานี
			foreach ($json_data[2]->provinces as $k => $v) {
				if($v->province_id==30)	$data1=$v;
				if($v->province_id==31)	$data2=$v;
				if($v->province_id==27)	$data3=$v;
				if($v->province_id==29)	$data4=$v;
				if($v->province_id==77)	$data5=$v;
				if($v->province_id==36)	$data6=$v;
				if($v->province_id==37)	$data7=$v;
				if($v->province_id==35)	$data8=$v;
			}
			array_push($data['data'],$data6,$data5,$data7,$data1,$data8,$data2,$data3,$data4);
		}else if($data['area']==9){
			// [0] => ชัยภูมิ
			// [1] => นครราชสีมา
			// [2] => บุรีรัมย์
			// [3] => สุรินทร์
			foreach ($json_data[2]->provinces as $k => $v) {
				if($v->province_id==25)	$data1=$v;
				if($v->province_id==19)	$data2=$v;
				if($v->province_id==20)	$data3=$v;
				if($v->province_id==21)	$data4=$v;
			}
			array_push($data['data'],$data1,$data2,$data3,$data4);
		}else if($data['area']==10){
			// [0] => ยโสธร
			// [1] => ศรีสะเกษ
			// [2] => อำนาจเจริญ
			// [3] => อุบลราชธานี
			foreach ($json_data[2]->provinces as $k => $v) {
				if($v->province_id==24)	$data1=$v;
				if($v->province_id==22)	$data2=$v;
				if($v->province_id==26)	$data3=$v;
				if($v->province_id==23)	$data4=$v;
			}
			array_push($data['data'],$data1,$data2,$data3,$data4);
		}else if($data['area']==11){
			// [0] => กระบี่
			// [1] => ชุมพร
			// [2] => นครศรีธรรมราช
			// [3] => พังงา
			// [4] => ภูเก็ต
			// [5] => ระนอง
			// [6] => สุราษฎร์ธานี
			foreach ($json_data[5]->provinces as $k => $v) {
				if($v->province_id==69)	$data1=$v;
				if($v->province_id==63)	$data2=$v;
				if($v->province_id==67)	$data3=$v;
				if($v->province_id==64)	$data4=$v;
				if($v->province_id==65)	$data5=$v;
				if($v->province_id==66)	$data6=$v;
				if($v->province_id==68)	$data7=$v;
			}
			array_push($data['data'],$data4,$data1,$data2,$data5,$data6,$data7,$data3);
		}else if($data['area']==12){
			// [0] => ตรัง
			// [1] => นราธิวาส
			// [2] => ปัตตานี
			// [3] => พัทลุง
			// [4] => ยะลา
			// [5] => สงขลา
			// [6] => สตูล
			foreach ($json_data[5]->provinces as $k => $v) {
				if($v->province_id==73)	$data1=$v;
				if($v->province_id==72)	$data2=$v;
				if($v->province_id==76)	$data3=$v;
				if($v->province_id==74)	$data4=$v;
				if($v->province_id==75)	$data5=$v;
				if($v->province_id==70)	$data6=$v;
				if($v->province_id==71)	$data7=$v;
			}
			array_push($data['data'],$data2,$data3,$data4,$data1,$data5,$data6,$data7);
		}else if($data['area']==13){
			foreach ($json_data[1]->provinces as $k => $v) {
				if($v->province_id==1)	$data1=$v;
			}
			array_push($data['data'],$data1);
		}
		// echo '<pre>';
		// print_r($data['data']);

		// $sortdata=array();
		// foreach ($data['data'] as $key => $value) { 
		// 		array_push($sortdata,$value->province_name_th);
		// }
		// usort($sortdata,'th_strcoll');
		// print_r($sortdata);
		// echo '</pre>';
		// exit();
		$this->load->view('file_pdf/pdf_text',$data);
	}
	public function pdf_pm25_2()
	{
		$data['area'] = $this->uri->segment(3);
		$time = $this->uri->segment(4);
		$json_data = file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/regionreport');
		$json_data = json_decode($json_data);
		$data['data']=array();
		if($data['area']==1){
			// [0] => เชียงราย
			// [1] => เชียงใหม่
			// [2] => น่าน
			// [3] => พะเยา
			// [4] => แพร่
			// [5] => แม่ฮ่องสอน
			// [6] => ลำปาง
			// [7] => ลำพูน
			foreach ($json_data[0]->provinces as $k => $v) {
				if($v->province_id==38)	$data1=$v;
				if($v->province_id==46)	$data2=$v;
				if($v->province_id==40)	$data3=$v;
				if($v->province_id==39)	$data4=$v;
				if($v->province_id==45)	$data5=$v;
				if($v->province_id==43)	$data6=$v;
				if($v->province_id==44)	$data7=$v;
				if($v->province_id==42)	$data8=$v;
			}
			array_push($data['data'],$data5,$data1,$data6,$data7,$data8,$data2,$data3,$data4);
		}else if($data['area']==2){
			// [0] => ตาก
			// [1] => พิษณุโลก
			// [2] => เพชรบูรณ์
			// [3] => สุโขทัย
			// [4] => อุตรดิตถ์
			foreach ($json_data[3]->provinces as $k => $v) {
				if($v->province_id==50)	$data1=$v;
			}
			foreach ($json_data[1]->provinces as $k => $v) {
				if($v->province_id==52)	$data2=$v;
				if($v->province_id==54)	$data3=$v;
				if($v->province_id==51)	$data4=$v;
			}
			foreach ($json_data[0]->provinces as $k => $v) {
				if($v->province_id==41)	$data5=$v;
			}
			array_push($data['data'],$data1,$data2,$data3,$data4,$data5);
		}else if($data['area']==3){
			// [0] => กำแพงเพชร
			// [1] => ชัยนาท
			// [2] => นครสวรรค์
			// [3] => พิจิตร
			// [4] => อุทัยธานี
			foreach ($json_data[1]->provinces as $k => $v) {
				if($v->province_id==49)	$data1=$v;
				if($v->province_id==47)	$data2=$v;
				if($v->province_id==53)	$data3=$v;
				if($v->province_id==48)	$data4=$v;
				if($v->province_id==9)	$data5=$v;
			}
			array_push($data['data'],$data1,$data5,$data2,$data3,$data4);
		}else if($data['area']==4){
			// [0] => นครนายก
			// [1] => นนทบุรี
			// [2] => ปทุมธานี
			// [3] => พระนครศรีอยุธยา
			// [4] => ลพบุรี
			// [5] => สระบุรี
			// [6] => สิงห์บุรี
			// [7] => อ่างทอง
			foreach ($json_data[1]->provinces as $k => $v) {
				if($v->province_id==3)	$data1=$v;
				if($v->province_id==4)	$data2=$v;
				if($v->province_id==5)	$data3=$v;
				if($v->province_id==10)	$data4=$v;
				if($v->province_id==7)	$data5=$v;
				if($v->province_id==8)	$data6=$v;
				if($v->province_id==6)	$data7=$v;
				if($v->province_id==17)	$data8=$v;
			}
			array_push($data['data'],$data8,$data1,$data2,$data3,$data5,$data4,$data6,$data7);
		}else if($data['area']==5){
			// [0] => กาญจนบุรี
			// [1] => นครปฐม
			// [2] => ประจวบคีรีขันธ์
			// [3] => เพชรบุรี
			// [4] => เพชรบูรณ์
			// [5] => สมุทรสงคราม
			// [6] => สมุทรสาคร
			// [7] => สุพรรณบุรี
			foreach ($json_data[3]->provinces as $k => $v) {
				if($v->province_id==56)	$data1=$v;
				if($v->province_id==62)	$data2=$v;
				if($v->province_id==61)	$data3=$v;
			}
			foreach ($json_data[1]->provinces as $k => $v) {
				if($v->province_id==54)	$data4=$v;
				if($v->province_id==58)	$data5=$v;
				if($v->province_id==57)	$data6=$v;
				if($v->province_id==60)	$data7=$v;
				if($v->province_id==59)	$data8=$v;
			}
			array_push($data['data'],$data1,$data5,$data2,$data3,$data4,$data7,$data8,$data6);
		}else if($data['area']==6){
			// [0] => ฉะเชิงเทรา
			// [1] => ตราด
			// [2] => ปราจีนบุรี
			// [3] => ระยอง
			// [4] => สมุทรปราการ
			// [5] => สระแก้ว
			foreach ($json_data[4]->provinces as $k => $v) {
				if($v->province_id==16)	$data1=$v;
				if($v->province_id==18)	$data2=$v;
				if($v->province_id==14)	$data3=$v;
				if($v->province_id==12)	$data4=$v;
				if($v->province_id==15)	$data5=$v;
			}
			foreach ($json_data[1]->provinces as $k => $v) {
				if($v->province_id==2)	$data6=$v;
			}
			array_push($data['data'],$data5,$data3,$data1,$data4,$data6,$data2);
		}else if($data['area']==7){
			// [0] => กาฬสินธุ์
			// [1] => ขอนแก่น
			// [2] => มหาสารคาม
			// [3] => ร้อยเอ็ด
			foreach ($json_data[2]->provinces as $k => $v) {
				if($v->province_id==34)	$data1=$v;
				if($v->province_id==28)	$data2=$v;
				if($v->province_id==32)	$data3=$v;
				if($v->province_id==33)	$data4=$v;
			}
			array_push($data['data'],$data1,$data2,$data3,$data4);
		}else if($data['area']==8){
			// [0] => นครพนม
			// [1] => บึงกาฬ
			// [2] => มุกดาหาร
			// [3] => เลย
			// [4] => สกลนคร
			// [5] => หนองคาย
			// [6] => หนองบัวลำภู
			// [7] => อุดรธานี
			foreach ($json_data[2]->provinces as $k => $v) {
				if($v->province_id==30)	$data1=$v;
				if($v->province_id==31)	$data2=$v;
				if($v->province_id==27)	$data3=$v;
				if($v->province_id==29)	$data4=$v;
				if($v->province_id==77)	$data5=$v;
				if($v->province_id==36)	$data6=$v;
				if($v->province_id==37)	$data7=$v;
				if($v->province_id==35)	$data8=$v;
			}
			array_push($data['data'],$data6,$data5,$data7,$data1,$data8,$data2,$data3,$data4);
		}else if($data['area']==9){
			// [0] => ชัยภูมิ
			// [1] => นครราชสีมา
			// [2] => บุรีรัมย์
			// [3] => สุรินทร์
			foreach ($json_data[2]->provinces as $k => $v) {
				if($v->province_id==25)	$data1=$v;
				if($v->province_id==19)	$data2=$v;
				if($v->province_id==20)	$data3=$v;
				if($v->province_id==21)	$data4=$v;
			}
			array_push($data['data'],$data1,$data2,$data3,$data4);
		}else if($data['area']==10){
			// [0] => ยโสธร
			// [1] => ศรีสะเกษ
			// [2] => อำนาจเจริญ
			// [3] => อุบลราชธานี
			foreach ($json_data[2]->provinces as $k => $v) {
				if($v->province_id==24)	$data1=$v;
				if($v->province_id==22)	$data2=$v;
				if($v->province_id==26)	$data3=$v;
				if($v->province_id==23)	$data4=$v;
			}
			array_push($data['data'],$data1,$data2,$data3,$data4);
		}else if($data['area']==11){
			// [0] => กระบี่
			// [1] => ชุมพร
			// [2] => นครศรีธรรมราช
			// [3] => พังงา
			// [4] => ภูเก็ต
			// [5] => ระนอง
			// [6] => สุราษฎร์ธานี
			foreach ($json_data[5]->provinces as $k => $v) {
				if($v->province_id==69)	$data1=$v;
				if($v->province_id==63)	$data2=$v;
				if($v->province_id==67)	$data3=$v;
				if($v->province_id==64)	$data4=$v;
				if($v->province_id==65)	$data5=$v;
				if($v->province_id==66)	$data6=$v;
				if($v->province_id==68)	$data7=$v;
			}
			array_push($data['data'],$data4,$data1,$data2,$data5,$data6,$data7,$data3);
		}else if($data['area']==12){
			// [0] => ตรัง
			// [1] => นราธิวาส
			// [2] => ปัตตานี
			// [3] => พัทลุง
			// [4] => ยะลา
			// [5] => สงขลา
			// [6] => สตูล
			foreach ($json_data[5]->provinces as $k => $v) {
				if($v->province_id==73)	$data1=$v;
				if($v->province_id==72)	$data2=$v;
				if($v->province_id==76)	$data3=$v;
				if($v->province_id==74)	$data4=$v;
				if($v->province_id==75)	$data5=$v;
				if($v->province_id==70)	$data6=$v;
				if($v->province_id==71)	$data7=$v;
			}
			array_push($data['data'],$data2,$data3,$data4,$data1,$data5,$data6,$data7);
		}else if($data['area']==13){
			foreach ($json_data[1]->provinces as $k => $v) {
				if($v->province_id==1)	$data1=$v;
			}
			array_push($data['data'],$data1);
		}
		$this->load->view('file_pdf/pdf_text2',$data);
	}
	public function prophecy()
	{
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'PM2.5 Prophecy';
		}else{
			$this->siteinfo['pre_title'] = 'ค่าพยากรณ์ PM2.5 ล่วงหน้า';
		}

		$data = array( 
			"rsStat" 			=> $this->rsStat,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			"_pageLink"			=> 'prophecy'
		);

		$json_data = file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/regionreport');
		$json_data = json_decode($json_data);
		$data['data1']=array();
		$data['data2']=array();
		$data['data3']=array();
		$data['data4']=array();
		$data['data5']=array();
		$data['data6']=array();
		$data['data7']=array();
		$data['data8']=array();
		$data['data9']=array();
		$data['data10']=array();
		$data['data11']=array();
		$data['data12']=array();
		$data['data13']=array();

		// [0] => เชียงราย
		// [1] => เชียงใหม่
		// [2] => น่าน
		// [3] => พะเยา
		// [4] => แพร่
		// [5] => แม่ฮ่องสอน
		// [6] => ลำปาง
		// [7] => ลำพูน
		foreach ($json_data[0]->provinces as $k => $v) {
			if($v->province_id==38)	$data1=$v;
			if($v->province_id==46)	$data2=$v;
			if($v->province_id==40)	$data3=$v;
			if($v->province_id==39)	$data4=$v;
			if($v->province_id==45)	$data5=$v;
			if($v->province_id==43)	$data6=$v;
			if($v->province_id==44)	$data7=$v;
			if($v->province_id==42)	$data8=$v;
		}
		array_push($data['data1'],$data5,$data1,$data6,$data7,$data8,$data2,$data3,$data4);
		// echo '<pre>';
		// print_r($json_data[0]->provinces);
		// print_r($data['data1']);
		// echo '</pre>';
		// exit();

		// [0] => ตาก
		// [1] => พิษณุโลก
		// [2] => เพชรบูรณ์
		// [3] => สุโขทัย
		// [4] => อุตรดิตถ์
		foreach ($json_data[3]->provinces as $k => $v) {
			if($v->province_id==50)	$data1=$v;
		}
		foreach ($json_data[1]->provinces as $k => $v) {
			if($v->province_id==52)	$data2=$v;
			if($v->province_id==54)	$data3=$v;
			if($v->province_id==51)	$data4=$v;
		}
		foreach ($json_data[0]->provinces as $k => $v) {
			if($v->province_id==41)	$data5=$v;
		}
		array_push($data['data2'],$data1,$data2,$data3,$data4,$data5);
		// [0] => กำแพงเพชร
		// [1] => ชัยนาท
		// [2] => นครสวรรค์
		// [3] => พิจิตร
		// [4] => อุทัยธานี
		foreach ($json_data[1]->provinces as $k => $v) {
			if($v->province_id==49)	$data1=$v;
			if($v->province_id==47)	$data2=$v;
			if($v->province_id==53)	$data3=$v;
			if($v->province_id==48)	$data4=$v;
			if($v->province_id==9)	$data5=$v;
		}
		array_push($data['data3'],$data1,$data5,$data2,$data3,$data4);
		// [0] => นครนายก
		// [1] => นนทบุรี
		// [2] => ปทุมธานี
		// [3] => พระนครศรีอยุธยา
		// [4] => ลพบุรี
		// [5] => สระบุรี
		// [6] => สิงห์บุรี
		// [7] => อ่างทอง
		foreach ($json_data[1]->provinces as $k => $v) {
			if($v->province_id==3)	$data1=$v;
			if($v->province_id==4)	$data2=$v;
			if($v->province_id==5)	$data3=$v;
			if($v->province_id==10)	$data4=$v;
			if($v->province_id==7)	$data5=$v;
			if($v->province_id==8)	$data6=$v;
			if($v->province_id==6)	$data7=$v;
			if($v->province_id==17)	$data8=$v;
		}
		array_push($data['data4'],$data8,$data1,$data2,$data3,$data5,$data4,$data6,$data7);
		// [0] => กาญจนบุรี
		// [1] => นครปฐม
		// [2] => ประจวบคีรีขันธ์
		// [3] => เพชรบุรี
		// [4] => เพชรบูรณ์
		// [5] => สมุทรสงคราม
		// [6] => สมุทรสาคร
		// [7] => สุพรรณบุรี
		foreach ($json_data[3]->provinces as $k => $v) {
			if($v->province_id==56)	$data1=$v;
			if($v->province_id==62)	$data2=$v;
			if($v->province_id==61)	$data3=$v;
		}
		foreach ($json_data[1]->provinces as $k => $v) {
			if($v->province_id==54)	$data4=$v;
			if($v->province_id==58)	$data5=$v;
			if($v->province_id==57)	$data6=$v;
			if($v->province_id==60)	$data7=$v;
			if($v->province_id==59)	$data8=$v;
		}
		array_push($data['data5'],$data1,$data5,$data2,$data3,$data4,$data7,$data8,$data6);
		// [0] => ฉะเชิงเทรา
		// [1] => ตราด
		// [2] => ปราจีนบุรี
		// [3] => ระยอง
		// [4] => สมุทรปราการ
		// [5] => สระแก้ว
		foreach ($json_data[4]->provinces as $k => $v) {
			if($v->province_id==16)	$data1=$v;
			if($v->province_id==18)	$data2=$v;
			if($v->province_id==14)	$data3=$v;
			if($v->province_id==12)	$data4=$v;
			if($v->province_id==15)	$data5=$v;
		}
		foreach ($json_data[1]->provinces as $k => $v) {
			if($v->province_id==2)	$data6=$v;
		}
		array_push($data['data6'],$data5,$data3,$data1,$data4,$data6,$data2);
		// [0] => กาฬสินธุ์
		// [1] => ขอนแก่น
		// [2] => มหาสารคาม
		// [3] => ร้อยเอ็ด
		foreach ($json_data[2]->provinces as $k => $v) {
			if($v->province_id==34)	$data1=$v;
			if($v->province_id==28)	$data2=$v;
			if($v->province_id==32)	$data3=$v;
			if($v->province_id==33)	$data4=$v;
		}
		array_push($data['data7'],$data1,$data2,$data3,$data4);
		// [0] => นครพนม
		// [1] => บึงกาฬ
		// [2] => มุกดาหาร
		// [3] => เลย
		// [4] => สกลนคร
		// [5] => หนองคาย
		// [6] => หนองบัวลำภู
		// [7] => อุดรธานี
		foreach ($json_data[2]->provinces as $k => $v) {
			if($v->province_id==30)	$data1=$v;
			if($v->province_id==31)	$data2=$v;
			if($v->province_id==27)	$data3=$v;
			if($v->province_id==29)	$data4=$v;
			if($v->province_id==77)	$data5=$v;
			if($v->province_id==36)	$data6=$v;
			if($v->province_id==37)	$data7=$v;
			if($v->province_id==35)	$data8=$v;
		}
		array_push($data['data8'],$data6,$data5,$data7,$data1,$data8,$data2,$data3,$data4);
		// [0] => ชัยภูมิ
		// [1] => นครราชสีมา
		// [2] => บุรีรัมย์
		// [3] => สุรินทร์
		foreach ($json_data[2]->provinces as $k => $v) {
			if($v->province_id==25)	$data1=$v;
			if($v->province_id==19)	$data2=$v;
			if($v->province_id==20)	$data3=$v;
			if($v->province_id==21)	$data4=$v;
		}
		array_push($data['data9'],$data1,$data2,$data3,$data4);
		// [0] => ยโสธร
		// [1] => ศรีสะเกษ
		// [2] => อำนาจเจริญ
		// [3] => อุบลราชธานี
		foreach ($json_data[2]->provinces as $k => $v) {
			if($v->province_id==24)	$data1=$v;
			if($v->province_id==22)	$data2=$v;
			if($v->province_id==26)	$data3=$v;
			if($v->province_id==23)	$data4=$v;
		}
		array_push($data['data10'],$data1,$data2,$data3,$data4);
		// [0] => กระบี่
		// [1] => ชุมพร
		// [2] => นครศรีธรรมราช
		// [3] => พังงา
		// [4] => ภูเก็ต
		// [5] => ระนอง
		// [6] => สุราษฎร์ธานี
		foreach ($json_data[5]->provinces as $k => $v) {
			if($v->province_id==69)	$data1=$v;
			if($v->province_id==63)	$data2=$v;
			if($v->province_id==67)	$data3=$v;
			if($v->province_id==64)	$data4=$v;
			if($v->province_id==65)	$data5=$v;
			if($v->province_id==66)	$data6=$v;
			if($v->province_id==68)	$data7=$v;
		}
		array_push($data['data11'],$data4,$data1,$data2,$data5,$data6,$data7,$data3);
		// [0] => ตรัง
		// [1] => นราธิวาส
		// [2] => ปัตตานี
		// [3] => พัทลุง
		// [4] => ยะลา
		// [5] => สงขลา
		// [6] => สตูล
		foreach ($json_data[5]->provinces as $k => $v) {
			if($v->province_id==73)	$data1=$v;
			if($v->province_id==72)	$data2=$v;
			if($v->province_id==76)	$data3=$v;
			if($v->province_id==74)	$data4=$v;
			if($v->province_id==75)	$data5=$v;
			if($v->province_id==70)	$data6=$v;
			if($v->province_id==71)	$data7=$v;
		}
		array_push($data['data12'],$data2,$data3,$data4,$data1,$data5,$data6,$data7);
		foreach ($json_data[1]->provinces as $k => $v) {
			if($v->province_id==1)	$data1=$v;
		}
		array_push($data['data13'],$data1);

		$this->load->view('prophecy/prophecy',$data);
	}
	public function prophecy_isoc()
	{
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'PM2.5 Prophecy';
		}else{
			$this->siteinfo['pre_title'] = 'ค่าพยากรณ์ PM2.5 ล่วงหน้า';
		}

		$data = array( 
			"rsStat" 			=> $this->rsStat,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			"_pageLink"			=> 'prophecy'
		);

		$json_data = file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/regionreport');
		$json_data = json_decode($json_data);
		$data['data1']=array();
		$data['data2']=array();
		$data['data3']=array();
		$data['data4']=array();
		$data['data5']=array();
		$data['data6']=array();
		$data['data7']=array();
		$data['data8']=array();
		$data['data9']=array();
		$data['data10']=array();
		$data['data11']=array();
		$data['data12']=array();
		$data['data13']=array();

		// [0] => เชียงราย
		// [1] => เชียงใหม่
		// [2] => น่าน
		// [3] => พะเยา
		// [4] => แพร่
		// [5] => แม่ฮ่องสอน
		// [6] => ลำปาง
		// [7] => ลำพูน
		foreach ($json_data[0]->provinces as $k => $v) {
			if($v->province_id==38)	$data1=$v;
			if($v->province_id==46)	$data2=$v;
			if($v->province_id==40)	$data3=$v;
			if($v->province_id==39)	$data4=$v;
			if($v->province_id==45)	$data5=$v;
			if($v->province_id==43)	$data6=$v;
			if($v->province_id==44)	$data7=$v;
			if($v->province_id==42)	$data8=$v;
		}
		array_push($data['data1'],$data5,$data1,$data6,$data7,$data8,$data2,$data3,$data4);
		// echo '<pre>';
		// print_r($json_data[0]->provinces);
		// print_r($data['data1']);
		// echo '</pre>';
		// exit();

		// [0] => ตาก
		// [1] => พิษณุโลก
		// [2] => เพชรบูรณ์
		// [3] => สุโขทัย
		// [4] => อุตรดิตถ์
		foreach ($json_data[3]->provinces as $k => $v) {
			if($v->province_id==50)	$data1=$v;
		}
		foreach ($json_data[1]->provinces as $k => $v) {
			if($v->province_id==52)	$data2=$v;
			if($v->province_id==54)	$data3=$v;
			if($v->province_id==51)	$data4=$v;
		}
		foreach ($json_data[0]->provinces as $k => $v) {
			if($v->province_id==41)	$data5=$v;
		}
		array_push($data['data2'],$data1,$data2,$data3,$data4,$data5);
		// [0] => กำแพงเพชร
		// [1] => ชัยนาท
		// [2] => นครสวรรค์
		// [3] => พิจิตร
		// [4] => อุทัยธานี
		foreach ($json_data[1]->provinces as $k => $v) {
			if($v->province_id==49)	$data1=$v;
			if($v->province_id==47)	$data2=$v;
			if($v->province_id==53)	$data3=$v;
			if($v->province_id==48)	$data4=$v;
			if($v->province_id==9)	$data5=$v;
		}
		array_push($data['data3'],$data1,$data5,$data2,$data3,$data4);
		// [0] => นครนายก
		// [1] => นนทบุรี
		// [2] => ปทุมธานี
		// [3] => พระนครศรีอยุธยา
		// [4] => ลพบุรี
		// [5] => สระบุรี
		// [6] => สิงห์บุรี
		// [7] => อ่างทอง
		foreach ($json_data[1]->provinces as $k => $v) {
			if($v->province_id==3)	$data1=$v;
			if($v->province_id==4)	$data2=$v;
			if($v->province_id==5)	$data3=$v;
			if($v->province_id==10)	$data4=$v;
			if($v->province_id==7)	$data5=$v;
			if($v->province_id==8)	$data6=$v;
			if($v->province_id==6)	$data7=$v;
			if($v->province_id==17)	$data8=$v;
		}
		array_push($data['data4'],$data8,$data1,$data2,$data3,$data5,$data4,$data6,$data7);
		// [0] => กาญจนบุรี
		// [1] => นครปฐม
		// [2] => ประจวบคีรีขันธ์
		// [3] => เพชรบุรี
		// [4] => เพชรบูรณ์
		// [5] => สมุทรสงคราม
		// [6] => สมุทรสาคร
		// [7] => สุพรรณบุรี
		foreach ($json_data[3]->provinces as $k => $v) {
			if($v->province_id==56)	$data1=$v;
			if($v->province_id==62)	$data2=$v;
			if($v->province_id==61)	$data3=$v;
		}
		foreach ($json_data[1]->provinces as $k => $v) {
			if($v->province_id==54)	$data4=$v;
			if($v->province_id==58)	$data5=$v;
			if($v->province_id==57)	$data6=$v;
			if($v->province_id==60)	$data7=$v;
			if($v->province_id==59)	$data8=$v;
		}
		array_push($data['data5'],$data1,$data5,$data2,$data3,$data4,$data7,$data8,$data6);
		// [0] => ฉะเชิงเทรา
		// [1] => ตราด
		// [2] => ปราจีนบุรี
		// [3] => ระยอง
		// [4] => สมุทรปราการ
		// [5] => สระแก้ว
		foreach ($json_data[4]->provinces as $k => $v) {
			if($v->province_id==16)	$data1=$v;
			if($v->province_id==18)	$data2=$v;
			if($v->province_id==14)	$data3=$v;
			if($v->province_id==12)	$data4=$v;
			if($v->province_id==15)	$data5=$v;
		}
		foreach ($json_data[1]->provinces as $k => $v) {
			if($v->province_id==2)	$data6=$v;
		}
		array_push($data['data6'],$data5,$data3,$data1,$data4,$data6,$data2);
		// [0] => กาฬสินธุ์
		// [1] => ขอนแก่น
		// [2] => มหาสารคาม
		// [3] => ร้อยเอ็ด
		foreach ($json_data[2]->provinces as $k => $v) {
			if($v->province_id==34)	$data1=$v;
			if($v->province_id==28)	$data2=$v;
			if($v->province_id==32)	$data3=$v;
			if($v->province_id==33)	$data4=$v;
		}
		array_push($data['data7'],$data1,$data2,$data3,$data4);
		// [0] => นครพนม
		// [1] => บึงกาฬ
		// [2] => มุกดาหาร
		// [3] => เลย
		// [4] => สกลนคร
		// [5] => หนองคาย
		// [6] => หนองบัวลำภู
		// [7] => อุดรธานี
		foreach ($json_data[2]->provinces as $k => $v) {
			if($v->province_id==30)	$data1=$v;
			if($v->province_id==31)	$data2=$v;
			if($v->province_id==27)	$data3=$v;
			if($v->province_id==29)	$data4=$v;
			if($v->province_id==77)	$data5=$v;
			if($v->province_id==36)	$data6=$v;
			if($v->province_id==37)	$data7=$v;
			if($v->province_id==35)	$data8=$v;
		}
		array_push($data['data8'],$data6,$data5,$data7,$data1,$data8,$data2,$data3,$data4);
		// [0] => ชัยภูมิ
		// [1] => นครราชสีมา
		// [2] => บุรีรัมย์
		// [3] => สุรินทร์
		foreach ($json_data[2]->provinces as $k => $v) {
			if($v->province_id==25)	$data1=$v;
			if($v->province_id==19)	$data2=$v;
			if($v->province_id==20)	$data3=$v;
			if($v->province_id==21)	$data4=$v;
		}
		array_push($data['data9'],$data1,$data2,$data3,$data4);
		// [0] => ยโสธร
		// [1] => ศรีสะเกษ
		// [2] => อำนาจเจริญ
		// [3] => อุบลราชธานี
		foreach ($json_data[2]->provinces as $k => $v) {
			if($v->province_id==24)	$data1=$v;
			if($v->province_id==22)	$data2=$v;
			if($v->province_id==26)	$data3=$v;
			if($v->province_id==23)	$data4=$v;
		}
		array_push($data['data10'],$data1,$data2,$data3,$data4);
		// [0] => กระบี่
		// [1] => ชุมพร
		// [2] => นครศรีธรรมราช
		// [3] => พังงา
		// [4] => ภูเก็ต
		// [5] => ระนอง
		// [6] => สุราษฎร์ธานี
		foreach ($json_data[5]->provinces as $k => $v) {
			if($v->province_id==69)	$data1=$v;
			if($v->province_id==63)	$data2=$v;
			if($v->province_id==67)	$data3=$v;
			if($v->province_id==64)	$data4=$v;
			if($v->province_id==65)	$data5=$v;
			if($v->province_id==66)	$data6=$v;
			if($v->province_id==68)	$data7=$v;
		}
		array_push($data['data11'],$data4,$data1,$data2,$data5,$data6,$data7,$data3);
		// [0] => ตรัง
		// [1] => นราธิวาส
		// [2] => ปัตตานี
		// [3] => พัทลุง
		// [4] => ยะลา
		// [5] => สงขลา
		// [6] => สตูล
		foreach ($json_data[5]->provinces as $k => $v) {
			if($v->province_id==73)	$data1=$v;
			if($v->province_id==72)	$data2=$v;
			if($v->province_id==76)	$data3=$v;
			if($v->province_id==74)	$data4=$v;
			if($v->province_id==75)	$data5=$v;
			if($v->province_id==70)	$data6=$v;
			if($v->province_id==71)	$data7=$v;
		}
		array_push($data['data12'],$data2,$data3,$data4,$data1,$data5,$data6,$data7);
		foreach ($json_data[1]->provinces as $k => $v) {
			if($v->province_id==1)	$data1=$v;
		}
		array_push($data['data13'],$data1);

		$this->load->view('prophecy/prophecy',$data);
	}
	public function pdf_pm25_test()
	{
		$data['area'] = $this->uri->segment(3);
		$time = $this->uri->segment(4);
		$json_data = file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/regionreport');
		$json_data = json_decode($json_data);
		$data['data']=array();
		if($data['area']==1){
			// [0] => เชียงราย
			// [1] => เชียงใหม่
			// [2] => น่าน
			// [3] => พะเยา
			// [4] => แพร่
			// [5] => แม่ฮ่องสอน
			// [6] => ลำปาง
			// [7] => ลำพูน
			foreach ($json_data[0]->provinces as $k => $v) {
				if($v->province_id==38)	$data1=$v;
				if($v->province_id==46)	$data2=$v;
				if($v->province_id==40)	$data3=$v;
				if($v->province_id==39)	$data4=$v;
				if($v->province_id==45)	$data5=$v;
				if($v->province_id==43)	$data6=$v;
				if($v->province_id==44)	$data7=$v;
				if($v->province_id==42)	$data8=$v;
			}
			array_push($data['data'],$data5,$data1,$data6,$data7,$data8,$data2,$data3,$data4);
		}else if($data['area']==2){
			// [0] => ตาก
			// [1] => พิษณุโลก
			// [2] => เพชรบูรณ์
			// [3] => สุโขทัย
			// [4] => อุตรดิตถ์
			foreach ($json_data[3]->provinces as $k => $v) {
				if($v->province_id==50)	$data1=$v;
			}
			foreach ($json_data[1]->provinces as $k => $v) {
				if($v->province_id==52)	$data2=$v;
				if($v->province_id==54)	$data3=$v;
				if($v->province_id==51)	$data4=$v;
			}
			foreach ($json_data[0]->provinces as $k => $v) {
				if($v->province_id==41)	$data5=$v;
			}
			array_push($data['data'],$data1,$data2,$data3,$data4,$data5);
		}else if($data['area']==3){
			// [0] => กำแพงเพชร
			// [1] => ชัยนาท
			// [2] => นครสวรรค์
			// [3] => พิจิตร
			// [4] => อุทัยธานี
			foreach ($json_data[1]->provinces as $k => $v) {
				if($v->province_id==49)	$data1=$v;
				if($v->province_id==47)	$data2=$v;
				if($v->province_id==53)	$data3=$v;
				if($v->province_id==48)	$data4=$v;
				if($v->province_id==9)	$data5=$v;
			}
			array_push($data['data'],$data1,$data5,$data2,$data3,$data4);
		}else if($data['area']==4){
			// [0] => นครนายก
			// [1] => นนทบุรี
			// [2] => ปทุมธานี
			// [3] => พระนครศรีอยุธยา
			// [4] => ลพบุรี
			// [5] => สระบุรี
			// [6] => สิงห์บุรี
			// [7] => อ่างทอง
			foreach ($json_data[1]->provinces as $k => $v) {
				if($v->province_id==3)	$data1=$v;
				if($v->province_id==4)	$data2=$v;
				if($v->province_id==5)	$data3=$v;
				if($v->province_id==10)	$data4=$v;
				if($v->province_id==7)	$data5=$v;
				if($v->province_id==8)	$data6=$v;
				if($v->province_id==6)	$data7=$v;
				if($v->province_id==17)	$data8=$v;
			}
			array_push($data['data'],$data8,$data1,$data2,$data3,$data5,$data4,$data6,$data7);
		}else if($data['area']==5){
			// [0] => กาญจนบุรี
			// [1] => นครปฐม
			// [2] => ประจวบคีรีขันธ์
			// [3] => เพชรบุรี
			// [4] => เพชรบูรณ์
			// [5] => สมุทรสงคราม
			// [6] => สมุทรสาคร
			// [7] => สุพรรณบุรี
			foreach ($json_data[3]->provinces as $k => $v) {
				if($v->province_id==56)	$data1=$v;
				if($v->province_id==62)	$data2=$v;
				if($v->province_id==61)	$data3=$v;
			}
			foreach ($json_data[1]->provinces as $k => $v) {
				if($v->province_id==54)	$data4=$v;
				if($v->province_id==58)	$data5=$v;
				if($v->province_id==57)	$data6=$v;
				if($v->province_id==60)	$data7=$v;
				if($v->province_id==59)	$data8=$v;
			}
			array_push($data['data'],$data1,$data5,$data2,$data3,$data4,$data7,$data8,$data6);
		}else if($data['area']==6){
			// [0] => ฉะเชิงเทรา
			// [1] => ตราด
			// [2] => ปราจีนบุรี
			// [3] => ระยอง
			// [4] => สมุทรปราการ
			// [5] => สระแก้ว
			foreach ($json_data[4]->provinces as $k => $v) {
				if($v->province_id==16)	$data1=$v;
				if($v->province_id==18)	$data2=$v;
				if($v->province_id==14)	$data3=$v;
				if($v->province_id==12)	$data4=$v;
				if($v->province_id==15)	$data5=$v;
			}
			foreach ($json_data[1]->provinces as $k => $v) {
				if($v->province_id==2)	$data6=$v;
			}
			array_push($data['data'],$data5,$data3,$data1,$data4,$data6,$data2);
		}else if($data['area']==7){
			// [0] => กาฬสินธุ์
			// [1] => ขอนแก่น
			// [2] => มหาสารคาม
			// [3] => ร้อยเอ็ด
			foreach ($json_data[2]->provinces as $k => $v) {
				if($v->province_id==34)	$data1=$v;
				if($v->province_id==28)	$data2=$v;
				if($v->province_id==32)	$data3=$v;
				if($v->province_id==33)	$data4=$v;
			}
			array_push($data['data'],$data1,$data2,$data3,$data4);
		}else if($data['area']==8){
			// [0] => นครพนม
			// [1] => บึงกาฬ
			// [2] => มุกดาหาร
			// [3] => เลย
			// [4] => สกลนคร
			// [5] => หนองคาย
			// [6] => หนองบัวลำภู
			// [7] => อุดรธานี
			foreach ($json_data[2]->provinces as $k => $v) {
				if($v->province_id==30)	$data1=$v;
				if($v->province_id==31)	$data2=$v;
				if($v->province_id==27)	$data3=$v;
				if($v->province_id==29)	$data4=$v;
				if($v->province_id==77)	$data5=$v;
				if($v->province_id==36)	$data6=$v;
				if($v->province_id==37)	$data7=$v;
				if($v->province_id==35)	$data8=$v;
			}
			array_push($data['data'],$data6,$data5,$data7,$data1,$data8,$data2,$data3,$data4);
		}else if($data['area']==9){
			// [0] => ชัยภูมิ
			// [1] => นครราชสีมา
			// [2] => บุรีรัมย์
			// [3] => สุรินทร์
			foreach ($json_data[2]->provinces as $k => $v) {
				if($v->province_id==25)	$data1=$v;
				if($v->province_id==19)	$data2=$v;
				if($v->province_id==20)	$data3=$v;
				if($v->province_id==21)	$data4=$v;
			}
			array_push($data['data'],$data1,$data2,$data3,$data4);
		}else if($data['area']==10){
			// [0] => ยโสธร
			// [1] => ศรีสะเกษ
			// [2] => อำนาจเจริญ
			// [3] => อุบลราชธานี
			foreach ($json_data[2]->provinces as $k => $v) {
				if($v->province_id==24)	$data1=$v;
				if($v->province_id==22)	$data2=$v;
				if($v->province_id==26)	$data3=$v;
				if($v->province_id==23)	$data4=$v;
			}
			array_push($data['data'],$data1,$data2,$data3,$data4);
		}else if($data['area']==11){
			// [0] => กระบี่
			// [1] => ชุมพร
			// [2] => นครศรีธรรมราช
			// [3] => พังงา
			// [4] => ภูเก็ต
			// [5] => ระนอง
			// [6] => สุราษฎร์ธานี
			foreach ($json_data[5]->provinces as $k => $v) {
				if($v->province_id==69)	$data1=$v;
				if($v->province_id==63)	$data2=$v;
				if($v->province_id==67)	$data3=$v;
				if($v->province_id==64)	$data4=$v;
				if($v->province_id==65)	$data5=$v;
				if($v->province_id==66)	$data6=$v;
				if($v->province_id==68)	$data7=$v;
			}
			array_push($data['data'],$data4,$data1,$data2,$data5,$data6,$data7,$data3);
		}else if($data['area']==12){
			// [0] => ตรัง
			// [1] => นราธิวาส
			// [2] => ปัตตานี
			// [3] => พัทลุง
			// [4] => ยะลา
			// [5] => สงขลา
			// [6] => สตูล
			foreach ($json_data[5]->provinces as $k => $v) {
				if($v->province_id==73)	$data1=$v;
				if($v->province_id==72)	$data2=$v;
				if($v->province_id==76)	$data3=$v;
				if($v->province_id==74)	$data4=$v;
				if($v->province_id==75)	$data5=$v;
				if($v->province_id==70)	$data6=$v;
				if($v->province_id==71)	$data7=$v;
			}
			array_push($data['data'],$data2,$data3,$data4,$data1,$data5,$data6,$data7);
		}else if($data['area']==13){
			foreach ($json_data[1]->provinces as $k => $v) {
				if($v->province_id==1)	$data1=$v;
			}
			array_push($data['data'],$data1);
		}
		// echo '<pre>';
		// // print_r($data['data']);

		// // $sortdata=array();
		// foreach ($data['data'] as $key => $value) { 
		// // 		array_push($sortdata,$value->province_name_th);
		// 	if(!empty($value->stations)){
		// 		// print_r($data['data']);
		// 		// echo $value->province_name_th.'<br>';
		// 		if(!empty($value->stations)){
		// 			print_r($value->stations);
		// 			foreach ($value->stations as $k => $v) {
						
		// 			}
		// 		}
				
		// 	}
		// }
		// // usort($sortdata,'th_strcoll');
		// // print_r($sortdata);
		// echo '</pre>';
		// exit();
		echo json_encode($data['data']);
	}
	public function create2()
	{
		$json_data = file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/regionreport');
		$json_data = json_decode($json_data);
		$data['data1']=array();
		$data['data2']=array();
		$data['data3']=array();
		$data['data4']=array();
		$data['data5']=array();
		$data['data6']=array();
		$data['data7']=array();
		$data['data8']=array();
		$data['data9']=array();
		$data['data10']=array();
		$data['data11']=array();
		$data['data12']=array();
		$data['data13']=array();
		// [0] => เชียงราย
		// [1] => เชียงใหม่
		// [2] => น่าน
		// [3] => พะเยา
		// [4] => แพร่
		// [5] => แม่ฮ่องสอน
		// [6] => ลำปาง
		// [7] => ลำพูน
		foreach ($json_data[0]->provinces as $k => $v) {
			if($v->province_id==38)	$data1=$v;
			if($v->province_id==46)	$data2=$v;
			if($v->province_id==40)	$data3=$v;
			if($v->province_id==39)	$data4=$v;
			if($v->province_id==45)	$data5=$v;
			if($v->province_id==43)	$data6=$v;
			if($v->province_id==44)	$data7=$v;
			if($v->province_id==42)	$data8=$v;
		}
		array_push($data['data1'],$data5,$data1,$data6,$data7,$data8,$data2,$data3,$data4);
		// [0] => ตาก
		// [1] => พิษณุโลก
		// [2] => เพชรบูรณ์
		// [3] => สุโขทัย
		// [4] => อุตรดิตถ์
		foreach ($json_data[3]->provinces as $k => $v) {
			if($v->province_id==50)	$data1=$v;
		}
		foreach ($json_data[1]->provinces as $k => $v) {
			if($v->province_id==52)	$data2=$v;
			if($v->province_id==54)	$data3=$v;
			if($v->province_id==51)	$data4=$v;
		}
		foreach ($json_data[0]->provinces as $k => $v) {
			if($v->province_id==41)	$data5=$v;
		}
		array_push($data['data2'],$data1,$data2,$data3,$data4,$data5);
		// [0] => กำแพงเพชร
		// [1] => ชัยนาท
		// [2] => นครสวรรค์
		// [3] => พิจิตร
		// [4] => อุทัยธานี
		foreach ($json_data[1]->provinces as $k => $v) {
			if($v->province_id==49)	$data1=$v;
			if($v->province_id==47)	$data2=$v;
			if($v->province_id==53)	$data3=$v;
			if($v->province_id==48)	$data4=$v;
			if($v->province_id==9)	$data5=$v;
		}
		array_push($data['data3'],$data1,$data5,$data2,$data3,$data4);
		// [0] => นครนายก
		// [1] => นนทบุรี
		// [2] => ปทุมธานี
		// [3] => พระนครศรีอยุธยา
		// [4] => ลพบุรี
		// [5] => สระบุรี
		// [6] => สิงห์บุรี
		// [7] => อ่างทอง
		foreach ($json_data[1]->provinces as $k => $v) {
			if($v->province_id==3)	$data1=$v;
			if($v->province_id==4)	$data2=$v;
			if($v->province_id==5)	$data3=$v;
			if($v->province_id==10)	$data4=$v;
			if($v->province_id==7)	$data5=$v;
			if($v->province_id==8)	$data6=$v;
			if($v->province_id==6)	$data7=$v;
			if($v->province_id==17)	$data8=$v;
		}
		array_push($data['data4'],$data8,$data1,$data2,$data3,$data5,$data4,$data6,$data7);
		// [0] => กาญจนบุรี
		// [1] => นครปฐม
		// [2] => ประจวบคีรีขันธ์
		// [3] => เพชรบุรี
		// [4] => เพชรบูรณ์
		// [5] => สมุทรสงคราม
		// [6] => สมุทรสาคร
		// [7] => สุพรรณบุรี
		foreach ($json_data[3]->provinces as $k => $v) {
			if($v->province_id==56)	$data1=$v;
			if($v->province_id==62)	$data2=$v;
			if($v->province_id==61)	$data3=$v;
		}
		foreach ($json_data[1]->provinces as $k => $v) {
			if($v->province_id==54)	$data4=$v;
			if($v->province_id==58)	$data5=$v;
			if($v->province_id==57)	$data6=$v;
			if($v->province_id==60)	$data7=$v;
			if($v->province_id==59)	$data8=$v;
		}
		array_push($data['data5'],$data1,$data5,$data2,$data3,$data4,$data7,$data8,$data6);
		// [0] => ฉะเชิงเทรา
		// [1] => ตราด
		// [2] => ปราจีนบุรี
		// [3] => ระยอง
		// [4] => สมุทรปราการ
		// [5] => สระแก้ว
		foreach ($json_data[4]->provinces as $k => $v) {
			if($v->province_id==16)	$data1=$v;
			if($v->province_id==18)	$data2=$v;
			if($v->province_id==14)	$data3=$v;
			if($v->province_id==12)	$data4=$v;
			if($v->province_id==15)	$data5=$v;
		}
		foreach ($json_data[1]->provinces as $k => $v) {
			if($v->province_id==2)	$data6=$v;
		}
		array_push($data['data6'],$data5,$data3,$data1,$data4,$data6,$data2);
		// [0] => กาฬสินธุ์
		// [1] => ขอนแก่น
		// [2] => มหาสารคาม
		// [3] => ร้อยเอ็ด
		foreach ($json_data[2]->provinces as $k => $v) {
			if($v->province_id==34)	$data1=$v;
			if($v->province_id==28)	$data2=$v;
			if($v->province_id==32)	$data3=$v;
			if($v->province_id==33)	$data4=$v;
		}
		array_push($data['data7'],$data1,$data2,$data3,$data4);
		// [0] => นครพนม
		// [1] => บึงกาฬ
		// [2] => มุกดาหาร
		// [3] => เลย
		// [4] => สกลนคร
		// [5] => หนองคาย
		// [6] => หนองบัวลำภู
		// [7] => อุดรธานี
		foreach ($json_data[2]->provinces as $k => $v) {
			if($v->province_id==30)	$data1=$v;
			if($v->province_id==31)	$data2=$v;
			if($v->province_id==27)	$data3=$v;
			if($v->province_id==29)	$data4=$v;
			if($v->province_id==77)	$data5=$v;
			if($v->province_id==36)	$data6=$v;
			if($v->province_id==37)	$data7=$v;
			if($v->province_id==35)	$data8=$v;
		}
		array_push($data['data8'],$data6,$data5,$data7,$data1,$data8,$data2,$data3,$data4);
		// [0] => ชัยภูมิ
		// [1] => นครราชสีมา
		// [2] => บุรีรัมย์
		// [3] => สุรินทร์
		foreach ($json_data[2]->provinces as $k => $v) {
			if($v->province_id==25)	$data1=$v;
			if($v->province_id==19)	$data2=$v;
			if($v->province_id==20)	$data3=$v;
			if($v->province_id==21)	$data4=$v;
		}
		array_push($data['data9'],$data1,$data2,$data3,$data4);
		// [0] => ยโสธร
		// [1] => ศรีสะเกษ
		// [2] => อำนาจเจริญ
		// [3] => อุบลราชธานี
		foreach ($json_data[2]->provinces as $k => $v) {
			if($v->province_id==24)	$data1=$v;
			if($v->province_id==22)	$data2=$v;
			if($v->province_id==26)	$data3=$v;
			if($v->province_id==23)	$data4=$v;
		}
		array_push($data['data10'],$data1,$data2,$data3,$data4);
		// [0] => กระบี่
		// [1] => ชุมพร
		// [2] => นครศรีธรรมราช
		// [3] => พังงา
		// [4] => ภูเก็ต
		// [5] => ระนอง
		// [6] => สุราษฎร์ธานี
		foreach ($json_data[5]->provinces as $k => $v) {
			if($v->province_id==69)	$data1=$v;
			if($v->province_id==63)	$data2=$v;
			if($v->province_id==67)	$data3=$v;
			if($v->province_id==64)	$data4=$v;
			if($v->province_id==65)	$data5=$v;
			if($v->province_id==66)	$data6=$v;
			if($v->province_id==68)	$data7=$v;
		}
		array_push($data['data11'],$data4,$data1,$data2,$data5,$data6,$data7,$data3);
		// [0] => ตรัง
		// [1] => นราธิวาส
		// [2] => ปัตตานี
		// [3] => พัทลุง
		// [4] => ยะลา
		// [5] => สงขลา
		// [6] => สตูล
		foreach ($json_data[5]->provinces as $k => $v) {
			if($v->province_id==73)	$data1=$v;
			if($v->province_id==72)	$data2=$v;
			if($v->province_id==76)	$data3=$v;
			if($v->province_id==74)	$data4=$v;
			if($v->province_id==75)	$data5=$v;
			if($v->province_id==70)	$data6=$v;
			if($v->province_id==71)	$data7=$v;
		}
		array_push($data['data12'],$data2,$data3,$data4,$data1,$data5,$data6,$data7);
		foreach ($json_data[1]->provinces as $k => $v) {
			if($v->province_id==1)	$data1=$v;
		}
		array_push($data['data13'],$data1);

		$this->load->view('prophecy/prophecy2',$data);
	}
	public function pdf_test()
	{
		// // สร้าง object สำหรับใช้สร้าง pdf 
		$pdf = new PDF2(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// กำหนดรายละเอียดของ pdf
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('CMUCCDC');
		$pdf->SetTitle('รายงานค่ามลพิษทางอากาศ ฝุ่นละอองขนาดเล็ก (PM2.5)');
		$pdf->SetSubject('ReportPM2.5');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
		
		// กำหนดข้อมูลที่จะแสดงในส่วนของ header และ footer
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
		// $pdf->setFooterData(array(0,64,0), array(0,64,128));
		

		// กำหนดรูปแบบของฟอนท์และขนาดฟอนท์ที่ใช้ใน header และ footer
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		
		// กำหนดค่าเริ่มต้นของฟอนท์แบบ monospaced 
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		// กำหนด margins
		$pdf->SetMargins(15, PDF_MARGIN_TOP, 15);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		
		// กำหนดการแบ่งหน้าอัตโนมัติ
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		
		// กำหนดรูปแบบการปรับขนาดของรูปภาพ 
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		ob_start();
		ob_end_flush();
		ob_end_clean();

		$pdf->Output('ReportPM25_TEST_'.date('YmdH').'.pdf', 'I');
	}
	public function nrct_pm25_testall()
	{
		set_time_limit(0);
		$time = $this->uri->segment(3);
		$data=array();
		$now_date = date('Y-m-d');
		$now_date_0 = date('Y-m-d 00:00:00');
		$now_date_full = date('Y-m-d H:i:s');
		$yesterday_date = date('Y-m-d',strtotime("yesterday"));
		$rs_time = '';
		if($time)
		{
			$time_n_1 = sprintf("%'.02d", $time-1);
			$rs_time1 =  $now_date.' '.$time_n_1.':00:00';
			$time_n_2 = sprintf("%'.02d", $time);
			$rs_time2 =  $now_date.' '.$time_n_2.':00:00';
		}
		$data_temp=$this->temp($time);
		//กลาง 112,5356,5067,5324
		$data1=$this->report_model->get_logdata_61(5319,$rs_time1,$rs_time2);
		$data1_1=$this->report_model->get_logdata_61(5319,$now_date_0,$now_date_full);
		if($data1[0]->pm25==null||$data1_1[0]->pm25==null)
		{
			$data1=$this->report_model->get_logdata_61(5315,$rs_time1,$rs_time2);
			$data1_1=$this->report_model->get_logdata_61(5315,$now_date_0,$now_date_full);
		}
		$data2=$this->report_model->get_logdata_61(5356,$rs_time1,$rs_time2);
		$data2_1=$this->report_model->get_logdata_61(5356,$now_date_0,$now_date_full);
		if($data2[0]->pm25==null||$data2_1[0]->pm25==null)
		{
			$data2=$this->report_model->get_logdata_61(6019,$rs_time1,$rs_time2);
			$data2_1=$this->report_model->get_logdata_61(6019,$now_date_0,$now_date_full);
		}
		$data3=$this->report_model->get_logdata_61(5068,$rs_time1,$rs_time2);
		$data3_1=$this->report_model->get_logdata_61(5068,$now_date_0,$now_date_full);
		if($data3[0]->pm25==null||$data3_1[0]->pm25==null)
		{
			$data3=$this->report_model->get_logdata_61(5326,$rs_time1,$rs_time2);
			$data3_1=$this->report_model->get_logdata_61(5326,$now_date_0,$now_date_full);
		}
		$data4=$this->report_model->get_logdata_61(5324,$rs_time1,$rs_time2);
		$data4_1=$this->report_model->get_logdata_61(5324,$now_date_0,$now_date_full);
		if($data4[0]->pm25==null||$data4_1[0]->pm25==null)
		{
			$data4=$this->report_model->get_logdata_61(5380,$rs_time1,$rs_time2);
			$data4_1=$this->report_model->get_logdata_61(5380,$now_date_0,$now_date_full);
		}
		//เหนือ 5281,5051,5212
		$data5=$this->report_model->get_logdata_61(5281,$rs_time1,$rs_time2);
		$data5_1=$this->report_model->get_logdata_61(5281,$now_date_0,$now_date_full);
		if($data5[0]->pm25==null||$data5_1[0]->pm25==null)
		{
			$data5=$this->report_model->get_logdata_61(5262,$rs_time1,$rs_time2);
			$data5_1=$this->report_model->get_logdata_61(5262,$now_date_0,$now_date_full);
		}
		$data6=$this->report_model->get_logdata_61(5051,$rs_time1,$rs_time2);
		$data6_1=$this->report_model->get_logdata_61(5051,$now_date_0,$now_date_full);
		if($data6[0]->pm25==null||$data6_1[0]->pm25==null)
		{
			$data6=$this->report_model->get_logdata_61(4040,$rs_time1,$rs_time2);
			$data6_1=$this->report_model->get_logdata_61(4040,$now_date_0,$now_date_full);
		}
		$data7=$this->report_model->get_logdata_61(5212,$rs_time1,$rs_time2);
		$data7_1=$this->report_model->get_logdata_61(5212,$now_date_0,$now_date_full);
		if($data7[0]->pm25==null||$data7_1[0]->pm25==null)
		{
			$data7=$this->report_model->get_logdata_61(5279,$rs_time1,$rs_time2);
			$data7_1=$this->report_model->get_logdata_61(5279,$now_date_0,$now_date_full);
		}
		//ตะวันออกเฉียงเหนือ 5388,5084
		$data8=$this->report_model->get_logdata_61(5388,$rs_time1,$rs_time2);
		$data8_1=$this->report_model->get_logdata_61(5388,$now_date_0,$now_date_full);
		if($data8[0]->pm25==null||$data8_1[0]->pm25==null)
		{
			$data8=$this->report_model->get_logdata_61(5205,$rs_time1,$rs_time2);
			$data8_1=$this->report_model->get_logdata_61(5205,$now_date_0,$now_date_full);
		}
		$data9=$this->report_model->get_logdata_61(5084,$rs_time1,$rs_time2);
		$data9_1=$this->report_model->get_logdata_61(5084,$now_date_0,$now_date_full);
		if($data9[0]->pm25==null||$data9_1[0]->pm25==null)
		{
			$data9=$this->report_model->get_logdata_61(5078,$rs_time1,$rs_time2);
			$data9_1=$this->report_model->get_logdata_61(5078,$now_date_0,$now_date_full);
		}
		//ใต้ 5352,5152
		$data10=$this->report_model->get_logdata_61(5352,$rs_time1,$rs_time2);
		$data10_1=$this->report_model->get_logdata_61(5352,$now_date_0,$now_date_full);
		if($data10[0]->pm25==null||$data10_1[0]->pm25==null)
		{
			$data10=$this->report_model->get_logdata_61(5070,$rs_time1,$rs_time2);
			$data10_1=$this->report_model->get_logdata_61(5070,$now_date_0,$now_date_full);
		}
		$data11=$this->report_model->get_logdata_61(5152,$rs_time1,$rs_time2);
		$data11_1=$this->report_model->get_logdata_61(5152,$now_date_0,$now_date_full);
		if($data11[0]->pm25==null||$data11_1[0]->pm25==null)
		{
			$data11=$this->report_model->get_logdata_61(5154,$rs_time1,$rs_time2);
			$data11_1=$this->report_model->get_logdata_61(5154,$now_date_0,$now_date_full);
		}
		//ตะวันออก 5344,5342
		$data12=$this->report_model->get_logdata_61(5344,$rs_time1,$rs_time2);
		$data12_1=$this->report_model->get_logdata_61(5344,$now_date_0,$now_date_full);
		// if($data12[0]->pm25==null||$data12_1[0]->pm25==null)
		// {
		// 	$data12=$this->report_model->get_logdata_61(5078,$rs_time1,$rs_time2);
		// 	$data12_1=$this->report_model->get_logdata_61(5078,$now_date_0,$now_date_full);
		// }
		$data13=$this->report_model->get_logdata_61(5342,$rs_time1,$rs_time2);
		$data13_1=$this->report_model->get_logdata_61(5342,$now_date_0,$now_date_full);
		if($data13[0]->pm25==null||$data13_1[0]->pm25==null)
		{
			$data13=$this->report_model->get_logdata_61(5380,$rs_time1,$rs_time2);
			$data13_1=$this->report_model->get_logdata_61(5380,$now_date_0,$now_date_full);
		}
		//ตะวันตก 5047
		$data14=$this->report_model->get_logdata_61(5047,$rs_time1,$rs_time2);
		$data14_1=$this->report_model->get_logdata_61(5047,$now_date_0,$now_date_full);
		// if($data14[0]->pm25==null||$data14_1[0]->pm25==null)
		// {
		// 	$data14=$this->report_model->get_logdata_61(5078,$rs_time1,$rs_time2);
		// 	$data14_1=$this->report_model->get_logdata_61(5078,$now_date_0,$now_date_full);
		// }
		//รวม
		// array_push($data['data'],$data1,$data2,$data3,$data4,$data5,$data6,$data7,$data8,$data9,$data10,$data11,$data12,$data13,$data14); 
		// array_push($data,$data1,$data2,$data3,$data4,$data5,$data6,$data7,$data8,$data9,$data10,$data11,$data12,$data13,$data14,$data_temp); 
		// array_push($data,$data1_1,$data2_1,$data3_1,$data4_1,$data5_1,$data6_1,$data7_1,$data8_1,$data9_1,$data10_1,$data11_1,$data12_1,$data13_1,$data14_1); 
		array_push($data,$data1,$data2,$data3,$data4,$data5,$data6,$data7,$data8,$data9,$data10,$data11,$data12,$data13,$data14,$data_temp,$data1_1,$data2_1,$data3_1,$data4_1,$data5_1,$data6_1,$data7_1,$data8_1,$data9_1,$data10_1,$data11_1,$data12_1,$data13_1,$data14_1); 
		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';
		// exit();

		// if($data['data']!=''){
		if($data!=''){
			// $this->load->view('file_pdf/pdf_nrct',$data);
			echo json_encode($data);
		}else{
			echo 'Error!';
		}
	}
	public function nrct_pm25v7()
	{
		set_time_limit(0);
		$time = $this->uri->segment(3);
		$time_limit = 43200;
		if (!$result = $this->cache->get('report_nrct'.$time)){
			$data = json_decode(file_get_contents('https://www.cmuccdc.org/api/ccdc_2/nrct3/'.$time.'?v='.date('YmdHis')));
			$rs_time = '';
			if($time)
			{
				$time_n_2 = sprintf("%'.02d", $time);
				$rs_time = $time_n_2.':00';
			}
			
			$pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('CMUCCDC');
			$pdf->SetTitle('รายงานค่ามลพิษทางอากาศ ฝุ่นละอองขนาดเล็ก (PM2.5)');
			$pdf->SetSubject('ReportPM2.5');
			$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
			
			// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
			$pdf->setPrintHeader(false);
			$pdf->setPrintFooter(false);

			// $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			// $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			
			$pdf->SetMargins(0);
			$pdf->SetHeaderMargin(0);
			$pdf->SetFooterMargin(0);
			// $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			// $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			
			// $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			$pdf->AddPage();
			// get the current page break margin
			$bMargin = $pdf->getBreakMargin();
			// get current auto-page-break mode
			$auto_page_break = $pdf->getAutoPageBreak();
			// disable auto-page-break
			$pdf->SetAutoPageBreak(false, 0);
			// set bacground image
			// 630*891
			// 840*1188
			$img_file = $time<13?base_url('assets/image_pdf/bg-nrctv3.14_7.jpg?v='.date('YmdHis')):base_url('assets/image_pdf/bg-nrctv3.14_16.jpg?v='.date('YmdHis'));
			// $img_file = base_url('assets/image_pdf/bg-nrctv3_7.jpg?v='.date('YmdHis'));
			$pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
			// restore auto-page-break status
			$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
			// set the starting point for the page content
			$pdf->setPageMark();
			//Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=0, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
			// spartan,spartanmedium,spartansemib,spartanb
			$pdf->SetFont('supermarket', '', 26, '', false);
			$pdf->Cell(34, 17.5,ceil($data->temp), 0, 0, 'R', 0, '', 0, false, 'T', 'B');
			$pdf->Ln();
			// ConvertToThaiDate_l(date('l'))
			//ConvertToThaiDate_m(date('m'))
			$pdf->SetFont('supermarket', '', 20, '', true); 
			$pdf->Cell(40, 10, '', 0, 0, 'R', 0, '', 0, false, 'T', 'B');
			$pdf->Cell(32, 10, 'วัน '.ConvertToThaiDate_l(date('l')), 0, 0, 'R', 0, '', 0, false, 'T', 'B');
			$pdf->Cell(9.75, 10, 'ที่', 0, 0, 'C', 0, '', 0, false, 'T', 'B');
			$pdf->SetFont('spartansemib', '', 20, '', false);
			$pdf->Cell(13, 10, date('j'), 0, 0, 'C', 0, '', 0, false, 'T', 'B');
			$pdf->SetFont('supermarket', '', 20, '', true);
			$pdf->Cell(27, 10, ConvertToThaiDate_m(date('m')), 0, 0, 'C', 0, '', 0, false, 'T', 'B');
			// $pdf->Cell(13, 12, 'พ.ศ.', 1, 0, 'R', 0, '', 0, false, 'T', 'B');
			$pdf->Cell(18, 10, date('Y')+543, 0, 0, 'C', 0, '', 0, false, 'T', 'B');
			$pdf->SetFont('supermarket', '', 22, '', true);
			$pdf->Cell(42, 10.5, $rs_time.' น.', 0, 0, 'C', 0, '', 0, false, 'T', 'B');

			$pdf->Ln();

            $pm25 = $data->pm5281->pm25;
			$pdf->SetFont('spartanb', 'B', ceil($pm25)>99||ceil($pm25)<=0?16:18, '', false);
			$color = color_th(ceil($pm25));
			$pdf->SetTextColor($color[0],$color[1],$color[2]); 
			$pdf->writeHTMLCell(17, 5, 34, 49,ceil($pm25)==0?'N/A':ceil($pm25), 0, 0, 0, true, 'C', false);
            $pm25 = $data->pm5281->daily_pm25;
			$pdf->SetFont('spartanb', 'B', ceil($pm25)>99||ceil($pm25)<=0?12:15, '', false);
			$color = color_th(ceil($pm25));
			$pdf->SetTextColor($color[0],$color[1],$color[2]); 
			$pdf->writeHTMLCell(17, 5, 49, 52,ceil($pm25)==0?'N/A':ceil($pm25), 0, 0, 0, true, 'C', false);

            $pm25 = $data->pm5049->pm25;
			$pdf->SetFont('spartanb', 'B', ceil($pm25)>99||ceil($pm25)<=0?16:18, '', false);
			$color = color_th(ceil($pm25));
			$pdf->SetTextColor($color[0],$color[1],$color[2]); 
			$pdf->writeHTMLCell(17, 5, 110, 50,ceil($pm25)==0?'N/A':ceil($pm25), 0, 0, 0, true, 'C', false);
            $pm25 = $data->pm5049->daily_pm25;
			$pdf->SetFont('spartanb', 'B', ceil($pm25)>99||ceil($pm25)<=0?12:15, '', false);
			$color = color_th(ceil($pm25));
			$pdf->SetTextColor($color[0],$color[1],$color[2]); 
			$pdf->writeHTMLCell(17, 5, 125, 53,ceil($pm25)==0?'N/A':ceil($pm25), 0, 0, 0, true, 'C', false);

			$pdf->Ln();

            $pm25 = $data->pm5212->pm25;
			$pdf->SetFont('spartanb', 'B', ceil($pm25)>99||ceil($pm25)<=0?16:18, '', false);
			$color = color_th(ceil($pm25));
			$pdf->SetTextColor($color[0],$color[1],$color[2]); 
			$pdf->writeHTMLCell(17, 5, 25.5, 78,ceil($pm25)==0?'N/A':ceil($pm25), 0, 0, 0, true, 'C', false);
            $pm25 = $data->pm5212->daily_pm25;
			$pdf->SetFont('spartanb', 'B', ceil($pm25)>99||ceil($pm25)<=0?12:15, '', false);
			$color = color_th(ceil($pm25));
			$pdf->SetTextColor($color[0],$color[1],$color[2]); 
			$pdf->writeHTMLCell(17, 5, 40, 81,ceil($pm25)==0?'N/A':ceil($pm25), 0, 0, 0, true, 'C', false);
			//pm5084 -> pm5078
            $pm25 = $data->pm5078->pm25;
			$pdf->SetFont('spartanb', 'B', ceil($pm25)>99||ceil($pm25)<=0?16:18, '', false);
			$color = color_th(ceil($pm25));
			$pdf->SetTextColor($color[0],$color[1],$color[2]); 
			$pdf->writeHTMLCell(17, 5, 150.5, 63,ceil($pm25)==0?'N/A':ceil($pm25), 0, 0, 0, true, 'C', false);
            $pm25 = $data->pm5078->daily_pm25;
			$pdf->SetFont('spartanb', 'B', ceil($pm25)>99||ceil($pm25)<=0?12:15, '', false);
			$color = color_th(ceil($pm25));
			$pdf->SetTextColor($color[0],$color[1],$color[2]); 
			$pdf->writeHTMLCell(17, 5, 166, 66,ceil($pm25)==0?'N/A':ceil($pm25), 0, 0, 0, true, 'C', false);

			$pdf->Ln();

            $pm25 = $data->pm5047->pm25;
			$pdf->SetFont('spartanb', 'B', ceil($pm25)>99||ceil($pm25)<=0?16:18, '', false);
			$color = color_th(ceil($pm25));
			$pdf->SetTextColor($color[0],$color[1],$color[2]); 
			$pdf->writeHTMLCell(17, 5, 27.5, 101.5,ceil($pm25)==0?'N/A':ceil($pm25), 0, 0, 0, true, 'C', false);
            $pm25 = $data->pm5047->daily_pm25;
			$pdf->SetFont('spartanb', 'B', ceil($pm25)>99||ceil($pm25)<=0?12:15, '', false);
			$color = color_th(ceil($pm25));
			$pdf->SetTextColor($color[0],$color[1],$color[2]); 
			$pdf->writeHTMLCell(17, 5, 42, 105,ceil($pm25)==0?'N/A':ceil($pm25), 0, 0, 0, true, 'C', false);

            $pm25 = $data->pm5068->pm25;
			$pdf->SetFont('spartanb', 'B', ceil($pm25)>99||ceil($pm25)<=0?16:18, '', false);
			$color = color_th(ceil($pm25));
			$pdf->SetTextColor($color[0],$color[1],$color[2]); 
			$pdf->writeHTMLCell(17, 5, 86, 88,ceil($pm25)==0?'N/A':ceil($pm25), 0, 0, 0, true, 'C', false);
            $pm25 = $data->pm5068->daily_pm25;
			$pdf->SetFont('spartanb', 'B', ceil($pm25)>99||ceil($pm25)<=0?12:15, '', false);
			$color = color_th(ceil($pm25));
			$pdf->SetTextColor($color[0],$color[1],$color[2]); 
			$pdf->writeHTMLCell(17, 5, 101.5, 91,ceil($pm25)==0?'N/A':ceil($pm25), 0, 0, 0, true, 'C', false);
			
            $pm25 = $data->pm5388->pm25;
			$pdf->SetFont('spartanb', 'B', ceil($pm25)>99||ceil($pm25)<=0?16:18, '', false);
			$color = color_th(ceil($pm25));
			$pdf->SetTextColor($color[0],$color[1],$color[2]); 
			$pdf->writeHTMLCell(17, 5, 169.5, 90,ceil($pm25)==0?'N/A':ceil($pm25), 0, 0, 0, true, 'C', false);
            $pm25 = $data->pm5388->daily_pm25;
			$pdf->SetFont('spartanb', 'B', ceil($pm25)>99||ceil($pm25)<=0?12:15, '', false);
			$color = color_th(ceil($pm25));
			$pdf->SetTextColor($color[0],$color[1],$color[2]); 
			$pdf->writeHTMLCell(17, 5, 185, 93,ceil($pm25)==0?'N/A':ceil($pm25), 0, 0, 0, true, 'C', false);

			$pdf->Ln();

            $pm25 = $data->pm5315->pm25;
			$pdf->SetFont('spartanb', 'B', ceil($pm25)>99||ceil($pm25)<=0?16:18, '', false);
			$color = color_th(ceil($pm25));
			$pdf->SetTextColor($color[0],$color[1],$color[2]); 
			$pdf->writeHTMLCell(17, 5, 14.5, 129.5,ceil($pm25)==0?'N/A':ceil($pm25), 0, 0, 0, true, 'C', false);
            $pm25 = $data->pm5315->daily_pm25;
			$pdf->SetFont('spartanb', 'B', ceil($pm25)>99||ceil($pm25)<=0?12:15, '', false);
			$color = color_th(ceil($pm25));
			$pdf->SetTextColor($color[0],$color[1],$color[2]); 
			$pdf->writeHTMLCell(17, 5, 28.5, 133,ceil($pm25)==0?'N/A':ceil($pm25), 0, 0, 0, true, 'C', false);

            $pm25 = $data->pm5356->pm25;
			$pdf->SetFont('spartanb', 'B', ceil($pm25)>99||ceil($pm25)<=0?16:18, '', false);
			$color = color_th(ceil($pm25));
			$pdf->SetTextColor($color[0],$color[1],$color[2]); 
			$pdf->writeHTMLCell(17, 5, 107.5, 108,ceil($pm25)==0?'N/A':ceil($pm25), 0, 0, 0, true, 'C', false);
            $pm25 = $data->pm5356->daily_pm25;
			$pdf->SetFont('spartanb', 'B', ceil($pm25)>99||ceil($pm25)<=0?12:15, '', false);
			$color = color_th(ceil($pm25));
			$pdf->SetTextColor($color[0],$color[1],$color[2]); 
			$pdf->writeHTMLCell(17, 5, 122.5, 111,ceil($pm25)==0?'N/A':ceil($pm25), 0, 0, 0, true, 'C', false);

			$pdf->Ln();

            $pm25 = $data->pm5324->pm25;
			$pdf->SetFont('spartanb', 'B', ceil($pm25)>99||ceil($pm25)<=0?16:18, '', false);
			$color = color_th(ceil($pm25));
			$pdf->SetTextColor($color[0],$color[1],$color[2]); 
			$pdf->writeHTMLCell(17, 5, 33.5, 157.5,ceil($pm25)==0?'N/A':ceil($pm25), 0, 0, 0, true, 'C', false);
            $pm25 = $data->pm5324->daily_pm25;
			$pdf->SetFont('spartanb', 'B', ceil($pm25)>99||ceil($pm25)<=0?12:15, '', false);
			$color = color_th(ceil($pm25));
			$pdf->SetTextColor($color[0],$color[1],$color[2]); 
			$pdf->writeHTMLCell(17, 5, 48.5, 160,ceil($pm25)==0?'N/A':ceil($pm25), 0, 0, 0, true, 'C', false);
			
            $pm25 = $data->pm5344->pm25;
			$pdf->SetFont('spartanb', 'B', ceil($pm25)>99||ceil($pm25)<=0?16:18, '', false);
			$color = color_th(ceil($pm25));
			$pdf->SetTextColor($color[0],$color[1],$color[2]); 
			$pdf->writeHTMLCell(17, 5, 169, 128,ceil($pm25)==0?'N/A':ceil($pm25), 0, 0, 0, true, 'C', false);
            $pm25 = $data->pm5344->daily_pm25;
			$pdf->SetFont('spartanb', 'B', ceil($pm25)>99||ceil($pm25)<=0?12:15, '', false);
			$color = color_th(ceil($pm25));
			$pdf->SetTextColor($color[0],$color[1],$color[2]); 
			$pdf->writeHTMLCell(17, 5, 183.5, 132,ceil($pm25)==0?'N/A':ceil($pm25), 0, 0, 0, true, 'C', false);

			$pdf->Ln();

            $pm25 = $data->pm5342->pm25;
			$pdf->SetFont('spartanb', 'B', ceil($pm25)>99||ceil($pm25)<=0?16:18, '', false);
			$color = color_th(ceil($pm25));
			$pdf->SetTextColor($color[0],$color[1],$color[2]); 
			$pdf->writeHTMLCell(17, 5, 121, 153.5,ceil($pm25)==0?'N/A':ceil($pm25), 0, 0, 0, true, 'C', false);
            $pm25 = $data->pm5342->daily_pm25;
			$pdf->SetFont('spartanb', 'B', ceil($pm25)>99||ceil($pm25)<=0?12:15, '', false);
			$color = color_th(ceil($pm25));
			$pdf->SetTextColor($color[0],$color[1],$color[2]); 
			$pdf->writeHTMLCell(17, 5, 135.5, 157.5,ceil($pm25)==0?'N/A':ceil($pm25), 0, 0, 0, true, 'C', false);

			$pdf->Ln();
			//pm5152 -> pm5154
            $pm25 = $data->pm5154->pm25;
			$pdf->SetFont('spartanb', 'B', ceil($pm25)>99||ceil($pm25)<=0?16:18, '', false);
			$color = color_th(ceil($pm25));
			$pdf->SetTextColor($color[0],$color[1],$color[2]);
			$pdf->writeHTMLCell(17, 5, 26, 188,ceil($pm25)==0?'N/A':ceil($pm25), 0, 0, 0, true, 'C', false);
            $pm25 = $data->pm5154->daily_pm25;
			$pdf->SetFont('spartanb', 'B', ceil($pm25)>99||ceil($pm25)<=0?12:15, '', false);
			$color = color_th(ceil($pm25));
			$pdf->SetTextColor($color[0],$color[1],$color[2]);
			$pdf->writeHTMLCell(17, 5, 40.5, 191.5,ceil($pm25)==0?'N/A':ceil($pm25), 0, 0, 0, true, 'C', false);

            $pm25 = $data->pm5352->pm25;
			$pdf->SetFont('spartanb', 'B', ceil($pm25)>99||ceil($pm25)<=0?16:18, '', false);
			$color = color_th(ceil($pm25));
			$pdf->SetTextColor($color[0],$color[1],$color[2]); 
			$pdf->writeHTMLCell(17, 5, 96.5, 180.5,ceil($pm25)==0?'N/A':ceil($pm25), 0, 0, 0, true, 'C', false);
            $pm25 = $data->pm5352->daily_pm25;
			$pdf->SetFont('spartanb', 'B', ceil($pm25)>99||ceil($pm25)<=0?12:15, '', false);
			$color = color_th(ceil($pm25));
			$pdf->SetTextColor($color[0],$color[1],$color[2]); 
			$pdf->writeHTMLCell(17, 5, 111, 184,ceil($pm25)==0?'N/A':ceil($pm25), 0, 0, 0, true, 'C', false);
		
			ob_start();
			ob_end_flush();
			ob_end_clean();

			// $pdf->Output('ReportPM25_NRCT_'.date('Ymd').$time.'.pdf', 'I');
			if($data){
				$this->cache->save('report_nrct'.$time, $pdf->Output('ReportPM25_NRCT_'.date('Ymd').$time.'.pdf', 'I'), $time_limit);
			}
			redirect(base_url('report/nrct_pm25v7/'.$time));
		}
		echo $result;
	}
	public function daily_report()
	{
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'Daily report (NRCT)';
		}else{
			$this->siteinfo['pre_title'] = 'รายงานประจำวัน (NRCT)';
		}

		$data = array( 
			"rsStat" 			=> $this->rsStat,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			"_pageLink"			=> 'reportNrct'
		);

		$this->load->view('prophecy/daily_report',$data);
	}
	public function daily_report2()
	{
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'Daily report (NRCT)';
		}else{
			$this->siteinfo['pre_title'] = 'รายงานประจำวัน (NRCT)';
		}

		$qid = $this->uri->segment(3);
		
		if($qid!=null){
			$qid = $this->uri->segment(3);
			$ar_info = array(
				'm'		=> ConvertToThaiDateMonth(date('Y-m-d'),0),
				't'		=> ($qid<10? '0'.$qid:$qid).":00 น.",
				'd'		=> (date('d')*1),
				'm'		=> ConvertToThaiDateMonth(date('Y-m-d'),0),
				'd2'	=> ConvertToThaiDateHeader(date('Y-m-d')).' ที่',
				'temp'	=> ceil($this->temp())
			);
			
			$ar_list = array(
				5281=>null, 5264=>null, 5263=>null, 5265=>null, 5266=>null, 5267=>null,
				5212=>null, 5614=>null, 5615=>null, 5616=>null, 5618=>null, 5278=>null,
				5047=>null, 5031=>null, 5032=>null, 5046=>null, 5399=>null, 5428=>null,
				5315=>null, 5361=>null, 5062=>null, 6008=>null, 110=>null, 5242=>null,
				5324=>null, 5291=>null, 5323=>null, 5338=>null, 5337=>null, 5638=>null,
				5152=>null, 5313=>null,
				5068=>null, 5635=>null, 5636=>null, 5067=>null, 5377=>null, 5378=>null,
				5356=>null, 6000=>null, 6019=>null,
				5049=>null, 5405=>null, 5688=>null, 5677=>null, 5676=>null, 5052=>null,
				5084=>null, 5078=>null, 5077=>null, 5076=>null, 5293=>null, 5295=>null,
				5388=>null, 5643=>null, 5202=>null, 5205=>null, 5200=>null, 5198=>null,
				5344=>null, 5318=>null, 5580=>null,
				5342=>null, 5380=>null,
				5352=>null, 5417=>null, 5305=>null, 5070=>null, 5056=>null, 5055=>null
			);
			$qid = ($qid<10? '0'.$qid:$qid);
			$uri = 'https://www-old.cmuccdc.org/assets/api/haze/pwa/json/temp/'.date('Ymd').$qid.'_stations.json';
			
			
			$stations = json_decode(file_get_contents($uri));
			
			foreach($stations as $item){
				if (array_key_exists($item->id, $ar_list)){
					$ar_list[$item->id] = $item;
				}
			}

			$data = array( 
				"rsStat" 			=> $this->rsStat,
				"_lang" 			=> $this->s_lang,
				"_pmType" 			=> $this->pmType,
				"siteInfo" 			=> $this->siteinfo,
				'ar_info'			=> $ar_info,
				'ar_list'			=> $ar_list,
				"_pageLink"			=> 'reportNrct'
			);

			$this->load->view('prophecy/daily_report2',$data);
		}else{ redirect(base_url());}
	}
	function temp()
	{
		$uri = 'http://api.openweathermap.org/data/2.5/weather?q=bangkok&appid=a8219f8dc98e941510ed5403f9a364be&units=metric';
		$weather = json_decode(file_get_contents($uri));
		if($weather){
			return ceil($weather->main->temp);
		}
	}
	public function pdf_pm25_2021_1p()
	{
		$data['area'] = $this->uri->segment(3);
		$time = $this->uri->segment(4);
		$data['data'] = json_decode(file_get_contents('https://www.cmuccdc.org/api/ccdc_2/healthzone_podd/'.$data['area']));
		$data['index_all'] = end($data['data']);
		$this->load->view('file_pdf/pdf_text_podd',$data);
	}
	public function pdf_pm25_2021_2p()
	{
		$data['area'] = $this->uri->segment(3);
		$time = $this->uri->segment(4);
		$data['data'] = json_decode(file_get_contents('https://www.cmuccdc.org/api/ccdc_2/healthzone_podd/'.$data['area']));
		$data['index_all'] = end($data['data']);
		$this->load->view('file_pdf/pdf_text_podd2',$data);
	}
	public function pdf_2021()
	{
		$data['area'] = $this->uri->segment(3);
		$index = json_decode(file_get_contents('https://www.cmuccdc.org/api/ccdc_2/count_healthzone_podd/'.$data['area']));
		// // สร้าง object สำหรับใช้สร้าง pdf 
		$pdf = new PDF2(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// กำหนดรายละเอียดของ pdf
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('CMUCCDC');
		$pdf->SetTitle('รายงานค่ามลพิษทางอากาศ ฝุ่นละอองขนาดเล็ก (PM2.5)');
		$pdf->SetSubject('ReportPM2.5');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

		//font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		//header
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		
		//footer
		// $pdf->setPrintFooter(false);
		// $pdf->SetFooterMargin(0);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		
		//margin
		$pdf->SetMargins(15, 35, 15);
		
		//next page
		$pdf->SetAutoPageBreak(TRUE, 62.5);
		
		// กำหนดรูปแบบการปรับขนาดของรูปภาพ 
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// // -- set new background ---
		// // get the current page break margin
		// $bMargin = $pdf->getBreakMargin();
		// // get current auto-page-break mode
		// $auto_page_break = $pdf->getAutoPageBreak();
		// // disable auto-page-break
		// $pdf->SetAutoPageBreak(false, 0);
		// // set bacground image
		// $img_file = base_url('assets/image_pdf/podd/bg-aqi.jpg');
		// $pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
		// // restore auto-page-break status
		// $pdf->SetAutoPageBreak($auto_page_break, $bMargin);
		// // set the starting point for the page content
		// $pdf->setPageMark();
		

		$pdf->SetFont('thsarabunnew', '', 14, '', true);
		$pdf->AddPage();

		if($data['area']==1){
			$pdf->Image(base_url('uploads/reportpm25/report_podd.png?v='.date('YmdHis')), 15, 44, 180, 180, 'PNG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else if($data['area']==2){
			$pdf->Image(base_url('uploads/reportpm25/report2.jpg?v='.date('YmdHis')), 15, 44, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else if($data['area']==3){
			$pdf->Image(base_url('uploads/reportpm25/report3.jpg?v='.date('YmdHis')), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else if($data['area']==4){
			$pdf->Image(base_url('uploads/reportpm25/report4.jpg?v='.date('YmdHis')), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else if($data['area']==5){
			$pdf->Image(base_url('uploads/reportpm25/report5.jpg?v='.date('YmdHis')), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else if($data['area']==6){
			$pdf->Image(base_url('uploads/reportpm25/report6.jpg?v='.date('YmdHis')), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else if($data['area']==7){
			$pdf->Image(base_url('uploads/reportpm25/report7.jpg?v='.date('YmdHis')), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else if($data['area']==8){
			$pdf->Image(base_url('uploads/reportpm25/report8.jpg?v='.date('YmdHis')), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else if($data['area']==9){
			$pdf->Image(base_url('uploads/reportpm25/report9.jpg?v='.date('YmdHis')), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else if($data['area']==10){
			$pdf->Image(base_url('uploads/reportpm25/report10.jpg?v='.date('YmdHis')), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else if($data['area']==11){
			$pdf->Image(base_url('uploads/reportpm25/report11.jpg?v='.date('YmdHis')), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else if($data['area']==12){
			$pdf->Image(base_url('uploads/reportpm25/report12.jpg?v='.date('YmdHis')), 15, 51, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}else{
			$pdf->Image(base_url('uploads/reportpm25/report13.jpg?v='.date('YmdHis')), 15, 15, 180, 180, 'JPG', '', '', false, 300, '', false, false, 0, true, false, false);
		}
		$pdf->Ln();
		// $pdf->Cell(180, 151,'ที่มา: https://www.cmuccdc.org/prophecy', 0, 0, 'R', 0, '', 0, false, 'T', 'B');
		$html = file_get_contents(base_url('report/pdf_pm25_2021_1p/'.$data['area']));
		$pdf->writeHTML($html, true, false, true, false, '');

		if($index>=14){
			// กำหนดการแบ่งหน้าอัตโนมัติ
			// $pdf->SetAutoPageBreak(TRUE, 29);
			$pdf->AddPage();
			$html = file_get_contents(base_url('report/pdf_pm25_2021_2p/'.$data['area']));
			$pdf->writeHTML($html, true, false, true, false, '');
		}
		ob_start();
		ob_end_flush();
		ob_end_clean();

		$pdf->Output('ReportPM25_TEST_'.date('YmdHis').'_'.$data['area'].'.pdf', 'I');
	}
	public function map_podd()
	{
		$data['area'] = $this->uri->segment(3);
		$this->load->view('prophecy/map_podd',$data);
	}
	public function cmu_report()
	{
		if($this->s_lang=="english"){
			$this->siteinfo['pre_title'] = 'Daily report (CMU)';
		}else{
			$this->siteinfo['pre_title'] = 'รายงานประจำวัน มช.';
		}

		$data = array( 
			"rsStat" 			=> $this->rsStat,
			"_lang" 			=> $this->s_lang,
			"_pmType" 			=> $this->pmType,
			"siteInfo" 			=> $this->siteinfo,
			"_pageLink"			=> 'reportCmu'
		);

		$this->load->view('prophecy/cmu_report',$data);
	}
	
	public function cmu_pm25v5(){
		set_time_limit(0);
        $time = $this->uri->segment(3);
		$time_limit = 1800;


		$data = json_decode(file_get_contents('https://www.cmuccdc.org/api/ccdc_2/cmu4/'.$time.'?v='.date('YmdHis')));
		$rs_time = '';
		if($time)
		{
			$time_n_2 = sprintf("%'.02d", $time);
			$rs_time = $time_n_2.':00';
		}
		if($data){
			
			$pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
				
				$pdf->SetCreator(PDF_CREATOR);
				$pdf->SetAuthor('CMUCCDC');
				$pdf->SetTitle('CMU AIR QUALITY รายงานคุณภาพอากาศ');
				$pdf->SetSubject('ReportPM2.5');
				$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
				
				$pdf->setPrintHeader(false);
				$pdf->setPrintFooter(false);

				$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
				
				$pdf->SetMargins(0);
				$pdf->SetHeaderMargin(0);
				$pdf->SetFooterMargin(0);
				
				$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

				$pdf->AddPage();

				// get the current page break margin
				$bMargin = $pdf->getBreakMargin();
				// get current auto-page-break mode
				$auto_page_break = $pdf->getAutoPageBreak();
				// disable auto-page-break
				$pdf->SetAutoPageBreak(false, 0);
				// set bacground image
				// 630*891
				// 840*1188
				$img_file = base_url('assets/img/cmureport/us/cmu_report_v1.jpg?v='.date('YmdHis'));
				$pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
				// restore auto-page-break status
				$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
				// set the starting point for the page content
				$pdf->setPageMark();
				$pdf->Cell(34, 17.5,'', 0, 0, 'R', 0, '', 0, false, 'T', 'B');
				$pdf->Ln();
				$pdf->SetTextColor(0,0,0); 
				$date_text = date('j');
				$date_text .= ' '.ConvertToThaiDate_m(date('m')).'';

				$pdf->SetFont('rsu_b', '', 34, '', false);
				$pdf->writeHTMLCell(70, 10, 20, 47,($date_text), 0, 0, 0, true, 'R', false);
				$pdf->writeHTMLCell(20, 10, 90, 47,'66', 0, 0, 0, true, 'L', false);
				$pdf->writeHTMLCell(50, 10, 120, 47,$rs_time.' น.', 0, 0, 0, true, 'C', false);
				

				$pdf->Ln();
				$pm25=ceil($data->pm5263->pm25);
				$pdf->SetFont('rsu_b','', 15, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$icon = pin_us($pm25);
				$img_file = base_url('assets/img/cmureport'.$icon.'?v='.date('YmdHis'));
				$pdf->Image($img_file, 61, 75, 22, 22, '', '', '', false, 300, '', false, false, 0);
				$pdf->writeHTMLCell(17, 5, 64, 80,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);

				//สถาบันนโยบายสาธารณะ มช. ต.สุเทพ อ.เมือง จ.เชียงใหม่
				$pdf->Ln();
				$pm25=ceil($data->pm5723->pm25);
				$pdf->SetFont('rsu_b','', 15, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$icon = pin_us($pm25);
				$img_file = base_url('assets/img/cmureport'.$icon.'?v='.date('YmdHis'));
				$pdf->Image($img_file, 45, 65, 22, 22, '', '', '', false, 300, '', false, false, 0);
				$pdf->writeHTMLCell(17, 5, 48, 70,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);

				//คณะมนุษยศาสตร์ มช. (HB5) ต.สุเทพ อ.เมือง จ.เชียงใหม่
				$pdf->Ln();
				$pm25=ceil($data->pm5264->pm25);
				$pdf->SetFont('rsu_b','', 15, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$icon = pin_us($pm25);
				$img_file = base_url('assets/img/cmureport'.$icon.'?v='.date('YmdHis'));
				$pdf->Image($img_file, 37, 77, 22, 22, '', '', '', false, 300, '', false, false, 0);
				$pdf->writeHTMLCell(17, 5, 40, 82,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);

				//คณะสังคมศาสตร์ มช. ต.สุเทพ อ.เมือง จ.เชียงใหม่
				$pdf->Ln();
				$pm25=ceil($data->pm5281->pm25);
				$pdf->SetFont('rsu_b','', 15, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$icon = pin_us($pm25);
				$img_file = base_url('assets/img/cmureport'.$icon.'?v='.date('YmdHis'));
				$pdf->Image($img_file, 25, 83, 22, 22, '', '', '', false, 300, '', false, false, 0);
				$pdf->writeHTMLCell(17, 5, 28, 88,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);

				//คณะการสื่อสารมวลชน มช. ต.สุเทพ อ.เมือง จ.เชียงใหม่
				$pdf->Ln();
				$pm25=ceil($data->pm5267->pm25);
				$pdf->SetFont('rsu_b','', 15, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$icon = pin_us($pm25);
				$img_file = base_url('assets/img/cmureport'.$icon.'?v='.date('YmdHis'));
				$pdf->Image($img_file, 7, 86, 22, 22, '', '', '', false, 300, '', false, false, 0);
				$pdf->writeHTMLCell(17, 5, 10, 91,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);

				//อาคาร 30 ปี คณะวิทยาศาสตร์ ม.เชียงใหม่ (ตึก SCB1 CMU)
				$pdf->Ln();
				$pm25=ceil($data->pm4421->pm25);
				$pdf->SetFont('rsu_b','', 15, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$icon = pin_us($pm25);
				$img_file = base_url('assets/img/cmureport'.$icon.'?v='.date('YmdHis'));
				$pdf->Image($img_file, 61, 96, 22, 22, '', '', '', false, 300, '', false, false, 0);
				$pdf->writeHTMLCell(17, 5, 64, 101,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);

				//อมช
				$pdf->Ln();
				$pm25=ceil($data->pm5266->pm25);
				$pdf->SetFont('rsu_b','', 15, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$icon = pin_us($pm25);
				$img_file = base_url('assets/img/cmureport'.$icon.'?v='.date('YmdHis'));
				$pdf->Image($img_file, 50, 103, 22, 22, '', '', '', false, 300, '', false, false, 0);
				$pdf->writeHTMLCell(17, 5, 53, 108,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);

				//อาคาร 40 ปี คณะวิทยาศาสตร์ มช. ต.สุเทพ อ.เมือง จ.เชียงใหม่
				$pdf->Ln();
				$pm25=ceil($data->pm5265->pm25);
				$pdf->SetFont('rsu_b','', 15, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$icon = pin_us($pm25);
				$img_file = base_url('assets/img/cmureport'.$icon.'?v='.date('YmdHis'));
				$pdf->Image($img_file, 73, 117, 22, 22, '', '', '', false, 300, '', false, false, 0);
				$pdf->writeHTMLCell(17, 5, 76, 122,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);

				//สนามกีฬากลาง มช. ต.สุเทพ อ.เมือง จ.เชียงใหม่
				$pdf->Ln();
				$pm25=ceil($data->pm5262->pm25);
				$pdf->SetFont('rsu_b','', 15, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$icon = pin_us($pm25);
				$img_file = base_url('assets/img/cmureport'.$icon.'?v='.date('YmdHis'));
				$pdf->Image($img_file, 77, 134, 22, 22, '', '', '', false, 300, '', false, false, 0);
				$pdf->writeHTMLCell(17, 5, 80, 139,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);

				//สถาบันวิทย์ เทคโน
				$pdf->Ln();
				$pm25=ceil($data->pm4426->pm25);
				$pdf->SetFont('rsu_b','', 15, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$icon = pin_us($pm25);
				$img_file = base_url('assets/img/cmureport'.$icon.'?v='.date('YmdHis'));
				$pdf->Image($img_file, 66, 140, 22, 22, '', '', '', false, 300, '', false, false, 0);
				$pdf->writeHTMLCell(17, 5, 69, 145,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);

				//คณะบริหารธุรกิจ มช. ต.สุเทพ อ.เมือง จ.เชียงใหม่
				$pdf->Ln();
				$pm25=ceil($data->pm5271->pm25);
				$pdf->SetFont('rsu_b','', 15, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$icon = pin_us($pm25);
				$img_file = base_url('assets/img/cmureport'.$icon.'?v='.date('YmdHis'));
				$pdf->Image($img_file, 53, 145, 22, 22, '', '', '', false, 300, '', false, false, 0);
				$pdf->writeHTMLCell(17, 5, 56, 150,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				
				//โรงอาหารคณะวิศวะ มช.
				$pdf->Ln();
				$pm25=ceil($data->pm4427->pm25);
				$pdf->SetFont('rsu_b','', 15, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$icon = pin_us($pm25);
				$img_file = base_url('assets/img/cmureport'.$icon.'?v='.date('YmdHis'));
				$pdf->Image($img_file, 30, 127, 22, 22, '', '', '', false, 300, '', false, false, 0);
				$pdf->writeHTMLCell(17, 5, 33, 132,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);


				//มช. แคมปัสแม่เหียะ ต.สุเทพ อ.เมือง จ.เชียงใหม่
				$pdf->Ln();
				$pm25=ceil($data->pm13->pm25);
				$pdf->SetFont('rsu_b','', 15, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$icon = pin_us($pm25);
				$img_file = base_url('assets/img/cmureport'.$icon.'?v='.date('YmdHis'));
				$pdf->Image($img_file, 136, 105, 22, 22, '', '', '', false, 300, '', false, false, 0);
				$pdf->writeHTMLCell(17, 5, 139, 110,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);

				//คณะเทคนิคการแพทย์
				$pdf->Ln();
				$pm25=ceil($data->pm6612->pm25);
				$pdf->SetFont('rsu_b','', 15, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$icon = pin_us($pm25);
				$img_file = base_url('assets/img/cmureport'.$icon.'?v='.date('YmdHis'));
				$pdf->Image($img_file, 180, 165, 22, 22, '', '', '', false, 300, '', false, false, 0);
				$pdf->writeHTMLCell(17, 5, 183, 170,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);

				//uniserv

				$pdf->Ln();
				$pm25=ceil($data->pm4439->pm25);
				$pdf->SetFont('rsu_b','', 15, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$icon = pin_us($pm25);
				$img_file = base_url('assets/img/cmureport'.$icon.'?v='.date('YmdHis'));
				$pdf->Image($img_file, 125, 150, 22, 22, '', '', '', false, 300, '', false, false, 0);
				$pdf->writeHTMLCell(17, 5, 128, 155,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);


				ob_start();
				ob_end_flush();
				ob_end_clean();

				if($data){
					//$this->cache->save('report_cmu_version5'.$time, $pdf->Output('ReportPM25_CMU_'.date('Ymd').$time.'.pdf', 'I'), $time_limit);
					$pdf->Output('ReportPM25_CMU_'.date('Ymd').$time.'.pdf', 'I');
				}else{
					redirect(base_url('report/cmu_pm25v5/'));
				}
		}
		
	}
	
	public function cmu_pm25v4(){
		set_time_limit(0);
        $time = $this->uri->segment(3);
		$time_limit = 1800;

		$data = json_decode(file_get_contents('https://www.cmuccdc.org/api/ccdc_2/cmu4/'.$time.'?v='.date('YmdHis')));
		echo '<pre>';
		print_r($data);
		echo '</pre>';
		exit;
		$rs_time = '';
		if($time)
		{
			$time_n_2 = sprintf("%'.02d", $time);
			$rs_time = $time_n_2.':00';
		}
		if($data){
			$pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
				
				$pdf->SetCreator(PDF_CREATOR);
				$pdf->SetAuthor('CMUCCDC');
				$pdf->SetTitle('CMU AIR QUALITY รายงานคุณภาพอากาศ');
				$pdf->SetSubject('ReportPM2.5');
				$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
				
				$pdf->setPrintHeader(false);
				$pdf->setPrintFooter(false);

				$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
				
				$pdf->SetMargins(0);
				$pdf->SetHeaderMargin(0);
				$pdf->SetFooterMargin(0);
				
				$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

				$pdf->AddPage();
				// get the current page break margin
				$bMargin = $pdf->getBreakMargin();
				// get current auto-page-break mode
				$auto_page_break = $pdf->getAutoPageBreak();
				// disable auto-page-break
				$pdf->SetAutoPageBreak(false, 0);
				// set bacground image
				// 630*891
				// 840*1188
				$img_file = base_url('assets/img/cmureport/cmu_report2023_v1.jpg?v='.date('YmdHis'));
				$pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
				// restore auto-page-break status
				$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
				// set the starting point for the page content
				$pdf->setPageMark();
				$pdf->Cell(34, 17.5,'', 0, 0, 'R', 0, '', 0, false, 'T', 'B');
				$pdf->Ln();
				$pdf->SetTextColor(0,0,0); 
				$date_text = date('j');
				$date_text .= ' '.ConvertToThaiDate_m(date('m')).'';
			
				$pdf->SetFont('rsu_b', '', 34, '', false);
				$pdf->writeHTMLCell(70, 10, 20, 47,($date_text), 0, 0, 0, true, 'R', false);
				$pdf->writeHTMLCell(20, 10, 90, 47,'66', 0, 0, 0, true, 'L', false);
				$pdf->writeHTMLCell(50, 10, 120, 47,$rs_time.' น.', 0, 0, 0, true, 'C', false);
				

				//ประตูหน้า มอ.
				$pdf->Ln();
				$pm25=ceil($data->pm5263->pm25);
				$pdf->SetFont('rsu_b','', 15, '', false);
				$color = color_th($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$icon = pin_nrct($pm25);
				$img_file = base_url('assets/img/cmureport/report_icons/'.$icon.'?v='.date('YmdHis'));
				$pdf->Image($img_file, 61, 75, 22, 22, '', '', '', false, 300, '', false, false, 0);
				$pdf->writeHTMLCell(17, 5, 64, 80,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				
				//สถาบันนโยบายสาธารณะ มช. ต.สุเทพ อ.เมือง จ.เชียงใหม่
				$pdf->Ln();
				$pm25=ceil($data->pm5723->pm25);
				$pdf->SetFont('rsu_b','', 15, '', false);
				$color = color_th($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$icon = pin_nrct($pm25);
				$img_file = base_url('assets/img/cmureport/report_icons/'.$icon.'?v='.date('YmdHis'));
				$pdf->Image($img_file, 45, 65, 22, 22, '', '', '', false, 300, '', false, false, 0);
				$pdf->writeHTMLCell(17, 5, 48, 70,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);

				//คณะมนุษยศาสตร์ มช. (HB5) ต.สุเทพ อ.เมือง จ.เชียงใหม่
				$pdf->Ln();
				$pm25=ceil($data->pm5264->pm25);
				$pdf->SetFont('rsu_b','', 15, '', false);
				$color = color_th($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$icon = pin_nrct($pm25);
				$img_file = base_url('assets/img/cmureport/report_icons/'.$icon.'?v='.date('YmdHis'));
				$pdf->Image($img_file, 37, 77, 22, 22, '', '', '', false, 300, '', false, false, 0);
				$pdf->writeHTMLCell(17, 5, 40, 82,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);

				//คณะสังคมศาสตร์ มช. ต.สุเทพ อ.เมือง จ.เชียงใหม่
				$pdf->Ln();
				$pm25=ceil($data->pm5281->pm25);
				$pdf->SetFont('rsu_b','', 15, '', false);
				$color = color_th($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$icon = pin_nrct($pm25);
				$img_file = base_url('assets/img/cmureport/report_icons/'.$icon.'?v='.date('YmdHis'));
				$pdf->Image($img_file, 25, 83, 22, 22, '', '', '', false, 300, '', false, false, 0);
				$pdf->writeHTMLCell(17, 5, 28, 88,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);

				//คณะการสื่อสารมวลชน มช. ต.สุเทพ อ.เมือง จ.เชียงใหม่
				$pdf->Ln();
				$pm25=ceil($data->pm5267->pm25);
				$pdf->SetFont('rsu_b','', 15, '', false);
				$color = color_th($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$icon = pin_nrct($pm25);
				$img_file = base_url('assets/img/cmureport/report_icons/'.$icon.'?v='.date('YmdHis'));
				$pdf->Image($img_file, 7, 86, 22, 22, '', '', '', false, 300, '', false, false, 0);
				$pdf->writeHTMLCell(17, 5, 10, 91,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);

				//อาคาร 30 ปี คณะวิทยาศาสตร์ ม.เชียงใหม่ (ตึก SCB1 CMU)
				$pdf->Ln();
				$pm25=ceil($data->pm4421->pm25);
				$pdf->SetFont('rsu_b','', 15, '', false);
				$color = color_th($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$icon = pin_nrct($pm25);
				$img_file = base_url('assets/img/cmureport/report_icons/'.$icon.'?v='.date('YmdHis'));
				$pdf->Image($img_file, 61, 96, 22, 22, '', '', '', false, 300, '', false, false, 0);
				$pdf->writeHTMLCell(17, 5, 64, 101,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);

				//อมช
				$pdf->Ln();
				$pm25=ceil($data->pm5266->pm25);
				$pdf->SetFont('rsu_b','', 15, '', false);
				$color = color_th($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$icon = pin_nrct($pm25);
				$img_file = base_url('assets/img/cmureport/report_icons/'.$icon.'?v='.date('YmdHis'));
				$pdf->Image($img_file, 50, 103, 22, 22, '', '', '', false, 300, '', false, false, 0);
				$pdf->writeHTMLCell(17, 5, 53, 108,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);

				//อาคาร 40 ปี คณะวิทยาศาสตร์ มช. ต.สุเทพ อ.เมือง จ.เชียงใหม่
				$pdf->Ln();
				$pm25=ceil($data->pm5265->pm25);
				$pdf->SetFont('rsu_b','', 15, '', false);
				$color = color_th($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$icon = pin_nrct($pm25);
				$img_file = base_url('assets/img/cmureport/report_icons/'.$icon.'?v='.date('YmdHis'));
				$pdf->Image($img_file, 73, 117, 22, 22, '', '', '', false, 300, '', false, false, 0);
				$pdf->writeHTMLCell(17, 5, 76, 122,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);

				//สนามกีฬากลาง มช. ต.สุเทพ อ.เมือง จ.เชียงใหม่
				$pdf->Ln();
				$pm25=ceil($data->pm5262->pm25);
				$pdf->SetFont('rsu_b','', 15, '', false);
				$color = color_th($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$icon = pin_nrct($pm25);
				$img_file = base_url('assets/img/cmureport/report_icons/'.$icon.'?v='.date('YmdHis'));
				$pdf->Image($img_file, 77, 134, 22, 22, '', '', '', false, 300, '', false, false, 0);
				$pdf->writeHTMLCell(17, 5, 80, 139,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);

				//สถาบันวิทย์ เทคโน
				$pdf->Ln();
				$pm25=ceil($data->pm4426->pm25);
				$pdf->SetFont('rsu_b','', 15, '', false);
				$color = color_th($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$icon = pin_nrct($pm25);
				$img_file = base_url('assets/img/cmureport/report_icons/'.$icon.'?v='.date('YmdHis'));
				$pdf->Image($img_file, 66, 140, 22, 22, '', '', '', false, 300, '', false, false, 0);
				$pdf->writeHTMLCell(17, 5, 69, 145,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);

				//คณะบริหารธุรกิจ มช. ต.สุเทพ อ.เมือง จ.เชียงใหม่
				$pdf->Ln();
				$pm25=ceil($data->pm5271->pm25);
				$pdf->SetFont('rsu_b','', 15, '', false);
				$color = color_th($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$icon = pin_nrct($pm25);
				$img_file = base_url('assets/img/cmureport/report_icons/'.$icon.'?v='.date('YmdHis'));
				$pdf->Image($img_file, 53, 145, 22, 22, '', '', '', false, 300, '', false, false, 0);
				$pdf->writeHTMLCell(17, 5, 56, 150,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				
				//โรงอาหารคณะวิศวะ มช.
				$pdf->Ln();
				$pm25=ceil($data->pm4427->pm25);
				$pdf->SetFont('rsu_b','', 15, '', false);
				$color = color_th($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$icon = pin_nrct($pm25);
				$img_file = base_url('assets/img/cmureport/report_icons/'.$icon.'?v='.date('YmdHis'));
				$pdf->Image($img_file, 30, 127, 22, 22, '', '', '', false, 300, '', false, false, 0);
				$pdf->writeHTMLCell(17, 5, 33, 132,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);


				//มช. แคมปัสแม่เหียะ ต.สุเทพ อ.เมือง จ.เชียงใหม่
				$pdf->Ln();
				$pm25=ceil($data->pm13->pm25);
				$pdf->SetFont('rsu_b','', 15, '', false);
				$color = color_th($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$icon = pin_nrct($pm25);
				$img_file = base_url('assets/img/cmureport/report_icons/'.$icon.'?v='.date('YmdHis'));
				$pdf->Image($img_file, 136, 105, 22, 22, '', '', '', false, 300, '', false, false, 0);
				$pdf->writeHTMLCell(17, 5, 139, 110,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);

				//คณะเทคนิคการแพทย์
				$pdf->Ln();
				$pm25=ceil($data->pm6612->pm25);
				$pdf->SetFont('rsu_b','', 15, '', false);
				$color = color_th($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$icon = pin_nrct($pm25);
				$img_file = base_url('assets/img/cmureport/report_icons/'.$icon.'?v='.date('YmdHis'));
				$pdf->Image($img_file, 180, 165, 22, 22, '', '', '', false, 300, '', false, false, 0);
				$pdf->writeHTMLCell(17, 5, 183, 170,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);

				//uniserv
				$pdf->Ln();
				$pm25=ceil($data->pm4439->pm25);
				$pdf->SetFont('rsu_b','', 15, '', false);
				$color = color_th($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$icon = pin_nrct($pm25);
				$img_file = base_url('assets/img/cmureport/report_icons/'.$icon.'?v='.date('YmdHis'));
				$pdf->Image($img_file, 125, 150, 22, 22, '', '', '', false, 300, '', false, false, 0);
				$pdf->writeHTMLCell(17, 5, 128, 155,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);



				ob_start();
				ob_end_flush();
				ob_end_clean();

				if($data){
					//$this->cache->save('report_cmu_version4'.$time, $pdf->Output('ReportPM25_CMU_'.date('Ymd').$time.'.pdf', 'I'), $time_limit);
					$pdf->Output('ReportPM25_CMU_'.date('Ymd').$time.'.pdf', 'I');
				}else{
					redirect(base_url('report/cmu_pm25v2/'));
				}
		}
		
	}
	public function cmu_pm25v3()
	{
		set_time_limit(0);
        $time = $this->uri->segment(3);
		$time_limit = 1800;
		if (!$result = $this->cache->get('report_cmu'.$time)){
			$data = json_decode(file_get_contents('https://www.cmuccdc.org/api/ccdc_2/cmu3/'.$time.'?v='.date('YmdHis')));
			$rs_time = '';
			if($time)
			{
				$time_n_2 = sprintf("%'.02d", $time);
				$rs_time = $time_n_2.':00';
			}
			if($data){
				$pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
				
				$pdf->SetCreator(PDF_CREATOR);
				$pdf->SetAuthor('CMUCCDC');
				$pdf->SetTitle('CMU AIR QUALITY รายงานคุณภาพอากาศ');
				$pdf->SetSubject('ReportPM2.5');
				$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
				
				$pdf->setPrintHeader(false);
				$pdf->setPrintFooter(false);

				$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
				
				$pdf->SetMargins(0);
				$pdf->SetHeaderMargin(0);
				$pdf->SetFooterMargin(0);
				
				$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

				$pdf->AddPage();
				// get the current page break margin
				$bMargin = $pdf->getBreakMargin();
				// get current auto-page-break mode
				$auto_page_break = $pdf->getAutoPageBreak();
				// disable auto-page-break
				$pdf->SetAutoPageBreak(false, 0);
				// set bacground image
				// 630*891
				// 840*1188
				$img_file = base_url('assets/image_pdf/bg-cmu5.jpg?v='.date('YmdHis'));
				$pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
				// restore auto-page-break status
				$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
				// set the starting point for the page content
				$pdf->setPageMark();
				$pdf->Cell(34, 17.5,'', 0, 0, 'R', 0, '', 0, false, 'T', 'B');
				$pdf->Ln();
				$pdf->SetTextColor(255,255,255); 
				$pdf->SetFont('rsu_light', '', 28, '', false); 
					$pdf->writeHTMLCell(20, 10, 57, 23.5,'วันที่', 0, 0, 0, true, 'C', false);
				$pdf->SetFont('rsu_light', '', 36, '', false);
					$pdf->writeHTMLCell(20, 10, 75, 21,date('j'), 0, 0, 0, true, 'C', false);
				$pdf->SetFont('rsu_light', '', 28, '', false); 
					$pdf->writeHTMLCell(50, 10, 87, 23.5,ConvertToThaiDate_m(date('m')), 0, 0, 0, true, 'C', false);
				$pdf->SetFont('rsu_light', '', 36, '', false);
					$pdf->writeHTMLCell(30, 10, 131, 21,date('Y')+543, 0, 0, 0, true, 'C', false);
				$pdf->SetFont('rsu_light', '', 30, '', false);
					$pdf->writeHTMLCell(50, 10, 161, 23,$rs_time, 0, 0, 0, true, 'C', false);
				$pdf->SetFont('rsu_light', '', 28, '', false);
					$pdf->writeHTMLCell(20, 10, 193, 23.5,'น.', 0, 0, 0, true, 'C', false);

				// pm25
				//หน้า มช.
				$pdf->Ln();
				$pm25=ceil($data->pm5263->pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?18:19, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 65.5, 80,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=ceil($data->pm5263->daily_pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?10:11, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 71.5, 74.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				//คณะมนุษยศาสตร์
				$pm25=ceil($data->pm5264->pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?18:19, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 3.5, 93,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5264->daily_pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?10:11, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 9.5, 87.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				//คณะสังคมศาสตร์
				$pm25=ceil($data->pm5281->pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?18:19, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 3, 125,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=ceil($data->pm5281->daily_pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?10:11, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 9, 119.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				//คณะการสื่อสารมวลชน
				$pm25=ceil($data->pm5267->pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?18:19, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 22.5, 151.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=ceil($data->pm5267->daily_pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?10:11, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 28, 146.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				//อมช
				$pm25=ceil($data->pm5266->pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?18:19, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 48, 132,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=ceil($data->pm5266->daily_pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?10:11, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 54, 126.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				//อาคาร 40 ปี
				$pm25=ceil($data->pm5265->pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?18:19, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 87.5, 97,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=ceil($data->pm5265->daily_pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?10:11, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 93.5, 91.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				//สนามกีฬากลาง
				$pm25=ceil($data->pm5262->pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?18:19, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 89.5, 122,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=ceil($data->pm5262->daily_pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?10:11, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 95.5, 117.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				//คณะบริหารธุรกิจ
				$pm25=!empty(ceil($data->pm109->pm25))?ceil($data->pm109->pm25):ceil($data->pm5271->pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?18:19, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 86.5, 147.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=!empty(ceil($data->pm109->daily_pm25))?ceil($data->pm109->daily_pm25):ceil($data->pm5271->daily_pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?10:11, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 92.5, 142.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				//สำนักบริการวิชาการ
				$pm25=ceil($data->pm5268->pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?18:19, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 134.5, 118.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=ceil($data->pm5268->daily_pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?10:11, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 140.5, 113.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				//โรงพยาบาลมหาราชนครเชียงใหม่
				// $pm25=ceil($data->pm500036->pm25);
				// $pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?18:19, '', false);
				// $color = color_us($pm25);
				// $pdf->SetTextColor($color[0],$color[1],$color[2]); 
				// $pdf->writeHTMLCell(17, 5, 186, 143.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				// $pm25=ceil($data->pm500036->daily_pm25);
				// $pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?10:11, '', false);
				// $color = color_us($pm25);
				// $pdf->SetTextColor($color[0],$color[1],$color[2]); 
				// $pdf->writeHTMLCell(17, 5, 192, 138.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				//สวนดอกปาร์ค
				$pm25=ceil($data->pm5270->pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?18:19, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 158.5, 179,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=ceil($data->pm5270->daily_pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?10:11, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 164.5, 173.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				//อาคารสุจิณโณ
				$pm25=ceil($data->pm5269->pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?18:19, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 187, 185.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=ceil($data->pm5269->daily_pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?10:11, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 192.5, 180,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				//แคมปัส
				$pm25=ceil($data->pm6->pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?18:19, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 36, 198,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=ceil($data->pm6->daily_pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?10:11, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 42, 192.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				//สถาบันวิจัยและพัฒนาพลังงานนครพิงค์
				// $pm25=ceil($data->pm500097->pm25);
				// $pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?18:19, '', false);
				// $color = color_us($pm25);
				// $pdf->SetTextColor($color[0],$color[1],$color[2]); 
				// $pdf->writeHTMLCell(17, 5, 120, 208.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				// $pm25=ceil($data->pm500097->daily_pm25);
				// $pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?10:11, '', false);
				// $color = color_us($pm25);
				// $pdf->SetTextColor($color[0],$color[1],$color[2]); 
				// $pdf->writeHTMLCell(17, 5, 126, 203.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);

				ob_start();
				ob_end_flush();
				ob_end_clean();

				if($data){
					$this->cache->save('report_cmu'.$time, $pdf->Output('ReportPM25_CMU_'.date('Ymd').$time.'.pdf', 'I'), $time_limit);
				}else{
					redirect(base_url('report/cmu_pm25v2/'));
				}
			}
		}
		echo $result;
	}
	public function cmuforcast_pm25()
	{
		set_time_limit(0);
		$time_limit = 1800;
		if (!$result = $this->cache->get('report_cmuforcast')){
			$data = json_decode(file_get_contents('https://www.cmuccdc.org/api/ccdc_2/cmuforcast?v='.date('YmdHis')));
			if($data)
			{
				$pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
				
				$pdf->SetCreator(PDF_CREATOR);
				$pdf->SetAuthor('CMUCCDC');
				$pdf->SetTitle('CMU AIR QUALITY FORECAST พยากรณ์คุณภาพอากาศค่าฝุ่น 17 จังหวัดภาคเหนือ');
				$pdf->SetSubject('ReportPM2.5');
				$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
				
				$pdf->setPrintHeader(false);
				$pdf->setPrintFooter(false);

				$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
				
				$pdf->SetMargins(0);
				$pdf->SetHeaderMargin(0);
				$pdf->SetFooterMargin(0);
				
				$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

				$pdf->AddPage();
				// get the current page break margin
				$bMargin = $pdf->getBreakMargin();
				// get current auto-page-break mode
				$auto_page_break = $pdf->getAutoPageBreak();
				// disable auto-page-break
				$pdf->SetAutoPageBreak(false, 0);
				// set bacground image
				// 630*891
				// 840*1188
				$img_file = base_url('assets/image_pdf/bg-cmuforecast2.jpg?v='.date('YmdHis'));
				$pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
				// restore auto-page-break status
				$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
				// set the starting point for the page content
				$pdf->setPageMark();
				$pdf->Cell(34, 17.5,'', 0, 0, 'R', 0, '', 0, false, 'T', 'B');
				$pdf->Ln();
				$pdf->SetTextColor(0,0,0); 
				$pdf->SetFont('rsu_b', '', 17, '', false); 
					$pdf->writeHTMLCell(30, 10, 76, 30,'วัน'.ConvertToThaiDate_ll(date('l')), 0, 0, 0, true, 'C', false);
				$pdf->SetFont('rsu_light', '', 12, '', false); 
					$pdf->writeHTMLCell(30, 10, 76, 39,date('j').' '.ConvertToThaiDate_mm(date('m')).' '.date('y'), 0, 0, 0, true, 'C', false);

				$pdf->SetTextColor(255,255,255); 
				$pdf->SetFont('rsu_b', '', 16, '', false); 
					$pdf->writeHTMLCell(30, 10, 124, 33,'วัน'.ConvertToThaiDate_ll(date('l', strtotime(date('Ymd').' +1 day'))), 0, 0, 0, true, 'C', false);
				$pdf->SetTextColor(0,0,0); 
				$pdf->SetFont('rsu_light', '', 12, '', false); 
					$pdf->writeHTMLCell(30, 10, 124, 40,date('j',strtotime(date('Ymd').' +1 day')).' '.ConvertToThaiDate_mm(date('m', strtotime(date('Ymd').' +1 day'))).' '.date('y',strtotime(date('Ymd').' +1 day')), 0, 0, 0, true, 'C', false);

				$pdf->SetTextColor(255,255,255); 
				$pdf->SetFont('rsu_b', '', 16, '', false); 
					$pdf->writeHTMLCell(30, 10, 152, 33,'วัน'.ConvertToThaiDate_ll(date('l', strtotime(date('Ymd').' +2 day'))), 0, 0, 0, true, 'C', false);
				$pdf->SetTextColor(0,0,0); 
				$pdf->SetFont('rsu_light', '', 12, '', false); 
					$pdf->writeHTMLCell(30, 10, 152, 40,date('j',strtotime(date('Ymd').' +2 day')).' '.ConvertToThaiDate_mm(date('m', strtotime(date('Ymd').' +2 day'))).' '.date('y',strtotime(date('Ymd').' +2 day')), 0, 0, 0, true, 'C', false);

				$pdf->SetTextColor(255,255,255); 
				$pdf->SetFont('rsu_b', '', 16, '', false); 
					$pdf->writeHTMLCell(30, 10, 179, 33,'วัน'.ConvertToThaiDate_ll(date('l', strtotime(date('Ymd').' +3 day'))), 0, 0, 0, true, 'C', false);
				$pdf->SetTextColor(0,0,0); 
				$pdf->SetFont('rsu_light', '', 12, '', false); 
					$pdf->writeHTMLCell(30, 10, 179, 40,date('j',strtotime(date('Ymd').' +3 day')).' '.ConvertToThaiDate_mm(date('m', strtotime(date('Ymd').' +3 day'))).' '.date('y',strtotime(date('Ymd').' +3 day')), 0, 0, 0, true, 'C', false);

				// เชียงใหม่
				$pdf->Ln();
				$pm25=@ceil($data->pm5264->daily_pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 80.5, 60.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5264->forcast->n1);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 130.5, 62,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5264->forcast->n2);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 158, 62,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5264->forcast->n3);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 185, 62,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				// เชียงราย
				$pdf->Ln();
				$pm25=ceil($data->pm4037->daily_pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 80.5, 67.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm4037->forcast->n1);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 130.5, 69.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm4037->forcast->n2);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 158, 69.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm4037->forcast->n3);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 185, 69.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				// ลำพูน
				$pdf->Ln();
				$pm25=@ceil($data->pm5687->daily_pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 80.5, 75,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5687->forcast->n1);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 130.5, 77,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5687->forcast->n2);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 158, 77,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5687->forcast->n3);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 185, 77,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				// ลำปาง
				$pdf->Ln();
				$pm25=@ceil($data->pm5272->daily_pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 80.5, 82,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5272->forcast->n1);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 130.5, 84,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5272->forcast->n2);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 158, 84,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5272->forcast->n3);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 185, 84,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				// แพร่
				$pdf->Ln();
				$pm25=@ceil($data->pm5006->daily_pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 80.5, 89.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5006->forcast->n1);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 130.5, 91.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5006->forcast->n2);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 158, 91.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5264->forcast->n3);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 185, 91.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				// น่าน
				$pdf->Ln();
				$pm25=@ceil($data->pm5669->daily_pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 80.5, 96.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5669->forcast->n1);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 130.5, 98.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5669->forcast->n2);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 158, 98.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5669->forcast->n3);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 185, 98.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				// พะเยา
				$pdf->Ln();
				$pm25=@ceil($data->pm5052->daily_pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 80.5, 104,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5052->forcast->n1);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 130.5, 105.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5052->forcast->n2);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 158, 105.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5052->forcast->n3);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 185, 105.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				// แม่ฮ่องสอน
				$pdf->Ln();
				$pm25=@ceil($data->pm5026->daily_pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 80.5, 112,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5026->forcast->n1);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 130.5, 112.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5026->forcast->n2);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 158, 112.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5026->forcast->n3);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 185, 112.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				// อุตรดิตถ์
				$pdf->Ln();
				$pm25=@ceil($data->pm5037->daily_pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 80.5, 119.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5037->forcast->n1);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 130.5, 120,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5037->forcast->n2);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 158, 120,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5037->forcast->n3);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 185, 120,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				// ตาก
				$pdf->Ln();
				$pm25=@ceil($data->pm5046->daily_pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 80.5, 126.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5046->forcast->n1);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 130.5, 127,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5046->forcast->n2);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 158, 127,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5046->forcast->n3);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 185, 127,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				// สุโขทัย
				$pdf->Ln();
				$pm25=@ceil($data->pm5410->daily_pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 80.5, 133.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5410->forcast->n1);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 130.5, 134,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5410->forcast->n2);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 158, 134,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5410->forcast->n3);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 185, 134,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				// พิษณุโลก
				$pdf->Ln();
				$pm25=@ceil($data->pm5212->daily_pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 80.5, 140.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5212->forcast->n1);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 130.5, 141,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5212->forcast->n2);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 158, 141,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5212->forcast->n3);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 185, 141,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				// กำแพงเพชร
				$pdf->Ln();
				$pm25=@ceil($data->pm5564->daily_pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 80.5, 147.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5564->forcast->n1);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 130.5, 148,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5564->forcast->n2);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 158, 148,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5564->forcast->n3);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 185, 148,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				// พิจิตร
				$pdf->Ln();
				$pm25=@ceil($data->pm5566->daily_pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 80.5, 155.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5566->forcast->n1);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 130.5, 156,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5566->forcast->n2);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 158, 156,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5566->forcast->n3);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 185, 156,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				// นครสวรรค์
				$pdf->Ln();
				$pm25=@ceil(0);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 80.5, 162.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil(0);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 130.5, 163,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil(0);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 158, 163,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil(0);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 185, 163,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				// เพชรบูรณ์
				$pdf->Ln();
				$pm25=@ceil($data->pm5038->daily_pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 80.5, 169.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5038->forcast->n1);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 130.5, 170,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5038->forcast->n2);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 158, 170,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5038->forcast->n3);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 185, 170,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				// อุทัยธานี
				$pdf->Ln();
				$pm25=@ceil($data->pm5434->daily_pm25);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 80.5, 177,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5434->forcast->n1);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 130.5, 177.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5434->forcast->n2);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 158, 177.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);
				$pm25=@ceil($data->pm5434->forcast->n3);
				$pdf->SetFont('rsu_b','', $pm25>99||$pm25<=0?16:17, '', false);
				$color = color_us($pm25);
				$pdf->SetTextColor($color[0],$color[1],$color[2]); 
				$pdf->writeHTMLCell(17, 5, 185, 177.5,$pm25==0?'N/A':$pm25, 0, 0, 0, true, 'C', false);

				$pdf->SetAutoPageBreak(false, 0);
				$img_file = 'https://thaq.soc.cmu.ac.th/tmp/stn_obs/pm2.5/pm25_all_stn_'.date('YmdH').'-colored-mask.png';
				$pdf->Image($img_file, 8, 213, 43, '', '', '', '', true, 300, '', false, false, 0);

				ob_start();
				ob_end_flush();
				ob_end_clean();
				if($data){
					$this->cache->save('report_cmuforcast', $pdf->Output('ReportPM25_CMUFORCAST_'.date('YmdH').'.pdf', 'I'), $time_limit);
				}else{
					redirect(base_url('report/cmuforcast_pm25/'));
				}
			}
		}
		echo $result;
	}
}
