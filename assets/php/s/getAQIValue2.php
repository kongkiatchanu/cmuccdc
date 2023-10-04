<?php 
include "connect.php";

	$sql="SELECT * FROM airinfo ORDER BY air_id ASC ";
	$q=$mysqli->query($sql);
	$air_data = array();
	while($air_detail=$q->fetch_assoc()){
		array_push($air_data,$air_detail);
	}


$messages = array();

function report_type($val){
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
		return $txt;
}

function report_txt($val,$air_data){

	if($val<=25){
		$txt = $air_data[0]['air_detail'];
	}else if($val>25 && $val<=50){
		$txt = $air_data[1]['air_detail'];
	}else if($val>50 && $val<=100){
		$txt = $air_data[2]['air_detail'];
	}else if($val>100 && $val<=200){
		$txt = $air_data[3]['air_detail'];
	}else if($val>300 && $val<=600){
		$txt = $air_data[4]['air_detail'];
	}else{
		$txt = $air_data[4]['air_detail'];
	}
	return $txt;
}

function calAQIPM10($val){
	if($val<=50){
		$data = (((25-0)*($val-0))/(50-0))+0;
	}else if($val>50 && $val<=80){
		$data=(((50-25)*($val-50))/(80-50))+25;
	}else if($val>80 && $val<=120){
		$data=(((100-50)*($val-80))/(120-80))+50;
	}else if($val>120 && $val<=180){
		$data=(((200-100)*($val-120))/(180-120))+100;
	}else if($val>180 && $val<=600){
		$data=(((500-200)*($val-180))/(600-180))+300;
	}else{
		$data=500;
	}
	return number_format($data);
}

function calAQIPM10txt($val){
	if($val<=25){
		$txt = 'ดี';
	}else if($val>25 && $val<=50){
		$txt = 'ปานกลาง';
	}else if($val>50 && $val<=100){
		$txt = 'มีผลกระทบต่อสุขภาพ';
	}else if($val>100 && $val<=200){
		$txt = 'มีผลกระทบต่อสุขภาพมาก';
	}else if($val>200 && $val<=600){
		$txt = 'อันตราย';
	}else{
		$txt = 'อันตราย';
	}
	return $txt;
}

function calAQIPM10Img($val){
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
	return $img;
}

function calAQIPM25($val){
	if($val<=25){
		$data = (((25-0)*($val-0))/(25-0))+0;
	}else if($val>25 && $val<=37){
		$data = (((50-25)*($val-25))/(37-25))+25;
	}else if($val>37 && $val<=50){
		$data = (((100-50)*($val-37))/(50-37))+50;
	}else if($val>50 && $val<=90){
		$data=(((200-100)*($val-50))/(90-50))+100;
	}else if($val>90 && $val<=600){
		$data=(((500-200)*($val-90))/(600-90))+300;
	}else{
		$data=500;
	}
	return number_format($data);
}

$ver = md5('s'.date('ymdh'));
//echo $ver;

if(!empty($_GET['s'])){
	if($_GET['key']==$ver){
		$s = mysqli_real_escape_string($mysqli,$_GET['s']);
		if($_GET['avg']=='hr'){
			$sql="SELECT 
			ROUND(avg(log_data_2562.log_pm10),2) as log_pm10,
			ROUND(avg(log_data_2562.log_pm25),2) as log_pm25,
			ROUND(avg(log_data_2562.log_wind),2) as log_wind,
			ROUND(avg(log_data_2562.temp),0) as temp,
			ROUND(avg(log_data_2562.humid),2) as humid,
			source.location_id,
			source.location_name,
			DATE_FORMAT(log_data_2562.log_datetime, '%d %M %Y') as thaidate ,
			log_data_2562.log_datetime 
		FROM log_data_2562 
		left join source on log_data_2562.source_id = source.source_id
		WHERE 
		log_data_2562.source_id ={$s} AND
		log_datetime 
				BETWEEN ( DATE_SUB( NOW() , INTERVAL 1 hour  ) )
				AND ( NOW() ) 
				
				order by log_datetime desc LIMIT 1";
		}else if($_GET['avg']=='24hr'){
			$sql="SELECT 
			ROUND(avg(log_data_2562.log_pm10),2) as log_pm10,
			ROUND(avg(log_data_2562.log_pm25),2) as log_pm25,
			ROUND(avg(log_data_2562.log_wind),2) as log_wind,
			ROUND(avg(log_data_2562.temp),0) as temp,
			ROUND(avg(log_data_2562.humid),2) as humid,
			source.location_id,
			source.location_name,
			DATE_FORMAT(log_data_2562.log_datetime, '%d %M %Y') as thaidate ,
			log_data_2562.log_datetime 
		FROM log_data_2562 
		left join source on log_data_2562.source_id = source.source_id
		WHERE 
		log_data_2562.source_id ={$s} AND
		log_datetime 
				BETWEEN ( DATE_SUB( NOW() , INTERVAL 24 hour  ) )
				AND ( NOW() ) 
				
				order by log_datetime desc LIMIT 1";
		}

		
		/*
		BETWEEN ( DATE_SUB( NOW() , INTERVAL 1 hour  ) )
				AND ( NOW() ) 
		BETWEEN ( DATE_SUB( NOW() , INTERVAL 3 hour  ) )
				AND ( DATE_SUB( NOW() , INTERVAL 1 hour  ) ) 
		*/

		$q=$mysqli->query($sql);
		$rs=$q->fetch_assoc();
		$time = ' n/a';
		if($rs["thaidate"]!=null){
			$time = ', '.(substr(@$rs["log_datetime"],11,2)-1).':00 น. - '.substr($rs["log_datetime"],11,2).':00 น.';
		}
		if($_GET['type']=="pm10"){
			$messages["log_pm10"] =$rs["log_pm10"];
			$messages["value"] =calAQIPM10($rs["log_pm10"]);
			$messages["txt"] = calAQIPM10txt(calAQIPM10($rs["log_pm10"]));
			$messages["name"] = $rs["location_id"].' - '.$rs["location_name"];
			if($_GET['avg']=='hr'){
				$messages["date"] = $rs["thaidate"].$time;
			}else{
				$messages["date"] = 'average 24 hour';
			}
			$messages["img"] = '<img style="margin:0 auto;width:80%;" src="/template/img/ccdc-0'.calAQIPM10Img(calAQIPM10($rs["log_pm10"])).'-en.png">';
			$messages["img_url"] = 'https://www.cmuccdc.org/template/img/ccdc-0'.calAQIPM10Img(calAQIPM10($rs["log_pm10"])).'-en.png';
			$messages["wind"] = $rs['log_wind'];
			$messages["report"] = report_txt(calAQIPM10($rs["log_pm10"]),$air_data);
			$messages["report_type"] = report_type(calAQIPM10($rs["log_pm10"]));
		}else if($_GET['type']=="pm25"){
			$messages["log_pm25"] =$rs["log_pm25"];
			$messages["log_temp"] =$rs["temp"];
			$messages["log_humid"] = $rs["humid"];
			$messages["value"] =calAQIPM25($rs["log_pm25"]);
			$messages["txt"] = calAQIPM10txt(calAQIPM25($rs["log_pm25"]));
			$messages["name"] = $rs["location_id"].' - '.$rs["location_name"];
			if($_GET['avg']=='hr'){
				$messages["date"] = $rs["thaidate"].$time;
			}else{
				$messages["date"] = 'average 24 hour';
			}
			$messages["img"] = '<img style="margin:0 auto;width:100%;" src="/template/img/ccdc-0'.calAQIPM10Img(calAQIPM25($rs["log_pm25"])).'-en.png">';
			$messages["img_url"] = 'https://www.cmuccdc.org/template/img/ccdc-0'.calAQIPM10Img(calAQIPM25($rs["log_pm25"])).'-en.png';
			$messages["wind"] = $rs['log_wind'];
			$messages["report"] = report_txt(calAQIPM25($rs["log_pm25"]),$air_data);
			$messages["report_type"] = report_type(calAQIPM25($rs["log_pm25"]));
		}
		
		echo json_encode($messages);
	}
}
	

	

?>