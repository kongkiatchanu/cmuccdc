<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function th_strcoll($stringA, $stringB)
{
	$regex = '(^[เแโใไ]*)((.)(.*))';
	$matchesA = $matchesB = null;
	mb_ereg($regex, $stringA, $matchesA);
	mb_ereg($regex, $stringB, $matchesB);

	if ($matchesA[1] !== $matchesB[1] && $matchesA[3] === $matchesB[3]) {
		if ($matchesA[1] === false) {
			return -1;
		} else if ($matchesB[1] === false) {
			return 1;
		} else {
			return strcoll($matchesA[1], $matchesB[1]);
		}
	}
	
	return strcoll($matchesA[2], $matchesB[2]);
}
function color($pm25){
	$color = '';
	// if($pm25>=0&&$pm25<26){    
	// 	$color = '0,191,243';
	// }else if($pm25>=26&&$pm25<38){
	// 	$color = '0,166,81';
	// }else if($pm25>=38&&$pm25<51){
	// 	$color = '253,192,78';
	// }else if($pm25>=51&&$pm25<91){
	// 	$color = '242,101,34';
	// }else if($pm25>=91&&$pm25<1000){
	// 	$color = '205,0,0';
	// }else{
	// 	$color = '255,255,255';
	// }

	if($pm25<=15){
		$color = '0,191,243';
	}else if($pm25>15 && $pm25<=25){
		$color = '0,166,81';
	}else if($pm25>25 && $pm25<=37){
		$color = '253,192,78';
	}else if($pm25>37 && $pm25<=75){
		$color = '242,101,34';
	}else if($pm25>75 && $pm25<=600){
		$color = '205,0,0';
	}else{
		$color = '255,255,255';
	}

	return $color;
}
function color_th($pm25){
	$color = '';
	if($pm25!=null){

		if($pm25<=15){
			$color = array(0,191,243);
		}else if($pm25>15 && $pm25<=25){
			$color = array(0,166,81);
		}else if($pm25>25 && $pm25<=37){
			$color = array(253,192,78);
		}else if($pm25>37 && $pm25<=75){
			$color = array(242,101,34);
		}else if($pm25>75 && $pm25<=600){
			$color = array(205,0,0);
		}else{
			$color = array(205,0,0);
		}
	}else{
		$color = array(101, 101, 101);
	}
	return $color;
}
function color_us($pm25){
	$color = '';
	if($pm25>=1&&$pm25<12){    
		$color = array(0, 153, 107);
	}else if($pm25>=13&&$pm25<=35){
		$color = array(253, 192, 78);
	}else if($pm25>=36&&$pm25<=55){
		$color = array(235, 132, 63);
	}else if($pm25>=56&&$pm25<=150){
		$color = array(205, 0, 0);
	}else if($pm25>=151&&$pm25<=250){
		$color = array(129, 21, 185);
	}else if($pm25>=251&&$pm25<=999){
		$color = array(160, 7, 54);
	}else{
		$color = array(82, 86, 89);
	}
	return $color;
}
function pin_nrct($pm25){
	$pin = '';
	if($pm25!=null){
		// if($pm25>=0&&$pm25<=25.9){    
		// 	$pin = 'pin-01.png';
		// }else if($pm25>=26&&$pm25<=37.9){
		// 	$pin = 'pin-02.png';
		// }else if($pm25>=38&&$pm25<=50.9){
		// 	$pin = 'pin-03.png';
		// }else if($pm25>=51&&$pm25<=90.9){
		// 	$pin = 'pin-04.png';
		// }else{
		// 	$pin = 'pin-05.png';
		// }

		if($pm25<=15){
			$pin = 'pin-01.png';
		}else if($pm25>15 && $pm25<=25){
			$pin = 'pin-02.png';
		}else if($pm25>25 && $pm25<=37){
			$pin = 'pin-03.png';
		}else if($pm25>37 && $pm25<=75){
			$pin = 'pin-04.png';
		}else if($pm25>75 && $pm25<=600){
			$pin = 'pin-05.png';
		}else{
			$pin = 'pin-05.png';
		}

	}else{
		$pin = 'pin-00.png';
	}
	return $pin;
}

function color_us_type($pm25){
	$type = '1';
	if($pm25>=1&&$pm25<=12){    
		$type = '1';
	}else if($pm25>=13&&$pm25<=35){
		$type = '2';
	}else if($pm25>=36&&$pm25<=55){
		$type = '3';
	}else if($pm25>=56&&$pm25<=150){
		$type = '4';
	}else if($pm25>=151&&$pm25<=250){
		$type = '5';
	}else if($pm25>=251&&$pm25<999){
		$type = '6';
	}else{
		$type = '0';
	}
	return $type;
}

function pin_us($pm25){
	$pin = '';
	if($pm25>=1&&$pm25<12){    
		$pin = '/us/1.png';
	}else if($pm25>=13&&$pm25<=35){
		$pin = '/us/2.png';
	}else if($pm25>=36&&$pm25<=55){
		$pin = '/us/3.png';
	}else if($pm25>=56&&$pm25<=150){
		$pin = '/us/4.png';
	}else if($pm25>=151&&$pm25<=250){
		$pin = '/us/5.png';
	}else if($pm25>=251&&$pm25<=999){
		$pin = '/us/6.png';
	}else{
		$pin = '/report_icons/pin-00.png';
	}
	return $pin;
}
function line_nrct($pm25){
	$line = '';
	// if($pm25>=0&&$pm25<=25.9){    
	// 	$line = 'line1.png';
	// }else if($pm25>=26&&$pm25<=37.9){
	// 	$line = 'line2.png';
	// }else if($pm25>=38&&$pm25<=50.9){
	// 	$line = 'line3.png';
	// }else if($pm25>=51&&$pm25<=90.9){
	// 	$line = 'line4.png';
	// }else{
	// 	$line = 'line5.png';
	// }

	if($pm25<=15){
		$line = 'line1.png';
	}else if($pm25>15 && $pm25<=25){
		$line = 'line2.png';
	}else if($pm25>25 && $pm25<=37){
		$line = 'line3.png';;
	}else if($pm25>37 && $pm25<=75){
		$line = 'line4.png';
	}else if($pm25>75 && $pm25<=600){
		$line = 'line5.png';
	}else{
		$line = 'line5.png';
	}

	return $line;
}
function ConvertToThaiDate_l($date) {
	if($date){
		$date == 'Monday'?$date = 'จันทร์':'';
		$date == 'Tuesday'?$date = 'อังคาร':'';
		$date == 'Wednesday'?$date = 'พุธ':'';
		$date == 'Thursday'?$date = 'พฤหัสบดี':'';
		$date == 'Friday'?$date = 'ศุกร์':'';
		$date == 'Saturday'?$date = 'เสาร์':'';
		$date == 'Sunday'?$date = 'อาทิตย์':'';
		return $date;
	}else{
		return "<font color=\"#FF0000\">ไม่ระบุ</font>";
	}	
}
function ConvertToThaiDate_m($date) {
	if($date){
		$date == 1?$date = 'มกราคม':'';
		$date == 2?$date = 'กุมภาพันธ์':'';
		$date == 3?$date = 'มีนาคม':'';
		$date == 4?$date = 'เมษายน':'';
		$date == 5?$date = 'พฤษภาคม':'';
		$date == 6?$date = 'มิถุนายน':'';
		$date == 7?$date = 'กรกฎาคม':'';
		$date == 8?$date = 'สิงหาคม':'';
		$date == 9?$date = 'กันยายน':'';
		$date == 10?$date = 'ตุลาคม':'';
		$date == 11?$date = 'พฤศจิกายน':'';
		$date == 12?$date = 'ธันวาคม':'';
		return $date;
	}else{
		return "<font color=\"#FF0000\">ไม่ระบุ</font>";
	}	
}
function ConvertToThaiDate_mm($date) {
	if($date){
		$date == 1?$date = 'ม.ค.':'';
		$date == 2?$date = 'ก.พ.':'';
		$date == 3?$date = 'มี.ค.':'';
		$date == 4?$date = 'เม.ย.':'';
		$date == 5?$date = 'พ.ค.':'';
		$date == 6?$date = 'มิ.ย.':'';
		$date == 7?$date = 'ก.ค.':'';
		$date == 8?$date = 'ส.ค.':'';
		$date == 9?$date = 'ก.ย.':'';
		$date == 10?$date = 'ต.ค.':'';
		$date == 11?$date = 'พ.ย.':'';
		$date == 12?$date = 'ธ.ค.':'';
		return $date;
	}else{
		return "<font color=\"#FF0000\">ไม่ระบุ</font>";
	}	
}
function ConvertToThaiDate_ll($date) {
	if($date){
		$date == 'Monday'?$date = 'จันทร์':'';
		$date == 'Tuesday'?$date = 'อังคาร':'';
		$date == 'Wednesday'?$date = 'พุธ':'';
		$date == 'Thursday'?$date = 'พฤหัส':'';
		$date == 'Friday'?$date = 'ศุกร์':'';
		$date == 'Saturday'?$date = 'เสาร์':'';
		$date == 'Sunday'?$date = 'อาทิตย์':'';
		return $date;
	}else{
		return "<font color=\"#FF0000\">ไม่ระบุ</font>";
	}	
}
function ConvertToThaiDateMonth($strDate,$short)
{
	if($short){
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
	}else{
		$strMonthCut = array(1=>"มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
	}
	$strYear = date("Y",strtotime($strDate))+543;
	$strMonth= date("n",strtotime($strDate));
	$strDay= date("j",strtotime($strDate));
	$strHour= date("H",strtotime($strDate));
	$strMinute= date("i",strtotime($strDate));
	$strSeconds= date("s",strtotime($strDate));
	
	$strMonthThai=$strMonthCut[$strMonth];
	return "$strMonthThai $strYear";
}
function ConvertToThaiDateHeader ($strDate) {
	$nameOfDay = date('D', strtotime($strDate));
	$arDayName =array(
		'Sun'=>	'วันอาทิตย์',
		'Mon'=>	'วันจันทร์',
		'Tue'=>	'วันอังคาร',
		'Wed'=>	'วันพุธ',
		'Thu'=>	'วันพฤหัสบดี',
		'Fri'=>	'วันศุกร์',
		'Sat'=>	'วันเสาร์',
	);
	return $arDayName[$nameOfDay];
}
function report_type_test($val){
	if($val<=15){
		$txt = '1';
	}else if($val>15 && $val<=25){
		$txt = '2';
	}else if($val>25 && $val<=37){
		$txt = '3';
	}else if($val>37 && $val<=75){
		$txt = '4';
	}else if($val>75 && $val<=600){
		$txt = '5';
	}else{
		$txt = '5';
	}
	return $txt;
}

function getResult($ar_list,$ar){
	foreach($ar as $id){
		if($ar_list[$id]!=null){
			return $ar_list[$id];
			exit;
		}
	}
}
function getProfileDateEN($date,$short){
	if($date){
		if($short){
			$MONTH = array("", "1","2","3","4","5","6","7","8","9","10","11","12");
		}else{
			$MONTH = array(1=>"January","February","March","April","May","June","July","August","September","October","November","December");
		}
		$dt = explode("-", $date);
		$tyear = $dt[0];
		$dt[0] = $dt[2] +0;
		$dt[1] = $MONTH[$dt[1]+0];
		$dt[2] = $tyear;
		return join(" ", $dt);
	}else{
		return "<font color=\"#FF0000\">ไม่ระบุ</font>";
	}
}
function getProfilehourEN($date){
	if($date){
		return substr($date,11,5);
	}else{
		return "<font color=\"#FF0000\">ไม่ระบุ</font>";
	}
}