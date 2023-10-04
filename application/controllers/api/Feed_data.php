<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';


class Feed_data extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
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
			"message" => "welcome cmuccdc api feed server 1 to 3 :)"
		);
		$this->response($data, 200);
	}

    //data_daily
    public function feed_data_daily_get(){
        $this->allowed_origin();
        $data = file_get_contents('https://cmuccdc.org/api/feed/data_daily');
        $obj = json_decode($data);
       
        foreach($obj as $item){
            $item = (array)$item;
            $query = $this->db->get_where('data_daily', array('source_id' => $item['source_id'], 'daily_date'=>$item['daily_date']));
            $rs = $query->result();
            if($query->result()){
                echo 'update'.$item['id'].'-'.$item['source_id'];
                $this->db->where('id',$item['id']);
                $this->db->where('source_id',$item['source_id']);
                $this->db->where('daily_date',$item['daily_date']);
			    $this->db->update('data_daily', array('pm25'=>$item['pm25'], 'pm10'=>$item['pm10'], 'humid'=>$item['humid'], 'temp'=>$item['temp']));
            }else{
                echo 'insert'.$item['id'].'-'.$item['source_id'];
                $this->db->insert('data_daily',$item);
            }
            echo '<br>';
        }
    }

    //db_status
    public function feed_db_status_get(){
        $this->allowed_origin();
        $data = file_get_contents('https://cmuccdc.org/api/feed/db_status');
        $obj = json_decode($data);
        print_r($obj);
        foreach($obj as $item){
            $item = (array)$item;
            $query = $this->db->get_where('db_status', array('status_source_id' => $item['status_source_id']));
		    $rs = $query->result();
            if($rs!=null){
                $this->db->where('status_source_id',$item['status_source_id']);
			    $this->db->update('db_status', $item);
            }else{
                $this->db->insert('db_status',$item);
                return $this->db->insert_id();
            }
        }
    }

    //meter_data
    public function feed_meter_data_get(){
        $this->allowed_origin();
        $data = file_get_contents('https://cmuccdc.org/api/feed/meter_data');
        $obj = json_decode($data);
       
        foreach($obj as $item){
            $item = (array)$item;
            $query = $this->db->get_where('meter_data', array('data_id' => $item['data_id']));
		    $rs = $query->result();
            if($rs==null){
                echo $item['data_id'];
                echo '<br>'; 
                $this->db->insert('meter_data',$item);
            }
        }
    }
		
    //snapshot
    public function feed_snapshot_get(){
        $this->allowed_origin();
        $data = file_get_contents('https://cmuccdc.org/api/feed/snapshot');
        $obj = json_decode($data);
       
        foreach($obj as $item){
            $item = (array)$item;
            $query = $this->db->get_where('snapshot', array('id' => $item['id']));
		    $rs = $query->result();
            if($rs==null){
                echo $item['id'];
                echo '<br>'; 
                $this->db->insert('snapshot',$item);
            }
            
        }
    }

    //log_zdata
    public function feed_log_zdata_get(){
        $this->allowed_origin();
        $data = file_get_contents('https://cmuccdc.org/api/feed/log_zdata');
        $obj = json_decode($data);
       
        foreach($obj as $item){
            $item = (array)$item;
            $query = $this->db->get_where('log_zdata', array('log_id' => $item['log_id']));
		    $rs = $query->result();
            if($rs==null){
                echo $item['log_id'];
                echo '<br>'; 
                $this->db->insert('log_zdata',$item);
            }
            
        }
    }

    //log_zdata
    public function feed_log_wplus_get(){
        $this->allowed_origin();
        $data = file_get_contents('https://cmuccdc.org/api/feed/log_wplus');
        $obj = json_decode($data);
       
        foreach($obj as $item){
            $item = (array)$item;
            $query = $this->db->get_where('log_wplus', array('log_id' => $item['log_id']));
		    $rs = $query->result();
            if($rs==null){
                echo $item['log_id'];
                echo '<br>'; 
                $this->db->insert('log_wplus',$item);
            }
        }
    }

    public function feed_log_mini_2561_get(){
        $this->allowed_origin();
        $sql = "SELECT max(log_id) as id FROM `log_mini_2561`";
        $query = $this->db->query($sql); 
        $rs = $query->result()[0];

        $data = file_get_contents('https://cmuccdc.org/api/feed/log_mini_2561/'.$rs->id);
        $obj = json_decode($data);
       
        foreach($obj as $item){
            $item = (array)$item;
            $query = $this->db->get_where('log_mini_2561', array('log_id' => $item['log_id']));
		    $rs = $query->result();
            if($rs==null){
                echo $item['log_id'];
                echo '<br>'; 
                $this->db->insert('log_mini_2561',$item);
            }
        }
    }

    public function feed_log_data_2561_get(){
        $this->allowed_origin();

        $sql = "SELECT max(log_id) as id FROM `log_data_2561`";
        $query = $this->db->query($sql); 
        $rs = $query->result()[0];

        $data = file_get_contents('https://cmuccdc.org/api/feed/log_data_2561/'.$rs->id);
        $obj = json_decode($data);
       
        foreach($obj as $item){
            $item = (array)$item;
            $query = $this->db->get_where('log_data_2561', array('log_id' => $item['log_id']));
		    $rs = $query->result();
            if($rs==null){
                echo $item['log_id'];
                echo '<br>'; 
                $this->db->insert('log_data_2561',$item);
            }
        }
    }

    public function feed_log_data_2562_get(){

        $sql="SELECT max(log_datetime) as last FROM `log_data_2562`";
        $query = $this->db->query($sql); 
        $rs = $query->result()[0];
        $url = 'https://cmuccdc.org/api/feed/log_data_2562/'.$rs->last;
        $data = file_get_contents($url);
        $obj = json_decode($data);
     
        foreach($obj as $item){
            $item = (array)$item;
            $query = $this->db->get_where('log_data_2562', array('log_datetime' => $item['log_datetime'], 'source_id'=> $item['source_id']));
		    $rs = $query->result();
            if($rs==null){
                echo $item['log_id'];
                echo '<br>'; 
                $this->db->insert('log_data_2562',$item);
            }
        }
    }
	
}