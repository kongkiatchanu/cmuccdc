<?php 
$id="";
$name="";
$lat="";
$lng="";
$pv="";
$am="";
$addr="";
$is_show="";
$createdate=date('Y-m-d H:i:s');
if($rs!=null){
$id=$rs[0]->id;
$name=$rs[0]->name;
$lat=$rs[0]->lat;
$lng=$rs[0]->lng;
$pv=$rs[0]->pv;
$am=$rs[0]->am;
$addr=$rs[0]->addr;
$is_show=$rs[0]->is_show;
$createdate=$rs[0]->createdate;
}

?>



<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/mkup/" class="btn btn-info"><i class="fa fa-undo"></i> กลับ</a>
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
							<label class="col-md-2 control-label">Name</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="name" id="name" required value="<?=$name?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Latitude</label>
							<div class="col-md-10">
								<input type="text" class="form-control input-small" name="lat" id="lat" required value="<?=$lat?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Longitude</label>
							<div class="col-md-10">
								<input type="text" class="form-control input-small" name="lng" id="lng" required value="<?=$lng?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Province</label>
							<div class="col-md-10">
								<input type="text" class="form-control input-medium" name="pv" id="pv" value="<?=$pv?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Amphur</label>
							<div class="col-md-10">
								<input type="text" class="form-control input-medium" name="am" id="am" value="<?=$am?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Address</label>
							<div class="col-md-10">
								<textarea class="form-control" name="addr" id="addr"><?=$am?></textarea>
							</div>
						</div>
						
						
						<div class="form-group">
							<label class="col-md-2 control-label">สถานะการแสดง</label>
							<div class="col-md-10">
								<div class="radio-list">
									<label class="radio-inline">
									<input type="radio" name="is_show" value="1" <?=$is_show==1?'checked':''?> <?=$is_show==''?'checked':''?>> แสดง </label>
									<label class="radio-inline">
									<input type="radio" name="is_show" value="0" <?=$is_show==0?'checked':''?> > ซ่อน </label>	
								</div>
							</div>
						</div>
						
					</div>
					
					<div class="form-actions fluid">
						<div class="col-md-offset-2 col-md-10">
							<input type="hidden" name="id" id="id" value="<?=$id?>">
							<input type="hidden" name="createdate" id="createdate" value="<?=$createdate?>">
							<button type="submit" id="btn_submit" class="btn btn-primary">บันทึก</button>
							<a href="javascript:history.back()" class="btn btn-default">ยกเลิก</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


