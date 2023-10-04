<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Line extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('report_model');
		$this->load->helper('jaydai_helper');
		// $this->chk_login();
	}
	function allowed_origin()
	{
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST');
		header("Access-Control-Allow-Headers: X-Requested-With");
    }
	public function chk_login()
	{
		if(!$this->session->userdata('login'))
		{
			$this->session->sess_destroy();
			echo '<script type="text/javascript">'; 
			echo "alert('กรุณาเข้าสู่ระบบใหม่อีกครั้ง');";
			echo "window.location.href='".base_url('login')."'"; 
			echo '</script>';
			exit();
		}
		$this->login=$this->session->userdata('login');
		$this->username = $this->session->userdata('login')[0]->username;
	}	
	public function index()
	{
		echo 'ok';
	}
	public function newText($image, $size, $angle= 0, $x, $y, $color, $font, $text,$align = "left",$border=false,$width=0,$height=0)
	{
		if($align == "center")
		{
			if ($border == true ){
			   imagerectangle($image, $x, $y, $x +$width, $y + $height, $color);
			}
			$bbox = imageftbbox($size, 0, $font, $text);
			// Marcamos el ancho y alto
			$s_width  = $bbox[4];
			$s_height = $bbox[5]; 
		   
			$y = $y + ($height-$s_height)/2;
			$x = $x + ($width-$s_width)/2;
		}
		imagettftext($image, $size, $angle, $x, $y, $color, $font, $text);
	}
	function temp()
	{
		$uri = 'http://api.openweathermap.org/data/2.5/weather?q=bangkok&appid=a8219f8dc98e941510ed5403f9a364be&units=metric';
		$weather = json_decode(file_get_contents($uri));
		if($weather){
			return ceil($weather->main->temp);
		}
	}
	public function pm25()
	{
		$pm25 = $this->uri->segment(3);
		if($pm25<26){
			$type='1';
			$r = 52;
			$g = 57;
			$b = 140;
		}else if($pm25>=26&&$pm25<38){	
			$type='2';
			$r = 8;
			$g = 95;
			$b = 54;
		}else if($pm25>=38&&$pm25<51){	
			$type='3';
			$r = 195;
			$g = 149;
			$b = 45;
		}else if($pm25>=51&&$pm25<91){	
			$type='4';
			$r = 209;
			$g = 87;
			$b = 40;
		}else{							
			$type='5';
			$r = 209;
			$g = 87;
			$b = 40;
		}
		//create-image
		$image = imagecreatefromjpeg(base_url('assets/prophecy/assets/image/aqic/pm25/pmlineoa'.$type.'.jpg?v=1'));
		// $background_color = imagecolorallocate($image, 255, 255, 255);
		$text_color = imagecolorallocate($image, $r, $g, $b);
		$font_path = $_SERVER["DOCUMENT_ROOT"].'/assets/prophecy/assets/font/spartan/Spartan-Bold.ttf';
		$this->newText($image, 110, 0, 80, 180, $text_color, $font_path, $pm25,$align = "center",$border = false, $width = 300, $height = 120);
		header("Content-Type: image/jpeg");
		imagejpeg($image);
		imagedestroy($image);
		exit;
	}
	public function daily_api()
	{
		// ini_set('display_errors', 1);
		// ini_set('display_startup_errors', 1);
		// error_reporting(E_ALL);
		set_time_limit(0);
		$this->allowed_origin();
		$filename = 'https://www.cmuccdc.org/uploads/reportpm25/report_aqic/dailyReport'.(empty($this->uri->segment(3))?date('G'):$this->uri->segment(3)).'.jpg?v='.date('YmdHis');
		
		if(((strtotime(date('YmdH0000')) - @strtotime(get_headers($filename,true)['Last-Modified']))/3600)>=0.5){
			
			if($this->uri->segment(3)){
				if($this->uri->segment(3)<10){
					$date_H = sprintf('%02d', $this->uri->segment(3));
				}else{
					$date_H = $this->uri->segment(3);
				}
			}
			
			//create-image
				if(date('H')<13){
					$image = imagecreatefromjpeg(base_url('assets/prophecy/assets/image/aqic/2023_bg_7_v3.jpg?v=2'));
					$time_color = imagecolorallocate($image, 46, 117, 181);
				}else{
					$image = imagecreatefromjpeg(base_url('assets/prophecy/assets/image/aqic/2023_bg_4_v3.jpg?v=2'));
					$time_color = imagecolorallocate($image, 255, 192, 0);
				}
				$background_color = imagecolorallocate($image, 255, 255, 255);
				// font-color
				$font_path = $_SERVER["DOCUMENT_ROOT"].'/assets/prophecy/assets/font/ThaiSansNeue/ThaiSansNeue-Black.ttf';
				$text_color = imagecolorallocate($image, 33, 37, 41);
				$temp_color = imagecolorallocate($image, 129, 56, 14);
				//date
				$this->newText($image, 175, 0, 15, 50, $text_color, $font_path, date('j') ,$align = "center",$border = false, $width = 300, $height = 150);
				$this->newText($image, 70, 0, 15, 215, $text_color, $font_path, ConvertToThaiDate_mm(date('n')).(date('y')+43) ,$align = "center",$border = false, $width = 300, $height = 60);
				//temp
				$this->newText($image, 60, 0, 300, 215, $temp_color, $font_path, $this->temp() ,$align = "center",$border = false, $width = 125, $height = 50);
				//time
				$this->newText($image, 90, 0, 305, 310, $time_color, $font_path, (empty($this->uri->segment(3))?date('H'):$date_H).':00 น.' ,$align = "center",$border = false, $width = 375, $height = 80);

				//list pm25
				$font_path = $_SERVER["DOCUMENT_ROOT"].'/assets/prophecy/assets/font/ThaiSansNeue/ThaiSansNeue-ExtraBold.ttf';
				$arrContextOptions=array(
					"ssl"=>array(
						"verify_peer"=>false,
						"verify_peer_name"=>false,
					),
				);  
				$uri = 'https://pm2_5.nrct.go.th/api/station/markerreport/'.(empty($this->uri->segment(3))?date('G'):$this->uri->segment(3));
				$list_api = json_decode(file_get_contents($uri, false, stream_context_create($arrContextOptions)));
				$ar_list = array();
				foreach($list_api as $key => $value){
					$ar_list[$key] = $value;
				}
				
				$uri2 = 'https://pm2_5.nrct.go.th/api/station/markerconfig';
				$list_res_ids = json_decode(file_get_contents($uri2, false, stream_context_create($arrContextOptions)),true);

				// list1
				$res_ids = explode(",",str_replace(" ", "",$list_res_ids[1]));
				$res = getResult($ar_list, $res_ids);
				// echo '<pre>';
				// print_r($ar_list);
				// echo '</pre>';
				// exit();
				if($res!=null){
					$pm25 = $res->pm25;
					$daily_pm25 = $res->daily_pm25;
					$name = $res->dustboy_name;
				}else{
					$pm25 = 'N/A';
					$daily_pm25 = 'N/A';
					$name = 'N/A';
				}
				$x = 245;$y = 460;$text_x = $x;$text_y = $y+35;
				$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
				$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

				$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
				$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
				
				// list2
				// $res_ids = array(5212,5614,5615,5616,5618,5278);
				$res_ids = explode(",",str_replace(" ", "",$list_res_ids[2]));
				$res = getResult($ar_list, $res_ids);
				if($res!=null){
					$pm25 = $res->pm25;
					$daily_pm25 = $res->daily_pm25;
					$name = $res->dustboy_name;
				}else{
					$pm25 = 'N/A';
					$daily_pm25 = 'N/A';
					$name = 'N/A';
				}
				$x = 120;$y = 740;$text_x = $x;$text_y = $y+35;
				$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
				$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

				$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
				$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
				
				// list3
				// $res_ids = array(5047,5031,5032,5046,5399,5428);
				$res_ids = explode(",",str_replace(" ", "",$list_res_ids[3]));
				$res = getResult($ar_list, $res_ids);
				if($res!=null){
					$pm25 = $res->pm25;
					$daily_pm25 = $res->daily_pm25;
					$name = $res->dustboy_name;
				}else{
					$pm25 = 'N/A';
					$daily_pm25 = 'N/A';
					$name = 'N/A';
				}
				$x = 110;$y = 1010;$text_x = $x;$text_y = $y+35;
				$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
				$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

				$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
				$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
				
				// list4
				// $res_ids = array(5315,5361,5062,6008,110,5242,5240,5243);
				$res_ids = explode(",",str_replace(" ", "",$list_res_ids[4]));
				$res = getResult($ar_list, $res_ids);
				if($res!=null){
					$pm25 = $res->pm25;
					$daily_pm25 = $res->daily_pm25;
					$name = $res->dustboy_name;
				}else{
					$pm25 = 'N/A';
					$daily_pm25 = 'N/A';
					$name = 'N/A';
				}
				$x = 330;$y = 1260;$text_x = $x;$text_y = $y+35;
				$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
				$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

				$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
				$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
				
				// list5
				// $res_ids = array(5324,5291,5323,5338,5337,5638);
				$res_ids = explode(",",str_replace(" ", "",$list_res_ids[5]));
				$res = getResult($ar_list, $res_ids);
				if($res!=null){
					$pm25 = $res->pm25;
					$daily_pm25 = $res->daily_pm25;
					$name = $res->dustboy_name;
				}else{
					$pm25 = 'N/A';
					$daily_pm25 = 'N/A';
					$name = 'N/A';
				}
				$x = 240;$y = 1500;$text_x = $x;$text_y = $y+35;
				$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
				$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

				$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
				$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
				
				// list6
				// $res_ids = array(5313,5152);
				// $res_ids = array(5072, 6599, 5151, 5152, 5313, 5419, 5420, 5671);
				$res_ids = explode(",",str_replace(" ", "",$list_res_ids[6]));
				$res = getResult($ar_list, $res_ids);
				if($res!=null){
					$pm25 = $res->pm25;
					$daily_pm25 = $res->daily_pm25;
					$name = $res->dustboy_name;
				}else{
					$pm25 = 'N/A';
					$daily_pm25 = 'N/A';
					$name = 'N/A';
				}
				$x = 260;$y = 1820;$text_x = $x;$text_y = $y+35;
				$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
				$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

				$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
				$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
				
				// list7
				// $res_ids = array(5068,5635,5636,6190,6191,6193,6194, 6195, 5609);
				$res_ids = explode(",",str_replace(" ", "",$list_res_ids[7]));
				$res = getResult($ar_list, $res_ids);
				if($res!=null){
					$pm25 = $res->pm25;
					$daily_pm25 = $res->daily_pm25;
					$name = $res->dustboy_name;
				}else{
					$pm25 = 'N/A';
					$daily_pm25 = 'N/A';
					$name = 'N/A';
				}
				$x = 1540;$y = 870;$text_x = $x;$text_y = $y+35;
				$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
				$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

				$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
				$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
				
				// list8
				// $res_ids = array(5356,6000,6019,4013,6020,5457,5357);
				// $res_ids = array(5457,5356,6000,4013,4070,5357,6020,6242,5239);
				$res_ids = explode(",",str_replace(" ", "",$list_res_ids[8]));
				$res = getResult($ar_list, $res_ids);
				if($res!=null){
					$pm25 = $res->pm25;
					$daily_pm25 = $res->daily_pm25;
					$name = $res->dustboy_name;
				}else{
					$pm25 = 'N/A';
					$daily_pm25 = 'N/A';
					$name = 'N/A';
				}
				$x = 840;$y = 1010;$text_x = $x;$text_y = $y+35;
				$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
				$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

				$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
				$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
				
				// list9
				// $res_ids = array(5051, 5049, 5688, 5677, 5676, 5052, 5405);
				$res_ids = explode(",",str_replace(" ", "",$list_res_ids[9]));
				$res = getResult($ar_list, $res_ids);
				if($res!=null){
					$pm25 = $res->pm25;
					$daily_pm25 = $res->daily_pm25;
					$name = $res->dustboy_name;
				}else{
					$pm25 = 'N/A';
					$daily_pm25 = 'N/A';
					$name = 'N/A';
				}
				$x = 835;$y = 305;$text_x = $x;$text_y = $y+35;
				$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
				$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

				$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
				$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
				
				// list10
				// $res_ids = array(5444,5293,5294,5295);
				$res_ids = explode(",",str_replace(" ", "",$list_res_ids[10]));
				$res = getResult($ar_list, $res_ids);
				if($res!=null){
					$pm25 = $res->pm25;
					$daily_pm25 = $res->daily_pm25;
					$name = $res->dustboy_name;
				}else{
					$pm25 = 'N/A';
					$daily_pm25 = 'N/A';
					$name = 'N/A';
				}
				$x = 1290;$y = 350;$text_x = $x;$text_y = $y+35;
				$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
				$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

				$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
				$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
				
				// list11
				// $res_ids = array(5388, 5643, 5202, 5205, 5200, 5198);
				$res_ids = explode(",",str_replace(" ", "",$list_res_ids[11]));
				$res = getResult($ar_list, $res_ids);
				// echo '<pre>';
				// print_r($res_ids);
				// echo '</pre>';
				// exit();
				if($res!=null){
					$pm25 = $res->pm25;
					$daily_pm25 = $res->daily_pm25;
					$name = $res->dustboy_name;
				}else{
					$pm25 = 'N/A';
					$daily_pm25 = 'N/A';
					$name = 'N/A';
				}
				$x = 1350;$y = 610;$text_x = $x;$text_y = $y+35;
				$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
				$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

				$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
				$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
				
				// list12
				// $res_ids = array(5344,5318,5580,6132,6133);
				$res_ids = explode(",",str_replace(" ", "",$list_res_ids[12]));
				$res = getResult($ar_list, $res_ids);
				if($res!=null){
					$pm25 = $res->pm25;
					$daily_pm25 = $res->daily_pm25;
					$name = $res->dustboy_name;
				}else{
					$pm25 = 'N/A';
					$daily_pm25 = 'N/A';
					$name = 'N/A';
				}
				$x = 1450;$y = 1300;$text_x = $x;$text_y = $y+35;
				$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
				$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

				$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
				$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
				
				// list13
				// $res_ids = array(5342,5597,5598,5464,5064,6148);
				$res_ids = explode(",",str_replace(" ", "",$list_res_ids[13]));
				$res = getResult($ar_list, $res_ids);
				if($res!=null){
					$pm25 = $res->pm25;
					$daily_pm25 = $res->daily_pm25;
					$name = $res->dustboy_name;
				}else{
					$pm25 = 'N/A';
					$daily_pm25 = 'N/A';
					$name = 'N/A';
				}
				$x = 1010;$y = 1440;$text_x = $x;$text_y = $y+35;
				$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
				$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

				$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
				$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
				
				// list14
				// $res_ids = array(5305, 5352,5417,5070,5056,5055);
				$res_ids = explode(",",str_replace(" ", "",$list_res_ids[14]));
				$res = getResult($ar_list, $res_ids);
				if($res!=null){
					$pm25 = $res->pm25;
					$daily_pm25 = $res->daily_pm25;
					$name = $res->dustboy_name;
				}else{
					$pm25 = 'N/A';
					$daily_pm25 = 'N/A';
					$name = 'N/A';
				}
				$x = 950;$y = 1680;$text_x = $x;$text_y = $y+35;
				$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
				$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

				$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
				$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			//end-create-image
			header("Content-Type: image/jpeg");
			// imagejpeg($image);
			if($ar_list!=null){ // data is not null
				if($this->uri->segment(3)){
					imagejpeg($image,$_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/dailyReport".$this->uri->segment(3).".jpg");
					imagedestroy($image);
					imagedestroy($mark1);
					// redirect('line/daily_api/'.$this->uri->segment(3));
				}else{
					imagejpeg($image,$_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/dailyReport".date('G').".jpg");
					imagedestroy($image);
					imagedestroy($mark1);
					// redirect('line/daily_api');
				}
			}
		}else{
			header("Content-Type: image/jpeg");
			if($this->uri->segment(3)){
				$image = imagecreatefromjpeg($_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/dailyReport".$this->uri->segment(3).".jpg");
			}else{
				$image = imagecreatefromjpeg($_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/dailyReport".date('G').".jpg");
			}
			imagejpeg($image);
			imagedestroy($image);
		}
	}
	public function dailyReport_preview_test()
	{
		$this->allowed_origin();
		header("Content-Type: image/jpeg");
		$image_p = imagecreatetruecolor(480, 672);
		if($this->uri->segment(3)){
			$image = imagecreatefromjpeg($_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/dailyReport".$this->uri->segment(3).".jpg");
		}else{
			$image = imagecreatefromjpeg($_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/dailyReport".date('G').".jpg");
		}
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, 480, 672, 1920, 2688);
		imagejpeg($image_p);
		imagedestroy($image);
		imagedestroy($image_p);
	}
	
	public function genDailyReport3(){
		set_time_limit(0);
		$this->allowed_origin();
		if($this->uri->segment(3)){
			if($this->uri->segment(3)<10){
				$date_H = sprintf('%02d', $this->uri->segment(3));
			}else{
				$date_H = $this->uri->segment(3);
			}
		}
		if(date('H')<13){
			$image = imagecreatefromjpeg(base_url('assets/prophecy/assets/image/vmap/report_bg_us.jpg?v=3'));
			$time_color = imagecolorallocate($image, 255, 192, 0);
		}else{
			$image = imagecreatefromjpeg(base_url('assets/prophecy/assets/image/vmap/report_bg_us.jpg?v=3'));
			$time_color = imagecolorallocate($image, 255, 192, 0);
		}
		$font_path = $_SERVER["DOCUMENT_ROOT"].'/assets/prophecy/assets/font/ThaiSansNeue/ThaiSansNeue-Black.ttf';
		$text_color = imagecolorallocate($image, 33, 37, 41);
		$temp_color = imagecolorallocate($image, 129, 56, 14);
			//date
		$this->newText($image, 175, 0, 15, 50, $text_color, $font_path, date('j') ,$align = "center",$border = false, $width = 300, $height = 150);
		$this->newText($image, 70, 0, 15, 215, $text_color, $font_path, ConvertToThaiDate_mm(date('n')).(date('y')+43) ,$align = "center",$border = false, $width = 300, $height = 60);
			//temp
		$this->newText($image, 60, 0, 300, 215, $temp_color, $font_path, $this->temp() ,$align = "center",$border = false, $width = 125, $height = 50);
			//time
		$this->newText($image, 90, 0, 350, 350, $time_color, $font_path, (empty($this->uri->segment(3))?date('H'):$date_H).':00 น.' ,$align = "center",$border = false, $width = 375, $height = 80);

		$font_path = $_SERVER["DOCUMENT_ROOT"].'/assets/prophecy/assets/font/ThaiSansNeue/ThaiSansNeue-ExtraBold.ttf';
			$arrContextOptions=array(
				"ssl"=>array(
					"verify_peer"=>false,
					"verify_peer_name"=>false,
				),
			);  
			$uri = 'https://pm2_5.nrct.go.th/api/station/markerreport/'.(empty($this->uri->segment(3))?date('G'):$this->uri->segment(3));
			
			$list_api = json_decode(file_get_contents($uri, false, stream_context_create($arrContextOptions)));
			$ar_list = array();
			foreach($list_api as $key => $value){
				$ar_list[$key] = $value;
			}

			$uri2 = 'https://pm2_5.nrct.go.th/api/station/markerconfig';
			$list_res_ids = json_decode(file_get_contents($uri2, false, stream_context_create($arrContextOptions)),true);

		$qid = date('H');
		$qid = ($qid<10? '0'.$qid:$qid);

		$filename = '/home/dev2/public_html/uploads/vmap/pm25_all_stn_'.date('Ymd').$qid.'-colored-mask-us.png';
			if (!file_exists($filename)) {
			
				$v ='https://thaq.soc.cmu.ac.th/tmp/stn_obs/pm2.5/pm25_all_stn_'.date('Ymd').$qid.'-colored-mask-us.png';
				$file_name = 'pm25_all_stn_'.date('Ymd').$qid.'-colored-mask-us.png';

				$arrContextOptions=array(
					"ssl"=>array(
						"verify_peer"=>false,
						"verify_peer_name"=>false,
					),
				);  
				
				$img_file = file_get_contents($v, false, stream_context_create($arrContextOptions));
				
				
				$file_loc=$_SERVER['DOCUMENT_ROOT'].'/uploads/vmap/'.$file_name;
				$file_handler=fopen($file_loc,'w');
				if(fwrite($file_handler,$img_file)==false){
					echo 'error';
				}
				fclose($file_handler);
		}
		$vmap_img = base_url('uploads/vmap/pm25_all_stn_'.date('Ymd').$qid.'-colored-mask-us.png?v='.date('His'));
		
		$mark1 = imagecreatefrompng($vmap_img);
		imagesavealpha($mark1, true);
		imagecopyresampled($image, $mark1, 550, 550, 0, 0, (1280/1.5), (2302/1.5) , 1280, 2302);

		$text_marker = base_url('assets/prophecy/assets/image/vmap/report_text.png');
		$mark1 = imagecreatefrompng($text_marker);
		imagesavealpha($mark1, true);
		imagecopyresampled($image, $mark1, 0, 0, 0, 0, (1920), (2716) , 1920, 2716);



		$res_ids = explode(",",str_replace(" ", "",$list_res_ids[1]));
		$res = getResult($ar_list, $res_ids);

			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}

			
			$x = 245;$y = 460;$text_x = $x;$text_y = $y+35;
			$text_color = color_us_type($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/us/realtime_'.color_us_type($pm25).'.png?v=1'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 72, 72);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = color_us_type($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/us/24hr_'.color_us_type($daily_pm25).'.png?v=1'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 70, 72);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
		
			// list2
			// $res_ids = array(5212,5614,5615,5616,5618,5278);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[2]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 120;$y = 740;$text_x = $x;$text_y = $y+35;
			$text_color = color_us_type($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/us/realtime_'.color_us_type($pm25).'.png?v=1'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 72, 72);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = color_us_type($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/us/24hr_'.color_us_type($daily_pm25).'.png?v=1'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 70, 72);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list3
			// $res_ids = array(5047,5031,5032,5046,5399,5428);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[3]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 110;$y = 1010;$text_x = $x;$text_y = $y+35;
			$text_color = color_us_type($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/us/realtime_'.color_us_type($pm25).'.png?v=1'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 72, 72);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = color_us_type($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/us/24hr_'.color_us_type($daily_pm25).'.png?v=1'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 70, 72);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list4
			// $res_ids = array(5315,5361,5062,6008,110,5242,5240,5243);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[4]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 330;$y = 1260;$text_x = $x;$text_y = $y+35;
			$text_color = color_us_type($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/us/realtime_'.color_us_type($pm25).'.png?v=1'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 72, 72);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = color_us_type($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/us/24hr_'.color_us_type($daily_pm25).'.png?v=1'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 70, 72);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list5
			// $res_ids = array(5324,5291,5323,5338,5337,5638);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[5]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 240;$y = 1500;$text_x = $x;$text_y = $y+35;
			$text_color = color_us_type($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/us/realtime_'.color_us_type($pm25).'.png?v=1'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 72, 72);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = color_us_type($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/us/24hr_'.color_us_type($daily_pm25).'.png?v=1'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 70, 72);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list6
			// $res_ids = array(5313,5152);
			// $res_ids = array(5072, 6599, 5151, 5152, 5313, 5419, 5420, 5671);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[6]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 260;$y = 1820;$text_x = $x;$text_y = $y+35;
			$text_color = color_us_type($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/us/realtime_'.color_us_type($pm25).'.png?v=1'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 72, 72);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = color_us_type($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/us/24hr_'.color_us_type($daily_pm25).'.png?v=1'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 70, 72);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list7
			// $res_ids = array(5068,5635,5636,6190,6191,6193,6194, 6195, 5609);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[7]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 1540;$y = 870;$text_x = $x;$text_y = $y+35;
			$text_color = color_us_type($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/us/realtime_'.color_us_type($pm25).'.png?v=1'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 72, 72);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = color_us_type($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/us/24hr_'.color_us_type($daily_pm25).'.png?v=1'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 70, 72);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list8
			// $res_ids = array(5356,6000,6019,4013,6020,5457,5357);
			// $res_ids = array(5457,5356,6000,4013,4070,5357,6020,6242,5239);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[8]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 840;$y = 1010;$text_x = $x;$text_y = $y+35;
			$text_color = color_us_type($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/us/realtime_'.color_us_type($pm25).'.png?v=1'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 72, 72);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = color_us_type($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/us/24hr_'.color_us_type($daily_pm25).'.png?v=1'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 70, 72);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list9
			// $res_ids = array(5051, 5049, 5688, 5677, 5676, 5052, 5405);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[9]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 835;$y = 305;$text_x = $x;$text_y = $y+35;
			$text_color = color_us_type($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/us/realtime_'.color_us_type($pm25).'.png?v=1'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 72, 72);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = color_us_type($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/us/24hr_'.color_us_type($daily_pm25).'.png?v=1'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 70, 72);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list10
			// $res_ids = array(5444,5293,5294,5295);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[10]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 1290;$y = 350;$text_x = $x;$text_y = $y+35;
			$text_color = color_us_type($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/us/realtime_'.color_us_type($pm25).'.png?v=1'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 72, 72);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = color_us_type($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/us/24hr_'.color_us_type($daily_pm25).'.png?v=1'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 70, 72);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list11
			// $res_ids = array(5388, 5643, 5202, 5205, 5200, 5198);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[11]));
			$res = getResult($ar_list, $res_ids);
			// echo '<pre>';
			// print_r($res_ids);
			// echo '</pre>';
			// exit();
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 1350;$y = 610;$text_x = $x;$text_y = $y+35;
			$text_color = color_us_type($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/us/realtime_'.color_us_type($pm25).'.png?v=1'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 72, 72);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = color_us_type($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/us/24hr_'.color_us_type($daily_pm25).'.png?v=1'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 70, 72);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list12
			// $res_ids = array(5344,5318,5580,6132,6133);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[12]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 1450;$y = 1300;$text_x = $x;$text_y = $y+35;
			$text_color = color_us_type($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/us/realtime_'.color_us_type($pm25).'.png?v=1'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 72, 72);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = color_us_type($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/us/24hr_'.color_us_type($daily_pm25).'.png?v=1'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 70, 72);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list13
			// $res_ids = array(5342,5597,5598,5464,5064,6148);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[13]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 1010;$y = 1440;$text_x = $x;$text_y = $y+35;
			$text_color = color_us_type($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/us/realtime_'.color_us_type($pm25).'.png?v=1'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 72, 72);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = color_us_type($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/us/24hr_'.color_us_type($daily_pm25).'.png?v=1'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 70, 72);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list14
			// $res_ids = array(5305, 5352,5417,5070,5056,5055);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[14]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 950;$y = 1680;$text_x = $x;$text_y = $y+35;
			$text_color = color_us_type($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/us/realtime_'.color_us_type($pm25).'.png?v=1'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 72, 72);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = color_us_type($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/us/24hr_'.color_us_type($daily_pm25).'.png?v=1'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 70, 72);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			//end-create-image


		header("Content-Type: image/jpeg");
		$file_name = "/uploads/reportpm25/report_aqic/dailyReport3".date('G').".jpg";
		
		imagejpeg($image,$_SERVER["DOCUMENT_ROOT"].$file_name);
		imagejpeg($image);
		imagedestroy($image);
				
	}
	public function genDailyReport2(){
		set_time_limit(0);
		$this->allowed_origin();
		if($this->uri->segment(3)){
			if($this->uri->segment(3)<10){
				$date_H = sprintf('%02d', $this->uri->segment(3));
			}else{
				$date_H = $this->uri->segment(3);
			}
		}
		if(date('H')<13){
			$image = imagecreatefromjpeg(base_url('assets/prophecy/assets/image/vmap/2023_bg_7_v3.jpg?v=3'));
			$time_color = imagecolorallocate($image, 46, 117, 181);
		}else{
			$image = imagecreatefromjpeg(base_url('assets/prophecy/assets/image/vmap/2023_bg_4_v3.jpg?v=3'));
			$time_color = imagecolorallocate($image, 255, 192, 0);
		}
		$font_path = $_SERVER["DOCUMENT_ROOT"].'/assets/prophecy/assets/font/ThaiSansNeue/ThaiSansNeue-Black.ttf';
		$text_color = imagecolorallocate($image, 33, 37, 41);
		$temp_color = imagecolorallocate($image, 129, 56, 14);
			//date
		$this->newText($image, 175, 0, 15, 50, $text_color, $font_path, date('j') ,$align = "center",$border = false, $width = 300, $height = 150);
		$this->newText($image, 70, 0, 15, 215, $text_color, $font_path, ConvertToThaiDate_mm(date('n')).(date('y')+43) ,$align = "center",$border = false, $width = 300, $height = 60);
			//temp
		$this->newText($image, 60, 0, 300, 215, $temp_color, $font_path, $this->temp() ,$align = "center",$border = false, $width = 125, $height = 50);
			//time
		$this->newText($image, 90, 0, 305, 310, $time_color, $font_path, (empty($this->uri->segment(3))?date('H'):$date_H).':00 น.' ,$align = "center",$border = false, $width = 375, $height = 80);


		$font_path = $_SERVER["DOCUMENT_ROOT"].'/assets/prophecy/assets/font/ThaiSansNeue/ThaiSansNeue-ExtraBold.ttf';
			$arrContextOptions=array(
				"ssl"=>array(
					"verify_peer"=>false,
					"verify_peer_name"=>false,
				),
			);  
			$uri = 'https://pm2_5.nrct.go.th/api/station/markerreport/'.(empty($this->uri->segment(3))?date('G'):$this->uri->segment(3));
			
			$list_api = json_decode(file_get_contents($uri, false, stream_context_create($arrContextOptions)));
			$ar_list = array();
			foreach($list_api as $key => $value){
				$ar_list[$key] = $value;
			}

			$uri2 = 'https://pm2_5.nrct.go.th/api/station/markerconfig';
			$list_res_ids = json_decode(file_get_contents($uri2, false, stream_context_create($arrContextOptions)),true);

		$qid = date('H');
		$qid = ($qid<10? '0'.$qid:$qid);

		$filename = '/home/dev2/public_html/uploads/vmap/pm25_all_stn_'.date('Ymd').$qid.'-colored-mask.png';
			if (!file_exists($filename)) {
			
				$v ='https://thaq.soc.cmu.ac.th/tmp/stn_obs/pm2.5/pm25_all_stn_'.date('Ymd').$qid.'-colored-mask.png';
				$file_name = 'pm25_all_stn_'.date('Ymd').$qid.'-colored-mask.png';

				$arrContextOptions=array(
					"ssl"=>array(
						"verify_peer"=>false,
						"verify_peer_name"=>false,
					),
				);  
				
				$img_file = file_get_contents($v, false, stream_context_create($arrContextOptions));
				
				
				$file_loc=$_SERVER['DOCUMENT_ROOT'].'/uploads/vmap/'.$file_name;
				$file_handler=fopen($file_loc,'w');
				if(fwrite($file_handler,$img_file)==false){
					echo 'error';
				}
				fclose($file_handler);
		}
		$vmap_img = base_url('uploads/vmap/pm25_all_stn_'.date('Ymd').$qid.'-colored-mask.png');
		
		$mark1 = imagecreatefrompng($vmap_img);
		imagesavealpha($mark1, true);
		imagecopyresampled($image, $mark1, 550, 550, 0, 0, (1280/1.5), (2302/1.5) , 1280, 2302);

		$text_marker = base_url('assets/prophecy/assets/image/vmap/report_text.png');
		$mark1 = imagecreatefrompng($text_marker);
		imagesavealpha($mark1, true);
		imagecopyresampled($image, $mark1, 0, 0, 0, 0, (1920), (2716) , 1920, 2716);
		
		
		$res_ids = explode(",",str_replace(" ", "",$list_res_ids[1]));
		$res = getResult($ar_list, $res_ids);

			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 245;$y = 460;$text_x = $x;$text_y = $y+35;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			

			// list2
			// $res_ids = array(5212,5614,5615,5616,5618,5278);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[2]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 120;$y = 740;$text_x = $x;$text_y = $y+35;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list3
			// $res_ids = array(5047,5031,5032,5046,5399,5428);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[3]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 110;$y = 1010;$text_x = $x;$text_y = $y+35;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list4
			// $res_ids = array(5315,5361,5062,6008,110,5242,5240,5243);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[4]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 330;$y = 1260;$text_x = $x;$text_y = $y+35;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list5
			// $res_ids = array(5324,5291,5323,5338,5337,5638);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[5]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 240;$y = 1500;$text_x = $x;$text_y = $y+35;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list6
			// $res_ids = array(5313,5152);
			// $res_ids = array(5072, 6599, 5151, 5152, 5313, 5419, 5420, 5671);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[6]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 260;$y = 1820;$text_x = $x;$text_y = $y+35;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list7
			// $res_ids = array(5068,5635,5636,6190,6191,6193,6194, 6195, 5609);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[7]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 1540;$y = 870;$text_x = $x;$text_y = $y+35;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list8
			// $res_ids = array(5356,6000,6019,4013,6020,5457,5357);
			// $res_ids = array(5457,5356,6000,4013,4070,5357,6020,6242,5239);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[8]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 840;$y = 1010;$text_x = $x;$text_y = $y+35;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list9
			// $res_ids = array(5051, 5049, 5688, 5677, 5676, 5052, 5405);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[9]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 835;$y = 305;$text_x = $x;$text_y = $y+35;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list10
			// $res_ids = array(5444,5293,5294,5295);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[10]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 1290;$y = 350;$text_x = $x;$text_y = $y+35;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list11
			// $res_ids = array(5388, 5643, 5202, 5205, 5200, 5198);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[11]));
			$res = getResult($ar_list, $res_ids);
			// echo '<pre>';
			// print_r($res_ids);
			// echo '</pre>';
			// exit();
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 1350;$y = 610;$text_x = $x;$text_y = $y+35;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list12
			// $res_ids = array(5344,5318,5580,6132,6133);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[12]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 1450;$y = 1300;$text_x = $x;$text_y = $y+35;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list13
			// $res_ids = array(5342,5597,5598,5464,5064,6148);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[13]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 1010;$y = 1440;$text_x = $x;$text_y = $y+35;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list14
			// $res_ids = array(5305, 5352,5417,5070,5056,5055);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[14]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 950;$y = 1680;$text_x = $x;$text_y = $y+35;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
		//end-create-image

		header("Content-Type: image/jpeg");
		$file_name = "/uploads/reportpm25/report_aqic/dailyReport2".date('G').".jpg";
		
		imagejpeg($image,$_SERVER["DOCUMENT_ROOT"].$file_name);
		imagejpeg($image);
		imagedestroy($image);
				
		
	}
	public function genDailyReport()
	{
		// ini_set('display_errors', 1);
		// ini_set('display_startup_errors', 1);
		// error_reporting(E_ALL);
		set_time_limit(0);
		$this->allowed_origin();
		if($this->uri->segment(3)){
			if($this->uri->segment(3)<10){
				$date_H = sprintf('%02d', $this->uri->segment(3));
			}else{
				$date_H = $this->uri->segment(3);
			}
		}
		//create-image
			if(date('H')<13){
				$image = imagecreatefromjpeg(base_url('assets/prophecy/assets/image/aqic/2023_bg_7_v3.jpg?v=2'));
				$time_color = imagecolorallocate($image, 46, 117, 181);
			}else{
				$image = imagecreatefromjpeg(base_url('assets/prophecy/assets/image/aqic/2023_bg_4_v3.jpg?v=2'));
				$time_color = imagecolorallocate($image, 255, 192, 0);
			}
			$background_color = imagecolorallocate($image, 255, 255, 255);
			// font-color
			$font_path = $_SERVER["DOCUMENT_ROOT"].'/assets/prophecy/assets/font/ThaiSansNeue/ThaiSansNeue-Black.ttf';
			$text_color = imagecolorallocate($image, 33, 37, 41);
			$temp_color = imagecolorallocate($image, 129, 56, 14);
			//date
			$this->newText($image, 175, 0, 15, 50, $text_color, $font_path, date('j') ,$align = "center",$border = false, $width = 300, $height = 150);
			$this->newText($image, 70, 0, 15, 215, $text_color, $font_path, ConvertToThaiDate_mm(date('n')).(date('y')+43) ,$align = "center",$border = false, $width = 300, $height = 60);
			//temp
			$this->newText($image, 60, 0, 300, 215, $temp_color, $font_path, $this->temp() ,$align = "center",$border = false, $width = 125, $height = 50);
			//time
			$this->newText($image, 90, 0, 305, 310, $time_color, $font_path, (empty($this->uri->segment(3))?date('H'):$date_H).':00 น.' ,$align = "center",$border = false, $width = 375, $height = 80);

			//list pm25
			$font_path = $_SERVER["DOCUMENT_ROOT"].'/assets/prophecy/assets/font/ThaiSansNeue/ThaiSansNeue-ExtraBold.ttf';
			$arrContextOptions=array(
				"ssl"=>array(
					"verify_peer"=>false,
					"verify_peer_name"=>false,
				),
			);  
			$uri = 'https://pm2_5.nrct.go.th/api/station/markerreport/'.(empty($this->uri->segment(3))?date('G'):$this->uri->segment(3));
			
			$list_api = json_decode(file_get_contents($uri, false, stream_context_create($arrContextOptions)));
			$ar_list = array();
			foreach($list_api as $key => $value){
				$ar_list[$key] = $value;
			}

			$uri2 = 'https://pm2_5.nrct.go.th/api/station/markerconfig';
			$list_res_ids = json_decode(file_get_contents($uri2, false, stream_context_create($arrContextOptions)),true);

			// list1
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[1]));
			$res = getResult($ar_list, $res_ids);
			// echo '<pre>';
			// print_r($ar_list);
			// echo '</pre>';
			// exit();
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 245;$y = 460;$text_x = $x;$text_y = $y+35;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list2
			// $res_ids = array(5212,5614,5615,5616,5618,5278);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[2]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 120;$y = 740;$text_x = $x;$text_y = $y+35;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list3
			// $res_ids = array(5047,5031,5032,5046,5399,5428);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[3]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 110;$y = 1010;$text_x = $x;$text_y = $y+35;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list4
			// $res_ids = array(5315,5361,5062,6008,110,5242,5240,5243);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[4]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 330;$y = 1260;$text_x = $x;$text_y = $y+35;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list5
			// $res_ids = array(5324,5291,5323,5338,5337,5638);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[5]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 240;$y = 1500;$text_x = $x;$text_y = $y+35;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list6
			// $res_ids = array(5313,5152);
			// $res_ids = array(5072, 6599, 5151, 5152, 5313, 5419, 5420, 5671);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[6]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 260;$y = 1820;$text_x = $x;$text_y = $y+35;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list7
			// $res_ids = array(5068,5635,5636,6190,6191,6193,6194, 6195, 5609);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[7]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 1540;$y = 870;$text_x = $x;$text_y = $y+35;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list8
			// $res_ids = array(5356,6000,6019,4013,6020,5457,5357);
			// $res_ids = array(5457,5356,6000,4013,4070,5357,6020,6242,5239);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[8]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 840;$y = 1010;$text_x = $x;$text_y = $y+35;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list9
			// $res_ids = array(5051, 5049, 5688, 5677, 5676, 5052, 5405);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[9]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 835;$y = 305;$text_x = $x;$text_y = $y+35;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list10
			// $res_ids = array(5444,5293,5294,5295);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[10]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 1290;$y = 350;$text_x = $x;$text_y = $y+35;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list11
			// $res_ids = array(5388, 5643, 5202, 5205, 5200, 5198);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[11]));
			$res = getResult($ar_list, $res_ids);
			// echo '<pre>';
			// print_r($res_ids);
			// echo '</pre>';
			// exit();
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 1350;$y = 610;$text_x = $x;$text_y = $y+35;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list12
			// $res_ids = array(5344,5318,5580,6132,6133);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[12]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 1450;$y = 1300;$text_x = $x;$text_y = $y+35;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list13
			// $res_ids = array(5342,5597,5598,5464,5064,6148);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[13]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 1010;$y = 1440;$text_x = $x;$text_y = $y+35;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
			
			// list14
			// $res_ids = array(5305, 5352,5417,5070,5056,5055);
			$res_ids = explode(",",str_replace(" ", "",$list_res_ids[14]));
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 950;$y = 1680;$text_x = $x;$text_y = $y+35;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
		//end-create-image
		
		header("Content-Type: image/jpeg");
		if($ar_list!=null){
			if($this->uri->segment(3)){
				imagejpeg($image,$_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/dailyReport".$this->uri->segment(3).".jpg");
				imagejpeg($image);
				imagedestroy($image);
				imagedestroy($mark1);
				// redirect('line/daily_api/'.$this->uri->segment(3));
			}else{
				imagejpeg($image,$_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/dailyReport".date('G').".jpg");
				imagejpeg($image);
				imagedestroy($image);
				imagedestroy($mark1);
			}
		}
	}
	public function genDailyReport_preview()
	{
		set_time_limit(0);
		$this->allowed_origin();
		if($this->uri->segment(3)){
			$time = $this->uri->segment(3);
			$dateTime = sprintf("%02d", $time);
		}else{
			$dateTime = date('H');
		}
		//create-image
			if($dateTime<13){
				$image = imagecreatefromjpeg(base_url('assets/prophecy/assets/image/aqic/bg_preview_7.jpg?v=1'));
				$time_color = imagecolorallocate($image, 46, 117, 181);
			}else{
				$image = imagecreatefromjpeg(base_url('assets/prophecy/assets/image/aqic/bg_preview_4.jpg?v=1'));
				$time_color = imagecolorallocate($image, 255, 192, 0);
			}
			$background_color = imagecolorallocate($image, 255, 255, 255);
			// font-color
			$font_path = $_SERVER["DOCUMENT_ROOT"].'/assets/prophecy/assets/font/ThaiSansNeue/ThaiSansNeue-Black.ttf';
			$text_color = imagecolorallocate($image, 33, 37, 41);
			$temp_color = imagecolorallocate($image, 129, 56, 14);
			//date
			$this->newText($image, 43.75, 0, 3.75, 12.5, $text_color, $font_path, date('j') ,$align = "center",$border = false, $width = 75, $height = 37.5);
			$this->newText($image, 17.5, 0, 3.75, 53.75, $text_color, $font_path, ConvertToThaiDate_mm(date('n')).(date('y')+43) ,$align = "center",$border = false, $width = 75, $height = 15);
			//temp
			$this->newText($image, 15, 0, 75, 53.75, $temp_color, $font_path, $this->temp() ,$align = "center",$border = false, $width = 31.25, $height = 12.5);
			//time
			$this->newText($image, 22.5, 0, 76.5, 77.5, $time_color, $font_path, $dateTime.':00 น.' ,$align = "center",$border = false, $width = 93.75, $height = 20);

			//list pm25
			$font_path = $_SERVER["DOCUMENT_ROOT"].'/assets/prophecy/assets/font/ThaiSansNeue/ThaiSansNeue-ExtraBold.ttf';
			$ar_list = array(
				5281=>null, 5264=>null, 5263=>null, 5265=>null, 5266=>null, 5267=>null,		//1
				5212=>null, 5614=>null, 5615=>null, 5616=>null, 5618=>null, 5278=>null,		//2
				5047=>null, 5031=>null, 5032=>null, 5046=>null, 5399=>null, 5428=>null,		//3
				5315=>null, 5361=>null, 5062=>null, 6008=>null, 110=>null, 5242=>null, 5240=>null, 5243=>null,		//4
				5324=>null, 5291=>null, 5323=>null, 5338=>null, 5337=>null, 5638=>null,		//5
				5072=>null, 6599=>null, 5151=>null, 5152=>null, 5313=>null, 5419=>null, 5420=>null,	 5671=>null,				//6							
				5068=>null, 5635=>null, 5636=>null, 6190=>null, 6191=>null, 6193=>null, 6194=>null, 6195=>null, 5609=>null,		//7	/*5067=>null, 5377=>null, 5378=>null,*/	
				// 5356=>null, 6000=>null, 6019=>null,	4013=>null, 6020=>null,	5457=>null, 5357=>null,									//8
				5457=>null, 5356=>null, 6000=>null, 4013=>null, 4070=>null, 5357=>null, 6020=>null, 6242=>null, 5239=>null,  //8
				5051=>null, 5049=>null, 5688=>null, 5677=>null, 5676=>null, 5052=>null, 5405=>null,   	//9
				5444=>null, 5293=>null, 5294=>null, 5295=>null,								//10
				5388=>null, 5643=>null, 5202=>null, 5205=>null, 5200=>null, 5198=>null,		//11
				5344=>null, 5318=>null, 5580=>null,	6132=>null, 6133=>null,										//12
				5342=>null, 5597=>null, 5598=>null,	5464=>null, 5064=>null, 6148=>null,	//13
				5305=>null, 5352=>null, 5417=>null,  5070=>null, 5056=>null, 5055=>null, 	//14
			);
			
			$uri = 'https://www-old.cmuccdc.org/assets/api/haze/pwa/json/temp_aun/'.date('Ymd').$dateTime.'_stations.json';
			$stations = json_decode(file_get_contents($uri));
			foreach($stations as $item){
				if (array_key_exists($item->id, $ar_list)){
					$ar_list[$item->id] = $item;
				}
			}
			// list1
			$res_ids = array(5281,5264,5263,5265,5266,5267);
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 61.25;$y = 115;$text_x = $x;$text_y = $y+6.4;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 37.5, 37.5, 896, 918);
			$this->newText($image, 17.5, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 37.5, $height = 15);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+33.75), ($y+1.25), 0, 0, 37.5, 37.5, 896, 918);
			$this->newText($image, 12.5, 0, ($text_x+36.75), ($text_y+7.5), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 32.5, $height = 10);
			
			// list2
			$res_ids = array(5212,5614,5615,5616,5618,5278);
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 30;$y = 185;$text_x = $x;$text_y = $y+6.4;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 37.5, 37.5, 896, 918);
			$this->newText($image, 17.5, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 37.5, $height = 15);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+33.75), ($y+1.25), 0, 0, 37.5, 37.5, 896, 918);
			$this->newText($image, 12.5, 0, ($text_x+36.75), ($text_y+7.5), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 32.5, $height = 10);
			
			// list3
			$res_ids = array(5047,5031,5032,5046,5399,5428);
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 27.5;$y = 252.5;$text_x = $x;$text_y = $y+6.4;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 37.5, 37.5, 896, 918);
			$this->newText($image, 17.5, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 37.5, $height = 15);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+33.75), ($y+1.25), 0, 0, 37.5, 37.5, 896, 918);
			$this->newText($image, 12.5, 0, ($text_x+36.75), ($text_y+7.5), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 32.5, $height = 10);
			
			// list4
			$res_ids = array(5315,5361,5062,6008,110,5242,5240,5243);
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 82.5;$y = 315;$text_x = $x;$text_y = $y+6.4;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 37.5, 37.5, 896, 918);
			$this->newText($image, 17.5, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 37.5, $height = 15);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+33.75), ($y+1.25), 0, 0, 37.5, 37.5, 896, 918);
			$this->newText($image, 12.5, 0, ($text_x+36.75), ($text_y+7.5), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 32.5, $height = 10);
			
			// list5
			$res_ids = array(5324,5291,5323,5338,5337,5638);
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 60;$y = 375;$text_x = $x;$text_y = $y+6.4;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 37.5, 37.5, 896, 918);
			$this->newText($image, 17.5, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 37.5, $height = 15);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+33.75), ($y+1.25), 0, 0, 37.5, 37.5, 896, 918);
			$this->newText($image, 12.5, 0, ($text_x+36.75), ($text_y+7.5), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 32.5, $height = 10);
			
			// list6
			$res_ids = array(5313,5152);
			$res_ids = array(5072, 6599, 5151, 5152, 5313, 5419, 5420, 5671);
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 65;$y = 455;$text_x = $x;$text_y = $y+6.4;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 37.5, 37.5, 896, 918);
			$this->newText($image, 17.5, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 37.5, $height = 15);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+33.75), ($y+1.25), 0, 0, 37.5, 37.5, 896, 918);
			$this->newText($image, 12.5, 0, ($text_x+36.75), ($text_y+7.5), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 32.5, $height = 10);
			
			// list7
			$res_ids = array(5068,5635,5636,6190,6191,6193,6194, 6195, 5609);
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 385;$y = 217.5;$text_x = $x;$text_y = $y+6.4;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 37.5, 37.5, 896, 918);
			$this->newText($image, 17.5, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 37.5, $height = 15);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+33.75), ($y+1.25), 0, 0, 37.5, 37.5, 896, 918);
			$this->newText($image, 12.5, 0, ($text_x+36.75), ($text_y+7.5), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 32.5, $height = 10);
			
			// list8
			// $res_ids = array(5356,6000,6019,4013,6020,5457,110,5357,5240,5243,5239);
			$res_ids = array(5457,5356,6000,4013,4070,5357,6020,6242,5239);
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 210;$y = 252.5;$text_x = $x;$text_y = $y+6.4;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 37.5, 37.5, 896, 918);
			$this->newText($image, 17.5, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 37.5, $height = 15);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+33.75), ($y+1.25), 0, 0, 37.5, 37.5, 896, 918);
			$this->newText($image, 12.5, 0, ($text_x+36.75), ($text_y+7.5), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 32.5, $height = 10);
			
			// list9
			$res_ids = array(5051, 5049, 5688, 5677, 5676, 5052, 5405);
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 208.75;$y = 76.25;$text_x = $x;$text_y = $y+6.4;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 37.5, 37.5, 896, 918);
			$this->newText($image, 17.5, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 37.5, $height = 15);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+33.75), ($y+1.25), 0, 0, 37.5, 37.5, 896, 918);
			$this->newText($image, 12.5, 0, ($text_x+36.75), ($text_y+7.5), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 32.5, $height = 10);
			
			// list10
			$res_ids = array(5444,5293,5294,5295);
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 322.5;$y = 87.5;$text_x = $x;$text_y = $y+6.4;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 37.5, 37.5, 896, 918);
			$this->newText($image, 17.5, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 37.5, $height = 15);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+33.75), ($y+1.25), 0, 0, 37.5, 37.5, 896, 918);
			$this->newText($image, 12.5, 0, ($text_x+36.75), ($text_y+7.5), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 32.5, $height = 10);
			
			// list11
			$res_ids = array(5388, 5643, 5202, 5205, 5200, 5198);
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 337.5;$y = 152.5;$text_x = $x;$text_y = $y+6.4;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 37.5, 37.5, 896, 918);
			$this->newText($image, 17.5, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 37.5, $height = 15);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+33.75), ($y+1.25), 0, 0, 37.5, 37.5, 896, 918);
			$this->newText($image, 12.5, 0, ($text_x+36.75), ($text_y+7.5), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 32.5, $height = 10);
			
			// list12
			$res_ids = array(5344,5318,5580,6132,6133);
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 362.5;$y = 325;$text_x = $x;$text_y = $y+6.4;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 37.5, 37.5, 896, 918);
			$this->newText($image, 17.5, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 37.5, $height = 15);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+33.75), ($y+1.25), 0, 0, 37.5, 37.5, 896, 918);
			$this->newText($image, 12.5, 0, ($text_x+36.75), ($text_y+7.5), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 32.5, $height = 10);
			
			// list13
			$res_ids = array(5342,5597,5598,5464,5064,6148);
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 252.5;$y = 360;$text_x = $x;$text_y = $y+6.4;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 37.5, 37.5, 896, 918);
			$this->newText($image, 17.5, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 37.5, $height = 15);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+33.75), ($y+1.25), 0, 0, 37.5, 37.5, 896, 918);
			$this->newText($image, 12.5, 0, ($text_x+36.75), ($text_y+7.5), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 32.5, $height = 10);
			
			// list14
			$res_ids = array(5305, 5352,5417,5070,5056,5055);
			$res = getResult($ar_list, $res_ids);
			if($res!=null){
				$pm25 = $res->pm25;
				$daily_pm25 = $res->daily_pm25;
				$name = $res->dustboy_name;
			}else{
				$pm25 = 'N/A';
				$daily_pm25 = 'N/A';
				$name = 'N/A';
			}
			$x = 237.5;$y = 420;$text_x = $x;$text_y = $y+6.4;
			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 37.5, 37.5, 896, 918);
			$this->newText($image, 17.5, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 37.5, $height = 15);

			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
			imagesavealpha($mark1, true);
			imagecopyresampled($image, $mark1, ($x+33.75), ($y+1.25), 0, 0, 37.5, 37.5, 896, 918);
			$this->newText($image, 12.5, 0, ($text_x+36.75), ($text_y+7.5), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 32.5, $height = 10);
		//end-create-image
		header("Content-Type: image/jpeg");
		imagejpeg($image,$_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/dailyReport_preview".date('G').".jpg");
		imagejpeg($image);
		imagedestroy($image);
		imagedestroy($mark1);
		// redirect('line/dailyReport_preview');
		// echo 'ok';
	}
	
	
	public function genJsonForecast(){
		
		$arrContextOptions=array(
			"ssl"=>array(
				"verify_peer"=>false,
				"verify_peer_name"=>false,
			),
		);  
		$data = array();
		
		$uri2 = 'https://pm2_5.nrct.go.th/api/station/markerconfig';
		$marker = array();
		$rsList = json_decode(file_get_contents($uri2, false, stream_context_create($arrContextOptions)),true);
		foreach($rsList as $list){
			$ar = explode(",",$list);
			foreach($ar as $a){
				array_push($marker, trim($a));
			}
		}
		
		$uri = 'https://www-old.cmuccdc.org/assets/api/haze/pwa/json/stations.json';
		$list_api = json_decode(file_get_contents($uri, false, stream_context_create($arrContextOptions)));
		foreach($list_api as $key => $value){
			if (in_array($value->id, $marker)){
				array_push($data, array(
					'id'	=>$value->id,
					'lat'	=>$value->dustboy_lat,
					'lon'	=>$value->dustboy_lon,
				));
			}
		}
		
		
		$uri = 'https://rcces.soc.cmu.ac.th:1443/pm25/v1/getDaily';
		$list_Forecast = json_decode(file_get_contents($uri, false, stream_context_create($arrContextOptions)));
		$payload = array();
		
		$toDay = date('Y-m-d');
		$tomorrow = date('Y-m-d',strtotime($toDay . "+1 days"));
		$aftertomorrow = date('Y-m-d',strtotime($toDay . "+2 days"));
		
		
		
		foreach($data as $mk){
			$ar_sub =array();
			foreach($list_Forecast->air_quality as $item){
				if( (float)$item->Latitude == (float)$mk['lat'] && (float)$item->Longitude == (float)$mk['lon']){
					$item = (array)$item;
					if(substr($item['ForecastDate'],0,10) == $toDay){
						$arz['today'] = ceil($item["PM25"]);
					}
					if(substr($item['ForecastDate'],0,10) == $tomorrow){
						$arz['tomorrow'] = ceil($item["PM25"]);
					}
					if(substr($item['ForecastDate'],0,10) == $aftertomorrow){
						$arz['afterTomorrow'] = ceil($item["PM25"]);
					}
					$ar_sub=$arz;
				}
			}
			$payload[$mk['id']] = $ar_sub;
		}
		
		
		if($payload){

			$filename = 'zforecast'.date('Ymd').'.json';
			$formattedData = json_encode($payload);
			$handle = fopen('/home/dev2/public_html/uploads/reportpm25/report_aqic/forecast/'.$filename,'w+');
			fwrite($handle,$formattedData);
			fclose($handle);
					
			chmod('/home/dev2/public_html/uploads/reportpm25/report_aqic/forecast/'.$filename, 0777);
			$error = false;	
			$tmp = file_get_contents('/home/dev2/public_html/uploads/reportpm25/report_aqic/forecast/'.$filename);
		
			
			echo $filename ;
		}
	}
	
	
	public function forecastReport()
	{
		$this->allowed_origin();
		$filename = 'https://www.cmuccdc.org/uploads/reportpm25/report_aqic/forecastReport.jpg?v='.date('YmdHis');
	
		if(((@strtotime(date('YmdH0000')) - @strtotime(get_headers($filename,true)['Last-Modified']))/3600)>=23){
			
				//create-image
				$image = imagecreatefromjpeg(base_url('assets/prophecy/assets/image/aqic/forecastreport.jpg?v=1'));
				$background_color = imagecolorallocate($image, 255, 255, 255);
				// font-color
				$font_path = $_SERVER["DOCUMENT_ROOT"].'/assets/prophecy/assets/font/ThaiSansNeue/ThaiSansNeue-Black.ttf';
				$text_color = imagecolorallocate($image, 33, 37, 41);
				$temp_color = imagecolorallocate($image, 129, 56, 14);
				//date
				$this->newText($image, 150, 0, 170, 50, $text_color, $font_path, date('j').'-'.date('j',strtotime('+2 days')) ,$align = "center",$border = false, $width = 300, $height = 125);
				$this->newText($image, 60, 0, 170, 200, $text_color, $font_path, ConvertToThaiDate_mm(date('n')).(date('y')+43) ,$align = "center",$border = false, $width = 300, $height = 50);
				//temp
				$this->newText($image, 50, 0, 125, 290, $temp_color, $font_path, $this->temp() ,$align = "center",$border = false, $width = 125, $height = 40);

				//date-forecast
				$this->newText($image, 40, 0, 1530, 1970, $text_color, $font_path, date('j') ,$align = "center",$border = false, $width = 125, $height = 30);
				$this->newText($image, 40, 0, 1630, 1970, $text_color, $font_path, date('j',strtotime('+1 days')) ,$align = "center",$border = false, $width = 125, $height = 30);
				$this->newText($image, 40, 0, 1740, 1970, $text_color, $font_path, date('j',strtotime('+2 days')) ,$align = "center",$border = false, $width = 125, $height = 30);


				//list pm25
				$font_path = $_SERVER["DOCUMENT_ROOT"].'/assets/prophecy/assets/font/ThaiSansNeue/ThaiSansNeue-ExtraBold.ttf';
			
				$ar_list = json_decode(file_get_contents(base_url('uploads/reportpm25/report_aqic/forecast/zforecast'.date('Ymd').'.json?v='.date('YmdHis'))),true);
	
				// list1
				$res_ids = array(5281,5264,5263,5265,5266,5267);
				$res = (object)getResult($ar_list, $res_ids);
				if($res!=null){
					$today = $res->today!=null?$res->today:'N/A';
					$tomorrow = $res->tomorrow!=null?$res->tomorrow:'N/A';
					$afterTomorrow = $res->afterTomorrow!=null?$res->afterTomorrow:'N/A';
				}else{
					$today = 'N/A';
					$tomorrow = 'N/A';
					$afterTomorrow = 'N/A';
				}
			
				$x = 70;$y = 430;$text_x = $x+27;$text_y = $y+80;
				$text_color = report_type_test($today)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($today).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x, $text_y, $text_color, $font_path, $today ,$align = "center",$border = false, $width = 150, $height = 55);

				$text_color = report_type_test($tomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($tomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+160, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x+160, $text_y, $text_color, $font_path, $tomorrow ,$align = "center",$border = false, $width = 150, $height = 55);

				$text_color = report_type_test($afterTomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($afterTomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+320, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x+320, $text_y, $text_color, $font_path, $afterTomorrow ,$align = "center",$border = false, $width = 150, $height = 55);
				
				// list2
				$res_ids = array(5212,5614,5615,5616,5618,5278);
				$res = (object)getResult($ar_list, $res_ids);
				if($res!=null){
					$today = $res->today!=null?$res->today:'N/A';
					$tomorrow = $res->tomorrow!=null?$res->tomorrow:'N/A';
					$afterTomorrow = $res->afterTomorrow!=null?$res->afterTomorrow:'N/A';
				}else{
					$today = 'N/A';
					$tomorrow = 'N/A';
					$afterTomorrow = 'N/A';
				}
				$x = 50;$y = 710;$text_x = $x+27;$text_y = $y+80;
				$text_color = report_type_test($today)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($today).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x, $text_y, $text_color, $font_path, $today ,$align = "center",$border = false, $width = 150, $height = 55);

				$text_color = report_type_test($tomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($tomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+160, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x+160, $text_y, $text_color, $font_path, $tomorrow ,$align = "center",$border = false, $width = 150, $height = 55);

				$text_color = report_type_test($afterTomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($afterTomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+320, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x+320, $text_y, $text_color, $font_path, $afterTomorrow ,$align = "center",$border = false, $width = 150, $height = 55);
				
				// // list3
				$res_ids = array(5047,5031,5032,5046,5399,5428);
				$res = (object)getResult($ar_list, $res_ids);
				if($res!=null){
					$today = $res->today!=null?$res->today:'N/A';
					$tomorrow = $res->tomorrow!=null?$res->tomorrow:'N/A';
					$afterTomorrow = $res->afterTomorrow!=null?$res->afterTomorrow:'N/A';
				}else{
					$today = 'N/A';
					$tomorrow = 'N/A';
					$afterTomorrow = 'N/A';
				}
				$x = 10;$y = 970;$text_x = $x+27;$text_y = $y+80;
				$text_color = report_type_test($today)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($today).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x, $text_y, $text_color, $font_path, $today ,$align = "center",$border = false, $width = 150, $height = 55);

				$text_color = report_type_test($tomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($tomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+160, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x+160, $text_y, $text_color, $font_path, $tomorrow ,$align = "center",$border = false, $width = 150, $height = 55);

				$text_color = report_type_test($afterTomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($afterTomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+320, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x+320, $text_y, $text_color, $font_path, $afterTomorrow ,$align = "center",$border = false, $width = 150, $height = 55);
				
				// // list4
				$res_ids = array(5315,5361,5062,6008,110,5242,5240,5243);
				$res = (object)getResult($ar_list, $res_ids);
				if($res!=null){
					$today = $res->today!=null?$res->today:'N/A';
					$tomorrow = $res->tomorrow!=null?$res->tomorrow:'N/A';
					$afterTomorrow = $res->afterTomorrow!=null?$res->afterTomorrow:'N/A';
				}else{
					$today = 'N/A';
					$tomorrow = 'N/A';
					$afterTomorrow = 'N/A';
				}
				$x = 100;$y = 1230;$text_x = $x+27;$text_y = $y+80;
				$text_color = report_type_test($today)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($today).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x, $text_y, $text_color, $font_path, $today ,$align = "center",$border = false, $width = 150, $height = 55);

				$text_color = report_type_test($tomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($tomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+160, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x+160, $text_y, $text_color, $font_path, $tomorrow ,$align = "center",$border = false, $width = 150, $height = 55);

				$text_color = report_type_test($afterTomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($afterTomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+320, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x+320, $text_y, $text_color, $font_path, $afterTomorrow ,$align = "center",$border = false, $width = 150, $height = 55);
				
				// // list5
				$res_ids = array(5324,5291,5323,5338,5337,5638);
				$res = (object)getResult($ar_list, $res_ids);
				if($res!=null){
					$today = $res->today!=null?$res->today:'N/A';
					$tomorrow = $res->tomorrow!=null?$res->tomorrow:'N/A';
					$afterTomorrow = $res->afterTomorrow!=null?$res->afterTomorrow:'N/A';
				}else{
					$today = 'N/A';
					$tomorrow = 'N/A';
					$afterTomorrow = 'N/A';
				}
				$x = 20;$y = 1470;$text_x = $x+27;$text_y = $y+80;
				$text_color = report_type_test($today)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($today).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x, $text_y, $text_color, $font_path, $today ,$align = "center",$border = false, $width = 150, $height = 55);

				$text_color = report_type_test($tomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($tomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+160, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x+160, $text_y, $text_color, $font_path, $tomorrow ,$align = "center",$border = false, $width = 150, $height = 55);

				$text_color = report_type_test($afterTomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($afterTomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+320, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x+320, $text_y, $text_color, $font_path, $afterTomorrow ,$align = "center",$border = false, $width = 150, $height = 55);
				
				// list6
				$res_ids = array(5313,5152);
				$res_ids = array(5072, 6599, 5151, 5152, 5313, 5419, 5420, 5671);
				$res = (object)getResult($ar_list, $res_ids);
				if($res!=null){
					$today = $res->today!=null?$res->today:'N/A';
					$tomorrow = $res->tomorrow!=null?$res->tomorrow:'N/A';
					$afterTomorrow = $res->afterTomorrow!=null?$res->afterTomorrow:'N/A';
				}else{
					$today = 'N/A';
					$tomorrow = 'N/A';
					$afterTomorrow = 'N/A';
				}
				$x = 30;$y = 1780;$text_x = $x+27;$text_y = $y+80;
				$text_color = report_type_test($today)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($today).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x, $text_y, $text_color, $font_path, $today ,$align = "center",$border = false, $width = 150, $height = 55);

				$text_color = report_type_test($tomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($tomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+160, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x+160, $text_y, $text_color, $font_path, $tomorrow ,$align = "center",$border = false, $width = 150, $height = 55);

				$text_color = report_type_test($afterTomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($afterTomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+320, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x+320, $text_y, $text_color, $font_path, $afterTomorrow ,$align = "center",$border = false, $width = 150, $height = 55);
				
				// list7
				$res_ids = array(5068,5635,5636,6190,6191,6193,6194, 6195, 5609);
				$res = (object)getResult($ar_list, $res_ids);
				if($res!=null){
					$today = $res->today!=null?$res->today:'N/A';
					$tomorrow = $res->tomorrow!=null?$res->tomorrow:'N/A';
					$afterTomorrow = $res->afterTomorrow!=null?$res->afterTomorrow:'N/A';
				}else{
					$today = 'N/A';
					$tomorrow = 'N/A';
					$afterTomorrow = 'N/A';
				}
				$x = 1400;$y = 840;$text_x = $x+27;$text_y = $y+80;
				$text_color = report_type_test($today)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($today).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x, $text_y, $text_color, $font_path, $today ,$align = "center",$border = false, $width = 150, $height = 55);

				$text_color = report_type_test($tomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($tomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+160, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x+160, $text_y, $text_color, $font_path, $tomorrow ,$align = "center",$border = false, $width = 150, $height = 55);

				$text_color = report_type_test($afterTomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($afterTomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+320, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x+320, $text_y, $text_color, $font_path, $afterTomorrow ,$align = "center",$border = false, $width = 150, $height = 55);
				
				// list8
				// $res_ids = array(5356,6000,6019,4013,6020,5457,5357);
				$res_ids = array(5457,5356,6000,4013,4070,5357,6020,6242,5239);
				$res = (object)getResult($ar_list, $res_ids);
				if($res!=null){
					$today = $res->today!=null?$res->today:'N/A';
					$tomorrow = $res->tomorrow!=null?$res->tomorrow:'N/A';
					$afterTomorrow = $res->afterTomorrow!=null?$res->afterTomorrow:'N/A';
				}else{
					$today = 'N/A';
					$tomorrow = 'N/A';
					$afterTomorrow = 'N/A';
				}
				$x = 700;$y = 990;$text_x = $x+27;$text_y = $y+80;
				$text_color = report_type_test($today)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($today).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x, $text_y, $text_color, $font_path, $today ,$align = "center",$border = false, $width = 150, $height = 55);

				$text_color = report_type_test($tomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($tomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+160, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x+160, $text_y, $text_color, $font_path, $tomorrow ,$align = "center",$border = false, $width = 150, $height = 55);

				$text_color = report_type_test($afterTomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($afterTomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+320, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x+320, $text_y, $text_color, $font_path, $afterTomorrow ,$align = "center",$border = false, $width = 150, $height = 55);
				
				// // list9
				$res_ids = array(5051, 5049, 5688, 5677, 5676, 5052, 5405);
				$res = (object)getResult($ar_list, $res_ids);
				if($res!=null){
					$today = $res->today!=null?$res->today:'N/A';
					$tomorrow = $res->tomorrow!=null?$res->tomorrow:'N/A';
					$afterTomorrow = $res->afterTomorrow!=null?$res->afterTomorrow:'N/A';
				}else{
					$today = 'N/A';
					$tomorrow = 'N/A';
					$afterTomorrow = 'N/A';
				}
				$x = 720;$y = 290;$text_x = $x+27;$text_y = $y+80;
				$text_color = report_type_test($today)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($today).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x, $text_y, $text_color, $font_path, $today ,$align = "center",$border = false, $width = 150, $height = 55);

				$text_color = report_type_test($tomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($tomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+160, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x+160, $text_y, $text_color, $font_path, $tomorrow ,$align = "center",$border = false, $width = 150, $height = 55);

				$text_color = report_type_test($afterTomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($afterTomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+320, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x+320, $text_y, $text_color, $font_path, $afterTomorrow ,$align = "center",$border = false, $width = 150, $height = 55);
				
				// list10
				$res_ids = array(5444,5293,5294,5295);
				$res = (object)getResult($ar_list, $res_ids);
				if($res!=null){
					$today = $res->today!=null?$res->today:'N/A';
					$tomorrow = $res->tomorrow!=null?$res->tomorrow:'N/A';
					$afterTomorrow = $res->afterTomorrow!=null?$res->afterTomorrow:'N/A';
				}else{
					$today = 'N/A';
					$tomorrow = 'N/A';
					$afterTomorrow = 'N/A';
				}
				$x = 1250;$y = 330;$text_x = $x+27;$text_y = $y+80;
				$text_color = report_type_test($today)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($today).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x, $text_y, $text_color, $font_path, $today ,$align = "center",$border = false, $width = 150, $height = 55);

				$text_color = report_type_test($tomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($tomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+160, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x+160, $text_y, $text_color, $font_path, $tomorrow ,$align = "center",$border = false, $width = 150, $height = 55);

				$text_color = report_type_test($afterTomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($afterTomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+320, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x+320, $text_y, $text_color, $font_path, $afterTomorrow ,$align = "center",$border = false, $width = 150, $height = 55);
				
				// list11
				$res_ids = array(5388, 5643, 5202, 5205, 5200, 5198);
				$res = (object)getResult($ar_list, $res_ids);
				if($res!=null){
					$today = $res->today!=null?$res->today:'N/A';
					$tomorrow = $res->tomorrow!=null?$res->tomorrow:'N/A';
					$afterTomorrow = $res->afterTomorrow!=null?$res->afterTomorrow:'N/A';
				}else{
					$today = 'N/A';
					$tomorrow = 'N/A';
					$afterTomorrow = 'N/A';
				}
				$x = 1300;$y = 580;$text_x = $x+27;$text_y = $y+80;
				$text_color = report_type_test($today)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($today).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x, $text_y, $text_color, $font_path, $today ,$align = "center",$border = false, $width = 150, $height = 55);

				$text_color = report_type_test($tomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($tomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+160, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x+160, $text_y, $text_color, $font_path, $tomorrow ,$align = "center",$border = false, $width = 150, $height = 55);

				$text_color = report_type_test($afterTomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($afterTomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+320, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x+320, $text_y, $text_color, $font_path, $afterTomorrow ,$align = "center",$border = false, $width = 150, $height = 55);
				
				// list12
				$res_ids = array(5344,5318,5580,6132,6133);
				$res = (object)getResult($ar_list, $res_ids);
				if($res!=null){
					$today = $res->today!=null?$res->today:'N/A';
					$tomorrow = $res->tomorrow!=null?$res->tomorrow:'N/A';
					$afterTomorrow = $res->afterTomorrow!=null?$res->afterTomorrow:'N/A';
				}else{
					$today = 'N/A';
					$tomorrow = 'N/A';
					$afterTomorrow = 'N/A';
				}
				$x = 1380;$y = 1270;$text_x = $x+27;$text_y = $y+80;
				$text_color = report_type_test($today)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($today).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x, $text_y, $text_color, $font_path, $today ,$align = "center",$border = false, $width = 150, $height = 55);

				$text_color = report_type_test($tomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($tomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+160, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x+160, $text_y, $text_color, $font_path, $tomorrow ,$align = "center",$border = false, $width = 150, $height = 55);

				$text_color = report_type_test($afterTomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($afterTomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+320, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x+320, $text_y, $text_color, $font_path, $afterTomorrow ,$align = "center",$border = false, $width = 150, $height = 55);
				
				// list13
				$res_ids = array(5342,5597,5598,5464,5064,6148);
				$res = (object)getResult($ar_list, $res_ids);
				if($res!=null){
					$today = $res->today!=null?$res->today:'N/A';
					$tomorrow = $res->tomorrow!=null?$res->tomorrow:'N/A';
					$afterTomorrow = $res->afterTomorrow!=null?$res->afterTomorrow:'N/A';
				}else{
					$today = 'N/A';
					$tomorrow = 'N/A';
					$afterTomorrow = 'N/A';
				}
				$x = 900;$y = 1410;$text_x = $x+27;$text_y = $y+80;
				$text_color = report_type_test($today)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($today).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x, $text_y, $text_color, $font_path, $today ,$align = "center",$border = false, $width = 150, $height = 55);

				$text_color = report_type_test($tomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($tomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+160, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x+160, $text_y, $text_color, $font_path, $tomorrow ,$align = "center",$border = false, $width = 150, $height = 55);

				$text_color = report_type_test($afterTomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($afterTomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+320, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x+320, $text_y, $text_color, $font_path, $afterTomorrow ,$align = "center",$border = false, $width = 150, $height = 55);
				
				// list14
				$res_ids = array(5305, 5352,5417,5070,5056,5055);
				$res = (object)getResult($ar_list, $res_ids);
				if($res!=null){
					$today = $res->today!=null?$res->today:'N/A';
					$tomorrow = $res->tomorrow!=null?$res->tomorrow:'N/A';
					$afterTomorrow = $res->afterTomorrow!=null?$res->afterTomorrow:'N/A';
				}else{
					$today = 'N/A';
					$tomorrow = 'N/A';
					$afterTomorrow = 'N/A';
				}
				$x = 860;$y = 1670;$text_x = $x+27;$text_y = $y+80;
				$text_color = report_type_test($today)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($today).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x, $text_y, $text_color, $font_path, $today ,$align = "center",$border = false, $width = 150, $height = 55);

				$text_color = report_type_test($tomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($tomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+160, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x+160, $text_y, $text_color, $font_path, $tomorrow ,$align = "center",$border = false, $width = 150, $height = 55);

				$text_color = report_type_test($afterTomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($afterTomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+320, $y, 0, 0, 200, 200, 896, 918);
				$this->newText($image, 65, 0, $text_x+320, $text_y, $text_color, $font_path, $afterTomorrow ,$align = "center",$border = false, $width = 150, $height = 55);
			//end-create-image
			
			header("Content-Type: image/jpeg");
			imagejpeg($image,$_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/forecastReport.jpg");
			// imagejpeg($image);
			imagedestroy($image);
			imagedestroy($mark1);
			// redirect('line/dailyReport');
		}else{
			header("Content-Type: image/jpeg");
			$image = imagecreatefromjpeg($_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/forecastReport.jpg");
			imagejpeg($image);
			imagedestroy($image);
		}
	}
	public function forecastReport_preview()
	{
		$this->allowed_origin();
		$filename = 'https://www.cmuccdc.org/uploads/reportpm25/report_aqic/forecastreport_preview.jpg?v='.date('YmdHis');
		if(((@strtotime(date('YmdH0000')) - @strtotime(get_headers($filename,true)['Last-Modified']))/3600)>=23){
			//create-image
				$image = imagecreatefromjpeg(base_url('assets/prophecy/assets/image/aqic/forecastreport_preview.jpg?v=1'));
				$background_color = imagecolorallocate($image, 255, 255, 255);
				// font-color
				$font_path = $_SERVER["DOCUMENT_ROOT"].'/assets/prophecy/assets/font/ThaiSansNeue/ThaiSansNeue-Black.ttf';
				$text_color = imagecolorallocate($image, 33, 37, 41);
				$temp_color = imagecolorallocate($image, 129, 56, 14);
				//date
				$this->newText($image, 37.5, 0, 42.5, 12.5, $text_color, $font_path, date('j').'-'.date('j',strtotime('+2 days')) ,$align = "center",$border = false, $width = 75, $height = 31.25);
				$this->newText($image, 15, 0, 42.5, 50, $text_color, $font_path, ConvertToThaiDate_mm(date('n')).(date('y')+43) ,$align = "center",$border = false, $width = 75, $height = 12.5);
				//temp
				$this->newText($image, 12.5, 0, 31.25, 72.5, $temp_color, $font_path, $this->temp() ,$align = "center",$border = false, $width = 31.25, $height = 10);

				//date-forecast
				$this->newText($image, 10, 0, 382.5, 492.5, $text_color, $font_path, date('j') ,$align = "center",$border = false, $width = 31.25, $height = 7.5);
				$this->newText($image, 10, 0, 407.5, 492.5, $text_color, $font_path, date('j',strtotime('+1 days')) ,$align = "center",$border = false, $width = 31.25, $height = 7.5);
				$this->newText($image, 10, 0, 435, 492.5, $text_color, $font_path, date('j',strtotime('+2 days')) ,$align = "center",$border = false, $width = 31.25, $height = 7.5);
				

				//list pm25
				$font_path = $_SERVER["DOCUMENT_ROOT"].'/assets/prophecy/assets/font/ThaiSansNeue/ThaiSansNeue-ExtraBold.ttf';
			
				$ar_list = json_decode(file_get_contents(base_url('uploads/reportpm25/report_aqic/forecast/forecast'.date('Ymd').'.json?v='.date('YmdHis'))),true);
				
				// list1
				$res_ids = array(5281,5264,5263,5265,5266,5267);
				$res = (object)getResult($ar_list, $res_ids);
				if($res!=null){
					$today = $res->today!=null?$res->today:'N/A';
					$tomorrow = $res->tomorrow!=null?$res->tomorrow:'N/A';
					$afterTomorrow = $res->afterTomorrow!=null?$res->afterTomorrow:'N/A';
				}else{
					$today = 'N/A';
					$tomorrow = 'N/A';
					$afterTomorrow = 'N/A';
				}
			
				$x = 17.5;$y = 107.5;$text_x = $x+6.75;$text_y = $y+20;
				$text_color = report_type_test($today)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($today).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x, $text_y, $text_color, $font_path, $today ,$align = "center",$border = false, $width = 37.5, $height = 13.75);

				$text_color = report_type_test($tomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($tomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+40, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x+40, $text_y, $text_color, $font_path, $tomorrow ,$align = "center",$border = false, $width = 37.5, $height = 13.75);

				$text_color = report_type_test($afterTomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($afterTomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+80, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x+80, $text_y, $text_color, $font_path, $afterTomorrow ,$align = "center",$border = false, $width = 37.5, $height = 13.75);
				
				// list2
				$res_ids = array(5212,5614,5615,5616,5618,5278);
				$res = (object)getResult($ar_list, $res_ids);
				if($res!=null){
					$today = $res->today!=null?$res->today:'N/A';
					$tomorrow = $res->tomorrow!=null?$res->tomorrow:'N/A';
					$afterTomorrow = $res->afterTomorrow!=null?$res->afterTomorrow:'N/A';
				}else{
					$today = 'N/A';
					$tomorrow = 'N/A';
					$afterTomorrow = 'N/A';
				}
				$x = 12.5;$y = 177.5;$text_x = $x+6.75;$text_y = $y+20;
				$text_color = report_type_test($today)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($today).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x, $text_y, $text_color, $font_path, $today ,$align = "center",$border = false, $width = 37.5, $height = 13.75);

				$text_color = report_type_test($tomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($tomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+40, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x+40, $text_y, $text_color, $font_path, $tomorrow ,$align = "center",$border = false, $width = 37.5, $height = 13.75);

				$text_color = report_type_test($afterTomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($afterTomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+80, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x+80, $text_y, $text_color, $font_path, $afterTomorrow ,$align = "center",$border = false, $width = 37.5, $height = 13.75);
				
				// // list3
				$res_ids = array(5047,5031,5032,5046,5399,5428);
				$res = (object)getResult($ar_list, $res_ids);
				if($res!=null){
					$today = $res->today!=null?$res->today:'N/A';
					$tomorrow = $res->tomorrow!=null?$res->tomorrow:'N/A';
					$afterTomorrow = $res->afterTomorrow!=null?$res->afterTomorrow:'N/A';
				}else{
					$today = 'N/A';
					$tomorrow = 'N/A';
					$afterTomorrow = 'N/A';
				}
				$x = 2.5;$y = 242.5;$text_x = $x+6.75;$text_y = $y+20;
				$text_color = report_type_test($today)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($today).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x, $text_y, $text_color, $font_path, $today ,$align = "center",$border = false, $width = 37.5, $height = 13.75);

				$text_color = report_type_test($tomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($tomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+40, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x+40, $text_y, $text_color, $font_path, $tomorrow ,$align = "center",$border = false, $width = 37.5, $height = 13.75);

				$text_color = report_type_test($afterTomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($afterTomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+80, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x+80, $text_y, $text_color, $font_path, $afterTomorrow ,$align = "center",$border = false, $width = 37.5, $height = 13.75);
				
				// // list4
				$res_ids = array(5315,5361,5062,6008,110,5242,5240,5243);
				$res = (object)getResult($ar_list, $res_ids);
				if($res!=null){
					$today = $res->today!=null?$res->today:'N/A';
					$tomorrow = $res->tomorrow!=null?$res->tomorrow:'N/A';
					$afterTomorrow = $res->afterTomorrow!=null?$res->afterTomorrow:'N/A';
				}else{
					$today = 'N/A';
					$tomorrow = 'N/A';
					$afterTomorrow = 'N/A';
				}
				$x = 25;$y = 307.5;$text_x = $x+6.75;$text_y = $y+20;
				$text_color = report_type_test($today)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($today).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x, $text_y, $text_color, $font_path, $today ,$align = "center",$border = false, $width = 37.5, $height = 13.75);

				$text_color = report_type_test($tomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($tomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+40, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x+40, $text_y, $text_color, $font_path, $tomorrow ,$align = "center",$border = false, $width = 37.5, $height = 13.75);

				$text_color = report_type_test($afterTomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($afterTomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+80, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x+80, $text_y, $text_color, $font_path, $afterTomorrow ,$align = "center",$border = false, $width = 37.5, $height = 13.75);
				
				// // list5
				$res_ids = array(5324,5291,5323,5338,5337,5638);
				$res = (object)getResult($ar_list, $res_ids);
				if($res!=null){
					$today = $res->today!=null?$res->today:'N/A';
					$tomorrow = $res->tomorrow!=null?$res->tomorrow:'N/A';
					$afterTomorrow = $res->afterTomorrow!=null?$res->afterTomorrow:'N/A';
				}else{
					$today = 'N/A';
					$tomorrow = 'N/A';
					$afterTomorrow = 'N/A';
				}
				$x = 5;$y = 367.5;$text_x = $x+6.75;$text_y = $y+20;
				$text_color = report_type_test($today)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($today).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x, $text_y, $text_color, $font_path, $today ,$align = "center",$border = false, $width = 37.5, $height = 13.75);

				$text_color = report_type_test($tomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($tomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+40, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x+40, $text_y, $text_color, $font_path, $tomorrow ,$align = "center",$border = false, $width = 37.5, $height = 13.75);

				$text_color = report_type_test($afterTomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($afterTomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+80, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x+80, $text_y, $text_color, $font_path, $afterTomorrow ,$align = "center",$border = false, $width = 37.5, $height = 13.75);
				
				// list6
				$res_ids = array(5313,5152);
				$res_ids = array(5072, 6599, 5151, 5152, 5313, 5419, 5420, 5671);
				$res = (object)getResult($ar_list, $res_ids);
				if($res!=null){
					$today = $res->today!=null?$res->today:'N/A';
					$tomorrow = $res->tomorrow!=null?$res->tomorrow:'N/A';
					$afterTomorrow = $res->afterTomorrow!=null?$res->afterTomorrow:'N/A';
				}else{
					$today = 'N/A';
					$tomorrow = 'N/A';
					$afterTomorrow = 'N/A';
				}
				$x = 7.5;$y = 445;$text_x = $x+6.75;$text_y = $y+20;
				$text_color = report_type_test($today)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($today).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x, $text_y, $text_color, $font_path, $today ,$align = "center",$border = false, $width = 37.5, $height = 13.75);

				$text_color = report_type_test($tomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($tomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+40, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x+40, $text_y, $text_color, $font_path, $tomorrow ,$align = "center",$border = false, $width = 37.5, $height = 13.75);

				$text_color = report_type_test($afterTomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($afterTomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+80, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x+80, $text_y, $text_color, $font_path, $afterTomorrow ,$align = "center",$border = false, $width = 37.5, $height = 13.75);
				
				// list7
				$res_ids = array(5068,5635,5636,6190,6191,6193,6194, 6195, 5609);
				$res = (object)getResult($ar_list, $res_ids);
				if($res!=null){
					$today = $res->today!=null?$res->today:'N/A';
					$tomorrow = $res->tomorrow!=null?$res->tomorrow:'N/A';
					$afterTomorrow = $res->afterTomorrow!=null?$res->afterTomorrow:'N/A';
				}else{
					$today = 'N/A';
					$tomorrow = 'N/A';
					$afterTomorrow = 'N/A';
				}
				$x = 350;$y = 210;$text_x = $x+6.75;$text_y = $y+20;
				$text_color = report_type_test($today)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($today).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x, $text_y, $text_color, $font_path, $today ,$align = "center",$border = false, $width = 37.5, $height = 13.75);

				$text_color = report_type_test($tomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($tomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+40, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x+40, $text_y, $text_color, $font_path, $tomorrow ,$align = "center",$border = false, $width = 37.5, $height = 13.75);

				$text_color = report_type_test($afterTomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($afterTomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+80, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x+80, $text_y, $text_color, $font_path, $afterTomorrow ,$align = "center",$border = false, $width = 37.5, $height = 13.75);
				
				// list8
				// $res_ids = array(5356,6000,6019,4013,6020,5457,5357);
				$res_ids = array(5457,5356,6000,4013,4070,5357,6020,6242,5239);
				$res = (object)getResult($ar_list, $res_ids);
				if($res!=null){
					$today = $res->today!=null?$res->today:'N/A';
					$tomorrow = $res->tomorrow!=null?$res->tomorrow:'N/A';
					$afterTomorrow = $res->afterTomorrow!=null?$res->afterTomorrow:'N/A';
				}else{
					$today = 'N/A';
					$tomorrow = 'N/A';
					$afterTomorrow = 'N/A';
				}
				$x = 175;$y = 247.5;$text_x = $x+6.75;$text_y = $y+20;
				$text_color = report_type_test($today)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($today).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x, $text_y, $text_color, $font_path, $today ,$align = "center",$border = false, $width = 37.5, $height = 13.75);

				$text_color = report_type_test($tomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($tomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+40, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x+40, $text_y, $text_color, $font_path, $tomorrow ,$align = "center",$border = false, $width = 37.5, $height = 13.75);

				$text_color = report_type_test($afterTomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($afterTomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+80, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x+80, $text_y, $text_color, $font_path, $afterTomorrow ,$align = "center",$border = false, $width = 37.5, $height = 13.75);
				
				// // list9
				$res_ids = array(5051, 5049, 5688, 5677, 5676, 5052, 5405);
				$res = (object)getResult($ar_list, $res_ids);
				if($res!=null){
					$today = $res->today!=null?$res->today:'N/A';
					$tomorrow = $res->tomorrow!=null?$res->tomorrow:'N/A';
					$afterTomorrow = $res->afterTomorrow!=null?$res->afterTomorrow:'N/A';
				}else{
					$today = 'N/A';
					$tomorrow = 'N/A';
					$afterTomorrow = 'N/A';
				}
				$x = 180;$y = 72.5;$text_x = $x+6.75;$text_y = $y+20;
				$text_color = report_type_test($today)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($today).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x, $text_y, $text_color, $font_path, $today ,$align = "center",$border = false, $width = 37.5, $height = 13.75);

				$text_color = report_type_test($tomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($tomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+40, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x+40, $text_y, $text_color, $font_path, $tomorrow ,$align = "center",$border = false, $width = 37.5, $height = 13.75);

				$text_color = report_type_test($afterTomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($afterTomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+80, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x+80, $text_y, $text_color, $font_path, $afterTomorrow ,$align = "center",$border = false, $width = 37.5, $height = 13.75);
				
				// list10
				$res_ids = array(5444,5293,5294,5295);
				$res = (object)getResult($ar_list, $res_ids);
				if($res!=null){
					$today = $res->today!=null?$res->today:'N/A';
					$tomorrow = $res->tomorrow!=null?$res->tomorrow:'N/A';
					$afterTomorrow = $res->afterTomorrow!=null?$res->afterTomorrow:'N/A';
				}else{
					$today = 'N/A';
					$tomorrow = 'N/A';
					$afterTomorrow = 'N/A';
				}
				$x = 312.5;$y = 82.5;$text_x = $x+6.75;$text_y = $y+20;
				$text_color = report_type_test($today)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($today).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x, $text_y, $text_color, $font_path, $today ,$align = "center",$border = false, $width = 37.5, $height = 13.75);

				$text_color = report_type_test($tomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($tomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+40, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x+40, $text_y, $text_color, $font_path, $tomorrow ,$align = "center",$border = false, $width = 37.5, $height = 13.75);

				$text_color = report_type_test($afterTomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($afterTomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+80, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x+80, $text_y, $text_color, $font_path, $afterTomorrow ,$align = "center",$border = false, $width = 37.5, $height = 13.75);
				
				// list11
				$res_ids = array(5388, 5643, 5202, 5205, 5200, 5198);
				$res = (object)getResult($ar_list, $res_ids);
				if($res!=null){
					$today = $res->today!=null?$res->today:'N/A';
					$tomorrow = $res->tomorrow!=null?$res->tomorrow:'N/A';
					$afterTomorrow = $res->afterTomorrow!=null?$res->afterTomorrow:'N/A';
				}else{
					$today = 'N/A';
					$tomorrow = 'N/A';
					$afterTomorrow = 'N/A';
				}
				$x = 325;$y = 145;$text_x = $x+6.75;$text_y = $y+20;
				$text_color = report_type_test($today)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($today).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x, $text_y, $text_color, $font_path, $today ,$align = "center",$border = false, $width = 37.5, $height = 13.75);

				$text_color = report_type_test($tomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($tomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+40, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x+40, $text_y, $text_color, $font_path, $tomorrow ,$align = "center",$border = false, $width = 37.5, $height = 13.75);

				$text_color = report_type_test($afterTomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($afterTomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+80, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x+80, $text_y, $text_color, $font_path, $afterTomorrow ,$align = "center",$border = false, $width = 37.5, $height = 13.75);
				
				// list12
				$res_ids = array(5344,5318,5580,6132,6133);
				$res = (object)getResult($ar_list, $res_ids);
				if($res!=null){
					$today = $res->today!=null?$res->today:'N/A';
					$tomorrow = $res->tomorrow!=null?$res->tomorrow:'N/A';
					$afterTomorrow = $res->afterTomorrow!=null?$res->afterTomorrow:'N/A';
				}else{
					$today = 'N/A';
					$tomorrow = 'N/A';
					$afterTomorrow = 'N/A';
				}
				$x = 345;$y = 317.5;$text_x = $x+6.75;$text_y = $y+20;
				$text_color = report_type_test($today)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($today).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x, $text_y, $text_color, $font_path, $today ,$align = "center",$border = false, $width = 37.5, $height = 13.75);

				$text_color = report_type_test($tomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($tomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+40, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x+40, $text_y, $text_color, $font_path, $tomorrow ,$align = "center",$border = false, $width = 37.5, $height = 13.75);

				$text_color = report_type_test($afterTomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($afterTomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+80, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x+80, $text_y, $text_color, $font_path, $afterTomorrow ,$align = "center",$border = false, $width = 37.5, $height = 13.75);
				
				// list13
				$res_ids = array(5342,5597,5598,5464,5064,6148);
				$res = (object)getResult($ar_list, $res_ids);
				if($res!=null){
					$today = $res->today!=null?$res->today:'N/A';
					$tomorrow = $res->tomorrow!=null?$res->tomorrow:'N/A';
					$afterTomorrow = $res->afterTomorrow!=null?$res->afterTomorrow:'N/A';
				}else{
					$today = 'N/A';
					$tomorrow = 'N/A';
					$afterTomorrow = 'N/A';
				}
				$x = 225;$y = 352.5;$text_x = $x+6.75;$text_y = $y+20;
				$text_color = report_type_test($today)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($today).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x, $text_y, $text_color, $font_path, $today ,$align = "center",$border = false, $width = 37.5, $height = 13.75);

				$text_color = report_type_test($tomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($tomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+40, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x+40, $text_y, $text_color, $font_path, $tomorrow ,$align = "center",$border = false, $width = 37.5, $height = 13.75);

				$text_color = report_type_test($afterTomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($afterTomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+80, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x+80, $text_y, $text_color, $font_path, $afterTomorrow ,$align = "center",$border = false, $width = 37.5, $height = 13.75);
				
				// list14
				$res_ids = array(5305, 5352,5417,5070,5056,5055);
				$res = (object)getResult($ar_list, $res_ids);
				if($res!=null){
					$today = $res->today!=null?$res->today:'N/A';
					$tomorrow = $res->tomorrow!=null?$res->tomorrow:'N/A';
					$afterTomorrow = $res->afterTomorrow!=null?$res->afterTomorrow:'N/A';
				}else{
					$today = 'N/A';
					$tomorrow = 'N/A';
					$afterTomorrow = 'N/A';
				}
				$x = 215;$y = 417.5;$text_x = $x+6.75;$text_y = $y+20;
				$text_color = report_type_test($today)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($today).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x, $text_y, $text_color, $font_path, $today ,$align = "center",$border = false, $width = 37.5, $height = 13.75);

				$text_color = report_type_test($tomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($tomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+40, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x+40, $text_y, $text_color, $font_path, $tomorrow ,$align = "center",$border = false, $width = 37.5, $height = 13.75);

				$text_color = report_type_test($afterTomorrow)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
				$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($afterTomorrow).'.png'));
				imagesavealpha($mark1, true);
				imagecopyresampled($image, $mark1, $x+80, $y, 0, 0, 50, 50, 896, 918);
				$this->newText($image, 16.25, 0, $text_x+80, $text_y, $text_color, $font_path, $afterTomorrow ,$align = "center",$border = false, $width = 37.5, $height = 13.75);
			//end-create-image
			
			header("Content-Type: image/jpeg");
			imagejpeg($image,$_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/forecastreport_preview.jpg");
			// imagejpeg($image);
			imagedestroy($image);
			imagedestroy($mark1);
			// redirect('line/dailyReport');
		}else{
			header("Content-Type: image/jpeg");
			$image = imagecreatefromjpeg($_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/forecastreport_preview.jpg");
			imagejpeg($image);
			imagedestroy($image);
		}
	}
	public function forecastReport_preview_test()
	{
		$this->allowed_origin();
		header("Content-Type: image/jpeg");
		$image_p = imagecreatetruecolor(480, 672);
		$image = imagecreatefromjpeg($_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/forecastReport.jpg");
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, 480, 672, 1920, 2688);
		imagejpeg($image_p);
		imagedestroy($image);
		imagedestroy($image_p);

	}
	public function hotspot()
	{
		$this->allowed_origin();
		$filename = 'https://www.cmuccdc.org/uploads/reportpm25/report_aqic/hotspot/hotspotReport.jpg?v='.date('YmdHis');
		if(((@strtotime(date('YmdH0000')) - @strtotime(get_headers($filename,true)['Last-Modified']))/3600)>=0){
			//create-image
				$image_p = imagecreatefromjpeg(base_url('assets/prophecy/assets/image/aqic/hotspotReport.jpg?v=1'));
				//$image_p = imagecreatefromjpeg(base_url('uploads/reportpm25/report_aqic/hotspot/hotspotReport.png?v=1'));
				$image = imagecreatefromjpeg($_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/hotspot/ex_hotspotReport_4.jpg");

				// font-color
				$font_path = $_SERVER["DOCUMENT_ROOT"].'/assets/prophecy/assets/font/ThaiSansNeue/ThaiSansNeue-Black.ttf';
				$text_color = imagecolorallocate($image_p, 255, 255, 255);
				
				//date
				$this->newText($image_p, 250, 0, 100, 15, $text_color, $font_path, date('j') ,$align = "center",$border = false, $width = 300, $height = 200);
				$this->newText($image_p, 85, 0, 100, 235, $text_color, $font_path, ConvertToThaiDate_mm(date('n')).(date('y')+43) ,$align = "center",$border = false, $width = 300, $height = 85);

				imagecopyresampled($image_p, $image, 0, 395, 0, 0, 1920, 1935, 2216, 1935);
				header("Content-Type: image/jpeg");
				imagejpeg($image_p,$_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/hotspot/hotspotReport.jpg");
				// imagejpeg($image_p);
				// header("Content-Type: image/png");
				// imagepng($image);

				imagedestroy($image_p); 
				imagedestroy($image);
			//end-create-image
		}else{
			header("Content-Type: image/jpeg");
			$image = imagecreatefromjpeg($_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/hotspot/hotspotReport.jpg");
			imagejpeg($image);
			imagedestroy($image);
		}
	}
	public function hotspot_preview()
	{
		$this->allowed_origin();
		header("Content-Type: image/jpeg");
		$image_p = imagecreatetruecolor(480, 672);
		$image = imagecreatefromjpeg($_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/hotspot/hotspotReport.jpg");
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, 480, 672, 1920, 2688);
		imagejpeg($image_p);
		imagedestroy($image);
		imagedestroy($image_p);

	}
	public function aqicReport1()
	{
		$this->allowed_origin();
		$filename = 'https://www.cmuccdc.org/uploads/reportpm25/report_aqic/aqic_report/aqicReport01.jpg?v='.date('YmdHis');
		if(((@strtotime(date('YmdH0000')) - @strtotime(get_headers($filename,true)['Last-Modified']))/3600)>=12){
			//create-image
				$image = imagecreatefromjpeg(base_url('assets/prophecy/assets/image/aqic/aqicReport01.jpg?v=1'));
				$background_color = imagecolorallocate($image, 255, 255, 255);
				// font-color
				$font_path = $_SERVER["DOCUMENT_ROOT"].'/assets/prophecy/assets/font/ThaiSansNeue/ThaiSansNeue-Black.ttf';
				$text_color = imagecolorallocate($image, 0, 31, 92);

				//date
				$this->newText($image, 55, 0, 55, 350, $text_color, $font_path, date('j').' '.ConvertToThaiDate_m(date('n')).' '.(date('Y')+543)  ,$align = "center",$border = false, $width = 400, $height = 55);
				$this->newText($image, 32, 0, 100, 425, $text_color, $font_path, 'ข้อมูล ณ เวลา 8:00 น.'  ,$align = "center",$border = false, $width = 350, $height = 32);

				header("Content-Type: image/jpeg");
				imagejpeg($image,$_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/aqic_report/aqicReport01.jpg");
				// imagejpeg($image);
				imagedestroy($image);
				// imagedestroy($mark1);
			//end-create-image
		}else{
			header("Content-Type: image/jpeg");
			$image = imagecreatefromjpeg($_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/aqic_report/aqicReport01.jpg");
			imagejpeg($image);
			imagedestroy($image);
		}
	}
	public function aqicReport2()
	{
		$this->allowed_origin();
		$filename = 'https://www.cmuccdc.org/uploads/reportpm25/report_aqic/aqic_report/aqicReport02.jpg?v='.date('YmdHis');
		if(((@strtotime(date('YmdH0000')) - @strtotime(get_headers($filename,true)['Last-Modified']))/3600)>=12){
			//create-image
				header("Content-Type: image/jpeg");
				$image_p = imagecreatefromjpeg(base_url('assets/prophecy/assets/image/aqic/aqicReport02.jpg?v=1'));
				$image = imagecreatefromjpeg($_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/dailyReport8.jpg");

				// font-color
				$font_path = $_SERVER["DOCUMENT_ROOT"].'/assets/prophecy/assets/font/ThaiSansNeue/ThaiSansNeue-Regular.ttf';
				$text_color = imagecolorallocate($image, 0, 0, 0);

				//text
				$data_get = json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/line/line_report_'.date('Ymd').'7.json'),true);
				$results = array($data_get['Bkk']['min'],$data_get['Bkk']['max'],$data_get['Central']['min'],$data_get['Central']['max'],$data_get['Northern']['min'],$data_get['Northern']['max'],$data_get['Eastern']['min'],$data_get['Eastern']['max'],$data_get['Southern']['min'],$data_get['Southern']['max']);
            	sort($results);
				$title = 'รายงานข้อมูลสถานการณ์คุณภาพอากาศ';
				$date = date('j').' '.ConvertToThaiDate_m(date('n')).' '.(date('Y')+543).' เวลา 8.00 น.';
				$paragraphBkk = "- กรุงเทพฯ มีค่าฝุ่นละอองขนาดเล็ก PM2.5 อยู่ระหว่าง ". $data_get['Bkk']['min'] ." - ". $data_get['Bkk']['max'] ." ug/m3\r\n";
				$paragraphC = "- ภาคกลาง มีค่าฝุ่นละอองขนาดเล็ก PM2.5 อยู่ระหว่าง ". $data_get['Central']['min'] ." - ". $data_get['Central']['max'] ." ug/m3\r\n";
				$paragraphN = "- ภาคเหนือ มีค่าฝุ่นละอองขนาดเล็ก PM2.5 อยู่ระหว่าง ". $data_get['Northern']['min'] ." - ". $data_get['Northern']['max'] ." ug/m3\r\n";
				$paragraphNE = "- ภาคตะวันออกเฉียงเหนือ มีค่าฝุ่นละอองขนาดเล็ก PM2.5 อยู่ระหว่าง ". $data_get['Eastern']['min'] ." - ". $data_get['Eastern']['max'] ." ug/m3\r\n";
				$paragraphS = "- ภาคใต้ มีค่าฝุ่นละอองขนาดเล็ก PM2.5 อยู่ระหว่าง ". $data_get['Southern']['min'] ." - ". $data_get['Southern']['max'] ." ug/m3\r\n";
				$paragraphO = "- ภาพรวมทั้งประเทศ มีค่าฝุ่นละอองขนาดเล็ก PM2.5 อยู่ระหว่าง ". $results[0] ." - ". end($results) ." ug/m3\r\n\r\n";
				$footer = "อย่าลืมสวมอุปกรณ์ป้องกันตัวเอง\r\n#DustBoy #pm2_5";
				
				$this->newText($image_p, 15, 0, 510, 225, $text_color, $font_path, $title."\r\n".$date."\r\n\r\n".$paragraphBkk.$paragraphC.$paragraphN.$paragraphNE.$paragraphS.$paragraphO.$footer  ,$align = "center",$border = false, $width = 550, $height = 15);
				

				imagecopyresampled($image_p, $image, 0, 0, 0, 0, 520, 720, 1920, 2688);
				imagejpeg($image_p,$_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/aqic_report/aqicReport02.jpg");
				// imagejpeg($image_p);

				imagedestroy($image);
				imagedestroy($image_p);
				// imagedestroy($mark1);
			//end-create-image
		}else{
			header("Content-Type: image/jpeg");
			$image = imagecreatefromjpeg($_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/aqic_report/aqicReport02.jpg");
			imagejpeg($image);
			imagedestroy($image);
		}
	}
	public function aqicReport3()
	{
		$this->allowed_origin();
		$filename = 'https://www.cmuccdc.org/uploads/reportpm25/report_aqic/aqic_report/aqicReport03.jpg?v='.date('YmdHis');
		if(((@strtotime(date('YmdH0000')) - @strtotime(get_headers($filename,true)['Last-Modified']))/3600)>=12){
			//create-image
				// ini_set('display_errors', 1);
				// ini_set('display_startup_errors', 1);
				// error_reporting(E_ALL);
				$arrContextOptions=array(
					"ssl"=>array(
						"verify_peer"=>false,
						"verify_peer_name"=>false,
					),
				);  
				$file = 'https://thaq.soc.cmu.ac.th/tmp/stn_obs/pm2.5/pm25_all_stn_'.date('Ymd').'08-colored-mask.png';
				$newfile = $_SERVER['DOCUMENT_ROOT'] . '/uploads/reportpm25/report_aqic/aqic_report/pm25_all_stn_08-colored-mask.png';
				
				if ( copy($file, $newfile, stream_context_create($arrContextOptions)) ) {
					$image = imagecreatefrompng("https://www.cmuccdc.org/uploads/reportpm25/report_aqic/aqic_report/pm25_all_stn_08-colored-mask.png");
				}else{
					echo "Copy failed.";
					exit();
				}
				$image_p = imagecreatefromjpeg(base_url('assets/prophecy/assets/image/aqic/aqicReport03.jpg?v=1'));
				// font-color
				$font_path = $_SERVER["DOCUMENT_ROOT"].'/assets/prophecy/assets/font/ThaiSansNeue/ThaiSansNeue-Black.ttf';
				$text_color = imagecolorallocate($image, 0, 31, 92);
				$time_color = imagecolorallocate($image, 129, 56, 14);
				
				//date
				$this->newText($image_p, 100, 0, 0, 15, $text_color, $font_path, date('j') ,$align = "center",$border = false, $width = 165, $height = 80);
				$this->newText($image_p, 35, 0, 0, 95, $text_color, $font_path, ConvertToThaiDate_mm(date('n')).(date('y')+43) ,$align = "center",$border = false, $width = 165, $height = 45);
				//time
				$this->newText($image_p, 25, 0, 0, 140, $time_color, $font_path, '08:00 น.' ,$align = "center",$border = false, $width = 165, $height = 30);
				
				
				imagecopyresampled($image_p, $image, 160, 75, 0, 0, 334, 600, 1280, 2302);
				header("Content-Type: image/jpeg");
				imagejpeg($image_p,$_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/aqic_report/aqicReport03.jpg");
				// imagejpeg($image_p);
				imagedestroy($image_p);
				// header("Content-Type: image/png");
				// imagepng($image);
				imagedestroy($image);
			//end-create-image
		}else{
			header("Content-Type: image/jpeg");
			$image = imagecreatefromjpeg($_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/aqic_report/aqicReport03.jpg");
			imagejpeg($image);
			imagedestroy($image);
		}
	}
	public function aqicReport4()
	{
		$this->allowed_origin();
		$filename = 'https://www.cmuccdc.org/uploads/reportpm25/report_aqic/aqic_report/aqicReport04.jpg?v='.date('YmdHis');
		if(((@strtotime(date('YmdH0000')) - @strtotime(get_headers($filename,true)['Last-Modified']))/3600)>=12){
			//create-image
				$image = imagecreatefromjpeg(base_url('assets/prophecy/assets/image/aqic/aqicReport04.jpg?v=1'));

				// font-color
				$font_path = $_SERVER["DOCUMENT_ROOT"].'/assets/prophecy/assets/font/ThaiSansNeue/ThaiSansNeue-Black.ttf';
				$text_color = imagecolorallocate($image, 0, 31, 92);
				$font_path2 = $_SERVER["DOCUMENT_ROOT"].'/assets/prophecy/assets/font/ThaiSansNeue/ThaiSansNeue-Bold.ttf';
				$text_color2 = imagecolorallocate($image, 0, 0, 0);

				//date
				$this->newText($image, 55, 0, 375, 150, $text_color, $font_path, date('j').' '.ConvertToThaiDate_m(date('n')).' '.(date('Y')+543)  ,$align = "center",$border = false, $width = 400, $height = 55);
				
				// text
				$data_get = json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/stations.json'),true);
				$province = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"].'/assets/prophecy/assets/js/province.json'),true);
				$results = array();
				foreach ($data_get as $key => $value) {
					if((int)$value['daily_pm25'] > 90)
					{
						array_push($results,$province[array_search($value['province_id'],array_column($province, 'province_id'))]['province_name']);
					}
				}
				$results = array_unique($results);
				sort($results);
				$results = array_chunk($results, 5);
				$text = '';
				$h = 325;
				foreach ($results as $key => $value) {
					$str = implode(', ',$value);
					$text = $str.', ';
					$this->newText($image, 18, 0, 375, $h, $text_color2, $font_path2, ($key==0?'จังหวัด ':'').$text."\r\n" ,$align = "left",$border = 1, $width = 550, $height = 20);
					$h+=25;
				}
				header("Content-Type: image/jpeg");
				imagejpeg($image,$_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/aqic_report/aqicReport04.jpg");
				// imagejpeg($image);
				imagedestroy($image);
			//end-create-image
		}else{
			header("Content-Type: image/jpeg");
			$image = imagecreatefromjpeg($_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/aqic_report/aqicReport04.jpg");
			imagejpeg($image);
			imagedestroy($image);
		}
	}
	public function aqicReport5()
	{
		$this->allowed_origin();
		$filename = 'https://www.cmuccdc.org/uploads/reportpm25/report_aqic/aqic_report/aqicReport05.jpg?v='.date('YmdHis');
		if(((@strtotime(date('YmdH0000')) - @strtotime(get_headers($filename,true)['Last-Modified']))/3600)>=12){
			//create-image
				header("Content-Type: image/jpeg");
				$image_p = imagecreatefromjpeg(base_url('assets/prophecy/assets/image/aqic/aqicReport05.jpg?v=1'));
				$image = imagecreatefromjpeg($_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/forecastReport.jpg");

				imagecopyresampled($image_p, $image, 425, 0, 0, 0, 520, 720, 1920, 2688);
				imagejpeg($image_p,$_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/aqic_report/aqicReport05.jpg");
				// imagejpeg($image_p);

				imagedestroy($image);
				imagedestroy($image_p); 
			//end-create-image
		}else{
			header("Content-Type: image/jpeg");
			$image = imagecreatefromjpeg($_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/aqic_report/aqicReport05.jpg");
			imagejpeg($image);
			imagedestroy($image);
		}
	}
	public function aqicReport6()
	{
		$this->allowed_origin();
		$filename = 'https://www.cmuccdc.org/uploads/reportpm25/report_aqic/aqic_report/aqicReport06.jpg?v='.date('YmdHis');
		if(((@strtotime(date('YmdH0000')) - @strtotime(get_headers($filename,true)['Last-Modified']))/3600)>=12){
			//create-image
				$image_p = imagecreatefromjpeg(base_url('assets/prophecy/assets/image/aqic/aqicReport06.jpg?v=1'));
				// $image = imagecreatefromjpeg($_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/hotspot/ex_hotspotReport_4.jpg");
				$image = imagecreatefromjpeg($_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/hotspot/hotspotReport.jpg");

				// font-color
				$font_path = $_SERVER["DOCUMENT_ROOT"].'/assets/prophecy/assets/font/ThaiSansNeue/ThaiSansNeue-Regular.ttf';
				$text_color = imagecolorallocate($image, 0, 0, 0);

				$hotspot = json_decode(file_get_contents('https://cmuccdc.org/api/ccdc_2/hotspot/'.date('Y-m-d', strtotime('-1 day',strtotime(date('Y-m-d')))).'/'.date('Y-m-d')));
				$all = $hotspot->point_total;

				// text
				$title = 'รายงานข้อมูลจุดความร้อน (Hotspot)';
				$date = date('j').' '.ConvertToThaiDate_m(date('n')).' '.(date('Y')+543);
				$text = 'จำนวนจุดความร้อนในประเทศไทย '.$all.' จุด';
				$footer = "จากรายงานจุดความร้อนด้วยระบบ MODIS และ VIIRS\r\n\r\n#MODIS #VIIRS #NASA #GISTDA #GISTNORTH";
				$this->newText($image_p, 20, 0, 510, 200, $text_color, $font_path, $title."\r\n".$date."\r\n\r\n".$text."\r\n\r\n".$footer  ,$align = "center",$border = false, $width = 550, $height = 20);

				// imagecopyresampled($image_p, $image, 25, 90, 0, 0, 480, 454, 2216, 1935);
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, 520, 720, 1920, 2688);
				header("Content-Type: image/jpeg");
				imagejpeg($image_p,$_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/aqic_report/aqicReport06.jpg");
				// imagejpeg($image_p);

				imagedestroy($image);
				imagedestroy($image_p); 
			//end-create-image
		}else{
			header("Content-Type: image/jpeg");
			$image = imagecreatefromjpeg($_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/aqic_report/aqicReport06.jpg");
			imagejpeg($image);
			imagedestroy($image);
		}
	}
	public function aqicAlert()
	{
		$station = json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/stations.json'));
		$data = array();
		foreach($station as $item){
			if($item->pm25>500){
				array_push($data, $item); 
			}
		}
		$result = array();
		if(count($data)>0){
			$sum_datas = array();
			$result['count'] =  count($data);
			$txt = '';
			foreach($data as $item){
				$text = array(
					'id' => $item->id,
					'dustboy_name' => $item->dustboy_name,
					'pm25' => $item->pm25,
				);
				array_push($result,$text);
				$txt .='[ID: '.$item->id.', Name: '.$item->dustboy_name.', PM25: '.$item->pm25.']\n';
		 	}
			
			$flex_message = '{"type":"flex","altText":"พบค่า PM2.5 เกิน 500 (μg/m3)","contents":{"type":"bubble","body":{"type":"box","layout":"vertical","contents":[{"type":"image","url":"https://www.cmuccdc.org/assets/prophecy/assets/image/aqic/alert.jpg","size":"full","aspectMode":"cover","aspectRatio":"9:16","gravity":"top"},{"type":"box","layout":"vertical","contents":[{"type":"box","layout":"vertical","contents":[{"type":"text","size":"xl","color":"#ffffff","weight":"bold","contents":[{"type":"span","text":"พบค่า PM2.5 เกิน 500 (μg/m3)","size":"lg"}]}]},{"type":"box","layout":"baseline","contents":[{"type":"text","color":"#ebebeb","size":"md","flex":0,"contents":[{"type":"span","text":"จำนวน ('.count($data).' จุด) ได้แก่","size":"sm"}]}],"spacing":"lg"},{"type":"box","layout":"vertical","contents":[{"type":"filler"},{"type":"box","layout":"baseline","contents":[{"type":"filler"},{"type":"text","text":"Add to cart","color":"#ffffff","flex":0,"offsetTop":"-2px","contents":[{"type":"span","size":"sm","text":"'.$txt.'"}],"size":"md","wrap":true},{"type":"filler"}],"spacing":"sm"},{"type":"filler"}],"borderWidth":"1px","cornerRadius":"4px","spacing":"sm","borderColor":"#ffffff","margin":"xxl"}],"position":"absolute","offsetBottom":"0px","offsetStart":"0px","offsetEnd":"0px","backgroundColor":"#133664cc","paddingAll":"20px","paddingTop":"18px"},{"type":"box","layout":"vertical","contents":[{"type":"text","text":"NEW","color":"#ffffff","align":"center","size":"xs","offsetTop":"3px"}],"position":"absolute","cornerRadius":"20px","offsetTop":"18px","backgroundColor":"#ff334b","offsetStart":"18px","height":"25px","width":"53px"}],"paddingAll":"0px"},"size":"mega"}}';
			$datas = json_decode($flex_message,true);
			$sum_datas[0] = $datas;
			$messages = [];
			$messages['messages'] = $sum_datas;
			$encodeJson = json_encode($messages);
			file_put_contents('uploads/log/send.json', $encodeJson . PHP_EOL, FILE_APPEND);
			$LINEDatas['url'] = "https://api.line.me/v2/bot/message/broadcast";
			$LINEDatas['token'] = "aJpW91t6DvYP7UGsdIo/DWJxKRS00aYVqKZumJ47M8mKuq0GNcTxGbOuc6uj1yGBtekrLru9vKkpSPWXWd36xjn/0rTiFm27WvflYd0Ib11GfxijzFXzzZvSZldQ9byLDoKkiF2xNzoV0Dk/c9tAoAdB04t89/1O/w1cDnyilFU=";
			$results = $this->sent_message($encodeJson,$LINEDatas);
			file_put_contents('uploads/log/send.json', $encodeJson . PHP_EOL, FILE_APPEND);
		}
	}
	function get_format_text_message($messaging)
    {
        // ประเภทข้อความ
        $type_message = @$messaging['type'];
        // ตัวข้อความ
        $text_message = @$messaging['text'];

        $sum_datas = array();

        if($text_message == 'PM2.5')
		{
            $datas = array(
                'type' => 'text',
                'text' => 'กรุณากดปุ่มพิกัดปัจจุบันเพื่อแสดงข้อมูลฝุ่นบริเวณใกล้เคียง',
                'quickReply' => array(
                    'items' => array()
                )
            );
            // แผนที่
            $datas['quickReply']['items'][0] = array(
                'type' => 'action',
                'action' => array(
                    'type' => 'location',
                    'label' => 'พิกัดปัจจุบัน'
                )
            );
			$datas['quickReply']['items'][1] = array(
                'type' => 'action',
                'action' => array(
                    'type' => 'uri',
                    'label' => 'พิกัดทั้งหมด',
                    'uri' => 'https://pm2_5.nrct.go.th/',
                )
            );
			$datas['quickReply']['items'][2] = array(
                'type' => 'action',
                'action' => array(
                    'type' => 'uri',
                    'label' => 'Open API',
                    'uri' => 'https://www.cmuccdc.org/open-api',
                )
            );

			$sum_datas[0] = $datas;
        }
		else if($type_message == 'location')
		{
			// $messaging['latitude'],$messaging['longitude']
			$data_get = json_decode(file_get_contents('https://www.cmuccdc.org/api/ccdc_2/get_ccdc_last_near/'.$messaging['latitude'].'/'.$messaging['longitude']),true);
			
            $datas = array(
				'type' => 'flex',
				'altText' => 'This is a Flex Message',
				'contents' => array(
					'type' => 'bubble',
					'body' => array(
						'type' => 'box',
						'layout' => 'vertical',
						'contents' => array(),
						'paddingAll' => '0px'
					),
					'size' => 'giga',
				),
			);
			$datas['contents']['body']['contents'][0] = array(
				'type' => 'image',
				'url' => base_url('line/pm25/'.$data_get['pm25'].'?v=2'),
				'size' => 'full',
				'aspectMode' => 'cover',
				'aspectRatio' => '1:1',
				'gravity' => 'center'
			);

			$sum_datas[0] = $datas;
			
			$description = '';
			if($data_get['pm25']<=25){
				$title = 'คุณภาพอากาศดีมาก';
				$description = 'เหมาะสำหรับกิจกรรมกลางแจ้งและการท่องเที่ยว';
			}else if($data_get['pm25']>=26&&$data_get['pm25']<=37){
				$title = 'คุณภาพอากาศดี';
				$description = 'สามารถทำกิจกรรมกลางแจ้งและท่องเที่ยวได้ตามปกติ';
			}else if($data_get['pm25']>=38&&$data_get['pm25']<=50){
				$title = 'คุณภาพอากาศปานกลาง';
				$description = '[ประชาชนทั่วไป] สามารถทำกิจกรรมกลางแจ้งได้ตามปกติ [ประชาชนในกลุ่มเสี่ยง] หากมีอาการเบื้องต้น เช่น ไอ หายใจลำบาก ระคายเคือง ตา ควรลดระยะเวลาการทำกิจกรรมกลางแจ้ง';
			}else if($data_get['pm25']>=51&&$data_get['pm25']<=90){
				$title = 'คุณภาพอากาศแย่';
				$description = '[ประชาชนทั่วไป] ควรเฝ้าระวังสุขภาพ ถ้ามีอาการเบื้องต้น เช่น ไอ หายใจลาบาก ระคาย เคืองตา ควรลดระยะเวลาการทำกิจกรรมกลางแจ้ง หรือใช้อุปกรณ์ป้องกันตนเองหากมีความจำเป็น [ประชาชนในกลุ่มเสี่ยง] ควรลดระยะเวลาการทากิจกรรมกลางแจ้ง หรือใช้อุปกรณ์ ป้องกันตนเองหากมีความจำเป็น ถ้ามีอาการทางสุขภาพ เช่น ไอ หายใจลำบาก ตา อักเสบ แน่นหน้าอก ปวดศีรษะ หัวใจเต้นไม่เป็นปกติ คลื่นไส้ อ่อนเพลีย ควรพบแพทย์';
			}else{
				$title = 'คุณภาพอากาศแย่มาก';
				$description = 'ประชาชนทุกคนควรหลีกเลี่ยงกิจกรรมกลางแจ้ง หลีกเลี่ยงพื้นที่ที่มีมลพิษทางอากาศสูง หรือใช้อุปกรณ์ป้องกันตนเองหากมีความจำเป็น หากมีอาการทางสุขภาพควรพบแพทย์';
			}

			$datas2 = array(
                'type' => 	'text',
                'text' =>	$title."\r\n\r\n".$description."\r\n\r\n"."ปริมาณฝุ่น PM2.5 : ".$data_get['pm25']." มคก./ลบ.ม.\r\nจากจุดวัดฝุ่น : ".$data_get['name']."\r\n\r\n ข้อมูล ณ.วันที่ :\r\n".date('j')."/".date('n')."/".(date('Y')+543)." ".date('H').":00 น.",
            );

			$sum_datas[1] = $datas2;
		}
		else if($type_message == 'broadcast'||$text_message == 'daily')
		{
			$datas = array(
				'type' => 'image',
				'originalContentUrl' => 'https://www.cmuccdc.org/line/daily_api/'.($text_message=='daily'?date('G'):$text_message).'?v='.date('YmdHis'),
				'previewImageUrl' => 'https://www.cmuccdc.org/line/dailyReport_preview_test/'.($text_message=='daily'?date('G'):$text_message).'?v='.date('YmdHis')
			);
			$sum_datas[0] = $datas;

			$data_get = json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/line/line_report_'.date('Ymd').(date('G')-1).'.json'),true);
			
			$title = 'รายงานข้อมูลสถานการณ์คุณภาพอากาศ ณ วัน'.ConvertToThaiDate_l(date('l')).'ที่ '.date('j').' '.ConvertToThaiDate_m(date('n')).' '.(date('Y')+543).' เวลา '.date('G').'.00 น.';
            
			$results = array($data_get['Bkk']['min'],$data_get['Bkk']['max'],$data_get['Central']['min'],$data_get['Central']['max'],$data_get['Northern']['min'],$data_get['Northern']['max'],$data_get['Eastern']['min'],$data_get['Eastern']['max'],$data_get['Southern']['min'],$data_get['Southern']['max']);
            sort($results);
            
			$paragraphBkk = "📍 กรุงเทพฯ มีค่าฝุ่นละอองขนาดเล็ก PM2.5 อยู่ระหว่าง ". $data_get['Bkk']['min'] ." - ". $data_get['Bkk']['max'] ." ug/m3\r\n";
            $paragraphC = "📍 ภาคกลาง มีค่าฝุ่นละอองขนาดเล็ก PM2.5 อยู่ระหว่าง ". $data_get['Central']['min'] ." - ". $data_get['Central']['max'] ." ug/m3\r\n";
            $paragraphN = "📍 ภาคเหนือ มีค่าฝุ่นละอองขนาดเล็ก PM2.5 อยู่ระหว่าง ". $data_get['Northern']['min'] ." - ". $data_get['Northern']['max'] ." ug/m3\r\n";
            $paragraphNE = "📍 ภาคตะวันออกเฉียงเหนือ มีค่าฝุ่นละอองขนาดเล็ก PM2.5 อยู่ระหว่าง ". $data_get['Eastern']['min'] ." - ". $data_get['Eastern']['max'] ." ug/m3\r\n";
            $paragraphS = "📍 ภาคใต้ มีค่าฝุ่นละอองขนาดเล็ก PM2.5 อยู่ระหว่าง ". $data_get['Southern']['min'] ." - ". $data_get['Southern']['max'] ." ug/m3\r\n";
            $paragraphO = "📍 ภาพรวมทั้งประเทศ มีค่าฝุ่นละอองขนาดเล็ก PM2.5 อยู่ระหว่าง ". $results[0] ." - ". end($results) ." ug/m3\r\n\r\n";
            $footer = "อย่าลืมสวมอุปกรณ์ป้องกันตัวเอง\r\n#DustBoy #pm2_5\r\n\r\nที่มา : รายงานค่าฝุ่น PM2.5 (ug/m3) จากจุดติดตั้งเครื่องวัดฝุ่น DustBoy\r\n\r\nศูนย์เฝ้าระวังคุณภาพอากาศ\r\nสำนักงานการวิจัยแห่งชาติ (วช.)\r\nกระทรวงการอุดมศึกษา วิทยาศาสตร์ วิจัยและนวัตกรรม\r\nhttps://pm2_5.nrct.go.th";
            $datas = array(
                'type' => 'text',
                'text' => $title."\r\n\r\n".$paragraphBkk.$paragraphC.$paragraphN.$paragraphNE.$paragraphS.$paragraphO.$footer
            );
			$sum_datas[1] = $datas;
        }
		else if($text_message == 'Forecast&Hotspot')
		{
            $datas = array(
                'type' => 'text',
                'text' => 'กรุณากดเลือกเมนูที่ท่านต้องการ',
                'quickReply' => array(
                    'items' => array()
                )
            );
            // แผนที่
            $datas['quickReply']['items'][0] = array(
				"type" => "action",
				"action" => array(
					"type" => "message",
					"label" => "พยากรณ์ฝุ่น",
					"text" =>"Forecast",
				)
            );
			$datas['quickReply']['items'][1] = array(
				"type" => "action",
				"action" => array(
					'type' => 'uri',
                    'label' => 'จุดความร้อน',
                    'uri' => 'https://pm2_5.nrct.go.th/hotspot'
				)
            );

			$sum_datas[0] = $datas;
        }
		else if($text_message == 'Forecast')
		{
			$datas = array(
				'type' => 'image',
				'originalContentUrl' => 'https://www.cmuccdc.org/line/forecastReport?v='.date('YmdHis'),
				'previewImageUrl' => 'https://www.cmuccdc.org/line/forecastReport_preview_test?v='.date('YmdHis')
			);
			$sum_datas[0] = $datas;

		}
		else if($text_message == 'Hotspot')
		{
			$datas = array(
				'type' => 'image',
				'originalContentUrl' => 'https://www.cmuccdc.org/line/hotspot?v='.date('YmdHis'),
				'previewImageUrl' => 'https://www.cmuccdc.org/line/hotspot_preview?v='.date('YmdHis')
			);
			$sum_datas[0] = $datas;
		}
		else if($text_message == 'Report01')
		{
			$datas = array(
				'type' => 'image',
				'originalContentUrl' => 'https://www.cmuccdc.org/line/aqicReport1?v='.date('YmdHis'),
				'previewImageUrl' => 'https://www.cmuccdc.org/line/aqicReport1?v='.date('YmdHis')
			);
			$sum_datas[0] = $datas;
		}
		else if($text_message == 'Report02')
		{
			$datas = array(
				'type' => 'image',
				'originalContentUrl' => 'https://www.cmuccdc.org/line/aqicReport2?v='.date('YmdHis'),
				'previewImageUrl' => 'https://www.cmuccdc.org/line/aqicReport2?v='.date('YmdHis')
			);
			$sum_datas[0] = $datas;
		}
		else if($text_message == 'Report03')
		{
			$datas = array(
				'type' => 'image',
				'originalContentUrl' => 'https://www.cmuccdc.org/line/aqicReport3?v='.date('YmdHis'),
				'previewImageUrl' => 'https://www.cmuccdc.org/line/aqicReport3?v='.date('YmdHis')
			);
			$sum_datas[0] = $datas;
		}
		else if($text_message == 'Report04')
		{
			$datas = array(
				'type' => 'image',
				'originalContentUrl' => 'https://www.cmuccdc.org/line/aqicReport4?v='.date('YmdHis'),
				'previewImageUrl' => 'https://www.cmuccdc.org/line/aqicReport4?v='.date('YmdHis')
			);
			$sum_datas[0] = $datas;
		}
		else if($text_message == 'Report05')
		{
			$datas = array(
				'type' => 'image',
				'originalContentUrl' => 'https://www.cmuccdc.org/line/aqicReport5?v='.date('YmdHis'),
				'previewImageUrl' => 'https://www.cmuccdc.org/line/aqicReport5?v='.date('YmdHis')
			);
			$sum_datas[0] = $datas;
		}
		else if($text_message == 'Report06')
		{
			$datas = array(
				'type' => 'image',
				'originalContentUrl' => 'https://www.cmuccdc.org/line/aqicReport6?v='.date('YmdHis'),
				'previewImageUrl' => 'https://www.cmuccdc.org/line/aqicReport6?v='.date('YmdHis')
			);
			$sum_datas[0] = $datas;
		}
		else if($text_message == 'More Info')
		{
			$datas = array(
				'type' => 'image',
				'originalContentUrl' => 'https://cmuccdc.org/assets/prophecy/assets/image/aqic/aqicReport07.jpg?v='.date('YmdHis'),
				'previewImageUrl' => 'https://cmuccdc.org/assets/prophecy/assets/image/aqic/aqicReport07.jpg?v='.date('YmdHis')
			);
			$sum_datas[0] = $datas;
		}
		else if($text_message == 'Report')
		{
            $datas = array(
                'type' => 'text',
                'text' => 'กรุณากดเลือกหน้ารายงานที่ท่านต้องการ',
                'quickReply' => array(
                    'items' => array()
                )
            );
            // หน้าปก
            $datas['quickReply']['items'][0] = array(
				"type" => "action",
				"action" => array(
					"type" => "message",
					"label" => "หน้าปก",
					"text" =>"Report01",
				)
            );
			$datas['quickReply']['items'][1] = array(
				"type" => "action",
				"action" => array(
					"type" => "message",
					"label" => "PM2.5",
					"text" => "Report02"
				)
            );
			$datas['quickReply']['items'][2] = array(
				"type" => "action",
				"action" => array(
					"type" => "message",
					"label" => "Visual",
					"text" => "Report03"
				)
            );
			$datas['quickReply']['items'][3] = array(
				"type" => "action",
				"action" => array(
					"type" => "message",
					"label" => "Risk area",
					"text" => "Report04"
				)
            );
			$datas['quickReply']['items'][4] = array(
				"type" => "action",
				"action" => array(
					"type" => "message",
					"label" => "Forecast",
					"text" => "Report05"
				)
            );
			$datas['quickReply']['items'][5] = array(
				"type" => "action",
				"action" => array(
					"type" => "message",
					"label" => "Hotspot",
					"text" => "Report06"
				)
            );
			$datas['quickReply']['items'][6] = array(
				"type" => "action",
				"action" => array(
					"type" => "message",
					"label" => "More Info",
					"text" => "More Info" 
				)
            );

			$sum_datas[0] = $datas;
        }
        return $sum_datas;
    }
	function sent_message($encodeJson,$datas)
    {
        $datasReturn = [];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $datas['url'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $encodeJson,
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer ".$datas['token'],
                "cache-control: no-cache",
                "content-type: application/json; charset=UTF-8",
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            $datasReturn['result'] = 'E';
            $datasReturn['message'] = $err;
        } else {
            if($response == "{}"){
				$datasReturn['result'] = 'S';
				$datasReturn['message'] = 'Success';
            }else{
				$datasReturn['result'] = 'E';
				$datasReturn['message'] = $response;
            }
        }
        return $datasReturn;
    }
	public function message()
	{
		// line data
		$datas = file_get_contents('php://input');
		// file_put_contents('uploads/log/log.json', $datas . PHP_EOL, FILE_APPEND);
		$deCode = json_decode($datas,true);

		//send data
		if($deCode&&$deCode['events'][0]['message']!='hotspot'){
			$messages = [];
			$messages['replyToken'] = $deCode['events'][0]['replyToken'];
			$messages['messages'] = $this->get_format_text_message($deCode['events'][0]['message']);
			$encodeJson = json_encode($messages);
			// file_put_contents('uploads/log/send.json', $encodeJson . PHP_EOL, FILE_APPEND);
			$LINEDatas['url'] = "https://api.line.me/v2/bot/message/reply";
			$LINEDatas['token'] = "aJpW91t6DvYP7UGsdIo/DWJxKRS00aYVqKZumJ47M8mKuq0GNcTxGbOuc6uj1yGBtekrLru9vKkpSPWXWd36xjn/0rTiFm27WvflYd0Ib11GfxijzFXzzZvSZldQ9byLDoKkiF2xNzoV0Dk/c9tAoAdB04t89/1O/w1cDnyilFU=";
			$results = $this->sent_message($encodeJson,$LINEDatas);
		}else if($this->uri->segment(3)&&$this->uri->segment(3)!='hotspot'){
			$messages = [];
			$deCode['message'] = array('type'=>'broadcast','text'=>$this->uri->segment(3));
			$messages['messages'] = $this->get_format_text_message($deCode['message']);
			$encodeJson = json_encode($messages);
			file_put_contents('uploads/log/send.json', $encodeJson . PHP_EOL, FILE_APPEND);
			$LINEDatas['url'] = "https://api.line.me/v2/bot/message/broadcast ";
			$LINEDatas['token'] = "aJpW91t6DvYP7UGsdIo/DWJxKRS00aYVqKZumJ47M8mKuq0GNcTxGbOuc6uj1yGBtekrLru9vKkpSPWXWd36xjn/0rTiFm27WvflYd0Ib11GfxijzFXzzZvSZldQ9byLDoKkiF2xNzoV0Dk/c9tAoAdB04t89/1O/w1cDnyilFU=";
			$results = $this->sent_message($encodeJson,$LINEDatas);
		}
		else if($this->uri->segment(3)=='hotspot'){
			//$this->load->view('prophecy/lineoa/lineoa_hotspot');
		}
		echo 'ok';
	}
	public function broadcast()
	{
		if($this->uri->segment(3)){
			$messages = [];
			$deCode['message'] = array('type'=>'broadcast','text'=>'all');
			$messages['messages'] = $this->get_format_text_message($deCode['message']);
			$encodeJson = json_encode($messages);
			file_put_contents('uploads/log/send.json', $encodeJson . PHP_EOL, FILE_APPEND);
			$LINEDatas['url'] = "https://api.line.me/v2/bot/message/broadcast ";
			$LINEDatas['token'] = "aJpW91t6DvYP7UGsdIo/DWJxKRS00aYVqKZumJ47M8mKuq0GNcTxGbOuc6uj1yGBtekrLru9vKkpSPWXWd36xjn/0rTiFm27WvflYd0Ib11GfxijzFXzzZvSZldQ9byLDoKkiF2xNzoV0Dk/c9tAoAdB04t89/1O/w1cDnyilFU=";
			$results = $this->sent_message($encodeJson,$LINEDatas);
			echo 'ok';
		}
	}
	public function upload_dropzone()
	{
		$dir=$this->uri->segment(3);
		if ($_FILES['file']['name']) {
			if (!$_FILES['file']['error']) {
				$name = date("YmdHis").md5(rand(100, 200));
				$ext = explode('.', $_FILES['file']['name']);
				$type=end($ext);
				$filename = $name . '.' . $type;
				// $destination = 'uploads/fire/'.$dir.'/' . $filename; //change this directory
				$destination = $dir=='drone'||$dir=='report_drone'?'assets/'.$dir.'/'.$filename:'uploads/fire/'.$dir.'/' . $filename; //change this directory
				$location = $_FILES["file"]["tmp_name"];
				move_uploaded_file($location, $destination);
				echo  $filename; //change this URL
			}else{
				echo  $message = 'Oops!  Your upload triggered the following error:  '.$_FILES['file']['error'];
			}
		}
	}
	
		// public function dailyReport()
	// {
	// 	set_time_limit(0);
	// 	$this->allowed_origin();
	// 	$filename = 'https://www.cmuccdc.org/uploads/reportpm25/report_aqic/dailyReport'.empty($this->uri->segment(3))?date('G'):$this->uri->segment(3).'.jpg?v='.date('YmdHis');
	// 	if(empty($this->uri->segment(3))&&((strtotime(date('YmdH0000')) - @strtotime(get_headers($filename,true)['Last-Modified']))/3600)>=0.5){
	// 		//create-image
	// 			if(date('H')<13){
	// 				$image = imagecreatefromjpeg(base_url('assets/prophecy/assets/image/aqic/bg_new_7.jpg?v=2'));
	// 				$time_color = imagecolorallocate($image, 46, 117, 181);
	// 			}else{
	// 				$image = imagecreatefromjpeg(base_url('assets/prophecy/assets/image/aqic/bg_new_4.jpg?v=2'));
	// 				$time_color = imagecolorallocate($image, 255, 192, 0);
	// 			}
	// 			$background_color = imagecolorallocate($image, 255, 255, 255);
	// 			// font-color
	// 			$font_path = $_SERVER["DOCUMENT_ROOT"].'/assets/prophecy/assets/font/ThaiSansNeue/ThaiSansNeue-Black.ttf';
	// 			$text_color = imagecolorallocate($image, 33, 37, 41);
	// 			$temp_color = imagecolorallocate($image, 129, 56, 14);
	// 			//date
	// 			$this->newText($image, 175, 0, 15, 50, $text_color, $font_path, date('j') ,$align = "center",$border = false, $width = 300, $height = 150);
	// 			$this->newText($image, 70, 0, 15, 215, $text_color, $font_path, ConvertToThaiDate_mm(date('n')).(date('y')+43) ,$align = "center",$border = false, $width = 300, $height = 60);
	// 			//temp
	// 			$this->newText($image, 60, 0, 300, 215, $temp_color, $font_path, $this->temp() ,$align = "center",$border = false, $width = 125, $height = 50);
	// 			//time
	// 			$this->newText($image, 90, 0, 305, 310, $time_color, $font_path, date('H').':00 น.' ,$align = "center",$border = false, $width = 375, $height = 80);

	// 			//list pm25
	// 			$font_path = $_SERVER["DOCUMENT_ROOT"].'/assets/prophecy/assets/font/ThaiSansNeue/ThaiSansNeue-ExtraBold.ttf';
	// 			$ar_list = array(
	// 				5281=>null, 5264=>null, 5263=>null, 5265=>null, 5266=>null, 5267=>null,		//1
	// 				5212=>null, 5614=>null, 5615=>null, 5616=>null, 5618=>null, 5278=>null,		//2
	// 				5047=>null, 5031=>null, 5032=>null, 5046=>null, 5399=>null, 5428=>null,		//3
	// 				5315=>null, 5361=>null, 5062=>null, 6008=>null, 110=>null, 5242=>null, 5240=>null, 5243=>null,		//4
	// 				5324=>null, 5291=>null, 5323=>null, 5338=>null, 5337=>null, 5638=>null,		//5
	// 				5072=>null, 6599=>null, 5151=>null, 5152=>null, 5313=>null, 5419=>null, 5420=>null,	5420=>null, 5671=>null,				//6							
	// 				5068=>null, 5635=>null, 5636=>null, 6190=>null, 6191=>null, 6193=>null, 6194=>null, 6195=>null, 5609=>null,		//7	
	// 				// 5356=>null, 6000=>null, 6019=>null, 4013=>null, 6020=>null, 5457=>null, 5357=>null,	//8
	// 				5457=>null, 5356=>null, 6000=>null, 4013=>null, 4070=>null, 5357=>null, 6020=>null, 6242=>null, 5239=>null, //8
	// 				5051=>null, 5051=>null, 5049=>null, 5688=>null, 5677=>null, 5676=>null, 5052=>null, 5405=>null,   	//9
	// 				5444=>null, 5293=>null, 5294=>null, 5295=>null,								//10
	// 				5388=>null, 5643=>null, 5202=>null, 5205=>null, 5200=>null, 5198=>null,		//11
	// 				5344=>null, 5318=>null, 5580=>null,	6132=>null, 6133=>null,					//12
	// 				5342=>null, 5597=>null, 5598=>null,	5464=>null, 5064=>null, 6148=>null,		//13
	// 				5305=>null, 5352=>null, 5417=>null,  5070=>null, 5056=>null, 5055=>null, 	//14
	// 			);
	// 			$uri = 'https://www-old.cmuccdc.org/assets/api/haze/pwa/json/temp/'.date('YmdH').'_stations.json';
	// 			$stations = json_decode(file_get_contents($uri));
	// 			foreach($stations as $item){
	// 				if (array_key_exists($item->id, $ar_list)){
	// 					$ar_list[$item->id] = $item;
	// 				}
	// 			}
	// 			// list1
	// 			$res_ids = array(5281,5264,5263,5265,5266,5267);
	// 			$res = getResult($ar_list, $res_ids);
	// 			if($res!=null){
	// 				$pm25 = $res->pm25;
	// 				$daily_pm25 = $res->daily_pm25;
	// 				$name = $res->dustboy_name;
	// 			}else{
	// 				$pm25 = 'N/A';
	// 				$daily_pm25 = 'N/A';
	// 				$name = 'N/A';
	// 			}
	// 			$x = 245;$y = 460;$text_x = $x;$text_y = $y+35;
	// 			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
	// 			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
	// 			imagesavealpha($mark1, true);
	// 			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
	// 			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

	// 			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
	// 			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
	// 			imagesavealpha($mark1, true);
	// 			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
	// 			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
				
	// 			// list2
	// 			$res_ids = array(5212,5614,5615,5616,5618,5278);
	// 			$res = getResult($ar_list, $res_ids);
	// 			if($res!=null){
	// 				$pm25 = $res->pm25;
	// 				$daily_pm25 = $res->daily_pm25;
	// 				$name = $res->dustboy_name;
	// 			}else{
	// 				$pm25 = 'N/A';
	// 				$daily_pm25 = 'N/A';
	// 				$name = 'N/A';
	// 			}
	// 			$x = 120;$y = 740;$text_x = $x;$text_y = $y+35;
	// 			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
	// 			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
	// 			imagesavealpha($mark1, true);
	// 			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
	// 			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

	// 			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
	// 			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
	// 			imagesavealpha($mark1, true);
	// 			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
	// 			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
				
	// 			// list3
	// 			$res_ids = array(5047,5031,5032,5046,5399,5428);
	// 			$res = getResult($ar_list, $res_ids);
	// 			if($res!=null){
	// 				$pm25 = $res->pm25;
	// 				$daily_pm25 = $res->daily_pm25;
	// 				$name = $res->dustboy_name;
	// 			}else{
	// 				$pm25 = 'N/A';
	// 				$daily_pm25 = 'N/A';
	// 				$name = 'N/A';
	// 			}
	// 			$x = 110;$y = 1010;$text_x = $x;$text_y = $y+35;
	// 			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
	// 			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
	// 			imagesavealpha($mark1, true);
	// 			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
	// 			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

	// 			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
	// 			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
	// 			imagesavealpha($mark1, true);
	// 			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
	// 			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
				
	// 			// list4
	// 			$res_ids = array(5315,5361,5062,6008,110,5242,5240,5243);
	// 			$res = getResult($ar_list, $res_ids);
	// 			if($res!=null){
	// 				$pm25 = $res->pm25;
	// 				$daily_pm25 = $res->daily_pm25;
	// 				$name = $res->dustboy_name;
	// 			}else{
	// 				$pm25 = 'N/A';
	// 				$daily_pm25 = 'N/A';
	// 				$name = 'N/A';
	// 			}
	// 			$x = 330;$y = 1260;$text_x = $x;$text_y = $y+35;
	// 			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
	// 			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
	// 			imagesavealpha($mark1, true);
	// 			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
	// 			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

	// 			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
	// 			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
	// 			imagesavealpha($mark1, true);
	// 			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
	// 			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
				
	// 			// list5
	// 			$res_ids = array(5324,5291,5323,5338,5337,5638);
	// 			$res = getResult($ar_list, $res_ids);
	// 			if($res!=null){
	// 				$pm25 = $res->pm25;
	// 				$daily_pm25 = $res->daily_pm25;
	// 				$name = $res->dustboy_name;
	// 			}else{
	// 				$pm25 = 'N/A';
	// 				$daily_pm25 = 'N/A';
	// 				$name = 'N/A';
	// 			}
	// 			$x = 240;$y = 1500;$text_x = $x;$text_y = $y+35;
	// 			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
	// 			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
	// 			imagesavealpha($mark1, true);
	// 			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
	// 			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

	// 			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
	// 			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
	// 			imagesavealpha($mark1, true);
	// 			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
	// 			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
				
	// 			// list6
	// 			$res_ids = array(5313,5152);
	// 			$res_ids = array(5072, 6599, 5151, 5152, 5313, 5419, 5420, 5671);
	// 			$res = getResult($ar_list, $res_ids);
	// 			if($res!=null){
	// 				$pm25 = $res->pm25;
	// 				$daily_pm25 = $res->daily_pm25;
	// 				$name = $res->dustboy_name;
	// 			}else{
	// 				$pm25 = 'N/A';
	// 				$daily_pm25 = 'N/A';
	// 				$name = 'N/A';
	// 			}
	// 			$x = 260;$y = 1820;$text_x = $x;$text_y = $y+35;
	// 			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
	// 			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
	// 			imagesavealpha($mark1, true);
	// 			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
	// 			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

	// 			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
	// 			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
	// 			imagesavealpha($mark1, true);
	// 			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
	// 			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
				
	// 			// list7
	// 			$res_ids = array(5068,5635,5636,6190,6191,6193,6194, 6195, 5609);
	// 			$res = getResult($ar_list, $res_ids);
	// 			if($res!=null){
	// 				$pm25 = $res->pm25;
	// 				$daily_pm25 = $res->daily_pm25;
	// 				$name = $res->dustboy_name;
	// 			}else{
	// 				$pm25 = 'N/A';
	// 				$daily_pm25 = 'N/A';
	// 				$name = 'N/A';
	// 			}
	// 			$x = 1540;$y = 870;$text_x = $x;$text_y = $y+35;
	// 			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
	// 			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
	// 			imagesavealpha($mark1, true);
	// 			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
	// 			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

	// 			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
	// 			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
	// 			imagesavealpha($mark1, true);
	// 			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
	// 			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
				
	// 			// list8
	// 			// $res_ids = array(5356,6000,6019,4013,6020,5457,5357);
	// 			$res_ids = array(5457,5356,6000,4013,4070,5357,6020,6242,5239);
	// 			$res = getResult($ar_list, $res_ids);
	// 			if($res!=null){
	// 				$pm25 = $res->pm25;
	// 				$daily_pm25 = $res->daily_pm25;
	// 				$name = $res->dustboy_name;
	// 			}else{
	// 				$pm25 = 'N/A';
	// 				$daily_pm25 = 'N/A';
	// 				$name = 'N/A';
	// 			}
	// 			$x = 840;$y = 1010;$text_x = $x;$text_y = $y+35;
	// 			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
	// 			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
	// 			imagesavealpha($mark1, true);
	// 			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
	// 			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

	// 			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
	// 			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
	// 			imagesavealpha($mark1, true);
	// 			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
	// 			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
				
	// 			// list9
	// 			$res_ids = array(5051, 5049, 5688, 5677, 5676, 5052, 5405);
	// 			$res = getResult($ar_list, $res_ids);
	// 			if($res!=null){
	// 				$pm25 = $res->pm25;
	// 				$daily_pm25 = $res->daily_pm25;
	// 				$name = $res->dustboy_name;
	// 			}else{
	// 				$pm25 = 'N/A';
	// 				$daily_pm25 = 'N/A';
	// 				$name = 'N/A';
	// 			}
	// 			$x = 835;$y = 305;$text_x = $x;$text_y = $y+35;
	// 			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
	// 			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
	// 			imagesavealpha($mark1, true);
	// 			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
	// 			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

	// 			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
	// 			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
	// 			imagesavealpha($mark1, true);
	// 			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
	// 			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
				
	// 			// list10
	// 			$res_ids = array(5444,5293,5294,5295);
	// 			$res = getResult($ar_list, $res_ids);
	// 			if($res!=null){
	// 				$pm25 = $res->pm25;
	// 				$daily_pm25 = $res->daily_pm25;
	// 				$name = $res->dustboy_name;
	// 			}else{
	// 				$pm25 = 'N/A';
	// 				$daily_pm25 = 'N/A';
	// 				$name = 'N/A';
	// 			}
	// 			$x = 1290;$y = 350;$text_x = $x;$text_y = $y+35;
	// 			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
	// 			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
	// 			imagesavealpha($mark1, true);
	// 			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
	// 			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

	// 			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
	// 			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
	// 			imagesavealpha($mark1, true);
	// 			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
	// 			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
				
	// 			// list11
	// 			$res_ids = array(5388, 5643, 5202, 5205, 5200, 5198);
	// 			$res = getResult($ar_list, $res_ids);
	// 			if($res!=null){
	// 				$pm25 = $res->pm25;
	// 				$daily_pm25 = $res->daily_pm25;
	// 				$name = $res->dustboy_name;
	// 			}else{
	// 				$pm25 = 'N/A';
	// 				$daily_pm25 = 'N/A';
	// 				$name = 'N/A';
	// 			}
	// 			$x = 1350;$y = 610;$text_x = $x;$text_y = $y+35;
	// 			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
	// 			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
	// 			imagesavealpha($mark1, true);
	// 			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
	// 			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

	// 			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
	// 			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
	// 			imagesavealpha($mark1, true);
	// 			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
	// 			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
				
	// 			// list12
	// 			$res_ids = array(5344,5318,5580,6132,6133);
	// 			$res = getResult($ar_list, $res_ids);
	// 			if($res!=null){
	// 				$pm25 = $res->pm25;
	// 				$daily_pm25 = $res->daily_pm25;
	// 				$name = $res->dustboy_name;
	// 			}else{
	// 				$pm25 = 'N/A';
	// 				$daily_pm25 = 'N/A';
	// 				$name = 'N/A';
	// 			}
	// 			$x = 1450;$y = 1300;$text_x = $x;$text_y = $y+35;
	// 			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
	// 			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
	// 			imagesavealpha($mark1, true);
	// 			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
	// 			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

	// 			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
	// 			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
	// 			imagesavealpha($mark1, true);
	// 			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
	// 			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
				
	// 			// list13
	// 			$res_ids = array(5342,5597,5598,5464,5064,6148);
	// 			$res = getResult($ar_list, $res_ids);
	// 			if($res!=null){
	// 				$pm25 = $res->pm25;
	// 				$daily_pm25 = $res->daily_pm25;
	// 				$name = $res->dustboy_name;
	// 			}else{
	// 				$pm25 = 'N/A';
	// 				$daily_pm25 = 'N/A';
	// 				$name = 'N/A';
	// 			}
	// 			$x = 1010;$y = 1440;$text_x = $x;$text_y = $y+35;
	// 			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
	// 			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
	// 			imagesavealpha($mark1, true);
	// 			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
	// 			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

	// 			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
	// 			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
	// 			imagesavealpha($mark1, true);
	// 			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
	// 			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
				
	// 			// list14
	// 			$res_ids = array(5305, 5352,5417,5070,5056,5055);
	// 			$res = getResult($ar_list, $res_ids);
	// 			if($res!=null){
	// 				$pm25 = $res->pm25;
	// 				$daily_pm25 = $res->daily_pm25;
	// 				$name = $res->dustboy_name;
	// 			}else{
	// 				$pm25 = 'N/A';
	// 				$daily_pm25 = 'N/A';
	// 				$name = 'N/A';
	// 			}
	// 			$x = 950;$y = 1680;$text_x = $x;$text_y = $y+35;
	// 			$text_color = report_type_test($pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 51, 51, 51);
	// 			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/realtime_'.report_type_test($pm25).'.png'));
	// 			imagesavealpha($mark1, true);
	// 			imagecopyresampled($image, $mark1, $x, $y, 0, 0, 150, 150, 896, 918);
	// 			$this->newText($image, 70, 0, $text_x, $text_y, $text_color, $font_path, $pm25 ,$align = "center",$border = false, $width = 150, $height = 60);

	// 			$text_color = report_type_test($daily_pm25)!=3?imagecolorallocate($image, 255, 255, 255):imagecolorallocate($image, 102, 102, 102);
	// 			$mark1 = imagecreatefrompng(base_url('assets/prophecy/assets/image/aqic/24hr_'.report_type_test($daily_pm25).'.png'));
	// 			imagesavealpha($mark1, true);
	// 			imagecopyresampled($image, $mark1, ($x+135), ($y+5), 0, 0, 150, 150, 896, 918);
	// 			$this->newText($image, 50, 0, ($text_x+147), ($text_y+30), $text_color, $font_path, $daily_pm25 ,$align = "center",$border = false, $width = 130, $height = 40);
	// 		//end-create-image
	// 		header("Content-Type: image/jpeg");
	// 		if($this->uri->segment(3)){
	// 			imagejpeg($image,$_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/dailyReport".$this->uri->segment(3).".jpg");
	// 		}else{
	// 			imagejpeg($image,$_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/dailyReport".date('G').".jpg");
	// 		}
	// 		// imagejpeg($image);
	// 		imagedestroy($image);
	// 		imagedestroy($mark1);
	// 		// redirect('line/dailyReport');
	// 	}else{
	// 		header("Content-Type: image/jpeg");
	// 		if($this->uri->segment(3)){
	// 			$image = imagecreatefromjpeg($_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/dailyReport".$this->uri->segment(3).".jpg");
	// 		}else{
	// 			$image = imagecreatefromjpeg($_SERVER["DOCUMENT_ROOT"]."/uploads/reportpm25/report_aqic/dailyReport".date('G').".jpg");
	// 		}
	// 		imagejpeg($image);
	// 		imagedestroy($image);
	// 	}
	// }
}
