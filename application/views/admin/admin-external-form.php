<?php 
$idlink="";
$link_name="";
$link_image="";
$link_url="";
$link_qno="";
$link_status="";
$link_create=date('Y-m-d H:i:s');
if($rs!=null){
$idlink=$rs[0]->idlink;
$link_name=$rs[0]->link_name;
$link_image=$rs[0]->link_image;
$link_qno=$rs[0]->link_qno;
$link_url=$rs[0]->link_url;
$link_status=$rs[0]->link_status;
$link_create=$rs[0]->link_create;
}
?>



<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/external/" class="btn btn-info"><i class="fa fa-undo"></i> กลับ</a>
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
							<label class="col-md-2 control-label">ชื่อลิงค์</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="link_name" id="link_name" title="ชื่อลิงค์" required value="<?=$link_name?>">
							</div>
						</div>
                        <div class="form-group">
							<label class="col-md-2 control-label">ยูอาร์แอล</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="link_url" id="link_url" title="ยูอาร์แอล" required value="<?=$link_url?>">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label">รูปภาพ</label>
							<div class="col-md-10">
								<?php if(!empty($link_image)){ ?>
										<div id="image_cover_show">
											<img src="<?=base_url()?>uploads/images/<?=$link_image?>" style="max-width:100%;max-height:250px;"><br/>
											<button type="button" id="remove_image_cover" class="btn btn-default btn-sm" style="margin-top:10px;">
											<i class="fa fa-trash-o"></i> Remove Image</button>
										</div>
								<?php	} ?>
								<div id="dropzone" name="link_image" class="dropzone" <?php if(!empty($link_image)){echo 'style="display:none;"';}?>></div>
                                <span class="text-danger">ขนาดแนะนำ 378x131 พิกเซล</span>
							</div>
                        </div>
                          
                        
                        <div class="form-group">
							<label class="col-md-2 control-label">ลำดับการแสดงผล</label>
							<div class="col-md-10">
								<input type="number" class="form-control input-small" name="link_qno" id="link_qno" title="ลำดับการแสดงผล" required value="<?=$link_qno?>">
							</div>
						</div>     
                       
						<div class="form-group">
							<label class="col-md-2 control-label">สถานะการแสดง</label>
							<div class="col-md-10">
								<div class="radio-list">
									<label class="radio-inline">
									<input type="radio" name="link_status" value="1" <?=$link_status==1?'checked':''?> <?=$link_status==''?'checked':''?>> แสดง </label>
									<label class="radio-inline">
									<input type="radio" name="link_status" value="0" <?=$link_status==0?'checked':''?> > ซ่อน </label>	
								</div>
							</div>
						</div>
						
					</div>
					
					<div class="form-actions fluid">
						<div class="col-md-offset-2 col-md-10">
							<input type="hidden" name="link_create" id="link_create" value="<?=$link_create?>">
							<input type="hidden" name="idlink" id="idlink" value="<?=$idlink?>">
							<input type="hidden" name="h_image" id="h_image" value="<?=$link_image?>">
							<button type="submit" id="btn_submit" class="btn btn-primary">บันทึก</button>
							<a href="javascript:history.back()" class="btn btn-default">ยกเลิก</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


