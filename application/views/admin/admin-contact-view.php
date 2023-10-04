<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/contact/" class="btn btn-info"><i class="fa fa-undo"></i> กลับ</a>
			</div>
		</div>
		<hr/>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
			
				<h2><i class="fa fa-comment" style="font-size:20px;"></i> <?=$rs[0]->contact_subject?>::</h2>
				<p><strong>รายละเอียด : </strong><p>
				<p><?=$rs[0]->contact_message?><p><br/>
				
				<p><strong>ชื่อผู้ติดต่อ : </strong><?=$rs[0]->contact_name?><p>
				<p><strong>อีเมล์ : </strong><?=$rs[0]->contact_email?><p>
				<p><strong>เวลา : </strong><?=$rs[0]->thaidate?><p>
				<p><a href="mailto:<?=$rs[0]->contact_email?>" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i> ตอบกลับ</a></p>
			</div>
		</div>
	</div>
</div>


