<?php 
	function translate($label){
		$ci=& get_instance();
		$rs=$ci->lang->line($label);
		if($rs){
			return $rs;
		}else{
			return $label;
		}
	}
	
	function getCategoryID($uri){
		$ar_cat = array(
			'effect'=>4,
			'activities'=>5,
			'message'=>6,
			'information'=>9,
		);
		return $ar_cat[$uri];
	}

	function ConvertToThaiDate ($date,$short) {
		
		if($date){
			if($short){
				$MONTH = array("", "ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
			}else{
				$MONTH = array(1=>"มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
			}
			$dt = explode("-", $date);
			$tyear = (int)$dt[0];
			$dt[0] = (int)$dt[2] +0;
			$dt[1] = $MONTH[$dt[1]+0];
			$dt[2] = (int)$tyear+543;
			return join(" ", $dt);
		}else{
			return "<font color=\"#FF0000\">ไม่ระบุ</font>";
		}	
	}
	
	function ConvertToThaiDateForcast ($date,$short) {
		
		if($date){
			if($short){
				$MONTH = array("", "ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
			}else{
				$MONTH = array(1=>"มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
			}
			$dt = explode("-", $date);
			$tyear = (int)$dt[0];
			$dt[0] = (int)$dt[2] +0;
			$dt[1] = $MONTH[$dt[1]+0];
			$dt[2] = (int)$tyear+543;
			return join(" ", $dt);
		}else{
			return "<font color=\"#FF0000\">ไม่ระบุ</font>";
		}	
	}
	
	function getAVGDays($date,$short){
		if($date){
			if($short){
				$MONTH = array("", "ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
			}else{
				$MONTH = array(1=>"มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
			}
			$dt = explode("-", $date);
			$tyear = (int)$dt[0];
			$dt[0] = (int)$dt[2] +0;
			$dt[1] = $MONTH[$dt[1]+0];
			$dt[2] = (int)$tyear+543;
			return join(" ", $dt).' เวลา 00:00-'.substr($date,11,5).' น.';
		}else{
			return "<font color=\"#FF0000\">ไม่ระบุ</font>";
		}	
	}
	
	function getProfileDate($date,$short){
		if($date){
			if($short){
				$MONTH = array("", "ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
			}else{
				$MONTH = array(1=>"มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
			}
			$dt = explode("-", $date);
			$tyear = (int)$dt[0];
			$dt[0] = (int)$dt[2] +0;
			$dt[1] = $MONTH[$dt[1]+0];
			$dt[2] = (int)$tyear+543;
			return join(" ", $dt);
		}else{
			return "<font color=\"#FF0000\">ไม่ระบุ</font>";
		}
	}
	function getProfilehour($date){
		if($date){
			return substr($date,11,5).' น.';
		}else{
			return "<font color=\"#FF0000\">ไม่ระบุ</font>";
		}
	}
	
	function getAVGHour($date,$short){
		if($date){
			if($short){
				$MONTH = array("", "ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
			}else{
				$MONTH = array(1=>"มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
			}
			$dt = explode("-", $date);
			$tyear = (int)$dt[0];
			$dt[0] = (int)$dt[2] +0;
			$dt[1] = $MONTH[$dt[1]+0];
			$dt[2] = (int)$tyear+543;
			return join(" ", $dt).' เวลา '.substr($date,11,5).' น.';
		}else{
			return "<font color=\"#FF0000\">ไม่ระบุ</font>";
		}	
	}
	
	function getDustboyVersion($id){
		$text = '[';
		if($id<5000){
			$text .= 'PRO' ;
		}else{
			$text .= 'IN' ;
		}
		if($id>2000 && $id<3000){
			$text .= '-NB' ;
		}
		$text .= ']';
		
		return $text;
	}
	
	function txtDescription($txt,$shot){
		return strip_tags(mb_substr($txt,0,$shot,'utf-8'));
		
	}
	
	function addhttp($url) {
		if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
			$url = "http://" . $url;
		}
		return $url;
	}
	
	function calAQIPM10($val){
	
		if($val<=50){
			$data = (((25-0)*($val-0))/(50-0))+0;
		}else if(($val<=80) && ($val>50)){
			$data = (((50-25)*($val-50))/(80-50))+25;
		}else if(($val<=120) && ($val>80)){
			$data = (((100-50)*($val-80))/(120-80))+50;
		}else if(($val<=180) && ($val>120)){
			$data = (((200-100)*($val-120))/(180-120))+100;
		}else if(($val<=600) && ($val>180)){
			$data = (((500-200)*($val-180))/(600-180))+300;
		}else{
			$data = 500;
		}
		return number_format($data,2);
	}
	
	function map($v,$v1,$v2,$a1,$a2){
		return round($a1+ ($a2-$a1)*($v-$v1)/($v2-$v1));
	}

	function calAQIPM25($val){
		/*
		if($val<=25){
			$data = (((25-0)*($val-0))/(25-0))+0;
		}else if($val<=37 && $val>25){
			$data = (((50-26)*($val-26))/(37-26))+26;
		}else if($val<=50 && $val>37){
			$data = (((100-51)*($val-38))/(50-38))+51;
		}else if($val<=90 && $val>50){
			$data = (((200-101)*($val-51))/(90-51))+101;
		}else if($val<=600 && $val>90){
			$data = (((500-201)*($val-91))/(600-91))+201;
		}else{
			$data = 500;
		}
		return number_format($data,2);*/
		if(round($val)<=25){
			$data =map(round($val),0,25,0,25);
		}else if(round($val)>25 && round($val)<=37){
			$data = map(round($val),26,37,26,50);
		}else if(round($val)>37 && round($val)<=50){
			$data = map(round($val),38,50,51,100);
		}else if(round($val)>50 && round($val)<=90){
			$data = map(round($val),51,90,101,200);
		}else if(round($val)>90){
			$data = round($val)-90+200;
		}
		return $data;
	}
	
	function report_type($val){
		if($val<=50){
			$txt = 'good';
		}else if($val>50 && $val<=100){
			$txt = 'moderate';
		}else if($val>100 && $val<=200){
			$txt = 'unhealthy';
		}else if($val>200 && $val<=300){
			$txt = 'very-unhealthy';
		}else if($val>300 && $val<=600){
			$txt = 'hazardous';
		}else{
			$txt = 'hazardous';
		}
		return $txt;
		
	}

	function report_typePM10($val){
		if($val>0){
			if($val<=50){
				$txt = 'good';
			}else if($val>50 && $val<=80){
				$txt = 'moderate';
			}else if($val>80 && $val<=120){
				$txt = 'unhealthy';
			}else if($val>120 && $val<=180){
				$txt = 'very-unhealthy';
			}else if($val>180 && $val<=600){
				$txt = 'hazardous';
			}else{
				$txt = 'hazardous';
			}
		}else{
			$txt = 'vempty';
		}
		return $txt;
	}
	
	function report_typePM25($val){
		if($val>0){
			if($val<=25){
				$txt = 'good';
			}else if($val>25 && $val<=37){
				$txt = 'moderate';
			}else if($val>37 && $val<=50){
				$txt = 'unhealthy';
			}else if($val>50 && $val<=90){
				$txt = 'very-unhealthy';
			}else if($val>90 && $val<=600){
				$txt = 'hazardous';
			}else{
				$txt = 'hazardous';
			}
		}else{
			$txt = 'vempty';
		}
		return $txt;
	}
	
	function report_typeAQI($val){
		if($val>0){
			if($val<=25){
				$txt = 'good';
			}else if($val>25 && $val<=50){
				$txt = 'moderate';
			}else if($val>50 && $val<=100){
				$txt = 'unhealthy';
			}else if($val>100 && $val<=200){
				$txt = 'very-unhealthy';
			}else if($val>200 && $val<=600){
				$txt = 'hazardous';
			}else{
				$txt = 'hazardous';
			}
		}else{
			$txt = 'vempty';
		}
		return $txt;
	}
	
	function od_display($val){
		if($val>0){
			if($val<=25){
				$txt = 'good';
			}else if($val>25 && $val<=50){
				$txt = 'mod';
			}else if($val>50 && $val<=100){
				$txt = 'un';
			}else if($val>100 && $val<=200){
				$txt = 'veryun';
			}else if($val>200 && $val<=600){
				$txt = 'haza';
			}else{
				$txt = 'haza';
			}
		}else{
			$txt = 'vempty';
		}
		return $txt;
	}
	
	function calAQIImg($val){
		if($val>0){
			if($val<=25){
				$img = 1;
			}else if($val>25 && $val<=50){
				$img = 2;
			}else if($val>50 && $val<=100){
				$img = 3;
			}else if($val>100 && $val<=200){
				$img = 4;
			}else if($val>200 && $val<=600){
				$img = 5;
			}else{
				$img = 5;
			}
		}else{
			$img = 0;
		}
		return $img;
	}
	
	function getStationsGroup($s){
		
		
		$name = array(
			' Other ', 
			' CNX ', 
			' BKK ', 
			' Southeast Asia ', 
			' Meahongson ', 
			' Phayao  ', 
			' Phrae ', 
			' Chiang rai ', 
			' Tak ', 
			' Lampang ',
			' Lamphun ',
			' Nan '
			);

		return trim($name[$s]);
	}
	
	function usPM25AQI($val){
		$data = 0;
		if($val>0){
			if($val<=12){
				$data=(((50-0)*($val-0))/(12-0))+0;
			}
			else if( ($val<=35.4) && ($val>12) ){
				$data=(((100-50)*($val-12))/(35.4-12))+50;
			}
			else if( ($val<=55.4) && ($val>35.4) ){
				$data=(((150-100)*($val-35.4))/(55.4-35.4))+100;
			}
			else if( ($val<=150.4) && ($val>55.4) ){
				$data=(((200-150)*($val-55.4))/(150.4-55.4))+150;
			}
			else if( ($val<=250.4) && ($val>150.4) ){
				$data=(((300-200)*($val-150.4))/(250.4-150.4))+200;
			}
			else if( ($val<=350.4) && ($val>250.4) ){
				$data=(((400-300)*($val-250.4))/(350.4-250.4))+300;
			}
			else if( ($val>350.4) ){
				$data=(((500-400)*($val-350.4))/(500.4-350.4))+400;
			}
			return number_format($data,2);
		}
	}
	function usPM10AQI($val){
		$data = 0;
		if($val>0){
			if($val<=54){
				$data=(((50-0)*($val-0))/(54-0))+0;
			}
			else if(($val<=154) && ($val>54)){
				$data=(((100-50)*($val-54))/(154-54))+50;
			}
			else if(($val<=254) && ($val>154)){
				$data=(((150-100)*($val-154))/(254-154))+100;
			}
			else if(($val<=354) && ($val>254)){
				$data=(((200-150)*($val-254))/(354-254))+150;
			}
			else if(($val<=424) && ($val>354)){
				$data=(((300-200)*($val-354))/(424-354))+200;
			}
			else if(($val<=504) && ($val>424)){
				$data=(((400-300)*($val-424))/(504-424))+300;
			}
			else if(($val>504)){
				$data=(((500-400)*($val-504))/(604-504))+400;
			}
			return number_format($data,2);
		}
	}
	
	function report_typeUSAQI($val){
		$data = 0;
		if($val>0){
			if($val<=50){
				$data="bg-green";
			}
			else if(($val<=100) && ($val>50)){
				$data="bg-yellow";
			}
			else if(($val<=150) && ($val>100)){
				$data="bg-orange";
			}
			else if(($val<=200) && ($val>150)){
				$data="bg-red";
			}
			else if(($val<=300) && ($val>200)){
				$data="bg-purper";
			}
			else if(($val<=500) && ($val>300)){
				$data="bg-blood";
			}
			else if(($val>504)){
				$data="bg-blood";
			}
			return $data;
		}
	}
	
	function report_typeUSAQI2($val){
		$data = 0;
		if($val>0){
			if($val<=54){
				$data="bg-green";
			}
			else if(($val<=154) && ($val>54)){
				$data="bg-yellow";
			}
			else if(($val<=254) && ($val>154)){
				$data="bg-orange";
			}
			else if(($val<=354) && ($val>254)){
				$data="bg-red";
			}
			else if(($val<=424) && ($val>354)){
				$data="bg-purper";
			}
			else if(($val<=504) && ($val>424)){
				$data="bg-blood";
			}
			else if(($val>500)){
				$data="bg-blood";
			}
			return $data;
		}
	}
	
	function calUSAQIImg($val){
		$data = 0;
		if($val>0){
			if($val<=50){
				$data="us_1";
			}
			else if(($val<=100) && ($val>50)){
				$data="us_2";
			}
			else if(($val<=150) && ($val>100)){
				$data="us_3";
			}
			else if(($val<=200) && ($val>150)){
				$data="us_4";
			}
			else if(($val<=300) && ($val>200)){
				$data="us_5";
			}
			else if(($val<=500) && ($val>300)){
				$data="us_6";
			}
			else if(($val>500)){
				$data="us_6";
			}
			return $data;
		}
	}
	
	function calUSAQIImg2($val){
		$data = 0;
		if($val>0){
			if($val<=54){
				$data="us_1";
			}
			else if(($val<=154) && ($val>54)){
				$data="us_2";
			}
			else if(($val<=254) && ($val>154)){
				$data="us_3";
			}
			else if(($val<=354) && ($val>254)){
				$data="us_4";
			}
			else if(($val<=424) && ($val>354)){
				$data="us_5";
			}
			else if(($val<=504) && ($val>424)){
				$data="us_6";
			}
			else if(($val>504)){
				$data="us_6";
			}
			return $data;
		}
	}
	
	function getDBModel(){
		$ar = array(
			'PRO' 	=>'Model PRO',
			'IN' 	=>'Model IN', 
			'N'		=>'Model N', 
			'P'		=>'Model P',
			'NB-CMMC'	=>'Model NB-CMMC',
			'NB-TIC'	=>'Model NB-TIC',
			'T-Plus'	=>'Model T Plus',
			'LED'		=>'LED',
			'NH-CMMC'		=>'NH-CMMC',
			'Smart-Meter'		=>'Smart-Meter',
			'DB-BLACK'		=>'Dustboy Black',
			'WPLUS'		=>'WPlus',
		);
		return $ar;
	}

	function getHospital($id=null){
		$ar_hospital = array(
			'10713'	=> 'โรงพยาบาลนครพิงค์',
			'11119'	=> 'โรงพยาบาลจอมทอง',
			'11120'	=> 'โรงพยาบาลเทพรัตนเวชชานุกูล เฉลิมพระเกียรติ ๖๐ พรรษา',
			'11121'	=> 'โรงพยาบาลเชียงดาว',
			'11122'	=> 'โรงพยาบาลดอยสะเก็ด',
			'11123'	=> 'โรงพยาบาลแม่แตง',
			'11124'	=> 'โรงพยาบาลสะเมิง',
			'11125'	=> 'โรงพยาบาลฝาง',
			'11126'	=> 'โรงพยาบาลแม่อาย',
			'11127'	=> 'โรงพยาบาลพร้าว',
			'11128'	=> 'โรงพยาบาลสันป่าตอง',
			'11129'	=> 'โรงพยาบาลสันกำแพง',
			'11131'	=> 'โรงพยาบาลหางดง',
			'11132'	=> 'โรงพยาบาลฮอด',
			'11133'	=> 'โรงพยาบาลดอยเต่า',
			'11134'	=> 'โรงพยาบาลอมก๋อย',
			'11135'	=> 'โรงพยาบาลสารภี',
			'11137'	=> 'โรงพยาบาลไชยปราการ',
			'11138'	=> 'โรงพยาบาลแม่วาง',
		);
		
	
		return $id!=''? $ar_hospital[$id]:$ar_hospital;

	}

	function getDisease($id){
		$ar = array(
			'I00'	=> 'กลุ่มโรคหัวใจและหลอดเลือดรวมทุกชนิด',
				'I64'	=> 'อัมพาตฉับพลัน',
				'I21'	=> 'กล้ามเนื้อหัวใจตายฉับพลัน',
				'I50'	=> 'หัวใจล้มเหลว',
				'I60'	=> 'หลอดเลือดสมอง',
				'I67'	=> 'หลอดเลือดสมองอื่น',
			'J00'	=> 'กลุ่มโรคทางเดินหายใจรวมทุกชนิด',
				'J10'	=> 'ไข้หวัดใหญ่ร่วมกับปอดบวม ตรวจพบไวรัสไข้หวัดใหญ่',
				'J11'	=> 'ไข้หวัดใหญ่ร่วมกับปอดบวม ตรวจไม่พบไวรัสไข้หวัดใหญ่',
				'J12'	=> 'ปอดบวม',
				'J44'	=> 'ปอดอุดกั้นเรื้อรัง',
				'J45'	=> 'หืด',
				'J46'	=> 'หืดในระยะเฉียบพลัน',
		);
		return $ar[$id];
	}
?>