		<style>
		#cat-list a{color:#333;text-decoration: none;}
		#cat-list a:hover{color:#99bf3d;}
		.ccdc_content img{max-width:100%}
		</style>
		<div class="container">
			
			
			<div class="row mt-3 mb-3">
				<div class="col-md-8">
					<div class="ccdc_content">
						<div class="mb-2">
							<p><iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $rs[0]['yt_id'];?>?autoplay=1" frameborder="0" allowfullscreen=""></iframe></p>
						</div>
						<i class="fa fa-calendar"></i> <?=ConvertToThaiDate($rs[0]['yt_datetime'],1)?>
						<p><?=str_replace('<img src="/uploads/','<img src="'.$this->config->item("base_api").'uploads/',$rs[0]['yt_detail'])?></p>
						<div class="clearfix">
							<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
								<a class="addthis_button_facebook"></a>
								<a class="addthis_button_twitter"></a>
								<a class="addthis_button_email"></a>
								<a class="addthis_button_linkedin"></a>
								<a class="addthis_button_compact"></a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<h3>หมวดหมู่</h3>
					<ul id="cat-list" class="list-unstyled">
						<li><a href="<?=base_url('news/category/effect')?>"><?=$ar_title['effect']?></a></li>
						<li><a href="<?=base_url('news/category/activities')?>"><?=$ar_title['activities']?></a></li>
						<li><a href="<?=base_url('news/category/message')?>"><?=$ar_title['message']?></a></li>
						<li><a href="<?=base_url('news/category/information')?>"><?=$ar_title['information']?></a></li>
						<li><a href="<?=base_url('news/category/video')?>"><?=$ar_title['video']?></a></li>
					</ul>
				</div>
			</div>
		</div>
		 <script type="text/javascript" src="https://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4fdc05233895bf13"></script>
		
		
	
