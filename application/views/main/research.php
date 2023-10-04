		<style>
		.research_list{margin-bottom:30px;border-bottom: 1px solid #eee;padding-bottom: 30px;}
		.research_list {display:none;}
		.research_list a{color:#99bf3d;text-decoration: none;}
		.research_list a h3{font-size:20px;}
		
		</style>
		<div class="container">
		<!--
			<div class="row mt-3 mb-3">
				<div class="col-12">
					<form id="frm_filter" class="form-inline">
						<label class="sr-only" for="inlineFormInputGroup">Title</label>
						<input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0 ui-autocomplete-input" id="s_title" name="s_title" placeholder="Title" autocomplete="off">
						<label class="sr-only" for="inlineFormInputGroup">Journal title</label>
						<input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0 ui-autocomplete-input" id="s_journal" name="s_journal" placeholder="Journal" autocomplete="off">
						<label class="sr-only" for="inlineFormInput">Keywords</label>
						<input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0 ui-autocomplete-input" id="s_keywords" name="s_keywords" placeholder="Keywords" autocomplete="off">
						<label class="sr-only" for="inlineFormInputGroup">Author name</label>
						<input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0 ui-autocomplete-input" id="s_author" name="s_author" placeholder="Author name" autocomplete="off">
						<button type="submit" class="btn btn-primary">Search</button>
					</form>
				</div>
			</div>
			<hr/>-->
			<div class="row mt-3 mb-3" id="research_feed">
				<?php foreach($rsResearch as $item){?>
					<div class="col-md-12 research_list">
				
						<a href="<?=base_url('research/'.$item->article_id)?>"><h3><?=$item->article_title?></h3></a>
						<p class="mb-0"><?=$item->article_journal?></p>
						<p class="mb-0"><?=$item->article_author?></p>
						<p class="mb-0"><?=$item->article_keyword?></p>
						
					</div>
				<?php }?>
			</div>
			
			<div class="row mb-5">
				<div class="col-md-12 text-center">
					<a href="#" class="research_more btn btn-info"><i class="fas fa-sync"></i> ดูเพิ่มเติม</a>
				</div>
			</div>
			
		</div>

	
