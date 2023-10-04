	<style>.form-filler{border-top:5px solid #0c364c;padding:20px 15px;background-color:#f8f8f8}.display-hide{display:none;}</style>
	<style>
	.engine_list{
		
	}
	.engine_list a{color: #333;}
	.engine_list a:hover {text-decoration: none;color: #999;}
	</style>
	<div class="container mb-5">
		
		
		<?php if($rsEngine){?>
		<div class="row mt-3 mb-3">
			<div class="col-md-12">
				<div class="form-filler">
		<?php 
		$rsData = json_decode($rsEngine[0]->engine_obj);
		echo '<pre>';
		print_r($rsData);
		echo '</pre>';
		
		
		?>
		</div>
		</div>
		</div>
		<?php }else{ echo '<p class="text-center">ไม่พบข้อมูล</p>';}?>
	</div>
	