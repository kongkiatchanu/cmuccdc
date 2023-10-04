
<div class="main-header row">
    <div class="col-12 col-md-6">
        <label class="title"><?=$pagename?></label>
    </div>
    <div class="col-12 col-md-6">
        <div class="controller">
            <a href="<?=base_url()?>admin2/maintain_setup/" class="btn btn-custom-sm btn-bg-color">
                <i class="fas fa-undo"></i> ย้อนกลับ
            </a>
        </div>
    </div>
</div>
<div class="main-body row">
    <div class="col-12">
		<h5><?=$rs[0]->dustboy_name?></h5>
		<p>รหัสเครื่อง : <?=$rs[0]->dustboy_code?></p>
		<p>ชื่อผู้ประสาน : <?=$rs[0]->dustboy_co_name?></p>
		<p>หมายเลขโทรศัพท์ : <?=$rs[0]->dustboy_co_tel?></p>
		<p>การเชื่อมต่อ : <?=$rs[0]->dustboy_type?></p>
		<p>รูปภาพ</p>
		<div class="row">
			<div class="col-md-3"><img src="/uploads/requests/<?=$rs[0]->dustboy_img_1?>" class="img-fluid"><p class="text-center">ความสูง 1.5 เมตร</p></div>
			<div class="col-md-3"><img src="/uploads/requests/<?=$rs[0]->dustboy_img_2?>" class="img-fluid"><p class="text-center">ด้านขวา</p></div>
			<div class="col-md-3"><img src="/uploads/requests/<?=$rs[0]->dustboy_img_3?>" class="img-fluid"><p class="text-center">ด้านซ้าย</p></div>
			<div class="col-md-3"><img src="/uploads/requests/<?=$rs[0]->dustboy_img_4?>" class="img-fluid"><p class="text-center">ด้านหน้า</p></div>
		</div>
		


	</div>
</div>