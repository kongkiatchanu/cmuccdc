<?php 
$air_id="";
$air_name="";
$air_detail="";

if($rs!=null){
$air_id=$rs[0]->air_id;
$air_name=$rs[0]->air_name;
$air_detail=$rs[0]->air_detail;
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
							<label class="col-md-2 control-label">Name</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="air_name" id="air_name" required value="<?=$air_name?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Detail</label>
							<div class="col-md-10">
								<textarea class="form-control" name="air_detail" id="air_detail" required rows="3"><?=$air_detail?></textarea>
							</div>
						</div>

						
					</div>
					
					<div class="form-actions fluid">
						<div class="col-md-offset-2 col-md-10">
							<input type="hidden" name="air_id" id="air_id" value="<?=$air_id?>">
							<button type="submit" id="btn_submit" class="btn btn-primary">บันทึก</button>
							<a href="javascript:history.back()" class="btn btn-default">ยกเลิก</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


