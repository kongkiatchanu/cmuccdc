<?php 
class Main_model extends CI_Model{
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
}