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
$location_status="";

$db_co="";
$db_mobile="";
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
$location_status=$rs[0]->location_status;

$db_co=$rs[0]->db_co;
$db_mobile=$rs[0]->db_mobile;
}
$_id = 'Dustboy 0';
if($source_id<10){
	$_id .= '0'.$source_id;
}else{
	$_id .= $source_id;
}
?>



<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/source/" class="btn btn-info"><i class="fa fa-undo"></i> กลับ</a>
			</div>
		</div>
		<hr/>
		<div class="row">
			<div class="col-md-12">
				<div class="containerz col-md-6 col-md-offset-3 alert alert-danger" style="display: none;margin-top:20px;">
					<h4>กรุณาป้อนข้อมูลต่อไปนี้ให้ถูกต้องครบถ้วน</h4>
					<ol></ol>
				</div>
				<div class="clearfix"></div>
				<form class="form-horizontal" method="post" role="form" id="frm_slide">
					<div class="form-body">
						<div class="form-group">
							<label class="col-md-2 control-label">Web ID</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="source_id" id="source_id" required value="<?=$source_id?>" <?=$source_id!=null?'readonly':''?> title="Webid">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Location ALIAS</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="location_id" id="yt_id" required value="<?=$location_id?>" title="Dustboy id">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Location Name (TH)</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="location_name" id="location_name" required value="<?=$location_name?>" title="Dustboy th name">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Location Name (EN)</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="location_name_en" id="location_name_en" required value="<?=$location_name_en?>" title="Dustboy en name">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Latitude</label>
							<div class="col-md-10">
								<input type="text" class="form-control input-small" name="location_lat" id="location_lat" required value="<?=$location_lat?>" title="Latitude">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Longitude</label>
							<div class="col-md-10">
								<input type="text" class="form-control input-small" name="location_lon" id="location_lon" required value="<?=$location_lon?>" title="Longitude">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">short URL</label>
							<div class="col-md-10">
								<input type="text" class="form-control input-medium" name="location_uri" id="location_uri" value="<?=$location_uri?>" title="URL">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-2 control-label">ผู้ประสานงาน</label>
							<div class="col-md-10">
								<input type="text" class="form-control input-medium" name="db_co" id="db_co" value="<?=$db_co?>" title="ผู้ประสานงาน">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">หมายเลขโทรศัพท์</label>
							<div class="col-md-10">
								<input type="text" class="form-control input-medium" name="db_mobile" id="db_mobile" value="<?=$db_mobile?>" title="หมายเลขโทรศัพท์">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Province</label>
							<div class="col-md-10">
								<select class="form-control" name="is_cnx" id="is_cnx" title="Province" required>
									<option value=""> - select province - </option>
									<?php  foreach ($rsProvince as $key => $item) {?>  
										  <option value="<?=$item->province_id?>" <?=$is_cnx==$item->province_id?'selected':''?>> <?=$item->province_name?> </option> 
									<?php } ?>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-2 control-label">Data Table</label>
							<div class="col-md-10">
								<div class="radio-list">
									<label class="radio-inline">
									<input type="radio" name="version" value="" <?=$version==''?'checked':''?> <?=$version==''?'checked':''?>> log_data_2562 </label>
									<label class="radio-inline">
									<input type="radio" name="version" value="mini" <?=$version=='mini'?'checked':''?> > log_mini_2561 </label>	
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-2 control-label">สถานะการแสดง</label>
							<div class="col-md-10">
								<div class="radio-list">
									<label class="radio-inline">
									<input type="radio" name="location_status" value="1" <?=$location_status==1?'checked':''?> <?=$location_status==''?'checked':''?>> แสดง </label>
									<label class="radio-inline">
									<input type="radio" name="location_status" value="0" <?=$location_status==0?'checked':''?> > ซ่อน </label>	
								</div>
							</div>
						</div>
						
					</div>
					
					<div class="form-actions fluid">
						<div class="col-md-offset-2 col-md-10">
							<button type="submit" id="btn_submit" class="btn btn-primary">บันทึก</button>
							<a href="javascript:history.back()" class="btn btn-default">ยกเลิก</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


