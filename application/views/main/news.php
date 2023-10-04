		<style>.new-title{height:66px;overflow-y:hidden}.new-detail{height:100px;overflow-y:hidden}.news-contant h4{font-size:18px;font-weight:600;line-height:22px}#news-page-news-feed .news-slice{display:none}#news-page-news-feed .single-news-content{margin-bottom:30px}.single-news-content{border-radius:5px;-webkit-transition:all .3s ease 0s;transition:all .3s ease 0s}.news-thum{background-color:#ddd;background-position:center center;background-repeat:no-repeat;background-size:cover;border-radius:5px 5px 0 0;display:block;height:265px;opacity:.8;-webkit-transition:.3s;transition:.3s}.news-contant{background-color:#f8f8f8;border-radius:0 0 5px 5px;font-size:13px;line-height:1.9em;padding:25px 20px 35px;-webkit-transition:all .3s ease 0s;transition:all .3s ease 0s}.news-contant,.news-contant a,.news-contant h4{text-decoration: none;color:#616161;letter-spacing:.6px;-webkit-transition:.3s;transition:.3s}.new-title{height:66px;overflow-y:hidden}.news-meta{margin:10px 0 8px}.news-meta a{font-size:15px;font-weight:400}.alignright{float:right}</style>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="mb-3 mt-3">
						<a href="<?=base_url('news/category/effect')?>" class="btn btn-sm btn-secondary mb-1"><i class="fa fa-tags"></i> <?=$ar_title['effect']?></a>
						<a href="<?=base_url('news/category/activities')?>" class="btn btn-sm btn-secondary mb-1"><i class="fa fa-tags"></i> <?=$ar_title['activities']?></a>
						<a href="<?=base_url('news/category/message')?>" class="btn btn-sm btn-secondary mb-1"><i class="fa fa-tags"></i> <?=$ar_title['message']?></a>
						<a href="<?=base_url('news/category/information')?>" class="btn btn-sm btn-secondary mb-1"><i class="fa fa-tags"></i> <?=$ar_title['information']?></a>
						<a href="<?=base_url('news/category/video')?>" class="btn btn-sm btn-secondary mb-1"><i class="fa fa-tags"></i> <?=$ar_title['video']?></a>
					</div>
				</div>
			</div>
			
			<div class="row" id="news-page-news-feed">
				<?php $cat = $this->uri->segment(3)!=null ? getCategoryID($this->uri->segment(3)):null;?>
				<?php foreach($rsNews as $item){?>
				<?php if($cat!=null){?>
				<?php if($cat==$item->id_category){?>
				<div class="col-lg-4 col-md-6 news-slice">
                    <div class="single-news-content">
                        <a href="<?=base_url('newsdetail/'.$item->idcontent)?>" class="news-thum news-thumbg-1" style="background-image: url(<?=base_url()?>uploads/timthumb.php?src=<?=base_url()?>uploads/images/<?=$item->content_thumbnail?>&w=740&h=530);"></a>
                        <div class="news-contant">
							<div class="new-title">
								<h4><a href="<?=base_url('newsdetail/'.$item->idcontent)?>"><?=$item->content_title?></a></h4>
							</div>
                            <p class="news-meta">
                                <a href="<?=base_url('newsdetail/'.$item->idcontent)?>"><i class="fa fa-calendar"></i> <?=ConvertToThaiDate($item->content_public,1)?></a>
                                <a href="<?=base_url('newsdetail/'.$item->idcontent)?>" style="float: right;" class="alignright rd-btn">อ่านเพิ่ม <i class="fas fa-arrow-right"></i></a>
                            </p>
                        </div>
                    </div>
                </div>
				<?php }?>
				<?php }else{?>
				<div class="col-lg-4 col-md-6 news-slice">
                    <div class="single-news-content">
                        <a href="<?=base_url('newsdetail/'.$item->idcontent)?>" class="news-thum news-thumbg-1" style="background-image: url(<?=base_url()?>uploads/timthumb.php?src=<?=base_url()?>uploads/images/<?=$item->content_thumbnail?>&w=740&h=530);"></a>
                        <div class="news-contant">
							<div class="new-title">
								<h4><a href="<?=base_url('newsdetail/'.$item->idcontent)?>"><?=$item->content_title?></a></h4>
							</div>
                            <p class="news-meta">
                                <a href="<?=base_url('newsdetail/'.$item->idcontent)?>"><i class="fa fa-calendar"></i> <?=ConvertToThaiDate($item->content_public,1)?></a>
                                <a href="<?=base_url('newsdetail/'.$item->idcontent)?>" style="float: right;" class="alignright rd-btn">อ่านเพิ่ม <i class="fas fa-arrow-right"></i></a>
                            </p>
                        </div>
                    </div>
                </div>
				<?php }?>
				<?php }?>
			</div>
			
			<div class="row mb-5">
				<div class="col-md-12 text-center">
					<a href="#" class="news-see-more-btn btn btn-info"><i class="fas fa-sync"></i> ดูเพิ่มเติม</a>
				</div>
			</div>
		</div>

		
	
