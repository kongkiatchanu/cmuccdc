<div class="container-getQuotationFile">
	<div class="form-group row">
		<div class="col-md-2"><a href="javascript:void(0)" id="btn-delListFile" class="btn btn-small btn-danger btn-del" style="float:right;"><i class="fa fa-times"></i></a></div>
		<div class="col-md-10">
			<div style="position:relative;margin-bottom:10px;">
				<a class='btn btn-primary' href='javascript:;'>
					เลือกไฟล์...
					<input type="file" name="content_file[]" style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;' name="file_source" size="40"  onchange='$("#upload-file-info-<?=$_GET['count']?>").html($(this).val());'>
				</a>
				&nbsp;
				<span class='label label-info' id="upload-file-info-<?=$_GET['count']?>"></span>
			</div>
		</div>
	</div>	
</div>
