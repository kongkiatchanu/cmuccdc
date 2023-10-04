<?php 
    $paper_id=null;
    $paper_no="";
    $paper_date="";
    $paper_from="";
    $category_parent="";
    $paper_topic="";
    $paper_amout="";
    $paper_addr="";
    $paper_file="";
    $createdate=date('Y-m-d H:i:s');
    if($rs!=null){
        $paper_id=$rs[0]->paper_id;
        $paper_no=$rs[0]->paper_no;
        $paper_date=$rs[0]->paper_date;
        $paper_from=$rs[0]->paper_from;
        $category_parent=$rs[0]->category_parent;
        $paper_topic=$rs[0]->paper_topic;
        $paper_amout=$rs[0]->paper_amout;
        $paper_addr=$rs[0]->paper_addr;
        $paper_file=$rs[0]->paper_file;
        $createdate=$rs[0]->createdate;
    }
?>

<div class="main-header row">
    <div class="col-12 col-md-6">
        <label class="title"><?=$pagename?></label>
    </div>
    <div class="col-12 col-md-6">
        <div class="controller">
            <a href="<?=base_url()?>admin2/paper" class="btn btn-custom-sm btn-bg-color">
                <i class="fas fa-undo"></i> ย้อนกลับ
            </a>
        </div>
    </div>
</div>
<div class="main-body row">
    <div class="col-md-12 ">
        <form class="custom-form" method="post" role="form" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="content_title" class="col-sm-2 col-form-label">เลขที่หนังสือ</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="paper_no" name="paper_no" required value="<?=$paper_no?>">
				</div>
            </div>
			<div class="form-group row">
                <label for="content_title" class="col-sm-2 col-form-label">ลงวันที่</label>
				<div class="col-sm-4">
					<div class="input-group date form_datetime text-base-color" id="datetimepicker" data-target-input="nearest">
						<input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker" name="paper_date" value="<?=$paper_date?>"/>
						<div class="input-group-append" data-target="#datetimepicker" data-toggle="datetimepicker">
							<div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
						</div>
					</div>
					
				</div>
            </div>
			<div class="form-group row">
                <label for="content_title" class="col-sm-2 col-form-label">จากหน่วยงาน</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="paper_from" name="paper_from" required value="<?=$paper_from?>">
				</div>
            </div>
			<div class="form-group row">
                <label for="content_title" class="col-sm-2 col-form-label">เรื่อง</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="paper_topic" name="paper_topic" required value="<?=$paper_topic?>">
				</div>
            </div>
			<div class="form-group row">
                <label for="content_title" class="col-sm-2 col-form-label">จำนวน(เครื่อง)</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="paper_amout" name="paper_amout" required value="<?=$paper_amout?>">
				</div>
            </div>
			<div class="form-group row">
                <label for="content_title" class="col-sm-2 col-form-label">จุดติดตั้ง</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="paper_addr" name="paper_addr" required value="<?=$paper_addr?>">
				</div>
            </div>
			<div class="form-group row">
                <label for="content_title" class="col-sm-2 col-form-label">ไฟล์แนบ</label>
				<div class="col-sm-10">
					<div style="position:relative;margin-bottom:10px;">
						<a class='btn btn-primary' href='javascript:;'>
							เลือกไฟล์...
							<input type="file" name="paper_file" style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;' name="file_source" size="40"  onchange='$("#upload-file-info").html($(this).val());'>
						</a>
						&nbsp;
						<br/>
						<?php if($paper_file!=null){ echo '<a target="_blank" href="/uploads/docs/'.$paper_file.'">';}?>
						<span class='label label-info' id="upload-file-info"><?=$paper_file?></span>
						<?php if($paper_file!=null){ echo '</a>';}?>
					</div>
				</div>
            </div>


            <hr>
            <div class="form-group row">
				<div class="col-sm-10 offset-sm-2">
					<input type="hidden" name="paper_id" id="paper_id" value="<?=$paper_id?>">
					<button type="submit" id="btn_submit" class="btn btn-custom btn-bg-color">บันทึก</button>
					<a href="javascript:history.back()" class="btn btn-custom btn-base-color">ยกเลิก</a>
				</div>
            </div>
        </form>
    </div>
</div>