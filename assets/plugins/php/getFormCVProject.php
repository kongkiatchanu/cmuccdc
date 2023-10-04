<div class="container-pro">
	
	<div class="form-group row">
		<label class="control-label col-md-1"><a href="javascript:void(0)" id="del-List" class="btn btn-small btn-danger btn-del" style="float:right;"><i class="fa fa-trash"></i></a></label>
		<div class="col-md-2 col-sm-6 col-6 mb-1">
			<input type="number" name="project_year[<?=$_GET['count']?>]" class="form-control" placeholder="ปีการศึกษา" maxlength="4" required>
		</div>
		<div class="col-md-9 mb-1">
			<input type="text" name="project_name[<?=$_GET['count']?>]" class="form-control" placeholder="ชื่อผลงาน" required>
		</div>	
		<input type="hidden" name="project_id[<?=$_GET['count']?>]">
	</div>
</div>