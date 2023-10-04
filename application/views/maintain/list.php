	
	<?php $action = $this->session->userdata('noti_action');?>
	<style>.form-filler{border-top:5px solid #0c364c;padding:20px 15px;background-color:#f8f8f8}.display-hide{display:none;}</style>
	<script src='https://www.google.com/recaptcha/api.js?hl=th'></script>
	<div class="container mb-5">
		<div class="row mt-3">
			<div class="col-12">
				<nav aria-label="breadcrumb">
				  <ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?=base_url('maintain')?>">หน้าหลัก</a></li>
					<li class="breadcrumb-item active" aria-current="page">เครือข่ายอาสา DustBoy</li>
				  </ol>
				</nav>
			</div>
		</div>
		<div class="row mt-3 mb-3">
			<div class="col-md-12">
			
				<!--
				<div class="form-filler mb-3">
					<form class="login-form" method="get">
						<div class="form-group row">
							<label for="dustboy_id" class="col-sm-2 col-form-label">กรองข้อมูล</label>
							<div class="col-sm-4">
								<select class="form-control" name="filter_region" id="filter_region">
									<option value=""> ทุกภูมิภาค </option>
									<?php //foreach($rsRegion as $region){?>
									<option  value="<?=$region['zone_id']?>"> <?=$region['zone_name_th']?> </option>
									<?php // }?>
								</select>
							</div>
							<div class="col-sm-4">
								<select class="form-control" name="filter_pv" id="filter_pv">
									<option value=""> ทุกจังหวัด </option>
								</select>
							</div>
							<div class="col-sm-2">
								<button type="button" id="btn-filter" class="btn btn-info btn-block">ดึงข้อมูล</button>
							</div>
						</div>
					</form>
				</div>
				-->
				
					
				<div class="row">
					<div class="col-md-12 mt-3 ">
						<div class="form-filler">
							<h5 class="mb-3">จุดติดตั้งทั้งหมด</h5><hr/>
							
							<div class="loader">
								<p class="text-center"><img src="<?=base_url('template/image/loader.gif')?>"> loading..</p>
							</div>
							
							<div id="tbl" style="display:none;">
								
							</div>
							
						</div>
					</div>
				</div>
						
			
			</div>
		</div>
	</div>
	
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
	<script>
		$( document ).ready(function() {
			
			var tbl_header = '<table id="tblDB"><thead><tr><th>ไอดี</th><th>ชื่อจุดติดตั้ง</th><th>รหัสเครื่อง</th><th>ผู้ประสานงาน</th><th>โทรศัพท์</th><th>อีเมล์</th><th></th></tr></thead><tbody>';
			
			var tbl_footer = '</tobdy></table>';
			
			
			loadData()
			
			function loadData(){
				var call = '<?=base_url()?>maintain/station_json';
				$.getJSON( call, function( data ) {
					if(data){
						var tbl_body = '';
						for (let index = 0; index < data.length; ++index) {
							var station = data[index];
							
							tbl_body += '<tr>';
							tbl_body += '<td>'+station.dustboy_id+'</td>';
							tbl_body += '<td>'+station.dustboy_name_th+'</td>';
							tbl_body += '<td>'+station.dustboy_alias+'</td>';
							tbl_body += '<td>'+station.db_co+'</td>';
							tbl_body += '<td>'+station.db_mobile+'</td>';
							tbl_body += '<td>'+station.db_email+'</td>';
							tbl_body += '<td><div class="btn-group"> <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-cog"></i> แจ้งอัพเดทข้อมูล</button><div class="dropdown-menu"> <a class="dropdown-item" href="/maintain/coordinator?dustboy_id='+station.dustboy_id+'"><i class="fas fa-user-cog"></i> ข้อมูลผู้ประสาน</a> <a class="dropdown-item" href="/maintain/fixed?dustboy_id='+station.dustboy_id+'"><i class="fas fa-tools"></i> เครื่องเสีย</a> <a class="dropdown-item" href="/maintain/location?dustboy_id='+station.dustboy_id+'"><i class="fas fa-street-view"></i> ย้ายจุดติดตั้ง</a></div></div></td>';
							tbl_body += '</tr>';
							
						}
						
						
						
											
						$('#tbl').html(tbl_header+tbl_body+tbl_footer);
						
						$('#tblDB').DataTable({
							"lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]]
						});
						
						$('.loader').hide();
						$('#tbl').show();
			
					}
				});
				
			}

			$('#filter_region').on('change',function(){
				var call = '<?=base_url()?>maintain/region_pwa';
				var region_check = $('#filter_region').val();
				$.getJSON( call, function( data ) {
					if(region_check){
						for (let i = 0; i < data.length; ++i) {
							if(region_check == data[i].zone_id){
								var provinces = data[i].provinces;
								var html = '<option value="">ทุกจังหวัด</option>';
								for (let index = 0; index < provinces.length; ++index) {
									console.log(provinces[index].province_name_th);
									html += '<option value="'+provinces[index].province_id+'">'+provinces[index].province_name_th+'</option>';
								}
								$('#filter_pv').html(html)
							}
						}
					}
				});
			});
		});
	</script>
	