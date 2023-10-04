		<style>

		</style>
		
		<div class="container">
			<div class="row mt-3 mb-3">
				<?php foreach($rsPartner as $item){?>
					<div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-3">
					<?php if($item->link_url!='' || $item->link_url!='#'){?>
						<a href="<?=$item->link_url?>" target="_blank">
					<?php }?>
						<img src="<?=$this->config->item('base_api')?>uploads/images/<?=$item->link_image?>" alt="<?=$item->link_name?>" class="img-fluid">
					<?php if($item->link_url!='' || $item->link_url!='#'){?></a><?php }?>
					</div>
				<?php }?>
			</div>
		</div>

		<script>
        $( document ).ready(function() {
			
		});
		</script>
		
