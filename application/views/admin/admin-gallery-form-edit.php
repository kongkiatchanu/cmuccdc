<?php 
$gallery_id="";
$gallery_name="";
$gallery_thumbnail="";
$gallery_description="";
$gallery_status="";
$gallery_create=date('Y-m-d H:i:s');
if($rs!=null){
$gallery_id=$rs[0]->gallery_id;
$gallery_name=$rs[0]->gallery_name;
$gallery_thumbnail=$rs[0]->gallery_thumbnail;
$gallery_description=$rs[0]->gallery_description;
$gallery_status=$rs[0]->gallery_status;
$gallery_create=$rs[0]->gallery_create;
}
?>
<style>
.frm-body{padding:30px;}
	
.fileUpload {
    position: relative;
    overflow: hidden;
    margin: 10px;
}
.fileUpload input.upload {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0);
}
#result{margin-top:10px;}.thumbnail{margin-bottom: 10px;}.box-thumbnail{position: relative;}.effect{position: absolute;left: 23px;top: 4px;}
</style>
<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/gallery/" class="btn btn-info"><i class="fa fa-undo"></i> กลับ</a>
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
				<form class="form-horizontal" method="post" role="form" id="frm_content" enctype="multipart/form-data">
					<div class="form-body">
						<ul class="nav nav-tabs">
							<li><a href="#tab1" data-toggle="tab">ข้อมูลทั่วไป</a></li>
							<li class="active"><a href="#tab2" data-toggle="tab">รูปภาพ</a> </li>
							
						</ul>
						<div class="tab-content">
							<div class="tab-pane fade" id="tab1">
								<div class="form-group">
									<label class="col-md-2 control-label">ชื่ออัลบั้ม</label>
									<div class="col-md-10">
										<input type="text" class="form-control" name="gallery_name" id="gallery_name" title="Gallery Name" required value="<?=$gallery_name?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">ภาพทัมเนล</label>
									<div class="col-md-10">
										<?php if(!empty($gallery_thumbnail)){ ?>
												<div id="image_cover_show">
													<img src="<?=base_url()?>uploads/images/<?=$gallery_thumbnail?>" style="max-width:100%;max-height:250px;"><br/>
													<button type="button" id="remove_image_cover" class="btn btn-default btn-sm" style="margin-top:10px;">
													<i class="fa fa-trash-o"></i> Remove Image</button>
												</div>
										<?php	} ?>

										<div id="dropzone" name="gallery_thumbnail" class="dropzone" <?php if(!empty($gallery_thumbnail)){echo 'style="display:none;"';}?>></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">คำอธิบาย</label>
									<div class="col-md-10">
										<div id="summernote"></div>
										<textarea class="summernote" name="gallery_description" style="display: none;"><?=$gallery_description?></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">สถานะการแสดง</label>
									<div class="col-md-10">
										<div class="radio-list">
											<label class="radio-inline">
											<input type="radio" name="gallery_status" value="1" <?=$gallery_status==1?'checked':''?> <?=$gallery_status==''?'checked':''?>> แสดง </label>
											<label class="radio-inline">
											<input type="radio" name="gallery_status" value="0" <?=$gallery_status==0?'checked':''?> > ซ่อน </label>	
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane fade active in" id="tab2">
								<div class="fileUpload btn btn-primary">
									<span>เลือกไฟล์ภาพ</span>
									<input type="file" class="upload" id="photoimg" name="photos[]" multiple="true">
								</div>
								<div class="row">
									<div id="result">
										<?php if($rsDetail!=null){?>
										<?php $i=0;foreach ($rsDetail as $key => $value) {$i++;?>  
											<div class="col-md-3 box-thumbnail" id="data-block-id-<?=$value->img_id?>">
												<div class="effect" del="<?=$value->img_id?>">
													<a class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> ลบภาพ</a>
												</div>
												<img class="img-responsive img-thumbnail thumbnail" src="<?=base_url()?>uploads/gallery/<?=$value->gallery_filename?>">
											</div>	
											<?php 
											if($i%4==0){
												echo '<div class="clearfix"></div>';
											}	
											?>
										<?php }?>
										
										<?php } ?>				
									</div>
								</div>
							</div>
						</div>
						
						
						
					</div>
					
					<div class="form-actions fluid">
						<div class="col-md-offset-2 col-md-10">
							<input type="hidden" name="gallery_create" id="gallery_create" value="<?=$gallery_create?>">
							<input type="hidden" name="gallery_id" id="gallery_id" value="<?=$gallery_id?>">
							<input type="hidden" name="h_image" id="h_image" value="<?=$gallery_thumbnail?>">
							<button type="submit" id="btn_submit" class="btn btn-primary">บันทึก</button>
							<a href="javascript:history.back()" class="btn btn-default">ยกเลิก</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function() { 
		
		$(".effect").on("click",function(){
			if (confirm('Confirm Delete photo.....')) {
				var del_id = $(this).attr("del");
					$.ajax({
						type: "POST",
						url: "<?=base_url()?>assets/plugins/php/ajax_update_album.php",
						data: "do=delete&abid=<?=$gallery_id?>&del_id="+del_id+"&_time="+Math.random(),
						dataType: "html",
						success: function(html){
							console.log(html)
							$( "#data-block-id-"+del_id+"" ).hide();
						}
						
				});
				
			}
		});
		
			window.onload = function(){
				//Check File API support
				if(window.File && window.FileList && window.FileReader)
				{
					var filesInput = document.getElementById("photoimg");
					
					filesInput.addEventListener("change", function(event){
						
						var photoimg = event.target.files; //FileList object
						var output = document.getElementById("result");
						
						for(var i = 0; i< photoimg.length; i++)
						{
							var file = photoimg[i];
							
							//Only pics
							if(!file.type.match('image'))
							  continue;
							
							var picReader = new FileReader();
							
							picReader.addEventListener("load",function(event){
								
								var picFile = event.target;
								
								var div = document.createElement("div");
								
								div.innerHTML = "<div class='col-lg-2 col-md-3 col-sm-3 box-thumbnail'><img class='img-responsive img-thumbnail thumbnail' src='" + picFile.result + "'" +"title='" + picFile.name + "'/></div>";
								
								output.insertBefore(div,null);            
							
							});
							
							 //Read the image
							picReader.readAsDataURL(file);
						}                               
					   
					});
				}
				else
				{
					console.log("Your browser does not support File API");
				}
			}
	});
</script>


