<?php
// $domain = [
//     'https://jaikrating.cmuccdc.org',
//     'https://pakkret.cmuccdc.org',
//     'https://cmu.cmuccdc.org',
//     'https://www.cmuccdc.org',
//     'https://rcces.soc.cmu.ac.th:1443/pm25/v1/getDaily',
// ];
// if(in_array($_SERVER['HTTP_ORIGIN'],$domain)){
//     header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
// }
header('Access-Control-Allow-Origin: *');
set_time_limit(0);
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';


class Ccdc_2 extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

		$this->load->helper('jaydai_helper');
		$this->load->model('report_model');
		$this->load->model('charm_model');
        $this->load->helper('file');
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 100000; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    }
	
	function allowed_origin()
	{
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST');
		header("Access-Control-Allow-Headers: X-Requested-With");
    }
    public function nrct_hourly_get(){
        set_time_limit(0);
        $time = $this->uri->segment(4);
        if($time)
		{
            $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
            $time_limit = 3600;
            if (!$data = $this->cache->get('nrct_hourly'.$time)){
                $now_date = date('Y-m-d');
                $time_n_1 = sprintf("%'.02d", $time-1);
                $startTime =  $now_date.' '.$time_n_1.':00:00';
                $time_n_2 = sprintf("%'.02d", $time);
                $endTime =  $now_date.' '.$time_n_2.':00:00';
                $id = array(5315,5356,5068,5324,5281,5051,5212,5388,5084,5352,5152,5344,5342,5047);
                $ids = array(5361,6019,5326,5380,5262,5004,5279,5205,5078,5070,5154,5344,5380,5047);
                $data = array();
                foreach($id as $key=>$value){
                    $query="SELECT source_id,AVG(log_pm25) as pm25,log_datetime FROM log_mini_2561 WHERE source_id = $value AND log_datetime >= '".$startTime."' AND log_datetime < '".$endTime."' ORDER BY log_datetime ASC";
                    if($this->db->query($query)->result()[0]->source_id!=null){
                        $data[$key] = $this->db->query($query)->result();
                    }else{
                        $query="SELECT source_id,AVG(log_pm25) as pm25,log_datetime FROM log_mini_2561 WHERE source_id = $ids[$key] AND log_datetime >= '".$startTime."' AND log_datetime < '".$endTime."' ORDER BY log_datetime ASC";
                        $data[$key] = $this->db->query($query)->result();
                    }
                }
                $this->cache->save('nrct_hourly'.$time, json_encode($data), $time_limit);
            }
            $this->response(json_decode($data), 200);
		}else{
            $data = array(
				"status" => FALSE,
				"message" => "no time :("
			);
			$this->response($data, 200);
        }
    }
    public function nrct_daily_get(){
        set_time_limit(0);
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        $time_limit = 86400;
        if (!$data = $this->cache->get('nrct_daily')){
            $nowTime = date('Y-m-d');
            $startDay = date("Y-m-d", strtotime("-1 day",strtotime($nowTime)));
            $id = array(5315,5356,5068,5324,5281,5051,5212,5388,5084,5352,5152,5344,5342,5047);
            $ids = array(5361,6019,5326,5380,5262,5004,5279,5205,5078,5070,5154,5344,5380,5047);
            $data = array();
            foreach($id as $key=>$value){
                $query="SELECT source_id,AVG(log_pm25) as pm25,log_datetime FROM log_mini_2561 WHERE source_id = $value AND log_datetime >= '".$startDay."' AND log_datetime < '".$nowTime."' ORDER BY log_datetime ASC";
                if($this->db->query($query)->result()[0]->source_id!=null){
                    $data[$key] = $this->db->query($query)->result();
                }else{
                    $query="SELECT source_id,AVG(log_pm25) as pm25,log_datetime FROM log_mini_2561 WHERE source_id = $ids[$key] AND log_datetime >= '".$startDay."' AND log_datetime < '".$nowTime."' ORDER BY log_datetime ASC";
                    $data[$key] = $this->db->query($query)->result();
                }
            }
            $this->cache->save('nrct_daily', json_encode($data), $time_limit);
        }
        $this->response(json_decode($data), 200);
    }
    public function nrct_daily2_get(){
        set_time_limit(0);
        $time = $this->uri->segment(4);
        if($time)
		{
            $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
            $time_limit = 3600;
            if (!$data = $this->cache->get('nrct_daily'.$time)){
                $time_n_1 = sprintf("%'.02d", $time);
                $nowTime = date('Y-m-d '.$time_n_1.':00:00');
                $startDay = date("Y-m-d H:00:00", strtotime("-24 hour",strtotime($nowTime)));
                $id = array(5315,5356,5068,5324,5281,5051,5212,5388,5084,5352,5152,5344,5342,5047);
                $ids = array(5361,6019,5326,5380,5262,5004,5279,5205,5078,5070,5154,5344,5380,5047);
                $data = array();
                foreach($id as $key=>$value){
                    $query="SELECT source_id,AVG(log_pm25) as pm25,log_datetime FROM log_mini_2561 WHERE source_id = $value AND log_datetime >= '".$startDay."' AND log_datetime < '".$nowTime."' ORDER BY log_datetime ASC";
                    if($this->db->query($query)->result()[0]->source_id!=null){
                        $data[$key] = $this->db->query($query)->result();
                    }else{
                        $query="SELECT source_id,AVG(log_pm25) as pm25,log_datetime FROM log_mini_2561 WHERE source_id = $ids[$key] AND log_datetime >= '".$startDay."' AND log_datetime < '".$nowTime."' ORDER BY log_datetime ASC";
                        $data[$key] = $this->db->query($query)->result();
                    }
                }
                $this->cache->save('nrct_daily'.$time, json_encode($data), $time_limit);
            }
            $this->response(json_decode($data), 200);
        }else{
            $data = array(
				"status" => FALSE,
				"message" => "no time :("
			);
			$this->response($data, 200);
        }
    }
    public function nrct3_get(){
        set_time_limit(0);
        $time = $this->uri->segment(4);
        if($time)
		{
            $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
            $time_limit = 3600;
            if (!$result = $this->cache->get('nrct_'.$time)){
                $time_n_1 = sprintf("%'.02d", $time);
                $nowTime = date('Y-m-d '.$time_n_1.':00:00');
                $startDay = date("Y-m-d H:00:00", strtotime("-24 hour",strtotime($nowTime)));
                $id = array(5315,5356,5068,5324,5281,5049,5212,5388,5084,5352,5152,5344,5342,5047);
                $ids = array(5361,6019,5326,5380,5262,5051,5279,5205,5078,5070,5154,5344,5380,5047);
                $result = array();
                $data = json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/temp/'.date('Ymd').$time_n_1.'_stations.json'));
                foreach($data as $key=>$value){
                    if(in_array($value->id,$id)){
                        $result['pm'.$value->id]=$value;
                    }
                    if(in_array($value->id,$ids)){
                        $result['pm'.$value->id]=$value;
                    }
                }
                $temp = json_decode(file_get_contents('https://www.cmuccdc.org/api/ccdc_2/nrct_temp/'));
                $result['temp']=$temp;
                
                !empty($data)?$this->cache->save('nrct_'.$time, json_encode($result), $time_limit):redirect(base_url('api/ccdc_2/nrct3/'.$time));
            }
            $this->response(json_decode($result), 200);
        }else{
            $data = array(
				"status" => FALSE,
				"message" => "no time :("
			);
			$this->response($data, 200);
        }
    }
    public function nrct_temp_get(){
        $time = date('G');
        if($time){
            $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
            $time_limit = 82800;
            if (!$data = $this->cache->get('nrct_temp'.$time)){
                $curl = curl_init();
    
                curl_setopt_array($curl, [
                    CURLOPT_URL => "https://community-open-weather-map.p.rapidapi.com/weather?q=Bangkok&lat=13.75&lon=100.52&id=2172797&lang=null&units=%22metric%22%20or%20%22imperial%22&mode=json",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => [
                        "x-rapidapi-host: community-open-weather-map.p.rapidapi.com",
                        "x-rapidapi-key: fd846fdb8amshd905aaa586984f6p1b3119jsn8ea094b40cae"
                    ],
                ]);
    
                $response = curl_exec($curl);
                $err = curl_error($curl);
    
                curl_close($curl);
    
                if ($err) {
                    echo "cURL Error #:" . $err;
    
                } else {
                    $response = json_decode($response);
                    $data = $response->main->temp-273.15;
                    $this->cache->save('nrct_temp'.$time, json_encode($data), $time_limit);
                }
            }
            $this->response(json_decode($data), 200);
        }else{
            $data = array(
				"status" => FALSE,
				"message" => "no time :("
			);
			$this->response($data, 200);
        }
    }
    public function nrct2_get(){
        set_time_limit(0);
        $time = $this->uri->segment(4);
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$time_limit = 82800;
        $data = $this->cache->get('nrct'.$time);
        if (!$data == "null"||empty($date)){
            $data1 = json_decode(file_get_contents('https://www.cmuccdc.org/api/ccdc_2/nrct_hourly/'.$time));
            $data2 = json_decode(file_get_contents('https://www.cmuccdc.org/api/ccdc_2/nrct_temp/'));
            $data3 = json_decode(file_get_contents('https://www.cmuccdc.org/api/ccdc_2/nrct_daily2/'.$time));
            array_push($data1,$data2);
            $data = array_merge($data1,$data3);
            $this->cache->save('nrct'.$time, json_encode($data), $time_limit);
        }
        $this->response($data, 200);
    }
    public function healthzone_podd_get(){
        set_time_limit(0);
        $area =  $this->uri->segment(4);
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$time_limit = 3600;
        if (!$result = $this->cache->get('healthzone_podd_'.$area)){
            $result = array();
            $p_area1 = array(38,46,40,39,45,43,44,42);
            $p_area2 = array(50,52,54,51,41);
            $p_area3 = array(49,47,53,48,9);
            $p_area4 = array(3,4,5,10,7,8,6,17);
            $p_area5 = array(56,62,61,54,58,57,60,59);
            $p_area6 = array(16,18,14,12,15,2);
            $p_area7 = array(34,28,32,33);
            $p_area8 = array(30,31,27,29,77,36,37,35);
            $p_area9 = array(25,19,20,21);
            $p_area10 = array(24,22,26,33);
            $p_area11 = array(69,63,67,64,65,66,68);
            $p_area12 = array(73,72,76,74,75,70,71);
            $p_area13 = array(1);
            $end_time = date('Y-m-d');
            $start_time = date('Y-m-d', strtotime($end_time. ' - 7 days'));
            $stations = json_decode(file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/regionreport'));
            if($stations!=null){
                foreach($stations as $key=>$value)
                {
                    foreach($value->provinces as $k=>$v)
                    {
                        if(in_array($v->province_id,$p_area1)&&!empty($v->stations)&&$area==1)  array_push($result,$v); 
                        else if(in_array($v->province_id,$p_area2)&&!empty($v->stations)&&$area==2)  array_push($result,$v); 
                        else if(in_array($v->province_id,$p_area3)&&!empty($v->stations)&&$area==3)  array_push($result,$v);
                        else if(in_array($v->province_id,$p_area4)&&!empty($v->stations)&&$area==4)  array_push($result,$v);
                        else if(in_array($v->province_id,$p_area5)&&!empty($v->stations)&&$area==5)  array_push($result,$v);
                        else if(in_array($v->province_id,$p_area6)&&!empty($v->stations)&&$area==6)  array_push($result,$v);
                        else if(in_array($v->province_id,$p_area7)&&!empty($v->stations)&&$area==7)  array_push($result,$v);
                        else if(in_array($v->province_id,$p_area8)&&!empty($v->stations)&&$area==8)  array_push($result,$v);
                        else if(in_array($v->province_id,$p_area9)&&!empty($v->stations)&&$area==9)  array_push($result,$v);
                        else if(in_array($v->province_id,$p_area10)&&!empty($v->stations)&&$area==10)    array_push($result,$v);
                        else if(in_array($v->province_id,$p_area11)&&!empty($v->stations)&&$area==11)    array_push($result,$v);
                        else if(in_array($v->province_id,$p_area12)&&!empty($v->stations)&&$area==12)    array_push($result,$v);
                        else if(in_array($v->province_id,$p_area13)&&!empty($v->stations)&&$area==13)    array_push($result,$v);
                    }
                }
                foreach($result as $k=>$v)
                {
                    foreach($v->stations as $kk=>$vv)
                    {
                        $source_id = $vv->source_id;
                        $query = $this->db->query("SELECT source_id,pm25 as PM25,daily_date FROM data_daily WHERE source_id = $source_id AND daily_date >= '".$start_time."' AND daily_date <= '".$end_time."' ORDER BY daily_date ASC")->result();
                        $vv->pm25 = $query;
                        $count = $this->db->query("SELECT pm25 FROM data_daily WHERE source_id = $source_id AND pm25>=51 AND daily_date >= '2021-01-01' ORDER BY daily_date ASC")->num_rows();
                        $vv->pm25_51 = $count;
                    }
                }
                if(!empty($result)){
                    $this->cache->save('healthzone_podd_'.$area, $result, $time_limit);
                }
            }
            redirect(base_url('api/ccdc_2/healthzone_podd/'.$area));
        }
        $this->response($result, 200);
    }
    public function provinces_podd_get(){
        set_time_limit(0);
        $id =  $this->uri->segment(4);
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$time_limit = 3600;
        if (!$result = $this->cache->get('provinces_podd_'.$area)){
            $result = array();
            $end_time = date('Y-m-d');
            $start_time = date('Y-m-d', strtotime($end_time. ' - 7 days'));
            $stations = json_decode(file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/regionreport'));
            if($stations!=null){
                foreach($stations as $key=>$value)
                {
                    foreach($value->provinces as $k=>$v)
                    {
                        if($v->province_id==$id&&!empty($v->stations))  array_push($result,$v); 
                    }
                }
                foreach($result as $k=>$v)
                {
                    foreach($v->stations as $kk=>$vv)
                    {
                        $source_id = $vv->source_id;
                        $query = $this->db->query("SELECT source_id,pm25 as PM25,daily_date FROM data_daily WHERE source_id = $source_id AND daily_date >= '".$start_time."' AND daily_date <= '".$end_time."' ORDER BY daily_date ASC")->result();
                        $vv->pm25 = $query;
                        $count = $this->db->query("SELECT pm25 FROM data_daily WHERE source_id = $source_id AND pm25>=51 AND daily_date >= '2021-01-01' ORDER BY daily_date ASC")->num_rows();
                        $vv->pm25_51 = $count;
                    }
                }
                if(!empty($result)){
                    $this->cache->save('provinces_podd_'.$id, $result, $time_limit);
                }
            }
            redirect(base_url('api/ccdc_2/provinces_podd/'.$id));
        }
        $this->response($result, 200);
    }
    public function DBhealthzone_get(){
        // https://www-old.cmuccdc.org/api2/dustboy/forecast/
        $area =  $this->uri->segment(4);
        $result = array();
        $end_time = date('Y-m-d');
        $start_time = date('Y-m-d', strtotime($end_time. ' - 7 days'));

        $query = $this->db->query("SELECT province_healthzones_id FROM z_healthzone WHERE province_healthzones_id!='' GROUP BY province_healthzones_id ORDER BY province_healthzones_id ASC")->result();
        foreach($query as $key=>$value){
            $provinces = $this->db->query("SELECT province_id,province_name FROM z_healthzone WHERE province_healthzones_id=$value->province_healthzones_id AND is_show=1");
            foreach($provinces->result() as $key2=>$value2){
                $stations_real=array(); $weather_real=array();
                $stations = $this->db->query("SELECT source_id,location_name,location_lat,location_lon FROM source WHERE source_province_id=$value2->province_id AND location_status = 1 AND db_status = 0")->result();
                foreach($stations as $key3=>$value3){
                    $chk_7day = $this->db->query("SELECT pm25 as PM25,daily_date FROM data_daily where source_id = $value3->source_id  AND daily_date >= '".$start_time."'")->result();
                    $value3->pm25=!empty($chk_7day)?$chk_7day:null;
                    !empty($chk_7day)?array_push($stations_real,$value3):'';
                }
                $value2->stations=$stations_real;
            }
            $value->provinces=$provinces->result();
        }
        $this->response($query, 200);
	}
	public function healthzone_get(){
        $area =  $this->uri->segment(4);
        $result = array();
        $p_area1 = array(38,46,40,39,45,43,44,42);
        $p_area2 = array(50,52,54,51,41);
        $p_area3 = array(49,47,53,48,9);
        $p_area4 = array(3,4,5,10,7,8,6,17);
        $p_area5 = array(56,62,61,54,58,57,60,59);
        $p_area6 = array(16,18,14,12,15,2);
        $p_area7 = array(34,28,32,33);
        $p_area8 = array(30,31,27,29,77,36,37,35);
        $p_area9 = array(25,19,20,21);
        $p_area10 = array(24,22,26,33);
        $p_area11 = array(69,63,67,64,65,66,68);
        $p_area12 = array(73,72,76,74,75,70,71);
        $p_area13 = array(1);
        $stations = json_decode(file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/regionreport'));
        if($stations!=null){
            // echo '<pre>';
            // print_r($stations);
            foreach($stations as $key=>$value)
            {
                foreach($value->provinces as $k=>$v)
                {
                    // print_r($v);
                    $sub_province = array();
                    if(in_array($v->province_id,$p_area1)&&!empty($v->stations)&&$area==1)
                    {
                        array_push($result,$v); 
                    }
                    else if(in_array($v->province_id,$p_area2)&&!empty($v->stations)&&$area==2)
                    {
                        array_push($result,$v); 
                    }
                    else if(in_array($v->province_id,$p_area3)&&!empty($v->stations)&&$area==3)
                    {
                        array_push($result,$v); 
                    }
                    else if(in_array($v->province_id,$p_area4)&&!empty($v->stations)&&$area==4)
                    {
                        array_push($result,$v); 
                    }
                    else if(in_array($v->province_id,$p_area5)&&!empty($v->stations)&&$area==5)
                    {
                        array_push($result,$v); 
                    }
                    else if(in_array($v->province_id,$p_area6)&&!empty($v->stations)&&$area==6)
                    {
                        array_push($result,$v); 
                    }
                    else if(in_array($v->province_id,$p_area7)&&!empty($v->stations)&&$area==7)
                    {
                        array_push($result,$v); 
                    }
                    else if(in_array($v->province_id,$p_area8)&&!empty($v->stations)&&$area==8)
                    {
                        array_push($result,$v); 
                    }
                    else if(in_array($v->province_id,$p_area9)&&!empty($v->stations)&&$area==9)
                    {
                        array_push($result,$v); 
                    }
                    else if(in_array($v->province_id,$p_area10)&&!empty($v->stations)&&$area==10)
                    {
                        array_push($result,$v); 
                    }
                    else if(in_array($v->province_id,$p_area11)&&!empty($v->stations)&&$area==11)
                    {
                        array_push($result,$v); 
                    }
                    else if(in_array($v->province_id,$p_area12)&&!empty($v->stations)&&$area==12)
                    {
                        array_push($result,$v); 
                    }
                    else if(in_array($v->province_id,$p_area13)&&!empty($v->stations)&&$area==13)
                    {
                        array_push($result,$v); 
                    }
                }
            }
            // echo '</pre>';
            // exit();
			$this->response($result, 200);
            $this->output->cache(5);
		}else{
			$data = array(
				"status" => FALSE,
				"message" => "data is empty :("
			);
			$this->response($data, 200);
		}
	}
    public function provinces_get(){
        $id =  $this->uri->segment(4);
        $result = array();
        $stations = json_decode(file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/regionreport'));
        if($stations!=null){
            // echo '<pre>';
            // print_r($stations);
            foreach($stations as $key=>$value)
            {
                foreach($value->provinces as $k=>$v)
                {
                    if($v->province_id==$id&&!empty($v->stations))
                    {
                        array_push($result,$v); 
                    }
                }
            }
            // echo '</pre>';
            // exit();
			$this->response($result, 200);
            $this->output->cache(5);
		}else{
			$data = array(
				"status" => FALSE,
				"message" => "data is empty :("
			);
			$this->response($data, 200);
		}
    }
	
	public function cmu_get(){
        set_time_limit(0);
        // $time = $this->uri->segment(4);
        $time = date('G');
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$time_limit = 3600;
        if (!$data = $this->cache->get('cmu_2022')){
            //คณะมนุษย์,แคมปัสแม่เหี่ย
            $data = json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/stations_temp.json?v='.date('YmdHis')));
            $result = array();
            $id = array('4421','5271','5264','5265','5267','5281','5263','5262','5723','6613','6612','6');
            foreach ($data as $key => $value) {
                if(in_array($value->id,$id)){
					array_push($result, $value);
                }
            }
            $this->cache->save('cmu_2022', $result, $time_limit);  
            $this->response($result, 200);
        }
        $this->response($data, 200);
    }
	
    public function cmu2_get(){
        set_time_limit(0);
        // $time = $this->uri->segment(4);
        $time = date('G');
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$time_limit = 3600;
        if (!$data = $this->cache->get('cmu'.$time)){
            //คณะมนุษย์,แคมปัสแม่เหี่ย
            $data = json_decode(file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/stations?v='.date('YmdHis')));
            $result = array();
            $id = array('5263','5264','5265','5281','5266','5262','5267','5271','5268','5270','5269','6');
            foreach ($data as $key => $value) {
                if(in_array($value->id,$id)){
                    $result['pm'.$value->id]=$value;
                }
            }
            $this->cache->save('cmu'.$time, $result, $time_limit);  
            $this->response($result, 200);
        }
        $this->response($data, 200);
    }
    public function cmu3_get(){
        set_time_limit(0);
        $time = $this->uri->segment(4);
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$time_limit = 3600;
        if (!$data = $this->cache->get('cmu_'.$time)){
            //คณะมนุษย์,แคมปัสแม่เหี่ย
            $time_n_1 = sprintf("%'.02d", $time);
            $data = json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/temp/'.date('Ymd').$time_n_1.'_stations.json'));
            $result = array();
            $id = array('5263','5264','5265','5281','5266','5262','5267','5271','5268','5270','5269','6');
            foreach ($data as $key => $value) {
                if(in_array($value->id,$id)){
                    $result['pm'.$value->id]=$value;
                }
            }
            if(!empty($data)){
                $this->cache->save('cmu_'.$time, $result, $time_limit);
            }
            redirect(base_url('api/ccdc_2/cmu3/'.$time));
        }
        $this->response($data, 200);
    }

    public function cmu4_get(){
        set_time_limit(0);
        $time = $this->uri->segment(4);
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$time_limit = 3600;
        if (!$data = $this->cache->get('cmu4_'.$time)){
            //คณะมนุษย์,แคมปัสแม่เหี่ย
            $time_n_1 = sprintf("%'.02d", $time);
            $data = json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/temp/'.date('Ymd').$time_n_1.'_stations.json'));
            $result = array();
            $id = array('4439', '5263', '5723', '5264', '5267', '5281', '5271', '4421', '5265', '6612', '5262', '6', '5266', '4427', '4426','5268','5270', '13');
            //$id = array('5263','5264','5265','5281','5266','5262','5267','5271','5268','5270','5269','6');
            foreach ($data as $key => $value) {
                if(in_array($value->id,$id)){
                    $result['pm'.$value->id]=$value;
                }
            }
            if(!empty($data)){
                $this->cache->save('cmu4_'.$time, $result, $time_limit);
            }
            redirect(base_url('api/ccdc_2/cmu4/'.$time));
        }
        $this->response($data, 200);
    }
    public function jaikrating_get(){
        set_time_limit(0);
        // $time = $this->uri->segment(4);
        $time = date('G');
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$time_limit = 3600;
        if (!$data = $this->cache->get('jaikrating')){
           // $data = json_decode(file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/stations?v='.date('YmdHis')));
            $data = json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/stations_temp.json?v='.date('YmdHis')));
            $result = array();
            foreach ($data as $key => $value) {
                if($value->id>=5501&&$value->id<=5521){
                    // $result['pm'.$value->id]=$value;
                    array_push($result,$value);
                }
            }
            sort($result);
            $this->cache->save('jaikrating', $result, $time_limit);  
            $this->response($result, 200);
        }
        $this->response($data, 200);
    }
    public function pakkret_get(){
        set_time_limit(0);
        $time = date('G');
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$time_limit = 1200;
//        $data = $this->cache->get('pakkret');
        if (!$data||date('H',$this->cache->get_metadata('pakkret')['mtime'])<date('H')){
            // $data = json_decode(file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/stations?v='.date('YmdHis')));
            $data = json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/stations_temp.json?v='.date('YmdHis')));
            $result = array();
            foreach ($data as $key => $value) {
                if($value->id>=4061&&$value->id<=4100){
                    array_push($result,$value);
                }
            }
            sort($result);
            $this->cache->save('pakkret', $result, $time_limit);  
            $this->response($result, 200);
        }
        $this->response($data, 200);
    }
    public function cmuforcast_get(){
        set_time_limit(0);
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$time_limit = 3600;
        $data = $this->cache->get('cmuforcast');
        if (!$data||date('d',$this->cache->get_metadata('cmuforcast')['mtime'])<date('d')){
            $data1 = json_decode(file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/stations?v='.date('YmdHis')));
            $result = array();
            $result_forcast = array();
            $id = array('5264','4037','5687','5272','5006','5669','5052','5026','5037','5046','5410','5212','5564','5566','','5038','5434');
            foreach ($data1 as $key => $value) {
                if(in_array($value->id,$id)){
                    $result['pm'.$value->id] = array(
                        'id' => $value->id,
                        'daily_pm25' => $value->daily_pm25,
                    );
                    $forcast = json_decode(file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/forecast/'.$value->id.'?v='.date('YmdHis')));
                    if($forcast){
                        foreach($forcast->forecast_days as $k=> $v){
                            if( date('Y-m-d',strtotime($v->day_date))==date('Y-m-d',strtotime("+1 day")) )
                                $result_forcast['n1']=$v->day_avg_pm25;
                            if( date('Y-m-d',strtotime($v->day_date))==date('Y-m-d',strtotime("+2 day")) )
                                $result_forcast['n2']=$v->day_avg_pm25;
                            if( date('Y-m-d',strtotime($v->day_date))==date('Y-m-d',strtotime("+3 day")) )
                                $result_forcast['n3']=$v->day_avg_pm25;
                        }
                        $result['pm'.$value->id]['forcast'] = $result_forcast;
                    }
                }
            }
            // sort($result);
            $this->cache->save('cmuforcast', $result, $time_limit);  
            $this->response($result, 200);
        }
        $this->response($data, 200);
    }
    public function cmumodel_get(){
        set_time_limit(0);
        $time = date('G');
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$time_limit = 1200;
        $data = $this->cache->get('cmumodel');
        if (!$data||date('H',$this->cache->get_metadata('cmumodel')['mtime'])<date('H')){
            $data = json_decode(file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/stations?v='.date('YmdHis')));
            $result = array();
            foreach ($data as $key => $value) {
                if($value->id>=5522&&$value->id<=5535){
                    array_push($result,$value);
                }
            }
            sort($result);
            $this->cache->save('cmumodel', $result, $time_limit);  
            $this->response($result, 200);
        }
        $this->response($data, 200);
    }
    public function blueskyOld_get(){
        set_time_limit(0);
        $this->allowed_origin();
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$time_limit = 1200;
        $data = $this->cache->get('blueskyOld');
        if (!$data||date('H',$this->cache->get_metadata('blueskyOld')['mtime'])<date('H')){
            $demo = json_decode(file_get_contents('https://bluesky.cmuccdc.org/assets/js/demo.json?v='.date('YmdHis')));
            $data = json_decode(file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/stations?v='.date('YmdHis')));
            $result = array();
            foreach ($data as $key => $value) {
                if($value->id==5700||($value->id>=5467&&$value->id<=5476)){
                    array_push($result,$value);
                }
            }
            array_push($result,$demo[0]);
            $this->cache->save('blueskyOld', $result, $time_limit);  
            $this->response($result, 200);
        }
        $this->response($data, 200);
    }
    public function bluesky_get(){
        set_time_limit(0);
        $this->allowed_origin();
        $time = date('G');
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$time_limit = 1200;
        $data = $this->cache->get('bluesky');
        if (!$data||date('H',$this->cache->get_metadata('bluesky')['mtime'])<date('H')){
            $data = json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/stations_temp.json?v='.date('YmdHis')));
            $result = array();
            foreach ($data as $key => $value) {
                if($value->id==5700||($value->id>=5467&&$value->id<=5476)){
                    if($value->id!=5471 || $value->id!=5472){
                    array_push($result,$value);
                        }
                }
            }
            $data2 = json_decode(file_get_contents('https://api.cmuccdc.org/sensors/12'));
            if($data2){
                foreach ($data2 as $key => $value) {
                    if($value->id==5700||$value->id==359072067236014||($value->id>=5467&&$value->id<=5476)){
                        array_push($result,$value);
                    }
                }
            }
            sort($result);
            $this->cache->save('bluesky', $result, $time_limit);  
            $this->response($result, 200);
        }
        $this->response($data, 200);
    }
    public function get_ccdc_last_near_get(){
		$lat = $this->uri->segment(4);
		$long = $this->uri->segment(5);
		$rs = array();
		$data = json_decode(file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/stations?v='.date('YmdHis')));
		if($data){
			$result = array();
			foreach($data as $key => $value){
				if($value->source_name=='DustBoy'){
					$theta = $long - floatval($value->dustboy_lon); 
					$distance = (sin(deg2rad($lat)) * sin(deg2rad(floatval($value->dustboy_lat)))) + (cos(deg2rad($lat)) * cos(deg2rad(floatval($value->dustboy_lat))) * cos(deg2rad($theta))); 
					$distance = acos($distance); 
					$distance = rad2deg($distance); 
					$distance = $distance * 60 * 1.1515 * 1.609344; //miles*1.609344
					$result[$key] = array(
						'distance' => $distance,
						'name' => $value->dustboy_name,
						'pm25' => $value->pm25,
						'date' => $value->log_datetime,
					);
				}
			}
			sort($result);
			$rs = $result[0];
		}else{
			$rs = array(
				'There was error, please use it again.'
			);
		}
		$this->response($rs, 200);
	}
    public function getAqicForecast1_get(){
        set_time_limit(0);
		$this->allowed_origin();
        // $rs = get_headers('https://rcces.soc.cmu.ac.th:1443/pm25/v1/getDaily',true);
        $rs = array(
            5281=>null, 5264=>null, 5263=>null, 5265=>null, 5266=>null, 5267=>null,		//1
            5212=>null, 5614=>null, 5615=>null, 5616=>null, 5618=>null, 5278=>null,		//2
            5047=>null, 5031=>null, 5032=>null, 5046=>null, 5399=>null, 5428=>null,		//3
            5315=>null, 5361=>null, 5062=>null, 6008=>null, 110=>null, 5242=>null,		//4
            5324=>null, 5291=>null, 5323=>null, 5338=>null, 5337=>null, 5638=>null,		//5
        );
        foreach($rs as $key=>$value){
            $uri = 'https://www-old.cmuccdc.org/api2/dustboy/forecast/'.$key.'?v='.date('YmdHis');
            $stations = json_decode(file_get_contents($uri));
            $rs[$key] = array(
                'today' => $stations->forecast_days[0]->day_avg_pm25,
                'tomorrow' => $stations->forecast_days[1]->day_avg_pm25,
                'afterTomorrow' => $stations->forecast_days[2]->day_avg_pm25,
            );
        }
        file_put_contents('uploads/reportpm25/report_aqic/forecast/forecast'.date('Ymd').'.json', json_encode($rs) . PHP_EOL);

		$this->response('ok', 200);
    }
    public function getAqicForecast2_get(){
        set_time_limit(0);
		$this->allowed_origin();
        $json_old = json_decode(file_get_contents(base_url('uploads/reportpm25/report_aqic/forecast/forecast'.date('Ymd').'.json?v='.date('YmdHis'))),true);
        $rs = array(
            5072=>null, 6599=>null, 5151=>null, 5152=>null, 5313=>null, 5419=>null, 5420=>null,	5420=>null, 5671=>null,				//6							
            5068=>null, 5635=>null, 5636=>null, 6190=>null, 6191=>null, 6193=>null, 	//7	/*5067=>null, 5377=>null, 5378=>null,*/	
            5356=>null, 6000=>null, 6019=>null,											//8
            5051=>null, 5051=>null, 5049=>null, 5688=>null, 5677=>null, 5676=>null, 5052=>null, 5405=>null,   	//9
            5444=>null, 5293=>null, 5294=>null, 5295=>null,								//10							//10
        );
        foreach($rs as $key=>$value){
            $uri = 'https://www-old.cmuccdc.org/api2/dustboy/forecast/'.$key.'?v='.date('YmdHis');
            $stations = json_decode(file_get_contents($uri));
            $json_old[$key] = array(
                'today' => $stations->forecast_days[0]->day_avg_pm25,
                'tomorrow' => $stations->forecast_days[1]->day_avg_pm25,
                'afterTomorrow' => $stations->forecast_days[2]->day_avg_pm25,
            );
        }

        file_put_contents('uploads/reportpm25/report_aqic/forecast/forecast'.date('Ymd').'.json', json_encode($json_old) . PHP_EOL);

		$this->response('ok', 200);
    }
    public function getAqicForecast3_get(){
        set_time_limit(0);
		$this->allowed_origin();
        $json_old = json_decode(file_get_contents(base_url('uploads/reportpm25/report_aqic/forecast/forecast'.date('Ymd').'.json?v='.date('YmdHis'))),true);
        $rs = array(
            5388=>null, 5643=>null, 5202=>null, 5205=>null, 5200=>null, 5198=>null,		//11
            5344=>null, 5318=>null, 5580=>null,											//12
            5342=>null, 5597=>null, 5598=>null,	5464=>null, 5064=>null, 6148=>null,									//13
            5305=>null, 5352=>null, 5417=>null,  5070=>null, 5056=>null, 5055=>null, 	//14
        );
        foreach($rs as $key=>$value){
            $uri = 'https://www-old.cmuccdc.org/api2/dustboy/forecast/'.$key.'?v='.date('YmdHis');
            $stations = json_decode(file_get_contents($uri));
            $json_old[$key] = array(
                'today' => $stations->forecast_days[0]->day_avg_pm25,
                'tomorrow' => $stations->forecast_days[1]->day_avg_pm25,
                'afterTomorrow' => $stations->forecast_days[2]->day_avg_pm25,
            );
        }

        file_put_contents('uploads/reportpm25/report_aqic/forecast/forecast'.date('Ymd').'.json', json_encode($json_old) . PHP_EOL);

		$this->response('ok', 200);
    }
    public function ams_get(){
        set_time_limit(0);
        $this->allowed_origin();
        $time = date('G');
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$time_limit = 1200;
        $data = $this->cache->get('ams');
        if (!$data||date('H',$this->cache->get_metadata('ams')['mtime'])<date('H')){
            $data = json_decode(file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/stations?v='.date('YmdHis')));
            $result = array();
            foreach ($data as $key => $value) {
                if($value->id==6612||$value->id==6613){
                    array_push($result,$value);
                }
            }
            sort($result);
            $this->cache->save('ams', $result, $time_limit);  
            $this->response($result, 200);
        }
        $this->response($data, 200);
    }
    public function singburi_get(){
        set_time_limit(0);
        $this->allowed_origin();
        $time = date('G');
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$time_limit = 1200;
        $data = $this->cache->get('singburi');
        if (!$data||date('H',$this->cache->get_metadata('singburi')['mtime'])<date('H')){
            $data = json_decode(file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/stations?v='.date('YmdHis')));
            $result = array();
            foreach ($data as $key => $value) {
                if($value->id==5363||$value->id==5364||$value->id==5430||$value->id==5441||$value->id==5275||$value->id==5459||$value->id==5460||$value->id==5461||$value->id==5465||$value->id==5466){
                    array_push($result,$value);
                }
            }
            sort($result);
            $this->cache->save('singburi', $result, $time_limit);  
            $this->response($result, 200);
        }
        $this->response($data, 200);
    }
    public function lampang_get(){
        set_time_limit(0);
        $this->allowed_origin();
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$time_limit = 1200;
        $data = $this->cache->get('lampang');
        if (!$data||date('H',$this->cache->get_metadata('lampang')['mtime'])<date('H')){
            $data = json_decode(file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/stations?v='.date('YmdHis')));
            $result = array();
            foreach ($data as $key => $value) {
                if($value->id==5388){
                    array_push($result,$value);
                }
                if($value->id>=5447&&$value->id<=5456&&$value->id!=5455){
                    array_push($result,$value);
                }
            }
            sort($result);
            $this->cache->save('lampang', $result, $time_limit);  
            $this->response($result, 200);
        }
        $this->response($data, 200);
    }
    public function phitsanulok_get(){
        $this->allowed_origin();
        // ini_set('display_errors', 1);
        // ini_set('display_startup_errors', 1);
        // error_reporting(E_ALL);
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$time_limit = 1200;
        $data = $this->cache->get('phitsanulok');
        if (!$data||date('H',$this->cache->get_metadata('phitsanulok')['mtime'])<date('H')){
            $data = json_decode(file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/stations?v='.date('YmdHis')));
            $result = array();
            foreach ($data as $key => $value) {
                if($value->id==5033||$value->id==5034||$value->id==5066||$value->id==5212||$value->id==5276||$value->id==5277||$value->id==5279||$value->id==5280||$value->id==5396||$value->id==5411||$value->id==6420||$value->id==6422||$value->id==6425||$value->id==6429||$value->id==6433||$value->id==6434||$value->id==6426||$value->id==6428||$value->id==6432||$value->id==5278||$value->id==6431){
                    array_push($result,$value);
                }
                if($value->id>=5613&&$value->id<=5618){
                    array_push($result,$value);
                }
            }
            sort($result);
            $this->cache->save('phitsanulok', $result, $time_limit);  
            $this->response($result, 200);
        }
        $this->response($data, 200);
    }
    public function thanalak_get(){
        $this->allowed_origin();
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$time_limit = 1200;
        $data = $this->cache->get('thanalak');
        if (!$data||date('H',$this->cache->get_metadata('thanalak')['mtime'])<date('H')){
            $data = json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/stations_temp.json?v='.date('YmdHis')));
            $result = array();
            foreach ($data as $key => $value) {
                if($value->id==5724||$value->id==5058||$value->id==10||$value->id==5379||$value->id==5376||$value->id==5512||$value->id==6612||$value->id==6613||$value->id==4425){
                    array_push($result,$value);
                }
            }
            sort($result);
            $this->cache->save('thanalak', $result, $time_limit);  
            $this->response($result, 200);
        }
        $this->response($data, 200);
    }
    public function hotspot_get(){
        $this->allowed_origin();
        $start = $this->uri->segment(4);
        $end = $this->uri->segment(5);
        $hotspot = json_decode(file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/hotspotall/'.$start.'/'.$end));
        $region_pwa = json_decode(file_get_contents(base_url('uploads/reportpm25/report_aqic/region_pwa/region_pwa.json')));
        if($hotspot){
            $data = $hotspot;
        }
        $this->response($data, 200);
    }
    public function charms_get(){
        set_time_limit(0);
        $this->allowed_origin();
		$id = $this->uri->segment(4);
		if($id!=null){
			if( ($id==5721||$id==5722||$id==5723||$id==5268||$id==5270||$value->id==6630||$value->id==6629) || ($id>=6614&&$id<=6627)){
				$data = json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/charm/'.$id.'.json'));
				//$rs = $this->charm_model->getSourceId($id);
				//$data->value = $rs;
			}
		}else{
			$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			$time_limit = 1200;
			$data = $this->cache->get('charms');
			if (!$data||date('H',$this->cache->get_metadata('charms')['mtime'])<date('H')){
				$data = json_decode(file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/stations?v='.date('YmdHis')));
				$result = array();
				foreach ($data as $key => $value) {
					if($value->id==5721||$value->id==5722||$value->id==5723||$value->id==5268||$value->id==5270||$value->id==6630||$value->id==6629){
						array_push($result,$value);
					}
					if($value->id>=6614&&$value->id<=6627){
						array_push($result,$value);
					}
					
				}
				sort($result);
				$this->cache->save('charms', $result, $time_limit);  
				$this->response($result, 200);
			}
		}
        $this->response($data, 200);
    }
	 public function charmsmeter_get(){
        set_time_limit(0);
		$data = array();
		
        $this->allowed_origin();
		$id = $this->uri->segment(4);
		if($id!=null){
			
			$data=array(); 
			$profile = json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/charms_meter.json'));
			foreach($profile as $item){
				if($item->id==$id){
					$data=$item;
				}
			}
			$rs = $this->charm_model->getMeterId($id);
			$data->value = $rs;
			
		}else{
		
			$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
			$time_limits = 900;	
			if ( ! $data_cache = $this->cache->get('charm_meter')){
				$data_cache = array();
				$profile = json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/charms_meter.json'));
				foreach($profile as $item){
					
					//$rs = $this->charm_model->getMeterId($item->id);
					//$item->value = $rs;
					array_push($data_cache, $item);
				}
				$this->cache->save('charm_meter', $data_cache, $time_limits);
			}
			$data_cache = $this->cache->get('charm_meter');
			$this->response($data_cache, 200);
			
		}
        
        $this->response($data, 200);
    }
	
	public function charmsmeterdata_get(){
		$rs = $this->charm_model->getMeterLog(); 
		$this->response($rs, 200);
	}
    public function wsrapathum_get(){
        set_time_limit(0);
        $this->allowed_origin();
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$time_limit = 1200;
        $data = $this->cache->get('wsrapathum');
        if (!$data||date('H',$this->cache->get_metadata('wsrapathum')['mtime'])<date('H')){
            $data = json_decode(file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/stations?v='.date('YmdHis')));
            $result = array();
            foreach ($data as $key => $value) {
                if($value->id==6643||$value->id==6644){
                    array_push($result,$value);
                }
            }
            sort($result);
            $this->cache->save('wsrapathum', $result, $time_limit);  
            $this->response($result, 200);
        }
        $this->response($data, 200);
    }
	
	public function sannameng_get(){
        set_time_limit(0);
        $this->allowed_origin();
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$time_limit = 1200;
        $data = $this->cache->get('sannameng');
        if (!$data||date('H',$this->cache->get_metadata('sannameng')['mtime'])<date('H')){
            $data = json_decode(file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/stations?v='.date('YmdHis')));
            $result = array();
            foreach ($data as $key => $value) {
                if($value->id==2109||$value->id==2110){
                    array_push($result,$value);
                }
            }
            sort($result);
            $this->cache->save('sannameng', $result, $time_limit);  
            $this->response($result, 200);
        }
        $this->response($data, 200);
    }
	
	public function maechaem_get(){
        set_time_limit(0);
        $this->allowed_origin();
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$time_limit = 1200;
        $data = $this->cache->get('maechaem');
        if (!$data||date('H',$this->cache->get_metadata('maechaem')['mtime'])<date('H')){
            $data = json_decode(file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/stations?v='.date('YmdHis')));
            $result = array();
            foreach ($data as $key => $value) {
                if($value->id==5731||$value->id==5732||$value->id==5734||$value->id==5735){
                    array_push($result,$value);
                }
            }
            sort($result);
            $this->cache->save('maechaem', $result, $time_limit);  
            $this->response($result, 200);
        }
        $this->response($data, 200);
    }
	
	public function snp_get(){
		
	}
	
	public function udonthani_get(){
        set_time_limit(0);
        $this->allowed_origin();
		$ar_station = array(6544, 6548, 5172, 6550, 6541, 5169, 6547, 5168, 5173,5385, 6542, 5167, 6534,5563,5562,5560,5561,5559,5170, 6539, 5171, 6546,6545, 6537, 6543, 5426, 5160, 5172, 6538);
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$time_limit = 1200;
        $data = $this->cache->get('udonthani');
        if (!$data||date('H',$this->cache->get_metadata('udonthani')['mtime'])<date('H')){
            $data = json_decode(file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/stations?v='.date('YmdHis')));
            $result = array();
            foreach ($data as $key => $value) {
               if (in_array($value->id, $ar_station)){
				   array_push($result,$value);
			   }
            }
            sort($result);
            $this->cache->save('udonthani', $result, $time_limit);  
            $this->response($result, 200);
        }
        $this->response($data, 200);
    }
	
	public function lamphun_get(){
        set_time_limit(0);
        $this->allowed_origin();
		$ar_station = array(6398, 5583, 5584, 2003, 5407, 6406, 6403, 6402, 5607, 5606, 6386, 6396, 5406, 5666, 4049, 6385, 6397, 6387, 6393, 6388, 6383, 5287, 6400, 4048, 105, 6391, 5701, 6389, 6394, 6401, 6382, 50, 5702, 6404, 6399, 104, 5696, 6390, 6384, 6381, 5687, 5288, 5289, 5282);
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$time_limit = 1200;
        $data = $this->cache->get('lamphun');
        if (!$data||date('H',$this->cache->get_metadata('lamphun')['mtime'])<date('H')){
            $data = json_decode(file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/stations?v='.date('YmdHis')));
            $result = array();
            foreach ($data as $key => $value) {
               if (in_array($value->id, $ar_station)){
				   array_push($result,$value);
			   }
            }
            sort($result);
            $this->cache->save('lamphun', $result, $time_limit);  
            $this->response($result, 200);
        }
        $this->response($data, 200);
    }
	
	public function nan_get(){
        set_time_limit(0);
        $this->allowed_origin();
		$ar_station = array(5692, 5669, 71, 6362, 72, 6361, 5694, 5693,6363, 40, 39, 5692);
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$time_limit = 1200;
        $data = $this->cache->get('nan');
        if (!$data||date('H',$this->cache->get_metadata('nan')['mtime'])<date('H')){
            $data = json_decode(file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/stations?v='.date('YmdHis')));
            $result = array();
            foreach ($data as $key => $value) {
               if (in_array($value->id, $ar_station)){
				   array_push($result,$value);
			   }
            }
            sort($result);
            $this->cache->save('nan', $result, $time_limit);  
            $this->response($result, 200);
        }
        $this->response($data, 200);
    }
	
	public function nakhonphanom_get(){
        set_time_limit(0);
        $this->allowed_origin();
		$ar_station = array(5585,5587,5238,5588,5590,5591,5234,6520,5589,5187,5189,5188,6519,6516,6517,6518,5394,5188);
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$time_limit = 1200;
        $data = $this->cache->get('nakhonphanom');
        if (!$data||date('H',$this->cache->get_metadata('nakhonphanom')['mtime'])<date('H')){
            $data = json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/stations_temp.json?v='.date('YmdHis')));
            $result = array();
            foreach ($data as $key => $value) {
               if (in_array($value->id, $ar_station)){
				   array_push($result,$value);
			   }
            }
            sort($result);
            $this->cache->save('nakhonphanom', $result, $time_limit);  
            $this->response($result, 200);
        }
        $this->response($data, 200);
    }
	
	public function tak_get(){
        set_time_limit(0);
        $this->allowed_origin();
		$ar_station = array(5028,6416,51,5046,5399,5428,6414,5031,5047,6415,5029,5398,5030,5032);
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$time_limit = 1200;
        $data = $this->cache->get('tak');
        if (!$data||date('H',$this->cache->get_metadata('tak')['mtime'])<date('H')){
            $data = json_decode(file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/stations?v='.date('YmdHis')));
            $result = array();
            foreach ($data as $key => $value) {
               if (in_array($value->id, $ar_station)){
				   array_push($result,$value);
			   }
            }
            sort($result);
            $this->cache->save('tak', $result, $time_limit);  
            $this->response($result, 200);
        }
        $this->response($data, 200);
    }
	
    public function hpc2_get(){
        set_time_limit(0);
        $this->allowed_origin();
        $ar_station = array(52, 5028,5029,5030,5031,5032,5046,5047,5398,5399,5428,6414,6415,6416,5038,5039, 5412,5574,5575,5576,5577,5578,5579,5661,5662,5663,6435,5033,5034,5066,5162,5212,5223,5276,5277,5278,5279,5280,5396,5411,5613,5614,5615,5616,5617,5618,6417,6420,6421,6422,6423,6424,6425,6426,6427,6428,6429,6430,6431,6432,6433,6434,5035,5036,5037,5413,5710,6300,6301,6302,6303,6305,6306,5040,5041,5595,5596,6411);
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        $time_limit = 1200;
        $data = $this->cache->get('hpc2');
        if (!$data||date('H',$this->cache->get_metadata('hpc2')['mtime'])<date('H')){
            $data = json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/stations_temp.json'));
            $result = array();
            foreach ($data as $key => $value) {
               if (in_array($value->id, $ar_station)){
                   array_push($result,$value);
               }
            }
            sort($result);
            $this->cache->save('hpc2', $result, $time_limit);
            $this->response($result, 200);
        }
        $this->response($data, 200);
    }
                    
	public function maetang_get(){
        set_time_limit(0);
        $this->allowed_origin();
		$ar_station = array(5054, 5612, 5707, 5708, 7051,7052,7053,7054,7055,7056,7057,7058,7059,7060,7061);
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$time_limit = 1200;
        $data = $this->cache->get('maetang');
        if (!$data||date('H',$this->cache->get_metadata('maetang')['mtime'])<date('H')){
            $data = json_decode(file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/stations?v='.date('YmdHis')));
            $result = array();
            foreach ($data as $key => $value) {
               if (in_array($value->id, $ar_station)){
				   array_push($result,$value);
			   }
            }
            sort($result);
            $this->cache->save('maetang', $result, $time_limit);  
            $this->response($result, 200);
        }
        $this->response($data, 200);
    }
	
	public function faipanetwork_get(){
        set_time_limit(0);
        $this->allowed_origin();
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$time_limit = 1200;
		$ar_list = array(7039,7041,7051, 7052, 7053, 7054, 7055, 7056, 7057, 7058, 7059, 7060, 7061, 7062,7063,7064,7065,7066,7067,7068,7069,7070,7071,7072,7073,7074,7075,7076,7077,7080,7081,7082,7083,7085,7086,7087,7088,7089,7090,7091,7092,7093,7094,7095,7096,7097,7098,7099,7100,7101,7102,7103,7104,7105,7106,7107,7108,7109,7110,7111,7112,7113,7114,7115,7116,7117,7118,7119,7120,7121,7122,7123,7124,7125,7126,7127,7128,7129,7130,7131,7132,7133,7134,7135,7136,7137,7138,7139,7140,7141,7142,7143,7145,7146,7147,7148,7149,7150,7151,7153,7154,7155,7156,7157,7158,7159,7160,7162,7163,7164,7165);
        $data = $this->cache->get('faipanetwork');
        if (!$data||date('H',$this->cache->get_metadata('faipanetwork')['mtime'])<date('H')){
            $data = json_decode(file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/stations?v='.date('YmdHis')));
            $result = array();
			
			foreach ($data as $key => $value) {
				if (in_array($value->id, $ar_list)){
					array_push($result,$value);
				}
			}
			/*
            foreach ($data as $key => $value) {
                if($value->id>=7051 && $value->id<=7160){
                    array_push($result,$value);
                }
            }*/
            sort($result);
            $this->cache->save('faipanetwork', $result, $time_limit);  
            $this->response($result, 200);
        }
        $this->response($data, 200);
    }
	
	
    public function downloadexcel_get(){
        ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
        $id = $this->uri->segment(4);
        set_time_limit(0);
        $this->allowed_origin();
        $data = json_decode(file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/stations?v='.date('YmdHis')),true);
        $list_elect = array('6615'=>'1001','6625'=>'1002','6626'=>'1003','6627'=>'1004','6629'=>'1005','6630'=>'1006');
      
        $result = array();
        foreach ($data as $key => $value) {
            if($id == @$value['id']){
                $result = array(
                    'id' => $value['id'],
                    'dustboy_id' => $value['dustboy_id'],
                    'dustboy_lat' => $value['dustboy_lat'],
                    'dustboy_lon' => $value['dustboy_lon'],
                    'value' => array(),
                );
                if(array_key_exists($id,$list_elect)){
                    $meter_id = $list_elect[$id];
                    $sql = "SELECT * FROM meter_data WHERE meter_id =".$meter_id." ORDER BY data_time DESC";
                    $query = $this->db->query($sql)->result();
                    foreach ($query as $k => $v) {
                        $dataResult = array(
                            'voltage' => $v->sensor_voltage_V,
                            'current' => $v->sensor_current_A,
                            'power' => $v->sensor_power_W,
                            'energy' => $v->sensor_energy_kWh,
                            'frequency' => $v->sensor_frequency_Hz,
                            'timestamp' => $v->data_time,
                        );
                        array_push($result['value'],$dataResult);
                    }
                }
            }
        }

        $this->response($result, 200);
    }
}
