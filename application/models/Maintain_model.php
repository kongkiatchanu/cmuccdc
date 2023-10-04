<?php 
class Maintain_model extends CI_Model{
	public function __contruct()
	{
		parent::__contruct();
	}
	
	public function getWPlus(){
		$query = $this->db->order_by('log_datetime desc')->limit(500)->get('log_wplus');
		return $query->result();
	}
	
	public function insertRenew($ar){
		$this->db->insert('maintain_renew',$ar);
		return $this->db->insert_id();	
	}
	
	public function getDustBoyID($source_id){
		$this -> db -> select('*');
		$this -> db -> from('source');
		$this -> db -> where('source_id', $source_id);
		$query = $this -> db -> get();
		return $query->result();
	}
	
	public function getStationList(){
		$this -> db -> select('source_id, location_id, location_name');
		$this -> db -> from('source');
		$this -> db -> where('location_status', 1);
		$this -> db -> order_by('source_id asc');
		$query = $this -> db -> get();
		return $query->result();
	}
	
	public function getStationStatus(){
		$query = $this->db->order_by('status_update asc')->get('db_status');
		/*$this -> db -> select('*');
		$this -> db -> from('db_status');
		$this -> db -> where('status_source_id > 7000');
		$query = $this -> db -> get();*/
		return $query->result();
	}
	public function insertDBStatus($ar){
		$this->db->insert('db_status',$ar);
		return $this->db->insert_id();	
	}
	
	public function getDataSony(){
		$data = array();
		$sql ="SELECT t1.source_id, t1.nickname, t1.log_pm25, MAX(t1.log_datetime) AS log_datetime, t2.location_name_en FROM log_sony t1 LEFT JOIN source t2 ON t1.source_id = t2.source_id group by t1.nickname ";
		$query = $this->db->query($sql);
		foreach($query->result() as $item){
			$sql2= "SELECT `log_pm25` FROM `log_sony` WHERE `source_id` = ".$item->source_id." ORDER BY log_datetime desc limit 1";
			$q2 = $this->db->query($sql2);
			$rs = $q2->result();
			$item->log_pm25 = $rs[0]->log_pm25;
			array_push($data, $item);
			
		}
		
		return $data;
	}
	
	public function updateStatusValue($source_id){
		$query = $this->db->get_where('source', array('source_id' => $source_id));
		$rs = $query->result();
		
		$db = 'log_data_2562';
		if($rs[0]->version=="mini"){
			$db = 'log_mini_2561';
		}
		if($rs[0]->version=="wplus"){
			$db = 'log_wplus';
		}

		
		$query_value = $this->db->limit(1)->order_by('log_datetime DESC')->get_where($db, array('source_id' => $source_id));
		$rsValue = $query_value->result();
		if($rsValue){
			$ar_update = array(
				'status_date' => $rsValue[0]->log_datetime,
				'status_source_ids' => $rs[0]->location_id,
				'status_source_name' => $rs[0]->location_name,
				'status_source_pv' => $rs[0]->source_province_id,
				'status_lat' => $rs[0]->location_lat,
				'status_lnt' => $rs[0]->location_lon,
				'status_update' => date('Y-m-d H:i:s'),
				'status_pm25' => $rsValue[0]->log_pm25,
				'status_co_name' => $rs[0]->db_co,
				'status_co_mobile' => $rs[0]->db_mobile,
				'status_addr' => $rs[0]->db_addr,
			);
			$this->db->where('status_source_id',$rsValue[0]->source_id);
			$this->db->update('db_status',$ar_update);
			return $this->db->affected_rows();
		}else{
			$ar_update = array(
				'status_date' => '0000-00-00 00:00:00',
				'status_source_ids' => $rs[0]->location_id,
				'status_source_name' => $rs[0]->location_name,
				'status_source_pv' => $rs[0]->source_province_id,
				'status_lat' => $rs[0]->location_lat,
				'status_lnt' => $rs[0]->location_lon,
				'status_update' => date('Y-m-d H:i:s'),
				'status_pm25' => null,
				'status_co_name' => $rs[0]->db_co,
				'status_co_mobile' => $rs[0]->db_mobile,
				'status_addr' => $rs[0]->db_addr,
			);
			$this->db->where('status_source_id',$source_id);
			$this->db->update('db_status',$ar_update);
			return $this->db->affected_rows();
		}
	}
	
	public function getProvinceList(){
		$query = $this->db->order_by('province_name asc')->get_where('z_province');
		return $query->result();
	}
	
	public function getDustBoyStatus($status_source_pv=null){
		$this -> db -> select('*');
		$this -> db -> from('db_status');
		if($status_source_pv!=null){
			$this -> db -> where('status_source_pv', $status_source_pv);
		}
		$query = $this -> db -> get();
		
		return $query->result();
	}
	
	public function login($username, $password)
	{
		$this -> db -> select('*');
		$this -> db -> from('maintain_user');
		$this -> db -> where('username', $username);
		$this -> db -> where('password', $password);
		$this -> db -> where('user_status', 1);
		$this -> db -> limit(1);
	 
		$query = $this -> db -> get();
	 
		if($query -> num_rows() == 1){
			$this->db->where('username',$username);
			$this->db->update('maintain_user',array('user_lastlogin'=> date('y-m-d H:i:s')));
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function addRequestLocation($ar){
		$this->db->insert('maintain_location',$ar);
		return $this->db->insert_id();	
	}
	
	public function addRequest($ar){
		$this->db->insert('maintain_request',$ar);
		return $this->db->insert_id();	
	}
	
	public function getRequestDetail($request_key){
		$query = $this->db->get_where('maintain_request', array('request_key' => $request_key));
		return $query->result();
	}
	
	public function cmRequest($ar){
		$this->db->where('request_key',$ar['request_key']);
		$this->db->update('maintain_request',$ar);
		return $this->db->affected_rows();
	}
	
	public function getAllEngineLists(){
		$this -> db -> select('source_id, location_id, location_name, location_name_en');
		$this -> db -> from('source');
		$this -> db -> where('location_status', 1);

		$query = $this -> db -> get();
		

		return $query->result();
	}
	
	public function getEngineID($engine_id){
		$query = $this->db->get_where('maintain_engine', array('engine_id' => $engine_id, 'deleted'=>0));
		return $query->result();
	}
	
	public function getEngineLists($engine_username){
		$query = $this->db->get_where('maintain_engine', array('engine_username' => $engine_username, 'deleted'=>0));
		return $query->result();
	}
	
	public function updateEngineMember($ar){
		$this->db->where('engine_id',$ar['engine_id']);
		$this->db->where('engine_username',$ar['engine_username']);
		$this->db->update('maintain_engine',$ar);
		return $this->db->affected_rows();
	}
	
	public function ckMemberNontiData($username){
		$query = $this->db->get_where('maintain_user', array('username' => $username));
		$rs= $query->result();
		if(!$rs[0]->user_noti){
			$this->db->where('username',$username);
			$this->db->update('maintain_user',array('user_noti'=>1));
			return $this->db->affected_rows();
		}
	}
	
	public function ckMemberFixed($username, $id){
		$query = $this->db->get_where('maintain_engine', array('engine_username' => $username, 'engine_id'=>$id));
		$rs= $query->result();
		if(!$rs[0]->is_repair){
			$this->db->where('engine_username',$username);
			$this->db->where('engine_id',$id);
			$this->db->update('maintain_engine',array('is_repair'=>1));
			return $this->db->affected_rows();
		}
	}

	public function addSetupLists($ar){
		$this->db->insert('maintain_setup',$ar);
		return $this->db->insert_id();	
	}
	
	public function getDataDailyPV($is_cnx){
		$array = array();
		$query = $this->db->select('source_id, location_name')->get_where('source', array('is_cnx' => $is_cnx, 'location_status'=> 1));
		$rs = $query->result();
		foreach($rs as $item){
			array_push($array, $item->source_id);
		}
		$this -> db -> select('source_id,pm25,daily_date');
		$this -> db -> from('data_daily');
		$this->db->where_in('source_id', $array );
		$query = $this -> db -> get();
		return $query->result();
	
	}
	
	public function getDataDaily($source_id){
			$query = $this->db->select('pm25,daily_date')->get_where('data_daily', array('source_id'=>$source_id));
			return $query->result();
	}
	public function getsourcebyprovince($is_cnx){
		$query = $this->db->select('source_id, location_name')->get_where('source', array('is_cnx' => $is_cnx, 'location_status'=> 1));
		return $query->result();
	}
}


