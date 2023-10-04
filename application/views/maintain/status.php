	
	<?php $action = $this->session->userdata('noti_action');?>
	<style>.form-filler{border-top:5px solid #0c364c;padding:20px 15px;background-color:#f8f8f8}.display-hide{display:none;}</style>
	<style>
	.info-box {
    border-bottom-left-radius: 5px;
    border-top-right-radius: 5px;
    min-height: 100px;
    background: #fff;
    width: 100%;
    box-shadow: 0 5px 20px rgba(0, 0, 0, .1);
    -webkit-box-shadow: 0 5px 20px rgba(0, 0, 0, .1);
    margin-bottom: 20px;
    padding: 15px;
	color:#fff;
}
	.bg-b-green {
		background: linear-gradient(45deg,#2ed8b6,#59e0c5);
	}
	.bg-b-yellow {
    background: linear-gradient(45deg,#FFB64D,#ffcb80);
}
.bg-b-pink {
    background: linear-gradient(45deg,#FF5370,#ff869a);
}
.bg-b-blue {
    background: linear-gradient(45deg,#4099ff,#73b4ff);
}
	</style>
	<script src='https://www.google.com/recaptcha/api.js?hl=th'></script>
	<div class="container mb-5">
		<div class="row mt-3">
			<div class="col-12">
				<nav aria-label="breadcrumb">
				  <ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?=base_url('maintain')?>">หน้าหลัก</a></li>
					<li class="breadcrumb-item active" aria-current="page">สถานะจุดติดตั้ง DustBoy</li>
				  </ol>
				</nav>
			</div>
		</div>
		<div class="row mt-3 mb-3">
			<div class="col-md-12">
				<?php 
				
				function DatediffCount($datetime){
					$earlier = new DateTime($datetime);
					$later = new DateTime(date('Y-m-d'));

					$diff = $later->diff($earlier)->format("%a");
					return $diff;
				}
				
				$c_online;
				$c_offline;
				foreach($rsStatus as $item){
					if(DatediffCount($item->status_date)>0){
						$c_offline++;
					}else{
						$c_online++;
					}
				}
				?>
					
				<div class="row">
					<div class="col-md-12 mt-3 ">
						<div class="form-filler">
							<h5 class="mb-3">ภาพรวม</h5><hr/>
							
							<div class="row">
								<div class="col-md-4">
									<div class="info-box bg-b-blue">
										DustBoy Total:
										<h4><?=count($rsStatus)?></h4>
									</div>
								</div>
								<div class="col-md-4">
									<div class="info-box bg-b-green">
										Online now:
										<h4><?=($c_online)?></h4>
									</div>
								</div>
								<div class="col-md-4">
									<div class="info-box bg-b-pink">
										Offline > 1 days:
										<h4><?=($c_offline)?></h4>
									</div>
								</div>
							</div>
							
							
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 mt-3 ">
						<div class="form-filler">
							<h5 class="mb-3">จุดติดตั้งทั้งหมด</h5><hr/>
							
							<form class="form-inline" method="get">

								<div class="form-group mx-sm-3 mb-2">
									<label for="inputPassword2" class="sr-only">กรองข้อมูลจังหวัด</label>
									<select class="form-control" name="province_id">
										<option value=""> เลือกจังหวัด</option>
										<?php foreach($rsProvince as $val){?>
										<option value="<?=$val->province_id?>" <?=$this->input->get('province_id')==$val->province_id?'selected':''?>><?=$val->province_name?></option>
										<?php }?>
									</select>
								</div>
								<button type="submit" id="btn-filter" class="btn btn-primary mb-2">กรองข้อมูล</button>
							</form>

							
							<table id="tblDB">
								<thead>
									<tr>
										<th>Webid</th>
										<th>Alias</th>
										<th>DustBoyName</th>
										<th>PM25</th>
										<th>Update(Days)</th>
										<th>Check</th>
										<th>CoName</th>
										<th>CoMobile</th>
										<th>Note</th>
									</tr>
								</thead>
								<tbody>
								<?php foreach($rsStatus as $item){?>
									<tr>
										<td class="text-center"><?=$item->status_source_id?></td>
										<td class="text-center"><?=$item->status_source_ids?></td>
										<td><?=$item->status_source_name?></td>
										<td class="text-center"><?=$item->status_pm25?></td>
										<td class="text-center"><?=$item->status_date=='0000-00-00 00:00:00'? '999':DatediffCount($item->status_date)?></td>
										<td class="text-center"><?=$item->status_update?></td>
										<td class="text-center"><?=$item->status_co_name?></td>
										<td class="text-center"><?=$item->status_co_mobile?></td>
										<td class="text-center"><?=$item->status_addr?></td>
									</tr>
								<?php }?>
								</tbody>
							</table>
							
							
						</div>
						<p class="text-center mt-3">
							<a href="<?=base_url('maintain/dustboy_status_export')?>" class="btn btn-success"> Export Excel</a>
						</p>
					</div>
				</div>
				
				
			</div>
		</div>
	</div>
	
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
	<script>
		$( document ).ready(function() {
			
			
			$('#tblDB').DataTable({
				"lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
				"columnDefs": [{ "type": "num", "targets": 3 }]
			});
		});
	</script>
	