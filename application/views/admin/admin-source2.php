
<div class="page-content-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-md-12">
				<h3 class="page-title"><?=$pagename?></h3>
				<a href="<?=base_url()?>admin/source/add" class="btn btn-info"><i class="fa fa-plus"></i> เพิ่มจุดตรวจวัดใหม่</a>
			</div>
		</div>
		<hr/>
		<div class="row">
			<div class="col-md-12">

				<div class="table-responsive">
					<table class="table" id="sample_2">
						<thead>
							<tr style="font-weight: 500;background-color: #333;color:#fff;">
								<th>WebID</th>
								<th>ALIAS</th>
								<th>Name</th>
								<th>Url</th>
								
								<th>Status</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php $i=0;foreach ($rsList as $value) {$i++;?>  

						<tr>
							<td><?=$value->source_id?></td>
							<td><?=$value->location_id?></td>
							<td><?=$value->location_name?></td>
							<td><a href="<?=base_url($value->location_uri)?>" target="_blank"><?=$value->location_uri?></a></td>
							
							<td><?=$value->location_status==1?'<span class="btn btn-success btn-xs">Show</span>':'<span class="btn btn-default btn-xs">Hide</span>'?></td>
								
							<td>
								<a href="<?=base_url()?>admin/source/edit/<?=$value->source_id?>" class="btn btn-info btn-xs">
									<i class="fa fa-edit"></i>	
									แก้ไข
								</a>
							</td>
						</tr>
						<?php }?>
						</tbody>
					</table>
				</div>
				
				
				<div class="alert alert-info">
					<p>หลังจากที่จัดการจุดติดตั้งทุกครั้งให้ สร้างข้อมูลโดยการคลิก url ด้านล่างนี่</p>
					<p><a href="https://www-old.cmuccdc.org/assets/api/haze/pwa/genAllStation.php" target="_blank">https://www-old.cmuccdc.org/assets/api/haze/pwa/genAllStation.php</a></p>
					<p><a href="https://www-old.cmuccdc.org/assets/api/haze/pwa/genAllStation2.php" target="_blank">https://www-old.cmuccdc.org/assets/api/haze/pwa/genAllStation2.php</a></p>
					<p><a href="https://www-old.cmuccdc.org/assets/api/haze/pwa/genRegion.php" target="_blank">https://www-old.cmuccdc.org/assets/api/haze/pwa/genRegion.php</a></p>
					
					<p>หลังจากนั้นสามารถตรวจสอบข้อมูลได้<a href="https://www-old.cmuccdc.org//assets/api/haze/pwa/json/allstation.json" target="_blank"> ที่นี่</a></p>
				</div>
			</div>
		</div>
	</div>
</div>


