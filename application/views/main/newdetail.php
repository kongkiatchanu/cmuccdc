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
							<img src="<?=base_url()?>uploads/timthumb.php?src=<?=base_url()?>uploads/images/<?=$rs[0]['content_thumbnail']?>&w=740&h=390" class="img-fluid">
						</div>
						<i class="fa fa-calendar"></i> <?=ConvertToThaiDate($rs[0]['content_public'],1)?>
						<!--<p><?=str_replace('<img src="/uploads/','<img src="'.$this->config->item("base_api").'uploads/',$rs[0]['content_full_description'])?></p>-->
						<p><?=$rs[0]['content_full_description']?></p>
						<?php if($rs[0]['content_file']!=null){?>
						<div class="clearfix">
							<h4>เอกสารแนบ</h4>
							<ul id="cat-list" class="list-unstyled">
							<?php foreach($rs[0]['content_file'] as $file){?>
								<li><a target="_blank" href="<?=$this->config->item('base_api')?>uploads/docs/<?=$file->file_path?>"><?=$file->file_name?></a></li>
							<?php }?>
							</ul>	
						</div>
						<?php }?>
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
		
		
	
