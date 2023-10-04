<div class="main-header row">
    <div class="col-12 col-md-6">
        <label class="title"><?=$pagename?></label>
    </div>
    <div class="col-12 col-md-6">
        <div class="controller">
            <a href="<?=base_url()?>admin2/contact/" class="btn btn-custom-sm btn-bg-color">
                <i class="fas fa-undo"></i> ย้อนกลับ
            </a>
        </div>
    </div>
</div>
<div class="main-body row">
    <div class="col-12 col-md-10 offset-md-1">
		<div class="alert-base-color">
			<h2><i class="fa fa-comment" style="font-size:20px;"></i> <?=$rs[0]->contact_subject?>::</h2>
			<p><strong>รายละเอียด : </strong><p>
			<p><?=$rs[0]->contact_message?><p><br/>
			
			<p><strong>ชื่อผู้ติดต่อ : </strong><?=$rs[0]->contact_name?><p>
			<p><strong>อีเมล์ : </strong><?=$rs[0]->contact_email?><p>
			<p><strong>เวลา : </strong><?=$rs[0]->thaidate?><p>
			<p><a href="mailto:<?=$rs[0]->contact_email?>" class="btn btn-bg-color btn-custom-sm"><i class="fas fa-reply"></i> ตอบกลับ</a></p>
		</div>
    </div>
</div>


