<div class="row mb-3 mt-3">
	<div class="col-12">
		<div class="form-filler">
			<form class="" method="get" action="/maintain/search">
				<div class="form-group row">
					<label for="text-search" class="col-sm-2 col-form-label">ระบุจุดติดตั้ง</label>
					
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="text-search" name="text-search" placeholder="ระบุจุดติดตั้ง หรือ ชื่อผู้ประสานงาน" value="<?=@$this->input->get('text-search')?>">
					</div>
					<div class="col-sm-2">
						<input type="hidden" name="search-key" value="<?=md5(date('YmdHis'))?>">
						<button type="submit" class="btn btn-primary mb-2">ค้นหา..</button>
					</div>
				</div>

			</form>
		</div>
	</div>
</div>