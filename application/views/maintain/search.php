	<style>.form-filler{border-top:5px solid #0c364c;padding:20px 15px;background-color:#f8f8f8}.display-hide{display:none;}</style>
	<style>
	.engine_list{
		
	}
	.engine_list a{color: #333;}
	.engine_list a:hover {text-decoration: none;color: #999;}
	</style>
	<div class="container mb-5">
		
		<div class="row mt-3">
			<div class="col-12">
				<nav aria-label="breadcrumb">
				  <ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?=base_url('maintain')?>">หน้าหลัก</a></li>
					<li class="breadcrumb-item active" aria-current="page">ค้นหา</li>
				  </ol>
				</nav>
			</div>
		</div>
		
		<?php $this->load->view('maintain/search_tools');?>
		
		<?php if($rsEngine){?>
		<div class="row mt-3 mb-3">
			<div class="col-md-12">
				<div class="form-filler">
					<p>ผลการค้นหาพบทั้งหมด <?=count($rsEngine)?> รายการ</p>
					<hr/>
					<?php foreach($rsEngine as $item){?>
						<div class="row">
							<div class="col-12">
								<div class="engine_list">
								<a href="/maintain/tracking/<?=$item->source_id?>">
									
									<h4><?=$item->location_name?></h4>
									<p><?=$item->location_name_en?><br/>id: <?=$item->source_id?></p>
								</a>
								</div>
							</div>
						</div>
						<hr/>
					<?php }?>
				</div>
			</div>
		</div>
		<?php }else{ echo '<p class="text-center">ไม่พบข้อมูล</p>';}?>
	</div>
	