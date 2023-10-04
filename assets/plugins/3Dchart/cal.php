<?php 

function calAQIPM10($val){
	if($val<=40){
		$data = (((50-0)*($val-0))/(40-0))+0;
	}else if($val>40 && $val<=120){
		$data=(((100-50)*($val-40))/(120-40))+50;
	}else if($val>120 && $val<=350){
		$data=(((200-100)*($val-120))/(350-120))+100;
	}else if($val>350 && $val<=420){
		$data=(((300-200)*($val-350))/(420-350))+200;
	}else if($val>420 && $val<=600){
		$data=(((500-300)*($val-420))/(600-420))+300;
	}else{
		$data=500;
	}
	return $data;
}


function calAQIPM25($val){
	if($val<=25){
		$data = (((50-0)*($val-0))/(25-0))+0;
	}else if($val>25 && $val<=50){
		$data = (((100-50)*($val-25))/(50-25))+50;
	}else if($val>50 && $val<=150){
		$data = (((200-100)*($val-50))/(150-50))+100;
	}else if($val>150 && $val<=250){
		$data=(((300-200)*($val-150))/(200-150))+200;
	}else if($val>250 && $val<=500){
		$data=(((500-300)*($val-250))/(500-250))+300;
	}else{
		$data=500;
	}
	return $data;
}

?>