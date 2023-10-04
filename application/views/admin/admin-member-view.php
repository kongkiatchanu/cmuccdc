<?php 
						function getfburl($contact_fb){
							if($contact_fb!=null){
								$pos = strpos($contact_fb, '.com');
								if($pos>1){
									$contact_fb = $contact_fb;
								}else{
									$contact_fb = 'https://fb.com/'.$contact_fb;
								}
								
							}
							return $contact_fb;
						}
						function addhttp($url) {
							if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
								$url = "http://" . $url;
							}
							return $url;
						}
				$idcard				= "";
		$idmember			= "";
		$member_img			= "";
		$member_code		= "";
		$member_prefix		= "";
		$member_fname 		= "";
		$member_lname 		= "";
		$member_nickname 	= "";
		$member_gender 		= "";
		$member_detail 		= "";
		$contact_phone		= "";
		$contact_fb 		= "";
		$contact_email 		= "";
		$contact_line		= "";
		$contact_website	= "";
		$contact_website2	= "";
		$contact_linkedin	= "";
		$contact_researchgate= "";
		$contact_address	= "";
		$contact_zipcode	= "";
		$department_detail		= "";
		$department_position		= "";
		$tbmajor_idtbmajor	= "";
		$tbcareer_idtbcareer= "";
		$tbcareer_other		= "";
		$contact_province	= "";
		$contact_amphur		= "";
		$contact_district	= "";
		$member_expertise	= "";
		$member_certifly	= "";
		$office_name	= "";
		$office_address	= "";
		
		$name_province	= "";
		$name_amphur	= "";
		$name_district	= "";
		$name_careerr	= "";
		$name_business	= "";
		$name_business_detail	= "";
		$name_ministry	= "";
		$name_ministry_detail	= "";
		$member_gear	= "";
if($member[0]["idmember"]!=null){
				//database
				$idcard				= $member[0]["idcard"];
				$idmember			= $member[0]["idmember"];
				$member_img			= $member[0]["member_img"];
				$member_code 		= $member[0]["member_code"];
				$member_gear 		= $member[0]["member_gear"];
				$member_prefix 		= $member[0]["member_prefix"];
				$tbmajor_idtbmajor	= $member[0]["tbmajor_idtbmajor"];
				$member_fname 		= $member[0]["member_fname"];
				$member_lname 		= $member[0]["member_lname"];
				$member_nickname 	= $member[0]["member_nickname"];
				$member_gender 		= $member[0]["member_gender"];
				$member_detail 		= $member[0]["member_detail"];
				$contact_phone 		= $member[0]["contact_phone"];
				$contact_fb 		= $member[0]["contact_fb"];
				$contact_email 		= $member[0]["contact_email"];
				$contact_line		= $member[0]["contact_line"];
				$contact_website	= $member[0]["contact_website"];
				$contact_website2	= $member[0]["contact_website2"];
				$contact_linkedin	= $member[0]["contact_linkedin"];
				$contact_researchgate= $member[0]["contact_researchgate"];
				$contact_address	= $member[0]["contact_address"];
				$contact_zipcode	= $member[0]["contact_zipcode"];
				$department_detail	= $member[0]["department_detail"];
				$department_position	= $member[0]["department_position"];
				$tbcareer_idtbcareer= $member[0]["tbcareer_idtbcareer"];
				$tbcareer_other		= $member[0]["tbcareer_other"];
				$contact_province	= $member[0]["contact_province"];
				$contact_amphur		= $member[0]["contact_amphur"];
				$contact_district	= $member[0]["contact_district"];
				$member_expertise	= $member[0]["member_expertise"];
				$member_certifly	= $member[0]["member_certifly"];
				$office_name	= $member[0]["office_name"];
				$office_address	= $member[0]["office_address"];
			}else{
				//facebook
				$member_fname		= $member[0]["member_fname"];
		        $member_lname		= $member[0]["member_lname"];
		        $member_nickname	= $member[0]["member_nickname"];
		        $contact_email		= $member[0]["contact_email"];
		        $member_gender		= $member[0]["member_gender"];
		        $contact_fb			= $member[0]["contact_fb"];	
			}
			if($rsprovince){
				$name_province = $rsprovince[0]->PROVINCE_NAME;
			}if($rsdistrict){
				$name_district = $rsdistrict[0]->DISTRICT_NAME;
			}if($rsamphur){
				$name_amphur = $rsamphur[0]->AMPHUR_NAME;
			}if($rscareer){
				$name_careerr = $rscareer[0]->career_name;
			}if($rsbusinessdetail){
				$name_business	= $rsbusinessdetail[0]->business_name;
				$name_business_detail	= $rsbusinessdetail[0]->detail_name;
			}if($rsministrydetail){
				$name_ministry	= $rsministrydetail[0]->ministry_name;
				$name_ministry_detail	= $rsministrydetail[0]->department_name 	;
			}	
?>
<style>
	/***
Profile Page
***/
.profile {
  position:relative;
}

.profile p {
  color:#636363;
  font-size:13px;
}

.profile p a {
  color:#169ef4;
}

.profile label {
  margin-top:10px;
}

.profile label:first-child {
  margin-top:0;
}

/*profile info*/
.profile-classic .profile-image {
  position:relative;
}

.profile-classic .profile-edit {
  top:0;
  right:0;
  margin:0;
  color:#fff;
  opacity:0.6;
  padding:0 9px;
  font-size:11px;
  background:#000;
  position:absolute;
  filter:alpha(opacity=60); /*for ie*/
}
.profile-classic .profile-image img {
  margin-bottom:15px;
}

.profile-classic li {
  padding:8px 0;
  font-size:13px;
  border-top:solid 1px #f5f5f5;
}

.profile-classic li:first-child {
  border-top:none;
}

.profile-classic li span {
  color:#666;
  font-size:13px;
  margin-right:7px;
}

/*profile tabs*/
.profile .tabbable-custom-profile .nav-tabs > li > a {
  padding:6px 12px;
}


/*profile navigation*/
.profile ul.profile-nav {
  margin-bottom:30px;
}

.profile ul.profile-nav li {
  position:relative;
}

.profile ul.profile-nav li a {
  color:#557386;
  display:block;
  font-size:14px;
  padding:8px 10px;
  margin-bottom:1px;
  background:#f0f6fa;
  border-left:solid 2px #c4d5df;
}

.profile ul.profile-nav li a:hover {
  color:#169ef4;
  background:#ecf5fb;
  text-decoration:none;
  border-left:solid 2px #169ef4;
}

.profile ul.profile-nav li a.profile-edit {
  top:0;
  right:0;
  margin:0;
  color:#fff;
  opacity:0.6;
  border:none;
  padding:3px 9px;
  font-size:12px;
  background:#000;
  position:absolute;
  filter:alpha(opacity=60); /*for ie*/
}

.profile ul.profile-nav li a.profile-edit:hover {
  text-decoration:underline;
}

.profile ul.profile-nav a span {
  top:0;
  right:0;
  color:#fff;
  font-size:16px; 
  padding:7px 13px;
  position:absolute;
  background:#169ef4;
}

.profile ul.profile-nav a:hover span {
  background:#0b94ea;
}

/*profile information*/
.profile-info h1 {
  color:#383839;
  font-size:24px;
  font-weight:400;
  margin:0 0 10px 0;
}

.profile-info ul {
  margin-bottom:15px;
}

.profile-info li {
  color:#6b6b6b;
  font-size:13px;
  margin-right:15px;
  margin-bottom:5px;
  padding:0 !important;
}

.profile-info li i {
  color:#b5c1c9;
  font-size:15px;
}

.profile-info li:hover i {
  color:#169ef4;
}

/*profile sales summary*/
.sale-summary ul {
  margin-top:-12px;
}
.sale-summary li {
  padding:10px 0;
  overflow:hidden;
  border-top:solid 1px #eee;
}

.sale-summary li:first-child {
  border-top:none;
}

.sale-summary li .sale-info {
  float:left;
  color:#646464;
  font-size:14px;
  text-transform:uppercase;
}

.sale-summary li .sale-num {
  float:right;
  color:#169ef4;
  font-size:20px;
  font-weight:300;
}

.sale-summary li span i {
  top:1px;
  width:13px;
  height:14px;
  margin-left:3px;
  position:relative;
  display:inline-block;
}

.sale-summary li i.icon-img-up {
  background:url(../../img/icon-img-up.png) no-repeat !important;
}

.sale-summary li i.icon-img-down {
  background:url(../../img/icon-img-down.png) no-repeat !important;
}

.sale-summary .caption h4 {
  color:#383839;
  font-size:18px;
}

.sale-summary .caption {
  border-color:#c9c9c9;
}

/*latest customers table*/
.profile .table-advance thead tr th {
  background:#f0f6fa;
}

.profile .table-bordered th, 
.profile .table-bordered td,
.profile .table-bordered {
  border-color:#e5eff6;
}

.profile .table-striped tbody > tr:nth-child(2n+1) > td, 
.profile .table-striped tbody > tr:nth-child(2n+1) > th {
  background:#fcfcfc;
}

.profile .table-hover tbody tr:hover td, 
.profile .table-hover tbody tr:hover th {
  background:#f5fafd;
}

/*add portfolio*/
.add-portfolio {
  overflow:hidden;
  margin-bottom:30px;
  background:#f0f6fa;
  padding: 12px 14px;
}

.add-portfolio span {
  float: left;
  display: inline-block;
  font-weight: 300;
  font-size: 22px;
  margin-top: 0px;
}

.add-portfolio .btn {
  margin-left: 20px;
}

/*portfolio block*/
.portfolio-block {
  background:#f7f7f7;
  margin-bottom:15px;
  overflow:hidden;
}

.portfolio-stat {
  overflow: hidden;
}

/*portfolio text*/
.portfolio-text {
  overflow:hidden;
}


.portfolio-text img {
  float:left;
  margin-right:15px;
}

.portfolio-text .portfolio-text-info {
  overflow:hidden;
}

/*portfolio button*/
.portfolio-btn a {
  display:block;
  padding:25px 0;
  background:#ddd !important;
}

.portfolio-btn a:hover {
  background:#1d943b !important;
}

.portfolio-btn span {
  color:#fff;
  font-size:22px;
  font-weight:200;  
}

/*portfolio info*/
.portfolio-info {
  float:left;
  color:#616161;
  font-size:12px;
  padding:10px 25px;
  margin-bottom:5px;
  text-transform:uppercase;
}

.portfolio-info span {
  color:#16a1f2;
  display:block;
  font-size:28px;
  line-height: 28px;
  margin-top:0px;
  font-weight:200;
  text-transform:uppercase;
}

/*portfolio settings*/
.profile-settings {
  background:#fafafa;
  padding:15px 8px 0;
  margin-bottom:5px;
}

.profile-settings p {
  padding-left:5px;
  margin-bottom:3px;
}

.profile-settings .controls > .radio, 
.profile-settings .controls > .checkbox {
  font-size:12px;
  margin-top:2px !important;
}

	</style>
<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/member" class="btn btn-info"><i class="fa fa-undo"></i> กลับ</a>
			</div>
		</div>
		<hr/>
		<div class="row">
			<div class="col-md-3">
					<?php 
					if(!empty($member_img)){ 
						$pos = strpos($member_img, 'facebook');
						if($pos){
								echo '<img src="'.$member_img.'" style="width:100%;border-bottom: 0px;" class="img-thumbnail"/>';
						}else{
								echo '<img src="'.base_url().'/uploads/images/'.$member_img.'" class="img-responsive img-thumbnail" style="border-bottom: 0px;"/>';
						}
					}else{		
							echo '<img src="'.base_url().'/img/avatar.png" class="img-responsive img-thumbnail" style="border-bottom: 0px;"/>';		
					}
					?>
			
			
			</div>
			<div class="col-md-9 profile-info">
				<div class="margin-bottom-20">
					<h1><?=$member_prefix?><?=$member_fname?> <?=$member_lname?> (<?=$member_nickname?>) #gear<?=$member_gear?></h1>
					<p><?=$member_detail?></p>
				</div>
				
				<div class="margin-bottom-20">
					<h4>ข้อมูลด้านอาชีพ</h4>
					<address>
					<?php 
					if($tbcareer_idtbcareer){
						if($tbcareer_idtbcareer!="15"){
							echo '<i class="fa fa-leaf" aria-hidden="true"></i> กลุ่มอาชีพ '.$name_careerr.'<br/>';
						}else{
						echo '<i class="fa fa-leaf" aria-hidden="true"></i> กลุ่มอาชีพ '.$tbcareer_other.'<br/>';
						}
					}

					if( $name_business==null && $name_business_detail==null){echo '';}else{echo '<i class="fa fa-leaf" aria-hidden="true"></i> ประเภทธุรกิจ '.$name_business.' '.$name_business_detail.'<br/>';}

					if( $name_ministry==null && $name_ministry_detail==null){echo '';}else{echo '<i class="fa fa-leaf" aria-hidden="true"></i> สังกัดกระทรวงและหน่วยงาน '.$name_ministry.' '.$name_ministry_detail.'<br/>';}
					
					echo $department_detail!=null? '<i class="fa fa-leaf" aria-hidden="true"></i> องค์กร/สังกัด '.$department_detail.'<br/>':'';
					echo $department_position!=null? '<i class="fa fa-leaf" aria-hidden="true"></i> ตำแหน่ง '.$department_position.'<br/>':'';
					if($member_certifly!=0){
						$text = '';
						if($member_certifly==1){
							$text = 'ระดับภาคี';
						}else if($member_certifly==2){
							$text = 'ระดับสามัญ';
						}else if($member_certifly==3){
							$text = 'ระดับวุฒิ';
						}
					}else{
						$text='ไม่ระบุ';
					}
					echo '<i class="fa fa-leaf" aria-hidden="true"></i> สถานะใบ กว. '.$text.'<br/>';
					
					echo '<div class="row margin-bottom-20"></div>';
					
					?>
					</address>
				</div>
				
				<?php if($member_expertise!=null){?>
				<div class="margin-bottom-20">
					<h4>ข้อมูลด้านอาชีพ</h4>
					<address>
					<div class="tags">
					<?php 
						$tags = explode(",", $member_expertise);
						foreach($tags as $value){ 
							if($value){?>
								<a title="<?=$value?>" class="btn btn-default btn-xs" href="<?=base_url()?>search/result?txt_search=<?=$value?>"><i class="fa fa-tags"></i> <?=$value?></a>
							<?php } 
						}	
					
					?>
					</div>
					</address>
				</div>
				<?php }?>

				
				<div class="margin-bottom-20">
					<h4>สถานที่ทำงาน</h4>
					<address>
					ชื่อบริษัท/ที่ทำงาน : <?=$office_name!=''?$office_name:' -'?><br/>
					ที่อยู่บริษัท/ที่ทำงาน : <?=$office_address!=''?$office_address:' -'?><br/>
					</address>
				</div>
				
				<div class="margin-bottom-20">
					<h4>ข้อมูลติดต่อ</h4>
					<address>
						<?=$contact_address!=""? '<i class="fa fa-map-marker"></i> ที่อยู่เลขที่  '.$contact_address:''?> 
						<?=$name_district!=""?'ตำบล'.$name_district:''?>
						<?=$name_amphur!=""? 'อำเภอ'.$name_amphur:''?>
						<?=$name_province!=""?'จังหวัด'.$name_province:''?>
						<?php if($contact_zipcode!=0 || $contact_zipcode!=""){ echo $contact_zipcode.'<br/>';} ?>
					
						<i class="fa fa-envelope"></i> <a href="mailto:<?=$contact_email?>"><?=$contact_email?></a><br>
						
						<?=getfburl($contact_fb)!=null?'<i class="fa fa-facebook-square"></i> Facebook : <a target="_blank" href="'.getfburl($contact_fb).'">'.getfburl($contact_fb).'</a><br/>':''?>
						<?=$contact_line!=null?'<img src="'.base_url().'img/header-social-line.png" width="15"> Line ID : '.$contact_line.'<br/>':''?>
						<?=$contact_website!=null?'<i class="fa fa-desktop"></i> Website : <a target="_blank" href="'.addhttp($contact_website).'">'.$contact_website.'</a><br/>':''?>
						<?=$contact_website2!=null?'<i class="fa fa-desktop"></i> Website : <a target="_blank" href="'.addhttp($contact_website2).'">'.$contact_website2.'</a><br/>':''?>
						<?=$contact_linkedin!=null?'<i class="fa fa-linkedin-square"></i> Linkedin : <a target="_blank" href="'.addhttp($contact_linkedin).'">'.$contact_linkedin.'</a><br/>':''?>
						<?=$contact_researchgate!=null?'<i class="fa fa-plus"></i> Researchgate : <a target="_blank" href="'.addhttp($contact_researchgate).'">'.$contact_researchgate.'</a><br/>':''?>
					</address>
				</div>
					

			</div>
		</div>
	</div>
</div>


