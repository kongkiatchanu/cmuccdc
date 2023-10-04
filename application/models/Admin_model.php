<?php 
class Admin_model extends CI_Model{
	public function __contruct()
	{
		parent::__contruct();
	}
	
	public function getMaintainRenew(){
		$query = $this->db->order_by('createdate desc')->get('maintain_renew');
		return $query->result();
	}
	public function getMaintainRenewDetail($renew_id){
		$query = $this->db->order_by('createdate desc')->get_where('maintain_renew', array('renew_id' => $renew_id));
		return $query->result();
	}
	
	
	public function getMaintainNotiList(){
		$query = $this->db->order_by('createdate desc')->get_where('maintain_location', array('deleted' => 0));
		return $query->result();
	}
	
	public function getMaintainNoti($loc_id){
		$query = $this->db->get_where('maintain_location', array('deleted' => 0, 'loc_id'=>$loc_id));
		$rs = $query->result();
		if($rs){
			$this->db->where('loc_id',$loc_id);
			$this->db->update('maintain_location', array('loc_view'=>1));
			return $rs;
		}
	}

	public function getDustBoy100(){
		$query = $this->db->get_where('mkup', array('is_show' => 1));
		return $query->result();
	}
	
	public function getMkupDetail($id){
		$query = $this->db->get_where('mkup', array('id' => $id));
		return $query->result();
	}
	
	public function updateMkup($ar){
		$this->db->where('id',$ar['id']);
		$this->db->update('mkup',$ar);
		return $ar['id'];
	}
	
	public function insertMkup($ar){
		$this->db->insert('mkup',$ar);
		return $this->db->insert_id();	
	}
	
	public function login($username, $password)
	{
	   $this -> db -> select('*');
	   $this -> db -> from('admin');
	   $this -> db -> where('username', $username);
	   $this -> db -> where('password', $password);
	   $this -> db -> where('is_ban', 0);
	   $this -> db -> where('is_admin', 1);
	   $this -> db -> limit(1);
	 
	   $query = $this -> db -> get();
	 
	   if($query -> num_rows() == 1)
	   {
		 return $query->result();
	   }
	   else
	   {
		 return false;
	   }
	}
	

	/*admin*/
	public function checkAdmin($ar)
	{
		$query = $this->db->get_where('admin', array('username' => $ar['username'],'password' => $ar['password']));
		return $query->result();
	}
	public function updateUser($ar)
	{
		$this->db->where('username',$ar['username']);
		$this->db->update('admin',$ar);
		
		$query = $this->db->get_where('admin', array('username' => $ar['username']));
		return $query->result();
	}
	
	//webinfo
	public function getWebinfo(){
		$query = $this->db->get_where('webinfo', array('site_id' => 1));
		return $query->result();
	}
	
	public function updateWebinfo($ar){
		$this->db->where('site_id',1);
		$this->db->update('webinfo',$ar);
		return $ar['site_id'];
	}
	
	//contact
	public function getContactList()
	{
		$query = $this->db->order_by('contact_datetime DESC')->get('contact');
		return $query->result();
	}
	public function deleteContact($idcontact)
	{
		$this->db->delete('contact', array('idcontact' => $idcontact));  
	}
	public function getContactDetail($idcontact)
	{
		$this->db->where('idcontact',$idcontact);
		$this->db->update('contact',array('contact_view'=>1));
		
		$this->db->select("*, DATE_FORMAT(contact.contact_datetime, '%d %M %Y %H:%i') as thaidate", false);
        $this->db->from('contact');
		$this->db->where('contact.idcontact',$idcontact);
		$query = $this->db->get(); 
		return $query->result();
	}
	public function getNewInbox(){
		$this->db->select("*, count(idcontact) as total_row");
        $this->db->from('contact');
		$this->db->where('contact.contact_view',0);
		$query = $this->db->get(); 
		return $query->result();
	}
	public function getInbox(){
		$this->db->select("*");
        $this->db->from('contact');
		$this->db->limit(3);
		$this->db->order_by('contact_datetime DESC');
		$query = $this->db->get(); 
		return $query->result();
	}
	
	//slide images
	public function getSlideImgList(){
		$query = $this->db->get('slide_img');
		return $query->result();
	}
	public function insertSlideImg($ar){
		$this->db->insert('slide_img',$ar);
	}
	public function updateSlideImg($ar){
		$this->db->where('slide_id',$ar['slide_id']);
		$this->db->update('slide_img',$ar);
	}
	public function getSlideImgDetail($slide_id){
		$query = $this->db->get_where('slide_img', array('slide_id' => $slide_id));
		return $query->result();
	}
	public function delSlideImg($slide_id){
		$this->db->delete('slide_img', array('slide_id' => $slide_id));  
	}
	
	public function delGallery($gallery_id){
		$this->db->delete('gallery', array('gallery_id' => $gallery_id));  
	}
	
	
	public function insertFiles($ar){
		$this->db->insert('content_file',$ar);
		return $this->db->insert_id();	
	}
	
	public function getFileList($file_idcontent){
		$query = $this->db->get_where('content_file', array('file_idcontent' => $file_idcontent));
		return $query->result();
	}
	
	public function delQuotationFile($file_id,$file_idcontent){
		$query = $this->db->get_where('content_file', array('file_idcontent' => $file_idcontent, 'file_id' => $file_id));
		$row = $query->result();
		if($row!=null){
			$this->db->delete('content_file', array('file_id' => $file_id));
			return $file_id;
		}
	}
	
	public function insertPageFiles($ar){
		$this->db->insert('page_file',$ar);
		return $this->db->insert_id();	
	}
	public function getPageFileList($file_idpage){
		$query = $this->db->get_where('page_file', array('file_idpage' => $file_idpage));
		return $query->result();
	}
	public function delPageQuotationFile($file_id,$file_idpage){
		$query = $this->db->get_where('page_file', array('file_idpage' => $file_idpage, 'file_id' => $file_id));
		$row = $query->result();
		if($row!=null){
			$this->db->delete('page_file', array('file_id' => $file_id));
			return $file_id;
		}
	}
	
	
	
	
	
	
	/*section*/
	public function getSection()
	{
		$query = $this->db->get('content_section');
		return $query->result();
	}
	public function getSectionByID($id_section)
	{
		$this->db->select('section_name');
		$query = $this->db->get_where('content_section', array('id_section' => $id_section));
		return $query->result();
	}
	
	/*getCategory*/
	public function getCategory()
	{
		$this->db->select('t2.id_section,t2.section_name,t1.id_category,t1.category_name,t3.id_category as idparent,t3.category_name as parent');
		$this->db->from('content_category t1'); 
		$this->db->join('content_section t2', 't2.id_section=t1.id_section', 'left');
		$this->db->join('content_category t3', 't1.category_parent=t3.id_category', 'left');
		$this->db->order_by('t1.id_category ASC');
		$query = $this->db->get();
		return  $query->result();
	}

	/*getCategoryRow*/
	public function getCategoryRow($id_category)
	{
		$this->db->select('t1.id_section,t1.section_name,t2.id_category,t2.category_name,t3.id_category as idparent,t3.category_name as parent');
		$this->db->from('content_section t1'); 
		$this->db->join('content_category t2', 't1.id_section=t2.id_section', 'left');
		$this->db->join('content_category t3', 't2.category_parent=t3.id_category', 'left');
		$this->db->where('t2.id_category',$id_category);
		$query = $this->db->get();
		return  $query->result();
	}

	/*updateCategory*/
	public function updateCategory($ar)
	{
		$this->db->where('id_category',$ar['id_category']);
		$this->db->update('content_category',$ar);
	}

	/*insertCategory*/
	public function insertCategory($ar)
	{
		$this->db->insert('content_category',$ar);
	}

	/*deleteCategory*/
	public function deleteCategory($id_category)
	{
		$this->db->delete('content', array('id_category' => $id_category));  
		$this->db->delete('content_category', array('id_category' => $id_category));  
	}

	/*getContentsList*/
	public function getContentsList($id_section)
	{
		$this->db->select('*');
		$this->db->from('content t1'); 
		$this->db->join('content_category t2', 't1.id_category=t2.id_category', 'left');
		$this->db->join('content_section t3', 't2.id_section=t3.id_section', 'left');
		$this->db->where('t3.id_section',$id_section)->order_by('t1.content_created DESC');
		$query = $this->db->get();
		return  $query->result();
	}

	public function getAllContentsList()
	{
		$this->db->select('*');
		$this->db->from('content t1'); 
		$this->db->join('content_category t2', 't1.id_category=t2.id_category', 'left');
		$this->db->join('content_section t3', 't2.id_section=t3.id_section', 'left');
		$query = $this->db->get();
		return  $query->result();
	}

	/*insertContents*/
	public function insertContents($ar)
	{
		$this->db->insert('content',$ar);
		return $this->db->insert_id();	
	}
	
	/*getContentRow*/
	public function getContentRow($idcontent)
	{
		$query = $this->db->get_where('content', array('idcontent' => $idcontent));
		return $query->result();	
	}
	
	/*updateContents*/
	public function updateContents($ar)
	{
		$this->db->where('idcontent',$ar['idcontent']);
		$this->db->update('content',$ar);
	}
	
	/*deleteContent*/
	public function deleteContent($idcontent)
	{
		$this->db->delete('content', array('idcontent' => $idcontent));  
	}
	
	

	/*menu*/
	public function getMenuListItemForm(){
		$rs = array();
		//$query = $this->db->order_by('menu_order', 'ASC')->get_where('menu', array('menu_parent' => 0));
		
		$this->db->select('*');
		$this->db->from('menu t1'); 
		$this->db->join('page t2', 't1.idpage=t2.idpage', 'left');
		$this->db->where('t1.menu_parent', 0);
		$query= $this->db->get();
		
		foreach($query->result_array() as $row){
			$subRs = array();
			
			$this->db->select('*');
			$this->db->from('menu t1'); 
			$this->db->join('page t2', 't1.idpage=t2.idpage', 'left');
			$this->db->where('t1.menu_parent', $row['idmenu']);
			$subQuery= $this->db->get();
			
			//$subQuery = $this->db->get_where('menu', array('menu_parent' => $row['idmenu']));
		  	foreach($subQuery->result_array() as $subRow){
		  		array_push($subRs,$subRow);
		  	}
		  	$mainMenu = array(
				"idmenu" => $row["idmenu"],
				"menu_label" => $row["menu_label"],
				"menu_parent" => $row["menu_parent"],
				"menu_order" => $row["menu_order"],
	            "idpage"=> $row["idpage"],
	            "page_title"=> $row["page_title"],
	            "menu_link"=> $row["menu_link"],
	            "subMenu"=> $subRs
			);
		  	array_push($rs,$mainMenu);
		}
		return $rs; //json_encode($rs);
	}
	public function getMenuListItem()
	{
		$this->db->select('t1.*,t2.idpage,t2.page_title,(SELECT t3.menu_label FROM menu t3 WHERE t3.idmenu = t1.menu_parent) AS menu_parent');
		$this->db->from('menu t1'); 
		$this->db->join('page t2', 't1.idpage=t2.idpage', 'left');
		$this->db->order_by('t1.menu_order,t1.idpage ASC');
		$query = $this->db->get();
		return  $query->result();
	}

	/*getMenuRow*/
	public function getMenuItem($idmenu)
	{
		$query = $this->db->get_where('menu', array('idmenu' => $idmenu));
		return $query->result();
	}


	/*deleteMenu*/
	public function deleteMenu($idmenu)
	{
		$this->db->delete('menu', array('idmenu' => $idmenu));  
	}

	/*insertMenu*/
	public function insertMenu($ar)
	{
		$this->db->insert('menu',$ar);
	}

	/*updateMenu*/
	public function updateMenu($ar)
	{
		$this->db->where('idmenu',$ar['idmenu']);
		$this->db->update('menu',$ar);
	}


	public function getGallery(){
		
		$query = $this->db->order_by('gallery_create DESC')->get('gallery');
		return $query->result();
	}
	
	public function insertGallery($ar){
		$this->db->insert('gallery',$ar);
		return $this->db->insert_id();
	}
	
	public function updateGallery($ar){
		$this->db->where('gallery_id',$ar['gallery_id']);
		$this->db->update('gallery',$ar);
		return $ar['gallery_id'];
	}
	
	public function getGalleryDetail($gallery_id){
		$query = $this->db->get_where('gallery', array('gallery_id' => $gallery_id));
		return $query->result();
	}
	
	public function getGalleryImgList($gallery_id){
		$query = $this->db->get_where('gallery_img', array('gallery_id' => $gallery_id));
		return $query->result();
	}
	
	public function insertGalleryImgDetail($ar){
		$this->db->insert('gallery_img',$ar);
		return $this->db->insert_id();
	}
	
	
	public function getPageList(){
		$query = $this->db->order_by('page_create DESC')->get('page');
		return $query->result();
	}
	public function getPageDetail($idpage){
		$query = $this->db->get_where('page', array('idpage' => $idpage));
		return $query->result();
	}
	public function insertPage($ar){
		$this->db->insert('page',$ar);
		return $this->db->insert_id();
	}
	public function updatePage($ar){
		$this->db->where('idpage',$ar['idpage']);
		$this->db->update('page',$ar);
		return $ar['idpage'];
	}
	public function deletePage($idpage){
		$this->db->delete('page', array('idpage' => $idpage));  
	}
	


	
	public function getMemberList(){
		$this->db->select('*');
		$this->db->from('member t1'); 
		//$this->db->join('tbmajor t2', 't1.tbmajor_idtbmajor=t2.idtbmajor', 'left');
		$this->db->order_by('t1.member_datetime DESC');
		$query = $this->db->get();
		return $query->result();
	}

	// landing page
	public function getLandingPageList(){
		$this->db->order_by('intro_create', "desc");
		$query = $this->db->get('site_intro'); 
		return $query->result();
	}
	
	public function getLandingPageDetail($intro_id){
		$query = $this->db->get_where('site_intro', array('intro_id' => $intro_id));
		return $query->result();
	}
	
	public function updateLandingPage($ar){
		if($ar['intro_active']==1){
			$sql = "update site_intro set intro_active=0 where intro_id>0";
			$query = $this->db->query($sql);
		}
		$this->db->where('intro_id',$ar['intro_id']);
		$this->db->update('site_intro',$ar);
	}
	
	public function delLandingPage($intro_id){
		$this->db->delete('site_intro', array('intro_id' => $intro_id));
		$this->db->limit(1);
	}
	
	public function insertLandingPage($ar){
		if($ar['intro_active']==1){
			$sql = "update site_intro set intro_active=0 where intro_id>0";
			$query = $this->db->query($sql);
		}
		$this->db->insert('site_intro',$ar);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	
	//ribbon
	public function getRibbonList(){
		$this->db->order_by('ribbon_create', "desc");
		$query = $this->db->get('ribbon'); 
		return $query->result();
	}
	public function insertRibbon($ar){
		if($ar['ribbon_status']==1){
			$sql = "update ribbon set ribbon_status=0 where ribbon_id>0";
			$query = $this->db->query($sql);
		}
		$this->db->insert('ribbon',$ar);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}
	public function updateRibbon($ar){
		if($ar['ribbon_status']==1){
			$sql = "update ribbon set ribbon_status=0 where ribbon_id>0";
			$query = $this->db->query($sql);
		}
		$this->db->where('ribbon_id',$ar['ribbon_id']);
		$this->db->update('ribbon',$ar);
	}
	public function getRibbonDetail($ribbon_id){
		$query = $this->db->get_where('ribbon', array('ribbon_id' => $ribbon_id));
		return $query->result();
	}
	public function delRibbon($ribbon_id){
		$this->db->delete('ribbon', array('ribbon_id' => $ribbon_id));
		$this->db->limit(1);
	}
	
	// poll
	public function getPollList(){
		$this->db->order_by('created_on desc, is_show asc'); 
		$query = $this->db->get('poll_questions'); 
		return $query->result();
	}

	public function getPoll($id){
		$this->db->select("*");
		$this->db->from('poll_questions'); 
		$this->db->join('poll_options', 'poll_questions.id=poll_options.ques_id','left');
		$this->db->where('poll_questions.id',$id);
		$query = $this->db->get();
		return  $query->result();	
	}

	public function getPollResult($id){
		$this->db->select("poll_questions.ques, poll_options.value, count(poll_votes.id) as votes");
		$this->db->from('poll_questions'); 
		$this->db->join('poll_options', 'poll_questions.id=poll_options.ques_id','left');
		$this->db->join('poll_votes', 'poll_options.option_id=poll_votes.option_id','left');
		$this->db->where('poll_questions.id',$id);
		$this->db->group_by("poll_options.option_id");
		$query = $this->db->get();
		return  $query->result();	
	}

	public function getPollResultTotal($id){
		$this->db->select("count(poll_votes.id) as vote_total");
		$this->db->from('poll_questions'); 
		$this->db->join('poll_options', 'poll_questions.id=poll_options.ques_id','left');
		$this->db->join('poll_votes', 'poll_options.option_id=poll_votes.option_id','left');
		$this->db->where('poll_questions.id',$id);
		$query = $this->db->get();
		return  $query->result();	
	}

	public function delPoll($id){
		$this->db->delete('poll_options', array('ques_id' => $id));
		$this->db->delete('poll_questions', array('id' => $id));
	}

	public function delPollOption($option_id, $ques_id){
		$this->db->delete('poll_options', array('option_id' => $option_id, 'ques_id' => $ques_id));
		$this->db->limit(1);
	}

	public function updatePoll($ar){
		if($ar['is_show']==1){
			$sql = "update poll_questions set is_show=0 where id>0";
			$query = $this->db->query($sql);
		}
		$this->db->where('id',$ar['id']);
		$this->db->update('poll_questions',$ar);
	}

	public function updateOption($id, $key, $val){
		$this->db->where('option_id',$key);
		$this->db->where('ques_id',$id);
		$this->db->update('poll_options',array('value'=>$val));
	}

	public function insertOption($ques_id, $value){
		$ar = array('ques_id'=>$ques_id, 'value'=>$value);
		$this->db->insert('poll_options',$ar);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}

	public function insertPoll($ar){
		if($ar['is_show']==1){
			$sql = "update poll_questions set is_show=0 where id>0";
			$query = $this->db->query($sql);
		}
		$this->db->insert('poll_questions',$ar);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}

	//personal
	public function getPersonalType($type_group){
		$query = $this->db->order_by('type_qno ASC')->get_where('personal_type',array('type_group'=>$type_group));
		return $query->result();
	}
	public function getPersonalList($type_group){
		$this->db->select("*");
		$this->db->from('personal t1'); 
		$this->db->join('personal_type t2', 't1.personal_type_id=t2.type_id', 'left');
		$this->db->where('t2.type_group',$type_group);
		$this->db->order_by('t2.type_qno ASC, t1.personal_qno ASC');
		$query = $this->db->get();
		return  $query->result();
	
	}
	public function insertPersonal($ar){
		$this->db->insert('personal',$ar);
	}
	public function updatePersonal($ar){
		$this->db->where('personal_id',$ar['personal_id']);
		$this->db->update('personal',$ar);
	}
	public function getPersonalDetail($personal_id){
		$this->db->select("*");
		$this->db->from('personal t1'); 
		$this->db->join('personal_type t2', 't1.personal_type_id=t2.type_id', 'left');
		$this->db->where('t1.personal_id',$personal_id);
		$query = $this->db->get();
		return  $query->result();
	}
	public function delPersonal($personal_id){
		$this->db->delete('personal', array('personal_id' => $personal_id));  
	}

	// external
	public function getExternalList(){
		$query = $this->db->order_by('link_qno ASC')->get('external_link');
		return $query->result();
	}
	public function insertExternal($ar){
		$this->db->insert('external_link',$ar);
	}
	public function updateExternal($ar){
		$this->db->where('idlink',$ar['idlink']);
		$this->db->update('external_link',$ar);
	}
	public function getExternalDetail($idlink){
		$query = $this->db->get_where('external_link', array('idlink' => $idlink));
		return $query->result();
	}
	public function delExternal($idlink){
		$this->db->delete('external_link', array('idlink' => $idlink));  
	}
	
	// external2
	public function getExternalList2(){
		$query = $this->db->order_by('link_qno ASC')->get('external_link2');
		return $query->result();
	}
	public function insertExternal2($ar){
		$this->db->insert('external_link2',$ar);
	}
	public function updateExternal2($ar){
		$this->db->where('idlink',$ar['idlink']);
		$this->db->update('external_link2',$ar);
	}
	public function getExternalDetail2($idlink){
		$query = $this->db->get_where('external_link2', array('idlink' => $idlink));
		return $query->result();
	}
	public function delExternal2($idlink){
		$this->db->delete('external_link2', array('idlink' => $idlink));  
	}


	// topic
	public function getTopicList($start=null, $limit=null){
		$this->db->select("t1.*,t2.member_id, t2.member_display, DATE_FORMAT(t1.create_date, '%d/%m/%Y %H:%i') as thaidate, , DATE_FORMAT(t1.edit_date, '%d/%m/%Y %H:%i') as update_thaidate, count(t3.post_id) as total_comment");
		$this->db->from('forum_topic t1'); 
		$this->db->join('member_db t2', 't1.member_id=t2.member_id', 'left');
		$this->db->join('forum_post t3', 't1.topic_id=t3.topic_id', 'left');
		//$this->db->where('t1.is_show',1);
		$this->db->group_by('t3.topic_id');
		$this->db->order_by('t1.create_date','DESC');
		if($limit!=null && $start!=null){
			$this->db->limit($limit,$start);
		}else if($limit!=null && $start==null){
			$this->db->limit($limit);
		} 
		$query = $this->db->get();
		return  $query->result();
	}

	public function getTopicDetail($topic_id){
		$this->db->select("t1.*, t2.member_display, DATE_FORMAT(t1.create_date, '%d %M %Y %H:%i') as thaidate", false);
		$this->db->from('forum_topic t1'); 
		$this->db->join('member_db t2', 't1.member_id=t2.member_id', 'left');
		$this->db->where('t1.topic_id',$topic_id);
		//$this->db->where('t1.is_show',1);
		$query = $this->db->get();
		return  $query->result();
	}

	public function getCommentDetail($topic_id){
		$rs = array();
		$this->db->select("*, DATE_FORMAT(t1.create_date, '%d %M %Y %H:%i') as thaidate", false);
		$this->db->from('forum_post t1'); 
		$this->db->join('member_db t2', 't1.member_id=t2.member_id', 'left');
		$this->db->where('t1.topic_id', $topic_id);
		$this->db->where('t1.parent_id', 0);
		$this->db->where('t1.is_show', 1);
		$this->db->order_by('create_date', 'ASC');
		$query =$this->db->get();
		
		foreach($query->result_array() as $row){
			$subRs = array();
			$this->db->select("t1.post_id, t1.post_detail, t2.member_id, t2.member_display, DATE_FORMAT(t1.create_date, '%d %M %Y %H:%i') as thaidate", false);
			$this->db->from('forum_post t1'); 
			$this->db->join('member_db t2', 't1.member_id=t2.member_id', 'left');
			$this->db->where('t1.parent_id', $row['post_id']);
			$this->db->where('t1.is_show', 1);
			$this->db->order_by('create_date', 'ASC');
			$subQuery =$this->db->get();
		  	foreach($subQuery->result_array() as $subRow){
		  		array_push($subRs,$subRow);
		  	}
		  	$mainMenu = array(
				"post_id" 		=> $row["post_id"],
				"post_detail" 	=> $row["post_detail"],
				"member_id"		=> $row["member_id"],
				"member_display"=> $row["member_display"],
				"thaidate"		=> $row["thaidate"],
	            "subComment"	=> $subRs
			);
		  	array_push($rs,$mainMenu);
		}
		return $rs; //json_encode($rs);
	}

	public function delCommentsRepost($post_id){

		$this->db->where('post_id',$post_id);
		$this->db->update('forum_post', array('is_show' => 0));

		$this->db->where('ref_id',$post_id);
		$this->db->update('forum_report', array('report_action' => 1));
		
		return $this->db->affected_rows(); 
	}

	public function getReportList(){
		$this->db->select("t1.*, t2.member_display, t3.topic_id , DATE_FORMAT(t1.report_date, '%d %M %Y %H:%i') as thaidate", false);
		$this->db->from('forum_report t1'); 
		$this->db->join('member_db t2', 't1.member_id=t2.member_id', 'left');
		$this->db->join('forum_post t3', 't1.ref_id=t3.post_id', 'left');
		$this->db->where('t1.report_action', 0);
		$this->db->order_by('t1.report_date', 'DESC');
		$query =$this->db->get();
		return $query->result();
	}
	
	public function deleteMember($member_id){
		$this->db->delete('member', array('member_id' => $member_id));  
	}

	public function getDocumentList(){
		$query = $this->db->order_by('doc_datetime DESC')->get('document');
		return $query->result();
	}
	public function insertDocument($ar){
		$this->db->insert('document',$ar);
		return $this->db->insert_id();	
	}
	public function updateDocument($ar){
		$this->db->where('doc_id',$ar['doc_id']);
		$this->db->update('document',$ar);
	}
	public function getDocumentDetail($doc_id){
		$query = $this->db->get_where('document', array('doc_id' => $doc_id));
		return $query->result();
	}
	public function delDocument($doc_id){
		$this->db->delete('document', array('doc_id' => $doc_id));  
	}
	public function getDocumentCat(){
		$query = $this->db->get('document_cat');
		return $query->result();
	}
	
	public function getEventsList(){
		$query = $this->db->order_by('event_createdate DESC')->get('cf_events');
		return $query->result();
	}
	public function insertEvent($ar){
		$this->db->insert('cf_events',$ar);
		return $this->db->insert_id();	
	}
	public function delEvent($event_id){
		$this->db->delete('cf_events', array('event_id' => $event_id));  
	}
	public function genEventID($event_id){
		$query = $this->db->get_where('cf_events', array('event_id' => $event_id));
		return $query->result();
	}	
	public function getEventDetail($event_id){
		$query = $this->db->get_where('cf_events', array('event_id' => $event_id));
		return $query->result();
	}
	public function updateEvent($ar){
		$this->db->where('event_id',$ar['event_id']);
		$this->db->update('cf_events',$ar);
	}
	
	
	public function getJobsList(){
		$query = $this->db->order_by('job_createdate DESC')->get('jobs');
		return $query->result();
	}
	public function getJobsCatList(){
		$query = $this->db->get('jobs_category');
		return $query->result();
	}
	public function getJobsProvinceList(){
		$query = $this->db->order_by('PROVINCE_NAME ASC')->get('province');
		return $query->result();
	}
	public function updateJobs($ar){
		$this->db->where('job_id',$ar['job_id']);
		$this->db->update('jobs',$ar);
	}
	public function genJobsID($job_id){
		$query = $this->db->get_where('jobs', array('job_id' => $job_id));
		return $query->result();
	}
	public function insertjobs($ar){
		$this->db->insert('jobs',$ar);
		return $this->db->insert_id();	
	}
	public function delJobs($job_id){
		$this->db->delete('jobs', array('job_id' => $job_id));  
	}
	public function getJobsDetail($job_id){
		$query = $this->db->get_where('jobs', array('job_id' => $job_id));
		return $query->result();
	}
	
	public function getPostList(){
		$query = $this->db->order_by('blog_createdate DESC')->get('blog');
		return $query->result();
	}
	
	public function getVdoList(){
		$query = $this->db->order_by('yt_datetime DESC')->get('vdo');
		return $query->result();	
	}
	public function deleteVDO($id){
		$this->db->delete('vdo', array('id' => $id));  
	}
	public function getVDODetail($id){
		$query = $this->db->get_where('vdo', array('id' => $id));
		return $query->result();
	}
	public function updateVDO($ar){
		$this->db->where('id',$ar['id']);
		$this->db->update('vdo',$ar);
		return $this->db->affected_rows(); 
	}
	public function insertVDO($ar){
		$query = $this->db->get_where('vdo', array('yt_id' => $ar['yt_id']));
		$rs = $query->result();
		if($rs==null){
			$this->db->insert('vdo',$ar);
			return $this->db->insert_id();	
		}
	}
	
	public function g_s_province(){
		$query = $this->db->order_by('province_name asc')->get('z_province');
		return $query->result();
	}
	
	public function getSourceList2(){
		$query = $this->db->select('source_id, location_id, location_name, location_uri, location_status')->order_by('source_id', 'ASC')->get('source');
		return $query->result();
	}
	
	public function getSourceList(){
		
		$rs = array();
		$query = $this->db->order_by('source_id', 'ASC')->get('source');
		foreach($query->result_array() as $row){
			$subRs = array();
			
			$sql="SELECT log_pm25, source_id, log_datetime FROM `map_pm` 
			WHERE `source_id` =".$row['source_id']." 
			limit 1 ";
			
			$subQuery = $this->db->query($sql);
			
			//$subQuery = $this->db->get_where('log_data_2561', array('source_id' => $row['source_id']), 1);
		  	foreach($subQuery->result_array() as $subRow){
		  		array_push($subRs,$subRow);
		  	}
		  	$mainMenu = array(
				"source_id" => $row["source_id"],
				"location_id" => $row["location_id"],
				"location_name" => $row["location_name"],
				"location_lat" => $row["location_lat"],
				"location_lon" => $row["location_lon"],
				"location_pv" => $row["province_name"],
				"is_cnx" => $row["is_cnx"],
	            "location_status"=> $row["location_status"],
	            "status"=> $subRs
			);
		  	array_push($rs,$mainMenu);
		}
		return $rs; //json_encode($rs);
		
	}
	public function getSourceDetail($source_id){
		$query = $this->db->get_where('source', array('source_id' => $source_id));
		return $query->result();
	}
	public function updateSource($ar){
		$query = $this->db->get_where('source', array('source_id' => $ar['source_id']));
		if($query->result()){
			$this->db->where('source_id',$ar['source_id']);
			$this->db->update('source',$ar);
			return $this->db->affected_rows(); 
		}else{
			$this->db->insert('source',$ar);
			return $this->db->insert_id();	
		}
	}
	
	public function getAirList(){
		$query = $this->db->order_by('air_id ASC')->get('airinfo');
		return $query->result();	
	}
	public function getAirDetail($air_id){
		$query = $this->db->get_where('airinfo', array('air_id' => $air_id));
		return $query->result();
	}
	public function updateAir($ar){
		$this->db->where('air_id',$ar['air_id']);
		$this->db->update('airinfo',$ar);
		return $this->db->affected_rows(); 
	}
	
	public function getSnapshotDefault(){
		$query = $this->db->get_where('config', array('type' => 'snapshot'));
		return $query->result();
	}
	
	public function getForcast($cast_date){
		$query = $this->db->get_where('forcast', array('cast_date' => $cast_date));
		return $query->result();
	}
	public function updateForcast($ar){
		$query = $this->db->get_where('forcast', array('cast_date' => $ar["cast_date"]));
		$rs= $query->result();
		if($rs!=null){
			$this->db->where('cast_date',$ar['cast_date']);
			$this->db->update('forcast',$ar);
			return $this->db->affected_rows(); 
		}else{
			$this->db->insert('forcast',$ar);
			return $this->db->insert_id();	
		}
	}
	
	public function getForcastDB($cast_date){
		$query = $this->db->get_where('forcast_db', array('cast_date' => $cast_date));
		return $query->result();
	}
	public function updateForcastDB($ar){
		$query = $this->db->get_where('forcast_db', array('cast_date' => $ar["cast_date"]));
		$rs= $query->result();
		if($rs!=null){
			$this->db->where('cast_date',$ar['cast_date']);
			$this->db->update('forcast_db',$ar);
			return $this->db->affected_rows(); 
		}else{
			$this->db->insert('forcast_db',$ar);
			return $this->db->insert_id();	
		}
	}
	
	/*
	public function getVdoList(){
		$query = $this->db->order_by('yt_datetime DESC')->get('vdo');
		return $query->result();	
	}
	public function deleteVDO($id){
		$this->db->delete('vdo', array('id' => $id));  
	}
	public function getVDODetail($id){
		$query = $this->db->get_where('vdo', array('id' => $id));
		return $query->result();
	}
	public function updateVDO($ar){
		$this->db->where('id',$ar['id']);
		$this->db->update('vdo',$ar);
		return $this->db->affected_rows(); 
	}
	public function insertVDO($ar){
		$query = $this->db->get_where('vdo', array('yt_id' => $ar['yt_id']));
		$rs = $query->result();
		if($rs==null){
			$this->db->insert('vdo',$ar);
			return $this->db->insert_id();	
		}
	}
	
	*/
	
	public function getresearchList(){
		$query = $this->db->order_by('article_timestamp DESC')->get('od_article');
		return $query->result();	
	}
	
	public function deleteResearch($article_id){
		$this->db->delete('od_article', array('article_id' => $article_id)); 
	}
	
	public function getResearchDetail($article_id){
		$query = $this->db->get_where('od_article', array('article_id' => $article_id));
		return $query->result();
	}
	
	public function updateResearch($ar){
		$this->db->where('article_id',$ar['article_id']);
		$this->db->update('od_article',$ar);
		return $this->db->affected_rows();
	}
	
	public function insertResearch($ar){
		$this->db->insert('od_article',$ar);
		return $this->db->insert_id();	
	}
	
	
	public function getLastDustboyValue($table, $id, $start_date=null, $end_date=null){
		$query = $this->db->order_by('log_datetime DESC')->limit(100)->get_where($table, array('source_id' => $id));
		return $query->result();
	}
	
	public function getLastDustboyValueExcel($table, $id, $start_date=null, $end_date=null){
		$query = $this->db->order_by('log_datetime DESC')->get_where($table, array('source_id' => $id));
		return $query->result();
	}
	
	public function getLastDustboyValue2($table, $id, $start_date=null, $end_date=null){
		
		$this->db->select("*");
        $this->db->from($table);
		$this->db->where('source_id',$id);
		$this->db->where('log_datetime >=', $start_date.' 00:00:00');
		$this->db->where('log_datetime <=', $end_date.' 23:59:59');
		$query = $this->db->get(); 
		return $query->result();
		//$query = $this->db->order_by('log_datetime DESC')->limit(100)->get_where($table, array('source_id' => $id));
		//return $query->result();
	}
	
	public function getPaperList(){
		$query = $this->db->order_by('createdate DESC')->get_where('r_paper', array('deleted' =>0));
		return $query->result();
	}
	public function deletePaper($paper_id){
		$this->db->where('paper_id',$ar['paper_id']);
		$this->db->update('r_paper',array('deleted'=>1));
		return $this->db->affected_rows();
	}
	public function getPaperDetail($paper_id){
		$query = $this->db->get_where('r_paper', array('paper_id' => $paper_id));
		return $query->result();
	}
	public function updatePaper($ar){
		$this->db->where('paper_id',$ar['paper_id']);
		$this->db->update('r_paper',$ar);
		return $this->db->affected_rows();
	}
	public function insertPaper($ar){
		$this->db->insert('r_paper',$ar);
		return $this->db->insert_id();	
	}
	
	public function getDBLists(){
		$query = $this->db->select('source_id,location_id,location_name')->order_by('source_id ASC')->get('source');
		return $query->result();
	}
	public function getFixedList(){
		$this->db->select('t1.*,t2.location_name,t2.location_id');
		$this->db->from('r_fixed t1'); 
		$this->db->join('source t2', 't1.fixed_source_id=t2.source_id', 'left');
		$this->db->order_by('createdate desc');
		$query = $this->db->get();
		return  $query->result();
	}
	public function updateFixed($ar){
		$this->db->where('fixed_id',$ar['fixed_id']);
		$this->db->update('r_fixed',$ar);
		return $this->db->affected_rows();
	}
	public function insertFixed($ar){
		$this->db->insert('r_fixed',$ar);
		return $this->db->insert_id();	
	}
	public function getFixedDetail($fixed_id){
		$query = $this->db->get_where('r_fixed', array('fixed_id' => $fixed_id));
		return $query->result();
	}
	
	public function getLogbookList(){
		$this->db->select('t1.*,t2.location_name,t2.location_id,t2.source_id,t2.db_model');
		$this->db->from('r_logbook t1'); 
		$this->db->join('source t2', 't1.log_webid=t2.source_id', 'left');
		$query = $this->db->get();
		return  $query->result();
	}
	public function insertLogbook($ar){
		$this->db->insert('r_logbook',$ar);
		return $this->db->insert_id();	
	}
	public function updateLogBook($ar){
		$this->db->where('log_id',$ar['log_id']);
		$this->db->update('r_logbook',$ar);
		return $this->db->affected_rows();
	}
	public function getLogBookDetail($log_id){
		$query = $this->db->get_where('r_logbook', array('log_id' => $log_id));
		return $query->result();
	}
	public function deleteLogBook($log_id){
		$this->db->delete('r_logbook', array('log_id' => $log_id)); 
	}

	public function getMaintainRequest(){
		$query = $this->db->get_where('maintain_request', array('deleted' => 0, 'request_status' => 1));
		return $query->result();
	}
	public function delMaintainRequest($id){
		$this->db->where('request_id',$id);
		$this->db->update('maintain_request', array('deleted'=>1));
		return $this->db->affected_rows();
	}
	
	public function getMaintainMember(){
		$query = $this->db->get('maintain_user');
		return $query->result();
	}
	public function getMaintainMemberDetail($username){
		$query = $this->db->get_where('maintain_user', array('username'=>$username));
		return $query->result();
	}
	public function getMaintainMemberAdd($request_key){
		$query = $this->db->get_where('maintain_request', array('deleted' => 0, 'request_key' => $request_key));
		return $query->result();
	}
	public function getMaintainMemberAdd2($username){
		$query = $this->db->get_where('maintain_user', array('username'=>$username));
		$rs= $query->result();
		$query = $this->db->get_where('maintain_request', array('deleted' => 0, 'request_id' => $rs[0]->user_request_id));
		return $query->result();
	}
	public function addMaintainMember($ar){
		$this->db->insert('maintain_user',$ar);
		
		$this->db->where('request_id',$ar['user_request_id']);
		$this->db->update('maintain_request', array('request_active'=>1));
		return $this->db->affected_rows();
	}
	
	public function updateMaintainMember($ar){
		$this->db->where('username',$ar['username']);
		$this->db->update('maintain_user', array('user_engines'=> $ar['user_engines']));
		return $this->db->affected_rows();
	}
	
	public function getMaintainEngine($engine_username){
		$query = $this->db->get_where('maintain_engine', array('deleted' => 0, 'engine_username' => $engine_username));
		return $query->result();
	}
	
	public function addEngine($engine_username){
		$ar = array('engine_username'=>$engine_username);
		$this->db->insert('maintain_engine',$ar);
	}
	public function delEngine($engine_id){
		$this->db->where('engine_id',$engine_id);
		$this->db->update('maintain_engine', array('deleted'=>1));
		return $this->db->affected_rows();
	}
	
	public function updateMaintainEngine($ar){
		$this->db->where('engine_id',$ar['engine_id']);
		$this->db->update('maintain_engine', $ar);
		return $this->db->affected_rows();
	}
	
	public function getMaintainByKey($request_key){
		$query = $this->db->get_where('maintain_request', array('deleted' => 0, 'request_key' => $request_key));
		$rs = $query->result();
		
		$query = $this->db->get_where('maintain_user', array('user_request_id' => $rs[0]->request_id));
		return $query->result();
	}
	
	public function getMaintainSetup(){
		$query = $this->db->order_by('createdate desc')->get('maintain_setup');
		return $query->result();
	}
	
	public function getMaintainSetupDetail($setup_id){
		$query = $this->db->get_where('maintain_setup', array( 'setup_id' => $setup_id));
		return $query->result();
	}
	
	public function getExportDB($table, $id, $start_date=null, $end_date=null){
		
		$sql = "SELECT  round(avg(log_pm10),2) as log_pm10, round(avg(log_pm25),2) as log_pm25, round(avg(temp),2) as avg_temp, round(avg(humid),2) as avg_humid, DATE_FORMAT(log_datetime,'%Y-%m-%d %H:00:00') as log_datetime FROM (
			SELECT * FROM ".$table." 
			WHERE source_id =".$id." AND
			log_datetime 
			BETWEEN '".$start_date." 00:00:00'
			AND  '".$end_date." 23:59:59'
			) t
			group by DATE_FORMAT(t.log_datetime, '%Y-%m-%d %H') 
			ORDER BY log_datetime ASC";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
}


