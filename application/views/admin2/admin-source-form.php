<?php 
    $source_id="";
    $location_id="";
    $location_name="";
    $location_name_en="";
    $location_lat="";
    $location_lon="";
    $location_uri="";
    $version="";
    $is_cnx="";
    $db_co="";
    $db_email="";
    $db_mobile="";
    $db_addr="";
    $db_model="";
    $db_status="";
    $db_status_fixed="";
    $db_status_install="";
    $location_status="";
    if($rs!=null){
        $source_id=$rs[0]->source_id;
        $location_id=$rs[0]->location_id;
        $location_name=$rs[0]->location_name;
        $location_name_en=$rs[0]->location_name_en;
        $location_lat=$rs[0]->location_lat;
        $location_lon=$rs[0]->location_lon;
        $location_uri=$rs[0]->location_uri;
        $version=$rs[0]->version;
        $is_cnx=$rs[0]->is_cnx;
        $db_co=$rs[0]->db_co;
        $db_email=$rs[0]->db_email;
        $db_mobile=$rs[0]->db_mobile;
        $db_addr=$rs[0]->db_addr;
        $db_model=$rs[0]->db_model;
        $db_status=$rs[0]->db_status;
        $db_status_fixed=$rs[0]->db_status_fixed;
        $db_status_install=$rs[0]->db_status_install;
        $location_status=$rs[0]->location_status;
    }
    $_id = 'Dustboy 0';
    if($source_id<10){
        $_id .= '0'.$source_id;
    }else{
        $_id .= $source_id;
    }
?>

<div class="main-header row">
    <div class="col-12 col-md-6">
        <label class="title"><?=$pagename?></label>
    </div>
    <div class="col-12 col-md-6">
        <div class="controller">
            <a href="<?=base_url()?>admin2/source/" class="btn btn-custom-sm btn-bg-color">
                <i class="fas fa-undo"></i> ย้อนกลับ
            </a>
        </div>
    </div>
</div>
<div class="main-body row">
    <div class="col-12">
        <form class="custom-form" method="post" role="form" id="frm_slide">
            <div class="form-group row">
                <label for="source_id" class="col-sm-2 col-form-label">Web ID</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="source_id" name="source_id" required value="<?=$source_id?>" <?=$source_id!=null?'readonly':''?> title="Web id is required">
				</div>
            </div>
            <div class="form-group row">
                <label for="yt_id" class="col-sm-2 col-form-label">Location ALIAS</label>
                <div class="col-sm-10">
					<input type="text" class="form-control" name="location_id" id="yt_id" required value="<?=$location_id?>" title="Dustboy id is required">
				</div>
            </div>
            <div class="form-group row">
                <label for="location_name" class="col-sm-2 col-form-label">Location Name (TH)</label>
                <div class="col-sm-10">
					<input type="text" class="form-control" name="location_name" id="location_name" required value="<?=$location_name?>" title="Dustboy th name is required">
				</div>
            </div>
            <div class="form-group row">
                <label for="location_name_en" class="col-sm-2 col-form-label">Location Name (EN)</label>
                <div class="col-sm-10">
					<input type="text" class="form-control" name="location_name_en" id="location_name_en"  value="<?=$location_name_en?>" title="Dustboy en name is required">
				</div>
            </div>
			<div class="form-group row">
                <label for="db_co" class="col-sm-2 col-form-label">ชื่อผู้ประสาน</label>
                <div class="col-sm-10">
					<input type="text" class="form-control" name="db_co" id="db_co"  value="<?=$db_co?>" title="ชื่อผู้ประสาน">
				</div>
            </div>
			<div class="form-group row">
                <label for="db_mobile" class="col-sm-2 col-form-label">เบอร์โทรศัพท์</label>
                <div class="col-sm-10">
					<input type="text" class="form-control" name="db_mobile" id="db_mobile"  value="<?=$db_mobile?>" title="เบอร์โทรศัพท์">
				</div>
            </div>
			<div class="form-group row">
                <label for="db_mobile" class="col-sm-2 col-form-label">อีเมล์</label>
                <div class="col-sm-10">
					<input type="email" class="form-control" name="db_email" id="db_email"  value="<?=$db_email?>" title="อีเมล์">
				</div>
            </div>
			<div class="form-group row">
                <label for="db_addr" class="col-sm-2 col-form-label">หมายเหตุ</label>
                <div class="col-sm-10">
					<input type="text" class="form-control" name="db_addr" id="db_addr"  value="<?=$db_addr?>" title="หมายเหตุ">
				</div>
            </div>
			<div class="form-group row">
                <label for="db_addr" class="col-sm-2 col-form-label">โมเดลเครื่อง</label>
                <div class="col-sm-10">
					<select class="custom-select" name="db_model" id="db_model" required title="โมเดลเครื่อง" >
						<option value=""> - Select Model - </option>
						<?php foreach(getDBModel() as $k=>$v){?>
						<option value="<?=$k?>" <?=$k==$db_model?'selected':''?>> <?=$v?> </option>
						<?php }?>
					</select>
				</div>
            </div>
            <div class="form-group row">
                <label for="location_lat" class="col-sm-2 col-form-label">Latitude</label>
                <div class="col-sm-3">
					<input type="text" class="form-control" name="location_lat" id="location_lat" required value="<?=$location_lat?>" title="Latitude is required">
				</div>
            </div>
            <div class="form-group row">
                <label for="location_lon" class="col-sm-2 col-form-label">Longitude</label>
                <div class="col-sm-3">
					<input type="text" class="form-control" name="location_lon" id="location_lon" required value="<?=$location_lon?>" title="Longitude is required">
				</div>
            </div>
            <div class="form-group row">
                <label for="location_uri" class="col-sm-2 col-form-label">short URL</label>
                <div class="col-sm-3">
					<input type="text" class="form-control" name="location_uri" id="location_uri" value="<?=$location_uri?>" title="URL">
				</div>
            </div>
            <div class="form-group row">
                <label for="is_cnx" class="col-sm-2 col-form-label">Province</label>
               <div class="col-sm-10">
				<select class="custom-select" name="is_cnx" id="is_cnx"  title="Province is required" >
                    <option value=""> - select province - </option>
                    <?php  foreach ($rsProvince as $key => $item) {?>  
                            <option value="<?=$item->province_id?>" <?=$is_cnx==$item->province_id?'selected':''?>> <?=$item->province_name?> </option> 
                    <?php } ?>
                </select>
				</div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="">Data Table</label>
				<div class="col-sm-10">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="version1" name="version" value="" <?=$version==''?'checked':''?>>
                    <label class="custom-control-label" for="version1">log_data_2562</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="version2" name="version" value="mini" <?=$version=='mini'?'checked':''?> >
                    <label class="custom-control-label" for="version2">log_mini_2561</label>
                </div>
				<div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="version3" name="version" value="wplus" <?=$version=='wplus'?'checked':''?> >
                    <label class="custom-control-label" for="version3">WPlus</label>
                </div>
				</div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="">สถานะการแสดง</label>
				<div class="col-sm-10">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="location_status1" name="location_status" value="1" <?=$location_status==1?'checked':''?> <?=$location_status==''?'checked':''?>>
                    <label class="custom-control-label" for="location_status1">แสดง</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="location_status2" name="location_status" value="0" <?=$location_status==0?'checked':''?>>
                    <label class="custom-control-label" for="location_status2">ซ่อน</label>
                </div>
				</div>
            </div>
			<div class="form-group row">
                <label class="col-sm-2 col-form-label" for="">สถานะการติดตั้ง</label>
				<div class="col-sm-10">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input sel_setup" id="db_status1" name="db_status" value="0" <?=$db_status==0?'checked':''?> <?=$db_status==''?'checked':''?>>
                    <label class="custom-control-label" for="db_status1">ไม่กำหนด</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input sel_setup" id="db_status2" name="db_status" value="1" <?=$db_status==1?'checked':''?>>
                    <label class="custom-control-label" for="db_status2">ส่งซ่อม</label>
                </div>
				<div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input sel_setup" id="db_status3" name="db_status" value="2" <?=$db_status==2?'checked':''?>>
                    <label class="custom-control-label" for="db_status3">ติดตั้ง</label>
                </div>
				</div>
            </div>
			<div id="db_fix" <?=$db_status==1?'':'style="display:none;"'?>>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="">สถานะการส่งซ่อม</label>
					<div class="col-sm-10">
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="custom-control-input" id="db_status_fixed" name="db_status_fixed" value="0" <?=$db_status_fixed==0?'checked':''?> <?=$db_status_fixed==''?'checked':''?>>
							<label class="custom-control-label" for="db_status_fixed">ไม่กำหนด</label>
						</div>
						<?php 
						$ar_fix = array(
							'1'=> 'แจ้งซ่อม',
							'2'=> 'รับเครื่อง',
							'3'=> 'ซ่อมบำรุง',
							'4'=> 'ทดสอบ',
							'5'=> 'ขนส่ง/ส่งคืน',
						);
						foreach($ar_fix as $k=>$v){
						?>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="custom-control-input sel_setup" id="db_status_fixed<?=$k?>" name="db_status_fixed" value="<?=$k?>" <?=$db_status_fixed==$k?'checked':''?>>
							<label class="custom-control-label" for="db_status_fixed<?=$k?>"><?=$v?></label>
						</div>
						<?php }?>
					</div>
				</div>
			</div>
			
			<div id="db_install" <?=$db_status==2?'':'style="display:none;"'?>>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="">สถานะการติดตั้ง</label>
					<div class="col-sm-10">
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="custom-control-input" id="db_status_install" name="db_status_install" value="0" <?=$db_status_install==0?'checked':''?> <?=$db_status_install==''?'checked':''?>>
							<label class="custom-control-label" for="db_status_install">ไม่กำหนด</label>
						</div>
						<?php 
						$ar_fix = array(
							'1'=> 'ผลิตเครื่อง',
							'2'=> 'ทดสอบ',
							'3'=> 'ขนส่ง',
							'4'=> 'ออนไลน์',
						);
						foreach($ar_fix as $k=>$v){
						?>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="custom-control-input sel_setup" id="db_status_install<?=$k?>" name="db_status_install" value="<?=$k?>" <?=$db_status_install==$k?'checked':''?>>
							<label class="custom-control-label" for="db_status_install<?=$k?>"><?=$v?></label>
						</div>
						<?php }?>
					</div>
				</div>
			</div>
            <hr>
            <div class="form-group text-right mt-3">
                <button type="submit" id="btn_submit" class="btn btn-custom btn-bg-color">บันทึก</button>
                <a href="javascript:history.back()" class="btn btn-custom btn-base-color">ยกเลิก</a>
            </div>
        </form>
    </div>
</div>