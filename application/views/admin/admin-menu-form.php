<?php
	$idmenu = "";
	$idpage = "";
	$menu_label = "";
	$menu_order = "";
	$menu_parent = "";
	$menu_link = "";
	
	if($rs != null){
		foreach($rs as $key => $row)
		{
			$idmenu = $row->idmenu;
			$idpage = $row->idpage;
			$menu_label = $row->menu_label;
			$menu_order = $row->menu_order;
			$menu_parent = $row->menu_parent;
			$menu_link = $row->menu_link;
		}
	}
?>

<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/menu/" class="btn btn-info"><i class="fa fa-undo"></i> กลับ</a>
			</div>
		</div>
		<hr/>
		<div class="row">
			<div class="col-md-12">
				<form class="form-horizontal" method="post" role="form" id="web_menu">
					<div class="form-body">
						<div class="form-group">
							<label class="col-md-3 control-label">Page</label>
							<div class="col-md-9">
								<select class="form-control" name="idpage" id="idpage" title="content">
									<option value=""> - select Content - </option>
									<?php  foreach ($rs_page as $key => $value) {?>  
										   <option value="<?=$value->idpage?>" <?=$idpage==$value->idpage?'selected':''?> > <?=$value->page_title?> </option> 
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Menu Name</label>
							<div class="col-md-9">
								<input type="text" maxlength="100" class="form-control" name="menu_label" id="menu_label" title="menu label" required value="<?=$menu_label?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Parent</label>
							<div class="col-md-9">
								<select class="form-control" name="menu_parent" id="menu_parent" title="Parent">
									<option value=""> - select Parent - </option>
									<?php  foreach ($rs_menu as $key => $value) {?>  
										   <option value="<?=$value->idmenu?>" <?=$menu_parent==$value->idmenu?'selected':''?> > <?=$value->menu_label?> </option> 
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Order</label>
							<div class="col-md-9">
								<input type="number" maxlength="3" class="form-control" name="menu_order" id="menu_order" title="menu order" value="<?=$menu_order?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Link</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="menu_link" id="menu_link" title="menu link" value="<?=$menu_link?>">
							</div>
						</div>
					</div>
					
					<div class="form-actions fluid">
						<div class="col-md-offset-2 col-md-10">
							<input type="hidden" name="idmenu" id="idmenu" value="<?=$idmenu?>">
							<button type="submit" id="btn_submit" class="btn btn-primary">บันทึก</button>
							<a href="javascript:history.back()" class="btn btn-default">ยกเลิก</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


