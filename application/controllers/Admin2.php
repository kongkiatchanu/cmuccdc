<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin2 extends CI_Controller {
	
	function __construct() {
        parent::__construct();

       	$this->load->model('admin_model');
        $this->load->library('form_validation');

        $this->load->helper('security');
        /*check session*/
        if($this->uri->segment(2)!="login"){
        	if($this->session->userdata('admin_logged_in')==""){
         		redirect('admin2/login');
      	  	}
        }

    }
	
	public function export_excel(){
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=\"".basename("export-".date('Y-m-d').".xls")."\"");
		header("Pragma: no-cache");
		header("Expires: 0");
		$rsList = json_decode(file_get_contents('https://www-old.cmuccdc.org/api2/dustboy/region'));
		
		?>
		<table>
			<thead>
				<tr>
					<td>ไอดี</td>
					<td>จังหวัด</td>
					<td>ชื่อจุดติดตั้ง(ไทย)</td>
					<td>ชื่อจุดติดตั้ง(อังกฤษ)</td>
					<td>ละติจูต</td>
					<td>ลองติจูต</td>
				</tr>
			</thead>
			<tbody>
				<?php $i=0;foreach($rsList as $zone){?>
				<?php foreach($zone->provinces as $province){?>
				<?php if($province){?>
				
				<?php foreach($province->stations as $station){$i++;?>
					<tr>
						<td><?=$station->source_id?></td>
						<td><?=$province->province_name_th?></td>
						<td><?=$station->location_name?></td>
						<td><?=$station->location_name_en?></td>
						<td><?=$station->location_lat?></td>
						<td><?=$station->location_lon?></td>
					</tr>
				<?php }?>
				
				<?php }?>
				<?php }?>
				<?php }?>
			</tbody>
		</table>
		
		<?php
	}
	
	public function index(){	
		
		$data = array(
			"page" 		=> 'index',
			"pagesub" 	=> 'index',
			"pageview"	=> 'index',
			'rsInbox'	=> $this->admin_model->getNewInbox(),
			'rsInboxAll'=> $this->admin_model->getInbox()
		);

		$this->load->view('admin2/template-main',$data);

	}
	public function login(){
		// if($this->input->post()){
		// 	echo '<pre>';
		// 	print_r($this->input->post());
		// 	echo '</pre>';
		// 	exit();
		// }
		$this->form_validation->set_rules('username', 'username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'password', 'trim|required|xss_clean|callback_check_database');

		if($this->form_validation->run() == FALSE)
		{
			$this->load->view("admin2/login");
		}else{
			redirect('admin2/index');
		}
		
	}
	
	public function check_database($password){
		$username = $this->input->post('username');
		$result = $this->admin_model->login($username, md5(sha1($password)));
		if($result)
		{
			$sess_array = array();
			foreach($result as $row)
			{
				$sess_array = array(
					'username' => $row->username,
					'display' => $row->displayname
				);
				$this->session->set_userdata('admin_logged_in', $sess_array);
			}
			return TRUE;
		}else{
			$message='<div class="alert alert-danger"><strong>คำเตือน !</strong> ชื่อผู้ใช้และรหัสผ่านไม่ถูกต้อง</div>';
			$this->form_validation->set_message('check_database', $message);
			return false;
		}
	}

	public function logout() {
		$this->session->unset_userdata('admin_logged_in');
		redirect('admin2/login');
		exit();
    }
	
	public function profile(){	
		if($this->input->post()){
			$ar = array(
		    	'username' => $this->input->post('username'),
		    	'password' => md5(sha1($this->input->post('o_password')))
		    );
		
			$ck = $this->admin_model->checkAdmin($ar);
		
			if($ck!=null){
				$ar = array(
					'username' => $this->input->post('username'),
					'password' => md5(sha1($this->input->post('n_password'))),
					'displayname' => $this->input->post('displayname')
				);
				$rs = $this->admin_model->updateUser($ar); 
				$sess_array = array(
					'username' => $this->input->post('username'),
					'display' => $this->input->post('displayname')
				);
				$this->session->set_userdata('admin_logged_in', $sess_array);
				redirect('admin2/profile/success');
			}else{
				redirect('admin2/profile/fail');
			}
		
		}

		$data = array(
			"pageview"	=> 'admin-profile',
			"page" 		=> 'config',
			"pagesub" 	=> 'profile',
			"pagename" 	=> 'เปลี่ยนรหัสผ่าน',

			"_user" 	=> $this->session->userdata('admin_logged_in'),
			'rsInbox'	=> $this->admin_model->getNewInbox(),
			'rsInboxAll'=> $this->admin_model->getInbox()

		);
		
		$this->load->view('admin2/template-main',$data);
	}
	
	public function web_contactus(){
		$load = 'admin-webcontact';
		if($this->input->post()){
			$ar = array(
				'site_id' =>1,
				'site_contactus' =>$this->input->post('site_contactus'),
				'site_email' =>$this->input->post('site_email')
			);
			$this->admin_model->updateWebinfo($ar);
			redirect('admin/web_contactus');
		}else{
			if($this->uri->segment(3)=="edit"){
	    		$load = "admin-webcontact-form";
	    	}
			$data = array(
				"pageview"	=> $load,
				"page" 		=> 'config',
				"pagesub" 	=> 'web_contactus',
				"pagename" 	=> 'หน้าติดต่อเรา',

				"rs" 		=> $this->admin_model->getWebinfo(1),
				'rsInbox'	=> $this->admin_model->getNewInbox(),
				'rsInboxAll'=> $this->admin_model->getInbox()
			);
			
			$this->load->view('admin/template_main',$data);
		}
	}
	
	public function web_aboutus(){
		$load = 'admin-webabout';
		if($this->input->post()){
			$ar = array(
				'site_id' =>1,
				'site_aboutus' =>$this->input->post('site_aboutus')
			);
			$this->admin_model->updateWebinfo($ar);
			redirect('admin/web_aboutus');
		}else{
			if($this->uri->segment(3)=="edit"){
	    		$load = "admin-webabout-form";
	    	}
			$data = array(
				"pageview"	=> $load,
				"page" 		=> 'config',
				"pagesub" 	=> 'web_aboutus',
				"pagename" 	=> 'หน้าเกี่ยวกับเรา',

				"rs" 		=> $this->admin_model->getWebinfo(1),
				'rsInbox'	=> $this->admin_model->getNewInbox(),
				'rsInboxAll'=> $this->admin_model->getInbox()
			);
			
			$this->load->view('admin/template_main',$data);
		}
	}
	
	public function web_info(){
		$load = 'admin-webinfo';
		if($this->input->post()){
			$ar = array(
				'site_id' =>1,
				'site_title' =>$this->input->post('site_title'),
				'site_keyword' =>$this->input->post('site_keyword'),
				'site_description' =>$this->input->post('site_description'),
				'site_picture' =>trim($this->input->post('h_image')),
			);
			$this->admin_model->updateWebinfo($ar);

			redirect('admin/web_info');
		}else{
			if($this->uri->segment(3)=="edit"){
	    		$load = "admin-webinfo-form";
	    	}
			$data = array(
				"pageview"	=> $load,
				"page" 		=> 'config',
				"pagesub" 	=> 'web_info',
				"pagename" 	=> 'กำหนดข้อมูลเว็บไซต์',

				"rs" 		=> $this->admin_model->getWebinfo(1),
				'rsInbox'	=> $this->admin_model->getNewInbox(),
				'rsInboxAll'=> $this->admin_model->getInbox()
			);
			
			$this->load->view('admin/template_main',$data);
		}
	}

	public function landingpage(){
		$load = 'admin-landing';
		if($this->input->post()){
			$ar = $this->input->post();
			
			$ar["intro_img"] = trim($ar['h_image']);

			unset($ar['h_image']);
			unset($ar['files']);
			if($this->input->post('intro_id')!=null){
				//update
				$ck=$this->admin_model->updateLandingPage($ar);
			}else{
				$ck=$this->admin_model->insertLandingPage($ar);
			}
			redirect('/admin/landingpage/');
		}else{
			$rs="";
			if($this->uri->segment(3)=="del"){
				$del = $this->admin_model->delLandingPage($this->uri->segment(4));
				redirect('/admin/landingpage/');
			}
			else if($this->uri->segment(3)=="add"){
				$load = "admin-landing-form";	
			}
			else if($this->uri->segment(3)=="edit"){
				$load = "admin-landing-form";
				$rs = $this->admin_model->getLandingPageDetail($this->uri->segment(4));
			}
			
			$data = array(
				"pageview"	=> $load,
				"page" 		=> 'config',
				"pagesub" 	=> 'landingpage',
				"pagename" 	=> 'Landing page / Popup',
				"rs" 		=> $rs,

				"rsList"	=> $this->admin_model->getLandingPageList(),
				'rsInbox'	=> $this->admin_model->getNewInbox(),
				'rsInboxAll'=> $this->admin_model->getInbox()
			);
			
			$this->load->view('admin/template_main',$data);
		}
	}
	
	public function ribbon(){
		$load = 'admin-ribbon';
		if($this->input->post()){
			$ar = $this->input->post();
			
			$ar["ribbon_img"] = trim($ar['h_image']);

			unset($ar['h_image']);
			if($this->input->post('ribbon_id')!=null){
				//update
				$ck=$this->admin_model->updateRibbon($ar);
			}else{
				$ck=$this->admin_model->insertRibbon($ar);
			}
			redirect('/admin/ribbon/');
		}else{
			$rs="";
			if($this->uri->segment(3)=="del"){
				$del = $this->admin_model->delRibbon($this->uri->segment(4));
				redirect('/admin/ribbon/');
			}
			else if($this->uri->segment(3)=="add"){
				$load = "admin-ribbon-form";	
			}
			else if($this->uri->segment(3)=="edit"){
				$load = "admin-ribbon-form";
				$rs = $this->admin_model->getRibbonDetail($this->uri->segment(4));
			}
			
			$data = array(
				"pageview"	=> $load,
				"page" 		=> 'config',
				"pagesub" 	=> 'ribbon',
				"pagename" 	=> 'ริบบิ้น',
				"rs" 		=> $rs,

				"rsList"	=> $this->admin_model->getRibbonList(),
				'rsInbox'	=> $this->admin_model->getNewInbox(),
				'rsInboxAll'=> $this->admin_model->getInbox()
			);
			
			$this->load->view('admin/template_main',$data);
		}
	}
	
	public function menu(){
		$load = "admin-menu";
		$rs="";
		if($this->input->post()){
			/*id post*/
			if($this->input->post('idpage')==null){
				$_id=0;
			}else{
				$_id = $this->input->post('idpage');
			}
    		if($this->input->post('idmenu')){

    			$ar = array(
		    		'idpage' => $_id,
		    		'menu_label' => $this->input->post('menu_label'),
		    		'menu_order' => $this->input->post('menu_order'),
		    		'menu_parent' => $this->input->post('menu_parent'),
		    		'menu_link' => $this->input->post('menu_link'),
		    		'idmenu' => $this->input->post('idmenu'),
		    	);
	    		$this->admin_model->updateMenu($ar); 

    		}else{

    			$ar = array(
		    		'idpage' => $_id,
		    		'menu_label' => $this->input->post('menu_label'),
		    		'menu_parent' => $this->input->post('menu_parent'),
		    		'menu_link' => $this->input->post('menu_link'),
		    		'menu_order' => $this->input->post('menu_order')
		    	);
	    		$this->admin_model->insertMenu($ar); 
    		}
    		redirect('admin/menu');
		}else{
	    	if($this->uri->segment(3)=="del"){
				$rs = $this->admin_model->getMenuItem($this->uri->segment(4)); 
				$this->admin_model->deleteMenu($this->uri->segment(4)); 
				redirect('admin/menu');
	    	}else if($this->uri->segment(3)=="edit"){
	    		$load = "admin-menu-form";
	    		$rs = $this->admin_model->getMenuItem($this->uri->segment(4)); 
	    	}else if($this->uri->segment(3)=="add"){
	    		$load = "admin-menu-form";
	    	}
	    	
			$data = array(
				"pageview"	=> $load,
				"page" 		=> 'config',
				"pagesub" 	=> 'menu',
				"pagename" 	=> 'จัดการเมนู',
				"rs"		=> $rs,

				"rs_menu"=> $this->admin_model->getMenuListItem(),
				"rs_menuf"=> $this->admin_model->getMenuListItemForm(),
				"rs_page"=> $this->admin_model->getPageList(),
				'rsInbox'	=> $this->admin_model->getNewInbox(),
				'rsInboxAll'=> $this->admin_model->getInbox()
			);
			
			$this->load->view('admin/template_main',$data);
		}
		 
	}
	
	public function contact(){
		
		$load = 'admin-contact';
		$rs ='';

		if($this->uri->segment(3)=="del"){
			$this->admin_model->deleteContact($this->uri->segment(4)); 
			redirect('admin2/contact');
	    }else if($this->uri->segment(3)=="view"){
			$rs = $this->admin_model->getContactDetail($this->uri->segment(4)); 
			$load = 'admin-contact-view';
	    }
		
		$data = array(
			"pageview"	=> $load,
			"page" 		=> 'contact',
			"pagesub" 	=> '',
			"pagename" 	=> 'ข้อความติดต่อ',
			"rsList" 	=> $this->admin_model->getContactList(),
			"rs" 		=> $rs,
			'rsInbox'	=> $this->admin_model->getNewInbox(),
			'rsInboxAll'=> $this->admin_model->getInbox()
		);
		
		$this->load->view('admin2/template-main',$data);
	}
	
	public function slide(){
		$load = 'admin-slide';
		$rs = '';
		if($this->input->post()!=null){
			
			$ar=$this->input->post();
			$ar['slide_path'] = trim($ar['h_image']);
			unset($ar['h_image']);

			if($this->input->post('slide_id')!=null){
				$ck = $this->admin_model->updateSlideImg($ar);
			}else{
				$ck = $this->admin_model->insertSlideImg($ar);
			}
			redirect('admin/slide');
		}else{
			if($this->uri->segment(3)=="del"){
				$rs = $this->admin_model->delSlideImg($this->uri->segment(4)); 
				redirect('admin/slide');
	    	}else if($this->uri->segment(3)=="edit"){
	    		$load = "admin-slide-form";
	    		$rs = $this->admin_model->getSlideImgDetail($this->uri->segment(4)); 
	    	}else if($this->uri->segment(3)=="add"){
	    		$load = "admin-slide-form";
	    	}
			
			$data = array(
				"pageview"	=> $load,
				"page" 		=> 'sinfo',
				"pagesub" 	=> 'slide',
				"pagename" 	=> 'จัดการสไลด์',
				"rsList" 	=> $this->admin_model->getSlideImgList(),
				"rs" 		=> $rs,
				'rsInbox'	=> $this->admin_model->getNewInbox(),
				'rsInboxAll'=> $this->admin_model->getInbox()
			);
		
			$this->load->view('admin2/template-main',$data);
		}
	}


	public function external(){
		$load = 'admin-external';
		$rs = '';
		if($this->input->post()!=null){
			$ar=$this->input->post();
			$ar['link_image'] = trim($ar['h_image']);
			unset($ar['h_image']);

			if($this->input->post('idlink')!=null){
				$ck = $this->admin_model->updateExternal($ar);
			}else{
				$ck = $this->admin_model->insertExternal($ar);
			}
			redirect('admin/external');
		}else{
			if($this->uri->segment(3)=="del"){
				$rs = $this->admin_model->delExternal($this->uri->segment(4)); 
				redirect('admin/external');
	    	}else if($this->uri->segment(3)=="edit"){
	    		$load = "admin-external-form";
	    		$rs = $this->admin_model->getExternalDetail($this->uri->segment(4)); 
	    	}else if($this->uri->segment(3)=="add"){
	    		$load = "admin-external-form";
	    	}
			
			$data = array(
				"pageview"	=> $load,
				"page" 		=> 'ads',
				"pagesub" 	=> 'external',
				"pagename" 	=> 'partner ccdc',

				"rsList" 	=> $this->admin_model->getExternalList(),
				"rs" 		=> $rs,
				'rsInbox'	=> $this->admin_model->getNewInbox(),
				'rsInboxAll'=> $this->admin_model->getInbox()
			);
		
			$this->load->view('admin/template_main',$data);
		}
	}
	
	public function external2(){
		$load = 'admin-external2';
		$rs = '';
		if($this->input->post()!=null){
			$ar=$this->input->post();
			$ar['link_image'] = trim($ar['h_image']);
			unset($ar['h_image']);

			if($this->input->post('idlink')!=null){
				$ck = $this->admin_model->updateExternal2($ar);
			}else{
				$ck = $this->admin_model->insertExternal2($ar);
			}
			redirect('admin/external2');
		}else{
			if($this->uri->segment(3)=="del"){
				$rs = $this->admin_model->delExternal2($this->uri->segment(4)); 
				redirect('admin/external2');
	    	}else if($this->uri->segment(3)=="edit"){
	    		$load = "admin-external2-form";
	    		$rs = $this->admin_model->getExternalDetail2($this->uri->segment(4)); 
	    	}else if($this->uri->segment(3)=="add"){
	    		$load = "admin-external2-form";
	    	}
			
			$data = array(
				"pageview"	=> $load,
				"page" 		=> 'ads',
				"pagesub" 	=> 'external2',
				"pagename" 	=> 'partner opendata',
				"rsList" 	=> $this->admin_model->getExternalList2(),
				"rs" 		=> $rs,
				'rsInbox'	=> $this->admin_model->getNewInbox(),
				'rsInboxAll'=> $this->admin_model->getInbox()
			);
		
			$this->load->view('admin/template_main',$data);
		}
	}

	public function category(){
    	$load = "admin-category";
		$rs="";

		if($this->input->post()){
			/*id post*/
    		if($this->input->post('id_category')){
    			$ar = array(
	    			'id_section' => $this->input->post('id_section'),
	    			'category_name' => $this->input->post('category_name'),
	    			'category_parent' => $this->input->post('category_parent'),
	    			'id_category' => $this->input->post('id_category')
	    		);

    			$this->admin_model->updateCategory($ar); 
    		}else{
    			$ar = array(
	    			'id_section' => $this->input->post('id_section'),
	    			'category_name' => $this->input->post('category_name'),
	    			'category_parent' => $this->input->post('category_parent'),
	    			'id_category' => $this->input->post('id_category')
	    		);

				$this->admin_model->insertCategory($ar); 
    		}
    		redirect('admin2/category');
		}else{
	    	if($this->uri->segment(3)==null){
	    		/*list*/
	    	}else if($this->uri->segment(3)=="del"){
				$rs = $this->admin_model->getCategoryRow($this->uri->segment(4));
				$this->admin_model->deleteCategory($this->uri->segment(4)); 
				redirect('admin/category');
	    	}else if($this->uri->segment(3)=="edit"){
	    		$load = "admin-category-form";
	    		$rs = $this->admin_model->getCategoryRow($this->uri->segment(4)); 
	    	}else if($this->uri->segment(3)=="add"){
	    		$load = "admin-category-form";
	    	}

			$data = array(
				"pageview"	=> $load,
				"page" 		=> 'content',
				"pagesub" 	=> 'category',
				"pagename" 	=> 'หมวดหมู่',
				"section" => $this->admin_model->getSection(),
				"category" => $this->admin_model->getCategory(),
				"rs" 		=> $rs,
				'rsInbox'	=> $this->admin_model->getNewInbox(),
				'rsInboxAll'=> $this->admin_model->getInbox()
			);
		
			$this->load->view('admin2/template-main',$data);
		}
    }
	
	public function section(){
    	$idSection=$this->uri->segment(3);/*getSectionIDFromURL*/
    	if($idSection!=null){
		
    		$load = "admin-section";
			$rs_page = $this->admin_model->getSectionByID($idSection);
			$pagename = $rs_page[0]->section_name;;
			$page = "section-".$idSection;
			$rs="";
			$_rsFile="";
			$content_list = $this->admin_model->getContentsList($idSection);/*listContentBySectionID*/
			
			if($this->input->post()){
				
				
				if($this->input->post('idcontent')){
				
					$ar = array(
		    			'content_title' => $this->input->post('content_title'),
		    			'content_short_description' => $this->input->post('content_short_description'),
		    			'content_full_description' => $this->input->post('content_full_description'),
		    			'content_thumbnail' => trim($this->input->post('h_image')),
						'content_hashtag'=> $this->input->post('content_hashtag'),
						'content_public'=> $this->input->post('content_public'),
		    			'id_category'=> $this->input->post('id_category'),
		    			'content_status'=> $this->input->post('content_status'),
						'idcontent'=> $this->input->post('idcontent')
		    		);
	    			$update = $this->admin_model->updateContents($ar); 
			
					if(@$_FILES["content_file"]!=null){
						for($i=0;$i<count($_FILES["content_file"]['tmp_name']);$i++) {
							if(!empty($_FILES["content_file"]["tmp_name"][$i])) {

								if ($_FILES["content_file"]["type"][$i] == "image/gif") {
									$ext = "gif";
								}elseif ($_FILES["content_file"]["type"][$i] == "image/pjpeg" || $_FILES["content_file"]["type"][$i] == "image/jpeg") {
									$ext = "jpg";
								}elseif ($_FILES["content_file"]["type"][$i] == "image/x-png"  || $_FILES["content_file"]["type"][$i] =="image/png") {
									$ext = "png";
								}elseif ($_FILES["content_file"]["type"][$i] == "application/pdf") {
									$ext = "pdf";
								}elseif ($_FILES["content_file"]["type"][$i] == "application/vnd.ms-excel" || $_FILES["content_file"]["type"][$i] =="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
									$ext = "xlsx";
								}elseif ($_FILES["content_file"]["type"][$i] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
									$ext = "docx";
								}		
								if(!empty($ext)) {
									$ints=date('YmdGis');
									$filenames =  $this->input->post('idcontent').'_'.$ints."_".$i.".".$ext;
									move_uploaded_file($_FILES["content_file"]["tmp_name"][$i],$_SERVER["DOCUMENT_ROOT"]."/uploads/docs/".$filenames); 
									chmod($_SERVER["DOCUMENT_ROOT"]."/uploads/docs/".$filenames, 0777);
										//insert database
									$ar_assets = array(
										'file_idcontent' => $this->input->post('idcontent'),
										'file_name' => $_FILES["content_file"]["name"][$i],
										'file_path' => $filenames,
										'file_type' => $ext,
										'file_time' => date('Y-m-d H:i:s')
									);
								
									$this->admin_model->insertFiles($ar_assets); 
										
								} else {		
									echo "<script>alert('ไฟล์รูปภาพไม่ถูกต้อง');</script>";  
									redirect('/admin2/section/1/edit/'.$this->input->post('idcontent'));
								}		
							}
						}
					}// if files
					
					
				}else{
				
					$ar = array(
		    			'content_title' => $this->input->post('content_title'),
		    			'content_short_description' => $this->input->post('content_short_description'),
		    			'content_full_description' => $this->input->post('content_full_description'),
		    			'content_thumbnail' => trim($this->input->post('h_image')),
						'content_created'=> date('Y-m-d H:i:s'),
						'content_public'=> $this->input->post('content_public'),	
		    			'content_hashtag'=> $this->input->post('content_hashtag'),
						'content_status'=> $this->input->post('content_status'),
						'content_author'=> 'admin',
		    			'id_category'=> $this->input->post('id_category')
		    			
		    		);
	    			$in_id = $this->admin_model->insertContents($ar); 

					if(@$_FILES["content_file"]!=null){
						for($i=0;$i<count($_FILES["content_file"]['tmp_name']);$i++) {
							if(!empty($_FILES["content_file"]["tmp_name"][$i])) {
								
								if ($_FILES["content_file"]["type"][$i] == "image/gif") {
									$ext = "gif";
								}elseif ($_FILES["content_file"]["type"][$i] == "image/pjpeg" || $_FILES["content_file"]["type"][$i] == "image/jpeg") {
									$ext = "jpg";
								}elseif ($_FILES["content_file"]["type"][$i] == "image/x-png"  || $_FILES["content_file"]["type"][$i] =="image/png") {
									$ext = "png";
								}elseif ($_FILES["content_file"]["type"][$i] == "application/pdf") {
									$ext = "pdf";
								}elseif ($_FILES["content_file"]["type"][$i] == "application/vnd.ms-excel" || $_FILES["content_file"]["type"][$i] =="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
									$ext = "xlsx";
								}elseif ($_FILES["content_file"]["type"][$i] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
									$ext = "docx";
								}		
								if(!empty($ext)) {
									$ints=date('YmdGis');
									$filenames =  $in_id.'_'.$ints."_".$i.".".$ext;
									move_uploaded_file($_FILES["content_file"]["tmp_name"][$i],$_SERVER["DOCUMENT_ROOT"]."/uploads/docs/".$filenames); 
									chmod($_SERVER["DOCUMENT_ROOT"]."/uploads/docs/".$filenames, 0777);
										//insert database
									$ar_assets = array(
										'file_idcontent' => $in_id,
										'file_name' => $_FILES["content_file"]["name"][$i],
										'file_path' => $filenames,
										'file_type' => $ext,
										'file_time' => date('Y-m-d H:i:s')
									);

									$this->admin_model->insertFiles($ar_assets); 
										
								} else {		
									echo "<script>alert('ไฟล์รูปภาพไม่ถูกต้อง');</script>";  
									redirect('/admin2/section/1/edit/'.$in_id);
								}		
							}
						}
					}// if files

				}

				redirect('admin2/section/'.$idSection);

			}else{

				if($this->uri->segment(4)==null){
		    		/*list*/
		    	}else if($this->uri->segment(4)=="del"){
					$rs = $this->admin_model->getContentRow($this->uri->segment(5)); 
					$this->admin_model->deleteContent($this->uri->segment(5)); 
					redirect('admin/section/'.$idSection);
		    	}else if($this->uri->segment(4)=="delfile"){
					$del = $this->admin_model->delQuotationFile($this->uri->segment(5),$this->uri->segment(6));
					if($del!=null){redirect('/admin/section/1/edit/'.$this->uri->segment(6));}
					
		    	}else if($this->uri->segment(4)=="edit"){
		    		$load = "admin-section-form";
		    		$rs = $this->admin_model->getContentRow($this->uri->segment(5)); 
		    		$_rsFile = $this->admin_model->getFileList($this->uri->segment(5)); 
		    	}else if($this->uri->segment(4)=="add"){
		    		$load = "admin-section-form";
		    	}
				
				$data = array(
					"pageview"	=> $load,
					"page" 		=> 'content',
					"pagesub" 	=> 'content',
					"pagename" 	=> 'ข่าวประชาสัมพันธ์',
					"section" 	=> $this->admin_model->getSection(),
					"idsection" => $idSection,
					"category" 	=> $this->admin_model->getCategory(),
					"clist"		=> $this->admin_model->getContentsList($idSection),
					"rs" 		=> $rs,
					"_rsFile" 	=> $_rsFile,
					'rsInbox'	=> $this->admin_model->getNewInbox(),
					'rsInboxAll'=> $this->admin_model->getInbox()
				);
			
				$this->load->view('admin2/template-main',$data);
			}
    	}else{
    		redirect('admin2/category');
    	}
    }

	public function gallery(){
		$load='admin-gallery';
		$rs="";
		$rsDetail="";
		
		
		if($this->input->post()!=null){
			$ar=$this->input->post();
			
			if($this->input->post('gallery_id')!=null){
				$ar['gallery_thumbnail'] = trim($ar['h_image']);
				
				unset($ar['h_image']);
				unset($ar['files']);
				
				
				$ck = $this->admin_model->updateGallery($ar);
				if($ck!=null){
					for($i=0;$i<count($_FILES["photos"]['tmp_name']);$i++) {
						

						$ints=date('YmdGis');
						if(!empty($_FILES["photos"]["tmp_name"][$i])) {
							if ($_FILES["photos"]["type"][$i] == "image/gif") {
								$ext = "gif";
							}elseif ($_FILES["photos"]["type"][$i] == "image/pjpeg" || $_FILES["photos"]["type"][$i] == "image/jpeg") {
								$ext = "jpg";
							}elseif ($_FILES["photos"]["type"][$i] == "image/x-png"  || $_FILES["photos"]["type"][$i] =="image/png") {
								$ext = "png";
							}		
							if(!empty($ext)) {
								$filenames =  'g_'.$ar['gallery_id'].'_'.$ints."_".$i.".".$ext;
								copy($_FILES["photos"]["tmp_name"][$i],$_SERVER["DOCUMENT_ROOT"]."/uploads/gallery/".$filenames);	
								//insert database
								$ar_assets = array(
									'gallery_id' => $this->input->post('gallery_id'),
									'gallery_filename' => $filenames,
									'gallery_size' => $_FILES["photos"]["size"][$i],
									'gallery_create' => date('Y-m-d H:i:s')
								);
								
								$this->admin_model->insertGalleryImgDetail($ar_assets); 
								
							} else {		
								echo "<script>alert('ไฟล์รูปภาพไม่ถูกต้อง');</script>";  
								redirect('admin/gallery/'.$this->input->post('gallery_id'));
							}
						}
	
					}
				}
			}else{
				//insert
				$ar['gallery_thumbnail'] = trim($ar['h_image']);
				$ar['gallery_author'] = 'admin';
				
				unset($ar['h_image']);
				unset($ar['files']);
				
				$ck = $this->admin_model->insertGallery($ar);
			}
			redirect('admin/gallery');
		}else{
			if($this->uri->segment(3)=="del"){
				$rs = $this->admin_model->delGallery($this->uri->segment(4)); 
				redirect('admin/gallery');
	    	}else if($this->uri->segment(3)=="edit"){
	    		$load = "admin-gallery-form-edit";
	    		$rs = $this->admin_model->getGalleryDetail($this->uri->segment(4)); 
	    		$rsDetail = $this->admin_model->getGalleryImgList($this->uri->segment(4)); 
	    	}else if($this->uri->segment(3)=="add"){
	    		$load = "admin-gallery-form";
	    	}

			
			$data = array(
				"pageview"	=> $load,
				"page" 		=> 'gallery',
				"pagesub" 	=> '',
				"pagename" 	=> 'ภาพกิจกรรม',
				"rsList" 	=> $this->admin_model->getGallery(),
				"rs" 		=> $rs,
				"rsDetail" 	=> $rsDetail,
				'rsInbox'	=> $this->admin_model->getNewInbox(),
				'rsInboxAll'=> $this->admin_model->getInbox()
			);
		
			$this->load->view('admin/template_main',$data);
		}
	}
	
	public function page(){
		$load='admin-page';
		$rs="";
		$_rsFile="";
		if($this->input->post()!=null){
			$ar=$this->input->post();
			unset($ar['files']);
			if($this->input->post('idpage')!=null){
				$ar = array(
		    		'page_title' => $this->input->post('page_title'),
		    		'page_description' => $this->input->post('page_description'),
		    		'page_create' => $this->input->post('page_create'),
		    		'page_rewrite' => $this->input->post('page_rewrite'),
		    		'idpage' => $this->input->post('idpage')
		    	);
					
				$up = $this->admin_model->updatePage($ar);
				
				if(@$_FILES["content_file"]!=null){
						for($i=0;$i<count($_FILES["content_file"]['tmp_name']);$i++) {
							if(!empty($_FILES["content_file"]["tmp_name"][$i])) {

								if ($_FILES["content_file"]["type"][$i] == "image/gif") {
									$ext = "gif";
								}elseif ($_FILES["content_file"]["type"][$i] == "image/pjpeg" || $_FILES["content_file"]["type"][$i] == "image/jpeg") {
									$ext = "jpg";
								}elseif ($_FILES["content_file"]["type"][$i] == "image/x-png"  || $_FILES["content_file"]["type"][$i] =="image/png") {
									$ext = "png";
								}elseif ($_FILES["content_file"]["type"][$i] == "application/pdf") {
									$ext = "pdf";
								}elseif ($_FILES["content_file"]["type"][$i] == "application/vnd.ms-excel" || $_FILES["content_file"]["type"][$i] =="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
									$ext = "xlsx";
								}elseif ($_FILES["content_file"]["type"][$i] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
									$ext = "docx";
								}		
								if(!empty($ext)) {
									$ints=date('YmdGis');
									$filenames =  $this->input->post('idpage').'_'.$ints."_".$i.".".$ext;
									move_uploaded_file($_FILES["content_file"]["tmp_name"][$i],$_SERVER["DOCUMENT_ROOT"]."/uploads/docs/".$filenames); 
									chmod($_SERVER["DOCUMENT_ROOT"]."/uploads/docs/".$filenames, 0777);
										//insert database
									$ar_assets = array(
										'file_idpage' => $this->input->post('idpage'),
										'file_name' => $_FILES["content_file"]["name"][$i],
										'file_path' => $filenames,
										'file_type' => $ext,
										'file_time' => date('Y-m-d H:i:s')
									);
								
									$this->admin_model->insertPageFiles($ar_assets); 
										
								} else {		
									echo "<script>alert('ไฟล์รูปภาพไม่ถูกต้อง');</script>";  
									redirect('/admin2/page/edit/'.$this->input->post('idpage'));
								}		
							}
						}
					}// if files
					
			}else{
				$ar = array(
		    		'page_title' => $this->input->post('page_title'),
		    		'page_description' => $this->input->post('page_description'),
					'page_rewrite' => $this->input->post('page_rewrite'),
		    		'page_create' => $this->input->post('page_create')
		    	);
				$in_id = $this->admin_model->insertPage($ar);
				
				if(@$_FILES["content_file"]!=null){
						for($i=0;$i<count($_FILES["content_file"]['tmp_name']);$i++) {
							if(!empty($_FILES["content_file"]["tmp_name"][$i])) {
								
								if ($_FILES["content_file"]["type"][$i] == "image/gif") {
									$ext = "gif";
								}elseif ($_FILES["content_file"]["type"][$i] == "image/pjpeg" || $_FILES["content_file"]["type"][$i] == "image/jpeg") {
									$ext = "jpg";
								}elseif ($_FILES["content_file"]["type"][$i] == "image/x-png"  || $_FILES["content_file"]["type"][$i] =="image/png") {
									$ext = "png";
								}elseif ($_FILES["content_file"]["type"][$i] == "application/pdf") {
									$ext = "pdf";
								}elseif ($_FILES["content_file"]["type"][$i] == "application/vnd.ms-excel" || $_FILES["content_file"]["type"][$i] =="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
									$ext = "xlsx";
								}elseif ($_FILES["content_file"]["type"][$i] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
									$ext = "docx";
								}		
								if(!empty($ext)) {
									$ints=date('YmdGis');
									$filenames =  $in_id.'_'.$ints."_".$i.".".$ext;
									move_uploaded_file($_FILES["content_file"]["tmp_name"][$i],$_SERVER["DOCUMENT_ROOT"]."/uploads/docs/".$filenames); 
									chmod($_SERVER["DOCUMENT_ROOT"]."/uploads/docs/".$filenames, 0777);
										//insert database
									$ar_assets = array(
										'file_idpage' => $in_id,
										'file_name' => $_FILES["content_file"]["name"][$i],
										'file_path' => $filenames,
										'file_type' => $ext,
										'file_time' => date('Y-m-d H:i:s')
									);

									$this->admin_model->insertFiles($ar_assets); 
										
								} else {		
									echo "<script>alert('ไฟล์รูปภาพไม่ถูกต้อง');</script>";  
									redirect('/admin2/page/edit/'.$in_id);
								}		
							}
						}
					}// if files
			}
			redirect('admin2/page');
		}else{
			
			if($this->uri->segment(3)=="del"){
				$rs = $this->admin_model->deletePage($this->uri->segment(4)); 
				redirect('admin2/page');
	    	}else if($this->uri->segment(3)=="delfile"){
				$del = $this->admin_model->delPageQuotationFile($this->uri->segment(4),$this->uri->segment(5));
				if($del!=null){redirect('/admin2/page/edit/'.$this->uri->segment(5));}
					
		    }else if($this->uri->segment(3)=="edit"){
	    		$load = "admin-page-form";
	    		$rs = $this->admin_model->getPageDetail($this->uri->segment(4)); 
				$_rsFile = $this->admin_model->getPageFileList($this->uri->segment(4)); 
	    	}else if($this->uri->segment(3)=="add"){
	    		$load = "admin-page-form";
	    	}

			
			$data = array(
				"pageview"	=> $load,
				"page" 		=> 'sinfo',
				"pagesub" 	=> 'page',
				"pagename" 	=> 'จัดการหน้าแสดงผล',
				"rsList" 	=> $this->admin_model->getPageList(),
				"rs" 		=> $rs,
				"_rsFile" 	=> $_rsFile,
				'rsInbox'	=> $this->admin_model->getNewInbox(),
				'rsInboxAll'=> $this->admin_model->getInbox()
			);
		
			$this->load->view('admin2/template-main',$data);
		}
	}

	
	/*-----------------------------------------------------------------------------*/
	public function vdo(){
		if($this->input->post()!=null){
			$ar = $this->input->post();
			unset($ar['files']);
			if($ar['id']!=null){
				//update
				$rs = $this->admin_model->updateVDO($ar);
				if($rs!=null){
					echo "<script>alert('บันทึกข้อมูลเรียบร้อยแล้ว');window.location.href='".site_url()."admin2/vdo';</script>";  
					redirect('/admin2/vdo');
				}else{
					echo "<script>alert('เกิดข้อผิดพลาดกรุณาตรวจสอบข้อมูลอีกครั้ง');window.location.href='".site_url()."admin2/vdo';</script>"; 
					redirect('/admin2/vdo');					
				}
			}else{
				//insert
				$rs = $this->admin_model->insertVDO($ar);
				if($rs!=null){
					echo "<script>alert('บันทึกข้อมูลเรียบร้อยแล้ว');window.location.href='".site_url()."admin2/vdo';</script>";  
					redirect('/admin2/vdo');
				}else{
					echo "<script>alert('เกิดข้อผิดพลาดกรุณาตรวจสอบข้อมูลอีกครั้ง');window.location.href='".site_url()."admin2/vdo';</script>"; 					
				}
			}
		}else{
			$load = "admin-vdo";
			$rs="";
			if($this->uri->segment(3)=="del"){
				$rs = $this->admin_model->deleteVDO($this->uri->segment(4)); 
				redirect('admin2/vdo');
	    	}else if($this->uri->segment(3)=="edit"){
	    		$load = "admin-vdo-form";
	    		$rs = $this->admin_model->getVDODetail($this->uri->segment(4)); 
	    	}else if($this->uri->segment(3)=="add"){
	    		$load = "admin-vdo-form";
	    	}
			$data = array(
				"pageview"	=> $load,
				"page" 		=> 'sinfo',
				"pagesub" 	=> 'vdo',
				"pagename" 	=> 'จัดการวีดีโอจากยูทูป',
				"rsList" 	=> $this->admin_model->getVdoList(),
				"rs" 		=> $rs,
				'rsInbox'	=> $this->admin_model->getNewInbox(),
				'rsInboxAll'=> $this->admin_model->getInbox()
			);
		
			$this->load->view('admin2/template-main',$data);
		}
		
	}
	
	public function api(){
		$load = "admin-api";
		$data = array(
				"pageview"	=> $load,
				"page" 		=> 'config',
				"pagesub" 	=> 'api',
				"pagename" 	=> 'สร้างข้อมูล APIs',
				'rsInbox'	=> $this->admin_model->getNewInbox(),
				'rsInboxAll'=> $this->admin_model->getInbox()
			);
		
			$this->load->view('admin2/template-main',$data);
	}
	
	public function source(){
		set_time_limit(0);
		if($this->input->post()!=null){
			$ar = $this->input->post();
			if($ar['source_id']!=null){
				//update\is_numeric
				if(!is_numeric($ar['location_lat'])){
					unset($ar['location_lat']);
				}
				
				if(!is_numeric($ar['location_lon'])){
					unset($ar['location_lon']);
				}
				
				
				$rs = $this->admin_model->updateSource($ar);
				if($rs!=null){
					echo "<script>alert('บันทึกข้อมูลเรียบร้อยแล้ว');window.location.href='".site_url()."admin2/source/edit/".$ar['source_id']."';</script>";  
					//redirect('/admin2/source');
				}else{
					echo "<script>alert('เกิดข้อผิดพลาดกรุณาตรวจสอบข้อมูลอีกครั้ง');window.location.href='".site_url()."admin2/source/edit/".$ar['source_id']."';</script>"; 
					//redirect('/admin2/source');					
				}
			}
		}else{
			$load = "admin-source";
			$rsProvince = array();
			$rs="";
			if($this->uri->segment(4)=="del"){
				//$rs = $this->admin_model->deleteVDO($this->uri->segment(4)); 
				//redirect('admin/vdo');
	    	}else if($this->uri->segment(3)=="edit"){
	    		$load = "admin-source-form";
				$rsProvince = $this->admin_model->g_s_province();
	    		$rs = $this->admin_model->getSourceDetail($this->uri->segment(4)); 
	    	}else if($this->uri->segment(3)=="add"){
				$rsProvince = $this->admin_model->g_s_province();
	    		$load = "admin-source-form";
	    	}else if($this->uri->segment(3)=="gen"){
	    		$rs = $this->admin_model->getSourceList2();
				
				$filename = 'station.json';
				$formattedData = json_encode($rs);
				$handle = fopen('/home/dev2/public_html/uploads/json/'.$filename,'w+');
				fwrite($handle,$formattedData);
				fclose($handle);
				echo 'gen cache file '.$filename;
				echo '<br/><a href="/admin2/source/">exit</a>';
				exit;
	    	}
			$rsList = json_decode(file_get_contents('https://www.cmuccdc.org/uploads/json/station.json'));
			

			$data = array(
				"pageview"	=> $load,
				"page" 		=> 'source',
				"pagesub" 	=> '',
				"pagename" 	=> 'จุดตรวจวัด',
				"rsList" 	=> $rsList,
				"rs" 		=> $rs,
				"rsProvince"=> $rsProvince,
				'rsInbox'	=> $this->admin_model->getNewInbox(),
				'rsInboxAll'=> $this->admin_model->getInbox()
			);
		
			$this->load->view('admin2/template-main',$data);
		}
	}
	
	public function dbdatahr(){
		$rsList = array();
		if($this->input->get()!=null){
			$ar = $this->input->get();
			if($ar['tb']=="log_mini_2561"){
				$table='log_mini_2561';
			}else if($ar['tb']=="log_data_2562"){
				$table='log_data_2562';
			}else if($ar['tb']=="log_mini_2561_2562"){
				$table='log_mini_2561_2562';
			}else if($ar['tb']=="log_mini_2561_sep2021"){
				$table='log_mini_2561_sep2021';
			}else if($ar['tb']=="log_wplus"){
				$table='log_wplus';
			}
			
		
			$rsList = $this->admin_model->getExportDB($table,$ar['webid'],$ar['start_date'], $ar['end_date']);
			

			header("Content-type: application/vnd.ms-excel");
			// header('Content-type: application/csv'); //*** CSV ***//
			header("Content-Disposition: attachment; filename=dustboy_date.xls");
			?>
			<table id="table-test" class="table table-custom" style="width:100%">
            <thead>
                <tr class="table-row-header">
                    <td class="table-header">source id</td>
                    <td class="table-header">pm25</td>
                    <td class="table-header">pm10</td>
                    <td class="table-header">temp</td>
                    <td class="table-header">humid</td>
                    <td class="table-header">datetime</td>
                </tr>
            </thead>
            <tbody>
                <?php $i=0;foreach ($rsList as $value) {$i++;?>  
                    <tr class="table-row-detail">
                        <td class="table-detail text-center"><?=$ar['webid']?></td>
                        <td class="table-detail text-center"><?=$value->log_pm25?></td>
                        <td class="table-detail text-center"><?=$value->log_pm10?></td>
                        <td class="table-detail text-center"><?=$value->avg_temp?></td>
                        <td class="table-detail text-center"><?=$value->avg_humid?></td>
                        <td class="table-detail"><?=$value->log_datetime?></td>
                    </tr>
                <?php }?>
            </tbody>
        </table>
			<?php 
		}
		
		
	}
	
	public function dbdata(){
		set_time_limit(0);
		$rsList= array();
		if($this->input->get()!=null){
			$ar = $this->input->get();
			if($ar['tb']=="log_mini_2561"){
				$table='log_mini_2561';
			}else if($ar['tb']=="log_data_2562"){
				$table='log_data_2562';
			}else if($ar['tb']=="log_mini_2561_2562"){
				$table='log_mini_2561_2562';
			}else if($ar['tb']=="log_mini_2561_sep2021"){
				$table='log_mini_2561_sep2021';
			}else if($ar['tb']=="log_wplus"){
				$table='log_wplus';
			}
			
			if($ar['start_date']!='' && $ar['end_date']!=''){
				$rsList = $this->admin_model->getLastDustboyValue2($table,$ar['webid'],$ar['start_date'], $ar['end_date']);
			}else{
				$rsList = $this->admin_model->getLastDustboyValue($table,$ar['webid'],'', '');
			}
			
		}

		
		
			$load = "admin-dbdata";
			$data = array(
				"pageview"	=> $load,
				"page" 		=> 'dbdata',
				"pagesub" 	=> '',
				"pagename" 	=> 'ตรวจเช็คข้อมูล',
				"rsList" 	=> $rsList,
				'rsInbox'	=> $this->admin_model->getNewInbox(),
				'rsInboxAll'=> $this->admin_model->getInbox()
			);
		
			$this->load->view('admin2/template-main',$data);
		
	}
	
	public function export_dbdata_json(){
		set_time_limit(0);
		if($this->input->get()!=null){
			$ar = $this->input->get();
			if($ar['tb']=="log_mini_2561"){
				$table='log_mini_2561';
			}else if($ar['tb']=="log_data_2562"){
				$table='log_data_2562';
			}else if($ar['tb']=="log_mini_2561_2562"){
				$table='log_mini_2561_2562';
			}else if($ar['tb']=="log_mini_2561_sep2021"){
				$table='log_mini_2561_sep2021';
			}else if($ar['tb']=="log_wplus"){
				$table='log_wplus';
			}
			if($ar['start_date']!='' && $ar['end_date']!=''){
				$rsList = $this->admin_model->getLastDustboyValue2($table,$ar['webid'],$ar['start_date'], $ar['end_date']);
			}else{
				$rsList = $this->admin_model->getLastDustboyValueExcel($table,$ar['webid'],'', '');
			}
			
			
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($rsList);
			

		}
	}
	
	public function export_dbdata(){
		set_time_limit(0);
		if($this->input->get()!=null){
			$ar = $this->input->get();
			if($ar['tb']=="log_mini_2561"){
				$table='log_mini_2561';
			}else if($ar['tb']=="log_data_2562"){
				$table='log_data_2562';
			}else if($ar['tb']=="log_mini_2561_2562"){
				$table='log_mini_2561_2562';
			}else if($ar['tb']=="log_mini_2561_sep2021"){
				$table='log_mini_2561_sep2021';
			}else if($ar['tb']=="log_wplus"){
				$table='log_wplus';
			}
			if($ar['start_date']!='' && $ar['end_date']!=''){
				$rsList = $this->admin_model->getLastDustboyValue2($table,$ar['webid'],$ar['start_date'], $ar['end_date']);
			}else{
				$rsList = $this->admin_model->getLastDustboyValueExcel($table,$ar['webid'],'', '');
			}
			
		
			header("Content-type: application/vnd.ms-excel");
			// header('Content-type: application/csv'); //*** CSV ***//
			header("Content-Disposition: attachment; filename=dustboy_date.xls");
			?>
			<table id="table-test" class="table table-custom" style="width:100%">
            <thead>
                <tr class="table-row-header">
                    <td class="table-header">source id</td>
                    <td class="table-header">nickname</td>
                    <td class="table-header">pm25</td>
                    <td class="table-header">pm10</td>
                    <td class="table-header">temp</td>
                    <td class="table-header">humid</td>
                    <td class="table-header">datetime</td>
                    <td class="table-header">ip</td>
                </tr>
            </thead>
            <tbody>
                <?php $i=0;foreach ($rsList as $value) {$i++;?>  
                    <tr class="table-row-detail">
                        <td class="table-detail text-center"><?=$value->source_id?></td>
                        <td class="table-detail"><?=$value->nickname?></td>
                        <td class="table-detail text-center"><?=$value->log_pm25?></td>
                        <td class="table-detail text-center"><?=$value->log_pm10?></td>
                        <td class="table-detail text-center"><?=$value->temp?></td>
                        <td class="table-detail text-center"><?=$value->humid?></td>
                        <td class="table-detail"><?=$value->log_datetime?></td>
                        <td class="table-detail"><?=$value->source_ip?></td>
                    </tr>
                <?php }?>
            </tbody>
        </table>
			<?php 
			exit;
			/*
			$load = "admin-dbdata-export";
			$data = array(
				"rsList" 	=> $rsList
			);
			$this->load->view('admin2/'.$load,$data);*/
		}
	}
	
	
	public function airdetail(){
		if($this->input->post()!=null){
			$ar = $this->input->post();
			if($ar['air_id']!=null){
				//update
				$rs = $this->admin_model->updateAir($ar);
				if($rs!=null){
					echo "<script>alert('บันทึกข้อมูลเรียบร้อยแล้ว');window.location.href='".site_url()."admin/airdetail';</script>";  
					redirect('/admin/airdetail');
				}else{
					echo "<script>alert('เกิดข้อผิดพลาดกรุณาตรวจสอบข้อมูลอีกครั้ง');window.location.href='".site_url()."admin/airdetail';</script>"; 
					redirect('/admin/airdetail');					
				}
			}
		}else{
			$load = "admin-air";
			$rs="";
			if($this->uri->segment(3)=="del"){
				//$rs = $this->admin_model->deleteVDO($this->uri->segment(4)); 
				//redirect('admin/vdo');
	    	}else if($this->uri->segment(3)=="edit"){
	    		$load = "admin-air-form";
	    		$rs = $this->admin_model->getAirDetail($this->uri->segment(4)); 
	    	}else if($this->uri->segment(3)=="add"){
	    		$load = "admin-air-form";
	    	}
			$data = array(
				"pageview"	=> $load,
				"page" 		=> 'airdetail',
				"pagesub" 	=> '',
				"pagename" 	=> 'ดัชนีคุณภาพอากาศ',
				"rsList" 	=> $this->admin_model->getAirList(),
				"rs" 		=> $rs,
				'rsInbox'	=> $this->admin_model->getNewInbox(),
				'rsInboxAll'=> $this->admin_model->getInbox()
			);
		
			$this->load->view('admin/template_main',$data);
		}
	}
	
	
	public function member(){
		if($this->uri->segment(3)=="del"){
			$rs = $this->admin_model->deleteMember($this->uri->segment(4)); 
			echo "<script>alert('ลบข้อมูลผู้ใช้เรียบร้อยแล้ว');window.location.href='".site_url()."admin/member';</script>"; 
	    }
			
			$load='admin-member';
			$data = array(
				"pageview"	=> $load,
				"page" 		=> 'member',
				"pagesub" 	=> '',
				"pagename" 	=> 'รายชื่อเจ้าหน้าที่',
				//"rs" 		=> $rs,
				"rsList"	=> $this->admin_model->getMemberList(),
				'rsInbox'	=> $this->admin_model->getNewInbox(),
				'rsInboxAll'=> $this->admin_model->getInbox()
			);
			
			$this->load->view('admin/template_main',$data);
	}
	
	public function snapshot(){
		if($this->input->post()!=null){
			
		}else{
			$data = array(
				"pageview"	=>  'admin-snapshot',
				"page" 		=> 'snapshot',
				"pagesub" 	=> '',
				"pagename" 	=> 'Snapshot',
				"rsSnapshot"=> $this->admin_model->getSnapshotDefault(),
				'rsInbox'	=> $this->admin_model->getNewInbox(),
				'rsInboxAll'=> $this->admin_model->getInbox()
			);
		
			$this->load->view('admin/template_main',$data);
		}
	}
	
	public function forcast(){
		if($this->input->post()!=null){
			$ar = $this->input->post();
			if($ar['cast_date']!=null){
				$ar['cast_bg'] = trim($this->input->post('h_image'));
				unset($ar['files']);
				unset($ar['h_image']);
				$update = $this->admin_model->updateForcast($ar);
				if($update!=null){
					redirect('admin/forcast');
				}
			}
		}else{
			$data = array(
				"pageview"	=>  'admin-forcast',
				"page" 		=> 'cast',
				"pagesub" 	=> 'forcast',
				"pagename" 	=> 'การรายงานผลรายวันของ กรมควบคุมมลพิษ',
				"rsForcast"=> $this->admin_model->getForcast(date('Y-m-d')),
				'rsInbox'	=> $this->admin_model->getNewInbox(),
				'rsInboxAll'=> $this->admin_model->getInbox()
			);
		
			$this->load->view('admin/template_main',$data);
		}
	}
	
	public function forcastdustboy(){
		if($this->input->post()!=null){
			$ar = $this->input->post();
			if($ar['cast_date']!=null){
				$ar['cast_bg'] = trim($this->input->post('h_image'));
				unset($ar['files']);
				unset($ar['h_image']);
				$update = $this->admin_model->updateForcastDB($ar);
				if($update!=null){
					redirect('admin/forcast');
				}
			}
		}else{
			$data = array(
				"pageview"	=>  'admin-forcast',
				"page" 		=> 'cast',
				"pagesub" 	=> 'forcast',
				"pagename" 	=> 'การรายงานผลรายวันของ Dustboy',
				"rsForcast"=> $this->admin_model->getForcastDB(date('Y-m-d')),
				'rsInbox'	=> $this->admin_model->getNewInbox(),
				'rsInboxAll'=> $this->admin_model->getInbox()
			);
		
			$this->load->view('admin/template_main',$data);
		}
	}
	
	public function research(){
		if($this->input->post()!=null){
			$ar = $this->input->post();
			unset($ar['files']);
			if($ar['article_id']!=null){
				//update
				$rs = $this->admin_model->updateResearch($ar);
				if($rs!=null){
					echo "<script>alert('บันทึกข้อมูลเรียบร้อยแล้ว');window.location.href='".site_url()."admin2/research';</script>";  
					redirect('/admin2/research');
				}else{
					echo "<script>alert('เกิดข้อผิดพลาดกรุณาตรวจสอบข้อมูลอีกครั้ง');window.location.href='".site_url()."admin2/research';</script>"; 
					redirect('/admin2/research');					
				}
			}else{
				//insert
				$rs = $this->admin_model->insertResearch($ar);
				if($rs!=null){
					echo "<script>alert('บันทึกข้อมูลเรียบร้อยแล้ว');window.location.href='".site_url()."admin2/research';</script>";  
					redirect('/admin2/research');
				}else{
					echo "<script>alert('เกิดข้อผิดพลาดกรุณาตรวจสอบข้อมูลอีกครั้ง');window.location.href='".site_url()."admin2/research';</script>"; 
					redirect('/admin2/research');					
				}
			}
		}else{
			$load = "admin-research";
			$rs="";
			if($this->uri->segment(3)=="del"){
				$rs = $this->admin_model->deleteResearch($this->uri->segment(4)); 
				redirect('admin/research');
	    	}else if($this->uri->segment(3)=="edit"){
	    		$load = "admin-research-form";
	    		$rs = $this->admin_model->getResearchDetail($this->uri->segment(4)); 
	    	}else if($this->uri->segment(3)=="add"){
	    		$load = "admin-research-form";
	    	}
			$data = array(
				"pageview"	=> $load,
				"page" 		=> 'sinfo',
				"pagesub" 	=> 'research',
				"pagename" 	=> 'บทความ / งานวิจัย',
				"rsList" 	=> $this->admin_model->getresearchList(),
				"rs" 		=> $rs,
				'rsInbox'	=> $this->admin_model->getNewInbox(),
				'rsInboxAll'=> $this->admin_model->getInbox()
			);
		
			$this->load->view('admin2/template-main',$data);
		}
	}
	
	public function paper(){
		if($this->input->post()!=null){
			$ar = $this->input->post();	
			if(@$_FILES["paper_file"]!=null){
				if(!empty($_FILES["paper_file"]["tmp_name"])) {
								
					if ($_FILES["paper_file"]["type"] == "application/pdf") {
						$ext = "pdf";
					}
					if(!empty($ext)) {
						$ints=date('YmdGis');
						$filenames =  'paper_'.$ints.".".$ext;
						move_uploaded_file($_FILES["paper_file"]["tmp_name"],$_SERVER["DOCUMENT_ROOT"]."/uploads/docs/".$filenames); 
						chmod($_SERVER["DOCUMENT_ROOT"]."/uploads/docs/".$filenames, 0777);
						//insert database		
						$ar['paper_file'] = $filenames;
					}else{		
						echo "<script>alert('ไฟล์ไม่ถูกต้อง');window.location.href='".site_url()."admin2/paper';</script>";  		
					}
				}
			}// if files
			if($ar['paper_id']!=null){
				//update
				$rs = $this->admin_model->updatePaper($ar);
			}else{
				$rs = $this->admin_model->insertPaper($ar);
			}
			echo "<script>alert('บันทึกข้อมูลแล้ว');window.location.href='".site_url()."admin2/paper';</script>";
		}else{
			$load = "admin-paper";
			$rs="";
			if($this->uri->segment(3)=="del"){
				$rs = $this->admin_model->deletePaper($this->uri->segment(4)); 
				redirect('admin/paper');
	    	}else if($this->uri->segment(3)=="edit"){
	    		$load = "admin-paper-form";
	    		$rs = $this->admin_model->getPaperDetail($this->uri->segment(4)); 
	    	}else if($this->uri->segment(3)=="add"){
	    		$load = "admin-paper-form";
	    	}
			$data = array(
				"pageview"	=> $load,
				"page" 		=> 'paper',
				"pagesub" 	=> '',
				"pagename" 	=> 'หนังสือขอความอนุเคราะห์',
				"rsList" 	=> $this->admin_model->getPaperList(),
				"rs" 		=> $rs,
				'rsInbox'	=> $this->admin_model->getNewInbox(),
				'rsInboxAll'=> $this->admin_model->getInbox()
			);
		
			$this->load->view('admin2/template-main',$data);
		}
	}
	
	
	public function fixed(){
		if($this->input->post()!=null){
			$ar = $this->input->post();
			
			if(@$_FILES["fixed_come_file"]!=null){
				if(!empty($_FILES["fixed_come_file"]["tmp_name"])) {
								
					if ($_FILES["fixed_come_file"]["type"] == "image/gif") {
						$ext = "gif";
					}elseif ($_FILES["fixed_come_file"]["type"] == "image/pjpeg" || $_FILES["fixed_come_file"]["type"] == "image/jpeg") {
						$ext = "jpg";
					}elseif ($_FILES["fixed_come_file"]["type"] == "image/x-png"  || $_FILES["fixed_come_file"]["type"] =="image/png") {
						$ext = "png";
					}elseif ($_FILES["fixed_come_file"]["type"] == "application/pdf") {
						$ext = "pdf";
					}
					if(!empty($ext)) {
						$ints=date('YmdGis');
						$filenames =  'fixed_'.$ints.".".$ext;
						move_uploaded_file($_FILES["fixed_come_file"]["tmp_name"],$_SERVER["DOCUMENT_ROOT"]."/uploads/docs/".$filenames); 
						chmod($_SERVER["DOCUMENT_ROOT"]."/uploads/docs/".$filenames, 0777);
						$ar['fixed_come_file'] = $filenames;
					}else{		
						echo "<script>alert('ไฟล์ไม่ถูกต้อง');window.location.href='".site_url()."admin2/fixed';</script>";  		
					}
				}
			}
			if(@$_FILES["fixed_get_file"]!=null){
				if(!empty($_FILES["fixed_get_file"]["tmp_name"])) {
								
					if ($_FILES["fixed_get_file"]["type"] == "image/gif") {
						$ext = "gif";
					}elseif ($_FILES["fixed_get_file"]["type"] == "image/pjpeg" || $_FILES["fixed_get_file"]["type"] == "image/jpeg") {
						$ext = "jpg";
					}elseif ($_FILES["fixed_get_file"]["type"] == "image/x-png"  || $_FILES["fixed_get_file"]["type"] =="image/png") {
						$ext = "png";
					}elseif ($_FILES["fixed_get_file"]["type"] == "application/pdf") {
						$ext = "pdf";
					}
					if(!empty($ext)) {
						$ints=date('YmdGis');
						$filenames =  'fixed_'.$ints.".".$ext;
						move_uploaded_file($_FILES["fixed_get_file"]["tmp_name"],$_SERVER["DOCUMENT_ROOT"]."/uploads/docs/".$filenames); 
						chmod($_SERVER["DOCUMENT_ROOT"]."/uploads/docs/".$filenames, 0777);
						$ar['fixed_get_file'] = $filenames;
					}else{		
						echo "<script>alert('ไฟล์ไม่ถูกต้อง');window.location.href='".site_url()."admin2/fixed';</script>";  		
					}
				}
			}
			if(@$_FILES["fixed_send_file"]!=null){
				if(!empty($_FILES["fixed_send_file"]["tmp_name"])) {
								
					if ($_FILES["fixed_send_file"]["type"] == "image/gif") {
						$ext = "gif";
					}elseif ($_FILES["fixed_send_file"]["type"] == "image/pjpeg" || $_FILES["fixed_send_file"]["type"] == "image/jpeg") {
						$ext = "jpg";
					}elseif ($_FILES["fixed_send_file"]["type"] == "image/x-png"  || $_FILES["fixed_send_file"]["type"] =="image/png") {
						$ext = "png";
					}elseif ($_FILES["fixed_send_file"]["type"] == "application/pdf") {
						$ext = "pdf";
					}
					if(!empty($ext)) {
						$ints=date('YmdGis');
						$filenames =  'fixed_'.$ints.".".$ext;
						move_uploaded_file($_FILES["fixed_send_file"]["tmp_name"],$_SERVER["DOCUMENT_ROOT"]."/uploads/docs/".$filenames); 
						chmod($_SERVER["DOCUMENT_ROOT"]."/uploads/docs/".$filenames, 0777);
						$ar['fixed_send_file'] = $filenames;
					}else{		
						echo "<script>alert('ไฟล์ไม่ถูกต้อง');window.location.href='".site_url()."admin2/fixed';</script>";  		
					}
				}
			}
			if(@$_FILES["fixed_repair_file"]!=null){
				if(!empty($_FILES["fixed_repair_file"]["tmp_name"])) {
								
					if ($_FILES["fixed_repair_file"]["type"] == "image/gif") {
						$ext = "gif";
					}elseif ($_FILES["fixed_repair_file"]["type"] == "image/pjpeg" || $_FILES["fixed_repair_file"]["type"] == "image/jpeg") {
						$ext = "jpg";
					}elseif ($_FILES["fixed_repair_file"]["type"] == "image/x-png"  || $_FILES["fixed_repair_file"]["type"] =="image/png") {
						$ext = "png";
					}elseif ($_FILES["fixed_repair_file"]["type"] == "application/pdf") {
						$ext = "pdf";
					}
					if(!empty($ext)) {
						$ints=date('YmdGis');
						$filenames =  'fixed_'.$ints.".".$ext;
						move_uploaded_file($_FILES["fixed_repair_file"]["tmp_name"],$_SERVER["DOCUMENT_ROOT"]."/uploads/docs/".$filenames); 
						chmod($_SERVER["DOCUMENT_ROOT"]."/uploads/docs/".$filenames, 0777);
						$ar['fixed_repair_file'] = $filenames;
					}else{		
						echo "<script>alert('ไฟล์ไม่ถูกต้อง');window.location.href='".site_url()."admin2/fixed';</script>";  		
					}
				}
			}
			if(@$_FILES["fixed_public_file"]!=null){
				if(!empty($_FILES["fixed_public_file"]["tmp_name"])) {
								
					if ($_FILES["fixed_public_file"]["type"] == "image/gif") {
						$ext = "gif";
					}elseif ($_FILES["fixed_public_file"]["type"] == "image/pjpeg" || $_FILES["fixed_public_file"]["type"] == "image/jpeg") {
						$ext = "jpg";
					}elseif ($_FILES["fixed_public_file"]["type"] == "image/x-png"  || $_FILES["fixed_public_file"]["type"] =="image/png") {
						$ext = "png";
					}elseif ($_FILES["fixed_public_file"]["type"] == "application/pdf") {
						$ext = "pdf";
					}
					if(!empty($ext)) {
						$ints=date('YmdGis');
						$filenames =  'fixed_'.$ints.".".$ext;
						move_uploaded_file($_FILES["fixed_public_file"]["tmp_name"],$_SERVER["DOCUMENT_ROOT"]."/uploads/docs/".$filenames); 
						chmod($_SERVER["DOCUMENT_ROOT"]."/uploads/docs/".$filenames, 0777);
						$ar['fixed_public_file'] = $filenames;
					}else{		
						echo "<script>alert('ไฟล์ไม่ถูกต้อง');window.location.href='".site_url()."admin2/fixed';</script>";  		
					}
				}
			}
			if($ar['fixed_id']!=null){
				//update
				$rs = $this->admin_model->updateFixed($ar);
			}else{
				$rs = $this->admin_model->insertFixed($ar);
			}
			echo "<script>alert('บันทึกข้อมูลแล้ว');window.location.href='".site_url()."admin2/fixed';</script>";
		}else{
			$load = "admin-fixed";
			$rs="";
			if($this->uri->segment(3)=="del"){
				//$rs = $this->admin_model->deleteFixed($this->uri->segment(4)); 
				redirect('admin/fixed');
	    	}else if($this->uri->segment(3)=="edit"){
	    		$load = "admin-fixed-form";
	    		$rs = $this->admin_model->getFixedDetail($this->uri->segment(4)); 
	    	}else if($this->uri->segment(3)=="add"){
	    		$load = "admin-fixed-form";
	    	}
			$data = array(
				"pageview"	=> $load,
				"page" 		=> 'fixed',
				"pagesub" 	=> '',
				"pagename" 	=> 'รายละเอียดการซ่อม',
				"rsList" 	=> $this->admin_model->getFixedList(),
				"rsDBList" 	=> $this->admin_model->getDBLists(),
				"rs" 		=> $rs,
				'rsInbox'	=> $this->admin_model->getNewInbox(),
				'rsInboxAll'=> $this->admin_model->getInbox()
			);
		
			$this->load->view('admin2/template-main',$data);
		}
	}
	
	public function fixed_export(){
			$data = array(
				"rsList" 	=> $this->admin_model->getFixedList(),
				"rsDBList" 	=> $this->admin_model->getDBLists(),
				'rsInbox'	=> $this->admin_model->getNewInbox(),
				'rsInboxAll'=> $this->admin_model->getInbox()
			);
		
			$this->load->view('admin2/admin-fixed-export',$data);
	}
	
	public function maintain_request(){
		if($this->input->post()!=null){
			$ar = $this->input->post();	
			exit;
		}else{
			$load = "admin-maintain_request";
			$rs="";
			if($this->uri->segment(3)=="del"){
				$rs = $this->admin_model->delMaintainRequest($this->uri->segment(4)); 
				redirect('admin2/maintain_request');
	    	}else if($this->uri->segment(3)=="edit"){
	    		$load = "admin-maintain_request-form";
	    		$rs = $this->admin_model->getPaperDetail($this->uri->segment(4)); 
	    	}else if($this->uri->segment(3)=="add"){
	    		$load = "admin-maintain_request-form";
	    	}
			$data = array(
				"pageview"	=> $load,
				"page" 		=> 'maintain',
				"pagesub" 	=> 'maintain_request',
				"pagename" 	=> 'คำขอติดตั้งเครื่อง',
				"rsList" 	=> $this->admin_model->getMaintainRequest(),
				"rs" 		=> $rs,
				'rsInbox'	=> $this->admin_model->getNewInbox(),
				'rsInboxAll'=> $this->admin_model->getInbox()
			);
		
			$this->load->view('admin2/template-main',$data);
		}
	}
	public function maintain_noti(){
		
		
		$load = 'admin-maintainnoti';
		$rs ='';

		if($this->uri->segment(3)=="del"){
			//$this->admin_model->deleteContact($this->uri->segment(4)); 
			redirect('admin2/maintain_noti');
	    }else if($this->uri->segment(3)=="view"){
			$rs = $this->admin_model->getMaintainNoti($this->uri->segment(4)); 
			$load = 'admin-maintainnoti-view';
	    }
		
		$data = array(
			"pageview"	=> $load,
			"page" 		=> 'maintain_noti',
			"pagesub" 	=> '',
			"pagename" 	=> 'แจ้งอัพเดทข้อมูล',
			"rsList" 	=> $this->admin_model->getMaintainNotiList(),
			"rs" 		=> $rs,
			'rsInbox'	=> $this->admin_model->getNewInbox(),
			'rsInboxAll'=> $this->admin_model->getInbox()
		);
		
		$this->load->view('admin2/template-main',$data);
	}
	
	public function maintain_renew(){
		
		
		$load = 'admin-maintain-renew';
		$rs ='';

		if($this->uri->segment(3)=="del"){
			//$this->admin_model->deleteContact($this->uri->segment(4)); 
			redirect('admin2/maintain_renew');
	    }else if($this->uri->segment(3)=="view"){
			$rs = $this->admin_model->getMaintainRenewDetail($this->uri->segment(4)); 
			$load = 'admin-renew-view';
	    }
		
		$data = array(
			"pageview"	=> $load,
			"page" 		=> 'maintain_renew',
			"pagesub" 	=> '',
			"pagename" 	=> 'แจ้งต่ออายุ NB',
			"rsList" 	=> $this->admin_model->getMaintainRenew(),
			"rs" 		=> $rs,
			'rsInbox'	=> $this->admin_model->getNewInbox(),
			'rsInboxAll'=> $this->admin_model->getInbox()
		);
		
		$this->load->view('admin2/template-main',$data);
	}
	
	public function maintain_setup(){
		
		$load = "admin-maintain_setup";
		$rs = array();
		if($this->uri->segment(3)=="view"){
			$load = "admin-maintain_setup_view";
			$rs = $this->admin_model->getMaintainSetupDetail($this->uri->segment(4)); 
			
	    }
		$data = array(
				"pageview"	=> $load,
				"page" 		=> 'maintain',
				"pagesub" 	=> 'maintain_setup',
				"pagename" 	=> 'แจ้งติดตั้งเครื่อง',
				"rsList" 	=> $this->admin_model->getMaintainSetup(),
				"rs" 		=> $rs,
				'rsInbox'	=> $this->admin_model->getNewInbox(),
				'rsInboxAll'=> $this->admin_model->getInbox()
			);
		
			$this->load->view('admin2/template-main',$data);
	}
	
	
	public function maintain_member(){
		if($this->input->post()!=null){
			$ar = $this->input->post();	
			if($this->uri->segment(3)=="add"){
				$ar['user_status'] =1;
				$es = $this->admin_model->addMaintainMember($ar);
				redirect('admin2/maintain_member/edit/'.$ar['username']);
			}else{
				
	
				foreach($ar['engine_code'] as $k=>$v){
					$ar_post = array(
						'engine_id'		=> $k,
						'engine_code'	=> $ar['engine_code'][$k][0],
						'engine_status'	=> @$ar['engine_status'][$k][0],
						'engine_repair'	=> @$ar['engine_repair'][$k][0],
					);
					$es = $this->admin_model->updateMaintainEngine($ar_post);
				}
				redirect('admin2/maintain_member/edit/'.$ar['username']);
				exit;
			}
		}else{
			$load = "admin-maintain_member";
			$rs="";
			$rsEngine="";
			$rsAdd="";
			if($this->uri->segment(3)=="del"){
				$rs = $this->admin_model->delMaintainRequest($this->uri->segment(4)); 
				redirect('admin2/maintain_member');
	    	}else if($this->uri->segment(3)=="edit"){
	    		$load = "admin-maintain_member-form";
	    		$rs = $this->admin_model->getMaintainMemberDetail($this->uri->segment(4)); 
				$rsAdd = $this->admin_model->getMaintainMemberAdd2($this->uri->segment(4)); 
				$rsEngine = $this->admin_model->getMaintainEngine($this->uri->segment(4)); 
	    	}else if($this->uri->segment(3)=="add"){
				$rsAdd = $this->admin_model->getMaintainMemberAdd($this->uri->segment(4)); 
	    		$load = "admin-maintain_member-form";
	    	}else if($this->uri->segment(3)=="addengine"){
				$add = $this->admin_model->addEngine($this->uri->segment(4));
				redirect('admin2/maintain_member/edit/'.$this->uri->segment(4));
	    	}else if($this->uri->segment(3)=="delengine"){
				$add = $this->admin_model->delEngine($this->uri->segment(4));
				redirect('admin2/maintain_member/edit/'.$this->uri->segment(5));
	    	}else if($this->uri->segment(3)=="editt"){
				$return = $this->admin_model->getMaintainByKey($this->uri->segment(4));
				redirect('admin2/maintain_member/edit/'.$return[0]->username);
	    	}
			
			$rsList = $this->admin_model->getMaintainMember();
			
			$g_username = 'MT'.$this->getUserMaintain(count($rsList));
			$g_password = $this->generateRandomString();

			
			$data = array(
				"pageview"	=> $load,
				"g_username"	=> $g_username,
				"g_password"	=> $g_password,
				"page" 		=> 'maintain',
				"pagesub" 	=> 'maintain_member',
				"pagename" 	=> 'รายชื่อสมาชิก',
				"rsList" 	=> $this->admin_model->getMaintainMember(),
				"rs" 		=> $rs,
				"rsAdd" 		=> $rsAdd,
				"rsEngine" 		=> $rsEngine,
				'rsInbox'	=> $this->admin_model->getNewInbox(),
				'rsInboxAll'=> $this->admin_model->getInbox()
			);
		
			$this->load->view('admin2/template-main',$data);
		}
	}
	
	public function logbook(){
		if($this->input->post()!=null){
			$ar = $this->input->post();	
			if($ar['log_id']!=null){
				$rs = $this->admin_model->updateLogBook($ar);
			}else{
				$ar['createdate'] = date('Y-m-d H:i:s');
				$rs = $this->admin_model->insertLogbook($ar);
			}
			echo "<script>alert('บันทึกข้อมูลแล้ว');window.location.href='".site_url()."admin2/logbook';</script>";

		}else{
			$load = "admin-logbook";
			$rs="";
			if($this->uri->segment(3)=="del"){
				$rs = $this->admin_model->deleteLogBook($this->uri->segment(4)); 
				redirect('admin/logbook');
	    	}else if($this->uri->segment(3)=="edit"){
	    		$load = "admin-logbook-form";
	    		$rs = $this->admin_model->getLogBookDetail($this->uri->segment(4)); 
	    	}else if($this->uri->segment(3)=="add"){
	    		$load = "admin-logbook-form";
	    	}
			$data = array(
				"pageview"	=> $load,
				"page" 		=> 'logbook',
				"pagesub" 	=> '',
				"pagename" 	=> 'LoogBook',
				"rsList" 	=> $this->admin_model->getLogbookList(),
				"rsDBList" 	=> $this->admin_model->getDBLists(),
				"rs" 		=> $rs,
				'rsInbox'	=> $this->admin_model->getNewInbox(),
				'rsInboxAll'=> $this->admin_model->getInbox()
			);
		
			$this->load->view('admin2/template-main',$data);
		}
	}
	
	function getUserMaintain($number){
		$number++;
		if($number<10){
			return '00'.$number;
		}else if($number>=10 && $number<100){
			return '0'.$number;
		}else{
			return $number;
		}
	}
	
	function generateRandomString($length = 5) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	
	
	public function offline_alert(){
		if($this->input->post()!=null){
			$ar = $this->input->post();	
			$json = json_encode($ar);
			$bytes = file_put_contents($_SERVER["DOCUMENT_ROOT"]."/uploads/json/station_alert.json", $json);
			
			redirect('admin2/offline_alert');
		}else{
			
			
			
			$json = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/uploads/json/station_alert.json");
			$json_setting = json_decode($json);
			
			$load = "admin-offline";
			$rs="";
			$station_lists1 = array(1001, 1002, 1003, 1004, 1005, 1006);
			$station_lists2 = array(5721, 5722, 5723, 6614, 6615, 6616, 6617, 6618, 6619, 6620, 6621, 6622, 6623, 6624 ,6625, 6626, 6627, 6629, 6630);
			
			$station_lists = array_merge($station_lists1, $station_lists2);
			$data = array(
				"pageview"	=> $load,
				"page" 		=> 'offline_alert',
				"pagesub" 	=> '',
				"pagename" 	=> 'แจ้งเตือนเครื่องออฟไลน์',
				"rsList" 	=> $station_lists,
				"json_setting" 	=> (array)$json_setting->station,
				"rsDBList" 	=> $this->admin_model->getDBLists(),
				"rs" 		=> $rs,
				'rsInbox'	=> $this->admin_model->getNewInbox(),
				'rsInboxAll'=> $this->admin_model->getInbox()
			);
		
			$this->load->view('admin2/template-main',$data);
		}
	}
	
}