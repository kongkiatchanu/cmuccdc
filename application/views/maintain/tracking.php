	<style>.form-filler{border-top:5px solid #0c364c;padding:0 15px;background-color:#f8f8f8}.display-hide{display:none;}
	.steps .step {
    display: block;
    width: 100%;
    margin-bottom: 35px;
    text-align: center
}

.steps .step .step-icon-wrap {
    display: block;
    position: relative;
    width: 100%;
    height: 80px;
    text-align: center
}

.steps .step .step-icon-wrap::before,
.steps .step .step-icon-wrap::after {
    display: block;
    position: absolute;
    top: 50%;
    width: 50%;
    height: 3px;
    margin-top: -1px;
    background-color: #e1e7ec;
    content: '';
    z-index: 1
}

.steps .step .step-icon-wrap::before {
    left: 0
}

.steps .step .step-icon-wrap::after {
    right: 0
}

.steps .step .step-icon {
    display: inline-block;
    position: relative;
    width: 80px;
    height: 80px;
    border: 1px solid #e1e7ec;
    border-radius: 50%;
    background-color: #f5f5f5;
    color: #374250;
    font-size: 38px;
    line-height: 81px;
    z-index: 5
}

.steps .step .step-title {
    margin-top: 16px;
    margin-bottom: 0;
    color: #606975;
    font-size: 14px;
    font-weight: 500
}

.steps .step:first-child .step-icon-wrap::before {
    display: none
}

.steps .step:last-child .step-icon-wrap::after {
    display: none
}

.steps .step.completed .step-icon-wrap::before,
.steps .step.completed .step-icon-wrap::after {
    background-color: #0da9ef
}

.steps .step.completed .step-icon {
    border-color: #0da9ef;
    background-color: #0da9ef;
    color: #fff
}

@media (max-width: 576px) {
    .flex-sm-nowrap .step .step-icon-wrap::before,
    .flex-sm-nowrap .step .step-icon-wrap::after {
        display: none
    }
}

@media (max-width: 768px) {
    .flex-md-nowrap .step .step-icon-wrap::before,
    .flex-md-nowrap .step .step-icon-wrap::after {
        display: none
    }
}

@media (max-width: 991px) {
    .flex-lg-nowrap .step .step-icon-wrap::before,
    .flex-lg-nowrap .step .step-icon-wrap::after {
        display: none
    }
}

@media (max-width: 1200px) {
    .flex-xl-nowrap .step .step-icon-wrap::before,
    .flex-xl-nowrap .step .step-icon-wrap::after {
        display: none
    }
}

.bg-faded, .bg-secondary {
    background-color: #f5f5f5 !important;
}
	</style>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
	<div class="container mb-5">
		
		<div class="row mt-3">
			<div class="col-12">
				<nav aria-label="breadcrumb">
				  <ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?=base_url('maintain')?>">หน้าหลัก</a></li>
					<li class="breadcrumb-item active" aria-current="page">tracking</li>
				  </ol>
				</nav>
			</div>
		</div>
		
		
		<?php if($rsEngine){?>
		<div class="row mt-3 mb-3">
			<div class="col-md-12">
				<div class="form-filler pt-3 pb-5" style="background: white url(/template/img/bg.jpg) no-repeat bottom;">
					<div class="card mb-5" style="opacity:.9">
						<div class="card-body">
						
							<div class="mb-3">
								<h4><?=$rsEngine[0]->location_name?></h4>
								<p><?=$rsEngine[0]->location_name_en?></p>
							</div>
							<div class="d-flex flex-wrap flex-sm-nowrap justify-content-between py-3 px-2 bg-secondary mb-3">
								<div class="w-100 text-center py-1 px-2"><span class="text-medium">เว็บไอดี:</span> <?=$this->uri->segment(3)?></div>
								<div class="w-100 text-center py-1 px-2"><span class="text-medium">รหัสเครื่อง:</span> <?=$rsEngine[0]->location_id?></div>
								<div class="w-100 text-center py-1 px-2"><span class="text-medium">โมเดล :</span> <?=$rsEngine[0]->db_model?></div>
							</div>
							
							<?php if($rsEngine[0]->db_status==1){?>
							<div class="steps d-flex flex-wrap flex-sm-nowrap justify-content-between padding-top-2x padding-bottom-1x">
							  <div class="step <?=$rsEngine[0]->db_status_fixed>=1?'completed':''?>">
								<div class="step-icon-wrap">
								  <div class="step-icon"><i class="far fa-bell"></i></div>
								</div>
								<h4 class="step-title">แจ้งซ่อม</h4>
							  </div>
							  <div class="step <?=$rsEngine[0]->db_status_fixed>=2?'completed':''?>">
								<div class="step-icon-wrap">
								  <div class="step-icon"><i class="fas fa-people-carry"></i></div>
								</div>
								<h4 class="step-title">รับเครื่อง</h4>
							  </div>
							  <div class="step <?=$rsEngine[0]->db_status_fixed>=3?'completed':''?>">
								<div class="step-icon-wrap">
								  <div class="step-icon"><i class="fas fa-tools"></i></div>
								</div>
								<h4 class="step-title">ซ่อมบำรุง</h4>
							  </div>
							  <div class="step <?=$rsEngine[0]->db_status_fixed>=4?'completed':''?>">
								<div class="step-icon-wrap">
								  <div class="step-icon"><i class="fas fa-quidditch"></i></div>
								</div>
								<h4 class="step-title">ทดสอบ</h4>
							  </div>
							   <div class="step <?=$rsEngine[0]->db_status_fixed>=5?'completed':''?>">
								<div class="step-icon-wrap">
								  <div class="step-icon"><i class="far fa-thumbs-up"></i></div>
								</div>
								<h4 class="step-title">ขนส่ง/ส่งคืน</h4>
							  </div>
							</div>
							<?php }else if($rsEngine[0]->db_status==2){?>
							<!--ติดตั้ง-->
							<div class="steps d-flex flex-wrap flex-sm-nowrap justify-content-between padding-top-2x padding-bottom-1x">
							  <div class="step <?=$rsEngine[0]->db_status_install>=1?'completed':''?>">
								<div class="step-icon-wrap">
								  <div class="step-icon"><i class="fas fa-tools"></i></div>
								</div>
								<h4 class="step-title">ผลิตเครื่อง</h4>
							  </div>
							  <div class="step <?=$rsEngine[0]->db_status_install>=2?'completed':''?>">
								<div class="step-icon-wrap">
								  <div class="step-icon"><i class="fas fa-tools"></i></div>
								</div>
								<h4 class="step-title">ทดสอบ</h4>
							  </div>
							  <div class="step <?=$rsEngine[0]->db_status_install>=3?'completed':''?>">
								<div class="step-icon-wrap">
								  <div class="step-icon"><i class="fas fa-shuttle-van"></i></div>
								</div>
								<h4 class="step-title">ขนส่ง</h4>
							  </div>
							  <div class="step <?=$rsEngine[0]->db_status_install>=4?'completed':''?>">
								<div class="step-icon-wrap">
								  <div class="step-icon"><i class="far fa-thumbs-up"></i></div>
								</div>
								<h4 class="step-title">ออนไลน์</h4>
							  </div>
							</div>
							<p>
								<a href="<?=base_url('maintain/lists')?>" class="btn btn-info btn-sm">เครือข่ายอาสา DustBoy</a>
								<a href="<?=base_url('guide')?>" class="btn btn-info btn-sm" target="_blank">การติดตั้ง DustBoy</a>
							</p>
							<?php }else{?>
								<p class="text-center">ยังไม่มีข้อมูล</p>
							<?php }?>
						</div>
						
					</div>
					
					
				</div>
			</div>
		</div>
		<?php }else{ echo '<p class="text-center">ไม่พบข้อมูล</p>';}?>
	</div>
	