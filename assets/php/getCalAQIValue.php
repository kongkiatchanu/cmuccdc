<?php 

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
		//return number_format($data,2);
	}
	
function calUSAQIPM25($val){
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
			return number_format($data,1);
		}
	}

function calUSAQIPM10($val){
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
			return number_format($data,1);
		}
	}
$func = $_GET['cal'];

if($func=="us"){
	if(!empty($_GET['v'])){
	
		if($_GET['t']=="10"){
			echo calUSAQIPM10($_GET['v']);
		}else if($_GET['t']=="25"){
			echo calUSAQIPM25($_GET['v']);
		}

	}
	
	
}else{
	if(!empty($_GET['v'])){
	
		if($_GET['t']=="10"){
			echo calAQIPM10($_GET['v']);
		}else if($_GET['t']=="25"){
			echo calAQIPM25($_GET['v']);
		}

	}
	
}


	

	

?>