<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';


class Ccdc extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
		$this->load->model('maintain_model');
		

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    }
	
	function allowed_origin()
	{
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST');
		header("Access-Control-Allow-Headers: X-Requested-With");
	}
	
    public function index_get()
    {
		$this->allowed_origin();
		$data = array(
			"status" => TRUE,
			"message" => "welcome cmuccdc api :)"
		);
		$this->response($data, 200);
	}
		
	public function stations_get(){
		$this->allowed_origin();
		$data = json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/allstations.json'));
		$this->response($data, 200);
	}
	
	public function station_get(){
		$this->allowed_origin();
		$id =  $this->uri->segment(4);
		if($id!=null){
			$stations = json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/allstations.json'));
			$data = array();
			foreach($stations as $station){
				if($id==$station->dustboy_id){
					$value = (array)$station;
					array_push($data, $value);
					$this->response($data[0], 200);
				}
			}
		}else{
			$data = array(
				"status" => FALSE,
				"message" => "data is empty :("
			);
			$this->response($data, 200);
		}
	}
	
	public function value_get(){
		$this->allowed_origin();
		$id =  $this->uri->segment(4);
		if($id!=null){
			$stations = json_decode(file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/value/'.$id));
			$this->response($stations, 200);
		}else{
			$data = array(
				"status" => FALSE,
				"message" => "data is empty :("
			);
			$this->response($data, 200);
		}
	}
	
	public function weather_get(){
		$this->allowed_origin();
		$ar_province = array(38, 46, 40, 51,  45, 43, 44, 42,  50, 52, 54, 51, 41,  49, 47, 53, 48);
		$ar_station = array();
	
		$regions = json_decode(file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/regionreport'));
			
		
		
		foreach($regions as $region){
			
			foreach($region->provinces as $province){
				if (in_array($province->province_id, $ar_province)){
					array_push($ar_station, $province);
				}
			}
		}
		$this->response($ar_station, 200);
	}
	
	public function province_get(){
		$this->allowed_origin();
		$id =  $this->uri->segment(4);
		$station = json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/stations.json'));
		$data = array();
		foreach($station as $item){
			if($item->province_id == $id){
				array_push($data, $item);
			}
		}
		$this->response($data, 200);
		//"Mae Hong Son 46
	}

	public function stations_outdoor_get(){
		$this->allowed_origin();
		$ar_station = array(6636, 4425, 5471, 5472,5468, 5469, 5473, 5475, 5268, 5270, 6614, 6615, 6616, 6617, 6618, 6619, 6620, 6621, 6622, 6623, 6624, 6625, 6626, 6627, 6629, 6630, 6613);
		$station = json_decode(file_get_contents('https://www-old.cmuccdc.org/assets/api/haze/pwa/json/stations.json'));
		$data = array();
		foreach($station as $item){
			if (!in_array((int)$item->id, $ar_station)){
				array_push($data, $item);
			}
		}
		$this->response($data, 200);
	}
	
	public function wplus_get(){
		$this->allowed_origin();
		$data = $this->maintain_model->getWPlus();
		$this->response($data, 200);
		//"Mae Hong Son 46
	}
    
}
