<?php 
class Charm_model extends CI_Model{
	public function __contruct()
	{
		parent::__contruct();
	}
	
	public function getMeterId($id){
		$query = $this->db->order_by('data_time desc')->get_where('meter_data', array('meter_id' => $id));
		return $query->result_array();
	}
	public function getSourceId($source_id){
		$sql="SELECT log_pm10,log_pm25,temp,humid,log_datetime FROM log_mini_2561 WHERE source_id = 5723 and log_datetime BETWEEN ( DATE_SUB( now() , INTERVAL 24 HOUR ) ) AND ( now() ) ORDER BY log_mini_2561.log_datetime DESC ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function getMeterLog(){
		$query = $this->db->order_by('data_time desc')->limit(500)->get('meter_data');
		return $query->result_array();
	}
}