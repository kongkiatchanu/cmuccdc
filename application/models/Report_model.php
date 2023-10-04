<?php 
class Report_model extends CI_Model{
	public function __contruct()
	{
		parent::__contruct();
	}
	
	public function getStatusDB($id){
		
		//$query = $this->db->select('source_id,location_id,location_name,location_uri,db_status')->like('location_id',$id)->get('source');
		$query = $this->db->select('source_id,location_id,location_name,location_uri,db_status')->get_where('source', array('location_id' =>$id));
		return $query->result();
		//return $query->result();

	}
	public function get_temp($time1,$time2){
		$query="SELECT AVG(temp) as temp FROM log_data_2562 WHERE source_id = 112 AND log_datetime >= '".$time1."' AND log_datetime < '".$time2."' ORDER BY log_datetime ASC";
		$query = $this->db->query($query);
		return $query->result();
	}
	//วช 5319,5356,5326,5324,5263,5051,5212,5388,5084,5352,5152,5343,5342,5335
	public function get_logdata_62($id,$time1,$time2){
		$query="SELECT source_id,AVG(log_pm25) as pm25,log_datetime FROM log_data_2562 WHERE source_id = $id AND log_datetime >= '".$time1."' AND log_datetime < '".$time2."' ORDER BY log_datetime ASC";
		$query = $this->db->query($query);
		return $query->result();
	}
	public function get_logdata_61($id,$time1,$time2){
		$query="SELECT source_id,AVG(log_pm25) as pm25,log_datetime FROM log_mini_2561 WHERE source_id = $id AND log_datetime >= '".$time1."' AND log_datetime < '".$time2."' ORDER BY log_datetime ASC";
		$query = $this->db->query($query);
		return $query->result();
    }
    public function getDaily($id){
		
		//$query = $this->db->select('source_id,location_id,location_name,location_uri,db_status')->like('location_id',$id)->get('source');
		$query = $this->db->select('*')->get_where('data_daily', array('source_id' =>$id));
		return $query->result();
		//return $query->result();

	}
	public function get_logdata_nrct($id,$time1,$time2){
		$result=array();
		$query="SELECT source_id,AVG(log_pm25) as pm25,log_datetime FROM log_data_2562 WHERE source_id = $id AND log_datetime >= '".$time1."' AND log_datetime < '".$time2."' ORDER BY log_datetime ASC";
		$query = $this->db->query($query);
		
		return $query->result();
	}
	public function province(){
		$result=array();
		$query="SELECT * FROM z_province ORDER BY province_id ASC";
		$query = $this->db->query($query);
		
		return $query->result();
	}
	// public function daliy_logdata_62($id,$time1,$time2){
	// 	$query="SELECT source_id,AVG(log_pm25) as pm25,log_datetime FROM log_data_2562 WHERE source_id = $id AND log_datetime >= '".$time1."' AND log_datetime < '".$time2."' ORDER BY log_datetime ASC";
	// 	$query = $this->db->query($query);
	// 	return $query->result();
	// }
	// public function daliy_logdata_61($id,$time1,$time2){
	// 	$query="SELECT source_id,AVG(log_pm25) as pm25,log_datetime FROM log_mini_2561 WHERE source_id = $id AND log_datetime >= '".$time1."' AND log_datetime < '".$time2."' ORDER BY log_datetime ASC";
	// 	$query = $this->db->query($query);
	// 	return $query->result();
	// }
}