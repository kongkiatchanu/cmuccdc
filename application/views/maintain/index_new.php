	<style>.form-filler{border-top:5px solid #0c364c;padding:20px 15px;background-color:#f8f8f8}.display-hide{display:none;}</style>
	
	<div class="container mb-5">
		<div class="row mt-3 mb-3 pt-5 pb-5" style="background: white url(/template/img/bg.jpg) no-repeat bottom;">
			<div class="col-md-6"></div>
			<div class="col-md-6">
				<div class="form-filler mb-3">
					<form class="" method="get" action="/maintain/search">
						<div class="form-group row">
							<label for="text-search" class="col-sm-2 col-form-label">Tracking</label>
							
							<div class="col-sm-8">
							  <input type="text" class="form-control mb-3" id="text-search" name="text-search" placeholder="ระบุจุดติดตั้ง หรือ ชื่อผู้ประสานงาน" value="<?=@$this->input->get('text-search')?>">
							</div>
							<div class="col-sm-2">
								<input type="hidden" name="search-key" value="<?=md5(date('YmdHis'))?>">
								<button type="submit" class="btn btn-primary mb-2">ค้นหา..</button>
							</div>
						</div>

					</form>
				</div>
				
				<div class="row mb-1"><div class="col-12"><a href="<?=base_url('maintain/lists')?>" class="btn btn-info btn-block">เครือข่ายอาสา DustBoy</a></div></div>
				<div class="row mb-1"><div class="col-12"><a href="<?=base_url('maintain/setup')?>" class="btn btn-info btn-block">แจ้งติดตั้งเครื่อง</a></div></div>
				<div class="row mb-1"><div class="col-12"><a href="<?=base_url('maintain/coordinator')?>" class="btn btn-info btn-block">แจ้งแก้ไขข้อมูลผู้ประสานงาน</a></div></div>
				<div class="row mb-1"><div class="col-12"><a href="<?=base_url('maintain/fixed')?>" class="btn btn-info btn-block">แจ้งเครื่องเสีย</a></div></div>
				<div class="row mb-1"><div class="col-12"><a href="<?=base_url('maintain/location')?>" class="btn btn-info btn-block">แจ้งย้ายจุดติดตั้ง</a></div></div>
				<div class="row mb-1"><div class="col-12"><a href="<?=base_url('maintain/register')?>" class="btn btn-info btn-block">ขอความอนุเคราะห์เครื่อง</a></div></div>
				<div class="row mb-1"><div class="col-12"><a href="<?=base_url('maintain/renew')?>" class="btn btn-info btn-block">แจ้งต่ออายุ NB</a></div></div>

			</div>
		</div>
	</div>
	