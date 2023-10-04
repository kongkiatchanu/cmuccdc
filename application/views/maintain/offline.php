	
	<?php $action = $this->session->userdata('noti_action');?>
	<style>.form-filler{border-top:5px solid #0c364c;padding:20px 15px;background-color:#f8f8f8}.display-hide{display:none;}</style>
	<script src='https://www.google.com/recaptcha/api.js?hl=th'></script>
	<div class="container mb-5">
		<div class="row mt-3">
			<div class="col-12">
				<nav aria-label="breadcrumb">
				  <ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?=base_url('maintain')?>">หน้าหลัก</a></li>
					<li class="breadcrumb-item active" aria-current="page">จุดติดตั้งที่ไม่มีข้อมูล</li>
				  </ol>
				</nav>
			</div>
		</div>
		<div class="row mt-3 mb-3">
			<div class="col-md-12">
				
					
				<div class="row">
					<div class="col-md-12 mt-3 ">
						<div class="form-filler">
							<h5 class="mb-3">จุดติดตั้งทั้งหมด</h5><hr/>
		
							<table id="tblDB">
								<thead>
									<tr>
										<th>Webid</th>
										<th>DustBoyID</th>
										<th>DustBoyName</th>
									</tr>
								</thead>
								<tbody>
								<?php foreach($offline as $item){?>
									<tr>
										<td><?=$item->source_id?></td>
										<td><?=$item->location_id?></td>
										<td><?=$item->location_name?></td>
									</tr>
								<?php }?>
								</tbody>
							</table>
							
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
			
			$('#tblDB').DataTable({
				"lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]]
			});
		});
	</script>
	