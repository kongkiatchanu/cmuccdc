<?php 
	include 'config.php';
	
	$_TYPE 		= mysqli_real_escape_string($mysqli,$_POST["type"]);
	$_ACTION 	= mysqli_real_escape_string($mysqli,$_POST["action"]);
	$_TXT 		= mysqli_real_escape_string($mysqli,$_POST["txt"]);
	
	if(trim($_TXT!=null) && trim($_TXT!="")){
			$tmp = strtolower($_TXT);
			if(substr($tmp,0,4)=="gear"){
				$gear = substr($tmp, -2);
				$gear = $gear+12;
				$rsResult = $this->main_model->getGearSearch($gear);
				$rsResultNum = $this->main_model->getGearSearchNum($gear);
			}elseif(substr($tmp,0,5)=="gear "){
				$gear = substr($tmp, -2);
				$gear = $gear+12;
				$rsResult = $this->main_model->getGearSearch($gear);
				$rsResultNum = $this->main_model->getGearSearchNum($gear);
			}elseif(substr($txt_search,0,18)=="เกียร์"){
				$gear = substr($tmp, -2);
				$gear = $gear+12;
				$rsResult = $this->main_model->getGearSearch($gear);
				$rsResultNum = $this->main_model->getGearSearchNum($gear);
			
			}elseif(substr($txt_search,0,19)=="เกียร์ "){
				$gear = substr($tmp, -2);
				$gear = $gear+12;
				$rsResult = $this->main_model->getGearSearch($gear);
				$rsResultNum = $this->main_model->getGearSearchNum($gear);
			
			}else{
				$rsResult = $this->main_model->getSearch($this->input->get('txt_search'));
				$rsResultNum = $this->main_model->getSearchNum($this->input->get('txt_search'));
			}

			$data = array(
				'_searchTxt' => $txt_search,
				'_searchResult' => $rsResult,
				'_searchResultNum' => $rsResultNum
			);	
			$this->load->view('demo/search',$data);
		}
?>