<?php 
$product_id="";
$product_name="";
$product_img="";
$product_txt="";
$product_status="";
$product_create=date('Y-m-d H:i:s');
if($rs!=null){
$product_id=$rs[0]->product_id;
$product_name=$rs[0]->product_name;
$product_img=$rs[0]->product_img;
$product_txt=$rs[0]->product_txt;
$product_status=$rs[0]->product_status;
$product_create=$rs[0]->product_create;

}
	
?>

<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/product" class="btn btn-info"><i class="fa fa-undo"></i> กลับ</a>
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
				<form class="form-horizontal" method="post" role="form" id="frm_content">
					<div class="form-body">
						
						<div class="form-group">
							<label class="col-md-2 control-label">ชื่อสินค้า</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="product_name" id="product_name" title="ชื่อสินค้า" required value="<?=$product_name?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">รายละเอียด</label>
							<div class="col-md-10">
								<textarea class="summernote" name="product_txt"><?=$product_txt?></textarea>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-2 control-label">รูปภาพ</label>
							<div class="col-md-10">
								<?php if(!empty($product_img)){ ?>
										<div id="image_cover_show">
											<img src="<?=base_url()?>uploads/images/<?=$product_img?>" style="max-width:100%;max-height:250px;"><br/>
											<button type="button" id="remove_image_cover" class="btn btn-default btn-sm" style="margin-top:10px;">
											<i class="fa fa-trash-o"></i> Remove Image</button>
										</div>
								<?php	} ?>
								<div id="dropzone" name="product_img" class="dropzone" <?php if(!empty($product_img)){echo 'style="display:none;"';}?>></div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">สถานะการแสดง</label>
							<div class="col-md-10">
								<div class="radio-list">
									<label class="radio-inline">
									<input type="radio" name="product_status" value="1" <?=$product_status==1?'checked':''?> <?=$product_status==''?'checked':''?>> แสดง </label>
									<label class="radio-inline">
									<input type="radio" name="product_status" value="0" <?=$product_status==0?'checked':''?> > ซ่อน </label>	
								</div>
							</div>
						</div>
					</div>
					
					<div class="form-actions fluid">
						<div class="col-md-offset-2 col-md-10">
							<input type="hidden" name="h_image" id="h_image" value="<?=$product_img?>">
							<input type="hidden" name="product_id" id="product_id" value="<?=$product_id?>">
							<input type="hidden" name="product_create" id="product_create" value="<?=$product_create?>">
							<button type="submit" id="btn_submit" class="btn btn-primary">บันทึก</button>
							<a href="javascript:history.back()" class="btn btn-default">ยกเลิก</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
