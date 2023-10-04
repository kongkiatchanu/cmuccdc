<?php 
	$id="";
	$ques="";
	$is_show="";
    $created_on=date('Y-m-d H:i:s');
	if($rs!=null){
	$id=$rs[0]->id;
	$ques=$rs[0]->ques;
	$is_show=$rs[0]->is_show;
    $created_on=$rs[0]->created_on;
	}

?>

<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/poll" class="btn btn-info"><i class="fa fa-undo"></i> กลับ</a>
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
						
						<div class="form-group">
							<label class="col-md-2 control-label">หัวข้อแบบสำรวจ</label>
							<div class="col-md-10">
                                <textarea name="ques" id="ques" class="form-control" rows="5"><?=$ques?></textarea>
							</div>
						</div>

						<div id="fList">
							<div class="form-group">
								<label class="col-md-2 control-label">ตัวเลือก</label>
								<div class="col-md-10">
									<button type="button" id="btnAddOption" class="btn btn-primary btn-success">
										<i class="fa fa-plus"></i>
									</button>
								</div>
							</div>
						</div>
						<input type="hidden" id="countOptions" value="<?=count($rs)?>">
						<?php if($rs!=null){?>
						<?php foreach($rs as $k=>$v){?>
							<div class="container-option">
								<div class="form-group">
									<div class="col-md-2"><a href="<?=base_url()?>admin/poll/deloption/<?=$v->option_id?>/<?=$v->id?>" onClick="return confirm('Delete Comfirm ?');" class="btn btn-small btn-danger btn-del" style="float:right;"><i class="glyphicon glyphicon-minus"></i></a></div>
									<div class="col-md-10">
										<input type="text" name="option[<?=$v->option_id?>]" class="form-control" placeholder="รายการ" required value="<?=$v->value?>">
									</div>
								</div>	
							</div>
						<?php }?>
						<?php }?>

                        <div class="form-group">
							<label class="control-label col-md-2">สถานะการแสดง</label>
							<div class="col-md-10">
								<input name="is_show" value="0" type="hidden">
                                <label class="control-label">
								<input id="is_show" name="is_show" type="checkbox" class="form-control tags" value="1" <?=$is_show==1?'checked':''?>> แสดง</label>
							</div>
						</div>

						
					</div>
					
					<div class="form-actions fluid">
						<div class="col-md-offset-2 col-md-10">
                            <input type="hidden" name="created_on" id="created_on" value="<?=$created_on?>">
                            <input type="hidden" name="id" id="id" value="<?=$id?>">
							<button type="submit" id="btn_submit" class="btn btn-primary">บันทึก</button>
							<a href="javascript:history.back()" class="btn btn-default">ยกเลิก</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
