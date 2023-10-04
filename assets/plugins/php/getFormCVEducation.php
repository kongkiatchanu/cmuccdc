<div class="container-edu">
	<div class="form-group row">
		<label class="control-label col-md-1"><a href="javascript:void(0)" id="del-List" class="btn btn-small btn-danger btn-del" style="float:right;"><i class="fa fa-trash"></i></a></label>
		<div class="col-md-2 col-sm-6 col-6 mb-1">
			<input type="number" name="edu_year[<?=$_GET['count']?>]" class="form-control" placeholder="ปีการศึกษา" maxlength="4" required>
		</div>
		<div class="col-md-2 col-sm-6 col-6 mb-1">
			<input type="text" name="edu_class[<?=$_GET['count']?>]" class="form-control" placeholder="ระดับชั้น" required>
		</div>
		<div class="col-md-5 mb-1">
			<input type="text" name="edu_form[<?=$_GET['count']?>]" class="form-control" placeholder="สถานบัน" required>
		</div>
		<div class="col-md-2 col-sm-6 col-6 mb-1">
			<input type="text" name="edu_gpa[<?=$_GET['count']?>]" class="form-control" placeholder="เกรดเฉลี่ย">
		</div>
		<input type="hidden" name="edu_id[<?=$_GET['count']?>]">
	</div>
</div>