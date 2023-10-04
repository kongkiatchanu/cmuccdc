<?php 
	$id_section=1;
$category_name="";
$category_parent="";
$id_category="";
if($rs!=null){
$category_name=$rs[0]->category_name;
$category_parent=$rs[0]->idparent;
$id_category=$rs[0]->id_category;
}
	
?>

<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/category/" class="btn btn-info"><i class="fa fa-undo"></i> กลับ</a>
			</div>
		</div>
		<hr/>
		<div class="row">
			<div class="col-md-12">
				<form class="form-horizontal" method="post" role="form" id="web_info">
					<div class="form-body">
						<!--<div class="form-group">
							<label class="col-md-3 control-label">Section</label>
							<div class="col-md-9">
								<select class="form-control" name="id_section" id="id_section" title="Section" required readonly>
									<option value=""> - select section - </option>
									<?php  foreach ($section as $key => $value) {?>  
										   <option value="<?=$value->id_section?>"> <?=$value->section_name?> </option> 
									<?php } ?>
								</select>
							</div>
						</div>-->
						<div class="form-group">
							<label class="col-md-3 control-label">Name</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="category_name" id="category_name" title="Category Name" required value="<?=$category_name?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Parent</label>
							<div class="col-md-9">
								<select class="form-control" name="category_parent" id="category_parent" title="category parent">
									<option value=""> - select parrent - </option>
									<?php  foreach ($category as $key => $value) {?>  
										<?php if($value->id_section==$id_section){?>
										   <option value="<?=$value->id_category?>" <?=$category_parent==$value->id_category?'selected':''?>> <?=$value->category_name?> </option> 
										<?php }?>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					
					<div class="form-actions fluid">
						<div class="col-md-offset-2 col-md-10">
							<input type="hidden" name="id_section" id="id_section" value="<?=$id_section?>">
							<input type="hidden" name="id_category" id="id_category" value="<?=$id_category?>">
							<button type="submit" id="btn_submit" class="btn btn-primary">บันทึก</button>
							<a href="javascript:history.back()" class="btn btn-default">ยกเลิก</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>